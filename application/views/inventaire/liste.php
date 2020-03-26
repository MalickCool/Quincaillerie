<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Inventaire</h1>
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
								<div class="col-sm-8">
									<h3>Lieu de stockage sélectionné : <?= $entrepot->designation ?></h3>
								</div>
								<div class="col-sm-4 text-right">
									<a href="<?= site_url("inventaire/index") ?>" class="btn btn-danger"> Annuler</a>
								</div>
							</div>
						</div>
						<div class="card-body">
							<?php echo form_open_multipart("inventaire/insert", array('class'=>'form-horizontal', 'id'=>'form'));?>
								<div class="table-responsive">
									<table id="zero_config" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th class="text-center">Produit</th>
												<th class="text-center">Quantité Théorique</th>
												<th class="text-center">Quantité Réelle</th>
											</tr>
										</thead>
										<tbody>
											<?php
												foreach ($stocks as $stock) {
													?>
													<tr>
														<td><?= $stock['designation'] ?></td>
														<td class="text-center"><?= $stock['Qte'] ?></td>
														<td class="text-center">
															<input name="old[<?= $stock['id'] ?>]" type="hidden" value="<?= $stock['Qte'] ?>" min="0">
															<input name="new[<?= $stock['id'] ?>]" type="number" step="0.00000000000001" class="form-control offset-sm-4 col-sm-4" value="<?= $stock['Qte'] ?>" min="0">
														</td>
													</tr>
													<?php
												}
											?>
										</tbody>
									</table>
								</div>

								<input type="hidden" name="token" value="<?= bin2hex(openssl_random_pseudo_bytes(50)) ?>">
								<input type="hidden" name="entrepot" value="<?= $entrepot->identrepot ?>">

								<div class="col-sm-12 text-center">
									<a href="<?= site_url("inventaire/index") ?>" class="btn btn-danger"> <i class="fa fa-window-close"></i> Annuler</a>
									<button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Valider</button>
								</div>

							<?php echo form_close();?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
