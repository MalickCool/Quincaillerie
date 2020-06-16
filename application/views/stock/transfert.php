<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">

			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<form action="<?= site_url("stock/insertTransfert") ?>" method="post" class="form-horizontal col-12">

					<input type="hidden" name="de" value="<?= $de->identrepot ?>">
					<input type="hidden" name="vers" value="<?= $vers->identrepot ?>">

					<div class="row">
						<div class="offset-md-3 col-md-6">
							<div class="card">
								<div class="card-header colorOrange font-weight-bolder">
									Transfert de Stock de <?= $de->designation ?> vers <?= $vers->designation ?><br>
									Quantité à Transférer
								</div>
								<div class="card-body">
									<table id="" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th>Article</th>
												<th style="width: 35%" class="text-center">Quantité</th>
											</tr>
										</thead>
										<tbody>
										<?php
											foreach ($stocks as $stock) {
												?>
												<tr>
													<td><?= $stock['designation'] ?></td>
													<td>
														<input type="number" name="stock_<?= $stock['idProduit'] ?>" max="<?= $stock['Qte'] ?>" min="0" value="<?= $stock['Qte'] ?>" class="form-control text-center colorOrange">
													</td>
												</tr>
												<?php
											}
										?>
										</tbody>
									</table
								</div>

								<input type="hidden" name="token" value="<?= bin2hex(openssl_random_pseudo_bytes(50)) ?>">

								<div class="border-top">
									<div class="card-body text-center">
										<a href="<?= site_url("accueil/index/") ?>" class="btn btn-danger">
											<i class="fa fa-window-close"></i> Annuler
										</a>
										<button type="submit" class="btn btn-primary">
											<i class="fa fa-save"></i> Transférer
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
