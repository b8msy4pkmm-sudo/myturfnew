<?php
use MAIN_NAMESPACE\utilities\form\Form;
$date_start = $_SESSION['horseRacingsDate']['dateStart'] -> format('Y-m-d');
$date_end   = $_SESSION['horseRacingsDate']['dateEnd']   -> format('Y-m-d');
?>

<div class=" flex-row group-stat-period">
    <div class="group-fields group-fields_input flex-col flex-center margin-none stat-period">
        <?php $inputClass="fields fields-input";?> 
        <?php $inputType="date";?> 
        <?php $inputName="date_start";?> 
        <label class="label" for="date_start">Du</label>
        <?= Form::createInput($inputClass, $inputType, $inputName,$date_start,'', 'onchange="submit()"');?>
    </div>
    <div class="group-fields group-fields_input flex-col flex-center margin-none stat-period">
        <?php $inputClass="fields fields-input";?> 
        <?php $inputType="date";?> 
        <?php $inputName="date_end";?> 
        <label class="label" for="date_end">Au</label>
        <?= Form::createInput($inputClass, $inputType, $inputName,$date_end,'', 'onchange="submit()"');?>
    </div>
</div>
