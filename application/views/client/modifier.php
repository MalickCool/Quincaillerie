<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Modification de Client</h1>
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
				<div class="col-md-6">
					<div class="card">
						<?php echo form_open_multipart("client/update", array('class'=>'form-horizontal', 'id'=>'form'));?>
							<div class="card-body">
								<?php
									$raisonSociale = ($client->ncc != "") ? $client->nom : "";
									$nom = ($client->ncc == "") ? $client->nom : "";
								?>

								<div class="form-group row">
									<label for="type_client" class="col-sm-3 text-right control-label col-form-label pr-0">Type de Client <b style="color: #e74c3c; font-weight: bolder">*</b></label>
									<div class="col-sm-9">
										<select name="type_client" class="form-control select2" id="type_client">
											<?php
												foreach ($types as $type) {
													?>
													<option <?= ($type->idType == $client->type_client) ? "selected" : "" ?> value="<?= $type->idType ?>"><?= $type->designation ?></option>
													<?php
												}
											?>
										</select>
										<?= form_error('type_client','<div class="alert alert-danger">','</div>');?>
									</div>
								</div>

								<fieldset>
									<legend>Entreprise</legend>

									<div class="form-group row" id="">
										<label for="raisonsociale" class="col-sm-3 text-right control-label col-form-label pr-0">Raison Sociale</label>
										<div class="col-sm-9">
											<input type="text" name="raisonsociale" class="form-control" id="raisonsociale" value="<?= $raisonSociale ?>">
											<?= form_error('raisonsociale','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>

									<div class="form-group row" id="">
										<label for="ncc" class="col-sm-3 text-right control-label col-form-label pr-0">NCC</label>
										<div class="col-sm-9">
											<input type="text" name="ncc" class="form-control" id="ncc" value="<?= $client->ncc ?>">
											<?= form_error('ncc','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>
								</fieldset>

								<fieldset>
									<legend>Autre Type de Client</legend>

									<div class="form-group row">
										<label for="nom" class="col-sm-3 text-right control-label col-form-label pr-0">Nom & Prenom <b style="color: #e74c3c; font-weight: bolder">*</b></label>
										<div class="col-sm-9">
											<input type="text" name="nom" class="form-control" id="nom" value="<?= $nom ?>">
											<?= form_error('nom','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>

									<div class="form-group row">
										<label for="profession" class="col-sm-3 text-right control-label col-form-label pr-0">Profession <b style="color: #e74c3c; font-weight: bolder">*</b></label>
										<div class="col-sm-9">
											<input type="text" name="profession" class="form-control" id="profession" value="<?= $client->profession ?>">
											<?= form_error('profession','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>

									<div class="form-group row">
										<label for="adres" class="col-sm-3 text-right control-label col-form-label pr-0">Domicile <b style="color: #e74c3c; font-weight: bolder">*</b></label>
										<div class="col-sm-9">
											<input type="text" name="adresse" class="form-control" id="adres" value="<?= $client->adresse ?>">
											<?= form_error('adresse','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>
								</fieldset>

								<fieldset>
									<legend>Informations Générales</legend>

									<div class="form-group row d-none">
										<label for="email" class="col-sm-3 text-right control-label col-form-label pr-0">Email</label>
										<div class="col-sm-9">
											<input type="text" name="email" class="form-control" id="email" placeholder="Adresse Email">
											<?= form_error('email','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>

									<div class="form-group row">
										<label for="tel" class="col-sm-3 text-right control-label col-form-label pr-0">Contact <b style="color: #e74c3c; font-weight: bolder">*</b></label>
										<div class="col-sm-9">
											<input type="text" name="phone" class="form-control" required id="tel" value="<?= $client->phone ?>">
											<?= form_error('phone','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>

									<div class="form-group row">
										<label for="observation" class="col-sm-3 text-right control-label col-form-label pr-0">Observation</label>
										<div class="col-sm-9">
											<textarea name="observation" id="observation" cols="30" rows="3" class="form-control"><?= $client->observation ?></textarea>
											<?= form_error('observation','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>
								</fieldset>






















								<div class="form-group row">
									<div class="offset-sm-3 col-sm-9">
										<div class="custom-control custom-checkbox mr-sm-2">
											<input type="checkbox" name="etat" class="custom-control-input" id="chb" <?php if($client->etat == 1) echo "checked"; ?> >
											<label class="custom-control-label" for="chb">Désactiver</label>
										</div>
									</div>
								</div>
							</div>
							<div class="border-top">
								<div class="card-body text-center">
									<button type="submit" class="btn btn-primary">Modifier</button>
									<a href="<?= site_url("client/index/") ?>" class="btn btn-danger">Quitter</a>
								</div>
							</div>
							<input type="hidden" name="id" value="<?= $client->idclient ?>">
						<?php echo form_close();?>
					</div>
				</div>
				<div class="col-md-6">
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
											<td><?= $this->typeclient_m->get($list->type_client)->designation ?></td>
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
