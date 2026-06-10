<?php
    use MAIN_NAMESPACE\utilities\form\Form;
    if(count($othersUsersDatas)>0){
        $userPseudo   = ($userDatas['pseudo'])??'';
        foreach ($othersUsersDatas as $otherUserDatas) {
            $userNameList[] = $otherUserDatas['username']. ' ' .$otherUserDatas['lastname'];
            $userPseudoList[]=$otherUserDatas['pseudo'];
        }
    }
    $displayNone=$_SESSION['temporyUser']['tmp']??0;
    $userAccountStatus=[0,1];
    $userAccountDesignation=["Inactif","Actif"];
    $userAccountStatusSelected=!isset($_SESSION['temporyUser']['is_authorized'])?0:$_SESSION['temporyUser']['is_authorized'];
    //$userAccountStatusSelected=(int)($_SESSION['temporyUser']['is_authorized'])??0;
    //$userAccountPositionSelected=(string)$_SESSION['temporyUser']['user_position'];
    $userAccountPosition=["Administratif","technicien"];
?>

<div id="user-manage" class="dialog-box bg-none">
    <h1 class="form-title title-black">Administration</h1>
    <?php if (count($othersUsersDatas)>0) :?>
    <table class="<?= $displayNone==0?'':'display-none';?>">
        <caption class="h-40"> Liste des utilisateurs</caption>
        <thead>
            <tr>
                <th scope="col" class="txt-align-left">Utilisateurs</th>
                <th scope="col" class="txt-align-left">Dernière<br/>connexion</th>
                <th scope="col">Validé <br>par mail</th>
                <th scope="col">Autorisé <br>par l'admin</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($othersUsersDatas as $otherUserDatas) :?>
            <tr>
                <td class="cell"><?=$otherUserDatas['lastname']. ' ' .$otherUserDatas['username'];?></td>
                <td class="cell"><?=($otherUserDatas['login_lastdate'])?($loginDate=new DateTime($otherUserDatas['login_lastdate']))->format('d/m/Y'):"-";?></td>
                <?php if ($otherUserDatas['statut']>0){$actived_date = new DateTime($otherUserDatas['actived_date']);} ?>
                <?php if ($otherUserDatas['is_authorized']>0) {$valided_date = new DateTime($otherUserDatas['valided_date']);}?>
                <td class="cell txt-align-center"><?=($otherUserDatas['statut']>0)?$actived_date->format('d/m/Y'):"-"?></td>
                <td class="cell txt-align-center"><?=($otherUserDatas['is_authorized']>0)?$valided_date->format('d/m/Y'):"-"?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <?php endif;?>
    <div id="dialog-box-user-list" class="dialog-box ">
        <h2>Gestion des droits</h2>
        <form action="<?= URL ?>memberSession/admin/user" method="POST">
            <div class="group-fields h-80 border-none flex-col flex-center <?= $displayNone==0?'':'display-none';?>">
                <label class="label" for="userPseudo">Utilisateur</label>
                <?php $selectClass="fields fields-select"?>
                <?php $selectName="userPseudo"?>
                <?= Form::createSelect($selectClass,$selectName,$userPseudo,$userPseudoList,$userNameList,'');?>
            </div>
            <div class="group-fields h-80 flex-col flex-center <?= $displayNone==0?'display-none':'';?>">
                <?php $inputClass="fields fields-input";?> 
                <?php $inputType="text";?> 
                <?php $inputName="completName";?> 
                <label class="label" for="completName">membre</label>
                <?= Form::createInput($inputClass, $inputType, $inputName, $_SESSION['temporyUser']['username']." ".$_SESSION['temporyUser']['lastname'],'', 'disabled');?>
            </div>
            <div id="btn-valid-user" class="btn-zone h-80 flex-col flex-center <?= $displayNone==0?'':'display-none';?>">
                <button type="submit" class="btn-form h-40">Gérer les droits</button>
            </div> 
        </form>
    </div>
    <div id="user-manage" class="dialog-box <?= $displayNone==1?'':'display-none';?>">
        <h2><?= ($userAccountStatusSelected===1)?"Membre déjà Actif":"Membre non actif";?></h2>
        <form action="<?= URL ?>memberSession/admin/accountAuthorization" method="POST">
            <!-- <div class="group-fields h-80 border-none flex-col flex-center">
                <label class="label" for="userPseudo">Etat du compte</label>
                <?php //$selectClass="fields fields-select"?>
                <?php //$selectName="accountStatus"?>
                <?php //Form::createSelect($selectClass,$selectName,$userAccountStatusSelected,$userAccountStatus,$userAccountDesignation,"");?>
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
            <div id="btn-valid-user" class="gbtn-zone h-80 flex-col flex-center">
                <button type="submit" class="btn-form h-40">Valider</button>
            </div> 
        </form>
        <p class="signMeIn <?= $displayNone==1?'':'display-none';?>">Je ne veux rien modifier, <a href="<?=URL?>memberSession/admin/noChange">Revenir au listing membre</a></p>
        <p>
            <pre><?php echo print_r($_SESSION['temporyUser']);?></pre>
        </p>
    </div>
</div>