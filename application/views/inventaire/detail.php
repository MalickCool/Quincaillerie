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
                <h4 class="page-title">Detail Inventaires</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Stock</li>
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
                            <div class="col-sm-9 text-left">
                                <h3><?= $titre ?></h3>
                                <h5>Lieux de Stockage: <?= $entrepot->designation ?></h5>
                            </div>
                            <div class="col-sm-3 text-right">
                                <a href="<?= site_url("accueil/") ?>" class="btn btn-danger"> Quitter</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Intrant</th>
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
                                                <td><?= $item->designation ?></td>
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
                        <a href="<?= site_url("inventaire/imprimerAfficher/".$inventaire->idinventaire) ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

