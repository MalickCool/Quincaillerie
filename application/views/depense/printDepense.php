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
            <th style="width: 15%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Date
            </th>
            <th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Site
            </th>
			<th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Motif
            </th>
            <th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Fournisseur / Prestataire
            </th>

            <th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Département
            </th>

            <th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Effectué Par
            </th>

            <th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Montant
            </th>
        </tr>
        </thead>
        <tbody>
            <?php
                $total = 0;
                foreach ($depenses as $item) {
                    $total += $item->montant;
                    ?>
                    <tr>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= date('d/m/Y', strtotime($item->datedepense)) ?>
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left">
							<?php if($item->site_id > 0){$site = $this->site_m->get($item->site_id); echo $site->nomsite; }else{ echo"-"; } ?>
                        </td>
						<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left">
                            <?= $item->motifdepense ?>
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= $item->prestataire ?>
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= $item->departement ?>
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= $this->ion_auth->user($item->iduser)->row()->first_name." ".$this->ion_auth->user($item->iduser)->row()->last_name ?>
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: right">
                            <?= $this->depense_m->formatNumber($item->montant) ?> FCFA
                        </td>
                    </tr>
                    <?php
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left; font-weight: bold; font-size: 16px" colspan="6">Total Dépense</td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: right; font-weight: bold; font-size: 16px">
                    <?= $this->achat_m->formatNumber($total) ?> FCFA
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- end: page -->
</section>
</div>
</section>
