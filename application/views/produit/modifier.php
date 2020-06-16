<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Modifier Produit</h1>
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
				<div class="col-md-6">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">Modifier <b><?= $produit->designation ?></b></h4>
						</div>
						<?php echo form_open_multipart("produit/update", array('class'=>'form-horizontal', 'id'=>'form'));?>
						<div class="card-body">
							<div class="form-group row">
								<label for="idfamille" class="col-sm-12 control-label col-form-label">Famille</label>
								<div class="col-sm-12">
									<select name="idfamille" id="idfamille" required class="select2 form-control custom-select">
										<?php
										foreach ($familles as $famille) {
											?>
											<option <?php if($famille->idfamille == $produit->idfamille) echo "selected"; ?> value="<?= $famille->idfamille ?>"><?= $famille->libelle ?></option>
											<?php
										}
										?>
									</select>
									<?= form_error('libelle','<div class="alert alert-danger">','</div>');?>
								</div>
							</div>

							<div class="form-group row">
								<label for="designation" class="col-sm-12 control-label col-form-label">Désignation</label>
								<div class="col-sm-12">
									<input type="text" name="designation" class="form-control" id="designation" value="<?= $produit->designation ?>" required>
									<?= form_error('designation','<div class="alert alert-danger">','</div>');?>
								</div>
							</div>

							<div class="form-group row">
								<label for="montant" class="col-sm-12 control-label col-form-label">Prix Par Défaut</label>
								<div class="col-sm-12">
									<input type="number" name="montant" class="form-control" id="montant" value="<?= $produit->montant ?>" required>
									<?= form_error('montant','<div class="alert alert-danger">','</div>');?>
								</div>
							</div>

							<div class="form-group row">
								<label for="masse" class="col-sm-12 control-label col-form-label">Poids du Produit (en Kg)</label>
								<div class="col-sm-12">
									<input type="number" step="any" name="masse" class="form-control" id="masse" value="<?= $produit->masse ?>" required>
									<?= form_error('masse','<div class="alert alert-danger">','</div>');?>
								</div>
							</div>

							<div class="form-group row">
								<label for="seuil" class="col-sm-12 control-label col-form-label">Seuil d'alerte</label>
								<div class="col-sm-12">
									<input type="number" name="seuil" class="form-control" id="seuil" value="<?= $produit->seuil ?>" required>
									<?= form_error('seuil','<div class="alert alert-danger">','</div>');?>
								</div>
							</div>

							<div class="form-group row">
								<label for="information" class="col-sm-12 control-label col-form-label">Détail</label>
								<div class="col-sm-12">
									<textarea name="information" class="form-control" id="information" rows="3"><?= $produit->information ?></textarea>
									<?= form_error('information','<div class="alert alert-danger">','</div>');?>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-sm-12">
									<div class="custom-control custom-checkbox mr-sm-2">
										<input type="checkbox" name="etat" class="custom-control-input" id="chb" <?php if($produit->etat == 1) echo "checked"; ?> >
										<label class="custom-control-label" for="chb">Désactiver</label>
									</div>
								</div>
							</div>
						</div>

						<div class="border-top">
							<div class="card-body text-center">
								<a href="<?= site_url("produit/index/") ?>" class="btn btn-danger">
									<i class="fa fa-window-close"></i> Quitter
								</a>
								<button type="submit" class="btn btn-primary">
									<i class="fa fa-edit"></i> Modifier
								</button>
							</div>
						</div>
						<input type="hidden" name="id" value="<?= $produit->idproduit ?>">
						<?php echo form_close();?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">Liste Produits</h4>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
									<tr>
										<th>Famille</th>
										<th>Désignation</th>
										<th>Prix Par Défaut</th>
										<th>Poids</th>
										<th>Etat</th>
										<th>Action</th>
									</tr>
									</thead>
									<tbody>
									<?php
									foreach ($produits as $item) {
										$status = "Activer";
										if($item->etat  > 0)
											$status = "Désactiver";
										?>
										<tr>
											<td><?= $item->libelle ?></td>
											<td><?= $item->designation ?></td>
											<td><?= $item->montant ?> FCFA</td>
											<td><?= $item->masse ?> Kg</td>
											<td><?= $status ?></td>
											<td>
												<a href="<?= site_url("produit/edit/".$item->idproduit) ?>" class="btn btn-danger">Modifier</a>
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
						<a href="<?= site_url("produit/imprimer") ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
