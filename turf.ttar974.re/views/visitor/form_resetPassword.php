<?php
use MAIN_NAMESPACE\utilities\form\Form;
?>
<div class="space-login">
    <div class="dialog-box">
        <h1 class="form-title">Nouveau Mot de passe</h1>
        <form action="<?= URL ?>validateNewPassword" method="POST">
        <div class="group-fields group-fields_input h-80 flex-col flex-center">
            <?php $inputClass="fields fields-input";?> 
            <?php $inputType="password";?> 
            <?php $inputName="newPassword";?> 
            <label class="label" for="newPassord">Nouveau mot de passe<i> (caractères > 6)</i></label>
            <?= Form::createInput($inputClass, $inputType, $inputName, ($_POST['newPassword'])??"",'', 'required');?>
        </div>
        <div class="group-fields group-fields_input h-80 flex-col flex-center">
            <?php $inputClass="fields fields-input";?> 
            <?php $inputType="text";?> 
            <?php $inputName="email";?> 
            <label class="label" for="email">Votre email</label>
            <?= Form::createInput($inputClass, $inputType, $inputName, ($_POST['email'])??"",'', 'required');?>
        </div>
        <div class="group-fields group-fields_input h-80 flex-col flex-center">
            <?php $inputClass="fields fields-input";?> 
            <?php $inputType="text";?> 
            <?php $inputName="secret_key";?> 
            <label class="label" for="secret_key">Code reçu par email</label>
            <?= Form::createInput($inputClass, $inputType, $inputName, ($_POST['secret_key'])??"",'', 'required');?>
        </div>
        <div class="btn-zone h-80 flex-col flex-center">
            <button type="submit" class="btn-form h-40">Se connecter</button>
        </div>
        </form>
        <p class="signMeIn">J'ai retrouvé mon mot de passe, <a href="<?=URL?>formForLoginUserSession">Se connecter</a></p>
    </div>
</div>