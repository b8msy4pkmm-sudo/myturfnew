<?php
ini_set('memory_limit', '128M');
session_start();
//ini_set('display_errors', 'on');
date_default_timezone_set('Indian/Reunion');
/* définition des constantes pour tout le site */
include("./views/common/noRefreshForm.php");
// URL principal du site
define ("URL", str_replace("index.php","",(isset($_SERVER['HTTPS'])?"https":"http")."://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']));

define ("RACE_TYPE",['Attelé', 'Haies', 'Monté','Plat','Steeple']);
define ("REUSSITE_MIN",15);
define ("RDT_MIN",120);

use MAIN_NAMESPACE\utilities\toolbox\Toolbox;
use MAIN_NAMESPACE\utilities\security\Security;

require_once("./controllers/utilities/toolbox/Toolbox.Class.php");
require_once("./controllers/utilities/forms/Forms.Class.php");
require_once("./controllers/visitor/Visitor.Class.php");
require_once("./controllers/member/Member.Class.php");

$visitor = new VisitorController();
$member  = new MemberController();

// $_SESSION['horseRacingsDate']['date']=new DateTime();
// $_SESSION['horseRacingsDate']['dateStart']=new DateTime('2022-01-01');
// $_SESSION['horseRacingsDate']['dateEnd']=new DateTime();

try
{
    if(empty($_GET['page']))
    {
        $page= "formForLoginUserSession";
    }
    else
    {
        $url=explode("/",filter_var($_GET['page'], FILTER_SANITIZE_URL)); 
        $page=$url[0];
    }

    switch ($page) 
    {
        /* ----  Quand l'utilisateur est un simple visiteur et n'est pas encore contecté en tant que membre ---- */
        case "formForLoginUserSession":
            if (Security::userSessionActive() && Security::cookieSessionStillActive()) 
            {
                header("location:".URL."memberSession/homePage");
            }else
            {
                if (Security::userSessionActive())
                {
                    unset($_SESSION['profil']);
                }
                $visitor->accessLoginPage();
            }

        break;

        case "formForCreateUserAccount":
            if (Security::userSessionActive() && Security::cookieSessionStillActive()) 
            {
                header("location:".URL."memberSession/homePage");
            }else
            {
                if (Security::userSessionActive())
                {
                    unset($_SESSION['profil']);
                }
                $visitor->accessCreateAccountPage();
            }           
        break;

        case "formForgettenPassword":
            if (Security::userSessionActive() && Security::cookieSessionStillActive()) 
            {
                header("location:".URL."memberSession/homePage");
            }else
            {
                if (Security::userSessionActive())
                {
                    unset($_SESSION['profil']);
                }
                $visitor->accessPageForgettenPassword();
            }  
        break;

        case "formForgettenPasswordValidated":
            if (Security::userSessionActive() && Security::cookieSessionStillActive()) 
            {
                header("location:".URL."memberSession/homePage");
            }else
            {
                if (Security::userSessionActive())
                {
                    unset($_SESSION['profil']);
                }
                //$visitor->accessPageResetPassword();
                if(!empty($_POST['email']) && Toolbox::verifEmail(Security::secureHTML($_POST['email'])))
                {
                    $datasConditions=[
                       "email" =>   Security::secureHTML($_POST['email'])
                    ];
                    if($member->checkMemberIfExist($datasConditions))
                    {
                        $member->sendEmailForForgettenPassword(Security::secureHTML($_POST['email']));
                        $visitor->accessLoginPage();
                    }else{
                        Toolbox::addMessageAlert("l'email inexistant",Toolbox::COLOR_WARNING);
                    }
                }
                else
                {
                    Toolbox::addMessageAlert("Email incorrect !",Toolbox::COLOR_DANGER);
                }   
                $visitor->accessPageForgettenPassword();
            }  
        break;

        case "formOfResetPassword":
            if (Security::userSessionActive() && Security::cookieSessionStillActive()) 
            {
                header("location:".URL."memberSession/homePage");
            }else
            {
                if (Security::userSessionActive())
                {
                    unset($_SESSION['profil']);
                }
                $visitor->accessPageResetPassword();
            }  
        break;

        case "validateNewPassword":
            if (Security::userSessionActive() && Security::cookieSessionStillActive()) 
            {
                header("location:".URL."memberSession/homePage");
            }else
            {
                if (Security::userSessionActive())
                {
                    unset($_SESSION['profil']);
                }
                if(!empty($_POST['secret_key']) && !empty($_POST['newPassword']) && !empty($_POST['email']))
                {
                    // Controle de saise du mot de passe
                    if((Security::secureHTML($_POST['newPassword']))<6 || str_word_count($_POST['newPassword'],0)>1)
                    {
                        Toolbox::addMessageAlert("Echec ! Mot de passe non conforme.",Toolbox::COLOR_DANGER);
                        $visitor->accessPageResetPassword();
                        exit();
                    }
                    // controle de la véracité de l'email et du code secret
                    $datas=[
                        "email"      =>   Security::secureHTML($_POST['email']),
                        "access_key" =>   Security::secureHTML($_POST['secret_key'])
                     ];
                    if(!$member->checkMemberIfExist($datas))
                    {
                        Toolbox::addMessageAlert("Echec ! Email et ou code secret invalides.",Toolbox::COLOR_DANGER);
                        $visitor->accessPageResetPassword();
                        exit();
                    }
                    // Si tout est conforme, Mise à jour du mot de passe
                    $datas += [
                        'newPassword'   => Security::secureHTML($_POST['newPassword'])
                    ];
                    $member->updateOfPasswordMember($datas);
                }
                else
                {
                    $visitor->accessPageResetPassword();
                }
            }  
        
        break;

        case "CheckUserIdentification":
            if (Security::userSessionActive() && Security::cookieSessionStillActive()) 
            {
                header("location:".URL."memberSession/homePage");
            }else
            {
                if (Security::userSessionActive())
                {
                    unset($_SESSION['profil']);
                }
                if(!empty($_POST['pseudo']) && (!empty($_POST['password'])))
                {
                    $memberDatas=[
                        "pseudo"  => ['=',Security::secureHTML($_POST['pseudo'])],
                        "pwd"     => ['=',Security::secureHTML($_POST['password'])]
                    ];
                    $pseudoToCheck=[
                        'pseudo'=>$memberDatas['pseudo']
                    ];
                    $_SESSION['sessionTime']=(isset($_POST['sessionTime']))?(int)($_POST['sessionTime'][0]):0;
                    
                    // SI le pseudo existe
                    if(!$member->checkMemberIfExist($pseudoToCheck))
                        {
                            Toolbox::addMessageAlert("Echec de connexion - Recommencez !",Toolbox::COLOR_DANGER);
                            $visitor->accessLoginPage();
                        }
                    else 
                        {
                            // Controle si le statut du membre est bien validé, sinon lui envoyé un mail pour qu'il active son compte
                            if($member->checkMemberAccountIfNoActived($memberDatas))
                            {
                                $linkValidationMail="<a href=".URL."returnValidationByMail/".$memberDatas["pseudo"][1]."> Renvoyer le mail d'activation</a>";
                                Toolbox::addMessageAlert("Oups ! Compte pas encore activé.".$linkValidationMail,Toolbox::COLOR_WARNING);
                                unset($_SESSION['profil']);
                                unset($_SESSION['sessionTime']);
                                $visitor->accessLoginPage();
                                exit();
                            }
                            // Dernier point de controle, le nouveau doit être approuvé par l'administrateur. Le compte du membre peut être est bien activé mais encore approuvé.
                            if($member->checkmemberAccountIsNotAuthorizedByAdministrator($memberDatas))
                            {
                                Toolbox::addMessageAlert("Votre compte est bien activé mais pas encore approuvé par l'administrateur !",Toolbox::COLOR_WARNING);
                                $member->sendEmailForAdmin($memberDatas);
                                unset($_SESSION['profil']);
                                $visitor->accessLoginPage();
                                exit();
                            }
                            // tout semble correct sur le statut du membre
                            if($member->memberIdentifiedValidated($memberDatas)){
                                Toolbox::addMessageAlert('Vous êtes connectés !',Toolbox::COLOR_SUCCESS);
                                header("location:".URL."memberSession/homePage");
                            }else{
                                Toolbox::addMessageAlert('Un souci avec le mot de passe !',Toolbox::COLOR_WARNING);
                                $visitor->accessLoginPage();
                            }
                            ;
                        }
                }else
                {
                    $visitor->accessLoginPage();
                }
            }  
        break;

        case "ValideNewMemberAccount":
            if (Security::userSessionActive() && Security::cookieSessionStillActive()) 
            {
                header("location:".URL."memberSession/homePage");
            }else
            {
                if (Security::userSessionActive())
                {
                    unset($_SESSION['profil']);
                }
                if(!empty($_POST['pseudo']) && !empty($_POST['username']) && !empty($_POST['lastname']) && !empty($_POST['password'])&& !empty($_POST['passwordConfirm'])&& !empty($_POST['email'])&& !empty($_POST['emailConfirm']))
                {
                    // Contrôle de saisie
                    // vérification si Email saisie est valide
                    if (!Toolbox::verifEmail($_POST['email']))
                    {
                        Toolbox::addMessageAlert("Email non valide !",Toolbox::COLOR_DANGER);
                        $visitor->accessCreateAccountPage();
                        exit();
                    }
                    // vérification si les confirmations emails saisis ou mot de passe sont identiques 
                    // vérification si le pseudo > 4 et qu'il s'agit d'un seul mot
                    if($_POST['password']!==$_POST['passwordConfirm'] || $_POST['email']!==$_POST['emailConfirm'] || (strlen(trim($_POST['pseudo']))<6) || str_word_count($_POST['pseudo'],0)>1)
                    {
                        Toolbox::addMessageAlert("Echec ! vérifier les points suivants : pseudo, mot de passe ou email.",Toolbox::COLOR_DANGER);
                        $visitor->accessCreateAccountPage();
                        exit();
                    }
                    $newMember=[
                        'pseudo'    => Security::secureHTML($_POST['pseudo']),
                        'username'  => Security::secureHTML(ucwords(strtolower($_POST['username']))),
                        'lastname'  => Security::secureHTML(strtoupper($_POST['lastname'])),
                        'password'  => Security::secureHTML($_POST['password']),
                        'email'     => Security::secureHTML(strtolower($_POST['email'])),
                        'gender'    => Security::secureHTML((int)$_POST['gender'])
                    ];
                    //Controle si le pseudo ou l'email ne sont pas attriués à un membre de la base
                    $pseudoToCheck=[
                        "pseudo" => $newMember['pseudo']
                    ];
                    $emailToCheck=[
                        "email" => $newMember['email']
                    ];
                    if ($member->checkMemberIfExist($pseudoToCheck) || $member->checkMemberIfExist($emailToCheck))
                    {
                        Toolbox::addMessageAlert("Echec ! le pseudo ou l'email est déjà utilisé.",Toolbox::COLOR_DANGER);
                        $visitor->accessCreateAccountPage();
                        exit();
                    }
                    // Tous les champs du nouveau membre sont vérifiés => enregistrement du membre
                    $member->createNewMember($newMember);
                    Toolbox::addMessageAlert("Membre enregistré avec succès",Toolbox::COLOR_SUCCESS);
    
                    $member->sendEmailForActivationMemberAccount($newMember['pseudo']);
                    $visitor->accessLoginPage();
                }
                else
                {
                    Toolbox::addMessageAlert("Oups ! Recommencer !",Toolbox::COLOR_WARNING);
                    $visitor->accessCreateAccountPage();
                }
            }  
        break;

        case "memberAccountValidatedByEmail":
            if (Security::userSessionActive() && Security::cookieSessionStillActive()) 
            {
                header("location:".URL."memberSession/homePage");
            }else
            {
                if (Security::userSessionActive())
                {
                    unset($_SESSION['profil']);
                }
                if(isset($url[1])){
                    $datasMember=[
                        'cookies' => Security::secureHTML($url[1])
                    ];
                    $member->memberAccountValidatedByEmail($datasMember);
                }
                $visitor->accessLoginPage();
            }  

        break;

        case "returnValidationByMail":
            if (Security::userSessionActive() && Security::cookieSessionStillActive()) 
            {
                header("location:".URL."memberSession/homePage");
            }else
            {
                if (Security::userSessionActive())
                {
                    unset($_SESSION['profil']);
                }
                if(isset($url[1]))
                {
                    $member->sendEmailForActivationMemberAccount($url[1]);
                }
                $visitor->accessLoginPage();
            } 
        break;

        case "accountValidatedByAdmin":
            if (Security::userSessionActive() && Security::cookieSessionStillActive()) 
            {
                header("location:".URL."memberSession/homePage");
            }else
            {
                if (Security::userSessionActive())
                {
                    unset($_SESSION['profil']);
                }
                if(isset($url[1])){
                    $datasMember=[
                        'cookies' => Security::secureHTML($url[1])
                    ];
                    $member->accountValidatedByAdmin($datasMember);
                }
                $visitor->accessLoginPage();
            }  

        break;

        /* ---- Quand l'utilisateur est identifié comme un membre tout se passera dans memberSession ---- */
        case "memberSession":
            if(Security::userSessionActive() && Security::cookieSessionStillActive())
            {
                switch ($url[1])
                {    
                    /*  -----   gestion des courses hippiques  -----  */    
                    case "homePage":
                        if (isset($_SESSION['temporyUser'])){unset($_SESSION['temporyUser']);};
                        if (isset($_SESSION['resultsOfFilters'])){unset($_SESSION['resultsOfFilters']);};
                        if (isset($_SESSION['horseRacing'])){unset($_SESSION['horseRacing']);};
                        //unset($_SESSION['racingStats']);
                        if(!isset(($_SESSION['horseRacingsDate']))){
                            $_SESSION['horseRacingsDate']=[
                                'date' => new datetime(),
                                'dateStart' => new datetime('2022-01-01'),
                                'dateEnd' => new datetime()
                            ];
                        }
                        $member->accessHomePage();
                    break;

                    case "raceHorse":
                        require_once("./controllers/member/turf/Turf.Class.php");
                        $racing = new \MAIN_NAMESPACE\controllers\member\turf\TurfController();
                        if(isset($url[2])){
                            switch($url[2])
                            {
                                
                                /** suite à l'appel du formulaire de selection date en entete de chaque page**/
                                /** renvoie vers la page appelante défini par la variable $_SESSION['horseRacing']['page'] **/

                                case "checkDateTurfOfDay":
                                    if(!empty($_POST['date'])){
                                        $_SESSION['horseRacingsDate']['date']=Security::controlTheDateInput($_POST['date']);
                                        switch ($_SESSION['horseRacing']['page']) 
                                        {
                                            case 'byTipsters':
                                                $racing->accessPageRaceHorseByTipsters();
                                            break;
                                            case 'raceResults':
                                                $racing->accessPageRaceHorseResults();
                                            break;
                                            case 'raceInfos':
                                                $_SESSION['horseRacing']['page']="raceInfos";
                                                $racing->accessPageRaceHorseResults();
                                            break;
                                            case 'raceFinish':
                                                $_SESSION['horseRacing']['page']="raceFinish";
                                                $racing->accessPageRaceHorseResults();
                                            break;
                                            case 'raceWinnings':
                                                $_SESSION['horseRacing']['page']="raceWinnings";
                                                $racing->accessPageRaceHorseResults();
                                            break;
                                            case "raceTipster":
                                                $_SESSION['horseRacing']['page']="raceTipster";
                                                $racing->accessPageRaceHorseResults();
                                            break;

                                            default:
                                                $racing->accessPageRaceHorseByTipsters();
                                            break;
                                        }
                                    }else
                                    {
                                        $member->accessHomePage();
                                    }
                                break;
    
                                case "checkDateHorseRacing":
                                    if(!empty($_POST['date']))
                                    {
                                        $_SESSION['horseRacingsDate']['date']=Security::controlTheDateInput($_POST['date']);
                                    }
                                    $member->accessHomePage();
                                break;

                                /* Tout ce qui suit vient des liens des menus et des sous menus issus de homePage.php */ 
                                /* On définit la variable $_SESSION['horseRacing']['page'] pour enregistrer la page visitée */

                                case "byTipsters":
                                    $_SESSION['horseRacing']['page']="byTipsters";
                                    $racing->accessPageRaceHorseByTipsters();
                                break;
                                case "simulRaceFinish":
                                    $_SESSION['horseRacing']['page']="simulRaceFinish";
                                    $_SESSION['horseRacingsDate']['dateNow']=new dateTime();
                                    $racing->accessPageRaceHorseByTipsters();                 
                                break;

                                case "raceResults":
                                    $_SESSION['horseRacing']['page']="raceResults";
                                    $racing->accessPageRaceHorseResults();
                                break;
    
                                case "raceInfos":
                                    $_SESSION['horseRacing']['page']="raceInfos";
                                    $racing->accessPageRaceHorseResults();
                                break;
    
                                case "raceFinish":
                                    $_SESSION['horseRacing']['page']="raceFinish";
                                    $racing->accessPageRaceHorseResults();
                                break;
    
                                case "raceWinnings":
                                    $_SESSION['horseRacing']['page']="raceWinnings";
                                    $racing->accessPageRaceHorseResults();
                                break;
                                case "raceTipster":
                                    $_SESSION['horseRacing']['page']="raceTipster";
                                    $racing->accessPageRaceHorseResults();
                                break;

                                /* Fin  des liens des menus et des sous menus issus de homePage.php */ 

                                case "updateHorseRacing":
                                    //Toolbox::addMessageAlert("url : ".$url[3],Toolbox::COLOR_WARNING);
                                    if(isset($url[3]))
                                    {
                                        switch ($url[3]) {
                                            case 'raceInfos':
                                                if(!empty($_POST['meetingNumber']) && 
                                                   !empty($_POST['raceNumber'])    && 
                                                   !empty($_POST['raceLength'])    && 
                                                   !empty($_POST['hippodrome'])    && 
                                                   !empty($_POST['raceType'])    
                                                   )
                                                {
                                                    $datas=[
                                                        'numero_reunion'=> (int)Security::secureHTML($_POST['meetingNumber']),
                                                        'numero_course'=> (int)Security::secureHTML($_POST['raceNumber']),
                                                        'distance_course'=> (int)Security::secureHTML($_POST['raceLength']),
                                                        'index_hippodrome'=> Security::secureHTML($_POST['hippodrome']),
                                                        'type_course'=> Security::secureHTML($_POST['raceType'])
                                                    ];
                                                    if($_SESSION['horseRacing']['indexCourse'])
                                                    {
                                                        $datasToUpdate=$datas;
                                                        $datasConditions=[
                                                            'date_course'=>$_SESSION['horseRacingsDate']['date']->format('Y-m-d')
                                                        ];
                                                        $racing->updateRacingInfos("courses_arrivee",$datasToUpdate,$datasConditions);
                                                    }
                                                    else
                                                    {
                                                        $datasToInsert=[...$datas,
                                                            'date_course'      => $_SESSION['horseRacingsDate']['date']->format('Y-m-d'),
                                                            'index_course'     => TurfController::indexCourseToCreate((int)Security::secureHTML($_POST['meetingNumber']),(int)Security::secureHTML($_POST['raceNumber'])),
                                                            'reunion_quinte'   => 1,
                                                            'course_quinte'    => 1
                                                        ];
                                                        $racing->insertRacingInfos("courses_arrivee",$datasToInsert);
                                                    }
                                                }
                                                else
                                                {
                                                    Toolbox::addMessageAlert("Echec ! Recommencer ! ",Toolbox::COLOR_DANGER);
                                                }
                                                $racing->accessPageRaceHorseResults();
                                            break;
    
                                            case "raceFinish":
                                                if(!empty($_POST['ch1']) && 
                                                !empty($_POST['ch2'])    && 
                                                !empty($_POST['ch3'])    && 
                                                !empty($_POST['ch4'])    && 
                                                !empty($_POST['ch5'])    
                                                )
                                                {
                                                    if(isset($_SESSION['horseRacing']['indexCourse']))
                                                    {
                                                        $datasToUpdate=[];
                                                        for ($i=1 ; $i<6; $i++){
                                                            $chFinish="arrivee_ch".$i;
                                                            $chInput="ch".$i;
                                                            $datasToUpdate+=[
                                                                $chFinish => (int)Security::secureHTML($_POST[$chInput])
                                                            ];
                                                        }
                                                        //print_r($datasToUpdate);
                                                        $datasConditions=[
                                                            'date_course'=>$_SESSION['horseRacingsDate']['date']->format('Y-m-d')
                                                        ];
                                                        $racing->updateRacingInfos("courses_arrivee",$datasToUpdate,$datasConditions);
                                                    }
                                                }
                                                else
                                                {
                                                    Toolbox::addMessageAlert("Echec ! Recommencer ! ",Toolbox::COLOR_DANGER);
                                                }
                                                $racing->accessPageRaceHorseResults();
                                            break;
    
                                            case "raceFinishSimul":
                                                $_SESSION['horseRacing']['page']="simulRaceFinish";
                                                $_SESSION['horseRacingsDate']['dateNow']=new dateTime();
                                                $_SESSION['horseRacing']['simulRace']=[
                                                    "arrivee_ch1"=>(int)Security::secureHTML($_POST["ch1"]??""),
                                                    "arrivee_ch2"=>(int)Security::secureHTML($_POST["ch2"]??""),
                                                    "arrivee_ch3"=>(int)Security::secureHTML($_POST["ch3"]??""),
                                                    "arrivee_ch4"=>(int)Security::secureHTML($_POST["ch4"]??""),
                                                    "arrivee_ch5"=>(int)Security::secureHTML($_POST["ch5"]??"")
                                                ];
                                                $racing->accessPageRaceHorseByTipsters();
                                            break;
    
                                            case "raceWinnings":
                                                if (preg_match("/^(\d+)?\.\d+$/",$_POST['sg']) &&
                                                preg_match("/^(\d+)?\.\d+$/",$_POST['zs']) && 
                                                preg_match("/^(\d+)?\.\d+$/",$_POST['zc']) && 
                                                preg_match("/^(\d+)?\.\d+$/",$_POST['sp1']) && 
                                                preg_match("/^(\d+)?\.\d+$/",$_POST['sp2']) && 
                                                preg_match("/^(\d+)?\.\d+$/",$_POST['sp3']) && 
                                                preg_match("/^(\d+)?\.\d+$/",$_POST['jg']) && 
                                                preg_match("/^(\d+)?\.\d+$/",$_POST['jgo']) && 
                                                preg_match("/^(\d+)?\.\d+$/",$_POST['ze24']))
                                                {
                                                    $datas=[
                                                        'sg'   =>(float)Security::secureHTML($_POST['sg']),
                                                        'zs'   =>(float)Security::secureHTML($_POST['zs']),
                                                        'zc'   =>(float)Security::secureHTML($_POST['zc']),
                                                        'sp1'  =>(float)Security::secureHTML($_POST['sp1']),
                                                        'sp2'  =>(float)Security::secureHTML($_POST['sp2']),
                                                        'sp3'  =>(float)Security::secureHTML($_POST['sp3']),
                                                        'jg'   =>(float)Security::secureHTML($_POST['jg']),
                                                        'jgo'  =>(float)Security::secureHTML($_POST['jgo']),
                                                        'ze24' =>(float)Security::secureHTML($_POST['ze24'])
                                                    ];
                                                    //print_r($datas);
                                                    if($_SESSION['horseRacing']['indexCourse'] && ($_SESSION['horseRacing']['sg'])=="")
                                                    {
                                                      
                                                        $datasToInsert=[...$datas,
                                                            'index_course'=>$_SESSION['horseRacing']['indexCourse']
                                                        ];
                                                        //var_dump($datasToInsert);
                                                        $racing->insertRacingInfos("course_gains",$datasToInsert);
                                                    }
                                                    else
                                                    {
                                                        $datasToUpdate=$datas;
                                                        $datasConditions=[
                                                            'index_course'=>$_SESSION['horseRacing']['indexCourse']
                                                        ];
                                                        $racing->updateRacingInfos("course_gains",$datasToUpdate,$datasConditions);
                                                    }
                                                }
                                                else
                                                {
                                                    Toolbox::addMessageAlert("Veuillez saisir un nombre décimal avec un point x.xx",Toolbox::COLOR_DANGER);
                                                }
                                                $racing->accessPageRaceHorseResults();
                                            break;
    
                                            case "raceTipster":
                                                if((!empty($_POST['tipster'])) && $_POST['tipster']!=$_SESSION['tipsterSelected'])
                                                {
                                                    $_SESSION['tipsterSelected']=Security::secureHTML($_POST['tipster']);
                                                    $_POST['tipster']="";
                                                    $racing->accessPageRaceHorseResults();
                                                    exit();
                                                }
                                                if (
                                                    !empty($_POST['ch1']) &&
                                                    !empty($_POST['ch2']) &&
                                                    !empty($_POST['ch3']) &&
                                                    !empty($_POST['ch4']) &&
                                                    !empty($_POST['ch5']) &&
                                                    !empty($_POST['ch6']) &&
                                                    !empty($_POST['ch7']) &&
                                                    !empty($_POST['ch8'])
                                                )
                                                {
                                                    //ToolBox::addMessageAlert("Pronostiquer sélectionnée :".$_POST['tipster']." Pronostiqueur en session : ".$_SESSION['tipsterSelected'],Toolbox::COLOR_WARNING);
                                                    $inputDatas=[];
                                                    for ($i=0; $i < 8; $i++) { 
                                                        $ch="ch".$i+1;
                                                        $inputDatas+=[$ch=>(int)Security::secureHTML($_POST[$ch])??""];
                                                    }
                                                    switch ($_SESSION['tipsterForecast']) {
                                                        case 'update':
                                                            $datasTuUpdate=[...$inputDatas];
                                                            $datasConditions=[
                                                                'index_course'  => $_SESSION['forecastOfTipsterSelected']['index_course'],
                                                                'index_tipster' => $_SESSION['forecastOfTipsterSelected']['index_tipster']
                                                            ];
                                                            $racing->updateRacingInfos("courses_pronostics",$datasTuUpdate,$datasConditions);
                                                            $racing->accessPageRaceHorseResults();
                                                            exit();
                                                        break;
    
                                                        case 'insert':
                                                            $datasToInsert=[...$inputDatas,
                                                                'index_course'        => $_SESSION['horseRacing']['indexCourse'],
                                                                'index_pronostiqueur' => $_SESSION['tipsterSelected'],
                                                                'index_tipster'       => $_SESSION['tipsterSelected']
                                                            ];
                                                            $racing->insertRacingInfos("courses_pronostics",$datasToInsert);
                                                            $racing->accessPageRaceHorseResults();
                                                            exit();
                                                        break;
                                                        
                                                        default:
                                                        break;
                                                    }
                                                }
                                                else
                                                {
                                                    Toolbox::addMessageAlert("Veuiller remplir tous champs !",Toolbox::COLOR_DANGER);
                                                }
                                        
                                                $racing->accessPageRaceHorseResults();
                                            break;
                                            
                                            default:
                                                $member->accessHomePage();
                                            break;
                                        }
                                    }
                                    else
                                    {
                                        $member->accessHomePage();
                                    }

                                break;
    
                                default:
                                    $_SESSION['errorMsg']= "Bien essayer ! &#x1F602;";
                                    throw new Exception("La page n'existe pas"); 
                                break;
                            }
                        }else
                        {
                            $member->accessHomePage();
                        }
                    break;

                    case "racingStats":
                        require_once("./controllers/member/turf/Turf.Class.php");
                        $racing = new \MAIN_NAMESPACE\controllers\member\turf\TurfController();
                        if(isset($url[2]))
                        {
                            switch ($url[2])
                            {
                                case "checkDatePeriod": //provenant de homePage.php 
                                    if (!empty($_POST['date_start']) && !empty($_POST['date_end']))
                                    {
                                        $_SESSION['horseRacingsDate']['dateStart']= Security::controlTheDateInput($_POST['date_start'],'2022-01-01');
                                        $_SESSION['horseRacingsDate']['dateEnd']  = Security::controlTheDateInput($_POST['date_end']);
                                        unset($_SESSION['dateEndChange']);
                                    }
                                    if (isset($_SESSION['resultsOfFilters'])){unset($_SESSION['resultsOfFilters']);};
                                    unset($_SESSION['resultsOfFiltersByDesc']);
                                    //$racing->resetFilter();
                                    $racing->initialiseGame();
                                    $member->accessHomePage();
                                break;

                                case "checkDatePeriodForStat": // Provenant de racingStats_mainTemplate.php
                                    if (!empty($_POST['date_start']) && !empty($_POST['date_end']))
                                    {
                                        $_SESSION['horseRacingsDate']['dateStart']= Security::controlTheDateInput($_POST['date_start'],'2022-01-01');
                                        $_SESSION['horseRacingsDate']['dateEnd']  = Security::controlTheDateInput($_POST['date_end']);
                                        unset($_SESSION['dateEndChange']);

                                        if(count($_SESSION['racingStats'])>2){
                                            $_SESSION['resultsOfFilters']=$racing->getAllResultsAndWinningsOfFilters();
                                        }
                                        if (isset($_SESSION['resultsOfFilters'])){unset($_SESSION['resultsOfFilters']);};
                                        $racing->accessPageRacingStats();
                                    }
                                    else{
                                        $member->accessHomePage();
                                    }
                                break;

                                case "simplesGames":
                                    $_SESSION['racingStats']['page']="simplesGames";
                                    if(!in_array($_SESSION['racingStats']['gameType'],['sg','zs','zc','sp']))$_SESSION['racingStats']['gameType']='sg';
                                    $_SESSION['racingStats']['gameType']=Security::secureHTML($_POST['gameType']??($_SESSION['racingStats']['gameType']??"sg"));
                                    $racing->accessPageRacingStats();
                                    //exit();
                                break;

                                case "couplesGames":
                                    $_SESSION['racingStats']['page']="couplesGames";
                                    if(!in_array($_SESSION['racingStats']['gameType'],['jg','jgo','2s4']))$_SESSION['racingStats']['gameType']='jg';
                                    //Toolbox::addMessageAlert($_SESSION['racingStats']['gameTypeTempory'],Toolbox::COLOR_WARNING);
                                    $_SESSION['racingStats']['gameType']=Security::secureHTML($_POST['gameType']??($_SESSION['racingStats']['gameType']??"jg"));
                                    $racing->accessPageRacingStats();
                                break;
                                
                                /*    
                                case "gameType":
                                    if(!empty($_POST['gameType']))
                                    {
                                        Toolbox::addMessageAlert('jeux joué : '.$_POST['gameType'],Toolbox::COLOR_SUCCESS);
                                        $_SESSION['racingStats']['gameType']=Security::secureHTML($_POST['gameType']);
                                        $racing->accessPageRacingStats();
                                        exit();
                                    }
                                    else
                                    {
                                        Toolbox::addMessageAlert("raté jeux",Toolbox::COLOR_WARNING);
                                        $racing->accessPageRacingStats();
                                    }
                                break;
                                */

                                case "executFilters":
                                    if($racing->checkFilters($_POST)) 
                                    {
                                        $_SESSION['resultsOfFilters']=$racing->getAllResultsAndWinningsOfFilters();
                                        $_SESSION['resultsOfFiltersByDesc']=$racing->getAllResultsAndWinningsOfFilters("DESC");
                                        if(!$_SESSION['resultsOfFilters'])
                                        {
                                            //$_SESSION['resultsOfFilters']=$racing->getAllResultsAndWinningsOfFilters();
                                             unset($_SESSION['resultsOfFilters']);
                                             unset($_SESSION['resultsOfFiltersByDesc']);
                                        }
                                    }
                                    else
                                    {
                                        Toolbox::addMessageAlert("Oups ! Veuiller recommencer ! ",Toolbox::COLOR_DANGER);
                                        unset($_SESSION['resultsOfFilters']);
                                        unset($_SESSION['resultsOfFiltersByDesc']);
                                    }
                                    $racing->accessPageRacingStats();
                                break;

                                case "resetFilter":
                                    unset($_SESSION['resultsOfFilters']);
                                    unset($_SESSION['resultsOfFiltersByDesc']);
                                    $racing->initialiseGame();
                                    //$racing->resetFilter();
                                    $racing->accessPageRacingStats();
                                break;
                            }
                        }
                        else
                        {
                            $member->accessHomePage();
                        }

                    break;

                    /*  -----  Gestion du compte membre  -----  */ 
                    case "profilMember":
                        $member->accessMemberProfil();
                    break;

                    case "modifyProfilMember":
                        if(!empty($_POST['pseudo']) && !empty($_POST['username']) && !empty($_POST['lastname']) && !empty($_POST['email']) && Security::userSessionActive())
                        {
                            $memberDatas=[
                                'pseudo'   => Security::secureHTML($_POST['pseudo']),
                                'username' => Security::secureHTML(ucwords(strtolower($_POST['username']))),
                                'lastname' => Security::secureHTML(strtoupper($_POST['lastname'])),
                                'email'    => Security::secureHTML($_POST['email'])         
                            ];
                            if($memberDatas['pseudo']!==$_SESSION['profil']['pseudo'])
                            {
                                $dataToCheck=[
                                    'pseudo'=>$memberDatas['pseudo']
                                ];
                                if($member->checkMemberIfExist($dataToCheck))
                                {
                                    Toolbox::addMessageAlert("Echec ! Ce pseudo est déjà utilisé !",Toolbox::COLOR_WARNING);
                                    $member->accessMemberProfil();
                                    exit();
                                }
                            }
                            if($memberDatas['email']!==$_SESSION['profil']['email'])
                            {
                                $dataToCheck=[
                                    'email'=>$memberDatas['email']
                                ];
                                if($member->checkMemberIfExist($dataToCheck))
                                {
                                Toolbox::addMessageAlert("Echec ! Cet email est déjà utilisé !",Toolbox::COLOR_WARNING);
                                $member->accessMemberProfil();
                                exit();
                                }
                            }
                            $member->updateMemberProfil($memberDatas);
                        }
                        else
                        {
                            Toolbox::addMessageAlert("Echec : Vérifier qu'aucun champ est vide !",Toolbox::COLOR_DANGER);
                            $member->accessMemberProfil();
                        }
                    break;

                    case "modifyMemberPassword":
                        if(!empty($_POST['newPasswordConfirm']) && !empty($_POST['newPassword']))
                        {
                            // Controle de saise du mot de passe
                            if(Security::secureHTML($_POST['newPassword'])!==Security::secureHTML($_POST['newPasswordConfirm']) || strlen((Security::secureHTML($_POST['newPassword'])))<6 || str_word_count($_POST['newPassword'],0)>1)
                            {
                                Toolbox::addMessageAlert("Echec ! Mot de passe non conforme.",Toolbox::COLOR_DANGER);
                                $member->accessMemberProfil();
                                exit();
                            }
                            $memberNewPassword=[
                                'newPassword' => Security::secureHTML($_POST['newPassword']),
                                'email'       => $_SESSION['profil']['email']
                            ];
                            $member->updateOfPasswordMember($memberNewPassword);
                        }
                    break;

                    case "updateMemberPicture":
                        if (
                            isset($_FILES['pictureUser']) &&
                            $_FILES['pictureUser']['error'] === 0 &&
                            $_FILES['pictureUser']['size'] > 0 
                            && is_uploaded_file($_FILES['pictureUser']['tmp_name']))
                        {
                            try {
                                $member->updateMemberPicture($_FILES['pictureUser']);
                            } catch (Exception $e) {
                                Toolbox::addMessageAlert("Erreur lors de la mise à jour : " . $e->getMessage(), Toolbox::COLOR_WARNING);
                                $member->accessMemberProfil();
                            }
                        } else {
                            Toolbox::addMessageAlert("Vous n'avez pas fourni une image valide", Toolbox::COLOR_WARNING);
                            $member->accessMemberProfil();
                        }
                    break;

                    case "manageAccess":
                        require_once("./controllers/admin/Admin.Class.php");
                        $admin = new \MAIN_NAMESPACE\controllers\Admin\AdminController();
                        $admin->accessManageAccess();
                    break;

                    case"deteleMember":
                        ($member->deleteMemberFolder())?$visitor->accessLoginPage():$member->accessMemberProfil();
                    break;

                    case"admin":
                        require_once("./controllers/admin/Admin.Class.php");
                        require_once("./controllers/member/turf/Turf.Class.php");
                        $admin = new \MAIN_NAMESPACE\controllers\Admin\AdminController();
                        $racing = new \MAIN_NAMESPACE\controllers\member\turf\TurfController();
                        switch ($url[2])
                        {
                            case "user":
                                if(!empty($_POST['userPseudo']))
                                {
                                    $admin->selectedUserRight(Security::secureHTML($_POST['userPseudo']));
                                }
                                $admin->accessManageAccess();
                            break;

                            case "noChange":
                                unset($_SESSION['temporyUser']);
                                $admin->accessManageAccess();
                            break;

                            case "initializTable":
                                $racing->initializTable("courses_pronostics");
                                $admin->accessManageAccess();
                            break;

                            case "accountAuthorization":
                                if(isset($_POST['accountStatus']) && isset($_SESSION['temporyUser'])){
                                    $userDatas=[
                                        'pseudo'=> $_SESSION['temporyUser']['pseudo']
                                    ];
                                    if(Security::secureHTML($_POST['accountStatus']==1))
                                    {
                                        $member->accountValidatedByAdmin($userDatas);
                                    }else{
                                        $member->accountDesactivatedByAdmin($userDatas);
                                    }
                                    unset($_SESSION['temporyUser']);
                                }
                                $admin->accessManageAccess();
                            break;
                            
                            default:
                                $_SESSION['errorMsg']= "Toujours bien essayer ! &#x1F602;";
                                throw new Exception("La page n'existe pas");
                            break; 

                        }
                    break;

                    case "disconnection":
                        // unset($_SESSION['profil']);
                        // unset($_SESSION['temporyUser']);
                        // unset($_SESSION['horseRacing']);
                        // unset($_SESSION['racingStats']);
                        // unset($_SESSION['resultsOfFilters']);
                        // unset($_SESSION['sauvegarde']);
                        // unset($_SESSION['post']);
                        session_destroy();
                        header('location:'.URL);
                    break;

                    default:
                        $_SESSION['errorMsg']= "Toujours bien essayer ! &#x1F602;";
                        throw new Exception("La page n'existe pas");
                    break; 
                }
            }
            else{
            header("location:".URL);
            }

        break;

        default: 
            $_SESSION['errorMsg']= "Bien essayer ! &#x1F602;";
            throw new Exception("La page n'existe pas"); 
        break;
    }
}
catch (Exception $e)
{
    $visitor->pageError($e->getMessage());
}
?>