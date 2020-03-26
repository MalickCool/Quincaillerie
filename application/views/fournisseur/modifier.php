<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Modifier Fournisseur</h1>
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
						<?php echo form_open("fournisseur/update", array('class'=>'form-horizontal', 'id'=>'form'));?>
							<div class="card-header">
								<h4 class="card-title">Modifier Fournisseur <b><?= $fournisseur->designation ?></b></h4>
							</div>
							<div class="card-body">
								<div class="form-group row">
									<label for="designation" class="col-sm-12 control-label col-form-label">Désignation</label>
									<div class="col-sm-12">
										<input type="text" name="designation" class="form-control" id="designation" value="<?= $fournisseur->designation ?>" required>
										<?= form_error('designation','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>

								<div class="form-group row">
									<div class="col-sm-6 pl-0">
										<label for="contact" class="col-sm-12 control-label col-form-label">Téléphone</label>
										<div class="col-sm-12">
											<input type="text" name="contact" class="form-control" id="contact" value="<?= $fournisseur->contact ?>" required>
											<?= form_error('contact','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>

									<div class="col-sm-6 pl-0">
										<label for="email" class="col-sm-12 control-label col-form-label">Email</label>
										<div class="col-sm-12">
											<input type="email" name="email" class="form-control" id="email" value="<?= $fournisseur->email ?>">
											<?= form_error('email','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>
								</div>

								<div class="form-group row">
									<label for="situation" class="col-sm-12 control-label col-form-label">Situation</label>
									<div class="col-sm-12">
										<textarea name="situation" class="form-control" id="situation" rows="3"><?= $fournisseur->situation ?></textarea>
										<?= form_error('situation','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>

								<div class="form-group row">
									<div class="col-sm-12">
										<div class="custom-control custom-checkbox mr-sm-2">
											<input type="checkbox" name="etat" class="custom-control-input" id="chb" <?php if($fournisseur->etat == 1) echo "checked"; ?> >
											<label class="custom-control-label" for="chb">Désactiver</label>
										</div>
									</div>
								</div>
							</div>
							<div class="border-top">
								<div class="card-body">
									<button type="submit" class="btn btn-primary">Modifier</button>
									<a href="<?= site_url("fournisseur/index/") ?>" class="btn btn-danger">Quitter</a>
								</div>
							</div>
							<input type="hidden" name="id" value="<?= $fournisseur->idfournisseur ?>">
						<?php echo form_close();?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">Liste des Fournisseur</h4>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Désignation</th>
											<th>Contact</th>
											<th>Email</th>
											<th>Etat</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach ($fournisseurs as $item) {
												$status = "Activer";
												if($item->etat  > 0)
													$status = "Désactiver";
												?>
												<tr>
													<td><?= $item->designation ?></td>
													<td><?= $item->contact ?></td>
													<td><?= $item->email ?></td>
													<td><?= $status ?></td>
													<td>
														<a href="<?= site_url("fournisseur/edit/".$item->idfournisseur) ?>" class="btn btn-danger">Modifier</a>
													</td>
												</tr>
												<?php
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="card-footer text-right">
						<a href="<?= site_url("fournisseur/imprimer") ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
