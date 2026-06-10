<?php
use MAIN_NAMESPACE\utilities\form\Form;
use MAIN_NAMESPACE\utilities\toolbox\Toolbox;

if (isset($_POST['gameType']))
{
    $_SESSION['racingStats']['gameType']=$_POST['gameType'];
}

if(isset($_SESSION['racingStats']['page']))
{
    switch ($_SESSION['racingStats']['page']) {
        case 'simplesGames':
            $indexGamesValue = ['sg','zs','zc','sp'];
            $indexGamesList = ['Simple Gagnant','ZeSchow','ZeCouillon','Simple Placé'];
            $gameSelected=$_SESSION['racingStats']['gameType']??"sg"; 
            $gameType="Jeux simples";      
        break;
    
        case 'couplesGames':
            $indexGamesValue = ['jg','jgo','ze24'];
            $indexGamesList = ['Couple Gagnant','Coule G. Tous les Ordres ','2 sur 4'];
            $gameSelected=$_SESSION['racingStats']['gameType']??"jg"; 
            $gameType="Jeux couplé / 2 sur 4"; 
        break;
        
        default:
            # code...
        break;
    }
}
else{
    print_r($_SESSION['racingStats']['page']);
    $indexGamesValue = [];
    $indexGamesList = [];
    $gameSelected="";
}

?>
<div class="container-filter_game-type">
    <div class="group-fields group-fields_select border-none flex-col flex-center no-margin-bottom">
        <label class="label" for="gameType"><?=$gameType;?></label>
        <?php $selectClass="fields fields-select"?>
        <?php $selectName="gameType"?>
        <?= Form::createSelect($selectClass,$selectName,$gameSelected,$indexGamesValue,$indexGamesList,'onchange="submit()"');?>
    </div>
</div>
