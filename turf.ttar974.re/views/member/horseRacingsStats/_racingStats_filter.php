
<?php

use MAIN_NAMESPACE\utilities\toolbox\Toolbox;

    $title="Statistiques des courses";
    ob_start();
?>
<div class="container-filter">
    <form action="<?= URL?>memberSession/racingStats/<?= $_SESSION['racingStats']['page']?>" method="POST">
        <?php
            require_once("./views/member/horseRacingsStats/__select_filter_gameType.php");
        ?>
    </form>
    <div class="txt-align-center"><small><?= ($_SESSION['racingStats']['gameType']=="jgo")?"⚠️ mise à 2 euros":"";?></small></div>
    <div class="result-filter">
        <?php if (isset($_SESSION['resultsOfFilters'])) : ?>
            <div class="flex-row flex-evenly flex-item-center">
                <p class="p-filter flex-item-center flex-grow">
                    Nombre de courses : <?= $totalRaceQuinte??0; ?><br/>
                    Nombre de pronostics : <?= count($_SESSION['resultsOfFilters']); ?>
                </p>
                <div class="zone-btn-filter flex-col flex-center">
                    <button id="btnViewFilter" class="btn-form h-40 btnViewFilter display-none">Masquer filtres</button>
                    <button id="btnMaskFilter" class="btn-form h-40 btnMaskFilter">Afficher filtres</button>
                </div>
            </div>
            <p id="resetFilter" class="signMeIn">Je réinitialise le filtre, <a href="<?=URL?>memberSession/racingStats/resetFilter">reset</a></p>
        <?php endif ;?>
    </div>  
    <form class="toggleFilter <?= count($finalResults)>0?"display-none":"";?>" action="<?= URL?>memberSession/racingStats/executFilters" method="POST">
        <?php
            require_once("./views/member/horseRacingsStats/__racing_filter_hippodrome.php");
        ?>
        <?php
            require_once("./views/member/horseRacingsStats/__racing_filter_tipster.php");
        ?>
        <div class="btn-zone h-80 flex-col flex-center">
            <button id="btn-valid-filter" type="submit" class="btn-form h-40">Enregistrer</button>
        </div>
    </form>
</div>
<?php 
    if(count($finalResults)>0){
        if($_SESSION['racingStats']['page']=="simplesGames"){
            require_once("./views/member/horseRacingsStats/__viewStats_simple.php");
        }
        if($_SESSION['racingStats']['page']=="couplesGames"){
            require_once("./views/member/horseRacingsStats/__viewStats_couple.php");
        }
        if($oneTipster)
        {
            require_once("./views/member/horseRacingsStats/__viewStats_viewTips.php");
        }
    }
    error_log('MEM AVANT : ' . (memory_get_usage(true) / 1024 / 1024) . ' MB');
    $pageContent=ob_get_clean();
    error_log('MEM APRES : ' . (memory_get_usage(true) / 1024 / 1024) . ' MB');

    require_once("./views/member/horseRacingsStats/racingStats_mainTemplate.php");
?>
