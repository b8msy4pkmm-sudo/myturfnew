<?php
namespace MAIN_NAMESPACE\controllers\Admin;

use DateTime;
use MAIN_NAMESPACE\utilities\page\Page;
use MAIN_NAMESPACE\models\sqlReq\SqlModel;
use MAIN_NAMESPACE\utilities\toolbox\Toolbox;
use MAIN_NAMESPACE\utilities\security\Security;
require_once("./models/reqsql/SqlReq.Class.php");
require_once("./controllers/utilities/page/Main.Page.Class.php");
require_once("./controllers/utilities/security/Security.Class.php");

class AdminController extends Page{
    private $admin;

    public function __construct() {
        $this->admin = new SqlModel();
    }

    public function accessManageAccess()
    {
        $filesCSS=[...parent::MAIN_CSS,'_memberHomePage.css','_tableManagment.css'];
        $filesJavaScript=[...parent::MAIN_JS];
        $table='members';
        $datasConditions=[
            'user_role'=>['<>','admin']
        ];
        $orderBy=['lastname','ASC'];
        $othersUsersDatas=$this->admin->getFewRowsDatasFromTable($table,$datasConditions,$orderBy);
        $data_page=[
            "page_description" => "Acces au compte Membre",
            "page_title"       => "Profil du membre",
            "files_css"        => $filesCSS,
            "files_js"         => $filesJavaScript,
            "userDatas"        => $_SESSION['profil'],
            "othersUsersDatas" => $othersUsersDatas,
            "container"        => "sub-container-admin",
            "page_url"         => URL,
            "view_page"        => "./views/member/admin/manageUsersRight.php",             
            "viewContent"      => "./views/common/templateFormMainView.php",
            "template"         => "./views/common/indexTemplate.php"
        ];
        $this->generatePage($data_page); 
    }

    public function  selectedUserRight(string $userPseudo)
    {
        $table="members";
        $selectedUser=['pseudo'=>$userPseudo];
        $_SESSION['temporyUser']=$this->admin->getOneRowDatasFromTable($table,$selectedUser);
        $_SESSION['temporyUser']['tmp']=1;
    }
}