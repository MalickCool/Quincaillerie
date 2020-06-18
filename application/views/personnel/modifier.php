<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Modifier Personnel</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">RH</li>
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
						<div class="card-header colorOrange font-weight-bolder">
							<h4 class="card-title"><?= $titre ?></h4>
						</div>
						<?php echo form_open("personnel/update", array('class'=>'form-horizontal', 'id'=>'form'));?>

						<div class="card-body">
							<div class="form-group row">
								<div class="col-md-6 pl-0">
									<label for="nom" class="col-sm-12 control-label col-form-label">Nom</label>
									<div class="col-sm-12">
										<input type="text" name="nom" class="form-control" id="nom" value="<?= $personnel->nom ?>" required>
										<?= form_error('nom','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>
								<div class="col-md-6 pl-0">
									<label for="prenom" class="col-sm-12 control-label col-form-label">Prénom</label>
									<div class="col-sm-12">
										<input type="text" name="prenom" class="form-control" id="prenom" value="<?= $personnel->prenom ?>" required>
										<?= form_error('prenom','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-5 pl-0">
									<label for="contact" class="col-sm-12 control-label col-form-label">Contact</label>
									<div class="col-sm-12">
										<input type="text" name="contact" class="form-control" id="contact" value="<?= $personnel->contact ?>" required>
										<?= form_error('contact','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>
								<div class="col-md-7 pl-0">
									<label for="statut" class="col-sm-12 control-label col-form-label">Statut</label>
									<div class="col-sm-12">
										<select name="statut" class="form-control select2" id="statut">
											<option <?= ($personnel->statut == "Permanent") ? "selected" : "" ?> value="Permanent">Permanent</option>
											<option <?= ($personnel->statut == "Temporaire") ? "selected" : "" ?> value="Temporaire">Temporaire</option>
										</select>
										<?= form_error('statut','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-7 pl-0">
									<label for="magasin_id" class="col-sm-12 control-label col-form-label">Magasin</label>
									<div class="col-sm-12">
										<select name="magasin_id" class="form-control select2" id="magasin_id">
											<?php
												foreach ($magasins as $magasin) {
													?>
													<option <?= ($personnel->magasin_id == $magasin->identrepot) ? "selected" : "" ?> value="<?= $magasin->identrepot ?>"><?= $magasin->designation ?></option>
													<?php
												}
											?>
										</select>
										<?= form_error('magasin_id','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>

								<div class="col-md-5 pl-0">
									<label for="fonction" class="col-sm-12 control-label col-form-label">Fonction</label>
									<div class="col-sm-12">
										<input type="text" name="fonction" class="form-control" id="fonction" value="<?= $personnel->fonction ?>" required>
										<?= form_error('fonction','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-sm-12">
									<div class="custom-control custom-checkbox mr-sm-2">
										<input type="checkbox" name="etat" class="custom-control-input" id="chb" <?php if($personnel->etat == 1) echo "checked"; ?> >
										<label class="custom-control-label" for="chb">Désactiver</label>
									</div>
								</div>
							</div>
						</div>

						<div class="border-top">
							<div class="card-body text-center">
								<a href="<?= site_url("accueil/index/") ?>" class="btn btn-danger">
									<i class="fa fa-window-close"></i> Quitter
								</a>
								<button type="submit" class="btn btn-primary">
									<i class="fa fa-edit"></i> Modifier
								</button>
							</div>
						</div>
						<input type="hidden" name="id" value="<?= $personnel->idpersonnel ?>">
						<?php echo form_close();?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card">
						<div class="card-header colorOrange font-weight-bolder">
							<h4 class="card-title">Liste du Personnel</h4>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Nom & Prénom</th>
											<th>Contact</th>
											<th>Statut</th>
											<th>Magasin</th>
											<th>Fonction</th>
											<th>Etat</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach ($personnels as $item) {
												$status = "Activer";
												if($item->etat  > 0)
													$status = "Désactiver";
												?>
												<tr>
													<td><?= $item->nom." ".$item->prenom ?></td>
													<td><?= $item->contact ?></td>
													<td><?= $item->statut ?></td>
													<td><?= $this->entrepot_m->get($item->magasin_id)->designation ?></td>
													<td><?= $item->fonction ?></td>
													<td><?= $status ?></td>
													<td>
														<a href="<?= site_url("personnel/edit/".$item->idpersonnel) ?>" class="btn btn-danger">Modifier</a>
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
							<a href="<?= site_url("personnel/imprimer") ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
