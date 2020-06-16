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
						<li class="breadcrumb-item active">Commande Client</li>
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
				<?php echo form_open("paiement/validerversement", array('class'=>'form-horizontal col-12', 'id'=>'form'));?>
					<div class="row">
						<div class="col-md-6">
							<div class="card">
								<div class="card-body">
									<fieldset id="filedset0">
										<legend>Commande</legend>
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
											<div class="col-sm-9">
												<input type="text" class="form-control" readonly value="<?= $this->vente_m->formatNumber($returnArray['Vente']->montant + $mTVA) ?> FCFA">
											</div>
										</div>

										<div class="form-group row">
											<label for="" class="col-sm-3 text-right control-label col-form-label">Remise :</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" readonly value="<?= $this->vente_m->formatNumber($returnArray['TotalRemise']) ?> FCFA">
											</div>
										</div>

										<div class="form-group row">
											<label for="" class="col-sm-3 text-right control-label col-form-label">Net à Payer :</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" readonly value="<?= $this->vente_m->formatNumber($returnArray['Vente']->montant + $mTVA - $returnArray['TotalRemise']) ?> FCFA">
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
									</fieldset>
								</div>
							</div>
						</div>

						<input type="hidden" id="totalTTC" value="<?= $returnArray['Reste'] ?>">
						<input type="hidden" name="comdId" value="<?= $returnArray['Vente']->idvente ?>">
						<input type="hidden" name="token" value="<?= bin2hex(openssl_random_pseudo_bytes(50)) ?>">

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
										<legend>Paiement</legend>

										<div class="form-group row">
											<label for="moyen" class="col-sm-2 text-right control-label col-form-label">Moyen de Paiement :</label>
											<div class="col-sm-9">
												<select name="typepaiement" class="select2 form-control custom-select" id="moyen" style="border: 2px red solid">
													<option value="espece">Espèce</option>
													<option value="cheque">Chèque</option>
													<option value="mobile">Mobile Money</option>
												</select>
											</div>
										</div>

										<div class="form-group row chequeDiv d-none">
											<div class="col-md-6">
												<div class="row">
													<label for="numCheque" class="col-sm-4 text-right control-label col-form-label">N° du Chèque:</label>
													<div class="col-sm-8">
														<input type="number" id="numCheque" class="form-control" name="numerocheque" min="1" style="border: 2px red solid">
													</div>
												</div>
											</div>
											<div class="col-md-5">
												<div class="row">
													<label for="banque" class="col-sm-4 text-right control-label col-form-label">Banque:</label>
													<div class="col-sm-8">
														<input type="text" id="banque" class="form-control" name="nombanque" style="border: 2px red solid">
													</div>
												</div>
											</div>
										</div>

										<div class="form-group row">
											<label for="montV" class="col-sm-2 text-right control-label col-form-label">Somme Versé :</label>
											<div class="col-sm-9">
												<input type="number" id="montV" class="form-control" name="montV" min="1" style="border: 2px red solid">
												<input type="hidden" id="montVV" class="form-control" name="montVV" min="1">
											</div>
										</div>

										<div class="form-group row">
											<label for="reste" class="col-sm-2 text-right control-label col-form-label">Reste à payer :</label>
											<div class="col-sm-9">
												<input type="text" id="reste" readonly class="form-control">
											</div>
										</div>

									</fieldset>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<div class="form-group row mb-0">
										<div class="col-sm-12 text-center">
											<button class="btn btn-success" type="submit"> Effectuer le Paiement</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
