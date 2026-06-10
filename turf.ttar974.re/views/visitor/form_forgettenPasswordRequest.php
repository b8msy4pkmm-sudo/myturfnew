<?php
use MAIN_NAMESPACE\utilities\form\Form;
?>
<div class="space-login">
    <div class="dialog-box">
        <h1 class="form-title">Mot de passe oublié ?</h1>
        <form action="<?= URL ?>formForgettenPasswordValidated" method="POST">
        <div class="group-fields group-fields_input h-80 flex-col flex-center">
            <?php $inputClass="fields fields-input";?> 
            <?php $inputType="email";?> 
            <?php $inputName="email";?> 
            <label class="label" for="email">Votre email</label>
            <?= Form::createInput($inputClass, $inputType, $inputName, ($_POST['email']??""),'', 'required');?>
        </div>
        <div class="btn-zone h-80 flex-col flex-center">
            <button type="submit" class="btn-form h-40">Se connecter</button>
        </div>
        </form>
        <p class="signMeIn">Je me souviens de mont de passe, <a href="<?=URL?>formForLoginUserSession">Se connecter</a></p>
    </div>
</div>


