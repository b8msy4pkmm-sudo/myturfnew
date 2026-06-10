<?php ($_SESSION['horseRacing']['page']==="simulRaceFinish")?$title="Pronostics presse du jour":$title="Pronostics de la presse";?>
<?php if($_SESSION['horseRacing']['page']==="simulRaceFinish"):?>
<div class="turfOfDay-subcontainer">
    <?php require("./views/member/horseRacing/__input_turfofday_arrival.php");?>
</div>
<?php endif ;?>
<?php ob_start();?>

<div class="turfOfDay-container">
    <hr>
    <?php if(isset($_SESSION['tipsterOfDayExist'])):?>
        <?php foreach ($tipstersOfDay as $tipster) :?>
            <div class="tipsters-of-day">
                <div class="tipsters-of-day_name"><p><?=$tipster['pronostiqueur'];?></p></div>
                <div class="tipsters-of-day_tips">
                    <?php for ($i=1; $i < 9; $i++) :?>
                        <?php $ch="ch".$i; ?>
                        <?php if ($_SESSION['horseRacing']['page']==="simulRaceFinish") : ?>
                            <?php switch ($tipster[$ch]) 
                                {
                                    case $_SESSION['horseRacing']['simulRace']['arrivee_ch1']??0:
                                        $styleColor="colorCh1";
                                    break;
                                    case $_SESSION['horseRacing']['simulRace']['arrivee_ch2']??0:
                                        $styleColor="colorCh2";
                                    break;
                                    case $_SESSION['horseRacing']['simulRace']['arrivee_ch3']??0:
                                        $styleColor="colorCh3";
                                    break;
                                    case $_SESSION['horseRacing']['simulRace']['arrivee_ch4']??0:
                                        $styleColor="colorCh4";
                                    break;
                                    case $_SESSION['horseRacing']['simulRace']['arrivee_ch5']??0:
                                        $styleColor="colorCh5";
                                    break;
                                    default:
                                        $styleColor="";
                                    break;
                                }
                            ?>
                        <?php else :?>
                            <?php switch ($tipster[$ch]) 
                                    {
                                        case $raceOfDay['arrivee_ch1']:
                                            $styleColor="colorCh1";
                                        break;
                                        case $raceOfDay['arrivee_ch2']:
                                            $styleColor="colorCh2";
                                        break;
                                        case $raceOfDay['arrivee_ch3']:
                                            $styleColor="colorCh3";
                                        break;
                                        case $raceOfDay['arrivee_ch4']:
                                            $styleColor="colorCh4";
                                        break;
                                        case $raceOfDay['arrivee_ch5']:
                                            $styleColor="colorCh5";
                                        break;
                                        default:
                                            $styleColor="";
                                        break;
                                    }
                            ?>
                        <?php endif;?>
                        <p class="tips <?=$styleColor;?>"><?= $tipster[$ch]==99?"":$tipster[$ch];?></p>
                    <?php endfor ?>
                </div>
            </div>
        <?php endforeach ;?>
    <?php else : ?>
        <h3>Pronostics inexistants !</h3>
    <?php endif ?>
</div>

<?php 
    $pageContent=ob_get_clean();
    require_once("./views/member/horseRacing/horseRacingOfDay_mainTemplate.php");
?>

