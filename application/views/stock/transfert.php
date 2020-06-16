<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Transfert Interne de Stock</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Stock</li>
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
				<form action="<?= site_url("stock/transfert_step2") ?>" method="post" class="form-horizontal col-12">
					<div class="row">
						<div class="offset-md-3 col-md-6">
							<div class="card">
								<div class="card-header colorOrange">
									Choix des Magasins
								</div>
								<div class="card-body">
									<div class="form-group row">
										<div class="col-sm-6">
											<label for="idmagasin" class="col-sm-12 control-label col-form-label">Transférer De</label>
											<div class="col-sm-12">
												<select name="de" id="idmagasin" required class="select2 form-control custom-select">
													<?php
													foreach ($entrepots as $entrepot) {
														?>
														<option value="<?= $entrepot->identrepot ?>"><?= $entrepot->designation ?></option>
														<?php
													}
													?>
												</select>
												<?= form_error('de','<div class="alert alert-danger">','</div>');?>
											</div>
										</div>

										<div class="col-sm-6">
											<label for="idmagasin2" class="col-sm-12 control-label col-form-label">Vers</label>
											<div class="col-sm-12">
												<select name="vers" id="idmagasin2" required class="select2 form-control custom-select">
													<?php
													foreach ($entrepots as $entrepot) {
														?>
														<option value="<?= $entrepot->identrepot ?>"><?= $entrepot->designation ?></option>
														<?php
													}
													?>
												</select>
												<?= form_error('vers','<div class="alert alert-danger">','</div>');?>
											</div>
										</div>
									</div>
								</div>

								<div class="border-top">
									<div class="card-body text-center">
										<a href="<?= site_url("accueil/index/") ?>" class="btn btn-danger">
											<i class="fa fa-window-close"></i> Annuler
										</a>
										<button type="submit" class="btn btn-primary">
											Continuer <i class="fa fa-chevron-circle-right"></i>
										</button>
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
