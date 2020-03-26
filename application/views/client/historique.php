<style>
	.form-group {
		margin-bottom: 0px !important;
	}
</style>
	<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Historique des Achats</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Sce Commercial</li>
						<li class="breadcrumb-item active">Historique Achats</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<?= $texte ?>
						</div>
						<div class="card-body">
							<?php
								foreach ($achats as $achat) {
									?>
									<fieldset>
										<legend>Achat N° <?= date('Y/m/', strtotime($achat['Vente']->datevente))."_".$achat['Vente']->idvente ?></legend>
										<div class="row pl-2 pr-2">
											<div class="col-md-5 card">
												<div class="card-header" style="border: 1px solid;">
													Détails de l'achat
												</div>
												<div class="card-body" style="border: 1px solid; border-top: none">
													<div class="form-group row">
														<label for="" class="col-sm-12 text-left control-label col-form-label">Client</label>
														<div class="col-sm-12">
															<input type="text" class="form-control" readonly value="<?= $achat['Client']->nom ?>">
														</div>
													</div>

													<div class="form-group row">
														<div class="col-md-6 pl-0">
															<label for="" class="col-sm-12 text-left control-label col-form-label">Montant HT</label>
															<div class="col-sm-12">
																<input type="text" class="form-control" readonly value="<?= $this->vente_m->formatNumber($achat['Vente']->montant) ?> FCFA">
															</div>
														</div>
														<div class="col-md-6 pr-0">
															<label for="" class="col-sm-12 text-left control-label col-form-label">Montant TVA</label>
															<?php
															$mTVA = $achat['Vente']->montant * $achat['Tva'] / 100;
															?>
															<div class="col-sm-12">
																<input type="text" class="form-control" readonly value="<?= $this->vente_m->formatNumber($mTVA) ?> FCFA">
															</div>
														</div>
													</div>

													<div class="form-group row">
														<div class="col-md-6 pl-0">
															<label for="" class="col-sm-12 text-left control-label col-form-label">Total Remise sur Brique</label>
															<div class="col-sm-12">
																<input type="text" class="form-control" readonly value="<?= $this->vente_m->formatNumber($achat['TotalRemise'] - $achat['Vente']->remisefacture) ?> FCFA">
															</div>
														</div>
														<div class="col-md-6 pr-0">
															<label for="" class="col-sm-12 text-left control-label col-form-label">Remise sur Facture</label>
															<div class="col-sm-12">
																<input type="text" style="font-weight: bolder; color: red" class="form-control" readonly value="<?= $this->vente_m->formatNumber($achat['Vente']->remisefacture) ?> FCFA">
															</div>
														</div>
													</div>

													<div class="form-group row">
														<div class="col-md-12 pr-0">
															<label for="" class="col-sm-12 text-left control-label col-form-label">Montant Total</label>
															<div class="col-sm-12">
																<input type="text" style="font-weight: bolder; color: red" class="form-control" readonly value="<?= $this->vente_m->formatNumber($achat['TotalTTC']) ?> FCFA">
															</div>
														</div>
													</div>

													<div class="form-group row">
														<div class="col-md-6 pl-0">
															<label for="" class="col-sm-12 text-left control-label col-form-label">Montant Payé :</label>
															<div class="col-sm-12">
																<input type="text" style="font-weight: bolder; color: red" class="form-control" readonly value="<?= $this->vente_m->formatNumber($achat['MontantVerse']) ?> FCFA">
															</div>
														</div>
														<div class="col-md-6 pr-0">
															<label for="" class="col-sm-12 text-left control-label col-form-label">Reste à payer :</label>
															<div class="col-sm-12">
																<input type="text" style="font-weight: bolder; color: red" class="form-control" readonly value="<?= $this->vente_m->formatNumber($achat['TotalTTC'] - $achat['MontantVerse']) ?> FCFA">
															</div>
														</div>
													</div>

													<div class="form-group row">

													</div>
													<div class="form-group row">

													</div>
												</div>
											</div>

											<div class="col-md-7 card">
												<div class="card-header" style="border: 1px solid;">
													Détails Produits Commandés
												</div>
												<div class="card-body" style="border: 1px solid; border-top: none">
													<div class="table-responsive">
														<table id="zero_config" class="table table-striped table-bordered">
															<thead>
																<tr>
																	<th>Produit</th>
																	<th>Quantité Commandé</th>
																	<th>PU</th>
																	<th>Montant Remise</th>
																	<th>Montant Total</th>
																</tr>
															</thead>
															<tbody>
															<?php
																$montantT = 0;
																foreach ($achat['Produits'] as $produit) {
																	$montantT += ($produit['Qte'] * $produit['Pu']);
																	?>
																	<tr>
																		<td><?= $produit['Produit'] ?></td>
																		<td><?= $produit['Qte'] ?></td>
																		<td><?= $this->vente_m->formatNumber($produit['Pu']) ?> FCFA</td>
																		<td><?= $this->vente_m->formatNumber($produit['Remise']) ?> FCFA</td>
																		<td><?= $this->vente_m->formatNumber($produit['Qte'] * ($produit['Pu'] - $produit['Remise'])) ?> FCFA</td>
																	</tr>
																	<?php
																}
															?>
															</tbody>
															<tfoot>
																<tr>
																	<td colspan="4">Total HT</td>
																	<td><?= $this->vente_m->formatNumber($montantT) ?> FCFA</td>
																</tr>
															</tfoot>
														</table>
													</div>
												</div>
											</div>

											<div class="col-md-12 card">
												<div class="card-header" style="border: 1px solid;">
													Détails Paiements
												</div>
												<div class="card-body" style="border: 1px solid; border-top: none">
													<div class="table-responsive">
														<table id="zero_config" class="table table-striped table-bordered">
															<thead>
															<tr>
																<th>Date</th>
																<th>Encaissé par</th>
																<th>Montant Versé</th>
															</tr>
															</thead>
															<tbody>
															<?php
																$versement = 0;
																foreach ($achat['Paiements'] as $paiement) {
																	$versement += $paiement->montant;
																	?>
																	<tr>
																		<td><?= date('d/m/Y', strtotime($paiement->datepaiement)) ?></td>
																		<td><?= $this->ion_auth->user($paiement->userid)->row()->first_name." ".$this->ion_auth->user($paiement->userid)->row()->last_name ?></td>
																		<td><?= $this->vente_m->formatNumber($paiement->montant) ?> FCFA</td>
																	</tr>
																	<?php
																}
															?>
															</tbody>
															<tbody>
																<tr>
																	<td colspan="2">Total Paiement</td>
																	<td>
																		<?= $this->vente_m->formatNumber($versement) ?> FCFA
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</fieldset>

									<?php
								}
							?>

						</div>
						<div class="card-footer text-right">
							<a href="<?= site_url("client/imprimerHistorique/".$clientId) ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
