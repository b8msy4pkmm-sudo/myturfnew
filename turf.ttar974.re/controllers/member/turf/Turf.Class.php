<?php
namespace MAIN_NAMESPACE\controllers\member\turf;
use DateTime;
use MAIN_NAMESPACE\utilities\page\Page;
use MAIN_NAMESPACE\models\sqlReq\SqlModel;
use MAIN_NAMESPACE\utilities\toolbox\Toolbox;
use MAIN_NAMESPACE\utilities\security\Security;
require_once("./models/reqsql/SqlReq.Class.php");
require_once("./controllers/utilities/page/Main.Page.Class.php");
require_once("./controllers/utilities/security/Security.Class.php");

class TurfController extends Page{
    private $horseRacing;

    public function __construct() {
        $this->horseRacing = new SqlModel();
    }

    public function getHippodromeName($indexHippodrome){
        $nameHippodromeOfDay=$this->horseRacing->getOneRowDatasFromTable('courses_hippodrome',['index_hippodrome'=>$indexHippodrome]);
        return $nameHippodromeOfDay['hippodrome'];
    }

    public function accessPageRaceHorseByTipsters()
    {
        $orderBy=['pronostiqueur','ASC'];
        $tipsters=$this->horseRacing->getFewRowsDatasFromTable('courses_pronostiqueurs',['archive_pronostiqueur'=>0],$orderBy);
        $raceOfDay=$this->horseRacing->getOneRowDatasFromTable('courses_arrivee',['date_course'=>($_SESSION['horseRacing']['page']==="simulRaceFinish")?$_SESSION['horseRacingsDate']['dateNow']->format('Y-m-d'):$_SESSION['horseRacingsDate']['date']->format('Y-m-d')]);
        
        if($raceOfDay){
            $datasCondition=
            [
                'index_course'=>$raceOfDay['index_course']??''            
            ];
            $nameHippodromeOfDay=$this->horseRacing->getOneRowDatasFromTable('courses_hippodrome',['index_hippodrome'=>$raceOfDay['index_hippodrome']]);
            $horseRacingWinnings=$this->horseRacing->getOneRowDatasFromTable('course_gains',$datasCondition);
            $tipstersOfDay=$this->getTipstersOfDay($datasCondition,[]);
            if($tipstersOfDay){
                $_SESSION['tipsterOfDayExist']=true;
            }
            /* A mettre en commentaire une fois la duplication du champ index_pronotiqueur */
        }else
        {
            Toolbox::addMessageAlert("Course du jour inexistante !",Toolbox::COLOR_WARNING);
        };
        $this->updateRaceOfDay($raceOfDay);
        $this->updateRaceWinningsOfDay($horseRacingWinnings??[]);

        $filesCSS=[...parent::MAIN_CSS,'_card.css','_turfOfDay.css'];
        $filesJavaScript=[...parent::MAIN_JS,'_turfOfDay.js'];
        $data_page=[
            "page_description"    => "Acces au compte Membre",
            "page_title"          => "Profil du membre",
            "files_css"           => $filesCSS,
            "files_js"            => $filesJavaScript,
            "userDatas"           => $_SESSION['profil'],
            "page_url"            => URL, 
            "tipsters"            => $tipsters??[],
            "raceOfDay"           => $raceOfDay??[],
            "raceOfDaySimul"      => $_SESSION['horseRacing']['simulRace']??[],
            "nameHippodromeOfDay" => $nameHippodromeOfDay??[],
            "racingWinnings"      => $horseRacingWinnings??[],
            "tipstersOfDay"       => $tipstersOfDay??[],  
            "viewContent"         => "./views/member/horseRacing/_horseRacingOfDay_tipsters.php",
            "template"            => "./views/common/indexTemplate.php"
        ];
        $this->generatePage($data_page); 
    }

    public function accessPageRaceHorseResults()
    {
        $tipsters=$this->horseRacing->getFewRowsDatasFromTable('courses_pronostiqueurs',['archive_pronostiqueur'=>0],['pronostiqueur','ASC']);
        $allHippodromes=$this->horseRacing->getFewRowsDatasFromTable('courses_hippodrome',[],['hippodrome','ASC']);
        $raceOfDay=$this->horseRacing->getOneRowDatasFromTable('courses_arrivee',['date_course'=>$_SESSION['horseRacingsDate']['date']->format('Y-m-d')]);
        if($raceOfDay)
        {
            $datasCondition=[
                'index_course'=>$raceOfDay['index_course']??''
            ];
            $nameHippodromeOfDay=$this->horseRacing->getOneRowDatasFromTable('courses_hippodrome',['index_hippodrome'=>$raceOfDay['index_hippodrome']]);
            $horseRacingWinnings=$this->horseRacing->getOneRowDatasFromTable('course_gains',$datasCondition);
            if($_SESSION['horseRacing']['page']==="raceTipster")
            {
                $tipsterOfDay=$this->getTipstersOfDay($datasCondition,['index_tipster'=>$_SESSION['tipsterSelected']??"P1"]);
                $_SESSION['forecastOfTipsterSelected']=$tipsterOfDay[0]??[];
                $missingForecasts=[];
                $missingForecasts=$this->missingTipsters($tipsters,$datasCondition);
            }
            else{
                $_SESSION['forecastOfTipsterSelected']=[];
            }

        }
        else
        {
            Toolbox::addMessageAlert("Course du jour inexistante !",Toolbox::COLOR_DANGER);
            // $_SESSION['forecastOfTipsterSelected']=[];
        }
        $this->updateRaceOfDay($raceOfDay);
        $this->updateRaceWinningsOfDay($horseRacingWinnings??[]);
        $filesCSS=[...parent::MAIN_CSS,'_card.css','_turfOfDay.css'];
        $filesJavaScript=[...parent::MAIN_JS,'_turfOfDay.js'];
        $data_page=[
            "page_description"    => "Acces au compte Membre",
            "page_title"          => "Profil du membre",
            "files_css"           => $filesCSS,
            "files_js"            => $filesJavaScript,
            "userDatas"           => $_SESSION['profil'],
            "page_url"            => URL, 
            "tipsters"            => $tipsters??[],
            "raceOfDay"           => $raceOfDay??[],
            "nameHippodromeOfDay" => $nameHippodromeOfDay??[],

            "racingWinnings"      => $horseRacingWinnings??[],
            "allHippodromes"      => $allHippodromes??[],
            "missingForecasts"    => $missingForecasts??[],
            "viewContent"         => "./views/member/horseRacing/_horseRacingOfDay_results.php",
            "template"            => "./views/common/indexTemplate.php"
        ];
        $this->generatePage($data_page); 
    }

    public function accessPageRacingStats()
    {
        if(!isset($_SESSION['allTipsters']))$_SESSION['allTipsters']=$this->horseRacing->getFewRowsDatasFromTable('courses_pronostiqueurs',['archive_pronostiqueur'=>0],['pronostiqueur','ASC']);
        if(!isset($_SESSION['allHippodromes']))$_SESSION['allHippodromes']=$this->horseRacing->getFewRowsDatasFromTable('courses_hippodrome',[],['hippodrome','ASC']);
        if(!isset($_SESSION['dateEndChange']))
            {
                $_SESSION['dateEndChange']=$this->horseRacing->getOneRowDatasFromTable('courses_arrivee',['date_course'=>$_SESSION['horseRacingsDate']['dateEnd']->format('Y-m-d')]);
                if($_SESSION['dateEndChange']==false)$_SESSION['dateEndChange']['index_course']=(new DateTime())->format('Y-m-d');
            }
        $oneTipster=false;
        if(isset($_SESSION['resultsOfFilters']) && count($_SESSION['resultsOfFilters'])>0)
        {
            $conditions=$this->getConditionsCommonOfFilter();
            $totalQuinte = count($this->horseRacing->getFewRowsDatasFromTable('courses_arrivee',$conditions,[]));
            $nbGame=[];
            $cumulAmount=[];
            $gapMaxGame=[];
            $currentGapGame=[];
            $finalResults=[];
            if($_SESSION['racingStats']['page']=="simplesGames")
            {
                for ($i=1; $i < 9 ; $i++) 
                { 
                    $nbGame+=['ch'.$i=>0];
                    $cumulAmount+=['ch'.$i=>0];
                    $gapMaxGame+=['ch'.$i=>0];
                    $currentGapGame+=['ch'.$i=>0];
                }
            }
            if($_SESSION['racingStats']['page']=="couplesGames")
            {
                for ($i=1; $i < 9; $i++) 
                { 
                    for ($j=$i+1; $j < 9; $j++) 
                    { 
                        $nbGame+=['ch'.$i.'-ch'.$j=>0];
                        $cumulAmount+=['ch'.$i.'-ch'.$j=>0];
                        $gapMaxGame+=['ch'.$i.'-ch'.$j=>0];
                        $currentGapGame+=['ch'.$i.'-ch'.$j=>0];
                    }
                }
            }
            $countTipster=0;
            $raceType=[];
            for ($i=0; $i < count($_SESSION['racingStats']['raceType']); $i++) { 
                array_push($raceType,$_SESSION['racingStats']['raceType'][$i]);
            }
            if(!in_array($_SESSION['dateEndChange']['type_course'],$raceType)){
                Toolbox::addMessageAlert('Incohérence dans votre choix, recommencer !',Toolbox::COLOR_DANGER);
                Toolbox::addMessageAlert("Au ".(new \DateTime($_SESSION['dateEndChange']['date_course']))->format('d/m/Y').", c'est une course de ".$_SESSION['dateEndChange']['type_course'].". Cocher la case !" ,Toolbox::COLOR_WARNING);
            }
            else
            {
                if (count($_SESSION['racingStats']['tipster'])==1)
                {
                    $oneTipster=true;
                }
                foreach ($_SESSION['allTipsters'] as $tipster)
                {
                    if(in_array($tipster['index_pronostiqueur'],$_SESSION['racingStats']['tipster']))
                    {
                        //ici on récupère le pronostique du jour de chaque pronostiqueur
                        $conditions=[
                            'index_course'=>$_SESSION['dateEndChange']['index_course'],
                            'index_tipster'=>$tipster['index_pronostiqueur']
                        ];
                        $tipsOfDay = $this->horseRacing->getOneRowDatasFromTable('courses_pronostics',$conditions);
                        foreach ($_SESSION['resultsOfFilters'] as $filterByTipster) 
                        {
                            if($filterByTipster['index_tipster']==$tipster['index_pronostiqueur'])
                            {
                                $ch="";
                                $condition="";
                                if($_SESSION['racingStats']['page']=="simplesGames")
                                {
                                    for ($i=1 ; $i<9 ; $i++)
                                    {
                                        $ch="ch".$i;
                                        switch ($_SESSION['racingStats']['gameType'])
                                        {
                                            case "sg":
                                                $condition=$filterByTipster[$ch]===$filterByTipster['arrivee_ch1'];
    
                                            break;
                                            case "zs":
                                                $condition=$filterByTipster[$ch]===$filterByTipster['arrivee_ch2'];
                                            break;
                                            case "zc":
                                                $condition=$filterByTipster[$ch]===$filterByTipster['arrivee_ch4'];
                                            break;
                                            case "sp":
                                                $condition=($filterByTipster[$ch]===$filterByTipster['arrivee_ch1']||$filterByTipster[$ch]===$filterByTipster['arrivee_ch2']||$filterByTipster[$ch]===$filterByTipster['arrivee_ch3']);
                                            break;
                                        }
                                        if($condition)
                                        {
                                            $nbGame[$ch]++;
                                            $currentGapGame[$ch]=0;
                                            if($_SESSION['racingStats']['gameType']!="sp")
                                            {
                                                $cumulAmount[$ch]=$cumulAmount[$ch]+$filterByTipster[$_SESSION['racingStats']['gameType']];  
                                            }
                                            else
                                            {
                                                if($filterByTipster[$ch]===$filterByTipster['arrivee_ch1']) $cumulAmount[$ch]=$cumulAmount[$ch]+$filterByTipster['sp1'];
                                                if($filterByTipster[$ch]===$filterByTipster['arrivee_ch2']) $cumulAmount[$ch]=$cumulAmount[$ch]+$filterByTipster['sp2'];
                                                if($filterByTipster[$ch]===$filterByTipster['arrivee_ch3']) $cumulAmount[$ch]=$cumulAmount[$ch]+$filterByTipster['sp3'];
                                            }
                                        }
                                        else if($filterByTipster['arrivee_ch1']!=0)
                                        {
                                            $currentGapGame[$ch]++;
                                            if($currentGapGame[$ch]>$gapMaxGame[$ch])
                                            {
                                                $gapMaxGame[$ch]=$currentGapGame[$ch];
                                            }
                                        }
                                    }
                                }
                                if($_SESSION['racingStats']['page']=="couplesGames")
                                {
                                    for ($i=1; $i < 9; $i++) 
                                    { 
                                        $chA='ch'.$i;
                                        for ($j=$i+1; $j < 9; $j++) 
                                        { 
                                            if($filterByTipster['ch1']>0 && $filterByTipster['arrivee_ch1'] >0)
                                            {
                                                $chB='ch'.$j;
    
                                                switch ($_SESSION['racingStats']['gameType']) 
                                                {
                                                    case "jg" : // couplé gagnant
                                                    case "jgo": // couplé gagnant tous les ordres
                                                        
                                                        if (($filterByTipster[$chA] === $filterByTipster['arrivee_ch1'] || $filterByTipster[$chA] === $filterByTipster['arrivee_ch2'])
                                                        && ($filterByTipster[$chB] === $filterByTipster['arrivee_ch1'] || $filterByTipster[$chB] === $filterByTipster['arrivee_ch2']))
                                                        {
                                                            
                                                            $nbGame[$chA.'-'.$chB]++;
                                                            $currentGapGame[$chA.'-'.$chB]=0;
                                                            $cumulAmount[$chA.'-'.$chB]=$cumulAmount[$chA.'-'.$chB]+($filterByTipster[$_SESSION['racingStats']['gameType']]);
                                                        }
                                                        else
                                                        {
                                                            $currentGapGame[$chA.'-'.$chB]++;
                                                            if($currentGapGame[$chA.'-'.$chB]>$gapMaxGame[$chA.'-'.$chB])
                                                            {
                                                                $gapMaxGame[$chA.'-'.$chB]=$currentGapGame[$chA.'-'.$chB];
                                                            }
                                                        }
                                                    break;
                                                    case "ze24":
                                                    // 2 sur 4
                                                    $couple2Sur4=[$filterByTipster['arrivee_ch1'],$filterByTipster['arrivee_ch2'],$filterByTipster['arrivee_ch3'],$filterByTipster['arrivee_ch4']];
                                                    if (in_array($filterByTipster[$chA],$couple2Sur4) && in_array($filterByTipster[$chB],$couple2Sur4))
                                                    {
                                                        $nbGame[$chA.'-'.$chB]++;
                                                        $currentGapGame[$chA.'-'.$chB]=0;
                                                        $cumulAmount[$chA.'-'.$chB]=$cumulAmount[$chA.'-'.$chB]+$filterByTipster[$_SESSION['racingStats']['gameType']];
                                                    }
                                                    else
                                                    {
                                                        $currentGapGame[$chA.'-'.$chB]++;
                                                        if($currentGapGame[$chA.'-'.$chB]>$gapMaxGame[$chA.'-'.$chB])
                                                        {
                                                            $gapMaxGame[$chA.'-'.$chB]=$currentGapGame[$chA.'-'.$chB];
                                                        }
                                                    }
                                                break;
                                                    
                                                }
    
                                            }
                                        }
                                    }
                                }
                                $countTipster++;
                            }
                        }
                        $resultsbyTipster=[
                            'tipster'     => $tipster['pronostiqueur'],
                            'tipsOfDay'   => $tipsOfDay??[],
                            /
                            'nbRaces'     => $countTipster,
                            'nbGame'      => $nbGame,
                            'cumulAmount' => $cumulAmount,
                            'maxGap'      => $gapMaxGame,
                            'currentGap'  => $currentGapGame
                            ];
                        array_push($finalResults,$resultsbyTipster);
                    }
                    /* RINITIALISATION DES VARIABLES */    
                    $countTipster=0;
                    $nbGame=[];
                    $cumulAmount=[];
                    $gapMaxGame=[];
                    $currentGapGame=[];
                    if($_SESSION['racingStats']['page']=="simplesGames")
                    {
                        for ($i=1; $i < 9 ; $i++) 
                        { 
                            $nbGame+=['ch'.$i=>0];
                            $cumulAmount+=['ch'.$i=>0];
                            $gapMaxGame+=['ch'.$i=>0];
                            $currentGapGame+=['ch'.$i=>0];
                        }
                    }
                    if($_SESSION['racingStats']['page']=="couplesGames")
                    {
                        for ($i=1; $i < 9; $i++) 
                        { 
                            for ($j=$i+1; $j < 9; $j++) 
                            { 
                                $nbGame+=['ch'.$i.'-ch'.$j=>0];
                                $cumulAmount+=['ch'.$i.'-ch'.$j=>0];
                                $gapMaxGame+=['ch'.$i.'-ch'.$j=>0];
                                $currentGapGame+=['ch'.$i.'-ch'.$j=>0];
                            }
                        }
                    } 
                }
            }
        }
        if(count($_SESSION['racingStats'])==2)Toolbox::addMessageAlert("Enregistrer vos choix pour commencer ! ",Toolbox::COLOR_WARNING);                                
        $filesCSS=[...parent::MAIN_CSS,'_turfOfDay.css','_card.css','_game.css','_viewStats.css'];
        $filesJavaScript=[...parent::MAIN_JS,'_filter.js'];
        $data_page=[
            "page_description" => "Acces au compte Membre",
            "page_title"       => "Profil du membre",
            "files_css"        => $filesCSS,
            "files_js"         => $filesJavaScript,
            "userDatas"        => $_SESSION['profil'],
            "page_url"         => URL, 
            "allHippodromes"   => $_SESSION['allHippodromes'],
            "allTipsters"      => $_SESSION['allTipsters'],
            "totalRaceQuinte"  => $totalQuinte??0,
            "finalResults"     => $finalResults??[],
            "oneTipster"       => $oneTipster,
            "viewContent"      => "./views/member/horseRacingsStats/_racingStats_filter.php",
            "template"         => "./views/common/indexTemplate.php"
        ];
        $this->generatePage($data_page); 
    }

    public function updateRacingInfos( string $table,array $datasToUpdate,array $datasConditions)
    {

        if($this->horseRacing->updateDatasInDataTable($table, $datasToUpdate, $datasConditions))
        {
            Toolbox::addMessageAlert("Modification réussie !", Toolbox::COLOR_SUCCESS);
        }
        else
        {
            Toolbox::addMessageAlert("Aucune modification effectuée !", Toolbox::COLOR_WARNING);
        }
    }

    public function insertRacingInfos( string $table,array $datasToInsert)
    {
        if($this->horseRacing->insertOneRowInDataTable($table, $datasToInsert))
        {
            Toolbox::addMessageAlert("Ajout réussi !", Toolbox::COLOR_SUCCESS);
        }
        else
        {
            Toolbox::addMessageAlert("Echec !", Toolbox::COLOR_WARNING);
        }
    }

    public function checkFilters(array $post):bool
    {
        $checkOK=true;
        if(empty($post['hippodrome'])){
            Toolbox::addMessageAlert("veuillez sélectionner au moins 1 hippodrome !",Toolbox::COLOR_DANGER);
            $_SESSION['racingStats']['hippodrome']=[];
            $checkOK=false;
        }else{
            $_SESSION['racingStats']['hippodrome']=$post['hippodrome'];
        }
        if(empty($post['tipster'])){
            Toolbox::addMessageAlert("veuillez sélectionner au moins 1 pronostiqueur !",Toolbox::COLOR_DANGER);
            $_SESSION['racingStats']['tipster']=[];
            $checkOK=false;
        }
        else{
            $_SESSION['racingStats']['tipster']=$post['tipster'];
        }
        if(empty($post['raceType'])){
            Toolbox::addMessageAlert("veuillez sélectionner au moins 1 type de course !",Toolbox::COLOR_DANGER);
            $_SESSION['racingStats']['raceType']=[];
            $checkOK=false;
        }else{
            $_SESSION['racingStats']['raceType']=$post['raceType'];
        }
        if(empty($post['min_length']) && empty($post['max_length']))
        {
            $_SESSION['racingStats']['min_length']="";
            $_SESSION['racingStats']['max_length']="";
            $_SESSION['racingStats']['trackLength']=[];
        }else if (!empty($post['min_length']) && empty($post['max_length'])){
            $_SESSION['racingStats']['min_length']=(int)Security::secureHTML($post['min_length']);
            $_SESSION['racingStats']['trackLength']=[">=",$_SESSION['racingStats']['min_length']];
        }else if (empty($post['min_length']) && !empty($post['max_length'])){
            $_SESSION['racingStats']['max_length']=(int)Security::secureHTML($post['max_length']);
            $_SESSION['racingStats']['trackLength']=["<=",$_SESSION['racingStats']['max_length']];
        }else{
            $_SESSION['racingStats']['min_length']=(int)Security::secureHTML($post['min_length']);
            $_SESSION['racingStats']['max_length']=(int)Security::secureHTML($post['max_length']);
            $_SESSION['racingStats']['trackLength']=["><",$_SESSION['racingStats']['min_length'],$_SESSION['racingStats']['max_length']];
        }
        return $checkOK;
    }

    public function initialiseGame()
    {
        $page=$_SESSION['racingStats']['page'];
        $gameType=$_SESSION['racingStats']['gameType'];
        unset($_SESSION['racingStats']);
        $_SESSION['racingStats']=[
            'page'=>$page,
            'gameType'=>$gameType
        ];
    }

    public function resetFilter()
    {   
        $indexHippodromesList=[];
        $indexTipstersList=[];
        $allHippodromes=$this->horseRacing->getFewRowsDatasFromTable('courses_hippodrome',[],['hippodrome','ASC']);
        
        foreach ($allHippodromes as $hippodrome) {
            array_push($indexHippodromesList,$hippodrome['index_hippodrome']);
        }

        $allTipsters=$this->horseRacing->getFewRowsDatasFromTable('courses_pronostiqueurs',[],['pronostiqueur','ASC']);
        foreach ($allTipsters as $tipster) {
            array_push($indexTipstersList,$tipster['index_pronostiqueur']);
        }
        $_SESSION['racingStats']['hippodrome']  = $indexHippodromesList;                       
        $_SESSION['racingStats']['tipster']     = $indexTipstersList;                       
        $_SESSION['racingStats']['min_length']  = 0;
        $_SESSION['racingStats']['max_length']  = 0;
        $_SESSION['racingStats']['trackLength'] = [];
        $_SESSION['racingStats']['raceType']    = RACE_TYPE;

    }
    public function getResultsWithOfFilters() :array
    {
        $conditions=$this->getConditionsCommonOfFilter();
        $tipster = $_SESSION['racingStats']['tipster'];
        array_unshift($tipster,"=");
        $conditions+=['index_tipster'=>$tipster];
        $orderBy=['date_course','ASC'];
        $elementOfTable_1=[
            'nameOfTable'  => 'courses_pronostics',
            'keyForJoin'   => 'index_course',
            'columnHeader' => ['index_course','index_tipster','ch1','ch2','ch3','ch4','ch5','ch6','ch7','ch8']
        ];
        $elementOfTable_2=[
            'nameOfTable'  => 'courses_arrivee',
            'keyForJoin'   => 'index_course',
            'columnHeader' => ['date_course','type_course','distance_course','index_hippodrome','arrivee_ch1','arrivee_ch2','arrivee_ch3','arrivee_ch4','arrivee_ch5']
        ];
        return $this->horseRacing->getWithJoinDatasFrom2Tables($elementOfTable_1,$elementOfTable_2, $conditions, $orderBy);
    }

    public function getAllResultsAndWinningsOfFilters(string $order="ASC") :array
    {
        $conditions=$this->getConditionsCommonOfFilter();
        $tipster = $_SESSION['racingStats']['tipster'];
        array_unshift($tipster,"=");
        $conditions+=['index_tipster'=>$tipster];
        $orderBy=['date_course',$order];

        $elementOfTable_1=[
            'nameOfTable'  => 'courses_pronostics',
            'keyForJoin'   => 'index_course',
            'columnHeader' => ['index_course','index_tipster','ch1','ch2','ch3','ch4','ch5','ch6','ch7','ch8']
        ];
        $elementOfTable_2=[
            'nameOfTable'  => 'courses_arrivee',
            'keyForJoin'   => 'index_course',
            'columnHeader' => ['date_course','type_course','distance_course','index_hippodrome','arrivee_ch1','arrivee_ch2','arrivee_ch3','arrivee_ch4','arrivee_ch5']
        ];
        $elementOfTable_3=[
            'nameOfTable'  => 'course_gains',
            'keyForJoin'   => 'index_course',
            'columnHeader' => ['sg','sp1','sp2','sp3','zs','zc','ze24','jg','jgo']
        ];

        return $this->horseRacing->getWithJoinDatasFrom3Tables($elementOfTable_1,$elementOfTable_2,$elementOfTable_3,$conditions, $orderBy);
    }

    public static function indexCourseToCreate($meetingNumber,$raceNumber):string
    {
        $dateJ=($_SESSION['horseRacingsDate']['date'])->format('d');
        $dateM=($_SESSION['horseRacingsDate']['date'])->format('m');
        $dateY=($_SESSION['horseRacingsDate']['date'])->format('Y');
        return ($dateY.'-'.$dateM.'-'.$dateJ.'_R'.$meetingNumber.'C'.$raceNumber);
    }

    private function missingTipsters($tipsters, $datasCondition)
    {
        $missingForecasts=[];
        foreach ($tipsters as $tipster) {
            if(!$this->getTipstersOfDay($datasCondition,['index_tipster'=>$tipster['index_pronostiqueur']]))
                {
                    array_push($missingForecasts,$tipster['pronostiqueur']);
                }
        }
        return $missingForecasts;
    }

    private function updateRaceOfDay($raceOfDay)
    {
        $_SESSION['horseRacing']['indexCourse']  = $raceOfDay['index_course']??"";
        $_SESSION['horseRacing']['meetingNumber'] = $raceOfDay['numero_reunion']??1;
        $_SESSION['horseRacing']['raceNumber']    = $raceOfDay['numero_course']??"";
        $_SESSION['horseRacing']['raceLength']    = $raceOfDay['distance_course']??"";
        $_SESSION['horseRacing']['raceType']      = $raceOfDay['type_course']??"";
        $_SESSION['horseRacing']['hippodrome']    = $raceOfDay['index_hippodrome']??"";
        for ($i=1; $i < 6; $i++) { 
            $ch="ch".$i;
            $_SESSION['horseRacing'][$ch]=$raceOfDay['arrivee_'.$ch]??"";
        }
    }

    private function updateRaceWinningsOfDay($horseRacingWinnings)
    {
        $_SESSION['horseRacing']['sg']   = $horseRacingWinnings['sg']??"";
        $_SESSION['horseRacing']['zs']   = $horseRacingWinnings['zs']??"";
        $_SESSION['horseRacing']['zc']   = $horseRacingWinnings['zc']??"";
        $_SESSION['horseRacing']['ze24'] = $horseRacingWinnings['ze24']??"";
        $_SESSION['horseRacing']['jg']   = $horseRacingWinnings['jg']??"";
        $_SESSION['horseRacing']['jgo']  = $horseRacingWinnings['jgo']??"";
        for ($i=1; $i < 4; $i++) { 
            $sp="sp".$i;
            $_SESSION['horseRacing'][$sp]= $horseRacingWinnings[$sp]??"";
        }
    }

    private function getTipstersOfDay($datasConditions,$otherDatasConditions)
    {
        $conditions=[];
        $conditions+=$datasConditions;
        $conditions+=['archive_pronostiqueur'=>0];
        if (count($otherDatasConditions)>0)$conditions+=$otherDatasConditions;
        $orderBy=['pronostiqueur','ASC'];
        $elementOfTable_1=[
            'nameOfTable'  => 'courses_pronostics',
            'keyForJoin'   => 'index_pronostiqueur',
            'columnHeader' => ['index_course','index_tipster','ch1','ch2','ch3','ch4','ch5','ch6','ch7','ch8']
        ];
        $elementOfTable_2=[
            'nameOfTable'  => 'courses_pronostiqueurs',
            'keyForJoin'   => 'index_pronostiqueur',
            'columnHeader' => ['pronostiqueur']
        ];
        return $this->horseRacing->getWithJoinDatasFrom2Tables($elementOfTable_1,$elementOfTable_2, $conditions, $orderBy);
    }

    private function getConditionsCommonOfFilter():array
    {
        $date_start   = $_SESSION['horseRacingsDate']['dateStart']->format('Y-m-d');
        $date_end     = $_SESSION['horseRacingsDate']['dateEnd']->format('Y-m-d');
        $type_race    = $_SESSION['racingStats']['raceType'];
        array_unshift($type_race,"=");
        $hippodrome   = $_SESSION['racingStats']['hippodrome'];
        array_unshift($hippodrome,"=");
        $length_track = $_SESSION['racingStats']['trackLength']; 
        $conditions=[
            'date_course'      => ['><',$date_start,$date_end],
            'type_course'      => $type_race,
            'index_hippodrome' => $hippodrome
        ];
        if(count($length_track)>0){
            $conditions+=['distance_course'=>$length_track];
        }
        return $conditions;
    }

    public function initializTable($table){
        $allRows=$this->horseRacing->getFewRowsDatasFromTable($table, [], []);
        $i=1;
            foreach ($allRows as $row) {
            $cond=[
                'compteur'=>$row['compteur']
            ];
            $updateDatas=[
                'compteur_2'=>$i
            ];
            $i++;
            $update=$this->horseRacing->updateDatasInDataTable($table,$updateDatas,$cond);
        }
        Toolbox::addMessageAlert("compteur : ".$i,Toolbox::COLOR_SUCCESS);
    }
}