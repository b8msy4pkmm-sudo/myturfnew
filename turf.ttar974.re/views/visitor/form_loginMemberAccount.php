<?php
    use MAIN_NAMESPACE\utilities\form\Form;
    use MAIN_NAMESPACE\utilities\security\Security;
?>
<div class="space-login">
    <div class="dialog-box">
        <h1 class="form-title">Déjà membre</h1>
        <form action="<?= URL ?>CheckUserIdentification" method="POST">
        <div class="group-fields group-fields_input h-80 flex-col flex-center">
            <?php $inputClass="fields fields-input";?> 
            <?php $inputType="text";?> 
            <?php $inputName="pseudo";?> 
            <label class="label" for="pseudo">Pseudo</label>
            <?= Form::createInput($inputClass, $inputType, $inputName, ($_POST['pseudo']??""),'', 'required');?>
        </div>
        <div class="group-fields group-fields_input h-80 flex-col flex-center">
            <label class="label" for="password">Mot de passe</label>
            <?php $inputClass="fields fields-input"?> 
            <?php $inputType="password";?>
            <?php $inputName="password";?>
            <?= Form::createInput($inputClass, $inputType, $inputName, ($_POST['password']??""),'', 'required');?>
        </div>
        <p class="forgetten-pwd"><small><a href="<?=URL?>formForgettenPassword">Mot de passe oublié ?</a></small></p>
        <div class="group-fields h-80 flex-col flex-center">
            <span class="label">rester connecté</span>
            <?php $classUl=""?>
            <?php $classLi="li-horizontal"?>
            <?php $checkboxName="sessionTime"?>
            <?php $statut=($statut)??[];?>
            <div class="fields flex-col flex-center">
                <?= Form::createCheckboxList($classUl,$classLi,$checkboxName,$statut,[8],[' pendant 8 heures']);?>
            </div> 
        </div>
        <div class="btn-zone h-80 flex-col flex-center">
            <button type="submit" class="btn-form h-40">Se connecter</button>
        </div>
        </form>
        <p class="signMeIn">Pas encore membre, <a href="<?=URL?>formForCreateUserAccount">inscrivez-vous</a></p>
    </div>
    <div>
    <p><pre><?php //print_r($_COOKIE[Security::COOKIE_NAME]??"pas de cookies en cours") ?></pre></hp>
    <!-- <p><?= Security::userSessionActive()?"session active":"session non active"; ?></p> -->
    <p><?php //Security::cookie?"cookie actif":"cookie non actif"; ?></p>
    </div>
</div>
