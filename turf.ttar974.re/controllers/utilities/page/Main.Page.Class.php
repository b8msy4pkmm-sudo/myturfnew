<?php
namespace MAIN_NAMESPACE\utilities\page;
use MAIN_NAMESPACE\utilities\toolbox\Toolbox;

abstract class Page 
{
    
    protected const MAIN_CSS=['style.css'];
    protected const MAIN_JS =['_alert.js','_nav.js'];
    protected const KEY_PASS="CoDeRuN!974";

    protected function generatePage(array $data)
    { 
        extract($data); 
        ob_start();
        require_once($viewContent);
        $page_content=ob_get_clean();
        require_once($template);
    }

    protected function pageError($msg)
    {
        Toolbox::addMessageAlert($msg,Toolbox::COLOR_DANGER);
        $filesCSS=[...self::MAIN_CSS];
        $filesJS=[...self::MAIN_JS];
        $data_page=[
            "page_description" => "Description de la page erreur",
            "page_title"       => "Titre de la page d'erreur",
            "files_css"        => $filesCSS,
            "files_js"         => $filesJS,
            "msg"              => $msg,
            "msgError"         => $_SESSION['errorMsg']??"",
            "page_url"         => URL,
            "viewContent"      => "views/common/pageError.php",
            "template"         => "views/common/indexTemplate.php"
        ];
        $this->generatePage($data_page);
    } 
}