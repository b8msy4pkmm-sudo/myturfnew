<?php
use MAIN_NAMESPACE\utilities\form\Form;
$indexTipstersList=[];
$tipstersNameList=[];
foreach ($allTipsters as $tipster) {
    array_push($indexTipstersList,$tipster['index_pronostiqueur']);
    array_push($tipstersNameList,$tipster['pronostiqueur']);
}
$tipsterSelected = ($_SESSION['racingStats']['tipster'])??$indexTipstersList;
$allTipstersSelected=($_POST['toggleSelectedTipsters'])??[0];
$min_length=($_POST['min_length']??0);
$max_length=($_POST['max_length']??0);
?>
<div class="toggleSelectTipster">
    <div id="toggleSelectTipster" class="group-fields group-fields_checkbox border-none flex-col flex-between">
        <span class="label">Sélection Pronostiqueurs</span>
        <?php $classUl=""?>
        <?php $classLi="li-vertical li-label"?>
        <?php $radioName="toggleSelectedTipsters"?>
        <div class="fields fields-checkbox">
            <?= Form::createCheckboxList($classUl,$classLi,$radioName,$allTipstersSelected,ONE_SELECTED,ALL_SELECT);?>
        </div> 
    </div>
</div>
<div id="selectTipster" class="group-fields group-fields_checkbox border-none flex-col flex-between">
    <!-- <span class="label">Sélection hippodrome</span> -->
    <?php $classUl=""?>
    <?php $classLi="li-vertical li-label li-tipsters"?>
    <?php $radioName="tipster"?>
    <div class="fields fields-checkbox">
        <?= Form::createCheckboxList($classUl,$classLi,$radioName,$tipsterSelected,$indexTipstersList,$tipstersNameList);?>  
    </div> 
</div>
