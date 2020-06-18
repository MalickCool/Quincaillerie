<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Service Génie Civil</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Génie Civil</li>
						<li class="breadcrumb-item active">Liste des Chantiers</li>
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
							<?php echo form_open("service/index", array('class'=>'form-horizontal form-bordered', 'id'=>'filter'));?>
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
						<div class="card-header text-right">
							<a href="<?= site_url("service/ajouter") ?>" class="btn btn-primary"> <i class="fa fa-plus-circle"> Nouveau Chantier</i></a>
						</div>
						<div class="card-body">
							<h3><?= $texte ?></h3>
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>N° Chantier</th>

											<th>Date Enregistrement</th>
											<th>Date Début</th>
											<th>Délai</th>

											<th>Client</th>
											<th>Main d'oeuvre</th>

											<th>Coût Matérieux</th>

											<th>Total</th>
											<th>Reste à Payer</th>

											<th>Etat</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$mont = 0;
											$montant = 0;
											$tva2 = 0;
											foreach ($services as $vente) {
												?>
												<tr>
													<td><?= $vente['Service']->idservice ?></td>
													<td class="text-center"><?= date('d/m/Y', strtotime($vente['Service']->dateenregistrement)) ?></td>
													<td class="text-center"><?= date('d/m/Y', strtotime($vente['Service']->datedebut)) ?></td>
													<td><?= $vente['Service']->delai ?> Jour(s)</td>
													<td><?= $vente['Client']->nom ?></td>
													<td class="text-right"><?= $this->service_m->formatNumber($vente['Service']->montant) ?> FCFA</td>

													<td class="text-right"><?= $this->service_m->formatNumber($vente['DetailProforma']['TotalTTC']) ?> FCFA</td>

													<td class="text-right">
														<b><?= $this->service_m->formatNumber($vente['Service']->montant + $vente['DetailProforma']['TotalTTC']) ?> FCFA</b>
													</td>

													<td class="text-right">
														<b></b>
													</td>

													<td class="text-right">
														<b><?= $vente['GlobalState'] ?></b>
													</td>

													
													<td class="text-center">

														<div class="btn-group">
															<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
															<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 35px, 0px);">

																<?php
																	if($vente['Service']->etat == 0){
																		?>
																		<a class="dropdown-item" href="<?= site_url("service/modifier/".$vente['Service']->idservice) ?>" >Modifier</a>
																		<a class="dropdown-item" href="<?= site_url("vente/details/".$vente['Service']->idservice) ?>" >Afficher Matériaux</a>
																		<?php
																	}else{
																		?>
																		<a class="dropdown-item" href="<?= site_url("vente/details/".$vente['Service']->idservice) ?>" >Afficher Détail</a>
																		<?php
																	}
																?>
															</div>
														</div>

													</td>
												</tr>
												<?php
											}
										?>
									</tbody>
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


<div class="modal fade" id="modal-default">
	<div class="modal-dialog">
		<div class="modal-content">
			<?php echo form_open("stock/destocker", array('class'=>'form-horizontal', 'id'=>'form'));?>
				<div class="modal-header">
					<h4 class="modal-title">Détail Lieux déstockage pour Livraison</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<div class="col-md-12">
							<label for="magasin" class="col-sm-12 text-left control-label col-form-label">Magasin :</label>
							<div class="col-sm-12">
								<select id="magasin" name="magasin" class="select2 theSelect form-control custom-select" style="" required>
									<option value="">Selectionner un Magasin</option>
									<?php
										foreach ($magasins as $magasin) {
											?>
											<option value="<?= $magasin->identrepot ?>"><?= $magasin->designation ?></option>
											<?php
										}
									?>
								</select>
								<input type="hidden" name="achat" id="achat">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-window-close"></i> Annuler</button>
					<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Enregistrer</button>
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

