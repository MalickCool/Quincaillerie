<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Service Génie Civil</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item">Génie Civil</li>
						<li class="breadcrumb-item active">Matériaux</li>
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
						<div class="card-header colorOrange font-weight-bolder">
							Choix de Matériaux
						</div>
						<div class="card-body pt-0">
							<?php echo form_open("service/materiaux", array('class'=>'form-horizontal', 'id'=>'form'));?>
								<div class="card-body pt-0">
									<fieldset id="filedset0" class="d-none">
										<select id="tva" name="tva" class="d-none">
											<option lang="18" value="1">18%</option>
										</select>
									</fieldset>

									<div class="form-group mt-3">
										<div class="col-sm-12">
											<button id="ajouter" class="btn btn-primary">Ajouter Matériaux</button>
										</div>
									</div>

									<fieldset id="fieldset">
										<legend>Produits Commandés</legend>

										<div id="add2">
											<div class="form-group row">
												<div class="col-md-3">
													<label for="agglo" class="col-sm-12 text-left control-label col-form-label">Produit :</label>
													<div class="col-sm-12">
														<select id="agglo" name="lib2[]" class="select2 theSelect form-control custom-select" style="width: 100%; height:36px;" required>
															<option value="">Selectionner un Produit</option>
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
														<input id="qte" min="1" type="number" name="qte[]" class="form-control theQte"  placeholder="Qte" required>
													</div>
												</div>
												<div class="col-md-3">
													<label for="cono1" class="col-sm-12 text-left control-label col-form-label">Total :</label>
													<div class="col-sm-12">
														<div class="input-group">
															<input type="number" value="" disabled="disabled" name="total[]" class="form-control theTotal"  aria-label="Recipient 's username" aria-describedby="basic-addon2">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">FCFA</span>
															</div>
														</div>
													</div>
												</div>

												<div class="col-md-2 d-none">
													<label for="cono1" class="col-sm-12 text-left control-label col-form-label">Remise</label>
													<div class="col-sm-12">
														<input  type="number" name="remise[]" class="form-control theRemise" id="cono1" value="0">
													</div>
												</div>

											</div>
										</div>
									</fieldset>

									<fieldset id="filedset0">
										<legend>Remise sur Facture</legend>
										<div class="form-group row">
											<label for="remiseMtnt" class="col-sm-3 text-right control-label col-form-label">Montant de la Remise:</label>
											<div class="col-sm-9">
												<input type="number" name="remisefacture" class="form-control" style="border: 1px red solid;" id="remiseMtnt">
												<?= form_error('remisefacture','<div class="alert alert-danger">','</div>');?>
											</div>
										</div>

									</fieldset>

									<fieldset>
										<legend>Montant Total</legend>

										<div class="form-group row">
											<label for="mht" class="col-sm-2 text-right control-label col-form-label">Montant HT</label>
											<div class="col-sm-9">
												<input readonly type="number" name="mont" class="form-control" id="mht" value="0">
											</div>
										</div>

										<div class="form-group row">
											<label for="mttc" class="col-sm-2 text-right control-label col-form-label">Montant TTC</label>
											<div class="col-sm-9">
												<input disabled="disabled" type="number" name="mont" class="form-control" id="mttc" placeholder="" value="0">
											</div>
										</div>
									</fieldset>
								</div>
								<input type="hidden" name="token" value="<?= bin2hex(openssl_random_pseudo_bytes(50)) ?>">
								<input type="hidden" name="serviceId" value="<?= $service->idservice ?>">
								<div class="border-top text-center pt-3">
									<button type="submit" class="btn btn-primary">Enregistrer</button>
									<a href="<?= site_url("commande/index/") ?>" class="btn btn-danger">Quitter</a>
								</div>

								<input type="hidden" id="htWithoutTransport">
								<input type="hidden" id="ttcWithoutTransport">

							<?php echo form_close();?>


							<div id="add" class="d-none">
								<div class="form-group row">
									<div class="col-md-3">
										<label for="cono1" class="col-sm-12 text-left control-label col-form-label">Produit :</label>
										<div class="col-sm-12">
											<select name="lib2[]" class="select theSelect form-control custom-select" style="width: 100%; height:36px;">
												<option value="">Selectionner un Produit</option>
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
											<input  type="number"  min="1" name="qte[]" class="form-control theQte" id="cono1" placeholder="Qte" required>
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
											<input  type="number" name="remise[]" class="form-control theRemise" id="cono1" value="0" >
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
