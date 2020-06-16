<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Gestion de Caisse</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Caisse</li>
						<li class="breadcrumb-item active">Point de Caisse</li>
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
							<?php echo form_open("versement/point", array('class'=>'form-horizontal form-bordered', 'id'=>'filter'));?>
							<div class="form-group">
								<div class="row">
									<div class="col-md-10 col-sm-12" style="">
										<div class="row">

											<div class="col-sm-9">
												<div class="row">
													<div class="col-sm-4">
														<div class="custom-control custom-radio">
															<input type="radio" class="custom-control-input" id="periode" name="periode" checked value="periode" v-on:click="fadein">
															<label class="custom-control-label" for="periode">À la Date du</label>
														</div>
													</div>

													<div class="col-sm-8">
														<div class="pd0" v-if="!checked">
															<div class="input-group">
																<input type="date" class="form-control" name="debut" max="<?= date("Y-m-d") ?>" value="<?= date("Y-m-d", strtotime($link)) ?>" v-bind:required="required">
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

						<div class="card-header mt-2">
							<div class="row">
								<div class="col-sm-12 text-right">
									<a href="<?= site_url('Accueil/') ?>" type="button" class="btn btn-danger"><i class="mdi mdi-close-circle"></i>  Quitter</a>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Libellé</th>
											<th>Montant</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$totalDepense = 0;
											$totalPaiement = 0;
											$totalVersement = 0;
											foreach ($listes as $item) {
												$totalDepense += $item['depense'];
												$totalPaiement += $item['paiement'];
												$totalVersement += $item['versement'];
												?>
												<tr>
													<td>Total Dépense</td>
													<td><?= $this->versement_m->formatNumber($item['depense']) ?> FCFA</td>
												</tr>

												<tr>
													<td>Total Paiement</td>
													<td><?= $this->versement_m->formatNumber($item['paiement']) ?> FCFA</td>
												</tr>

												<tr>
													<td>Total Versement</td>
													<td><?= $this->versement_m->formatNumber($item['versement']) ?> FCFA</td>
												</tr>
												<?php
											}
										?>
									</tbody>
									<tfoot>
										<tr>
											<td class="font-24 font-weight-bold">Reste en caisse:</td>
											<td class="font-24 font-weight-bold"><?= $this->versement_m->formatNumber(($totalPaiement + $totalVersement) - $totalDepense) ?> FCFA</td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<div class="card-footer">
							<div class="card-footer text-right">
								<a href="<?= site_url("versement/imprimerPoint/".$link) ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>

