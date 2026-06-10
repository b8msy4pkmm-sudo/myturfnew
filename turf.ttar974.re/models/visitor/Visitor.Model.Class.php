<?php
namespace MAIN_NAMESPACE\models\visitor;

use MAIN_NAMESPACE\datas\AccessDB;
require_once("./models/Main.Model.Class.php");

class VisitorModel extends AccessDB 
{
    // private function getKeypass()
    // {
    //     $req   = "SELECT keypass FROM page_keypass";
    //     $stmt  = $this->getBdd()->prepare($req);
    //     $stmt -> execute();
    //     $resultat=$stmt->fetch(\PDO::FETCH_ASSOC);
    //     $stmt -> closeCursor();
    //     return $resultat['keypass'];
    // }

    // public function verifKeypass($keypass)
    // {
    //     $keypassDB = $this->getKeypass();
    //     return password_verify($keypass,$keypassDB);
    // }

}