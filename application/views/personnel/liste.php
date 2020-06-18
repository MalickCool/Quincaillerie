<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Liste du Personnel</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Edition</li>
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

