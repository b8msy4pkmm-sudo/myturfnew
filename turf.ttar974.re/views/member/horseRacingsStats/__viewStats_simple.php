<?php use MAIN_NAMESPACE\utilities\toolbox\Toolbox;?>
<?php $nbTipsterWhitoutTips=0;?>
<?php for ($i=0;$i< count($finalResults);$i++) : ?>

    <?php if($finalResults[$i]['tipsOfDay'] && $finalResults[$i]['nbRaces']>0) :?>
        <div class="bloc-synthese">
            <div class="bloc-synthese-cadre">            
                <div class="bloc-synthese-title">
                    <p><?= $finalResults[$i]['tipster']?></p>
                    <p class="">nombre de pronostics : <?=  $finalResults[$i]['nbRaces'];?></p>
                </div>
                <table class="table-synthese">
                    <thead>
                        <tr>
                            <th></th>
                            <?php for ($j=1; $j<9;$j++) :?>
                                <?php $ch='ch'.$j ;?>
                                <th class="table-synthese-cell ch-title"><?= $ch;?></th>
                            <?php endfor ?>
                        </tr>
                        <tr>
                            <td class="table-synthese-cell-label">Pronos</td>
                            <?php for ($j=1; $j<9; $j++) :?>
                                <?php $ch='ch'.$j ;?>
                                <?php $reussite= ($finalResults[$i]['nbGame'][$ch]/$finalResults[$i]['nbRaces'])*100;?>
                                <?php $rdt= ($finalResults[$i]['cumulAmount'][$ch]/$finalResults[$i]['nbRaces'])*100;?>
                                <?php
                                    if(($reussite>=REUSSITE_MIN && $rdt>=RDT_MIN)){
                                        $classReussite="ch-reussite";
                                    }
                                    else{
                                        $classReussite="";
                                    }
                                ?>
                                <td class="table-synthese-cell ch-tipsOfDay <?= $classReussite;?>">
                                    <?= ((count($finalResults[$i]['tipsOfDay'])>0) && $finalResults[$i]['tipsOfDay'][$ch]!=99)?$finalResults[$i]['tipsOfDay'][$ch]:"";?>
                                </td>
                            <?php endfor ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="table-synthese-cell-label">Nb G.</td>
                            <?php for ($j=1; $j<=count($finalResults[$i]['nbGame']);$j++) :?>
                                <?php $ch='ch'.$j ;?>
                                <td class="table-synthese-cell ch-nbRace"><?= $finalResults[$i]['nbGame'][$ch];?></td>
                            <?php endfor ?>
                        </tr>
                        <tr>
                            <td class="table-synthese-cell-label table-synthese-cell-border">Gains €</td>
                            <?php for ($j=1; $j<=count($finalResults[$i]['cumulAmount']);$j++) :?>
                                <?php $ch='ch'.$j ;?>
                                <td class="table-synthese-cell table-synthese-cell-border ch-gains"><?= number_format($finalResults[$i]['cumulAmount'][$ch],2,',');?></td>
                            <?php endfor ?>
                        </tr>
                        <tr>
                            <td class="table-synthese-cell-label"> Ec. Max</td>
                            <?php for ($j=1; $j<=count($finalResults[$i]['maxGap']);$j++) :?>
                                <?php $ch='ch'.$j ;?>
                                <td class="table-synthese-cell ch-ecartMax"><?= $finalResults[$i]['maxGap'][$ch];?></td>
                            <?php endfor ?>
                        </tr>
                        <tr>
                            <td class="table-synthese-cell-label">Ec. Actuel</td>
                            <?php for ($j=1; $j<=count($finalResults[$i]['currentGap']);$j++) :?>
                                <?php $ch='ch'.$j ;?>
                                <td class="table-synthese-cell ch-ecartNow"><?= $finalResults[$i]['currentGap'][$ch];?></td>
                            <?php endfor ?>
                        </tr>
                        <tr>
                            <td class="table-synthese-cell-label">Rdt %</td>
                            <?php for ($j=1; $j<=count($finalResults[$i]['cumulAmount']);$j++) :?>
                                <?php $ch='ch'.$j ;?>
                                <?php $rdt= ($finalResults[$i]['cumulAmount'][$ch]/$finalResults[$i]['nbRaces'])*100;?>
                                <?php
                                    if($rdt>=100 && $rdt <150){
                                        $classRdt="rdt100";
                                    }else if ($rdt>=150)
                                    {
                                        $classRdt="rdt150";
                                    }else{
                                        $classRdt="";
                                    }
                                ?>
                                <td class="table-synthese-cell ch-ecartNow <?= $classRdt; ?>"><?= number_format($rdt,0,',');?>%
                                </td>
                            <?php endfor ?>
                        </tr>
                        <tr>
                            <td class="table-synthese-cell-label">Réus. %</td>
                            <?php for ($j=1; $j<=count($finalResults[$i]['cumulAmount']);$j++) :?>
                                <?php $ch='ch'.$j ;?>
                                <?php $reussite= ($finalResults[$i]['nbGame'][$ch]/$finalResults[$i]['nbRaces'])*100;?>
                                <?php
                                    if($reussite>=16){
                                        $classRdt="rdt100";
                                    }else{
                                        $classRdt="";
                                    }
                                ?>
                                <td class="table-synthese-cell ch-ecartNow <?= $classRdt;?>"><?= number_format($reussite,0,',');?>%
                                </td>
                            <?php endfor ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else :?>
        <?php 
            $nbTipsterWhitoutTips++;
        ?>
    <?php endif ?>

<?php endfor ?>
<?php 
    if($nbTipsterWhitoutTips==count($finalResults) && $nbTipsterWhitoutTips>0)Toolbox::addMessageAlert("Pas de pronostic enregistré pour les presses sélectionnées le ".$_SESSION['horseRacingsDate']['dateEnd']-> format('d-m-Y'),Toolbox::COLOR_DANGER);
?>
