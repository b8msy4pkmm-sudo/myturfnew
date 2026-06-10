<?php
namespace MAIN_NAMESPACE\controllers\visitor;

use MAIN_NAMESPACE\utilities\page\Page;
use MAIN_NAMESPACE\models\sqlReq\SqlModel;
use MAIN_NAMESPACE\utilities\toolbox\Toolbox;
use MAIN_NAMESPACE\utilities\security\Security;

require_once("./models/reqsql/SqlReq.Class.php");
require_once("./controllers/utilities/page/Main.Page.Class.php");
require_once("./controllers/utilities/security/Security.Class.php");

class VisitorController extends Page{
    private $visitor;

    public function __construct() {
        $this->visitor = new SqlModel();
    }
    
    public function pageError($msg){
        parent::pageError($msg);
    }

    public function accessLoginPage(){
        //$_SESSION['url'] = URL;
        $filesCSS= [...parent::MAIN_CSS,'_visitorHomePage.css'];
        $filesJavaScript= [...parent::MAIN_JS];
        $data_page=[
            "page_description" => "Se connecter à l'espace membre",
            "page_title"       => "Connexion membre",
            "files_css"        => $filesCSS,
            "files_js"         => $filesJavaScript,
            "page_url"         => URL,
            "view_page"        => "./views/visitor/form_loginMemberAccount.php",
            "viewContent"      => "./views/common/templateFormMainView.php",
            "template"         => "./views/common/indexTemplate.php"
        ];
        $this->generatePage($data_page);  
    }

    public function accessCreateAccountPage(){
        //$_SESSION['url'] = URL;
        $filesCSS= [...parent::MAIN_CSS,'_visitorHomePage.css'];
        $filesJavaScript= [...parent::MAIN_JS];
        $data_page=[
            "page_description" => "Se connecter à l'espace membre",
            "page_title"       => "Connexion membre",
            "files_css"        => $filesCSS,
            "files_js"         => $filesJavaScript,
            "page_url"         => URL,
            "view_page"        => "./views/visitor/form_createMemberAccount.php",
            "viewContent"      => "./views/common/templateFormMainView.php",
            "template"         => "./views/common/indexTemplate.php"
        ];
        $this->generatePage($data_page);  
    }

    public function accessPageForgettenPassword()
    {
        //$_SESSION['url']="forgettenPassword";
        $filesCSS=[...parent::MAIN_CSS,'_visitorHomePage.css'];
        $filesJavaScript=[...parent::MAIN_JS];
        $data_page=[
            "page_description" => "Formulaire de mot de passe oublié",
            "page_title"       => "Demande de Réinitialisation du mot de passe",
            "files_css"        => $filesCSS,
            "files_js"         => $filesJavaScript,
            "page_url"         => URL,
            "view_page"        => "./views/visitor/form_forgettenPasswordRequest.php",             
            "viewContent"      => "./views/common/templateFormMainView.php",
            "template"         => "./views/common/indexTemplate.php"
        ];
        $this->generatePage($data_page);
    }

    public function accessPageResetPassword()
    {
        //$_SESSION['url']="forgettenPassword";
        $filesCSS=[...parent::MAIN_CSS,'_visitorHomePage.css'];
        $filesJavaScript=[...parent::MAIN_JS];
        $data_page=[
            "page_description" => "Formulaire de réinitialisation du mot de passe",
            "page_title"       => "Nouveau mot de passe",
            "files_css"        => $filesCSS,
            "files_js"         => $filesJavaScript,
            "page_url"         => URL,
            "view_page"        => "./views/visitor/form_resetPassword.php",             
            "viewContent"      => "./views/common/templateFormMainView.php",
            "template"         => "./views/common/indexTemplate.php"
        ];
        $this->generatePage($data_page);
    }

    public function accessPageTest(){
        //$_SESSION['url'] = URL;
        $filesCSS= [...parent::MAIN_CSS,'_visitorHomePage.css'];
        $filesJavaScript= [...parent::MAIN_JS];
        $data_page=[
            "page_description" => "Se connecter à l'espace membre",
            "page_title"       => "Connexion membre",
            "files_css"        => $filesCSS,
            "files_js"         => $filesJavaScript,
            "page_url"         => URL,         
            "viewContent"      => "./views/visitor/test.php",
            "template"         => "./views/common/indexTemplate.php"
        ];
        $this->generatePage($data_page);  
    }
    // public function validatedKey($keypass){
    //     if($this->visitor->verifKeypass($keypass)){
    //         Security::visitorSessionCookies();
    //         $_SESSION['visitor']=['access'=>true];
    //         Toolbox::addMessageAlert("Accès autorisé !",Toolbox::COLOR_SUCCESS);
    //         header("location:".URL);
    //     }
    //     else{
    //         Toolbox::addMessageAlert("Erreur : clé invalide !",Toolbox::COLOR_DANGER);
    //         header("location:".URL);
    //         exit();
    //     }
    // }
}