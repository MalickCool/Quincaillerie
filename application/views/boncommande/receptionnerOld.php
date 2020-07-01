<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Réceptionner Commande </h1>
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
							<ul class="list-unstyled">
								<li>
									- Date de la facture:<b> <?= date('d/m/Y', strtotime($bon->datebon)) ?> </b>
								</li>
								<li>
									- Numero du Bon:<b> <?= $bon->numbon ?></b>
								</li>
								<li>
									- Utilisateur:<b> <?= $this->ion_auth->user($bon->iduser)->row()->first_name." ".$this->ion_auth->user($bon->iduser)->row()->last_name ?></b>
								</li>
								<li>
									- Fournisseur:<b> <?= $bon->idfournisseur ?></b>
								</li>
								<li>
									- TVA Appliquée:<b id="tva"> <?= ucfirst($bon->tva) ?></b>
								</li>
							</ul>
						</div>
						<?php
							$item = 3;
						?>
						<?php echo form_open_multipart("Commande/validerReception/".$bon->idfacture, array('class'=>'form-horizontal', 'id'=>'form'));?>
							<div class="card-body">
								<div class="row">
									<table class="table table-striped table-bordered table-responsive-md">
										<thead>
											<tr>
												<th style="width: 20%">Produit</th>
												<th style="width: 10%">Quantité Total</th>
												<?php
													foreach ($magasins as $magasin) {
														$item++;
														?>
														<th style="width: 10%"><?= $magasin->designation ?></th>
														<?php
													}
												?>

												<th style="width: 15%">Prix Unitaire TTC</th>
												<th style="width: 15%">Total TTC</th>
											</tr>
										</thead>
										<tbody id="tbody">
											<?php
												$total = 0;
												foreach ($details as $detail) {
													$total += ($detail->qte * $detail->pu);
													?>
													<tr>
														<td><?= $detail->produit ?></td>
														<td><input class="form-control qte font-weight-bold text-center" readonly type="number" name="qte_<?= $detail->iddetail ?>" value="<?= $detail->qte ?>"></td>


														<?php
															foreach ($magasins as $magasin) {
																?>
																<td>
																	<input class="form-control entrepot font-weight-bold" type="number" name="entrepot_<?= $detail->iddetail ?>_<?= $magasin->identrepot ?>">
																</td>
																<?php
															}
														?>
														<td class="text-right font-weight-bold" style="font-size: 20px"><span class="pu"><?= $this->detailsbc_m->formatNumber($detail->pu) ?></span> FCFA</td>
														<td class="text-right font-weight-bold" style="font-size: 20px"><span class="total"><?= $this->detailsbc_m->formatNumber($detail->qte * $detail->pu) ?></span> FCFA</td>
													</tr>
													<?php
												}
											?>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="<?= $item ?>">Total:</td>
												<td class="text-right font-weight-bold" style="font-size: 20px; text-align: right"><span id="theTotal"><?= $this->detailsbc_m->formatNumber($total) ?></span> FCFA</td>
											</tr>
											<tr>
												<td colspan="<?= $item ?>">Montant du Paiement:</td>
												<td>
													<input type="number" class="form-control font-weight-bold bg-red" style="border: 2px red solid" name="montantPayer" id="montantPayer" min="0">
												</td>
											</tr>
											<tr>
												<td colspan="<?= $item ?>">Reste à Payer:</td>
												<td>
													<input type="text" class="form-control font-weight-bold" readonly style="border: 2px red solid" name="reste" id="reste">
												</td>
											</tr>
											<tr id="echeanceDiv">
												<td colspan="<?= $item ?>">Prochaine Echéance:</td>
												<td>
													<input type="date" class="form-control font-weight-bold text-center" style="border: 2px red solid" required name="echeance" id="echeance">
												</td>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
							<div class="card-footer text-center">
								<input type="hidden" name="token" value="<?= bin2hex(openssl_random_pseudo_bytes(50)) ?>">
								<a href="<?= site_url("commande/index") ?>" class="btn btn-danger"> <i class="fa fa-window-close"></i> Annuler</a>
								<button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Valider</button>
							</div>

						<?php echo form_close();?>

					</div>
				</div>
			</div>
		</div>
	</section>
</div>
