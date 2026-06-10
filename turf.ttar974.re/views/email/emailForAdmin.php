<html>
    <head>
    <title>Un utilisateur inactif cherche à se connecter</title>
    </head>
    <body>
        <h3>L'utilisateur :</h3>
        <p><?=$userDatas['username']." ".$userDatas['lastname']?><br></p> 
        <ul>
            <li>Son pseudo : <?=($userDatas['pseudo'])??''?></li>
            <li>Son Email : <?=($userDatas['email'])??''?></li>
        </ul>
        <div class="btn-zone h-80 flex-col flex-center">
            <button class="btn-form h-40"><a href="<?= URL."accountValidatedByAdmin/".$userDatas['cookies'];?>">Valider</a></button>
        </div>
    </body>
</html>