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
                <h4 class="page-title">Situation Banque</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
                            <li class="breadcrumb-item" aria-current="page">Sce Comptabilité</li>
                            <li class="breadcrumb-item active" aria-current="page">Situation Banque</li>
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
                        <?php echo form_open("versement/banque", array('class'=>'form-horizontal form-bordered', 'id'=>'filter'));?>
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
                            <div class="col-sm-6 font-weight-bold font-20"><?= $titre ?></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Site</th>
                                        <th>Motif</th>
                                        <th>Effectué Par</th>
                                        <th>Montant</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $total = 0;
                                        foreach ($depenses as $item) {
                                            $total += $item->montant;
                                            ?>
                                            <tr>
                                                <td><?= date('d/m/Y', strtotime($item->datedepense)) ?></td>
                                                <td><?php if($item->site_id > 0){$site = $this->site_m->get($item->site_id); echo $site->nomsite; }else{ echo"-"; } ?></td>
                                                <td><?= $item->motifdepense ?></td>

                                                <td><?= $this->ion_auth->user($item->iduser)->row()->first_name." ".$this->ion_auth->user($item->iduser)->row()->last_name ?></td>
                                                <td><?= $this->depense_m->formatNumber($item->montant) ?> FCFA</td>
                                                <td>
                                                    <?php

                                                        if(is_null($item->factureachat) OR $item->factureachat == 2){
                                                            if($item->datedepense == date("Y-m-d")){
                                                                ?>
                                                                <a href="<?= site_url("depense/edit/".$item->iddepense) ?>" class="btn btn-danger"><i class="mdi mdi-update"></i> Modifier</a>
                                                                <?php
                                                            }
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
                                        <td colspan="4">Total Versement Banque</td>
                                        <td><?= $this->depense_m->formatNumber($total) ?> FCFA</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="<?= site_url("versement/imprimerSituation/".$link) ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-print"> Imprimer</i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

