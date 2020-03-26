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
							<?php echo form_open("stock/entrepot", array('class'=>'form-horizontal', 'id'=>'form'));?>
								<div class="form-group row">
									<label for="entrepot" class="col-sm-3 text-right control-label col-form-label">Magasins</label>
									<div class="col-sm-5">
										<select id="entrepot" name="entrepot" class="select2 form-control custom-select col-sm-12">
											<option <?php if($selected == "") echo"selected"; ?> value="">Tous les Magasins</option>
											<?php
											foreach ($entrepots as $intrant) {
												?>
												<option <?php if($selected == $intrant->identrepot) echo"selected"; ?> value="<?= $intrant->identrepot ?>"><?= $intrant->designation ?></option>
												<?php
											}
											?>
										</select>
									</div>
									<div class="col-sm-2">
										<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Afficher</button>
									</div>
								</div>
							<?php echo form_close();?>

							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Intrant</th>
											<th>Quantité</th>
											<th>Seuil d'Alerte</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach ($stocks as $item) {
												?>
												<tr>
													<td><?= $item['designation'] ?></td>
													<td><?= round($item['Qte'], 2) ?></td>
													<td><?= round($item['seuil'], 2) ?></td>
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
