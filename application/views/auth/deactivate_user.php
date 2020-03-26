<div class="card">
    <section role="main" class="content-body">

        <!-- start: page -->

    <?php echo form_open("auth/deactivate/".$user->id);?>
        <div class="offset-sm-3 col-sm-6">
            <section class="panel card-body">
                <header class="panel-heading">
                    <h2 class="panel-title"><?php echo lang('deactivate_heading');?></h2>
                    <p><?php echo sprintf(lang('deactivate_subheading'), $user->first_name." ".$user->last_name);?></p>
                </header>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="radio-custom radio-danger">
                            <input type="radio" id="yes" name="confirm" value="yes">
                            <label for="yes"><?php echo lang('deactivate_confirm_y_label');?></label>
                        </div>

                        <div class="radio-custom radio-primary">
                            <input type="radio" checked id="no" name="confirm" value="no">
                            <label for="no"><?php echo lang('deactivate_confirm_n_label');?></label>
                        </div>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 text-center">
                            <a type="button" class="btn btn-danger" href="<?= site_url("auth/") ?>"><i class="fa fa-mail-reply-all"></i> Annuler</a>
                            <button type="submit" name="submit" class="btn btn-danger"><i class="fa fa-lock"></i> Désactiver</button>
                        </div>
                    </div>
                </footer>
            </section>
        </div>

      <?php echo form_hidden($csrf); ?>
      <?php echo form_hidden(['id' => $user->id]); ?>


    <?php echo form_close();?>

    </section>
    </div>
    </section>
</div>
