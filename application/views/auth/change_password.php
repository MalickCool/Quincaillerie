<section role="main" class="content-body">
    <header class="page-header">
        <h2><?php echo lang('change_password_heading');?></h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?= site_url("accueil/") ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Mon compte</span></li>
                <li><span>Modifier Mot de Passe</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"></a>
        </div>
    </header>

    <!-- start: page -->

    <?php echo form_open("auth/change_password", array('class'=>'form-horizontal', 'id'=>'form'));?>
    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title"><?php echo lang('change_password_heading');?></h2>
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
                <label for="old" class="col-sm-2 control-label pdr0"><?php echo lang('change_password_old_password_label');?></label>
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-edit"></i>
                        </span>
                        <input type="password" name="old" id="old" value="" class="form-control" required/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="new" class="col-sm-2 control-label"><?php echo lang('change_password_new_password_label');?></label>
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-edit"></i>
                        </span>
                        <input type="password" name="new" id="new" value="" class="form-control" required/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="new_confirm" class="col-sm-2 control-label"><?php echo lang('change_password_new_password_confirm_label');?></label>
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-edit"></i>
                        </span>
                        <input type="password" name="new_confirm" id="new_confirm" value="" class="form-control" required/>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_input($user_id);?>

        <footer class="panel-footer">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 text-center">
                    <a type="button" class="btn btn-default" href="<?= site_url("accueil/") ?>"><i class="fa fa-mail-reply-all"></i> Quitter</a>
                    <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-edit"></i> Modifier</button>
                </div>
            </div>
        </footer>
    </section>
    <?php echo form_close();?>

</section>
</div>
</section>