<section role="main" class="content-body">
    <!-- start: page -->
    <header class="panel-heading">

    </header>

    <h2 class="panel-title" style="color: #000000; text-align: center; padding-top: 60px; padding-bottom: 25px">
        <?= $message ?>
    </h2>

    <div style="padding-bottom: 0px">
        <b>N° Client: </b>C<?= str_pad($returnArray['Client']->idclient, 5, "0", STR_PAD_LEFT); ?>
    </div>
    <div style="padding-bottom: 0px">
        <b>Client: </b><?= $returnArray['Client']->nom ?>
    </div>

    <div style="padding-bottom: 0px">
        <b>Date de la commande: </b><?= $returnArray['Commande']->datecommande ?>
    </div>

	<div style="padding-bottom: 0px">
        <b>Date probable de livraison: </b><?= $returnArray['Commande']->datelivraison ?>
    </div>

    <div style="padding-bottom: 20px">
        <b>Adresse de livraison: </b><?= $returnArray['Commande']->lieuxlivraison ?>
    </div>

    <table style="width: 100%;" cellspacing="0">
        <thead style="width: 100%; border: solid; border-color: #000;">
            <tr style="width: 100%; border: solid; border-color: #000;">
                <th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                    Libellé
                </th>
                <th style="width: 14%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                    P.U
                </th>
                <th style="width: 14%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                    Remise
                </th>
                <th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                    Quantité
                </th>
                <th style="width: 15%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                    Montant
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
                $montantT = 0;
                $montantRemise = 0;
                $montantVrai = 0;
                foreach ($returnArray['Briques'] as $brique) {
                    if($brique['Etat'] == 0){
                        $montantT += ($brique['Qte'] * $brique['Pu']);
                        $montantRemise += ($brique['Qte'] * $brique['Remise']);
                        $montantVrai += ($brique['Qte'] * ($brique['Pu'] - $brique['Remise']));

                        ?>
                        <tr>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left">
                                <?= $brique['Brique'] ?>
                            </td>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                                <?= $brique['Pu'] ?>
                            </td>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                                <?= $brique['Remise'] ?>
                            </td>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                                <?= $brique['Qte'] ?>
                            </td>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: right">
                                <?= $this->commande_m->formatNumber($brique['Qte'] * ($brique['Pu'] - $brique['Remise'])) ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left; font-weight: bold; font-size: 16px"></td>
            </tr>
            <tr>
                <td colspan="4" style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left; font-weight: bold; font-size: 16px">Total Brique (HT)</td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: right; font-weight: bold; font-size: 16px">
                    <?= $this->commande_m->formatNumber($montantVrai) ?>
                </td>
            </tr>

            <tr>
                <td colspan="4" style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left; font-weight: bold; font-size: 16px">Total Brique (TTC)</td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: right; font-weight: bold; font-size: 16px">
                    <?= $this->commande_m->formatNumber($returnArray['MontTTC']) ?>
                </td>
            </tr>

            <tr>
                <td colspan="4" style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left; font-weight: bold; font-size: 16px">Frais de Livraison</td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: right; font-weight: bold; font-size: 16px">
                    <?= $this->commande_m->formatNumber($returnArray['FraisPort']) ?>
                </td>
            </tr>

            <tr>
                <td colspan="4" style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left; font-weight: bold; font-size: 16px">Total</td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: right; font-weight: bold; font-size: 16px">
                    <?= $this->commande_m->formatNumber($returnArray['TotalTTC']) ?>
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- end: page -->
</section>
</div>
</section>
