<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Main content -->
	<section class="content pt-5">
		<div class="container-fluid">
			<div class="row">
				<div class="offset-md-3 col-md-6">
					<div class="card">
						<div class="card-header text-center font-weight-bolder colorOrange">
							Réouverture de Caisse
						</div>
						<div class="card-body">
							<?php echo form_open_multipart("#", array('class'=>'form-horizontal', 'id'=>'form'));?>
								<input type="hidden" name="token" id="token" value="<?= bin2hex(openssl_random_pseudo_bytes(50)) ?>">
								<input type="hidden" name="idcaisse" value="<?= $caisse->idcaisse ?>">

								<div class="form-group row">
									<label for="codecaisse" class="col-md-5 col-sm-5 text-md-right control-label col-form-label"><b>Caisse:</b></label>
									<div class="col-md-3 col-sm-7">
										<input type="text" name="codecaisse" value="<?= $caisse->libelle ?>" readonly class="form-control font-weight-bolder" id="codecaisse">
									</div>
								</div>

								<fieldset>
									<legend>Caissier du jour</legend>

									<div class="form-group row">
										<label for="utilisateur" class="col-sm-12 col-md-5 col-lg-3 text-left control-label col-form-label"><b>Utilisateur:</b></label>
										<div class="col-sm-12 col-md-7 col-lg-9">
											<input type="text" name="Utilisateur" class="form-control font-weight-bolder" readonly value="<?= $utilisateur ?>" id="utilisateur" required>
										</div>
									</div>

									<div class="form-group row">
										<label for="password" class="col-sm-12 col-md-5 col-lg-3 text-left control-label col-form-label"><b>Mot de Passe:</b></label>
										<div class="col-sm-12 col-md-7 col-lg-9">
											<input type="password" name="password" class="form-control font-weight-bolder" id="password" required>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-md-12 pd0 text-center fontRed font-weight-bolder" id="changeName"></div>
									</div>
								</fieldset>

								<div class="form-group row pt-4">
									<div class="col-sm-12 text-center">
										<button type="submit" id="reOpenCaisse" class="btn btn-primary"><i class="fa fa-unlock-alt"></i> Réouvrir Caisse</button>
										<a href="<?= site_url("accueil/index/") ?>" class="btn btn-danger"><i class="fa fa-window-close"></i> Quitter</a>
									</div>
								</div>
							<?php echo form_close();?>

							<input type="hidden" value="<?= site_url("vente/selectCustomer") ?>" id="link">
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
