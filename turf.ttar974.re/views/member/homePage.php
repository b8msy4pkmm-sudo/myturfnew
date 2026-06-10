<?php 

?>
<div class="container-card">
    <div class="card">
        <div class="card-img">
            <img class="img-responsive" src="<?=URL?>public/pictures/homepage/horse_racing.jpg" alt="">
        </div>
        <div class="card-block-title flex-row flex-center flex-item-center">
            <h3 class="card-title">Course Quinté+</h3>
            <!-- <div class="dialog-box bg-none w-50"> -->
                <form action="<?= URL ?>memberSession/raceHorse/checkDateHorseRacing" method="POST">
                    <?php require_once("./views/member/horseRacing/__input_date_race.php");?>
                </form>
            <!-- </div> -->
        </div>
        <hr>
        <div class="card-menu-navbar">
            <ul class="card-menu">
                <?php if($_SESSION['profil']['user_role']==="admin"):?>
                <li class="card-menu-item dropdown">
                    <a class="card-menu-item-link" href="#">Presses<span class="dropdown-menu-symbol"></span></a>
                    <ul class="dropdown-menu display-none">
                        <li class="dropdown-menu-item">
                            <a class="dropdown-menu-item__link" href="<?= URL?>memberSession/raceHorse/byTipsters">Consulter pronostics</a>
                        </li>
                        <li class="dropdown-menu-item">
                            <a class="dropdown-menu-item__link" href="<?= URL?>memberSession/raceHorse/raceTipster">Ajouter pronostic</a>
                        </li>
                        <li class="dropdown-menu-item">
                            <a class="dropdown-menu-item__link" href="<?= URL?>memberSession/raceHorse/simulRaceFinish">Simulation</a>
                        </li>
                    </ul>
                </li>
                <li class="card-menu-item">
                <a class="card-menu-item-link" href="<?= URL;?>memberSession/raceHorse/raceInfos">Course</a>
                </li>
                <li class="card-menu-item dropdown">
                    <a class="card-menu-item-link" href="#">Résultats<span class="dropdown-menu-symbol"></span></a>
                    <ul class="dropdown-menu display-none">
                        <li class="dropdown-menu-item">
                            <a class="dropdown-menu-item__link" href="<?= URL?>memberSession/raceHorse/raceFinish">Arrivée course</a>
                        </li>
                        <li class="dropdown-menu-item">
                            <a class="dropdown-menu-item__link" href="<?= URL?>memberSession/raceHorse/raceWinnings">Rapports course</a>
                        </li>
                    </ul>
                </li>
                <?php else: ?>
                    <li class="card-menu-item">
                        <a class="card-menu-item-link" href="<?= URL;?>memberSession/raceHorse/byTipsters">Presse</a>
                    </li>
                    <li class="card-menu-item">
                        <a class="card-menu-item-link" href="<?= URL;?>memberSession/raceHorse/simulRaceFinish">Simulation</a>
                    </li>

                <?php endif;?>
            </ul>
        </div>
        <p class="card-info">Sélectionner une date pour découvrir les pronostics et les résultats du Quinté + </p>
    </div>
    <div id="form-racingStat" class="card">
        <div class="card-img">
            <img class="img-responsive" src="<?=URL?>public/pictures/homepage/stat.jpg" alt="">
        </div>
        <div class="card-block-title flex-row flex-center flex-item-center">
            <h3 class="card-title stat-title">Stats</h3>
            <!-- <div class="dialog-box bg-none w-50"> -->
                <form action="<?= URL ?>memberSession/racingStats/checkDatePeriod#form-racingStat" method="POST">
                    <?php require_once("./views/member/horseRacingsStats/__input_date_stat.php");?>
                </form>
            <!-- </div> -->
        </div>
        <hr>
        <div class="card-menu-navbar">
            <ul class="card-menu">
                <li class="card-menu-item">
                <a class="card-menu-item-link" href="<?= URL ?>memberSession/racingStats/simplesGames">Simples</a>
                </li>
                <li class="card-menu-item">
                <a class="card-menu-item-link" href="<?= URL ?>memberSession/racingStats/couplesGames">Couple</a>
                </li>
                <!-- <li class="card-menu-item">
                <a class="card-menu-item-link" href="#">Presse</a>
                </li> -->
            </ul>
        </div>
        <p class="card-info">Sélectionner une période pour suivre les statistiques de jeux en fonction des pronostics, du type de jeu, et de l'hippodrome</p>
    </div>

</div>