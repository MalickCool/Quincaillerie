<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">

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
										<label for="type_client" class="col-sm-3 text-right control-label col-form-label pr-0">Type de Client</label>
										<div class="col-sm-9">
											<select name="type_client" class="form-control select2" id="type_client">
												<?php
													foreach ($types as $type) {
														?>
														<option value="<?= $type->idType ?>"><?= $type->designation ?></option>
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
												<input type="text" name="raisonsociale" class="form-control" id="raisonsociale" placeholder="Raison Sociale">
												<?= form_error('raisonsociale','<div class="alert alert-danger">','</div>');?>
											</div>
										</div>

										<div class="form-group row" id="">
											<label for="ncc" class="col-sm-3 text-right control-label col-form-label pr-0">NCC</label>
											<div class="col-sm-9">
												<input type="text" name="ncc" class="form-control" id="ncc" placeholder="Numéro Compte Contribuable">
												<?= form_error('email','<div class="alert alert-danger">','</div>');?>
											</div>
										</div>
									</fieldset>

									<fieldset>
										<legend>Autre Type de Client</legend>

										<div class="form-group row">
											<label for="nom" class="col-sm-3 text-right control-label col-form-label pr-0">Nom & Prenom</label>
											<div class="col-sm-9">
												<input type="text" name="nom" class="form-control" id="nom" placeholder="Nom et Prenom">
												<?= form_error('nom','<div class="alert alert-danger">','</div>');?>
											</div>
										</div>

										<div class="form-group row">
											<label for="profession" class="col-sm-3 text-right control-label col-form-label pr-0">Profession</label>
											<div class="col-sm-9">
												<input type="text" name="profession" class="form-control" id="profession" placeholder="Adresse">
												<?= form_error('profession','<div class="alert alert-danger">','</div>');?>
											</div>
										</div>

										<div class="form-group row">
											<label for="adres" class="col-sm-3 text-right control-label col-form-label pr-0">Domicile</label>
											<div class="col-sm-9">
												<input type="text" name="adresse" class="form-control" id="adres" placeholder="Adresse">
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
											<label for="tel" class="col-sm-3 text-right control-label col-form-label pr-0">Contact</label>
											<div class="col-sm-9">
												<input type="text" name="phone" class="form-control" required id="tel" placeholder="Numéro de téléphone">
												<?= form_error('phone','<div class="alert alert-danger">','</div>');?>
											</div>
										</div>

										<div class="form-group row">
											<label for="observation" class="col-sm-3 text-right control-label col-form-label pr-0">Observation</label>
											<div class="col-sm-9">
												<textarea name="observation" id="observation" cols="30" rows="3" class="form-control"></textarea>
												<?= form_error('observation','<div class="alert alert-danger">','</div>');?>
											</div>
										</div>
									</fieldset>
								</div>
								<input type="hidden" name="token" value="<?= bin2hex(openssl_random_pseudo_bytes(50)) ?>">
								<div class="border-top text-center pt-3">
									<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Enregistrer</button>
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
