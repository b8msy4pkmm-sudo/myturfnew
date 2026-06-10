<?php
use MAIN_NAMESPACE\utilities\form\Form;

$pseudo   = ($userDatas['pseudo'])??'';
$username = ($userDatas['username'])??'';
$lastname = ($userDatas['lastname'])??'';
$email    = ($userDatas['email'])??'';

(isset($_POST['pseudo']) && $_POST['pseudo']!==$userDatas['pseudo'])?$_POST['pseudo']=$userDatas['pseudo']:'';
(isset($_POST['email']) && $_POST['email']!==$userDatas['email'])?$_POST['email']=$userDatas['email']:'';

?>

<div id="dialog-box-profil-account" class="dialog-box bg-none">
    <h1 class="form-title title-black">Mes informations</h1>
    <form action="<?= URL ?>memberSession/modifyProfilMember" method="POST">
        <div class="group-fields h-80 bg-transparent border-none flex-col flex-center">
        <?php $inputClass="fields fields-input";?> 
        <?php $inputType="text";?> 
        <?php $inputName="pseudo";?> 
        <label class="label" for="pseudo">Pseudo <i>(4 caractères minimum)</i></label>
        <?= Form::createInput($inputClass, $inputType, $inputName,$pseudo,'', 'readonly');?>
        </div>
        <div class="group-fields h-80 bg-transparent border-none flex-col flex-center">
            <?php $inputClass="fields fields-input";?> 
            <?php $inputType="text";?> 
            <?php $inputName="username";?> 
            <label class="label" for="username">Prénom</label>
            <?= Form::createInput($inputClass, $inputType, $inputName, ($_POST['username'] ?? $userDatas['username']),'', 'readonly');?>
        </div>
        <div class="group-fields h-80 bg-transparent border-none flex-col flex-center">
            <?php $inputClass="fields fields-input";?> 
            <?php $inputType="text";?> 
            <?php $inputName="lastname";?> 
            <label class="label" for="lastname">Nom</label>
            <?= Form::createInput($inputClass, $inputType, $inputName, ($_POST['lastname']?? $userDatas['lastname']),'', 'readonly');?>
        </div>
        <div class="group-fields h-80 bg-transparent border-none flex-col flex-center">
            <?php $inputClass="fields fields-input";?> 
            <?php $inputType="email";?> 
            <?php $inputName="email";?> 
            <label class="label" for="email">Email</label>
            <?= Form::createInput($inputClass, $inputType, $inputName, ($_POST['email']?? $email),'', 'readonly');?>
        </div>
        <div id="btn-edit" class="btn-zone h-80 flex-col flex-center">
            <button type="button" class="btn-form h-40">Modifier</button>
        </div>
        <div id="btn-validation" class="btn-zone h-80 flex-col flex-center display-none">
            <button type="submit" class="btn-form h-40">Valider</button>
        </div>
    </form>
    <p class="signMeIn display-none">Je ne souhaite rien modifier, <a href="<?=URL?>memberSession/profilMember">Annuler</a></p>

    <div class="profil-pwd"> 
        <button id="btn-modify-pwd">Changer mot de passe</button>
    </div>
</div>

<div class="user-picture">
    <div>
        <img src="<?=URL?>public/pictures/<?= $userDatas['picture'];?>" alt="photo de Profil" title="<?=URL?>public/pictures/<?= $userDatas['picture'];?>" class="rounded-circle profilPicture">
    </div>
    <div id="userPicture">
        <form action="<?= URL ?>memberSession/updateMemberPicture" method="POST" enctype="multipart/form-data">
                <label for="pictureUser">Changer l'image de profil</label><br/>
                <input type="file" class="form-control-file" id="pictureUser" name="pictureUser" required/>
                <button type="submit">Envoyer</button>
        </form>
    </div>
</div>

<!-- <div class="profil-pwd">
<a href="<?php //URL?>memberSession/deteleMember" class="btn-form h-40"><small>Supprimer mon compte</small></a>
</div> -->
<div id="delete-account" class="btn-zone h-80 flex-col flex-center">
    <button id="btn-delete-account" class="btn-form h-40">Supprimer mon compte</button>
</div>

    <div id="dialog-box-delete-account" class="dialog-box display-none">
        <h1 class="form-title">Attention !</h1>
        <form action="<?= URL ?>memberSession/deteleMember" method="POST">
        <div class="group-fields h-80 flex-col flex-center">
            <?php $inputClass="fields fields-input";?> 
            <?php $inputType="account";?> 
            <?php $inputName="deleteAccount";?> 
            <label class="label" for="deleteAccount">La suppression du votre compte est irreversible</label>
            <?= Form::createInput($inputClass, $inputType, $inputName, ($_POST['newPassword'])??"",'', 'hidden');?>
        </div>

        <div class="btn-zone h-80 flex-col flex-center">
            <button type="submit" class="btn-form h-40">Valider</button>
        </div>
        </form>
        <p class="signMeIn">Je ne veux pas supprimer mon compte, <a href="<?=URL?>memberSession/profilMember">Annuler</a></p>
    </div>
<?php require("./views/member/memberAccount/form_modifyPassword.php");?>

