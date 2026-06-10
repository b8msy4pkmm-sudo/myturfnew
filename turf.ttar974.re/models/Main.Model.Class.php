<?php
namespace MAIN_NAMESPACE\datas;

abstract class AccessDB 
{
    private const HOST_NAME = "91.216.107.79";
    private const DB_NAME = "ttar92110138";
    private const USER_NAME = "ttar92110138";
    private const PWD = "97rpszsbon";    
    private static $pdo = null;
    
    private static function setBdd()
    {
        self::$pdo = new \PDO('mysql:host='.self::HOST_NAME.';
                              dbname='.self::DB_NAME.';
                              charset=utf8',self::USER_NAME,self::PWD);
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