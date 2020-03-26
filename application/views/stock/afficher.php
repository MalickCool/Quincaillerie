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
                <h4 class="page-title">Affichage de la Facture d'achat</h4>
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
                        <ul class="list-style-none">
                            <li>
                                <b>
                                    - Date de la facture: <?= date('d/m/Y', strtotime($facture->datefacture)) ?>
                                </b>
                            </li>
                            <li>
                                <b>
                                    - Utilisateur: <?= $this->ion_auth->user($facture->iduser)->row()->first_name." ".$this->ion_auth->user($facture->iduser)->row()->last_name ?>
                                </b>
                            </li>
                            <li>
                                <b>
                                    - Numero de la Facture: <?= $facture->numfacture ?>
                                </b>
                            </li>
                            <li>
                                <b>
                                    - Fournisseur: <?= $fournisseur ?>
                                </b>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Quantité</th>
                                        <th>Prix Unitaire</th>
                                        <th>Total</th>
                                        <th>Entrepot</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    <?php
                                        $total = 0;
                                        foreach ($details as $detail) {
                                            $total += ($detail->qte * $detail->pu);
                                            ?>
                                            <tr>
                                                <td><?= $detail->intrant ?></td>
                                                <td><?= $detail->qte ?></td>
                                                <td><?= $this->achat_m->formatNumber($detail->pu) ?> FCFA</td>
                                                <td><?= $this->achat_m->formatNumber($detail->qte * $detail->pu) ?> FCFA</td>
                                                <td><?= $detail->entrepot ?></td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">Total:</td>
                                        <td><?= $this->achat_m->formatNumber($total) ?> FCFA</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
