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

    <div style="padding-bottom: 25px">
        <b>Date de la vente: </b><?= date("d/m/Y", strtotime($returnArray['Vente']->datevente)) ?>
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
                <th style="width: 14%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC; display: none; visibility: hidden">
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
                foreach ($returnArray['Produits'] as $produitItem) {
                    if($produitItem['Etat'] == 0){
                        $montantT += ($produitItem['Qte'] * $produitItem['Pu']);
                        $montantRemise += ($produitItem['Qte'] * $produitItem['Remise']);
                        $montantVrai += ($produitItem['Qte'] * ($produitItem['Pu'] - $produitItem['Remise']));

                        ?>
                        <tr>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left">
                                <?= $produitItem['Produit'] ?>
                            </td>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                                <?= $this->vente_m->formatNumber($produitItem['Pu']) ?>
                            </td>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center; display: none; visibility: hidden">
                                <?= $produitItem['Remise'] ?>
                            </td>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                                <?= $produitItem['Qte'] ?>
                            </td>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: right">
                                <?= $this->vente_m->formatNumber($produitItem['Qte'] * ($produitItem['Pu'] - $produitItem['Remise'])) ?>
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
                <td colspan="4" style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left; font-weight: bold; font-size: 16px">Total (HT)</td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: right; font-weight: bold; font-size: 16px">
                    <?= $this->vente_m->formatNumber($montantVrai) ?>
                </td>
            </tr>

			<tr>
				<td colspan="4" style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left; font-weight: bold; font-size: 16px">TVA (18%)</td>
				<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: right; font-weight: bold; font-size: 16px">
					<?= $this->vente_m->formatNumber($returnArray['MontTVA']) ?>
				</td>
			</tr>

            <tr>
                <td colspan="4" style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left; font-weight: bold; font-size: 16px">Total (TTC)</td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: right; font-weight: bold; font-size: 16px">
                    <?= $this->vente_m->formatNumber($returnArray['MontTTC']) ?>
                </td>
            </tr>

			<tr>
                <td colspan="4" style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left; font-weight: bold; font-size: 16px">Remise</td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: right; font-weight: bold; font-size: 16px">
                    <?= $this->vente_m->formatNumber($returnArray['TotalRemise']) ?>
                </td>
            </tr>

            <tr>
                <td colspan="4" style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left; font-weight: bold; font-size: 16px">Net à Payer</td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: right; font-weight: bold; font-size: 16px">
                    <?= $this->vente_m->formatNumber($returnArray['TotalTTC']) ?>
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- end: page -->
</section>
</div>
</section>
