<?php
use MAIN_NAMESPACE\utilities\form\Form;
//$date               = ($_SESSION['rac']['date'])??$_SESSION['quinte']['date'];
$sg   = ($_SESSION['horseRacing']['sg'])??"";
$zs   = ($_SESSION['horseRacing']['zs'])??"";
$zc   = ($_SESSION['horseRacing']['zc'])??"";
$jg   = ($_SESSION['horseRacing']['jg'])??"";
$jgo  = ($_SESSION['horseRacing']['jgo'])??"";
$ze24 = ($_SESSION['horseRacing']['ze24'])??"";

$spx=[];
for ($i=0; $i < 5; $i++) { 
    $sp="sp".$i+1;
    if (isset($_SESSION['horseRacing'][$sp])) array_push($spx,$_SESSION['horseRacing'][$sp]);
}
?>

<h2>Rapports</h2>
<form action="<?= URL ?>memberSession/raceHorse/updateHorseRacing/raceWinnings" method="POST">
    <div class="turfOfDay-race-winnings">
        <div class="turfOfDay-input-winnings">
            <div class="group-fields group-fields_input border-none flex-col flex-center">
                <?php $inputClass="fields fields-input";?> 
                <?php $inputType="text";?> 
                <?php $inputName="sg";?> 
                <label class="label" for="sg">SG</label>
                <?= Form::createInput($inputClass, $inputType, $inputName,$sg,'0.00', '');?>
            </div>
        </div>
        <div class="turfOfDay-input-winnings">
            <div class="group-fields group-fields_input border-none flex-col flex-center">
                <?php $inputClass="fields fields-input";?> 
                <?php $inputType="text";?> 
                <?php $inputName="zs";?> 
                <label class="label" for="zs">ZS</label>
                <?= Form::createInput($inputClass, $inputType, $inputName,$zs,'0.00', '');?>
            </div>
        </div> 
        <div class="turfOfDay-input-winnings">
            <div class="group-fields group-fields_input border-none flex-col flex-center">
                <?php $inputClass="fields fields-input";?> 
                <?php $inputType="text";?> 
                <?php $inputName="zc";?> 
                <label class="label" for="zc">ZC</label>
                <?= Form::createInput($inputClass, $inputType, $inputName,$zc,'0.00', '');?>
            </div>
        </div>
        <?php for ($i=1; $i < 4; $i++):?>
            <div class="turfOfDay-input-winnings">
                <div class="group-fields group-fields_input border-none flex-col flex-center">
                    <?php $inputClass="fields fields-input";?> 
                    <?php $inputType="text";?> 
                    <?php $inputName="sp".$i;?> 
                    <label class="label" for="sp<?=$i;?>">SP<?=$i;?></label>
                    <?= Form::createInput($inputClass, $inputType, $inputName,$spx[$i-1]??"",'0.00', '');?>
                </div>
            </div>
        <?php endfor?>
        <div class="turfOfDay-input-winnings">
            <div class="group-fields group-fields_input border-none flex-col flex-center">
                <?php $inputClass="fields fields-input";?> 
                <?php $inputType="text";?> 
                <?php $inputName="jg";?> 
                <label class="label" for="jg">CG</label>
                <?= Form::createInput($inputClass, $inputType, $inputName,$jg,'0.00', '');?>
            </div>
        </div>
        <div class="turfOfDay-input-winnings">
            <div class="group-fields group-fields_input border-none flex-col flex-center">
                <?php $inputClass="fields fields-input";?> 
                <?php $inputType="text";?> 
                <?php $inputName="jgo";?> 
                <label class="label" for="jgo">CG Ordre</label>
                <?= Form::createInput($inputClass, $inputType, $inputName,$jgo,'0.00', '');?>
            </div> 
        </div>
        <div class="turfOfDay-input-winnings">
            <div class="group-fields group-fields_input border-none flex-col flex-center">
                <?php $inputClass="fields fields-input";?> 
                <?php $inputType="text";?> 
                <?php $inputName="ze24";?> 
                <label class="label" for="ze24">2 Sur 4</label>
                <?= Form::createInput($inputClass, $inputType, $inputName,$ze24,'0.00', '');?>
            </div>
        </div>
    </div>
    <div class="btn-zone h-80 flex-col flex-center">
        <button type="submit" class="btn-form h-40">Enregistrer</button>
    </div>
</form>
