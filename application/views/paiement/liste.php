<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Gestion des Paiements</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Sce Commercial</li>
						<li class="breadcrumb-item active">Paiement Client</li>
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
							<?php echo form_open("paiement/index", array('class'=>'form-horizontal form-bordered', 'id'=>'filter'));?>
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
							<h3><?= $texte ?></h3>
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Date</th>
											<th>N° Vente</th>
											<th>Encaissé par</th>
											<th>Moyen de Paiement</th>
											<th>Montant</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$montant = 0;
											foreach ($paiements as $paiement) {
												$montant += $paiement->montant;
												?>
												<tr>
													<td class="text-center"><?= date('d/m/Y', strtotime($paiement->datepaiement)) ?></td>
													<td><?= $paiement->vente_id ?></td>

													<td><?= $this->ion_auth->user($paiement->userid)->row()->first_name." ".$this->ion_auth->user($paiement->userid)->row()->last_name ?></td>

													<?php
													switch ($paiement->typepaiement) {
														case 'espece':
															$moyen = 'Espèce';
															break;

														case 'cheque':
															$moyen = 'Chèque';
															break;

														default:
															$moyen = 'Mobile Money';
															break;
													}
													?>
													<td class="text-center"><?= $moyen ?></td>

													<td class="text-center"><?= $this->vente_m->formatNumber($paiement->montant) ?> FCFA</td>
													<td>
														<a role="button" href="<?= site_url("vente/details/".$paiement->vente_id) ?>" class="btn btn-info">Détail</a>
													</td>
												</tr>
												<?php
											}
										?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="4">Total Encaissé:</td>
											<td class="text-center font-weight-bold font-24"><?= $this->vente_m->formatNumber($montant) ?> FCFA</td>
											<td></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<div class="card-footer text-right">
							<a href="<?= site_url("paiement/imprimer/".$link) ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
