<?php
namespace MAIN_NAMESPACE\utilities\toolbox;

class Toolbox{
    public const COLOR_DANGER ="danger-alert";
    public const COLOR_WARNING ="warning-alert";
    public const COLOR_SUCCESS ="success-alert";

    public static function addMessageAlert($message,$type)
    {
            $_SESSION['alert'][]=[
                "message"=> $message,
                "type"=>$type
            ];
    }

    public static function verifEmail ($email) 
    {
        if (filter_var ($email, FILTER_VALIDATE_EMAIL) === false) 
            {
                return false;
            } 
        else 
            {
                return true;
            }
    }

    // public static function verifMail_2 ($mail) 
    // {
    //     if (preg_match ('/^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]/i', $mail ) ) 
    //         {
    //             return false;
    //         }
    //     list ($nom, $domaine) = explode ('@', $mail);
    //     if (getmxrr ($domaine, $mxhosts)) 
    //         {
    //             return true;
    //         } 
    //     else 
    //         {
    //             return false;
    //         } 
    // } 

    public static function sendMail($beneficiary,$sujet,$message,$msgAlert)
    {
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = 'From: Thierry TECHER <contact@ttar974.re>';
        if(mail($beneficiary,$sujet,$message,implode("\r\n",$headers)))
            {
                self::addMessageAlert($msgAlert,self::COLOR_SUCCESS);
            }   
        else
            {
            self::addMessageAlert("Mail non envoyé",self::COLOR_DANGER);
            }
    }

    public static function addPicture_initial($file,$dir)
    {
        if (!isset($file['name']) || empty($file['name'])) throw new \Exception("Vous devez indiquer une image !");
        if (!file_exists($dir)) mkdir($dir,0777);
        $extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
        $random=rand(0,99999);
        $target_file=$dir.$random.'_'.$file['name'];
        if(!getimagesize($file['tmp_name'])) throw new \Exception("Le fichier n'est pas une image");
        if($extension !=="jpg" && $extension !=="jpeg" && $extension !=="png" && $extension !=="gif") throw new \Exception("L'extension du fichier n'est pas reconnu");
        if(file_exists($target_file)) throw new \Exception(("le fichier existe déjà"));
        if($file['size']>5000000) throw new \Exception("Le fichier est trop volumineux, il ne doit pas dépasser 5Mo");
        if(!move_uploaded_file($file['tmp_name'],$target_file)) throw new \Exception("L'ajout de l'image n'a pas fonctionné");
        else return ($random."_".$file['name']);
    }


// version chatgpt    
public static function addPicture($file, $dir)
{
    if (!isset($file['name']) || empty($file['name'])) {
        throw new \Exception("Vous devez indiquer une image !");
    }

    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($extension, $allowed)) {
        throw new \Exception("L'extension du fichier n'est pas autorisée");
    }

    //Check complet
    if ($file['error'] !== 0) {
    throw new \Exception("Erreur d'upload (code {$file['error']})");    
    }

    if (!is_uploaded_file($file['tmp_name'])) {
        throw new \Exception("Le fichier n'est pas un upload HTTP valide");
    }

    if (!is_readable($file['tmp_name'])) {
        throw new \Exception("Le fichier temporaire n'est pas lisible");
    }

    if ($file['size'] === 0) {
        throw new \Exception("Le fichier est vide");
    }

    $imageInfo = getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        throw new \Exception("Ce n'est pas une image valide");
    }

    if (!getimagesize($file['tmp_name'])) {
        throw new \Exception("Le fichier n'est pas une image");
    }

    if ($file['size'] > 5000000) {
        throw new \Exception("Le fichier est trop volumineux (max 5 Mo)");
    }

    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
    $newName = uniqid('img_', true) . '_' . $filename . '.' . $extension;
    $target_file = rtrim($dir, '/') . '/' . $newName;

    if (!move_uploaded_file($file['tmp_name'], $target_file)) {
        throw new \Exception("L'ajout de l'image a échoué");
    }

    return $newName;
}
    
}