<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Régler Dette Fournisseur </h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item">Caisse</li>
						<li class="breadcrumb-item active">Régler Dette Fournisseur</li>
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
						<?php echo form_open_multipart("depense/validerPaiementFournisseur/", array('class'=>'form-horizontal', 'id'=>'form'));?>

							<input type="hidden" name="idFacture" value="<?= $bon->idfacture ?>">
							<div class="card-body">
								<div class="row">
									<table class="table table-striped table-bordered table-responsive-md">


											<?php
												$total = 0;
												foreach ($details as $detail) {
													$total += ($detail->qte * $detail->pu);
												}
											?>
										<span id="theTotal" class="d-none"><?= $total - $oldPaiement ?></span>
										<tfoot>
											<tr>
												<td colspan="<?= $item ?>">Total Facture:</td>
												<td class="text-right font-weight-bold" style="font-size: 20px; text-align: right"><span id=""><?= $this->detailsbc_m->formatNumber($total) ?></span> FCFA</td>
											</tr>
											<tr>
												<td colspan="<?= $item ?>">Motant déjà Payé:</td>
												<td class="text-right font-weight-bold" style="font-size: 20px; text-align: right"><span id=""><?= $this->detailsbc_m->formatNumber($oldPaiement) ?></span> FCFA</td>

											</tr>
											<tr>
												<td colspan="<?= $item ?>">Montant à Régler:</td>
												<td>
													<input type="number" class="form-control font-weight-bold bg-red" style="border: 2px red solid" name="montantPayer" id="montantPayer" min="0">
												</td>
											</tr>
											<tr>
												<td colspan="<?= $item ?>">Reste à Payer:</td>
												<td>
													<input type="text" class="form-control font-weight-bold" value="<?= $this->detailsbc_m->formatNumber($total - $oldPaiement) ?>" readonly style="border: 2px red solid" name="reste" id="reste">
												</td>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
							<div class="card-footer text-center">
								<input type="hidden" name="token" value="<?= bin2hex(openssl_random_pseudo_bytes(50)) ?>">
								<a href="<?= site_url("accueil/index") ?>" class="btn btn-danger"> <i class="fa fa-window-close"></i> Annuler</a>
								<button type="submit" class="btn btn-success"> <i class="fa fa-save"></i> Valider</button>
							</div>

						<?php echo form_close();?>

					</div>
				</div>
			</div>
		</div>
	</section>
</div>
