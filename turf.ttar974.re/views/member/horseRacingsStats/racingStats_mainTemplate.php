<h1 class="txt-align-center"><?=$title;?></h1>
<div class="card-block-title flex-row flex-center flex-item-center">

    <h3 class="card-title">Période</h3>
        <form action="<?= URL ?>memberSession/racingStats/checkDatePeriodForStat" method="POST">
            <?php require_once("./views/member/horseRacingsStats/__input_date_stat.php");?>
        </form>

</div>

<?= $pageContent ;?>

<!-- <pre>
    <?= print_r($_SESSION['racingStats']??[]);?>
</pre> -->
<!-- <pre>
    <?= print_r($_SESSION['resultsOfFilters']??[]);?>
</pre> -->
<!-- <pre>
    <?= print_r($_SESSION['resultsOfWinnings']??[]);?>
</pre> -->
<!-- <pre>
    <?= print_r($finalResults);?>
</pre> -->
<!-- <pre>
    <?= print_r($_SESSION['dateEndChange']);?>
</pre> -->
<!-- <pre>
    <?= print_r($_SESSION['resultsOfFiltersByDesc']);?>
</pre> -->
