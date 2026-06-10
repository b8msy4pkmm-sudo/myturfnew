<?php
namespace MAIN_NAMESPACE\datas;

require_once __DIR__.'/../../config.php';

abstract class AccessDB
{
    private static $pdo = null;

    private static function setBdd()
    {
        self::$pdo = new \PDO('mysql:host='.DB_HOST.';
                              dbname='.DB_NAME.';
                              charset=utf8', DB_USER, DB_PWD);
        self::$pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
    }

    protected function getBdd()
    {
        if(self::$pdo===null){
            try
            {
                 self::setBdd();
            }
            catch (\PDOException $e) 
            {
                throw new \Exception("Oups serveur base de donées en maintenance !");
            };
        }
        return self::$pdo;
    }
}