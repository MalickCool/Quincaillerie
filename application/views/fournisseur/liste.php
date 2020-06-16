<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Liste des Fournisseurs</h1>
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
				<div class="col-md-12">
					<div class="card">
						<div class="card-header text-right">
							<a href="<?= site_url("fournisseur/ajouter") ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Ajouter Fournisseur</a>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Désignation</th>
											<th>Contact</th>
											<th>Email</th>

											<th>NCC</th>
											<th>RCCM</th>
											<th>N° Compte</th>

											<th>Représentant</th>
											<th>Fonction</th>
											<th>Contact Professionnel</th>
											<th>Contact Personnel</th>

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

													<td><?= $item->ncc ?></td>
													<td><?= $item->rccm ?></td>
													<td><?= $item->ncb ?></td>

													<td><?= $item->nomRep ?></td>
													<td><?= $item->fonction ?></td>
													<td><?= $item->contactProfessionnel ?></td>
													<td><?= $item->contactPersonnel ?></td>

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

