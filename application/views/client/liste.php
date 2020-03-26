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
						<li class="breadcrumb-item active">Liste des Clients</li>
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
				<div class="col-md-12">
					<div class="card">
						<div class="card-header text-right">
							<a href="<?= site_url("client/ajouter") ?>" class="btn btn-primary"> <i class="fa fa-plus-circle"> Ajouter Client</i></a>
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
														<a href="<?= site_url("client/historique/".$list->idclient) ?>" class="btn btn-primary">Historique</a>
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
