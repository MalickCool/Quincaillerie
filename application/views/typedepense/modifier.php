<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Modifier un Type de Sortie de Caisse</h1>
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
						<?php echo form_open("typedepense/update", array('class'=>'form-horizontal', 'id'=>'form'));?>
							<div class="card-body">

								<div class="form-group row">
									<label for="libelle" class="col-sm-12 control-label col-form-label">Désignation <b style="color: #e74c3c; font-weight: bolder">*</b></label>
									<div class="col-sm-12">
										<input type="text" name="libelle" class="form-control" id="libelle" value="<?= $type->libelle ?>" required>
										<?= form_error('libelle','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>

								<div class="form-group row">
									<label for="description" class="col-sm-12 control-label col-form-label">Description</label>
									<div class="col-sm-12">
										<textarea name="description" id="description" class="form-control" cols="30" rows="10"><?= $type->description ?></textarea>
										<?= form_error('description','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>
							</div>
							<div class="border-top">
								<div class="card-body text-center">
									<a href="<?= site_url("typedepense/index/") ?>" class="btn btn-danger">
										<i class="fa fa-window-close"></i> Quitter
									</a>
									<button type="submit" class="btn btn-primary">
										<i class="fa fa-edit"></i> Modifier
									</button>
								</div>
							</div>
							<input type="hidden" name="id" value="<?= $type->idtypedepense ?>">
						<?php echo form_close();?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">Liste des Type de Sortie de Caisse</h4>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
									<tr>
										<th>Désignation</th>
										<th>Description</th>
										<th class="text-center">Action</th>
									</tr>
									</thead>
									<tbody>
									<?php
									foreach ($types as $item) {
										?>
										<tr>
											<td><?= $item->libelle ?></td>
											<td><?= $item->description ?></td>
											<td class="text-center">
												<a href="<?= site_url("typedepense/edit/".$item->idtypedepense) ?>" class="btn btn-danger">Modifier</a>
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
							<a href="<?= site_url("typedepense/imprimer") ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
