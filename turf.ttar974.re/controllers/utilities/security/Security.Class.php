<?php 

namespace MAIN_NAMESPACE\utilities\security;

use MAIN_NAMESPACE\utilities\toolbox\Toolbox;

class Security {
    public const COOKIE_NAME = "timers" ;

    public static function secureHTML($chaine)
    {
        return htmlspecialchars(trim($chaine));
    }
    
    public static function isValidDate(array $dateInput):bool
    {
        if (count($dateInput)!==3)return false;
        foreach ($dateInput as $value) {
            if (!is_numeric($value))return false;
        }
        if(!checkdate($dateInput[1],$dateInput[2],$dateInput[0]))return false;
        return true;
    }

    public static function controlTheDateInput(string $date, string $dateStartDefault='', int $referenceYear=2022)
    {
        if (!empty($date))
        {
            $dateInput       = explode('-', (self::secureHTML($date)));
            $dateInputGlobal = new \dateTime(self::secureHTML($date));
            $DateOfStart     = explode('-',$dateStartDefault);
            $now=new \DateTime();
            if (self::isValidDate($dateInput))
            { 
                if($dateInput[0]<$DateOfStart[0] || $dateInputGlobal>$now || (int)$dateInput[0]<$referenceYear)
                {
                    $dateSession = new \DateTime($dateStartDefault);
                }
                else
                {
                    $dateSession=new \DateTime($date);
                }
            }
            else
            {
                $dateSession=new \DateTime($dateStartDefault);
            }
        }
        else
        {
            if(!isset($dateSession))$dateSession=new \DateTime($dateStartDefault);
        }
        return $dateSession;
    }

    public static function hasAccessAuthorization()
    {
        return(!empty($_SESSION['visitor']) && $_SESSION['visitor']['access']==true);
    }

    public static function userSessionActive()
    {
        return(isset($_SESSION['profil']));
    }

    public static function isAdministrator(){
        return isset($_SESSION['profil']['user_role']) && $_SESSION['profil']['user_role'] === "admin";
    }

    public static function visitorSessionCookies()
    {
        $ticket = session_id().microtime().rand(0,999999);
        $ticket = hash("sha512",$ticket);
        setcookie(self::COOKIE_NAME,$ticket,time()+(60*1 )); //actif pendant 1 minite
        $_SESSION['visitor'][self::COOKIE_NAME] = $ticket;
    }

    public static function genererateSessionCookies()
    {
        $ticket = session_id().microtime().rand(0,999999);
        $ticket = hash("sha512",$ticket);
        setcookie(self::COOKIE_NAME,$ticket,time()+($_SESSION['sessionTime'] ?? 3600));
        $_SESSION['profil'][self::COOKIE_NAME] = $ticket;
    }

    public static function cookieSessionStillActive(){
        return isset($_COOKIE[self::COOKIE_NAME]) && ($_COOKIE[self::COOKIE_NAME] === $_SESSION['profil'][self::COOKIE_NAME]);
    }
}