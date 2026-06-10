<html>
    <head>
    <title>Activation de votre compte</title>
    </head>
    <body>
        <h3>Plus qu'une ultime étape pour utiliser votre compte</h3>
        <p>Bonjour <?=($userDatas['username'])??''?><br></p> 
        <ul>
            <li>Votre pseudo : <?=($userDatas['pseudo'])??''?></li>
            <li><a href="<?=URL?>memberAccountValidatedByEmail/<?=$userDatas['cookies']?>" _target="blank">Cliquer-ici pour activer votre compte</a></li>
        </ul>
    </body>
</html>