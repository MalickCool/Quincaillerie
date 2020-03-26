<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:44
 */
?>
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Modifier Dépense</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Compte</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <div class="card">
                    <?php echo form_open("depense/update", array('class'=>'form-horizontal', 'id'=>'form'));?>
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-sm-6 pl-0 pr-0">
                                <label for="typeDepense" class="col-sm-12 control-label col-form-label">Type de dépense</label>
                                <div class="col-sm-12">
                                    <select class="select2 form-control custom-select" name="typedepense" id="typeDepense">
                                        <option <?php if(is_null($depense->factureachat) OR $depense->factureachat == 1) echo "selected"; ?> value="">Exploitation</option>
                                        <option <?php if($depense->factureachat == 2) echo "selected"; ?> value="2">Banque</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6 pl-0 pr-0 depBenef <?php if(is_null($depense->departement)) echo"d-none"; ?>">
                                <label for="departement" class="col-sm-12 control-label col-form-label">Département Bénéficiaire</label>
                                <div class="col-sm-12">
                                    <select class="select2 form-control custom-select" name="departement" id="departement">
                                        <?php
                                        foreach ($departements as $departement) {
                                            ?>
                                            <option value="<?= $departement->iddepartement ?>"><?= $departement->nomdepartement ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

						<div class="form-group row">
							<label for="fournisseur_id" class="col-sm-12 control-label col-form-label">Site</label>
							<div class="col-sm-12">
								<select class="select2 form-control custom-select" name="site_id" id="site_id">
									<?php
									foreach ($sites as $site) {
										?>
										<option <?php if($site->idsite == $depense->site_id) echo "selected"; ?> value="<?= $site->idsite ?>"><?= $site->nomsite ?></option>
										<?php
									}
									?>
								</select>
							</div>
						</div>

                        <div class="form-group row">
                            <label for="montant" class="col-sm-12 control-label col-form-label">Montant de la dépense</label>
                            <div class="col-sm-12">
                                <input type="number" name="montant" class="form-control" id="montant" value="<?= $depense->montant ?>">
                                <?= form_error('montant','<div class="alert alert-danger">','</div>');?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="motifdepense" class="col-sm-12 control-label col-form-label">Motif de la dépense</label>
                            <div class="col-sm-12">
                                <textarea name="motifdepense" class="form-control" id="motifdepense" rows="12"><?= $depense->motifdepense ?></textarea>
                                <?= form_error('motifdepense','<div class="alert alert-danger">','</div>');?>
                            </div>
                        </div>
                    </div>
                    <div class="border-top">
                        <div class="card-body text-center">
                            <button type="submit" class="btn btn-primary">Modifier</button>
                            <a href="<?= site_url("depense/index/") ?>" class="btn btn-danger">Quitter</a>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?= $depense->iddepense ?>">
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
