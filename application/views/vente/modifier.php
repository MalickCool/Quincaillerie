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
						<li class="breadcrumb-item active">Modifier Vente</li>
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
				<div class="col-md-12 col-sm-12">
					<div class="card">
						<div class="card-header">
							Modifier Vente
						</div>
						<div class="card-body">
							<?php echo form_open("vente/update", array('class'=>'form-horizontal', 'id'=>'form'));?>
							<div class="card-body">


								<fieldset id="filedset0">
									<legend>Détails Client</legend>
									<div class="form-group row">
										<label for="commercial_id" class="col-sm-2 text-left text-sm-right control-label col-form-label">Commercial</label>
										<div class="col-sm-4">
											<select id="commercial_id" name="commercial_id" class="select2 form-control custom-select" style="width: 100%; height:36px;">
												<option value="">Aucun</option>
												<?php
													foreach ($commerciaux as $commercial) {
														?>
														<option <?= ($returnArray['Commercial']->idcommercial == $commercial->idcommercial) ? 'selected' : ""; ?> value="<?= $commercial->idcommercial ?>"><?= $commercial->nom ?></option>
														<?php
													}
												?>
											</select>
											<?= form_error('commercial_id','<div class="alert alert-danger">','</div>');?>
										</div>

										<label for="client" class="col-sm-2 text-left text-sm-right control-label col-form-label">Client</label>
										<div class="col-sm-4">
											<select id="client" name="client_id" class="form-control" readonly style="width: 100%; height:36px;" required>
												<option value="<?= $client->idclient ?>"><?= $client->nom ?></option>
											</select>
											<?= form_error('client_id','<div class="alert alert-danger">','</div>');?>
										</div>

										<label for="tva" class="col-sm-1 d-none text-left text-sm-right control-label col-form-label">Appliquer TVA :</label>
										<div class="col-sm-2 d-none">
											<select id="tva" name="tva" class="select2 form-control custom-select theTVA" style="width: 100%; height:36px;">
												<option lang="18" value="1">18%</option>
											</select>
										</div>
									</div>
								</fieldset>

								<div class="form-group mt-3">
									<div class="col-sm-12">
										<button id="ajouter" class="btn btn-primary">Ajouter Produit</button>
									</div>
								</div>

								<fieldset id="fieldset">
									<legend>Produits Vendus</legend>

									<div id="add2">

										<?php
											foreach ($returnArray['Produits'] as $item) {
												?>
												<div class="form-group row">
													<div class="col-md-3">
														<label for="agglo" class="col-sm-12 text-left control-label col-form-label">Produit :</label>
														<div class="col-sm-12">
															<select name="lib2[]" class="select theSelect form-control custom-select" style="width: 100%; height:36px;">
																<option value="">Selectionner Produit</option>
																<?php
																	foreach ($produits as $produit) {
																		?>
																		<option <?php if($item['IdProduit'] == $produit['IdProduit']) echo 'selected'; ?> lang="<?= $produit['Prix'] ?>" value="<?= $produit['IdProduit'] ?>"><?= $produit['Designation'] ?></option>
																		<?php
																	}
																?>
															</select>
														</div>
													</div>

													<div class="col-md-3">
														<label for="qte" class="col-sm-12 pr-0 pl-0 text-left control-label col-form-label">Quantité :</label>
														<div class="col-sm-12">
															<input id="qte" type="number" name="qte[]" class="form-control theQte"  value="<?= $item['Qte'] ?>" required>
														</div>
													</div>

													<div class="col-md-3">
														<label for="cono1" class="col-sm-12 text-left control-label col-form-label">Total :</label>
														<div class="col-sm-12">
															<div class="input-group">
																<input type="number" value="<?= $item['Qte'] * ($item['Pu'] - $item['Remise']) ?>" disabled="disabled" name="total[]" class="form-control theTotal"  aria-label="Recipient 's username" aria-describedby="basic-addon2">
																<div class="input-group-append">
																	<span class="input-group-text" id="basic-addon2">FCFA</span>
																</div>
															</div>
														</div>
													</div>

													<div class="col-md-2 d-none">
														<label for="cono1" class="col-sm-12 text-left control-label col-form-label">Remise</label>
														<div class="col-sm-12">
															<input type="number" value="<?= $item['Remise'] ?>"  name="remise[]" class="form-control theRemise" id="cono1" required>
														</div>
													</div>


												</div>
												<?php
											}
										?>

									</div>
								</fieldset>

								<fieldset id="filedset0">
									<legend>Remise sur Commande</legend>
									<div class="form-group row">
										<label for="remiseMtnt" class="col-sm-3 text-right control-label col-form-label">Montant de la Remise:</label>
										<div class="col-sm-9">
											<input type="number" value="<?= $returnArray['Vente']->remisefacture ?>" name="remisefacture" class="form-control" style="border: 1px red solid;" id="remiseMtnt">
											<?= form_error('remisefacture','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>

								</fieldset>

								<fieldset>
									<legend>Montant Total</legend>

									<div class="form-group row">
										<label for="mht" class="col-sm-2 text-right control-label col-form-label">Montant HT</label>
										<div class="col-sm-9">
											<input readonly type="number" name="mont" class="form-control" id="mht" value="<?= $returnArray['Vente']->montant - $returnArray['Vente']->remisefacture ?>">
										</div>
									</div>

									<div class="form-group row">
										<label for="mttc" class="col-sm-2 text-right control-label col-form-label">Montant TTC</label>
										<div class="col-sm-9">
											<input disabled="disabled" type="number" name="mont" class="form-control" id="mttc" value="<?= $returnArray['MontTTC'] - $returnArray['Vente']->remisefacture ?>">
										</div>
									</div>
								</fieldset>

								<fieldset class="d-none">
									<legend>Paiement</legend>

									<div class="form-group row">
										<label for="montP" class="col-sm-2 text-right control-label col-form-label">Montant Payé</label>
										<div class="col-sm-9">
											<input type="number" name="montP" class="form-control" id="montP" value="">
										</div>
									</div>

									<div class="form-group row">
										<label for="rap" class="col-sm-2 text-right control-label col-form-label">Reste à Payer</label>
										<div class="col-sm-9">
											<input disabled="disabled" type="number" name="rap" class="form-control" id="rap" placeholder="" value="0">
										</div>
									</div>
								</fieldset>
							</div>
							<input type="hidden" name="token" value="<?= bin2hex(openssl_random_pseudo_bytes(50)) ?>">
							<input type="hidden" name="cmdID" value="<?= $returnArray['Vente']->idvente ?>">
							<div class="border-top text-center pt-3">
								<button type="submit" class="btn btn-primary">Enregistrer</button>
								<a href="<?= site_url("vente/index/") ?>" class="btn btn-danger">Quitter</a>
							</div>

							<input type="hidden" id="htWithoutTransport" value="<?= $returnArray['MontHT'] ?>">
							<input type="hidden" id="ttcWithoutTransport" value="<?= $returnArray['TotalTTC'] + $returnArray['Vente']->remisefacture ?>">

							<?php echo form_close();?>


							<div id="add" class="d-none">
								<div class="form-group row">
									<div class="col-md-3">
										<label for="cono1" class="col-sm-12 text-left control-label col-form-label">Produit :</label>
										<div class="col-sm-12">
											<select name="lib2[]" class="select theSelect form-control custom-select" style="width: 100%; height:36px;">
												<option value="">Selectionner Produit</option>
												<?php
													foreach ($produits as $produit) {
														?>
														<option lang="<?= $produit['Prix'] ?>" value="<?= $produit['IdProduit'] ?>"><?= $produit['Designation'] ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>



									<div class="col-md-3">
										<label for="qte" class="col-sm-12 pr-0 pl-0 text-left control-label col-form-label">Quantité :</label>
										<div class="col-sm-12">
											<input  type="number" name="qte[]" class="form-control theQte" id="cono1" placeholder="Qte" required>
										</div>
									</div>
									<div class="col-md-3">
										<label for="cono1" class="col-sm-12 text-left control-label col-form-label">Total :</label>
										<div class="col-sm-12">
											<div class="input-group">
												<input type="number" disabled="disabled" name="total[]" class="form-control theTotal"  aria-label="Recipient 's username" aria-describedby="basic-addon2">
												<div class="input-group-append">
													<span class="input-group-text" id="basic-addon2">FCFA</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2 d-none">
										<label for="cono1" class="col-sm-12 text-left control-label col-form-label">Remise</label>
										<div class="col-sm-12">
											<input  type="number" name="remise[]" class="form-control theRemise" id="cono1" value="0" required>
										</div>
									</div>

									<div class="col-md-1">
										<label for="cono1" class="col-sm-12 text-left control-label col-form-label">&nbsp;</label>
										<div class="col-sm-12">
											<button id="suppr" class="btn btn-danger"><i class="fa fa-trash"></i></button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
