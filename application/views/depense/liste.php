<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Liste des Dépenses</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Caisse</li>
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
							<?php echo form_open("depense/index", array('class'=>'form-horizontal form-bordered', 'id'=>'filter'));?>
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
													<label for="typeDepense" class="col-sm-12 control-label col-form-label">Type de Dépense</label>
													<div class="col-sm-12">
														<select id="typeDepense" name="typeDepense" class=" form-control custom-select" style="width: 100%; height:36px;" required>
															<option <?= ($selectedType == 'all') ? 'selected' : '' ?> value="all">Toute les Dépenses</option>
															<option <?= ($selectedType == 'fa') ? 'selected' : '' ?> value="fa">Facture d'achat</option>
															<option <?= ($selectedType == 'banque') ? 'selected' : '' ?> value="banque">Versements Banque</option>
															<option <?= ($selectedType == 'exp') ? 'selected' : '' ?> value="exp">Dépense d'exploitation</option>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2 col-sm-12 text-right">
										<button type="submit" class="btn btn-success mt-4"> Afficher</button>
									</div>
								</div>
							</div>
							<?php echo form_close();?>
						</div>
						<div class="card-header mt-2">
							<div class="row">
								<div class="col-sm-12 font-weight-bold font-20">
									<?= $titre ?><br>
									Type de dépense: <?= isset($dep) ? $dep : '' ?>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Date</th>
											<th>Motif</th>
											<th>Fournisseur / Prestataire</th>
											<th>Effectué Par</th>
											<th>Montant</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$total = 0;
											foreach ($depenses as $item) {
												$total += $item->montant;
												?>
												<tr>
													<td><?= date('d/m/Y', strtotime($item->datedepense)) ?></td>
													<td><?= $item->motifdepense ?></td>
													<td><?= $item->token ?></td>
													<td><?= $this->ion_auth->user($item->iduser)->row()->first_name." ".$this->ion_auth->user($item->iduser)->row()->last_name ?></td>
													<td><?= $this->depense_m->formatNumber($item->montant) ?> FCFA</td>
													<td>
														<?php

															if(is_null($item->factureachat)){
																if($item->datedepense == date("Y-m-d")){
																	?>
																	<a href="<?= site_url("depense/edit/".$item->iddepense) ?>" class="btn btn-danger"><i class="mdi mdi-update"></i> Modifier</a>
																	<?php
																}
															}else{
																?>
																<a href="<?= site_url("commande/show/".$item->factureachat) ?>" class="btn btn-primary"><i class="mdi mdi-eye"></i> Afficher</a>
																<?php
															}
														?>
													</td>
												</tr>
												<?php
											}
										?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="4">Total Dépense</td>
											<td><?= $this->depense_m->formatNumber($total) ?> FCFA</td>
											<td></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<div class="card-footer text-right">
							<a href="<?= site_url("depense/imprimerDepense/".$link) ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

