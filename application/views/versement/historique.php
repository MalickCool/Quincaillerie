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
                <h4 class="page-title"><?= $titre ?></h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Caisse</li>
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
                        Filtre:
                        <?php echo form_open("versement/historique", array('class'=>'form-horizontal form-bordered', 'id'=>'filter'));?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-10 col-sm-12" style="">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="today" name="periode" value="today" checked v-on:click="checked = false" >
                                                <label class="custom-control-label" for="today">Aujourd'hui</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="periode" name="periode" value="periode" v-on:click="fadein" >
                                                        <label class="custom-control-label" for="periode">Période</label>
                                                    </div>
                                                </div>

                                                <div class="col-sm-8">
                                                    <div class="pd0" v-if="checked">
                                                        <div class="input-group">
                                                            <input type="date" class="form-control" name="debut" v-model="mindate" v-on:change="maxdate = ''" v-bind:required="required">
                                                            <span class="input-group-addon" style="font-weight: bolder; width: 45px;text-align: center;font-size: 24px;">à</span>
                                                            <input type="date" class="form-control" name="fin" v-bind:min="mindate" v-bind:value="maxdate" v-bind:required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12 text-right">
                                    <button type="submit" class="btn btn-success"> Afficher</button>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close();?>
                    </div>

                    <div class="card-header mt-2">
                        <div class="row">
                            <div class="col-sm-8 font-weight-bold">
                                <?= $periode ?>
                            </div>
                            <div class="col-sm-4 text-right">
                                <a href="<?= site_url('Accueil/') ?>" type="button" class="btn btn-danger"><i class="mdi mdi-close-circle"></i>  Quitter</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Libellé</th>
                                        <th style="background-color: green; color: #FFFFFF;" class="font-weight-bold text-center">Entrée</th>
                                        <th style="background-color: red; color: #FFFFFF;" class="font-weight-bold text-center">Sortie</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $entree = 0;
                                        $depense = 0;
                                        foreach ($listes as $item) {
                                            $entree += ($item['Versement'] + $item['Recette']);
                                            $depense += ($item['Depense']);

                                            if(!empty($item['DepenseExploitation'])){
                                                foreach ($item['DepenseExploitation'] as $itemee) {
                                                    ?>
                                                    <tr>
                                                        <td><?= date('d/m/Y', strtotime($item['Date'])) ?></td>
                                                        <td><?= $itemee['motif'] ?></td>
                                                        <td></td>
                                                        <td class="text-center"><?= $this->versement_m->formatNumber($itemee['somme']) ?> FCFA</td>
                                                    </tr>
                                                    <?php
                                                }
                                            }

                                            if($item['DepenseAchat'] > 0){
                                                ?>
                                                <tr>
                                                    <td><?= date('d/m/Y', strtotime($item['Date'])) ?></td>
                                                    <td>Dépense Intrant</td>
                                                    <td></td>
                                                    <td class="text-center"><?= $this->versement_m->formatNumber($item['DepenseAchat']) ?> FCFA</td>
                                                </tr>
                                                <?php
                                            }

                                            if(!empty($item['DepenseBanque'])){
                                                foreach ($item['DepenseBanque'] as $iteme) {
                                                    ?>
                                                    <tr>
                                                        <td><?= date('d/m/Y', strtotime($item['Date'])) ?></td>
                                                        <td><?= $iteme['motif'] ?></td>
                                                        <td></td>
                                                        <td class="text-center"><?= $this->versement_m->formatNumber($iteme['somme']) ?> FCFA</td>
                                                    </tr>
                                                    <?php
                                                }
                                            }

                                            if($item['DepenseIntervention'] > 0){
                                                ?>
                                                <tr>
                                                    <td><?= date('d/m/Y', strtotime($item['Date'])) ?></td>
                                                    <td>Dépense Interventions</td>
                                                    <td></td>
                                                    <td class="text-center"><?= $this->versement_m->formatNumber($item['DepenseIntervention']) ?> FCFA</td>
                                                </tr>
                                                <?php
                                            }

                                            if($item['Versement'] > 0){
                                                ?>
                                                <tr>
                                                    <td><?= date('d/m/Y', strtotime($item['Date'])) ?></td>
                                                    <td>Versement</td>
                                                    <td class="text-center"><?= $this->versement_m->formatNumber($item['Versement']) ?> FCFA</td>
                                                    <td></td>
                                                </tr>
                                                <?php
                                            }

                                            if($item['Recette'] > 0){
                                                ?>
                                                <tr>
                                                    <td><?= date('d/m/Y', strtotime($item['Date'])) ?></td>
                                                    <td>Paiements Client</td>
                                                    <td class="text-center"><?= $this->versement_m->formatNumber($item['Recette']) ?> FCFA</td>
                                                    <td></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="2" class="font-20 font-weight-bold">Total:</td>
                                    <td class="font-20 font-weight-bold text-center"><?= $this->versement_m->formatNumber($entree) ?> FCFA</td>
                                    <td class="font-20 font-weight-bold text-center"><?= $this->versement_m->formatNumber($depense) ?> FCFA</td>
                                </tr>

                                <tr style="">
                                    <td class="font-24 font-weight-bold">Reste</td>
                                    <td colspan="3" class="font-24 font-weight-bold text-center"><?= $this->versement_m->formatNumber($entree - $depense) ?> FCFA</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="card-footer text-right">
                            <a href="<?= site_url("versement/imprimerMvt/".$link) ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

