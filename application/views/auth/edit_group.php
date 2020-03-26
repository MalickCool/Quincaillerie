<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Modifier</h4>
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
                    <section role="main" class="content-body">
                        <header class="page-header">
                            <h2></h2>
                        </header>

                        <!-- start: page -->

                        <?php echo form_open(current_url(), array('class'=>'form-horizontal', 'id'=>'form'));?>
                            <section class="panel">
                                <header class="panel-heading">

                                    <?php
                                    if($message != "") {
                                        ?>
                                        <div id="infoMessage" class="alert alert-danger text-center"><?php echo $message; ?></div>
                                        <?php
                                    }
                                    ?>
                                </header>

                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="group_name" class="col-sm-12 control-label pr-0"><?php echo lang('edit_group_name_label');?></label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="group_name" id="group_name" value="<?= $group_name['value'] ?>" class="form-control" required/>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label for="group_description" class="col-sm-12 control-label"><?php echo lang('edit_group_desc_label');?></label>
                                                    <div class="col-sm-12">
                                                        <input type="text" name="group_description" id="group_description" value="<?= $group_description['value'] ?>" class="form-control" required/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                </div>

                                <footer class="panel-footer pb-3">
                                    <div class="row">
                                        <div class="col-sm-6 offset-sm-3 text-center">
                                            <a type="button" class="btn btn-default" href="<?= site_url("accueil/") ?>"><i class="fa fa-mail-reply-all"></i> Quitter</a>
                                            <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-edit"></i> Modifier</button>
                                        </div>
                                    </div>
                                </footer>
                            </section>
                        <?php echo form_close();?>
                    </section>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <section role="main" class="content-body card-body">

                        <h2 class="text-center pt-3">Liste Groupes d’Utilisateurs</h2>
                        <table class="table table-bordered table-striped mb-none data-table" id="datatable-default">
                            <thead>
                                <tr>
                                    <th>Nom du Service</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($groups as $group):?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($group->name,ENT_QUOTES,'UTF-8');?></td>
                                        <td><?php echo htmlspecialchars($group->description,ENT_QUOTES,'UTF-8');?></td>
                                        <td class="text-center">
                                            <span class="">
                                                <a class="btn btn-warning" href="<?= site_url("auth/edit_group/".$group->id) ?>"> Modifier</a>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <a href="" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Imprimer</a>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>