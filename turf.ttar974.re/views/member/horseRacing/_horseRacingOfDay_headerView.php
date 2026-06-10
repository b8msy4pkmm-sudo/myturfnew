<div class="turfOfDay-result">
    <?php if($raceOfDay):?>
        <div class="flex-row flex-center">
        <p class="flex-row flex-center flex-item-center tips_final">Arrivée </p>
            <?php for ($i=1; $i < 6; $i++) : ?>
                <?php $ch="arrivee_ch".$i; ?>
                <p class="tips colorCh<?= $i;?>"><?= $raceOfDay[$ch]; ?>
            <?php endfor ?>
        </p>
        <div class="turfOfDay-result_img flex-row flex-center">
        <img src="<?= URL?>public/pictures/lookresults.svg" alt="résultats du Quinté" title="détail gains">
        </div>
        </div> 
        <div class="flex-row flex-center flex-item-center h-40">
            <small><i>
                <?= $nameHippodromeOfDay['hippodrome']." - R".$raceOfDay['numero_reunion']."C".$raceOfDay['numero_course']." - ".$raceOfDay['type_course']." - ".$raceOfDay['distance_course']."m"?>
            </i></small>
        </div> 
        <?php 
        require_once("./views/member/horseRacing/__table_turfofday_winnings.php");
        ?>
    <?php endif ?> 
</div>