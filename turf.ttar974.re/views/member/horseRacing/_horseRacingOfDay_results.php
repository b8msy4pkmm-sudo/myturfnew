<?php 
    $title="Course Quinté du jour";
    ob_start();
?>

<div class="turfOfDay-subcontainer">
    <?php
        if($_SESSION['horseRacing']['page']=="raceInfos") require_once("./views/member/horseRacing/__input_turfofday_infos.php");
        if($_SESSION['horseRacing']['page']=="raceFinish") require_once("./views/member/horseRacing/__input_turfofday_arrival.php");
        if($_SESSION['horseRacing']['page']=="raceWinnings") require_once("./views/member/horseRacing/__input_turfofday_winnings.php");
        if($_SESSION['horseRacing']['page']=="raceTipster") require_once("./views/member/horseRacing/__input_turfofday_tipster.php");
    ?>
</div>

<?php 
    $pageContent=ob_get_clean();
    require_once("./views/member/horseRacing/horseRacingOfDay_mainTemplate.php");
?>