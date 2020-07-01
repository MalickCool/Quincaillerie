<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 15:31
 */
?>
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Liste</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Configuration</li>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-12 text-right pb-2">
                                <a href="<?= site_url("unite/ajouter") ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Ajouter Unité de Mesure</a>
                                <a href="<?= site_url("accueil/") ?>" class="btn btn-danger"><i class="fa fa-plus"></i> Quitter</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Désignation</th>
                                        <th>Symbole</th>
                                        <th>Valeur</th>
                                        <th>Unité Parente</th>
                                        <th>Etat</th>
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
                                                <td><?= $item['symbole'] ?></td>
                                                <td><?= $item['valeur'] ?></td>
                                                <td><?= $item['parent'] ?></td>
                                                <td><?= $status ?></td>
                                                <td>
                                                    <a href="<?= site_url("unite/edit/".$item['idunite']) ?>" class="btn btn-danger">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
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

