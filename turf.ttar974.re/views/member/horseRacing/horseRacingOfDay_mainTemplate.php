<?php if (!isset($raceOfDay)) :?>
    <h1>course inexistante</h1>
<?php endif ?>
<h1 class="txt-align-center"><?=$title;?></h1>
<?php if($_SESSION['horseRacing']['page']!=="simulRaceFinish") :?>
<div class="card-block-title flex-row flex-center flex-item-center">
    <h3 class="card-title">Course Quinté+</h3>
    <form action="<?= URL ?>memberSession/raceHorse/checkDateTurfOfDay" method="POST">
        <?php require_once("./views/member/horseRacing/__input_date_race.php");?>
    </form>
</div>
<?php endif ;?>
<?php 
    if($_SESSION['horseRacing']['page']!=="simulRaceFinish")
    require_once("./views/member/horseRacing/_horseRacingOfDay_headerView.php");
?>
<?= $pageContent ;?>

<!-- <h4>Variable $tipsterOfday[0]</h4>
<pre>
    <?= print_r($tipsterOfDay[0]??"");?>
</pre> -->
<!-- <pre>
    <?= print_r($_SESSION['horseRacing']['simulRace']??[]);?>
</pre> -->