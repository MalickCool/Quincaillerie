<section role="main" class="content-body">
	<!-- start: page -->
	<header class="panel-heading">

	</header>

	<h2 class="panel-title" style="color: #000000; text-align: center; padding-top: 60px; padding-bottom: 25px">
		<?= $message ?>
	</h2>

	<div style="padding-bottom: 0px">
		<b>Date de la Commande:</b> <?= date('d/m/Y', strtotime($bon->datebon)) ?>
	</div>
	<div style="padding-bottom: 0px">
		<b>Fournisseur:</b> <?= $bon->idfournisseur ?>
	</div>

	<div style="padding-bottom: 10px">
		<b>TVA Appliquée:</b> <?= ucfirst($bon->tva) ?>
	</div>

	<div style="padding-bottom: 25px">
		<b>Poids Total:</b> <?= $this->detailsbc_m->formatNumber($poids) ?> Kg
	</div>

	<table style="width: 100%;" cellspacing="0">
		<thead style="width: 100%; border: solid; border-color: #000;">
		<tr style="width: 100%; border: solid; border-color: #000;">
			<th style="width: 30%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
				Produit
			</th>
			<th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
				Quantité
			</th>
			<th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
				P.U.
			</th>
			<th style="width: 15%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
				TVA
			</th>
			<th style="width: 25%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
				Total TTC
			</th>
		</tr>
		</thead>
		<tbody>
			<?php
				$total = 0;
				foreach ($details as $detail) {
					if($bon->tva == 'oui'){
						$mht = $detail->pu / 1.18;
					}else{
						$mht = $detail->pu;
					}
					$taxe = $detail->pu - $mht;

					$total += ($detail->qte * $detail->pu);
					?>
					<tr>
						<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left">
							<?= $detail->produit ?>
						</td>
						<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left">
							<?= $detail->qte ?>
						</td>
						<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: right">
							<?= $this->detailsbc_m->formatNumber($mht) ?> FCFA
						</td>
						<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: right">
							<?= $this->detailsbc_m->formatNumber($taxe) ?> FCFA
						</td>
						<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: right">
							<?= $this->detailsbc_m->formatNumber($detail->qte * $detail->pu) ?> FCFA
						</td>
					</tr>
					<?php
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="4" style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left; font-weight: bold; font-size: 16px">
					Total:
				</td>
				<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: right; font-weight: bold; font-size: 16px">
					<?= $this->detailsbc_m->formatNumber($total) ?> FCFA
				</td>
			</tr>
		</tfoot>
	</table>

	<!-- end: page -->
</section>
</div>
</section>
