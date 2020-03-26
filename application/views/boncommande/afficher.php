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
						<div class="card-header">
							<ul class="list-style-none">
								<li>
									<b>
										- Date de la facture: <?= date('d/m/Y', strtotime($bon->datebon)) ?>
									</b>
								</li>
								<li>
									<b>
										- Utilisateur: <?= $this->ion_auth->user($bon->iduser)->row()->first_name." ".$this->ion_auth->user($bon->iduser)->row()->last_name ?>
									</b>
								</li>
								<li>
									<b>
										- Numero du Bon: <?= $bon->numbon ?>
									</b>
								</li>
								<li>
									<b>
										- Fournisseur: <?= $bon->idfournisseur ?>
									</b>
								</li>
								<li>
									<b>
										- TVA Appliquée: <?= ucfirst($bon->tva) ?>
									</b>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="row">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Quantité</th>
											<th>Produit</th>
											<th>Prix Unitaire</th>
											<th>TVA</th>
											<th>Total TTC</th>
										</tr>
									</thead>
									<tbody id="tbody">
										<?php
											$total = 0;
											foreach ($details as $detail) {
												if($bon->tva == 'oui'){
													$mht = $detail->pu / 1.18;
												}else{
													$mht = $detail->pu;
												}
												$taxe = $detail->pu - $mht;

												$total += ($detail->qte * $detail->pu);
												?>
												<tr>
													<td><?= $detail->qte ?></td>
													<td><?= $detail->produit ?></td>
													<td><?= $this->detailsbc_m->formatNumber($mht) ?> FCFA</td>
													<td><?= $this->detailsbc_m->formatNumber($taxe) ?> FCFA</td>
													<td><?= $this->detailsbc_m->formatNumber($detail->qte * $detail->pu) ?> FCFA</td>
												</tr>
												<?php
											}
										?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="4">Total:</td>
											<td><?= $this->detailsbc_m->formatNumber($total) ?> FCFA</td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<div class="card-footer text-center">
							<?php
								if($bon->etat == 0){
									?>
									<a href="<?= site_url("commande/receptionner/".$bon->idfacture) ?>" class="btn btn-success"><i class="fa fa-shopping-basket"></i> Réceptionner les marchandises</a>
									<?php
								}
							?>
							<a href="" class="btn btn-primary"><i class="fa fa-print"></i> Imprimer Bon</a>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
