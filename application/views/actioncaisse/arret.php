<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Main content -->
	<section class="content pt-5">
		<div class="container-fluid">
			<div class="row">
				<div class="offset-md-3 col-md-6">
					<div class="card">
						<div class="card-header text-center font-weight-bolder colorOrange">
							Arrêt de Caisse
						</div>
						<div class="card-body">
							<?php echo form_open_multipart("actioncaisse/billetage", array('class'=>'form-horizontal', 'id'=>'form'));?>
								<input type="hidden" name="token" id="token" value="<?= bin2hex(openssl_random_pseudo_bytes(50)) ?>">
								<input type="hidden" name="idcaisse" value="<?= $caisse->idcaisse ?>">

								<fieldset>
									<legend>Arrêt caisse</legend>


									<div class="form-group row">
										<label for="codecaisse" class="col-md-5 col-sm-5 text-md-right control-label col-form-label"><b>Arrêt de caisse N°:</b></label>
										<div class="col-md-3 col-sm-7">
											<input type="text" name="codecaisse" value="<?= $_SESSION['IdAC'] ?>" readonly class="form-control font-weight-bolder" id="codecaisse">
										</div>
									</div>

									<fieldset>
										<legend>Caissier</legend>

										<div class="form-group row">
											<label for="utilisateur" class="col-sm-12 col-md-3 col-lg-2 text-left control-label col-form-label"><b>Caissier:</b></label>
											<div class="col-sm-12 col-md-9 col-lg-10">
												<input type="text" name="Utilisateur" class="form-control font-weight-bolder" readonly value="<?= $this->ion_auth->user($this->session->userdata('user_id'))->row()->first_name." ".$this->ion_auth->user($this->session->userdata('user_id'))->row()->last_name ?>" id="utilisateur" required>
											</div>
										</div>

										<div class="form-group row">
											<label for="codecaisse" class="col-sm-12 col-md-3 col-lg-2 text-left control-label col-form-label"><b>Caisse:</b></label>
											<div class="col-sm-12 col-md-9 col-lg-10">
												<input type="text" name="codecaisse" value="<?= $caisse->libelle ?>" readonly class="form-control font-weight-bolder" id="codecaisse">
											</div>
										</div>
									</fieldset>

									<fieldset>
										<legend>Date & Heure</legend>

										<div class="form-group row">
											<div class="col-sm-7">
												<div class="row">
													<label for="utilisateur" class="col-sm-12 col-md-3 col-lg-2 text-left control-label col-form-label"><b>Date:</b></label>
													<div class="col-sm-12 col-md-9 col-lg-10">
														<input type="text" name="Utilisateur" class="form-control font-weight-bolder" readonly value="<?= date("d/m/Y") ?>" id="utilisateur" required>
													</div>
												</div>
											</div>
											<div class="col-sm-5">
												<div class="row">
													<label for="codecaisse" class="col-sm-12 col-md-5 col-lg-3 text-left control-label col-form-label"><b>Heure:</b></label>
													<div class="col-sm-12 col-md-7 col-lg-9">
														<input type="text" name="codecaisse" value="<?= $caisse->libelle ?>" readonly class="form-control font-weight-bolder" id="codecaisse">
													</div>
												</div>
											</div>
										</div>
									</fieldset>

									<fieldset>
										<legend>Bilan Journalier</legend>

										<div class="form-group row">
											<div class="col-sm-6">
												<div class="row">
													<label for="utilisateur" class="col-sm-12 col-md-3 col-lg-2 text-left control-label col-form-label"><b>Entrée:</b></label>
													<div class="col-sm-12 col-md-9 col-lg-10">
														<input type="text" name="Utilisateur" class="form-control font-weight-bolder" readonly value="<?= $this->depense_m->formatNumber($Entree['Total']) ?> FCFA" id="utilisateur" required>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="row">
													<label for="codecaisse" class="col-sm-12 col-md-5 col-lg-3 text-left control-label col-form-label"><b>Sortie:</b></label>
													<div class="col-sm-12 col-md-7 col-lg-9">
														<input type="text" name="codecaisse" value="<?= $this->depense_m->formatNumber($Sortie['Total']) ?> FCFA" readonly class="form-control font-weight-bolder" id="codecaisse">
													</div>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label for="utilisateur" class="col-sm-12 col-md-3 col-lg-2 text-left control-label col-form-label"><b>Reste en caisse:</b></label>
											<div class="col-sm-12 col-md-9 col-lg-10">
												<input type="text" name="Utilisateur" class="form-control font-weight-bolder" readonly value="<?= $this->depense_m->formatNumber($Entree['Total'] - $Sortie['Total']) ?> FCFA" id="utilisateur" required>
											</div>
										</div>
									</fieldset>
								</fieldset>

								<div class="form-group row pt-4">
									<div class="col-sm-12 text-center">
										<button type="submit"  class="btn btn-primary"><i class="fa fa-chevron-circle-right"></i> Billetage</button>

										<a href="<?= site_url("accueil/index/") ?>" class="btn btn-danger"><i class="fa fa-window-close"></i> Annuler</a>
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
