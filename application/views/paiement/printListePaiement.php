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
		<b>Montant de la Facture: </b><?= $this->vente_m->formatNumber($returnArray['TotalTTC']) ?> FCFA
	</div>

    <table style="width: 100%;" cellspacing="0">
        <thead style="width: 100%; border: solid; border-color: #000;">
            <tr style="width: 100%; border: solid; border-color: #000;">
                <th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                    Date
                </th>
				<th style="width: 14%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
					Encaissé Par
				</th>
				<th style="width: 14%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
					Moyen de Paiement
				</th>
                <th style="width: 14%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                    Montant Versé
                </th>
            </tr>
        </thead>
        <tbody>
			<?php
				$total = 0;
				foreach ($returnArray['Paiements'] as $paiement) {
					$total += $paiement->montant;
					switch ($paiement->typepaiement) {
						case 'espece':
							$moyen = 'Espèce';
							break;

						case 'cheque':
							$moyen = 'Chèque';
							break;

						default:
							$moyen = 'Mobile Money';
							break;
					}
					?>
					<tr>
						<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
							<?= date('d/m/Y', strtotime($paiement->datepaiement)) ?>
						</td>
						<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
							<?= $this->ion_auth->user($paiement->userid)->row()->first_name." ".$this->ion_auth->user($paiement->userid)->row()->last_name ?>
						</td>
						<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
							<?= $moyen ?>
						</td>
						<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: right">
							<?= $this->vente_m->formatNumber($paiement->montant) ?> FCFA
						</td>
					</tr>
					<?php
				}
			?>

        </tbody>
		<tfoot>
			<tr>
				<td colspan="4" style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left; font-weight: bold; font-size: 16px"></td>
			</tr>
			<tr>
				<td colspan="3" style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left; font-weight: bold; font-size: 16px">Total Payé</td>
				<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: right; font-weight: bold; font-size: 16px">
					<?= $this->vente_m->formatNumber($total) ?> FCFA
				</td>
			</tr>
		</tfoot>
    </table>

    <!-- end: page -->
</section>
</div>
</section>
