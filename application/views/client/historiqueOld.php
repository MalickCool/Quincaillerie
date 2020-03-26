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
                <h4 class="page-title">Historique des Commandes</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sce Commercial</li>
                            <li class="breadcrumb-item active" aria-current="page">Historique Commande</li>
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
                        <?= $texte ?>
                    </div>
                    <div class="card-body">
                        <?php
                            foreach ($commandes as $commande) {
                                ?>

                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>N° Commande</th>
                                            <th>Montant TTC</th>

                                            <th>Frais Transport</th>
                                            <th>Remise</th>
                                            <th>Montant Total</th>

                                            <th>Status</th>

                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $montant = 0;
                                                $total = 0;
                                                $totalRemise = 0;
                                                //foreach ($commandes as $commande) {
                                                    $montant += $commande['Reste'];
                                                    $total += $commande['TotalTTC'];
                                                    $totalRemise += $commande['TotalRemise'];
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?= date('d/m/Y', strtotime($commande['Commande']->datecommande)) ?></td>
                                                        <td><?= date('Y/m/', strtotime($commande['Commande']->datecommande))."_".$commande['Commande']->idcommande ?></td>
                                                        <td class="text-right"><?= $this->commande_m->formatNumber($commande['MontTTC']) ?> FCFA</td>
                                                        <td class="text-right"><?= $this->commande_m->formatNumber($commande['FraisPort']) ?> FCFA</td>
                                                        <td class="text-right"><?= $this->commande_m->formatNumber($commande['TotalRemise']) ?> FCFA</td>
                                                        <td class="text-right"><?= $this->commande_m->formatNumber($commande['TotalTTC']) ?> FCFA</td>

                                                        <td>
                                                            <?php
                                                            if($commande['Commande']->etat == 1){
                                                                if($commande['Reste'] > 0){
                                                                    echo "Non Soldée";
                                                                }else{
                                                                    echo "Soldée";
                                                                }
                                                            }else{
                                                                echo "Non Validée";
                                                            }
                                                            ?>
                                                        </td>

                                                        <td class="text-center">
                                                            <?php
                                                            if($commande['Commande']->etat == 1){
                                                                ?>
                                                                <a role="button" href="<?= site_url("commande/details/".$commande['Commande']->idcommande) ?>" class="btn btn-info">Détail</a>
                                                                <?php
                                                            }else{
                                                                ?>
                                                                <a role="button" href="<?= site_url("commande/valider/".$commande['Commande']->idcommande) ?>" class="btn btn-primary">
                                                                    Valider
                                                                </a>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                //}
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">Total Reste à Payer</td>
                                                <td class="font-weight-bold font-24 text-center">
                                                    <?= $this->commande_m->formatNumber($totalRemise) ?> FCFA
                                                </td>

                                                <td class="font-weight-bold font-24 text-center">
                                                    <?= $this->commande_m->formatNumber($total) ?> FCFA
                                                </td>
                                                <td class="font-weight-bold font-24 text-center">
                                                    <?= $this->commande_m->formatNumber($montant) ?> FCFA
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <?php
                            }
                        ?>


                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>N° Commande</th>
                                        <th>Montant TTC</th>

                                        <th>Frais Transport</th>
                                        <th>Remise</th>
                                        <th>Montant Total</th>

                                        <th>Status</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $montant = 0;
                                        $total = 0;
                                        $totalRemise = 0;
                                        foreach ($commandes as $commande) {
                                            $montant += $commande['Reste'];
                                            $total += $commande['TotalTTC'];
                                            $totalRemise += $commande['TotalRemise'];
                                            ?>
                                            <tr>
                                                <td class="text-center"><?= date('d/m/Y', strtotime($commande['Commande']->datecommande)) ?></td>
                                                <td><?= date('Y/m/', strtotime($commande['Commande']->datecommande))."_".$commande['Commande']->idcommande ?></td>
                                                <td class="text-right"><?= $this->commande_m->formatNumber($commande['MontTTC']) ?> FCFA</td>
                                                <td class="text-right"><?= $this->commande_m->formatNumber($commande['FraisPort']) ?> FCFA</td>
                                                <td class="text-right"><?= $this->commande_m->formatNumber($commande['TotalRemise']) ?> FCFA</td>
                                                <td class="text-right"><?= $this->commande_m->formatNumber($commande['TotalTTC']) ?> FCFA</td>

                                                <td>
                                                    <?php
                                                        if($commande['Commande']->etat == 1){
                                                            if($commande['Reste'] > 0){
                                                                echo "Non Soldée";
                                                            }else{
                                                                echo "Soldée";
                                                            }
                                                        }else{
                                                            echo "Non Validée";
                                                        }
                                                    ?>
                                                </td>

                                                <td class="text-center">
                                                    <?php
                                                        if($commande['Commande']->etat == 1){
                                                            ?>
                                                            <a role="button" href="<?= site_url("commande/details/".$commande['Commande']->idcommande) ?>" class="btn btn-info">Détail</a>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <a role="button" href="<?= site_url("commande/valider/".$commande['Commande']->idcommande) ?>" class="btn btn-primary">
                                                                Valider
                                                            </a>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">Total Reste à Payer</td>
                                        <td class="font-weight-bold font-24 text-center">
                                            <?= $this->commande_m->formatNumber($totalRemise) ?> FCFA
                                        </td>

                                        <td class="font-weight-bold font-24 text-center">
                                            <?= $this->commande_m->formatNumber($total) ?> FCFA
                                        </td>
                                        <td class="font-weight-bold font-24 text-center">
                                            <?= $this->commande_m->formatNumber($montant) ?> FCFA
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>


                    </div>
                    <div class="card-footer text-right">
                        <a href="<?= site_url("client/imprimerHistorique/".$clientId) ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

