<?php
use MAIN_NAMESPACE\utilities\form\Form;
?>
<div id="dialog-box-pwd-account" class="dialog-box display-none">
    <h1 class="form-title">Nouveau mot de passe</h1>
    <form action="<?= URL ?>memberSession/modifyMemberPassword" method="POST">
    <div class="group-fields h-80 flex-col flex-center">
        <?php $inputClass="fields fields-input";?> 
        <?php $inputType="password";?> 
        <?php $inputName="newPassword";?> 
        <label class="label" for="newPassord">Nouveau mot de passe<i> (caractères > 6)</i></label>
        <?= Form::createInput($inputClass, $inputType, $inputName, ($_POST['newPassword'])??"",'', 'required');?>
    </div>
    <div class="group-fields h-80 flex-col flex-center">
        <?php $inputClass="fields fields-input";?> 
        <?php $inputType="password";?> 
        <?php $inputName="newPasswordConfirm";?> 
        <label class="label" for="newPassordConfirm">Confirme le nouveau mot de passe</label>
        <?= Form::createInput($inputClass, $inputType, $inputName, ($_POST['newPasswordConfirm'])??"",'', 'required');?>
    </div>

    <div class="btn-zone h-80 flex-col flex-center">
        <button type="submit" class="btn-form h-40">Valider</button>
    </div>
    </form>
    <p class="signMeIn">Je me souviens du mot de passe, <a href="<?=URL?>memberSession/profilMember">Annuler</a></p>
</div>


