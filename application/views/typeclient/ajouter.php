<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Ajouter un Type de Client</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Configuration</li>
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
				<div class="col-md-6">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">Créer un Type de Client</h4>
						</div>
						<?php echo form_open("typeclient/insert", array('class'=>'form-horizontal', 'id'=>'form'));?>
							<div class="card-body">
								<div class="form-group row">
									<label for="designation" class="col-sm-12 control-label col-form-label">Désignation <b style="color: #e74c3c; font-weight: bolder">*</b></label>
									<div class="col-sm-12">
										<input type="text" name="designation" class="form-control" id="designation" placeholder="Désignation de Type de Commercial" required>
										<?= form_error('designation','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>

								<div class="form-group row">
									<label for="description" class="col-sm-12 control-label col-form-label">Description <b style="color: #e74c3c; font-weight: bolder">*</b></label>
									<div class="col-sm-12">
										<textarea name="description" id="description" class="form-control" cols="30" rows="10"></textarea>
										<?= form_error('description','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>
							</div>
							<div class="border-top">
								<div class="card-body text-center">
									<a href="<?= site_url("typeclient/index") ?>" class="btn btn-danger">
										<i class="fa fa-window-close"></i> Quitter
									</a>
									<button type="submit" class="btn btn-primary">
										<i class="fa fa-save"></i> Ajouter
									</button>
								</div>
							</div>
							<input type="hidden" name="token" value="<?= bin2hex(openssl_random_pseudo_bytes(50)) ?>">
						<?php echo form_close();?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">Liste des Type de Client</h4>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Désignation</th>
											<th>Description</th>
											<th class="text-center">Etat</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach ($types as $item) {
												$status = "Activer";
												if($item->etat  > 0)
													$status = "Désactiver";
												?>
												<tr>
													<td><?= $item->designation ?></td>
													<td><?= $item->description ?></td>
													<td class="text-center"><?= $status ?></td>
													<td class="text-center">
														<a href="<?= site_url("typeclient/edit/".$item->idType) ?>" class="btn btn-danger">Modifier</a>
													</td>
												</tr>
												<?php
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="card-footer text-right">
							<a href="<?= site_url("typeclient/imprimer") ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
