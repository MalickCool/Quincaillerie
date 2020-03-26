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
            <th style="width: 30%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Libellé
            </th>
            <th style="width: 70%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Montant
            </th>
        </tr>
        </thead>
        <tbody>
            <?php
                $totalDepense = 0;
                $totalPaiement = 0;
                $totalVersement = 0;
                foreach ($details as $item) {
                    $totalDepense += $item['depense'];
					$totalPaiement += $item['paiement'];
                    $totalVersement += $item['versement'];
                    ?>
                    <tr>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            Total Dépense
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= $this->versement_m->formatNumber($item['depense']) ?> FCFA
                        </td>
                    </tr>

                    <tr>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            Total Paiement
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= $this->versement_m->formatNumber($item['paiement']) ?> FCFA
                        </td>
                    </tr>

                    <tr>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            Total Versement
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= $this->versement_m->formatNumber($item['versement']) ?> FCFA
                        </td>
                    </tr>
                    <?php
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; font-weight: bold">Reste en caisse:</td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center; font-weight: bold">
                    <?= $this->versement_m->formatNumber(($totalPaiement + $totalVersement) - $totalDepense) ?> FCFA
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- end: page -->
</section>
</div>
</section>
