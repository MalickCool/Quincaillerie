<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Bon de Commande</h1>
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
							<div class="card-body">
								<div class="col-xs-12 text-right">
									<div class="offset-sm-10 text-center col-sm-2 pr-0 pt-2 pb-2 mb-3 font-weight-bold" style="color: #DA542E; border: 2px red solid;">
										<span class="total"><?= $totalFacture ?></span><span> FCFA</span>
									</div>
								</div>
								<?php echo form_open_multipart("Commande/validerAchat", array('class'=>'form-horizontal', 'id'=>'form'));?>
									<div id="formulaire" class="">
										<?php
											foreach ($stocks as $stock) {
												?>
												<div id="elem_<?= $stock['idProduit'] ?>">
													<input name="product[]" type="" value="<?= $stock['idProduit'] ?>">
													<input name="qte[]" class="qte" type="" value="<?= $stock['seuil'] - $stock['Qte'] ?>">
													<input name="pu[]" class="pu" type="" value="<?= $stock['prix'] ?>">
												</div>
												<?php
											}
										?>
									</div>
									<input type="hidden" name="token" value="<?= bin2hex(openssl_random_pseudo_bytes(50)) ?>">

									<div class="form-group row">

										<label for="idfournisseur" class="col-sm-2 text-right control-label col-form-label"><b>Fournisseur</b></label>
										<div class="col-sm-4">
											<select id="idfournisseur" name="idfournisseur" required class="select2 form-control custom-select">
												<option value=""></option>
												<?php
												foreach ($fournisseurs as $fournisseur) {
													?>
													<option value="<?= $fournisseur->idfournisseur ?>"><?= $fournisseur->designation ?></option>
													<?php
												}
												?>
											</select>
										</div>

										<label for="tva" class="col-sm-1 text-right control-label col-form-label"><b>TVA</b></label>
										<div class="col-sm-3">
											<select id="tva" name="tva" required class="select2 form-control custom-select">
												<option value="non">Désactiver</option>
												<option value="oui">18%</option>
											</select>
										</div>



										<div class="col-sm-2 text-right">
											<button type="submit" class="btn btn-primary">Valider</button>
											<a href="<?= site_url("stock/index/") ?>" class="btn btn-danger">Annuler</a>
										</div>
									</div>


								<?php echo form_close();?>
								<style>
									.select2.select2-container.select2-container--default.select2-container--focus{
										width: 100% !important;
									}
								</style>
								<div class="form-group row" id="field">
									<div class="col-sm-3 pl-0 pr-0">
										<label for="intrant" class="col-sm-12 control-label col-form-label">Produit</label>
										<div class="col-sm-12">
											<select id="intrant" class="select2 form-control custom-select col-sm-12">
												<option value=""></option>
												<?php
													foreach ($produits as $produit) {
														?>
														<option value="<?= $produit->idproduit ?>"><?= $produit->designation ?></option>
														<?php
													}
												?>
											</select>
										</div>
									</div>

									<div class="col-sm-3 pl-0 pr-0">
										<label for="qte" class="col-sm-12 control-label col-form-label">Quantité</label>
										<div class="col-sm-12">
											<input type="number" class="form-control" id="qte" placeholder="Quantité">
										</div>
									</div>

									<div class="col-sm-3 pl-0 pr-0">
										<label for="pu" class="col-sm-12 control-label col-form-label">Prix Unitaire TTC</label>
										<div class="col-sm-12">
											<input type="number" id="pu" step="0.01" class="form-control" placeholder="Prix Unitaire">
										</div>
									</div>

									<div class="col-sm-2 pl-0 pr-0">
										<label for="total" class="col-sm-12 control-label col-form-label">Total TTC</label>
										<div class="col-sm-12">
											<input type="number" id="total" class="form-control" readonly>
										</div>
									</div>

									<div class="col-sm-1 pl-0 pr-0">
										<button type="button" id="addToTable" class="btn btn-success" style="margin-top: 38px">Ajouter</button>
									</div>
								</div>

								<div class="row">
									<table class="table table-striped table-bordered">
										<thead>
											<tr>
												<th>Produit</th>
												<th>Quantité</th>
												<th>Prix Unitaire</th>
												<th>Total</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody id="tbody">
											<?php
												foreach ($stocks as $stock) {
													?>
													<tr id="tr_<?= $stock['idProduit'] ?>">
														<td id="name_<?= $stock['idProduit'] ?>"><?= $stock['designation'] ?></td>
														<td><input type="number" class="form-control automaticallyAddQte" min="1" value="<?= $stock['seuil'] - $stock['Qte'] ?>"></td>
														<td><input type="number" class="form-control automaticallyAddPu" min="1" value="<?= $stock['prix'] ?>"></td>
														<td class="tot"><?= ($stock['seuil'] - $stock['Qte']) * $stock['prix'] ?></td>
														<td>
															<button type="button" class="btn btn-danger removeBtn" id="<?= $stock['idProduit'] ?>"> Retirer</button>
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
				</div>
			</div>
		</div>
	</section>
</div>
