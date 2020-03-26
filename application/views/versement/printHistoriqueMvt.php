<section role="main" class="content-body">
    <!-- start: page -->
    <header class="panel-heading">
        <h2 class="panel-title" style="color: #000000; text-align: center; padding: 10px">
            <?= $message ?>
        </h2>
    </header>

    <table style="width: 100%;" cellspacing="0">
        <thead style="width: 100%; border: solid; border-color: #000;">
        <tr style="width: 100%; border: solid; border-color: #000;">

            <th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Date
            </th>
            <th style="width: 25%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Libellé
            </th>
            <th style="width: 15%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Entrée
            </th>
            <th style="width: 15%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Sortie
            </th>
        </tr>
        </thead>
        <tbody>

            <?php
                $entree = 0;
                $depense = 0;
                foreach ($details as $item) {
                    $entree += ($item['Versement'] + $item['Recette']);
                    $depense += ($item['Depense']);


                    //$entree += ($item['Versement'] + $item['Recette']);
                    //$depense += ($item['Depense']);

                    if(!empty($item['DepenseExploitation'])){
                        foreach ($item['DepenseExploitation'] as $itemee) {
                            ?>
                            <tr>
                                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"><?= date('d/m/Y', strtotime($item['Date'])) ?></td>
                                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"><?= $itemee['motif'] ?></td>
                                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"></td>
                                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center" class="text-center"><?= $this->versement_m->formatNumber($itemee['somme']) ?> FCFA</td>
                            </tr>
                            <?php
                        }
                    }

                    if($item['DepenseAchat'] > 0){
                        ?>
                        <tr>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"><?= date('d/m/Y', strtotime($item['Date'])) ?></td>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">Dépense Intrant</td>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"></td>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center" class="text-center"><?= $this->versement_m->formatNumber($item['DepenseAchat']) ?> FCFA</td>
                        </tr>
                        <?php
                    }

                    if(!empty($item['DepenseBanque'])){
                        foreach ($item['DepenseBanque'] as $iteme) {
                            ?>
                            <tr>
                                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"><?= date('d/m/Y', strtotime($item['Date'])) ?></td>
                                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"><?= $iteme['motif'] ?></td>
                                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"></td>
                                <td  style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center" class="text-center"><?= $this->versement_m->formatNumber($iteme['somme']) ?> FCFA</td>
                            </tr>
                            <?php
                        }
                    }

                    if($item['DepenseIntervention'] > 0){
                        ?>
                        <tr>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"><?= date('d/m/Y', strtotime($item['Date'])) ?></td>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">Dépense Interventions</td>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"></td>
                            <td  style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center" class="text-center"><?= $this->versement_m->formatNumber($item['DepenseIntervention']) ?> FCFA</td>
                        </tr>
                        <?php
                    }

                    if($item['Versement'] > 0){
                        ?>
                        <tr>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"><?= date('d/m/Y', strtotime($item['Date'])) ?></td>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">Versement</td>
                            <td  style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center" class="text-center"><?= $this->versement_m->formatNumber($item['Versement']) ?> FCFA</td>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"></td>
                        </tr>
                        <?php
                    }

                    if($item['Recette'] > 0){
                        ?>
                        <tr>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"><?= date('d/m/Y', strtotime($item['Date'])) ?></td>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">Paiements Client</td>
                            <td  style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center" class="text-center"><?= $this->versement_m->formatNumber($item['Recette']) ?> FCFA</td>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"></td>
                        </tr>
                        <?php
                    }
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; font-weight: bold; text-align: center"></td>
            </tr>
            <tr>
                <td colspan="2" style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; font-weight: bold">
                    Total:
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; font-weight: bold; text-align: center">
					<?= $this->versement_m->formatNumber($entree) ?> FCFA
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; font-weight: bold; text-align: center">
					<?= $this->versement_m->formatNumber($depense) ?> FCFA
                </td>
            </tr>

            <tr>
                <td colspan="4" style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; font-weight: bold; text-align: center"></td>
            </tr>

            <tr style="">
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; font-weight: bold; font-size: 18px">
                    Reste:
                </td>
                <td colspan="3" style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; font-weight: bold; text-align: center; font-size: 18px">
                    <?= $this->versement_m->formatNumber($entree - $depense) ?> FCFA
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- end: page -->
</section>
</div>
</section>
