<?php
use MAIN_NAMESPACE\utilities\form\Form;
const ONE_SELECTED=[1];
const ALL_SELECT=['Choisir'];
const ALL_TRACKLENGTH=['Définir'];
$indexHippodromesList=[];
$hippodromesNameList=[];
foreach ($allHippodromes as $hippodrome) {
    array_push($indexHippodromesList,$hippodrome['index_hippodrome']);
    array_push($hippodromesNameList,$hippodrome['hippodrome']);
}
$hippodromeSelected  = ($_SESSION['racingStats']['hippodrome'])??$indexHippodromesList;
$allHippoSelected    = ($_SESSION['racingStats']['toggleSelectedHippodromes'])??[0];
$trackLegnthSelected = ($_SESSION['racingStats']['toggleSelectedTrackLength'])??[0];
$min_length=($_SESSION['racingStats']['min_length']??"");
$max_length=($_SESSION['racingStats']['max_length']??"");
$raceTypeStatus=RACE_TYPE;
$raceTypeDesignation=RACE_TYPE;
$raceTypeSelected=$_SESSION['racingStats']['raceType']??RACE_TYPE;
?>

<div class="toggleSelectHippo">
    <div id="toggleSelectHippo" class="group-fields group-fields_checkbox border-none flex-col flex-between">
        <span class="label">Sélection Hippodromes</span>
        <?php $classUl=""?>
        <?php $classLi="li-vertical li-label"?>
        <?php $radioName="toggleSelectedHippodromes"?>
        <div class="fields fields-checkbox">
            <?= Form::createCheckboxList($classUl,$classLi,$radioName,$allHippoSelected,ONE_SELECTED,ALL_SELECT);?>
        </div> 
    </div>
</div>
<div id="selectHippo" class="group-fields group-fields_checkbox border-none flex-col flex-between">
    <!-- <span class="label">Sélection hippodrome</span> -->
    <?php $classUl=""?>
    <?php $classLi="li-vertical li-label li-hippodromes"?>
    <?php $radioName="hippodrome"?>
    <div class="fields fields-checkbox">
        <?= Form::createCheckboxList($classUl,$classLi,$radioName,$hippodromeSelected,$indexHippodromesList,$hippodromesNameList);?>  
    </div> 
</div>
<div class="selectRaceType">
    <div id="selectRaceType" class="group-fields group-fields_checkbox border-none flex-col flex-between">
        <span class="label">Sélection type de course</span>
        <?php $classUl=""?>
        <?php $classLi="li-horizontal li-label"?>
        <?php $radioName="raceType"?>
        <div class="fields fields-checkbox">
            <?= Form::createCheckboxList($classUl,$classLi,$radioName,$raceTypeSelected,$raceTypeStatus,$raceTypeDesignation);?>
        </div> 
    </div>
</div>

<div class="selectTrackLength flex-row flex-gap-10">
    <div id="toggleSelectLength" class="group-fields group-fields_checkbox border-none flex-col flex-between">
        <span class="label">Distance piste</span>
        <?php $classUl=""?>
        <?php $classLi="li-vertical li-label"?>
        <?php $radioName="toggleSelectedTrackLength"?>
        <div class="fields fields-checkbox">
            <?= Form::createCheckboxList($classUl,$classLi,$radioName,$trackLegnthSelected,ONE_SELECTED,ALL_TRACKLENGTH);?>
        </div> 
    </div>
    <div class="trackLengthSeleted flex-row flex-item-center flex-gap-10">
        <div id="length_min" class="group-fields group-fields_input flex-col flex-center margin-none bg-none border-none">
            <?php $inputClass="fields fields-input";?> 
            <?php $inputType="number";?> 
            <?php $inputName="min_length";?> 
            <label class="label" for="min_length">De</label>
            <?= Form::createInput($inputClass, $inputType, $inputName,$min_length,'0', 'readonly');?>
        </div>
        <div id="length_max" class="group-fields group-fields_input flex-col flex-center margin-none bg-none border-none">
            <?php $inputClass="fields fields-input";?> 
            <?php $inputType="number";?> 
            <?php $inputName="max_length";?> 
            <label class="label" for="max_length">A</label>
            <?= Form::createInput($inputClass, $inputType, $inputName,$max_length,'0', 'readonly');?>
        </div>
    </div>
</div>
