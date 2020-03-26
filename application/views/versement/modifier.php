<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Modifier un Approvisionnement Caisse</h1>
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
				<div class="offset-md-3 col-md-6">
					<div class="card">
						<?php echo form_open("versement/update", array('class'=>'form-horizontal', 'id'=>'form'));?>
						<div class="card-body">

							<div class="form-group row">
								<label for="montant" class="col-sm-12 control-label col-form-label">Montant du Versement</label>
								<div class="col-sm-12">
									<input type="number" name="montant" class="form-control" id="montant" value="<?= $versement->montant ?>">
									<?= form_error('montant','<div class="alert alert-danger">','</div>');?>
								</div>
							</div>

							<div class="form-group row">
								<label for="motifversement" class="col-sm-12 control-label col-form-label">Description</label>
								<div class="col-sm-12">
									<textarea name="motifversement" class="form-control" id="motifversement" rows="12"><?= $versement->motifversement ?></textarea>
									<?= form_error('motifversement','<div class="alert alert-danger">','</div>');?>
								</div>
							</div>
						</div>
						<div class="border-top">
							<div class="card-body text-center">
								<button type="submit" class="btn btn-primary">Modifier</button>
								<a href="<?= site_url("versement/index/") ?>" class="btn btn-danger">Quitter</a>
							</div>
						</div>
						<input type="hidden" name="id" value="<?= $versement->idversement ?>">
						<?php echo form_close();?>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
