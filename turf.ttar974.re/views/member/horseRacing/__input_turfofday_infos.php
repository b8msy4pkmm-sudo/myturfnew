<?php
use MAIN_NAMESPACE\utilities\form\Form;
$meetingNumber      = ($_SESSION['horseRacing']['meetingNumber'])??1;
$raceNumber         = ($_SESSION['horseRacing']['raceNumber'])??"";
$raceLength         = ($_SESSION['horseRacing']['raceLength'])??"";
$raceTypeSelected   = ($_SESSION['horseRacing']['raceType'])??"";
$hippodromeSelected = ($_SESSION['horseRacing']['hippodrome'])??"";
$raceType=RACE_TYPE;
$indexHippodromesList=[];
$hippodromesNameList=[];
foreach ($allHippodromes as $hippodrome) {
    array_push($indexHippodromesList,$hippodrome['index_hippodrome']);
    array_push($hippodromesNameList,$hippodrome['hippodrome']);
}
?>
<h2>Info courses</h2>
<div class="turfofday-race-infos">
    <form action="<?= URL ?>memberSession/raceHorse/updateHorseRacing/raceInfos" method="POST">
        <div class="group-fields group-fields_input border-none flex-col flex-center">
            <?php $inputClass="fields fields-input";?> 
            <?php $inputType="number";?> 
            <?php $inputName="meetingNumber";?> 
            <label class="label" for="meetingNumber">Réunion</label>
            <?= Form::createInput($inputClass, $inputType, $inputName,$meetingNumber,'', 'required');?>
        </div>
        <div class="group-fields group-fields_input border-none flex-col flex-center">
            <?php $inputClass="fields fields-input";?> 
            <?php $inputType="number";?> 
            <?php $inputName="raceNumber";?> 
            <label class="label" for="raceNumber">Course</label>
            <?= Form::createInput($inputClass, $inputType, $inputName,$raceNumber,'', 'required');?>
        </div>  
        <div class="group-fields group-fields_input border-none flex-col flex-center">
            <?php $inputClass="fields fields-input";?> 
            <?php $inputType="number";?> 
            <?php $inputName="raceLength";?> 
            <label class="label" for="raceLength">Distance</label>
            <?= Form::createInput($inputClass, $inputType, $inputName,$raceLength,'', 'required');?>
        </div>
        <div class="group-fields group-fields_select border-none flex-col flex-center">
            <label class="label" for="userPseudo">Hippodrome</label>
            <?php $selectClass="fields fields-select"?>
            <?php $selectName="hippodrome"?>
            <?= Form::createSelect($selectClass,$selectName,$hippodromeSelected,$indexHippodromesList,$hippodromesNameList,"");?>
        </div>
        <div class="group-fields group-fields_select border-none flex-col flex-center">
            <label class="label" for="userPseudo">Type</label>
            <?php $selectClass="fields fields-select"?>
            <?php $selectName="raceType"?>
            <?= Form::createSelect($selectClass,$selectName,$raceTypeSelected,$raceType,$raceType,"");?>
        </div>
        <div class="btn-zone h-80 flex-col flex-center">
            <button type="submit" class="btn-form h-40">Enregistrer</button>
        </div>
    </form>
</div>