<?php use MAIN_NAMESPACE\utilities\toolbox\Toolbox;?>
<?php $nbTipsterWhitoutTips=0;?>
<?php for ($i=0;$i< count($finalResults);$i++) : ?>
    <?php if($finalResults[$i]['tipsOfDay'] && $finalResults[$i]['nbRaces']>0):?>
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
                    </thead>
                    <tbody>
                        <tr>
                            <td class="table-synthese-cell-label">Pronos du jour</td>
                            <?php if(isset($finalResults[$i]['tipsOfDay'])) :?>
                                <?php for ($j=1; $j<9 ;$j++) :?>
                                    <?php $ch='ch'.$j ;?>
                                    <td class="table-synthese-cell ch-tipsOfDay <?= $classReussite;?>"><?= ($finalResults[$i]['tipsOfDay'][$ch]!=99)?$finalResults[$i]['tipsOfDay'][$ch]:"";?></td>
                                <?php endfor ?>
                            <?php else :?>
                                <?php for ($j=1; $j<=9;$j++) :?>
                                    <?php $ch='ch'.$j ;?>
                                    <td class="table-synthese-cell ch-tipsOfDay <?= $classReussite;?>"><?= " " ;?></td>
                                <?php endfor ?>
                            <?php endif ?>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <table class="table-synthese">
                    <thead>
                        <tr>
                            <th class="table2-synthese-cell ch-title">Couple</th>
                            <th class="table2-synthese-cell ch-title">Jeu</th>
                            <th class="table-synthese-cell ch-title">Nb</th>
                            <th class="table-synthese-cell ch-title">Ecart Max</th>
                            <th class="table2-synthese-cell ch-title">Ecart Actuel</th>
                            <th class="table2-synthese-cell ch-title cell-end">Gains</th>
                            <th class="table2-synthese-cell ch-title cell-end">rdt (%)</th>
                            <th class="table2-synthese-cell ch-title cell-end cell-rte">réus. (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $chA=1;$chB=$chA;$amountTotal=0;?>
                        <?php $nbRows=1;?>
                        <?php for ($row=1; $row < 29; $row++) :?> 
                            <?php if ($chA<=$chB && $chB<8) : ?>
                                <?php $chB++;?>
                            <?php else :?>
                                <?php $chA=$chA+1; $chB=$chA+1;  ?>  
                            <?php endif ?> 
                            <?php if($finalResults[$i]['tipsOfDay']['ch'.$chA]!=99 && $finalResults[$i]['tipsOfDay']['ch'.$chB]!=99) : ?>
                                <?php $nbRows++; ?>
                                <tr>
                                    <?php 
                                        $z=$_SESSION['racingStats']['gameType']=="jgo"?2:1;
                                        $rdt=(($finalResults[$i]['cumulAmount']['ch'.$chA.'-ch'.$chB])/($finalResults[$i]['nbRaces']*$z))*100;
                                        $rte=(($finalResults[$i]['nbGame']['ch'.$chA.'-ch'.$chB])/($finalResults[$i]['nbRaces']))*100;
                                        $passPercentage=(($finalResults[$i]['nbGame']['ch'.$chA.'-ch'.$chB])/($finalResults[$i]['nbRaces']))*100;
                                        
                                        if($rdt>=100 && $rdt <150){
                                            $classRdt="rdt100";
                                        }else if ($rdt>=150)
                                        {
                                            $classRdt="rdt150";
                                        }else{
                                            $classRdt="";
                                        }

                                        if ($rte>=30){$classRte="rdt100";}
                                        else if ($rte >=50){$classRte="rdt150";}
                                        else {$classRte="";};

                                        if(($passPercentage>=10 && $rdt>=110 && ($_SESSION['racingStats']['gameType']=="jg" || $_SESSION['racingStats']['gameType']=="jgo")) || ($passPercentage>=16 && $rdt>=120) && $_SESSION['racingStats']['gameType']=="ze24")
                                        {
                                            $colorPass="ch-reussite";
                                        }else{
                                            $colorPass="";
                                        }
                                    ?> 
                                    <td class="table2-synthese-cell cell-content">
                                        <?='ch'.$chA.'-ch'.$chB;?>  
                                    </td>
                                    <td class="table2-synthese-cell cell-content-couple <?= $colorPass;?>">
                                        <span class="both_ch"><?= ($finalResults[$i]['tipsOfDay']['ch'.$chA])??" "; ?></span>
                                            - 
                                        <span class="both_ch"><?= ($finalResults[$i]['tipsOfDay']['ch'.$chB])??" "; ?></span>
                                    </td>
                                    <td class="table-synthese-cell cell-content"><?= $finalResults[$i]['nbGame']['ch'.$chA.'-ch'.$chB]?></td>
                                    <td class="table-synthese-cell cell-content"><?= $finalResults[$i]['maxGap']['ch'.$chA.'-ch'.$chB]?></td>
                                    <td class="table-synthese-cell cell-content"><?= $finalResults[$i]['currentGap']['ch'.$chA.'-ch'.$chB]?></td>
                                    <td class="table2-synthese-cell cell-content cell-end <?=$classRdt;?>"><?= number_format($finalResults[$i]['cumulAmount']['ch'.$chA.'-ch'.$chB],2,',')?>€</td>
                                    <?php $amountTotal=$amountTotal+$finalResults[$i]['cumulAmount']['ch'.$chA.'-ch'.$chB];?>
                                    <td class="table2-synthese-cell cell-content cell-end <?=$classRdt;?>">
                                        <?=number_format($rdt,0,',');?>%
                                    </td>
                                     <td class="table2-synthese-cell cell-content cell-end cell-rte <?=$classRte;?>">
                                        <?=number_format($rte,0,',');?>%
                                    </td>
                                </tr> 
                            <?php endif;?> 
                        <?php endfor ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="table2-synthese-cell cell-content cell-end" colspan="4">Si les 28 combinaisons sont joués</td>
                            <td class="table2-synthese-cell cell-content cell-end">Total gains</td>
                            <td class="table2-synthese-cell cell-content cell-end"><?=number_format($amountTotal,2,',');?>€</td>
                            <?php $z=$_SESSION['racingStats']['gameType']=="jgo"?2:1;?>
                            <td class="table2-synthese-cell cell-content cell-end"><?= number_format(($amountTotal/(($finalResults[$i]['nbRaces'])*$z*($nbRows-1))*100),0,',');?>%</td>
                            <td class="table2-synthese-cell cell-content cell-end. cell-rte"> </td>
                        </tr>
                    </tfoot>
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

