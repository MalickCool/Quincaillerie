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
                <h4 class="page-title">Modifier une famille de produit</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Famille</li>
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
            <div class="col-md-6">
                <div class="card">
                    <?php echo form_open_multipart("famille/update", array('class'=>'form-horizontal', 'id'=>'form'));?>
                        <div class="card-body">
                            <h4 class="card-title">Modifier la famille de produit <?= $famille->libelle ?></h4>
                            <div class="form-group row">
                                <label for="designation" class="col-sm-3 text-right control-label col-form-label">Désignation</label>
                                <div class="col-sm-9">
                                    <input type="text" name="libelle" class="form-control" id="designation" value="<?= $famille->libelle ?>" required>
                                    <?= form_error('libelle','<div class="alert alert-danger">','</div>');?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="image" class="col-sm-3 text-right control-label col-form-label">Image</label>
                                <div class="col-sm-9">
                                    <input type="file" name="image" class="custom-file-input" id="validatedCustomFile">
                                    <label class="custom-file-label" for="validatedCustomFile">Choisir l'image...</label>
                                    <div class="invalid-feedback">Example invalid custom file feedback</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-sm-3 col-sm-9">
                                    <div class="custom-control custom-checkbox mr-sm-2">
                                        <input type="checkbox" name="etat" class="custom-control-input" id="chb" <?php if($famille->etat == 1) echo "checked"; ?> >
                                        <label class="custom-control-label" for="chb">Désactiver</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">Modifier</button>
                                <a href="<?= site_url("famille/index/") ?>" class="btn btn-danger">Quitter</a>
                            </div>
                        </div>
                        <input type="hidden" name="id" value="<?= $famille->idfamille ?>">
                    <?php echo form_close();?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Liste des familles</h4>
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Désignation</th>
                                        <th>Image</th>
                                        <th>Etat</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach ($familles as $item) {
                                        $status = "Activer";
                                        if($item->etat  > 0)
                                            $status = "Désactiver";
                                        ?>
                                        <tr>
                                            <td><?= $item->libelle ?></td>
                                            <td><img src="<?= base_url() ?>/Uploads/Familles/<?= $item->image ?>" alt="<?= $item->libelle ?>" style="width: 50px; height: 50px;"></td>
                                            <td><?= $status ?></td>
                                            <td>
                                                <a href="<?= site_url("famille/edit/".$item->idfamille) ?>" class="btn btn-danger">Modifier</a>
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
