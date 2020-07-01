<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:44
 */
?>
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
				<div class="col-md-5">
					<div class="card">
						<?php echo form_open("unite/update", array('class'=>'form-horizontal', 'id'=>'form'));?>
							<div class="card-body">
								<div class="form-group row">
									<div class="col-sm-12 pl-0">
										<label for="designation" class="col-sm-12 control-label col-form-label">Désignation <b style="color: #e74c3c; font-weight: bolder">*</b></label>
										<div class="col-sm-12">
											<input type="text" name="designation" class="form-control" id="designation" value="<?= $unite->designation ?>" required>
											<?= form_error('designation','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>
								</div>

								<div class="form-group row">
									<div class="col-sm-4 pl-0">
										<label for="valeur" class="col-sm-12 control-label col-form-label">Valeur <b style="color: #e74c3c; font-weight: bolder">*</b></label>
										<div class="col-sm-12">
											<input type="number" name="valeur" class="form-control" id="valeur" value="<?= $unite->valeur ?>" step=0.00001 required>
											<?= form_error('valeur','<div class="alert alert-danger">','</div>');?>
										</div>
									</div>

									<div class="col-sm-8 pl-0">
										<label for="parent" class="col-sm-12 control-label col-form-label">Unité Parente <b style="color: #e74c3c; font-weight: bolder">*</b></label>
										<div class="col-sm-12">
											<select name="parent" id="parent" class="select2 form-control custom-select">
												<option <?php if ($unite->parent == 0) echo"selected"; ?> value="">Aucun</option>
												<?php
												foreach ($unites2 as $unity) {
													?>
													<option <?php if ($unite->parent > 0 && $unite->parent == $unity->idunite) echo"selected"; ?> value="<?= $unity->idunite ?>"><?= $unity->designation ?></option>
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
											<input type="checkbox" name="etat" class="custom-control-input" id="chb" <?php if($unite->etat == 1) echo "checked"; ?> >
											<label class="custom-control-label" for="chb">Désactiver</label>
										</div>
									</div>
								</div>
							</div>
							<div class="border-top">
								<div class="card-body text-center">
									<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Modifier</button>
									<a href="<?= site_url("unite/index/") ?>" class="btn btn-danger"><i class="fa fa-window-close"></i> Quitter</a>
								</div>
							</div>
							<input type="hidden" name="id" value="<?= $unite->idunite ?>">
						<?php echo form_close();?>
					</div>
				</div>
				<div class="col-md-7">
					<div class="card">
						<div class="card-body">
							<h4 class="card-title">Liste des Unités de mesure</h4>
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
												<td>
													<a href="<?= site_url("unite/edit/".$item['idunite']) ?>" class="btn btn-danger"><i class="fa fa-edit"></i></a>
												</td>
											</tr>
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
