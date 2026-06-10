<h3 class="txt-align-center">Historique des pronostics</h3>
<h4 class="txt-align-center"><?= $finalResults[0]['tipster'];?></h4>
<div class="turfOfDay-container">
    <?php $index=1;?>
        <?php foreach ($_SESSION['resultsOfFiltersByDesc'] as $tipster) :?>
            <div class="tipsters-of-day">
                <div class="tipsters-of-day_name">
                    <!-- <p> -->
                        <small>
                            <?= (new dateTime($tipster['date_course']))->format('d-m-Y');?>
                            <i>
                                <?= $tipster['type_course']." - ".$tipster['distance_course']."m" ;?> - 
                            </i>
                                <?= $this->getHippodromeName($tipster['index_hippodrome']); ?>
                        </small>
                    <!-- </p> -->
                </div>
                <div class="tipsters-of-day_tips">
                    <?php for ($i=1; $i < 9; $i++) :?>
                        <?php $ch="ch".$i; ?>
                        <?php switch ($tipster[$ch]) 
                                {
                                    case $tipster['arrivee_ch1']:
                                        $styleColor="colorCh1";
                                    break;
                                    case $tipster['arrivee_ch2']:
                                        $styleColor="colorCh2";
                                    break;
                                    case $tipster['arrivee_ch3']:
                                        $styleColor="colorCh3";
                                    break;
                                    case $tipster['arrivee_ch4']:
                                        $styleColor="colorCh4";
                                    break;
                                    case $tipster['arrivee_ch5']:
                                        $styleColor="colorCh5";
                                    break;
                                    default:
                                        $styleColor="";
                                    break;
                                }
                        ?>
                        <p class="tips <?=$styleColor;?>"><?= $tipster[$ch]==99?"":$tipster[$ch];?></p>
                    <?php endfor ?>
                </div>
            </div>
            <?php $index++;?>
        <?php endforeach ;?>
</div>