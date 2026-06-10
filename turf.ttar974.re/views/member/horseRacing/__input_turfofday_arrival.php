<?php
use MAIN_NAMESPACE\utilities\form\Form;
$chx=[];
for ($i=0; $i < 5; $i++) { 
    $ch="ch".$i+1;
    if (isset($_SESSION['horseRacing'][$ch]))array_push($chx,$_SESSION['horseRacing'][$ch]);
}
$page=($_SESSION['horseRacing']['page']==="simulRaceFinish")?"raceFinishSimul":"raceFinish"
?>
<h2><?=($_SESSION['horseRacing']['page']==="simulRaceFinish")?"Votre pronostic d'arrivée":"Arrivée officielle";?></h2>
<form action="<?= URL;?>memberSession/raceHorse/updateHorseRacing/<?= $page;?>" method="POST">
    <div class="turfOfDay-race-arrival">
        <?php for($i=1 ; $i<6 ; $i++) :?>
            <div class="turfOfDay-input-arrival">
                <div class="group-fields border-none flex-col flex-center">
                    <?php $inputClass="fields fields-input";?> 
                    <?php $inputType="number";?> 
                    <?php $inputName="ch".$i;?> 
                    <label class="label" for="ch<?=$i;?>">ch<?= $i;?></label>
                    <?= Form::createInput($inputClass, $inputType, $inputName,$chx[$i-1]??"",'0', ($_SESSION['horseRacing']['page']==="simulRaceFinish")?'':'required');?>
                </div>
            </div>
        <?php endfor ?>
        <div class="btn-zone h-80 flex-col flex-center">
            <button type="submit" class="btn-form h-40">
                <?=($_SESSION['horseRacing']['page']==="simulRaceFinish")?"Valider":"Enregistrer";?>
            </button>
        </div>
    </div>
</form>