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
                <h4 class="page-title">Pertes Produit</h4>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Filtre:
                        <?php echo form_open("stock/historique_perte", array('class'=>'form-horizontal form-bordered', 'id'=>'filter'));?>
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

                                    <div class="col-md-2 col-sm-12 text-sm-center">
                                        <button type="submit" class="btn btn-success"> Afficher</button>
                                        <a href="<?= site_url('Accueil/') ?>" type="button" class="btn btn-danger"> Quitter</a>
                                    </div>
                                </div>
                            </div>
                        <?php echo form_close();?>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <h4>
                                <?= $texte ?>
                            </h4>

                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Heure</th>
                                        <th>Point de Vente</th>
                                        <th>Produit</th>
                                        <th>Quantité Perdue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($details) AND !empty($details)){
                                            foreach ($details as $detail) {
                                                ?>
                                                <tr>
                                                    <td><?= $detail['date'] ?></td>
                                                    <td><?= $detail['heure'] ?></td>
                                                    <td><?= $detail['Point'] ?></td>
                                                    <td><?= $detail['Produit'] ?></td>
                                                    <td><?= $detail['quantite'] ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right">
                            <a href="<?= site_url("stock/printHistory/".$link) ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Imprimer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

