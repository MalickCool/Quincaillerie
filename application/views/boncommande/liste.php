<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Liste des Bons de Commande</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Gestion des Stocks</li>
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
							<?php echo form_open("commande/index", array('class'=>'form-horizontal form-bordered', 'id'=>'filter'));?>
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
											<div class="col-sm-9">
												<div class="row">
													<div class="col-sm-4">
														<div class="custom-control custom-radio">
															<input type="radio" class="custom-control-input" id="periode" name="periode" value="periode" v-on:click="fadein" >
															<label class="custom-control-label" for="periode">Période</label>
														</div>
													</div>

													<div class="col-sm-8">
														<div class="pd0" v-if="checked">
															<div class="input-group">
																<input type="date" class="form-control" name="debut" v-model="mindate" v-on:change="maxdate = ''" v-bind:required="required">
																<span class="input-group-addon" style="font-weight: bolder; width: 45px;text-align: center;font-size: 24px;">à</span>
																<input type="date" class="form-control" name="fin" v-bind:min="mindate" v-bind:value="maxdate" v-bind:required="required">
															</div>
														</div>
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
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered datatableset">
									<thead>
										<tr>
											<th>Date</th>
											<th>N° BC</th>
											<th>Fournisseur</th>
											<th>TVA Appliquée</th>
											<th>Effectué Par</th>
											<th>Poids</th>
											<th>Solde HT</th>
											<th>Montant TVA</th>
											<th>Solde TTC</th>
											<th>Status</th>
											<th>Etat</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
										$totalPoids = 0;
										$totalHT = 0;
										$totalTVA = 0;
										$totalTTC = 0;
										foreach ($bons as $item) {

											$etat = "Valide";
											if($item->annulee == 1)
												$etat = "Annulée";

											$totalPoids += $item->PoidsTotal;
											$totalHT += $item->soldeHT;
											$totalTVA += $item->soldeTaxe;
											$totalTTC += $item->soldeTTC;
											?>
											<tr>
												<td><?= date('d/m/Y', strtotime($item->datebon)) ?></td>
												<td><?= $item->numbon ?></td>
												<td><?= $item->idfournisseur ?></td>
												<td><?= ucfirst($item->tva) ?></td>
												<td><?= $this->ion_auth->user($item->iduser)->row()->first_name." ".$this->ion_auth->user($item->iduser)->row()->last_name ?></td>
												<td class="text-right"><?= $this->detailsbc_m->formatNumber($item->PoidsTotal) ?> Kg</td>
												<td class="text-right"><?= $this->detailsbc_m->formatNumber($item->soldeHT) ?></td>
												<td class="text-right"><?= $this->detailsbc_m->formatNumber($item->soldeTaxe) ?></td>
												<td class="text-right"><?= $this->detailsbc_m->formatNumber($item->soldeTTC) ?></td>
												<td><?= $item->State ?></td>
												<td><?= $etat ?></td>
												<?php
												if($item->annulee == 0){
													?>
													<td>
														<div class="dropdown">
															<button class="btn btn btn-info dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																Action
															</button>
															<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
																<a href="<?= site_url("commande/detail/".$item->idfacture) ?>" class="dropdown-item" type="button">Détail</a>
																<div class="dropdown-divider"></div>
																<?php
																	if($item->etat == 0){
																		?>
																		<a href="<?= site_url("commande/receptionner/".$item->idfacture) ?>" class="dropdown-item" type="button">Réceptionner</a>
																		<div class="dropdown-divider"></div>
																		<?php
																	}
																?>
																<a target="_blank" href="<?= site_url("commande/imprimerBon/".$item->idfacture) ?>" class="dropdown-item" type="button">Imprimer Bon</a>
																<?php
																	if($item->etat == 0){
																		?>
																		<div class="dropdown-divider"></div>
																		<a href="<?= site_url("commande/annuler/".$item->idfacture) ?>" class="dropdown-item" type="button">Annuler BC</a>
																		<?php
																	}
																?>
															</div>
														</div>
													</td>
													<?php
												}
												?>
											</tr>
											<?php
										}
									?>
									</tbody>
									<tfoot>
										<tr>
											<td class=" font-weight-bold" colspan="5">Totaux:</td>
											<td class="text-right font-weight-bold"><?= $this->detailsbc_m->formatNumber($totalPoids) ?> Kg</td>
											<td class="text-right font-weight-bold"><?= $this->detailsbc_m->formatNumber($totalHT) ?> FCFA</td>
											<td class="text-right font-weight-bold"><?= $this->detailsbc_m->formatNumber($totalTVA) ?> FCFA</td>
											<td class="text-right font-weight-bold"><?= $this->detailsbc_m->formatNumber($totalTTC) ?> FCFA</td>
											<td></td>
											<td></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<div class="card-footer text-right">
							<a href="<?= site_url("stock/imprimer/".$link) ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
