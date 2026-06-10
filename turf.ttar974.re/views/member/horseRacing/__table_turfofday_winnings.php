<div class="turfOfDay-table-winnings display-none">
    <h2 class="txt-align-center">Rapports du quinté <small> - Zeturf</small></h2>
    <table class="table-winnings">
        <thead>
            <tr>
                <th class="table-winnings-cell_title" scope="col" colspan="5">SIMPLE</th>
            </tr>
            <tr>
                <th class="table-winnings-cell_th" scope="col">Cheval</th>
                <th class="table-winnings-cell_th" scope="col">SG</th>
                <th class="table-winnings-cell_th" scope="col">SP</th>
                <th class="table-winnings-cell_th" scope="col">ZS</th>
                <th class="table-winnings-cell_th" scope="col">ZC</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row" class="table-winnings-cell"><?=$raceOfDay['arrivee_ch1']??"";?></td>
                <td class="table-winnings-cell"><?=$racingWinnings['sg']??"";?></td>
                <td class="table-winnings-cell"><?=$racingWinnings['sp1']??"";?></td>
                <td class="table-winnings-cell"></td>
                <td class="table-winnings-cell"></td>
            </tr>
            <tr>
                <th scope="row" class="table-winnings-cell"><?=$raceOfDay['arrivee_ch2']??"";?></td>
                <td class="table-winnings-cell"></td>
                <td class="table-winnings-cell"><?=$racingWinnings['sp2']??"";?></td>
                <td class="table-winnings-cell"><?=$racingWinnings['zs']??"";?></td>
                <td class="table-winnings-cell"></td>
            </tr>
            <tr>
                <th scope="row" class="table-winnings-cell"><?=$raceOfDay['arrivee_ch3']??"";?></td>
                <td class="table-winnings-cell"></td>
                <td class="table-winnings-cell"><?=$racingWinnings['sp3']??"";?></td>
                <td class="table-winnings-cell"></td>
                <td class="table-winnings-cell"></td>
            </tr>
            <tr>
                <th scope="row" class="table-winnings-cell"><?=$raceOfDay['arrivee_ch4']??"";?></td>
                <td class="table-winnings-cell"></td>
                <td class="table-winnings-cell"></td>
                <td class="table-winnings-cell"></td>
                <td class="table-winnings-cell"><?=$racingWinnings['zc']??"";?></td>
            </tr>
        </tbody>
    </table>
    <table class="table-winnings">
        <thead>
            <tr>
                <th class="table-winnings-cell_title" scope="col" colspan="5">COUPLE</th>
            </tr>
            <tr>
                <th class="table-winnings-cell_th"  scope="col">Cheval</th>
                <th class="table-winnings-cell_th" scope="col" colspan="2">CG</th>
                <th class="table-winnings-cell_th"  scope="col" colspan="2">CG Ordre<small> (genybet)</small></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row" class="table-winnings-cell"><?=$raceOfDay['arrivee_ch1']??"";?>-<?=$raceOfDay['arrivee_ch2']??"";?></td>
                <td class="table-winnings-cell" colspan="2"><?=$racingWinnings['jg']??"";?></td>
                <td class="table-winnings-cell" colspan="2"><?=$racingWinnings['jgo']??"";?></td>
            </tr>
        </tbody>
    </table>
    <table class="table-winnings">
        <thead>
            <tr>
                <th class="table-winnings-cell_title"  scope="col" colspan="2">2 SUR 4</th>
            </tr>
            <tr>
                <th class="table-winnings-cell_th" >Cheval</th>
                <th class="table-winnings-cell_th">2/4</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row" class="table-winnings-cell"><?=$raceOfDay['arrivee_ch1']??"";?>-<?=$raceOfDay['arrivee_ch2']??"";?></td>
                <td class="table-winnings-cell" colspan="5"><?=$racingWinnings['ze24']??"";?></td>
            </tr>
            <tr>
                <th scope="row" class="table-winnings-cell" ><?=$raceOfDay['arrivee_ch1']??"";?>-<?=$raceOfDay['arrivee_ch3']??"";?></td>
                <td class="table-winnings-cell" colspan="5"><?=$racingWinnings['ze24']??"";?></td>
            </tr>
            <tr>
                <th scope="row" class="table-winnings-cell" ><?=$raceOfDay['arrivee_ch1']??"";?>-<?=$raceOfDay['arrivee_ch4']??"";?></td>
                <td class="table-winnings-cell" colspan="5"><?=$racingWinnings['ze24']??"";?></td>
            </tr>
            <tr>
                <th scope="row" class="table-winnings-cell" ><?=$raceOfDay['arrivee_ch2']??"";?>-<?=$raceOfDay['arrivee_ch3']??"";?></td>
                <td  class="table-winnings-cell" colspan="5"><?=$racingWinnings['ze24']??"";?></td>
            </tr>
            <tr>
                <th scope="row" class="table-winnings-cell"><?=$raceOfDay['arrivee_ch2']??"";?>-<?=$raceOfDay['arrivee_ch4']??"";?></td>
                <td class="table-winnings-cell" colspan="5"><?=$racingWinnings['ze24']??"";?></td>
            </tr>
            <tr>
                <th scope="row" class="table-winnings-cell"><?=$raceOfDay['arrivee_ch3']??"";?>-<?=$raceOfDay['arrivee_ch4']??"";?></td>
                <td class="table-winnings-cell" colspan="5"><?=$racingWinnings['ze24']??"";?></td>
            </tr>
        </tbody>
    </table>
</div>