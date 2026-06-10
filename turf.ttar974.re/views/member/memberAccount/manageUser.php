<?php
use MAIN_NAMESPACE\utilities\form\Form;


if(count($othersUsersDatas)>0){
    $userPseudo   = ($userDatas['pseudo'])??'';
    foreach ($othersUsersDatas as $otherUserDatas) {
        $userNameList[] = $otherUserDatas['username']. ' ' .$otherUserDatas['lastname'];
        $userPseudoList[]=$otherUserDatas['pseudo'];
    }
}
$userAccountStatus=[0,1];
$userAccountDesignation=["Inactif","Actif"];
$userAccountStatusSelected=(int)$userDatas['is_authorized'];
$userAccountPositionSelected=(string)$userDatas['user_position'];
$userAccountPosition=["Administratif","technicien"];
?>
<div class="main-content">
    <?php if (count($othersUsersDatas)>0) :?>
        <div id="user-manage" class="dialog-box bg-none">
            <h1 class="form-title title-black">Administration</h1>
            <table>
                <caption class="h-40"> Liste des utilisateurs</caption>
                <thead>
                    <tr>
                        <th scope="col" class="txt-align-left">Utilisateurs</th>
                        <th scope="col" class="txt-align-left">Role</th>
                        <th scope="col">Validé <br>par mail</th>
                        <th scope="col">Autorisé <br>par l'admin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($othersUsersDatas as $otherUserDatas) :?>
                    <tr>
                        <td class="cell"><?=$otherUserDatas['lastname']. ' ' .$otherUserDatas['username'];?></td>
                        <td class="cell"><?=$otherUserDatas['user_role'];?></td>
                        <?php if ($otherUserDatas['statut']>0){$actived_date = new DateTime($otherUserDatas['actived_date']);} ?>
                        <?php if ($otherUserDatas['is_authorized']>0) {$valided_date = new DateTime($otherUserDatas['valided_date']);}?>
                        <td class="cell txt-align-center"><?=($otherUserDatas['statut']>0)?$actived_date->format('d/m/Y'):"-"?></td>
                        <td class="cell txt-align-center"><?=($otherUserDatas['is_authorized']>0)?$valided_date->format('d/m/Y'):"-"?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>

            </table>
        </div>
        <div id="dialog-box-user-list" class="dialog-box">
            <h1 class="form-title">Gestion des droits</h1>
            <form action="<?= URL ?>member/memberSession/manageAccess/user" method="POST">
                <div class="group-fields h-80 border-none flex-col flex-center">
                    <label class="label" for="userPseudo">Utilisateur</label>
                    <?php $selectClass="fields fields-select"?>
                    <?php $selectName="userPseudo"?>
                    <?= Form::createSelect($selectClass,$selectName,$userPseudo,$userPseudoList,$userNameList,"");?>
                </div>
                <div id="btn-valid-user" class="group-btn h-80 flex-col flex-center">
                    <button type="submit" class="btn form-btn">Valider</button>
                </div> 
            </form>
            <p class="signMeIn">Je ne souhaite rien modifier, <a href="<?=URL?>member/memberSession/myAccount">Annuler</a></p>
        </div>
        <p><a href="<?= URL;?>member/memberSession/manageAccess/tableIndex">Reindexer la table</a></p>
    <?php else :?>
        <?php $_SESSION['temporyUser']=$userDatas?>
        <div id="user-manage" class="dialog-box bg-none">
            <h1 class="form-title title-black">Utilisateur sélectionné</h1>
            <!-- <form action="<?= URL ?>member/memberSession/manageAccess" method="POST">   -->
                <div class="group-fields h-80 bg-transparent border-none flex-col flex-center">
                    <?php $inputClass="fields fields-input";?> 
                    <?php $inputType="text";?> 
                    <?php $inputName="username";?> 
                    <?php $placeholder="Prénom";?> 
                    <label class="label" for="username">Prénom</label>
                    <?= Form::createInput($inputClass, $inputType, $inputName, $userDatas['username'],$placeholder, 'readonly');?>
                </div>
                <div class="group-fields h-80 bg-transparent border-none flex-col flex-center">
                    <?php $inputClass="fields fields-input";?> 
                    <?php $inputType="text";?> 
                    <?php $inputName="lastname";?> 
                    <?php $placeholder="Nom";?> 
                    <label class="label" for="lastname">Nom</label>
                    <?= Form::createInput($inputClass, $inputType, $inputName, $userDatas['lastname'],$placeholder, 'readonly');?>
                </div>
                <div class="group-fields h-80 bg-transparent border-none flex-col flex-center">
                    <?php $inputClass="fields fields-input";?> 
                    <?php $inputType="email";?> 
                    <?php $inputName="email";?> 
                    <?php $placeholder="Email";?> 
                    <label class="label" for="email">Email</label>
                    <?= Form::createInput($inputClass, $inputType, $inputName, $userDatas['email'],$placeholder, 'readonly');?>
                </div>
                <!-- <div id="btn-valid-user" class="group-btn h-80 flex-col flex-center">
                    <button type="submit" class="btn form-btn">Valider</button>
                </div>  -->
            <!-- </form>   -->
        </div>
        <div id="user-manage" class="dialog-box">
            <h2 class="form-title"><?= ($userAccountStatusSelected===1)?"Membre déjà Actif":"Membre non actif";?></h2>
            <form action="<?= URL ?>member/memberSession/manageAccess/user" method="POST">
                <!-- <div class="group-fields h-80 border-none flex-col flex-center">
                    <label class="label" for="userPseudo">Etat du compte</label>
                    <?php $selectClass="fields fields-select"?>
                    <?php $selectName="accountStatus"?>
                    <?= Form::createSelect($selectClass,$selectName,$userAccountStatusSelected,$userAccountStatus,$userAccountDesignation,"");?>
                </div> -->
                <div class="group-fields group-fields_radio border-none flex-col flex-between">
                    <span class="label">Etat du compte</span>
                    <?php $classUl=""?>
                    <?php $classLi="li-vertical li-label"?>
                    <?php $radioName="accountStatus"?>
                    <div class="fields fields-radio">
                        <?= Form::createRadioList($classUl,$classLi,$radioName,$userAccountStatusSelected,$userAccountStatus,$userAccountDesignation);?>
                    </div> 
                </div>
                <div id="btn-valid-user" class="group-btn h-80 flex-col flex-center">
                    <button type="submit" class="btn form-btn">Modifier le statut du compte</button>
                </div> 
            </form>
            <h2 class="form-title">Poste occupé</h2>
            <form action="<?= URL ?>member/memberSession/manageAccess/user" method="POST">
                <!-- <div class="group-fields h-80 border-none flex-col flex-center">
                    <label class="label" for="userPseudo">Etat du compte</label>
                    <?php $selectClass="fields fields-select"?>
                    <?php $selectName="accountStatus"?>
                    <?= Form::createSelect($selectClass,$selectName,$userAccountStatusSelected,$userAccountStatus,$userAccountDesignation,"");?>
                </div> -->
                <div class="group-fields group-fields_radio  border-none flex-col flex-between">
                    <span class="label">Secteur</span>
                    <?php $classUl=""?>
                    <?php $classLi="li-vertical li-label"?>
                    <?php $radioName="accountPosition"?>
                    <div class="fields fields-radio">
                        <?= Form::createRadioList($classUl,$classLi,$radioName,$userAccountPositionSelected,$userAccountPosition,$userAccountPosition);?>
                    </div> 
                </div>
                <div id="btn-valid-user" class="group-btn h-80 flex-col flex-center">
                    <button type="submit" class="btn form-btn">Modifier la fonction du poste</button>
                </div> 
            </form>
            <p class="signMeIn">Je ne souhaite rien modifier, <a href="<?=URL?>member/memberSession/myAccount">Annuler</a></p>
        </div>
    <?php endif ;?>
</div>