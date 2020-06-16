<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Gestion des Prix</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Configuration</li>
						<li class="breadcrumb-item active">Prix par Type de Client</li>
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
				<?php echo form_open("prix/insert", array('class'=>'form-horizontal col-12', 'id'=>'form'));?>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header colorOrange">
									Produit: <?= $produit->designation ?><br>
									Prix de vente par Défaut: <?= $this->prix_m->formatNumber($produit->montant) ?> FCFA
								</div>
								<div class="card-body">
									<input type="hidden" class="form-control" name="idProduit" value="<?= $produit->idproduit ?>">
									<table id="zero_config" class="table datatableset table-striped table-bordered">
										<thead>
											<tr>
												<th>Type De Client</th>
												<th>Prix de Vente</th>
											</tr>
										</thead>
										<tbody>
											<?php
												foreach ($types as $type) {
													?>
													<tr>
														<td class="font-weight-bolder"><?= $type->designation ?></td>
														<td>
															<input type="number" class="form-control font-weight-bolder text-center" name="Type_<?= $type->idType ?>" value="<?= $priceArray[$type->idType] ?>">
														</td>
													</tr>
													<?php
												}
											?>
										</tbody>
									</table>
								</div>
								<div class="border-top">
									<div class="card-body text-center">
										<button type="submit" class="btn btn-primary">Enregistrer</button>
										<a href="<?= site_url("produit/index/") ?>" class="btn btn-danger">Annuler</a>
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
