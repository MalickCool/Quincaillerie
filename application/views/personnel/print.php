<section role="main" class="content-body">
    <!-- start: page -->
    <header class="panel-heading">
        <h2 class="panel-title" style="color: #000000; text-align: center; border: solid; border-bottom-color: #0a001f; padding: 10px; border-radius: 15px">
            <?= $message ?>
        </h2>
    </header>

	<?php
		foreach ($magasins as $key => $personnels) {
			?>
			<h3 style="text-align: center">
				<?= $key ?>
			</h3>
			<table style="width: 100%;" cellspacing="0">
				<thead style="width: 100%; border: solid; border-color: #000;">
					<tr style="width: 100%; border: solid; border-color: #000;">
						<th style="width: 30%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
							Nom & Prénom
						</th>
						<th style="width: 15%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
							Contact
						</th>
						<th style="width: 15%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
							Statut
						</th>
						<th style="width: 15%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
							Magasin
						</th>
						<th style="width: 15%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
							Fonction
						</th>
						<th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
							Etat
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($personnels as $item) {
							$status = "Activer";
							if ($item->etat > 0)
								$status = "Désactiver";
							?>
							<tr>
								<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
									<?= $item->nom." ".$item->prenom ?>
								</td>
								<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
									<?= $item->contact ?>

								</td>
								<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
									<?= $item->statut ?>
								</td>
								<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
									<?= $this->entrepot_m->get($item->magasin_id)->designation ?>

								</td>
								<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
									<?= $item->fonction ?>
								</td>
								<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
									<?= $status ?>
								</td>
							</tr>
							<?php
						}
					?>
				</tbody>
			</table>
			<?php
		}
	?>

    <!-- end: page -->
</section>
</div>
</section>
