<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Historique Détaillé</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Edition</li>
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
							<?php echo form_open("inventaire/historiquedetaille", array('class'=>'form-horizontal form-bordered', 'id'=>'filter'));?>
							<div class="form-group">
								<div class="row">
									<div class="col-md-10 col-sm-12" style="">
										<div class="row">
											<div class="col-sm-2">
												<div class="custom-control custom-radio">
													<input type="radio" class="custom-control-input" id="today" name="periode" value="today" checked v-on:click="checked = false" >
													<label class="custom-control-label" for="today">Aujourd'hui</label>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="row">
													<div class="col-sm-12">
														<div class="custom-control custom-radio">
															<input type="radio" class="custom-control-input" id="periode" name="periode" value="periode" v-on:click="fadein" >
															<label class="custom-control-label" for="periode">Période</label>
														</div>
													</div>

													<div class="col-sm-12">
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
											<div class="col-sm-4">
												<div class="row">
													<label for="image" class="col-sm-5 text-right control-label col-form-label">Magasin</label>
													<div class="col-sm-7">
														<select name="lieux" class="form-control" id="">
															<option value="all">Tous les Magasins</option>
															<?php
																foreach ($entrepots as $entrepot) {
																	?>
																	<option <?= ($selectedEnt == $entrepot->identrepot) ? 'selected' : '' ?> value="<?= $entrepot->identrepot ?>"><?= $entrepot->designation ?></option>
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
										<a href="<?= site_url('Accueil/') ?>" type="button" class="btn btn-danger"> Quitter</a>
									</div>
								</div>
							</div>
							<?php echo form_close();?>
						</div>

						<div class="card-header mt-3">
							<div class="row">
								<div class="col-sm-9 text-left">
									<h4><?= $titre ?></h4>
									<h5>Salle : <?= $stockage ?></h5>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Date</th>
											<th>Produit</th>
											<th>Magasin</th>
											<th>Quantité Avant</th>
											<th>Quantité Après</th>
											<th>Différence</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach ($details as $item) {
												?>
												<tr>
													<td><?= date('d/m/Y', strtotime($item->dateinventaire)) ?></td>
													<td><?= $item->designation ?></td>
													<td><?= $item->entrepot ?></td>
													<td><?= $item->qteavant ?></td>
													<td><?= $item->qteapres ?></td>
													<td class="text-center"><?= $item->qteapres - $item->qteavant ?></td>
												</tr>
												<?php
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="card-footer text-right">
							<a href="<?= site_url("inventaire/printHdetail/".$link) ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
