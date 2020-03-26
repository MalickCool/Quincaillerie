<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Gestion des Clients</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Gestion Commerciale</li>
						<li class="breadcrumb-item active">Client</li>
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
				<div class="col-md-6 col-sm-12">
					<div class="card">
						<div class="card-header">
							Ajouter un Client
						</div>
						<div class="card-body">
							<?php echo form_open_multipart("client/do_upload", array('class'=>'form-horizontal', 'id'=>'form'));?>
								<div class="card-body">
									<div class="form-group row">
										<label for="nom" class="col-sm-3 text-right control-label col-form-label pr-0">Nom & Prenom</label>
										<div class="col-sm-9">
											<input type="text" name="nom" class="form-control" required id="nom" placeholder="Nom et Prenom">
											<?= form_error('nom','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>

									<div class="form-group row d-none">
										<label for="adres" class="col-sm-3 text-right control-label col-form-label pr-0">Adresse</label>
										<div class="col-sm-9">
											<input type="text" name="adresse" class="form-control" id="adres" placeholder="Adresse">
											<?= form_error('adresse','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>

									<div class="form-group row d-none">
										<label for="email" class="col-sm-3 text-right control-label col-form-label pr-0">Email</label>
										<div class="col-sm-9">
											<input type="text" name="email" class="form-control" id="email" placeholder="Adresse Email">
											<?= form_error('email','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>

									<div class="form-group row">
										<label for="type_client" class="col-sm-3 text-right control-label col-form-label pr-0">Type de Client</label>
										<div class="col-sm-9">
											<select name="type_client" class="form-control select2" id="type_client">
												<option value="revendeur">Revendeur</option>
												<option value="ordinaire">Ordinaire</option>
											</select>
											<?= form_error('type_client','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>

									<div class="form-group row">
										<label for="tel" class="col-sm-3 text-right control-label col-form-label pr-0">Contact</label>
										<div class="col-sm-9">
											<input type="text" name="phone" class="form-control" required id="tel" placeholder="Numéro de téléphone">
											<?= form_error('phone','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>
								</div>
								<input type="hidden" name="token" value="<?= bin2hex(openssl_random_pseudo_bytes(50)) ?>">
								<div class="border-top text-center pt-3">
									<button type="submit" class="btn btn-primary">Enregistrer</button>
									<a href="<?= site_url("client/index/") ?>" class="btn btn-danger">Quitter</a>
								</div>
							<?php echo form_close();?>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="card">
						<div class="card-header">
							Liste des Clients
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>N° Client</th>
											<th>Nom & Prénom</th>
											<th>Contact</th>
											<th>Type de Client</th>
											<th>Etat</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach ($clients as $list) {
												$status = "Activer";
												if($list->etat  > 0)
													$status = "Désactiver";


												?>
												<tr>
													<td>C<?= str_pad($list->idclient, 4, "0", STR_PAD_LEFT) ?></td>
													<td><?= $list->nom ?></td>
													<td><?= $list->phone ?></td>
													<td><?= ucfirst($list->type_client) ?></td>
													<td><?= $status ?></td>
													<td>
														<a href="<?= site_url("client/edit/".$list->idclient) ?>" class="btn btn-primary">Modifier</a>
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
							<a href="<?= site_url("client/imprimer") ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
