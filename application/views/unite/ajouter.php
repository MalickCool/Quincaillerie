<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:44
 */
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Unité Produit</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Configuration</li>
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
				<?php
				if(isset($_SESSION['message'])){
					?>

					<div class="alert alert-success col-md-12" role="alert">
						<?= $_SESSION['message'] ?>
					</div>

					<?php
				}
				?>
				<div class="col-md-5">
					<div class="card">
						<?php echo form_open("unite/insert", array('class'=>'form-horizontal', 'id'=>'form'));?>
							<div class="card-body">
								<div class="form-group row">
									<div class="col-sm-12 pl-0">
										<label for="designation" class="col-sm-12 control-label col-form-label">Désignation <b style="color: #e74c3c; font-weight: bolder">*</b></label>
										<div class="col-sm-12">
											<input type="text" name="designation" class="form-control" id="designation" placeholder="Designation de l'unité" required>
											<?= form_error('designation','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>
								</div>

								<div class="form-group row">
									<div class="col-sm-4 pl-0">
										<label for="valeur" class="col-sm-12 control-label col-form-label">Valeur <b style="color: #e74c3c; font-weight: bolder">*</b></label>
										<div class="col-sm-12">
											<input type="number" name="valeur" class="form-control" id="valeur" placeholder="Valeur de l'unité" step=0.00001 required>
											<?= form_error('valeur','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>

									<div class="col-sm-8 pl-0">
										<label for="parent" class="col-sm-12 control-label col-form-label">Unité Parente <b style="color: #e74c3c; font-weight: bolder">*</b></label>
										<div class="col-sm-12">
											<select name="parent" id="parent" class="select2 form-control custom-select">
												<option value="">Aucun</option>
												<?php
												foreach ($unites2 as $unite) {
													?>
													<option value="<?= $unite->idunite ?>"><?= $unite->designation ?></option>
													<?php
												}
												?>
											</select>
											<?= form_error('parent','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>
								</div>

							</div>
							<div class="border-top">
								<div class="card-body text-center">
									<a href="<?= site_url("accueil/index/") ?>" class="btn btn-danger"><i class="fa fa-window-close"></i> Quitter</a>
									<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Ajouter</button>
								</div>
							</div>
							<input type="hidden" name="token" value="<?= bin2hex(openssl_random_pseudo_bytes(50)) ?>">
						<?php echo form_close();?>
					</div>
				</div>
				<div class="col-md-7">
					<div class="card">
						<div class="card-body">
							<h4 class="card-title">Liste des Unités</h4>
							<div class="table-responsive">
								<table id="zero_config" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Désignation</th>
											<th>Valeur</th>
											<th>Unité Parente</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach ($unites as $item) {
												$status = "Activer";
												if($item['etat']  > 0)
													$status = "Désactiver";
												?>
												<tr>
													<td><?= $item['designation'] ?></td>
													<td><?= $item['valeur'] ?></td>
													<td><?= $item['parent'] ?></td>
													<td class="text-center">
														<button class="btn btn-danger" data-toggle="modal" data-target="#exampleModal_<?= $item['idunite'] ?>">
															<i class="fa fa-edit"></i>
														</button>
													</td>
												</tr>

												<div class="modal fade" id="exampleModal_<?= $item['idunite'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">Modifier unité de mesure: <?= $item['designation'] ?></h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">

																<div class="card mb-0">
																	<?php echo form_open("unite/update", array('class'=>'form-horizontal', 'id'=>'form'));?>
																	<div class="card-body">
																		<div class="form-group row">
																			<div class="col-sm-12 pl-0">
																				<label for="designation" class="col-sm-12 control-label col-form-label">Désignation</label>
																				<div class="col-sm-12">
																					<input type="text" name="designation" class="form-control" id="designation" value="<?= $item['designation'] ?>" required>
																					<?= form_error('designation','<div class="alert alert-danger">','</div>');?>
																				</div>
																			</div>
																		</div>

																		<div class="form-group row">
																			<div class="col-sm-4 pl-0">
																				<label for="valeur" class="col-sm-12 control-label col-form-label">Valeur</label>
																				<div class="col-sm-12">
																					<input type="number" name="valeur" class="form-control" id="valeur" value="<?= $item['valeur'] ?>" step=0.00001 required>
																					<?= form_error('valeur','<div class="alert alert-danger">','</div>');?>
																				</div>
																			</div>

																			<div class="col-sm-8 pl-0">
																				<label for="parent" class="col-sm-12 control-label col-form-label">Unité Parente</label>
																				<div class="col-sm-12">
																					<select name="parent" id="parent" class="select2 form-control custom-select">
																						<option <?php if ($item['idparent'] == 0) echo"selected"; ?> value="">Aucun</option>
																						<?php
																						foreach ($unites as $unity) {
																							?>
																							<option <?php if ($item['idparent'] > 0 && $item['idparent'] == $unity['idunite']) echo"selected"; ?> value="<?= $unity['idunite'] ?>"><?= $unity['designation'] ?></option>
																							<?php
																						}
																						?>

																					</select>
																					<?= form_error('parent','<div class="alert alert-danger">','</div>');?>
																				</div>
																			</div>
																		</div>

																		<div class="form-group row">
																			<div class="offset-sm-1 col-sm-9">
																				<div class="custom-control custom-checkbox mr-sm-2">
																					<input type="checkbox" name="etat" class="custom-control-input" id="chb_<?= $item['idunite'] ?>" <?php if($item['etat'] == 1) echo "checked"; ?> >
																					<label class="custom-control-label" for="chb_<?= $item['idunite'] ?>">Désactiver</label>
																				</div>
																			</div>
																		</div>
																	</div>

																	<input type="hidden" name="id" value="<?= $item['idunite'] ?>">

																	<div class="modal-footer pb-0">
																		<div class="card-body text-center pb-0 mb-0">
																			<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Modifier</button>
																			<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-window-close"></i> Annuler</button>
																		</div>
																	</div>
																	<?php echo form_close();?>
																</div>

															</div>

														</div>
													</div>
												</div>

												<?php
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
