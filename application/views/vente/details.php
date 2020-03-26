<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Gestion des Ventes</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Sce Commercial</li>
						<li class="breadcrumb-item active">Détails Commande Client</li>
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
				<div class="col-md-6">
					<div class="card">
						<div class="card-body">
							<fieldset id="filedset0">
								<legend>Vente</legend>
								<div class="form-group row">
									<label for="" class="col-sm-3 text-right control-label col-form-label">N° Vente :</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" readonly value="<?= $returnArray['Vente']->idvente ?>">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-3 text-right control-label col-form-label">Client :</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" readonly value="<?= $returnArray['Client']->nom ?>">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-3 text-right control-label col-form-label">Montant HT :</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" readonly value="<?= $this->vente_m->formatNumber($returnArray['Vente']->montant) ?> FCFA">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-3 text-right control-label col-form-label">TVA :</label>
									<div class="col-sm-2">
										<input type="text" class="form-control" readonly value="<?= $returnArray['Tva'] ?>%">
									</div>

									<label for="" class="col-sm-3 text-right control-label col-form-label">Montant TVA :</label>
									<?php
										$mTVA = $returnArray['Vente']->montant * $returnArray['Tva'] / 100;
									?>
									<div class="col-sm-4">
										<input type="text" class="form-control" readonly value="<?= $this->vente_m->formatNumber($mTVA) ?> FCFA">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-3 text-right control-label col-form-label">Montant TTC :</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" readonly value="<?= $this->vente_m->formatNumber($returnArray['Vente']->montant + $mTVA) ?> FCFA">
									</div>

									<label for="" class="col-sm-3 text-right control-label col-form-label">Remise :</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" readonly value="<?= $this->vente_m->formatNumber($returnArray['TotalRemise']) ?> FCFA">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-3 text-right control-label col-form-label">Net à Payer :</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" readonly value="<?= $this->vente_m->formatNumber($returnArray['TotalTTC']) ?> FCFA">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-3 text-right control-label col-form-label">Montant Payé :</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" readonly value="<?= $this->vente_m->formatNumber($returnArray['MontantVerse']) ?> FCFA">
									</div>
								</div>
								<div class="form-group row">
									<label for="" class="col-sm-3 text-right control-label col-form-label">Reste à payer :</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" readonly value="<?= $this->vente_m->formatNumber($returnArray['TotalTTC'] - $returnArray['MontantVerse']) ?> FCFA">
									</div>
								</div>

								<div class="text-right">
									<a href="<?= site_url("vente/imprimerCommande/".$returnArray['Vente']->idvente) ?>" target="_blank" class="btn btn-primary">
										<i class="fa fa-print"></i> Imprimer
									</a>
								</div>
							</fieldset>
						</div>
					</div>
				</div>

				<input type="hidden" id="totalTTC" value="<?= $returnArray['Vente']->montant + $mTVA ?>">
				<input type="hidden" name="comdId" value="<?= $returnArray['Vente']->idvente ?>">

				<div class="col-md-6">
					<div class="card" style="height: 95%">
						<div class="card-body">
							<fieldset id="filedset0" style="height: 100%">
								<legend>Produits Commandés</legend>

								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Produit</th>
											<th>Quantité</th>
											<th>Prix Unitaire</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$montantT = 0;
											foreach ($returnArray['Produits'] as $produit) {
												$montantT += ($produit['Qte'] * $produit['Pu']);
												?>
												<tr>
													<td><?= $produit['Produit'] ?></td>
													<td><?= $produit['Qte'] ?></td>
													<td><?= $produit['Pu'] ?></td>
													<td><?= $this->vente_m->formatNumber($produit['Qte'] * $produit['Pu']) ?></td>
												</tr>
												<?php
											}
										?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3">Total HT</td>
											<td><?= $this->vente_m->formatNumber($montantT) ?> FCFA</td>
										</tr>
									</tfoot>
								</table>
							</fieldset>
						</div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="card" style="height: 95%">
						<div class="card-body">
							<fieldset id="filedset0" style="height: 100%">
								<legend>Historique de Paiements</legend>

								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Date</th>
											<th>Encaissé Par</th>
											<th>Montant Versement</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$montantT = 0;
											foreach ($returnArray['Paiements'] as $paiement) {
												$montantT += $paiement->montant;
												?>
												<tr>
													<td><?= date("d/m/Y", strtotime($paiement->datepaiement)) ?></td>
													<td><?= $this->ion_auth->user($paiement->userid)->row()->first_name." ".$this->ion_auth->user($paiement->userid)->row()->last_name ?></td>
													<td><?= $this->vente_m->formatNumber($paiement->montant) ?> FCFA</td>
													<td class="text-center">
														<a href="<?= site_url("paiement/imprimerRecu/".$paiement->idpaiement) ?>" target="_blank" class="btn btn-primary">
															<i class="fa fa-print"></i> Imprimer
														</a>
													</td>
												</tr>
												<?php
											}
										?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="2">Total Payé</td>
											<td><?= $this->vente_m->formatNumber($montantT) ?> FCFA</td>
											<td></td>
										</tr>
									</tfoot>
								</table>
								<div class="text-right">
									<a href="" class="btn btn-primary">
										<i class="fa fa-print"></i> Imprimer
									</a>
								</div>
							</fieldset>
						</div>
					</div>
				</div>

				<?php
					$mTTC = $returnArray['Vente']->montant + $mTVA;
					if($returnArray['Vente']->etat != -1){
						if($montantT < $returnArray['TotalTTC']){
							?>
							<div class="col-md-12">
								<div class="card">
									<div class="card-body">
										<div class="form-group row mb-0">
											<div class="col-sm-12 text-center">
												<a class="btn btn-success" href="<?= site_url("paiement/ajouter/".$returnArray['Vente']->idvente) ?>"> Effectuer Versement</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
						}
					}
				?>
			</div>
		</div>
	</section>
</div>
