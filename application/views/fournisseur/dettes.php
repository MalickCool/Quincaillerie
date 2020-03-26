<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Créances Fournisseur</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Sce Comptabilité</li>
						<li class="breadcrumb-item active">Créances Fournisseur</li>
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
							Filtre:
							<?php echo form_open("fournisseur/dettes", array('class'=>'form-horizontal form-bordered', 'id'=>'filter'));?>
								<div class="form-group">
									<div class="row">
										<div class="col-md-10 col-sm-12" style="">
											<div class="row">
												<div class="col-sm-3">
													<div class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" id="today" name="periode" value="today" checked v-on:click="checked = false" >
														<label class="custom-control-label" for="today">Aujourd'hui</label>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="row">
														<div class="col-sm-4">
															<div class="custom-control custom-radio">
																<input type="radio" class="custom-control-input" id="periode" name="periode" value="periode" v-on:click="fadein" >
																<label class="custom-control-label" for="periode">Période</label>
															</div>
														</div>

														<div class="col-sm-12 pt-1">
															<div class="pd0 pt-2" v-if="checked">
																<div class="input-group">
																	<input type="date" class="form-control" name="debut" v-model="mindate" v-on:change="maxdate = ''" v-bind:required="required">
																	<span class="input-group-addon" style="font-weight: bolder; width: 45px;text-align: center;font-size: 24px;">à</span>
																	<input type="date" class="form-control" name="fin" v-bind:min="mindate" v-bind:value="maxdate" v-bind:required="required">
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-sm-3">
													<div class="form-group row">
														<label for="fournisseur" class="col-sm-12 control-label col-form-label">Fournisseur</label>
														<div class="col-sm-12">
															<select id="fournisseur" name="fournisseur" class="form-control" style="width: 100%; height:36px;" required>
																<option value="all">Tous les Fournisseurs</option>
																<?php
																	foreach ($fournisseurs as $fournisseur) {
																		?>
																		<option <?= ($selectedFournisseur == $fournisseur->idfournisseur) ? 'selected' : '' ?> value="<?= $fournisseur->idfournisseur ?>"><?= $fournisseur->designation ?></option>
																		<?php
																	}
																?>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-2 col-sm-12 text-right">
											<button type="submit" class="btn btn-success"> Afficher</button>
										</div>
									</div>
								</div>
							<?php echo form_close();?>
						</div>
						<div class="card-header text-right">
							<a href="<?= site_url("accueil/") ?>" class="btn btn-danger"> <i class="fa fa-window-close"> Quitter</i></a>
						</div>
						<div class="card-body">
							<h3><?= $titre ?></h3>
							<h4>Fournisseur: <?= $supMessage ?></h4>
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>N° Bon Commande</th>
											<th>Date Bon de Commande</th>
											<th>Fournisseur</th>
											<th>Montant Bon Commande</th>
											<th>Montant Réglé</th>
											<th>Reste à Payer</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$montB = 0;
											$montR = 0;
											foreach ($bons as $bon) {
												$montB += $bon->montantCommande;
												$montR += $bon->montantRegler;
												?>
												<tr>
													<td><?= $bon->numbon ?></td>
													<td><?= date('d/m/Y', strtotime($bon->datebon)) ?></td>
													<td><?= $bon->Fournisseur ?></td>
													<td class="text-right"><?= $this->fournisseur_m->formatNumber($bon->montantCommande) ?> FCFA</td>
													<td class="text-right"><?= $this->fournisseur_m->formatNumber($bon->montantRegler) ?> FCFA</td>
													<td class="text-right"><?= $this->fournisseur_m->formatNumber($bon->montantCommande - $bon->montantRegler) ?> FCFA</td>
												</tr>
												<?php
											}
										?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3" class="font-weight-bold" style="font-size: 22px">Total:</td>
											<td class="font-weight-bold text-right" style="font-size: 22px"><?= $this->fournisseur_m->formatNumber($montB) ?> FCFA</td>
											<td class="font-weight-bold text-right" style="font-size: 22px"><?= $this->fournisseur_m->formatNumber($montR) ?> FCFA</td>
											<td class="font-weight-bold text-right" style="font-size: 22px"><?= $this->fournisseur_m->formatNumber($montB - $montR) ?> FCFA</td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<div class="card-footer text-right">
							<a href="<?= site_url("vente/imprimer/".$link) ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

