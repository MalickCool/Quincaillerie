<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Bon de Commande</h1>
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
				<div class="offset-md-3 col-md-6">
					<div class="card">
						<?php echo form_open_multipart("commande/disableBon", array('class'=>'form-horizontal', 'id'=>'form'));?>
							<div class="card-header">
								<h4 class="card-title">Annuler Bon de Commande <?= $bon->numbon ?></h4>
							</div>
							<div class="card-body">

								<div class="form-group row">
									<label for="motif" class="col-md-12 text-left control-label col-form-label">Motif de l'annulation</label>
									<div class="col-md-12">
										<textarea name="motif" id="motif" cols="30" class="form-control" required="required" rows="15"></textarea>
										<?= form_error('motif','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>
							</div>
							<div class="border-top">
								<div class="card-body text-center">
									<a href="<?= site_url("commande/index/") ?>" class="btn btn-danger"><i class="fa fa-window-close"></i> Quitter</a>
									<button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Valider</button>
								</div>
							</div>
							<input type="hidden" name="id" value="<?= $bon->idfacture ?>">
						<?php echo form_close();?>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
