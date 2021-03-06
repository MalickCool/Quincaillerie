<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Etat du Stock</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Stock</li>
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
						<div class="card-header">
							<div class="row">
								<div class="col-sm-12 text-right pb-2">
									<a href="<?= site_url("produit/ajouter") ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Ajouter Produit</a>
									<a href="<?= site_url("commande/ajouter") ?>" class="btn btn-success"><i class="fa fa-plus"></i> Facture d'Achat</a>
									<a href="<?= site_url("inventaire/index") ?>" class="btn btn-danger"><i class="fa fa-circle-notch"></i> Inventaire</a>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Produit</th>
											<?php
												foreach ($entrepots as $entrepot) {
													?>
													<th class="text-center"><?= $entrepot->designation ?></th>
													<?php
												}
											?>
											<th class="text-center">Seuil d'Alerte</th>
											<th class="text-center">Total Qté</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach ($stocks as $item) {
												?>
												<tr>
													<td><?= $item['Produit']->designation ?></td>
													<?php
														$total = 0;
														foreach ($entrepots as $entrepot) {
															$total += $item['Quantité'][$entrepot->identrepot];
															?>
															<td class="text-center"><?= $item['Quantité'][$entrepot->identrepot] ?></td>
															<?php
														}
													?>
													<td class="text-center"><?= round($item['Produit']->seuil, 2) ?></td>
													<td class="text-center"><?= $this->stock_m->formatNumber($total) ?></td>
												</tr>
												<?php
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
