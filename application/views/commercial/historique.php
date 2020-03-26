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

    <style>
        .form-group {
            margin-bottom: 0px !important;
        }
    </style>
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
                                <fieldset>
                                    <legend>Commande N° <?= date('Y/m/', strtotime($commande['Commande']->datecommande))."_".$commande['Commande']->idcommande ?></legend>
                                    <div class="row pl-2 pr-2">
                                        <div class="col-md-5 card">
                                            <div class="card-header" style="border: 1px solid;">
                                                Détails de la Commande
                                            </div>
                                            <div class="card-body" style="border: 1px solid; border-top: none">
                                                <div class="form-group row">
                                                    <label for="" class="col-sm-12 text-left control-label col-form-label">Client</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" class="form-control" readonly value="<?= $commande['Client']->nom ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="dateLiv" class="col-sm-12 text-left control-label col-form-label">Date et Lieu de Livraison</label>
                                                    <div class="col-sm-12">
                                                        <input type="text" id="dateLiv" readonly name="dateLiv" required value="Le <?= date('d/m/Y', strtotime($commande['Commande']->datelivraison)) ?> à <?= $commande['Commande']->lieuxlivraison ?>" class="form-control" min="<?= date('Y-m-d') ?>">
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6 pl-0">
                                                        <label for="nomRecep" class="col-sm-12 text-left control-label col-form-label">Réceptionniste</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" id="nomRecep" readonly name="nomRecep" required value="<?= $commande['Commande']->chefchantier ?>" class="form-control" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 pr-0">
                                                        <label for="numRecep" class="col-sm-12 text-left control-label col-form-label">Numéro</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" id="numRecep" readonly name="numRecep" required value="<?= $commande['Commande']->numchefchantier ?>" class="form-control" >
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6 pl-0">
                                                        <label for="" class="col-sm-12 text-left control-label col-form-label">Montant HT</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" readonly value="<?= $this->commande_m->formatNumber($commande['Commande']->montant) ?> FCFA">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 pr-0">
                                                        <label for="" class="col-sm-12 text-left control-label col-form-label">Montant TVA</label>
                                                        <?php
                                                        $mTVA = $commande['Commande']->montant * $commande['Tva'] / 100;
                                                        ?>
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" readonly value="<?= $this->commande_m->formatNumber($mTVA) ?> FCFA">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-12 pl-0">
                                                        <label for="" class="col-sm-12 text-left control-label col-form-label">Transport</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" readonly value="<?= $this->commande_m->formatNumber($commande['Commande']->montantfrais) ?> FCFA">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6 pl-0">
                                                        <label for="" class="col-sm-12 text-left control-label col-form-label">Total Remise sur Brique</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" readonly value="<?= $this->commande_m->formatNumber($commande['TotalRemise'] - $commande['Commande']->remisefacture) ?> FCFA">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 pr-0">
                                                        <label for="" class="col-sm-12 text-left control-label col-form-label">Remise sur Facture</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" style="font-weight: bolder; color: red" class="form-control" readonly value="<?= $this->commande_m->formatNumber($commande['Commande']->remisefacture) ?> FCFA">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-12 pr-0">
                                                        <label for="" class="col-sm-12 text-left control-label col-form-label">Montant Total</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" style="font-weight: bolder; color: red" class="form-control" readonly value="<?= $this->commande_m->formatNumber($commande['TotalTTC']) ?> FCFA">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6 pl-0">
                                                        <label for="" class="col-sm-12 text-left control-label col-form-label">Montant Payé :</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" style="font-weight: bolder; color: red" class="form-control" readonly value="<?= $this->commande_m->formatNumber($commande['MontantVerse']) ?> FCFA">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 pr-0">
                                                        <label for="" class="col-sm-12 text-left control-label col-form-label">Reste à payer :</label>
                                                        <div class="col-sm-12">
                                                            <input type="text" style="font-weight: bolder; color: red" class="form-control" readonly value="<?= $this->commande_m->formatNumber($commande['TotalTTC'] - $commande['MontantVerse']) ?> FCFA">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">

                                                </div>
                                                <div class="form-group row">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-7 card">
                                            <div class="card-header" style="border: 1px solid;">
                                                Détails Agglos Commandés
                                            </div>
                                            <div class="card-body" style="border: 1px solid; border-top: none">
                                                <div class="table-responsive">
                                                    <table id="zero_config" class="table table-striped table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>Agglos</th>
                                                            <th class="d-none">Designation Agglo</th>
                                                            <th>PU</th>

                                                            <th>Montant Remise</th>
                                                            <th class="d-none">PU de vente</th>
                                                            <th>Quantité Commandé</th>
                                                            <th>Montant Total</th>

                                                            <th>Quantité Livré</th>

                                                            <th>Reste</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        foreach ($commande['Briques'] as $brique) {

                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><?= $brique['CodeBrique'] ?></td>
                                                            <td class="d-none"><?= $brique['Brique'] ?></td>
                                                            <td><?= $this->commande_m->formatNumber($brique['Pu']) ?> FCFA</td>
                                                            <td><?= $this->commande_m->formatNumber($brique['Remise']) ?> FCFA</td>
                                                            <td class="d-none"><?= $this->commande_m->formatNumber($brique['Pu'] - $brique['Remise']) ?> FCFA</td>
                                                            <td><?= $brique['Qte'] ?></td>
                                                            <td><?= $this->commande_m->formatNumber($brique['Qte'] * ($brique['Pu'] - $brique['Remise'])) ?> FCFA</td>
                                                            <td><?= $brique['NbreLivrer'] ?></td>
                                                            <td><?= $brique['Qte'] - $brique['NbreLivrer'] ?></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-7 card">
                                            <div class="card-header" style="border: 1px solid;">
                                                Détails Paiements
                                            </div>
                                            <div class="card-body" style="border: 1px solid; border-top: none">
                                                <div class="table-responsive">
                                                    <table id="zero_config" class="table table-striped table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Payeur</th>
                                                            <th>Type Paiement</th>

                                                            <th>Montant Versé</th>
                                                            <th>Encaissé par</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        foreach ($commande['Paiements'] as $paiement) {
                                                            ?>
                                                            <tr>
                                                                <td><?= date('d/m/Y', strtotime($paiement->datepaiement)) ?></td>
                                                                <td><?= $paiement->nompayeur ?></td>
                                                                <td><?= ucwords($paiement->typepaiement) ?></td>
                                                                <td><?= $this->commande_m->formatNumber($paiement->montant) ?> FCFA</td>
                                                                <td><?= $this->ion_auth->user($paiement->userid)->row()->first_name." ".$this->ion_auth->user($paiement->userid)->row()->last_name ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                            if(!empty($commande['Livraisons'])) {
                                                ?>
                                                <div class="col-md-5 card">
                                                    <div class="card-header" style="border: 1px solid;">
                                                        Détails Livraison
                                                    </div>
                                                    <div class="card-body" style="border: 1px solid; border-top: none">
                                                        <div class="table-responsive">
                                                            <table id="zero_config" class="table table-striped table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Date Livraison</th>
                                                                    <th>Véhicule</th>
                                                                    <th>Agglo Livré</th>

                                                                    <th>Quantité</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                foreach ($commande['Livraisons'] as $livraison) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= date('d/m/Y', strtotime($livraison['DateLivraison'])) ?></td>
                                                                        <td><?= ucwords($livraison['Vehicule']) ?></td>
                                                                        <td><?= ucwords($livraison['Agglos']) ?></td>
                                                                        <td><?= $this->commande_m->formatNumber($livraison['Qte']) ?></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                                ?>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </fieldset>

                                <?php
                            }
                        ?>

                    </div>
                    <div class="card-footer text-right">
                        <a href="<?= site_url("client/imprimerHistorique/".$clientId) ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

