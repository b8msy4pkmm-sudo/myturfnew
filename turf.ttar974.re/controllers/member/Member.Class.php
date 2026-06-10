<?php
namespace MAIN_NAMESPACE\controllers\Member;

use DateTime;
use MAIN_NAMESPACE\utilities\page\Page;
use MAIN_NAMESPACE\models\sqlReq\SqlModel;
use MAIN_NAMESPACE\utilities\toolbox\Toolbox;
use MAIN_NAMESPACE\utilities\security\Security;
require_once("./models/reqsql/SqlReq.Class.php");
require_once("./controllers/utilities/page/Main.Page.Class.php");
require_once("./controllers/utilities/security/Security.Class.php");

class MemberController extends Page{
    private $member;

    public function __construct() {
        $this->member = new SqlModel();
    }
    
    public function accessMemberProfil()
    {
        $filesCSS=[...parent::MAIN_CSS,'_visitorHomePage.css','_memberProfil.css'];
        $filesJavaScript=[...parent::MAIN_JS,'_profilMember.js'];
        $data_page=[
            "page_description" => "Acces au compte Membre",
            "page_title"       => "Profil du membre",
            "files_css"        => $filesCSS,
            "files_js"         => $filesJavaScript,
            "userDatas"        => $_SESSION['profil'],
            "page_url"         => URL,
            "view_page"        => "./views/member/memberAccount/form_profilMember.php",             
            "viewContent"      => "./views/common/templateFormMainView.php",
            "template"         => "./views/common/indexTemplate.php"
        ];
        $this->generatePage($data_page); 
    }

    public function accessHomePage()
    {
        $filesCSS=[...parent::MAIN_CSS,'_card.css'];
        $filesJavaScript=[...parent::MAIN_JS];
        $data_page=[
            "page_description" => "Acces au compte Membre",
            "page_title"       => "Profil du membre",
            "files_css"        => $filesCSS,
            "files_js"         => $filesJavaScript,
            "userDatas"        => $_SESSION['profil'],
            "page_url"         => URL,
            //"view_page"        => "./views/member/memberAccount/form_profilMember.php",             
            "viewContent"      => "./views/member/homePage.php",
            "template"         => "./views/common/indexTemplate.php"
        ];
        $this->generatePage($data_page); 
    }
    
/* Fonctions pour la gestion du profil utilisateur */
    public function memberIdentifiedValidated(array $userIdentification):bool
    {
        $table="members";
        $userPseudo=['pseudo'=>$userIdentification['pseudo']];
        $userIdentities=$this->member->getOneRowDatasFromTable($table,$userPseudo);
        if(!$userIdentities) return false;
        if(password_verify($userIdentification['pwd'][1],$userIdentities['pwd'])){
            ($_SESSION['sessionTime']>0)?$_SESSION['sessionTime']=3600*$_SESSION['sessionTime']:$_SESSION['sessionTime']=3600;//Une heure par défaut à changer si besoin
            $dateLogin = new DateTime();
            $updateDatas=[
                "login_lastdate"=> $dateLogin->format('Y/m/d')
            ];
            $updatedateLogin=$this->member->updateDatasInDataTable($table,$updateDatas,$userPseudo);
            $this->updateUserProfil($userIdentities);
            Security::genererateSessionCookies();
            return true;
        }else{
            return false;
        }   
    }

    public function checkMemberIfExist(array $datasConditions):bool
    {
        $table="members";
        if($this->member->getOneRowDatasFromtable($table,$datasConditions))return true;else return false;
    }

    public function updateOfPasswordMember(array $datas)
    {
        $table='members';
        $datasToUpdate=[
            'pwd'        => password_hash($datas['newPassword'],PASSWORD_DEFAULT),
            'access_key' => bin2hex(openssl_random_pseudo_bytes(3,$crypto_strong))
        ];
        $datasToCheck=[
            "email"=>$datas['email']
        ];
        $datasUpdated=$this->member->updateDatasInDataTable($table,$datasToUpdate,$datasToCheck);
        if($datasUpdated===1)
        {
            Toolbox::addMessageAlert("Mot de passe mise à jour avec succès !",Toolbox::COLOR_SUCCESS);
            header("location:".URL."memberSession/profilMember");
        }
        else
        {
            Toolbox::addMessageAlert("oups!",Toolbox::COLOR_WARNING);
            header("location:".URL);
        }
    }

    public function updateMemberProfil(array $datas){
        $table='members';
        $username=$datas['username'].' '.$datas['lastname'];
        $initial=$this->getInitialsUser($username);       
        $datasToUpdate = [
            'pseudo'     => $datas['pseudo'],
            'username'   => $datas['username'],
            'lastname'   => $datas['lastname'],
            'email'      => $datas['email'],
            'initial'    => $initial          
        ];
        $datasToCheck=[
            "id"=>$_SESSION['profil']['id']
        ];
        $datasUpdated=$this->member->updateDatasInDataTable($table,$datasToUpdate,$datasToCheck);
        if($datasUpdated===1)
        {
            Toolbox::addMessageAlert("Profil mis à jour avec succès !",Toolbox::COLOR_SUCCESS);
            $userInDB=$this->member->getOneRowDatasFromTable($table,$datasToCheck);
            $this->updateUserProfil($userInDB);
            $_SESSION['profil'][Security::COOKIE_NAME]=$_COOKIE[Security::COOKIE_NAME];
        }
        else
        {
            Toolbox::addMessageAlert("Aucune modification n'est efectiée !",Toolbox::COLOR_SUCCESS);
        }
        header("location:".URL."memberSession/profilMember");
    }

    public function sendEmailForForgettenPassword(string $email)
    {
        $table="members";
        $datasConditions=[
            'email'=>['=',$email]
        ];
        $mailDatas=[
            'subject' => "Reinitialisation du mot de passe",
            "view"    => "views/email/emailForChangePassword.php"
        ];
        if($userDatas=$this->member->getOneRowDatasFromtable($table,$datasConditions))
        {
            $sender='';
            return $this->emailSend($userDatas,$mailDatas,"Vous allez recevoir un e-mail d'ici 5 minutes",$sender);

        }
    }

    public function createNewMember(array $newMember):bool
    {
        $username=$newMember['username'].' '.$newMember['lastname'];
        $initial=$this->getInitialsUser($username);
        $created_date=new DateTime();
        $passwordCrypte=password_hash($newMember['password'],PASSWORD_DEFAULT);
        //Création d'un code secret pour la réinitialisation du mot de passe;
        $secretKey=bin2hex(openssl_random_pseudo_bytes(3,$crypto_strong));
        //Creation du code crypté pour le cookie
        $secretCookies=rand().sha1($newMember['email']).time().rand();
        $fileName=($newMember['gender']==1)?"profils/".$newMember['pseudo']."/profil_H.png":"profils/".$newMember['pseudo']."/profil_F.png";
        $dir="./public/pictures/profils/".$newMember['pseudo']."/";
        if (!file_exists($dir)) mkdir($dir,0777);
        if ($newMember['gender']==1)
        {
            $dir1="./public/pictures/profils/profil_H.png";
            $dir2= "./public/pictures/profils/".$newMember['pseudo']."/profil_H.png";
        }else
        {
            $dir1="./public/pictures/profils/profil_F.png";
            $dir2= "./public/pictures/profils/".$newMember['pseudo']."/profil_F.png";
        }
        copy($dir1,$dir2);
        $table="members";
        $newMemberDatas=[
            'pseudo'=>$newMember['pseudo'],
            'initial'=> $initial,
            'username'=>$newMember['username'],
            'lastname'=>$newMember['lastname'],
            'gender'=>(int)$newMember['gender'],
            'email'=>$newMember['email'],
            'pwd'=>$passwordCrypte,
            'user_role'=>'utilisateur',
            'user_position'=>'technicien',
            'statut'=>0,
            'created_date'=>$created_date->format('Y/m/d'),
            'picture'=>$fileName,
            'cookies'=>$secretCookies,
            'access_key'=>$secretKey
        ];
        $_SESSION['msgImportant']=$newMemberDatas;

        return ($this->member->insertOneRowInDataTable($table,$newMemberDatas));
    }

    public function sendEmailForActivationMemberAccount(string $pseudo)
    {
        $table="members";
        $datasConditions=[
            'pseudo'=>$pseudo
        ];
        $mailDatas=
        [
            'subject' => "Validation de votre compte",
            "view"    => "views/email/emailForActivationAccount.php"
        ];
        if($userDatas=$this->member->getOneRowDatasFromtable($table,$datasConditions))
        {
            $sender='';
            return $this->emailSend($userDatas,$mailDatas,"Vous allez recevoir un e-mail de validation d'ici 5 minutes",$sender);
        }
    }

    public function sendEmailForValidationByAdmin(array $userDatas)
    {
        $mailDatas=
        [
            'subject' => "Activation de votre compte par l'administrateur",
            "view"    => "views/email/emailForValidatationMemberAccountByAdmin.php"
        ];
        if($userDatas)
        {
            $sender='';
            return $this->emailSend($userDatas,$mailDatas,"Un email a été envoyé à l'utilisateur pour l'informer",$sender);
        }
    }

    public function sendEmailForDesactivationByAdmin(array $userDatas)
    {
        $mailDatas=
        [
            'subject' => "Désactivation de votre compte par l'administrateur",
            "view"    => "views/email/emailForDesactivationAccountByAdmin.php"
        ];
        if($userDatas)
        {
            $sender='';
            return $this->emailSend($userDatas,$mailDatas,"Un email a été envoyé à l'utilisateur pour l'informer",$sender);
        }
    }

    public function sendEmailForAdmin(array $datas)
    {
        $table="members";
        $datasConditions=[
            'pseudo'=>$datas['pseudo']
        ];
        $mailDatas=
        [
            'subject' => "Un utilisateur inactif essaie de se connecter",
            "view"    => "views/email/emailForAdmin.php"
        ];
        if($userDatas=$this->member->getOneRowDatasFromtable($table,$datasConditions))
        {
            $sender='contact@ttar974.re,ttar974@gmail.com,techerthierry@icloud.com';
            return $this->emailSend($userDatas,$mailDatas,"Un email a été envoyé à l'administrateur pour l'informer",$sender);
        }
        else
        {
            return false;
        }
    }

    public function memberAccountValidatedByEmail(array $datasConditions)
    {
        $table='members';
        $actived_date=new DateTime();
        $memberDatas=[
            'statut'=>1,
            'actived_date'=>$actived_date->format('Y/m/d')
        ];
        $datasUpdated=$this->member->updateDatasInDataTable($table,$memberDatas,$datasConditions);
        if($datasUpdated===1)
        {
            Toolbox::addMessageAlert("Le compte a bien été activé. Reconnecter-vous pour y accéder pour de bon !",Toolbox::COLOR_SUCCESS);
        }
        else
        {
            Toolbox::addMessageAlert("Si le compte est actif, reconnectez-vous ! Sinon contacter l'administrateur !",Toolbox::COLOR_WARNING);
        }
    }

    public function accountValidatedByAdmin(array $datasConditions){
        $table='members';
        $actived_date=new DateTime();
        $memberDatas=[
            'is_authorized'=>1,
            'valided_date'=>$actived_date->format('Y/m/d')
        ];
        $user=$this->member->getOneRowDatasFromTable($table,$datasConditions);
        if($user){
            if($user['is_authorized']==1){
                Toolbox::addMessageAlert("Membre déjà validé par l'administrateur ! ",Toolbox::COLOR_WARNING);
            }else{
                $datasUpdated=$this->member->updateDatasInDataTable($table,$memberDatas,$datasConditions);
                if($datasUpdated===1)
                {
                    $this->sendEmailForValidationByAdmin($user);
                }
            }
        }
        else{
            Toolbox::addMessageAlert("Membre inexistant ! ",Toolbox::COLOR_WARNING);
        }
    }

    public function accountDesactivatedByAdmin(array $datasConditions){
        $table='members';
        $actived_date=new DateTime();
        $memberDatas=[
            'is_authorized'=>0,
            'valided_date'=>$actived_date->format('Y/m/d')
        ];
        $user=$this->member->getOneRowDatasFromTable($table,$datasConditions);
        if($user){
            if($user['is_authorized']==0){
                Toolbox::addMessageAlert("Membre pas encore validé par l'administrateur ! ",Toolbox::COLOR_WARNING);
            }else{
                $datasUpdated=$this->member->updateDatasInDataTable($table,$memberDatas,$datasConditions);
                if($datasUpdated===1)
                {
                    $this->sendEmailForDesactivationByAdmin($user);
                }
            }
        }
        else{
            Toolbox::addMessageAlert("Membre inexistant ! ",Toolbox::COLOR_WARNING);
        }
    }

    public function checkMemberAccountIfNoActived(array $memberDatas):bool
    {
        $datasConditions=[
            'pseudo'=>$memberDatas['pseudo'],
            'statut'=>0
        ];
        return ($this->checkMemberIfExist($datasConditions))>0?true:false;
    }

    public function checkmemberAccountIsNotAuthorizedByAdministrator(array $memberDatas):bool
    {
        $datasConditions=[
            'pseudo'=>$memberDatas['pseudo'],
            'is_authorized'=>0
        ];
        return ($this->checkMemberIfExist($datasConditions))>0?true:false;
    }

    public function updateMemberPicture($file)
    {
        try{
            $repertoire = "public/pictures/profils/".$_SESSION['profil']['pseudo']."/";
            // Ajout de la nouvelle image dans le répertoire            
            $imageName = Toolbox::addPicture($file,$repertoire);
            // Suppression de l'ancienne image
            $this->deleteMemberPictureFolder();
            // Ajout de la nouvelle image dans la Base de Données
            $table='members';
            $conditionsDatas=[
                'pseudo'=>$_SESSION['profil']['pseudo']
            ];
            $memberDatas=[
                'picture'=>"profils/".$_SESSION['profil']['pseudo']."/".$imageName
            ];
            if($this->member->updateDatasInDataTable($table,$memberDatas,$conditionsDatas)===0){
                Toolbox::addMessageAlert("La modification de l'image n'a pas été effectuée", Toolbox::COLOR_WARNING);
            }else {
                $_SESSION['profil']['picture']=$memberDatas['picture'];
                Toolbox::addMessageAlert("La modification de l'image a été effectuée", Toolbox::COLOR_SUCCESS);           
            }
        } catch (\Exception $e){
            Toolbox::addMessageAlert($e->getMessage(),Toolbox::COLOR_DANGER);
        }
        header("location:".URL."memberSession/profilMember");
    }
    
    public function deleteMemberFolder():bool
    {
        $table="members";
        $dataConditions=[
            'id'=>(int)$_SESSION['profil']['id'],
            'user_role'=>['<>','admin']
        ];
        
        if($this->member->getOneRowDatasFromTable($table,$dataConditions))
        {
            // Supprime l'image du profil de l'utisateur
            $this->deleteMemberPictureFolder();
            // Supprime également le dossier profil de l'utisateur
            // A chercher
        }
        // Supprime de la base de données le membre
        if($this->member->deleteRowFromDataTable($table, $dataConditions)==1){
            Toolbox::addMessageAlert("Votre profil a été supprimé de la base !",Toolbox::COLOR_SUCCESS);
            unset($_SESSION['profil']);
            return true;
        }else{
            Toolbox::addMessageAlert("Supression impossible ! Contacter l'admin !",Toolbox::COLOR_WARNING);
            return false;
        }
    }

    private function updateUserProfil(array $datas)
    {
        $_SESSION['profil']=$datas;
        // [
        //     'id'        => $datas['id'],
        //     'pseudo'    => $datas['pseudo'],
        //     'initial'   => $datas['initial'],
        //     'username'  => $datas['username'],
        //     'lastname'  => $datas['lastname'],
        //     'gender'    => $datas['gender'],
        //     'email'     => $datas['email'],
        //     'user_role' => $datas['user_role'],
        //     'picture'   => $datas['picture']
        // ];
    }
    
    private function getInitialsUser(string $username):string
    {
        $words=explode(" ",$username);
        $initials="";
        foreach ($words as $word) {
            $initials.= substr(strtoupper($word),0,1);
        }
        return $initials;
    }

    private function emailSend(array $userDatas,array $mailDatas,string $msgAlert, string $sender)
    {
        $subject=$mailDatas['subject'];
        ob_start();
        $viewContent=$mailDatas['view'];
        require_once($viewContent);
        $page_content=ob_get_clean();
        $email=($sender!="")?$sender:$userDatas['email'];
        Toolbox::sendMail($email,$subject,$page_content,$msgAlert);
    }
    
    private function deleteMemberPictureFolder()
    {
        $table="members";
        $dataConditions=[
            'pseudo'=>$_SESSION['profil']['pseudo']
        ];
        $oldPicture=$this->member->getOneRowDatasFromTable($table, $dataConditions);
            unlink("public/pictures/".$oldPicture['picture']);
    }

/* Fonctions pour por le reste du site en tant que membre*/  


}
