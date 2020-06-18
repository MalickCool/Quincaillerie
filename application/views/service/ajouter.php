<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Enregistrer un nouveau Chantier</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Service Génie Civil</li>
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
							<h4 class="card-title">Nouveau Chantier</h4>
						</div>
						<?php echo form_open_multipart("service/insert", array('class'=>'form-horizontal', 'id'=>'form'));?>
							<div class="card-body">

								<div class="form-group row">
									<label for="typeservice" class="col-sm-12 control-label col-form-label">Type de Chantier</label>
									<div class="col-sm-12">
										<select name="typeservice" id="typeservice" required class="select2 form-control custom-select">
											<option value="Construction">Construction</option>
											<option value="Aménagement">Aménagement</option>
											<option value="Expertise">Expertise</option>
										</select>
										<?= form_error('typeservice','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>

								<div class="form-group row">
									<label for="client_id" class="col-sm-12 control-label col-form-label">Client</label>
									<div class="col-sm-12">
										<select name="client_id" class="form-control select2" id="client_id">
											<?php
											foreach ($clients as $client) {
												?>
												<option value="<?= $client->idclient ?>"><?= $client->nom ?></option>
												<?php
											}
											?>
										</select>
										<?= form_error('client_id','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>

								<div class="form-group row">
									<label for="adresse" class="col-sm-12 control-label col-form-label">Adresse d'exécution</label>
									<div class="col-sm-12">
										<input type="text" name="adresse" class="form-control" id="adresse" placeholder="Adresse d'exécution du chantier" required>
										<?= form_error('adresse','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>

								<div class="form-group row">
									<div class="col-md-6 pl-0">
										<label for="datedebut" class="col-sm-12 control-label col-form-label">Date de Début</label>
										<div class="col-sm-12">
											<input type="date" name="datedebut" class="form-control" id="datedebut" placeholder="Date de Début">
											<?= form_error('datedebut','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>
									<div class="col-md-6">
										<label for="delai" class="col-sm-12 control-label col-form-label">Délai d'exécution <small>(en Jour)</small></label>
										<div class="col-sm-12">
											<input type="number" name="delai" class="form-control" id="delai" placeholder="Délai d'exécution" required>
											<?= form_error('delai','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>
								</div>

								<div class="form-group row">
									<label for="detail" class="col-sm-12 control-label col-form-label">Détail du Chantier</label>
									<div class="col-sm-12">
										<textarea name="detail" id="detail" cols="30" class="form-control" rows="3"></textarea>
										<?= form_error('detail','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>

								<div class="form-group row">
									<label for="montant" class="col-sm-12 control-label col-form-label">Main d'oeuvre</label>
									<div class="col-sm-12">
										<input type="number" name="montant" class="form-control" id="montant" placeholder="Montant de la mains d'oeuvre" required>
										<?= form_error('montant','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>

							</div>
							<div class="border-top">
								<div class="card-body text-center">
									<a href="<?= site_url("accueil/index/") ?>" class="btn btn-danger">
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
							<h4 class="card-title">Liste des Familles</h4>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Désignation</th>
											<th>Etat</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
										foreach ($familles as $item) {
											$status = "Activer";
											if($item->etat  > 0)
												$status = "Désactiver";
											?>
											<tr>
												<td><?= $item->libelle ?></td>
												<td><?= $status ?></td>
												<td>
													<a href="<?= site_url("famille/edit/".$item->idfamille) ?>" class="btn btn-danger">Modifier</a>
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
						<a href="<?= site_url("famille/imprimer") ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
