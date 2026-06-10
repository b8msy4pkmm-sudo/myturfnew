<?php
    use MAIN_NAMESPACE\utilities\form\Form;
    $genderSelected??1;
?>
<div class="dialog-box">
    <h1 class="form-title">Nouveau membre</h1>
    <form action="<?= URL ?>ValideNewMemberAccount" method="POST">
    <div class="group-fields group-fields_input h-80 flex-col flex-center">
        <?php $inputClass="fields fields-input";?> 
        <?php $inputType="text";?> 
        <?php $inputName="pseudo";?> 
        <label class="label" for="pseudo">Pseudo <i>(4 caractères minimum)</i></label>
        <?= Form::createInput($inputClass, $inputType, $inputName,($_POST['pseudo']??""),'', 'required');?>
    </div>
    <div class="group-fields group-fields_input h-80 flex-col flex-center">
        <?php $inputClass="fields fields-input";?> 
        <?php $inputType="text";?> 
        <?php $inputName="username";?> 
        <label class="label" for="username">Prénom</label>
        <?= Form::createInput($inputClass, $inputType, $inputName, ($_POST['username']??""),'', 'required');?>
    </div>
    <div class="group-fields group-fields_input h-80 flex-col flex-center">
        <?php $inputClass="fields fields-input";?> 
        <?php $inputType="text";?> 
        <?php $inputName="lastname";?> 
        <label class="label" for="lastname">Nom</label>
        <?= Form::createInput($inputClass, $inputType, $inputName, ($_POST['lastname']??""),'', 'required');?>
    </div>

    <div class="group-fields group-fields_radio border-none flex-col">
        <span class="label">Vous êtes</span>                     
        <?php $classUl=""?>
        <?php $classLi="li-horizontal li-label"?>
        <?php $radioName="gender"?>
        <div class="fields fields-checkbox">
            <?php $genderSelected=($_POST['gender'])??1;?>
            <?= Form::createRadioList($classUl,$classLi,$radioName,$genderSelected,[1,0],['un Homme','une Femme']);?>
        </div> 
    </div>
    
    <div class="group-fields group-fields_input h-80 flex-col flex-center">
        <label class="label" for="password">Mot de passe</label>
        <?php $inputClass="fields fields-input"?> 
        <?php $inputType="password";?>
        <?php $inputName="password";?>
        <?= Form::createInput($inputClass, $inputType, $inputName, ($_POST['password']??""),'', 'required');?>
    </div>
    <div class="group-fields group-fields_input h-80 flex-col flex-center">
        <label class="label" for="password">Confirmer votre mot de passe</label>
        <?php $inputClass="fields fields-input"?> 
        <?php $inputType="password";?>
        <?php $inputName="passwordConfirm";?>
        <?= Form::createInput($inputClass, $inputType, $inputName, ($_POST['passwordConfirm']??""),'', 'required');?>
    </div>
    <div class="group-fields group-fields_input h-80 flex-col flex-center">
        <label class="label" for="password">Email</label>
        <?php $inputClass="fields fields-input"?> 
        <?php $inputType="email";?>
        <?php $inputName="email";?>
        <?= Form::createInput($inputClass, $inputType, $inputName, ($_POST['email']??""),'', 'required');?>
    </div>
    <div class="group-fields group-fields_input h-80 flex-col flex-center">
        <label class="label" for="password">Confirmer votre email</label>
        <?php $inputClass="fields fields-input"?> 
        <?php $inputType="email";?>
        <?php $inputName="emailConfirm";?>
        <?= Form::createInput($inputClass, $inputType, $inputName, ($_POST['emailConfirm']??""),'', 'required');?>
    </div>
    <div class="btn-zone h-80 flex-col flex-center">
        <button type="submit" class="btn-form h-40">S'enregister</button>
    </div>
    </form>
    <p class="signMeIn">Je suis déjà membre, <a href="<?=URL?>formForLoginUserSession">Se connecter</a></p>
</div>
