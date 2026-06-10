<?php
use MAIN_NAMESPACE\utilities\form\Form;
//$date               = ($_SESSION['rac']['date'])??$_SESSION['quinte']['date'];
$meetingNumber      = ($_SESSION['horseRacing']['meetingNumber'])??1;
$raceNumber         = ($_SESSION['horseRacing']['raceNumber'])??"";
$raceLength         = ($_SESSION['horseRacing']['raceLength'])??"";
$raceTypeSelected   = ($_SESSION['horseRacing']['raceType'])??"";
$hippodromeSelected = ($_SESSION['horseRacing']['hippodrome'])??"";
$sg  = ($_SESSION['quinte']['sg'])??"";
$zs  = ($_SESSION['quinte']['zs'])??"";
$zc  = ($_SESSION['quinte']['zc'])??"";
$jg  = ($_SESSION['quinte']['jg'])??"";
$jgo = ($_SESSION['quinte']['jgo'])??"";
$ze24 = ($_SESSION['quinte']['ze24'])??"";

$chx=[];
for ($i=0; $i < 5; $i++) { 
    $ch="ch".$i+1;
    if (isset($_SESSION['horseRacing'][$ch]))array_push($chx,$_SESSION['horseRacing'][$ch]);
}

$spx=[];
for ($i=0; $i < 4; $i++) { 
    $sp="sp".$i+1;
    if (isset($_SESSION['horseRacing'][$sp]))array_push($chx,$_SESSION['horseRacing'][$sp]);
}

?>
<h2>Info courses</h2>
<div class="turfofday-race-infos">
    <div class="group-fields border-none flex-col flex-center">
        <?php $inputClass="fields fields-input";?> 
        <?php $inputType="number";?> 
        <?php $inputName="meetingNumber";?> 
        <label class="label" for="meetingNumber">Réunion</label>
        <?= Form::createInput($inputClass, $inputType, $inputName,$meetingNumber,'', 'required');?>
    </div>
    <div class="group-fields border-none flex-col flex-center">
        <?php $inputClass="fields fields-input";?> 
        <?php $inputType="number";?> 
        <?php $inputName="raceNumber";?> 
        <label class="label" for="raceNumber">Course</label>
        <?= Form::createInput($inputClass, $inputType, $inputName,$raceNumber,'', 'required');?>
    </div>  
    <div class="group-fields  border-none flex-col flex-center">
        <?php $inputClass="fields fields-input";?> 
        <?php $inputType="number";?> 
        <?php $inputName="raceLength";?> 
        <label class="label" for="raceLength">Distance</label>
        <?= Form::createInput($inputClass, $inputType, $inputName,$raceLength,'', 'required');?>
    </div>
    <div class="group-fields border-none flex-col flex-center">
        <label class="label" for="userPseudo">Hippodrome</label>
        <?php $selectClass="fields fields-select"?>
        <?php $selectName="hippodrome"?>
        <?= Form::createSelect($selectClass,$selectName,$hippodromeSelected,$indexHippodromesList,$hippodromesNameList,"");?>
    </div>
    <div class="group-fields border-none flex-col flex-center">
        <label class="label" for="userPseudo">Type</label>
        <?php $selectClass="fields fields-select"?>
        <?php $selectName="raceType"?>
        <?= Form::createSelect($selectClass,$selectName,$raceTypeSelected,$raceType,$raceType,"");?>
    </div>
</div>
<h2>Arrivée</h2>
<div class="turfofday_raceInfos">
    <?php for($i=1 ; $i<6 ; $i++) :?>
        <div class="group-fields border-none flex-col flex-center">
            <?php $inputClass="fields fields-input";?> 
            <?php $inputType="number";?> 
            <?php $inputName="ch".$i;?> 
            <label class="label" for="ch<?=$i;?>">ch<?= $i;?></label>
            <?= Form::createInput($inputClass, $inputType, $inputName,$chx[$i-1]??"",'', '');?>
        </div>
    <?php endfor ?>
</div>
<h2>Rapports</h2>
<div class="turfofday_raceInfos">
    <div class="group-fields border-none flex-col flex-center">
        <?php $inputClass="fields fields-input";?> 
        <?php $inputType="text";?> 
        <?php $inputName="sg";?> 
        <label class="label" for="sg">SG</label>
        <?= Form::createInput($inputClass, $inputType, $inputName,$sg,'', '');?>
    </div>
    <div class="group-fields border-none flex-col flex-center">
        <?php $inputClass="fields fields-input";?> 
        <?php $inputType="text";?> 
        <?php $inputName="zs";?> 
        <label class="label" for="zs">ZS</label>
        <?= Form::createInput($inputClass, $inputType, $inputName,$zs,'', '');?>
    </div>  
    <div class="group-fields border-none flex-col flex-center">
        <?php $inputClass="fields fields-input";?> 
        <?php $inputType="text";?> 
        <?php $inputName="zc";?> 
        <label class="label" for="zc">ZC</label>
        <?= Form::createInput($inputClass, $inputType, $inputName,$zc,'', '');?>
    </div>
    <?php for ($i=1; $i < 4; $i++):?>
    <div class="group-fields border-none flex-col flex-center">
        <?php $inputClass="fields fields-input";?> 
        <?php $inputType="text";?> 
        <?php $inputName="sp".$i;?> 
        <label class="label" for="sp<?=$i;?>">SP<?=$i;?></label>
        <?= Form::createInput($inputClass, $inputType, $inputName,$spx[$i-1]??"",'', '');?>
    </div>
    <?php endfor?>
    <div class="group-fields border-none flex-col flex-center">
        <?php $inputClass="fields fields-input";?> 
        <?php $inputType="text";?> 
        <?php $inputName="jg";?> 
        <label class="label" for="jg">CG</label>
        <?= Form::createInput($inputClass, $inputType, $inputName,$jg,'', '');?>
    </div>
    <div class="group-fields border-none flex-col flex-center">
        <?php $inputClass="fields fields-input";?> 
        <?php $inputType="text";?> 
        <?php $inputName="jgo";?> 
        <label class="label" for="jgo">CG Ordre</label>
        <?= Form::createInput($inputClass, $inputType, $inputName,$jgo,'', '');?>
    </div> 
    <div class="group-fields border-none flex-col flex-center">
        <?php $inputClass="fields fields-input";?> 
        <?php $inputType="text";?> 
        <?php $inputName="ze24";?> 
        <label class="label" for="ze24">2 Sur 4</label>
        <?= Form::createInput($inputClass, $inputType, $inputName,$ze24,'', '');?>
    </div>
</div>