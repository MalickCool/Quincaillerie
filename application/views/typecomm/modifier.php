<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Modifier Magasin</h1>
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
				<div class="col-md-6">
					<div class="card">
						<?php echo form_open("entrepot/update", array('class'=>'form-horizontal', 'id'=>'form'));?>
						<div class="card-body">
							<div class="form-group row">
								<label for="designation" class="col-sm-12 control-label col-form-label">Désignation</label>
								<div class="col-sm-12">
									<input type="text" name="designation" class="form-control" id="designation" value="<?= $entrepot->designation ?>" required>
									<?= form_error('designation','<div class="alert alert-danger">','</div>');?>
								</div>
							</div>

							<div class="form-group row">
								<label for="details" class="col-sm-12 control-label col-form-label">Description</label>
								<div class="col-sm-12">
									<textarea name="details" class="form-control" id="details" rows="3"><?= $entrepot->details ?></textarea>
									<?= form_error('details','<div class="alert alert-danger">','</div>');?>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-sm-12">
									<div class="custom-control custom-checkbox mr-sm-2">
										<input type="checkbox" name="etat" class="custom-control-input" id="chb" <?php if($entrepot->etat == 1) echo "checked"; ?> >
										<label class="custom-control-label" for="chb">Désactiver</label>
									</div>
								</div>
							</div>
						</div>
						<div class="border-top">
							<div class="card-body text-center">
								<a href="<?= site_url("entrepot/index/") ?>" class="btn btn-danger">
									<i class="fa fa-window-close"></i> Quitter
								</a>
								<button type="submit" class="btn btn-primary">
									<i class="fa fa-edit"></i> Modifier
								</button>
							</div>
						</div>
						<input type="hidden" name="id" value="<?= $entrepot->identrepot ?>">
						<?php echo form_close();?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">Liste des Magasins</h4>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Désignation</th>
											<th>Description</th>
											<th>Etat</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach ($entrepots as $item) {
												$status = "Activer";
												if($item->etat  > 0)
													$status = "Désactiver";
												?>
												<tr>
													<td><?= $item->designation ?></td>
													<td><?= $item->details ?></td>
													<td><?= $status ?></td>
													<td>
														<a href="<?= site_url("entrepot/edit/".$item->identrepot) ?>" class="btn btn-danger">Modifier</a>
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
							<a href="<?= site_url("entrepot/imprimer") ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
