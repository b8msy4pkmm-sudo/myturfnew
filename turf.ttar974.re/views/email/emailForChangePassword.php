<html>
    <head>
    <title>Nouveau mot de passe</title>
    </head>
    <body>
        <h3>Vous avez demandé à réinitialiser votre mot de passe</h3>
        <p>Bonjour <?=($userDatas['username'])??''?><br>.Voici le code à saisir lors de la validation du nouveau mot de passe et lien de la page</p> 
        <ul>
            <li>Pour rappel, voici votre pseudo : <i><?= ($userDatas['pseudo'])?? '' ?> </i></li>
        <li>votre code : <wrong><?=($userDatas['access_key']) ?? "";?></wrong></li>
        <li><a href="<?=URL?>formOfResetPassword" _target="blank">Cliquer-ici pour réinitialiser votre de passe</a></li>
        </ul>
    </body>
</html>
