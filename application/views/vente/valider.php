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
                <h4 class="page-title">Gestion des Versements</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sce Comptabilité</li>
                            <li class="breadcrumb-item active" aria-current="page">Encaissement</li>
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
            <?php echo form_open("commande/validercmd", array('class'=>'form-horizontal col-12', 'id'=>'form'));?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <fieldset id="filedset0">
                                    <legend>Commande</legend>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-3 text-right control-label col-form-label">N° Commande :</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" readonly value="<?= $returnArray['Commande']->idcommande ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="" class="col-sm-3 text-right control-label col-form-label">Client :</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" readonly value="<?= $returnArray['Client']->nom ?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="dateLiv" class="col-sm-3 text-right control-label col-form-label">Date de Livraison :</label>
                                        <div class="col-sm-4">
                                            <input type="date" id="dateLiv" name="dateLiv" required value="<?= $returnArray['Commande']->datelivraison ?>" class="form-control" min="<?= date('Y-m-d') ?>">
                                        </div>

                                        <label for="lieuxLiv" class="col-sm-1 text-right control-label col-form-label">Lieu :</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="lieuxLiv" name="lieuxLiv" required value="<?= $returnArray['Commande']->lieuxlivraison ?>" class="form-control" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="nomRecep" class="col-sm-3 text-right control-label col-form-label">Réceptionniste :</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="nomRecep" name="nomRecep" required value="<?= $returnArray['Commande']->chefchantier ?>" class="form-control" >
                                        </div>

                                        <label for="numRecep" class="col-sm-2 text-right control-label col-form-label">Numéro :</label>
                                        <div class="col-sm-3">
                                            <input type="text" id="numRecep" name="numRecep" required value="<?= $returnArray['Commande']->numchefchantier ?>" class="form-control" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="" class="col-sm-3 text-right control-label col-form-label">TVA :</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" readonly value="<?= $returnArray['Tva'] ?>%">
                                        </div>

                                        <label for="" class="col-sm-3 text-right control-label col-form-label">Montant TVA :</label>
                                        <?php
                                        $mTVA = $returnArray['Commande']->montant * $returnArray['Tva'] / 100;
                                        ?>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" readonly value="<?= $this->commande_m->formatNumber($mTVA) ?> FCFA">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="" class="col-sm-3 text-right control-label col-form-label">Montant TTC :</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" readonly value="<?= $this->commande_m->formatNumber($returnArray['MontTTC']) ?> FCFA">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="" class="col-sm-3 text-right control-label col-form-label">Transport :</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" readonly value="<?= $this->commande_m->formatNumber($returnArray['FraisPort']) ?> FCFA">
                                        </div>

                                        <label for="" class="col-sm-3 text-right control-label col-form-label">Total Remise :</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" readonly value="<?= $this->commande_m->formatNumber($returnArray['TotalRemise']) ?> FCFA">
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label for="" class="col-sm-3 text-right control-label col-form-label">Total Commande:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" readonly value="<?= $this->commande_m->formatNumber($returnArray['TotalTTC']) ?> FCFA">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="totalTTC" value="<?= $returnArray['TotalTTC'] ?>">
                    <input type="hidden" name="comdId" value="<?= $returnArray['Commande']->idcommande ?>">
                    <input type="hidden" name="token" value="<?= bin2hex(openssl_random_pseudo_bytes(50)) ?>">

                    <div class="col-md-6">
                        <div class="card" style="height: 95%">
                            <div class="card-body">
                                <fieldset id="filedset0" style="height: 100%">
                                    <legend>Agglos Commandés</legend>

                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Agglos</th>
                                                <th>Quantité</th>
                                                <th>Prix Unitaire</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $montantT = 0;
                                                foreach ($returnArray['Briques'] as $brique) {
                                                    $montantT += ($brique['Qte'] * $brique['Pu']);
                                                    ?>
                                                    <tr>
                                                        <td><?= $brique['Brique'] ?></td>
                                                        <td><?= $brique['Qte'] ?></td>
                                                        <td><?= $brique['Pu'] ?></td>
                                                        <td><?= $this->commande_m->formatNumber($brique['Qte'] * $brique['Pu']) ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">Total HT</td>
                                                <td><?= $this->commande_m->formatNumber($montantT) ?> FCFA</td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </fieldset>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card" style="height: 95%">
                            <div class="card-body">
                                <fieldset id="filedset0" style="height: 100%">
                                    <legend>Versement</legend>

                                    <div class="form-group row">
                                        <div class="offset-md-2 col-md-8">
                                            <label for="nompayeur" class="col-sm-12 text-left control-label col-form-label">Nom & Prénom</label>
                                            <div class="col-sm-12">
                                                <input type="text" id="nompayeur" class="form-control" name="nompayeur" min="1" required style="border: 2px red solid">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-md-2 col-md-8">
                                            <label for="moyen" class="col-sm-12 text-left control-label col-form-label">Moyen de Paiement :</label>
                                            <div class="col-sm-12">
                                                <select name="typepaiement" class="select2 form-control custom-select" id="moyen" style="border: 2px red solid">
                                                    <option value="espece">Espèce</option>
                                                    <option value="cheque">Chèque</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row chequeDiv d-none">
                                        <div class="offset-md-2 col-md-4">
                                            <label for="numCheque" class="col-sm-12 text-left control-label col-form-label">N° du Chèque:</label>
                                            <div class="col-sm-12">
                                                <input type="number" id="numCheque" class="form-control" name="numerocheque" min="1" style="border: 2px red solid">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="banque" class="col-sm-12 text-left control-label col-form-label">Banque:</label>
                                            <div class="col-sm-12">
                                                <input type="text" id="banque" class="form-control" name="nombanque" style="border: 2px red solid">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-md-2 col-md-8">
                                            <label for="montV" class="col-sm-12 text-left control-label col-form-label">Somme Versé :</label>
                                            <div class="col-sm-12">
                                                <input type="number" id="montV" class="form-control" name="montV" min="1" style="border: 2px red solid">
                                                <input type="hidden" id="montVV" class="form-control" name="montVV" min="1">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-md-2 col-md-8">
                                            <label for="reste" class="col-sm-12 text-left control-label col-form-label">Reste à payer :</label>
                                            <div class="col-sm-12">
                                                <input type="text" id="reste" readonly class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row echeanceDiv">
                                        <div class="offset-md-2 col-md-8">
                                            <label for="echeance" class="col-sm-12 text-left control-label col-form-label">Date prochaine échéance</label>
                                            <div class="col-sm-12">
                                                <input type="date" id="echeance" class="form-control" name="echeance" min="<?= date('Y-m-d') ?>" style="border: 2px red solid">
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group row mb-0">
                                    <div class="col-sm-12 text-center">
                                        <button class="btn btn-success" type="submit"> Valider la Commade</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



