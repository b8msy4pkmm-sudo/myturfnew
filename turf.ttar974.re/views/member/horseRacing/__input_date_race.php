<?php
use MAIN_NAMESPACE\utilities\form\Form;
$date = (($_SESSION['horseRacingsDate']['date'])->format('Y-m-d'))??(new dateTime)->format('Y-m-d');
?>
<div class="group-fields group-fields_input h-40 flex-col flex-center margin-none card-input">
    <?php $inputClass="fields fields-input";?> 
    <?php $inputType="date";?> 
    <?php $inputName="date";?> 
    <label class="label display-none" for="date">Date <i>(Autres dates)</i></label>
    <?= Form::createInput($inputClass, $inputType, $inputName,$date,'', 'onchange="submit()"');?>
</div>