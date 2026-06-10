<?php
use MAIN_NAMESPACE\utilities\form\Form;
use MAIN_NAMESPACE\utilities\toolbox\Toolbox;

if(!isset($_SESSION['tipsterSelected']))$_SESSION['tipsterSelected']="P1";
$chx=[];

if (count($_SESSION['forecastOfTipsterSelected']??[])<1)
{
    Toolbox::addMessageAlert("Pas de pronostic enregistré",Toolbox::COLOR_DANGER);
    $_SESSION['tipsterForecast']="insert";
}else{
    $_SESSION['tipsterForecast']="update";
}

for ($i=0; $i < 8; $i++) { 
    $ch="ch".$i+1;
    array_push($chx,$_SESSION['forecastOfTipsterSelected'][$ch]??"");
}

$tipsterSelected = $_SESSION['tipsterSelected'];
$indexTipstersList=[];
$tipstersNameList=[];
foreach ($tipsters as $tipster) {
    array_push($indexTipstersList,$tipster['index_pronostiqueur']);
    array_push($tipstersNameList,$tipster['pronostiqueur']);
}

?>
<h2>Pronostiqueur</h2>
<form action="<?= URL ?>memberSession/raceHorse/updateHorseRacing/raceTipster" method="POST">
    <div id='selectTipster' class="group-fields group-fields_select vborder-none flex-col flex-center">
        <label class="label" for="userPseudo">Sélectionner un pronostiqueur</label>
        <?php $selectClass="fields fields-select"?>
        <?php $selectName="tipster"?>
        <?= Form::createSelect($selectClass,$selectName,$tipsterSelected,$indexTipstersList,$tipstersNameList,'onchange="submit()"');?>
    </div>
    <div id="forecasts" class="turfOfDay-race-arrival">
        <?php for($i=1 ; $i<9 ; $i++) :?>
        <div class="turfOfDay-input-arrival">
            <div class="group-fields group-fields_input border-none flex-col flex-center">
                <?php $inputClass="fields fields-input";?> 
                <?php $inputType="number";?> 
                <?php $inputName="ch".$i;?> 
                <label class="label" for="ch<?=$i;?>">ch<?= $i;?></label>
                <?= Form::createInput($inputClass, $inputType, $inputName,$chx[$i-1]??"",'0', 'required');?>
            </div>
        </div>
        <?php endfor ?>
        <div id="btn-tips" class="btn-zone h-80 flex-col flex-center">
            <button type="submit" class="btn-form h-40">
                <?= (count($_SESSION['forecastOfTipsterSelected']??[])<1)?"Enregistrer":"Modifier" ?>
            </button>
        </div>
    </div>
</form>

<?php if (count($missingForecasts)) :?>
    <h3 class="txt-align-center">Pronostics manquant pour :</h3>
    <?php for ($i=0 ; $i < count($missingForecasts) ; $i++) :?>
        <div class="flex-col flex-center h-40 p-15">
            <p><?= $missingForecasts[$i]; ?></p>
        </div>
    <?php endfor?>
<?php endif ?>
