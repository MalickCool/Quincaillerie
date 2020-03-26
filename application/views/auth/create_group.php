<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title"><?php echo lang('create_group_heading');?></h4>
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

                    <h1 class="text-center login-title"></h1>
                    <p class="col-sm-12"><?php echo lang('create_group_subheading');?></p>
                    <div class="account-wall">
                        <div id="infoMessage"><?php echo $message;?></div>

                        <?php echo form_open("auth/create_group", array('class'=>'form-signin form-horizontal'));?>
                            <fieldset style="margin-bottom: 0px; padding: 15px 25px;" class="col-12">
                                  <p>
                                        <?php echo lang('create_group_name_label', 'group_name');?> <br />
                                        <?php echo form_input($group_name);?>
                                  </p>

                                  <p>
                                        <?php echo lang('create_group_desc_label', 'description');?> <br />
                                        <?php echo form_input($description);?>
                                  </p>

                                  <p><?php echo form_submit('submit', lang('create_group_submit_btn'), array('class' => 'btn btn-success'));?></p>
                            </fieldset>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h2 class="text-center col-sm-12 pt-3">Liste des Groupes d'utilisateur</h2>
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nom du Groupe</th>
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
                                    <a target="_blank" href="<?= site_url("auth/print_create_group") ?>" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Imprimer</a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
