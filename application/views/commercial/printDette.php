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
            <th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
				N° Commande
            </th>
            <th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
				Date
            </th>
            <th style="width: 30%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
				Client
            </th>
            <th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Contact Client
            </th>
			<th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
				Montant Total
            </th>
			<th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
				Montant Reglé
            </th>
			<th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
				Reste à Payer
            </th>
        </tr>
        </thead>
        <tbody>
			<?php
				$mttc = 0;
				$mr = 0;
				$mp = 0;
				foreach ($commandes as $list) {
					$mttc += $list['TotalTTC'];
					$mr += $list['MontantVerse'];
					$mp += $list['Reste'];
					?>
					<tr>
						<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"><?= date('Y/m/', strtotime($list['Commande']->datecommande))."_".$list['Commande']->idcommande; ?></td>
						<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"><?= date('d/m/Y', strtotime($list['Commande']->datecommande)) ?></td>
						<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"><?= $list['Client']->nom ?></td>
						<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"><?= $list['Client']->phone ?></td>
						<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"><?= $this->client_m->formatNumber($list['TotalTTC']) ?></td>
						<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"><?= $this->client_m->formatNumber($list['MontantVerse']) ?></td>
						<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center"><?= $this->client_m->formatNumber($list['Reste']) ?></td>
					</tr>
					<?php
				}
			?>
        </tbody>
		<tfoot>
			<tr>
				<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left; font-weight: bold" colspan="4">Total</td>
				<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center; font-weight: bold"><?= $this->client_m->formatNumber($mttc) ?></td>
				<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center; font-weight: bold"><?= $this->client_m->formatNumber($mr) ?></td>
				<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center; font-weight: bold"><?= $this->client_m->formatNumber($mp) ?></td>
			</tr>
		</tfoot>
    </table>

    <!-- end: page -->
</section>
</div>
</section>
