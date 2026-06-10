<html>
    <head>
    <title>Activation de votre compte</title>
    </head>
    <body>
        <h3>L'administrateur a validé votre compte</h3>
        <p>Bonjour <?=($userDatas['username'])??''?><br></p> 
        <ul>
            <li>Votre pseudo : <?=($userDatas['pseudo'])??''?></li>
            <li><a href="<?=URL?>formForLoginUserSession" _target="blank">Cliquer-ici pour vous connecter à votre compte</a></li>
        </ul>
    </body>
</html>