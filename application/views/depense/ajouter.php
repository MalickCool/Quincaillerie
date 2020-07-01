<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Sortie de Caisse</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Caisse</li>
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
				<?php
				if(isset($_SESSION['message'])){
					?>

					<div class="alert alert-success col-md-12" role="alert">
						<?= $_SESSION['message'] ?>
					</div>

					<?php
				}
				?>
				<div class="offset-md-3 col-md-6">
					<div class="card">
						<?php echo form_open("depense/insert", array('class'=>'form-horizontal', 'id'=>'form'));?>
						<div class="card-body">

							<div class="form-group row">
								<div class="col-sm-6 pl-0 pr-0">
									<label for="typeDepense" class="col-sm-12 control-label col-form-label">Type de Sortie de Caisse <b style="color: #e74c3c; font-weight: bolder">*</b></label>
									<div class="col-sm-12">
										<select class="select2 form-control custom-select" name="typedepense" id="typeDepense">
											<?php
												foreach ($types as $type) {
													?>
													<option value="<?= $type->idtypedepense ?>"><?= $type->libelle ?></option>
													<?php
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-sm-6 pl-0 pr-0">
									<label for="montant" class="col-sm-12 control-label col-form-label">Montant de la Transaction <b style="color: #e74c3c; font-weight: bolder">*</b></label>
									<div class="col-sm-12">
										<input type="number" name="montant" class="form-control" id="montant" placeholder="Montant de la dépense">
										<?= form_error('montant','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<label for="motifdepense" class="col-sm-12 control-label col-form-label">Motif de la Transaction <b style="color: #e74c3c; font-weight: bolder">*</b></label>
								<div class="col-sm-12">
									<textarea name="motifdepense" class="form-control" id="motifdepense" rows="12"> </textarea>
									<?= form_error('motifdepense','<div class="alert alert-danger">','</div>');?>
								</div>
							</div>
						</div>
						<div class="border-top">
							<div class="card-body text-center">
								<a href="<?= site_url("accueil/index/") ?>" class="btn btn-danger"><i class="fa fa-window-close"></i> Quitter</a>
								<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Ajouter</button>
							</div>
						</div>
						<input type="hidden" name="token" value="<?= bin2hex(openssl_random_pseudo_bytes(50)) ?>">
						<?php echo form_close();?>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
