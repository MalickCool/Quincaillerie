<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Gestion des Commerciaux</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Gestion Commerciale</li>
						<li class="breadcrumb-item active">Commerciaux</li>
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
				<div class="col-md-6 col-sm-12">
					<div class="card">
						<div class="card-header">
							Ajouter un Commercial
						</div>
						<div class="card-body">
							<?php echo form_open_multipart("commercial/insert", array('class'=>'form-horizontal', 'id'=>'form'));?>
								<div class="card-body">
									<div class="form-group row">
										<label for="type" class="col-sm-3 text-right control-label col-form-label"><b>Type Commercial</b></label>
										<div class="col-sm-9">
											<select id="type" name="typecommercial" required class="select2 form-control custom-select">
												<?php
													foreach ($types as $type) {
														?>
														<option value="<?= $type->idType ?>"><?= $type->designation ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label for="nom" class="col-sm-3 text-right control-label col-form-label pr-0">Nom & Prenom</label>
										<div class="col-sm-9">
											<input type="text" name="nom" class="form-control" required id="nom" placeholder="Nom et Prenom">
											<?= form_error('nom','<div class="alert alert-danger">','</div>');?>
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
									<a href="<?= site_url("commercial/index/") ?>" class="btn btn-danger">Quitter</a>
								</div>
							<?php echo form_close();?>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="card">
						<div class="card-header">
							Liste des Commerciaux
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>N° Commercial</th>
											<th>Nom & Prénom</th>
											<th>Type de Commerciaux</th>
											<th>Contact</th>
											<th>Etat</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach ($commerciaux as $list) {
												$status = "Activer";
												if($list->etat  > 0)
													$status = "Désactiver";
												?>
												<tr>
													<td>C<?= str_pad($list->idcommercial, 4, "0", STR_PAD_LEFT) ?></td>
													<td><?= $list->nom ?></td>
													<td><?= $this->typecommercial_m->get($list->type)->designation ?></td>
													<td><?= $list->phone ?></td>
													<td><?= $status ?></td>
													<td>
														<a href="<?= site_url("commercial/edit/".$list->idcommercial) ?>" class="btn btn-primary">Modifier</a>
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
							<a href="<?= site_url("commercial/imprimer") ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
