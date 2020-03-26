<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Liste des Créances Client</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Sce Comptabilité</li>
						<li class="breadcrumb-item active">Créances Client</li>
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
							<?php echo form_open("client/detteClient", array('class'=>'form-horizontal form-bordered', 'id'=>'filter'));?>
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
													<label for="client" class="col-sm-12 control-label col-form-label">Client</label>
													<div class="col-sm-12">
														<select id="client" name="client" class="form-control" style="width: 100%; height:36px;" required>
															<option value="all">Tous les Clients</option>
															<?php
															foreach ($clients as $client) {
																?>
																<option <?= ($selectedClient == $client->idclient) ? 'selected' : '' ?> value="<?= $client->idclient ?>"><?= $client->nom ?></option>
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
							<h4>Client: <?= $supMessage ?></h4>
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>N° Facture</th>
											<th>Date Achat</th>
											<th>Client</th>
											<th>Contact Client</th>
											<th>Montant Total</th>
											<th>Montant Reglé</th>
											<th>Reste à Payer</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$mttc = 0;
											$mr = 0;
											$mp = 0;
											foreach ($dettes as $list) {
												$mttc += $list['TotalTTC'];
												$mr += $list['MontantVerse'];
												$mp += $list['Reste'];
												?>
												<tr>
													<td><?= date('Y/m/', strtotime($list['Vente']->datevente))."_".$list['Vente']->idvente; ?></td>
													<td><?= date('d/m/Y', strtotime($list['Vente']->datevente)) ?></td>
													<td><?= $list['Client']->nom ?></td>
													<td><?= $list['Client']->phone ?></td>
													<td><?= $this->client_m->formatNumber($list['TotalTTC']) ?></td>
													<td><?= $this->client_m->formatNumber($list['MontantVerse']) ?></td>
													<td><?= $this->client_m->formatNumber($list['Reste']) ?></td>
												</tr>
												<?php
											}
										?>
									</tbody>
									<tfoot>
										<tr>
											<td class="font-weight-bold font-24" colspan="4">Total</td>
											<td class="font-weight-bold font-24"><?= $this->client_m->formatNumber($mttc) ?></td>
											<td class="font-weight-bold font-24"><?= $this->client_m->formatNumber($mr) ?></td>
											<td class="font-weight-bold font-24"><?= $this->client_m->formatNumber($mp) ?></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<div class="card-footer text-right">
							<a href="<?= site_url("client/imprimerDette") ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
