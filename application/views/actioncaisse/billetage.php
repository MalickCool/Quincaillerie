<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

	<!-- Main content -->
	<section class="content pt-5">
		<div class="container-fluid">
			<div class="row">
				<div class="offset-md-2 col-md-8">
					<div class="card">
						<div class="card-header text-center font-weight-bolder colorOrange">
							Arrêt de Caisse
						</div>
						<div class="card-body">
							<?php echo form_open_multipart("actioncaisse/confirmBilletage", array('class'=>'form-horizontal', 'id'=>'form'));?>
								<input type="hidden" name="token" id="token" value="<?= bin2hex(openssl_random_pseudo_bytes(50)) ?>">
								<input type="hidden" name="idcaisse" value="<?= $caisse->idcaisse ?>">

								<input type="hidden" id="soldeTheorique" class="form-control fwbolder fs18 color" readonly value="<?= $Entree['Total'] - $Sortie['Total'] ?>">

								<div class="row">
									<div class="col-md-2">
										<div class="font-weight-bolder fs-22 fontOrange text-center" style="padding-top: 170px">
											Mon solde: <br>   <?= $this->depense_m->formatNumber($Entree['Total'] - $Sortie['Total']) ?> FCFA
										</div>
									</div>
									<div class="col-md-8 divVersement">

										<fieldset>
											<legend>Billetage</legend>
											<div class="row">
												<?php
													foreach ($Argents as $key => $types) {
														?>
														<div class="col-lg-6">
															<table class="table table-bordered table-hover table-striped">
																<thead>
																	<tr class="colorOrange">
																		<th class="text-center" style="width: 50%;"><?= $key ?></th>
																		<th class="text-center">Quantité</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																		foreach ($types as $argent) {
																			?>
																			<tr>
																				<td class="text-center" lang="<?= $argent->valeur ?>"><?= $this->depense_m->formatNumber($argent->valeur) ?></td>
																				<td class="text-center">
																					<input type="number" name="<?= $argent->id_argent ?>_Coupure" min="0" value="" class="form-control nombreBillet">
																				</td>
																			</tr>
																			<?php
																		}
																	?>
																</tbody>
															</table>

														</div>
														<?php
													}
												?>
											</div>
											<div class="form-group row" style="">
												<label for="montantEncaisser" class="col-md-3">Montant versé </label>
												<div class="col-md-9">
													<textarea name="" disabled id="montantEncaisser" class="form-control text-center fontOrange font-weight-bolder fs-22" cols="30" rows="2"></textarea>
													<input type="hidden" name="montPh" id="montPh">
												</div>
											</div>
											<div class="form-group row">
												<label for="putRemarque" class="col-md-3">Remarque(s) </label>
												<div class="col-md-9">
													<textarea name="remarque" id="putRemarque" class="form-control color fwbolder fs18" cols="30" rows="2" <?= (($Entree['Total'] - $Sortie['Total']) > 0) ? 'required="required"' : '' ?> ></textarea>
												</div>
											</div>
										</fieldset>
									</div>
								</div>

								<div class="form-group row pt-4">
									<div class="col-sm-12 text-center">
										<a href="<?= site_url("accueil/index/") ?>" class="btn btn-danger"><i class="fa fa-window-close"></i> Annuler</a>
										<button type="submit"  class="btn btn-success"><i class="fa fa-check-circle"></i> Arrêter la Caisse</button>
									</div>
								</div>

							<?php echo form_close();?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
