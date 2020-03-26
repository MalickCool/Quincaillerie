<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Liste des Utilisateurs</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Accueil</a></li>
						<li class="breadcrumb-item active">Utilisateurs</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<section role="main" class="content-body card-body">
							<!-- start: page -->
							<?php echo form_open("auth/create_user", array('class'=>'form-horizontal', 'id'=>'form'));?>
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
									<div class="panel-body col-sm-12">

										<div class="form-group row">
											<div class="col-sm-6 pl-0">
												<label for="last_name" class="col-sm-12 control-label"><?php echo lang('create_user_lname_label', 'last_name');?> <span class="required">*</span></label>
												<div class="col-sm-12">
													<input type="text" name="last_name" id="last_name" class="form-control" required/>
												</div>
											</div>
											<div class="col-sm-6 pl-0">
												<label for="first_name" class="col-sm-12 control-label"><?php echo lang('create_user_fname_label', 'first_name');?> <span class="required">*</span></label>
												<div class="col-sm-12">
													<input type="text" name="first_name" id="first_name" class="form-control" required/>
												</div>
											</div>
										</div>



										<div class="form-group row">
											<div class="col-sm-4 pl-0">
												<label for="company" class="col-sm-12 control-label">Fonction <span class="required">*</span></label>
												<div class="col-sm-12">
													<input type="text" name="company" id="company" class="form-control" required/>
												</div>
											</div>
											<div class="col-sm-4 pl-0">
												<label for="email" class="col-sm-12 control-label"><?= lang('create_user_email_label', 'email') ?> <span class="required">*</span></label>
												<div class="col-sm-12">
													<input type="email" name="email" id="email" class="form-control" required/>
												</div>
											</div>

											<div class="col-sm-4 pl-0">
												<label for="phone" class="col-sm-12 control-label"><?= lang('create_user_phone_label', 'phone') ?> <span class="required">*</span></label>
												<div class="col-sm-12">
													<input type="text" name="phone" id="phone" class="form-control" required/>
												</div>
											</div>
										</div>

										<div class="form-group row">
											<div class="col-sm-4 pl-0">
												<label for="identity" class="col-sm-12 control-label"><?= lang('create_user_identity_label', 'identity') ?></label>
												<div class="col-sm-12">
													<input type="text" name="identity" id="identity" class="form-control" required/>
												</div>
											</div>

											<div class="col-sm-4 pl-0">
												<label for="password" class="col-sm-12 control-label"><?= lang('create_user_password_label', 'password') ?></label>
												<div class="col-sm-12">
													<input type="password" name="password" id="password" class="form-control" required/>
												</div>
											</div>

											<div class="col-sm-4 pl-0">
												<label for="password_confirm" class="col-sm-12 control-label"><?= lang('create_user_password_confirm_label', 'password_confirm') ?> <span class="required">*</span></label>
												<div class="col-sm-12">
													<input type="password" name="password_confirm" id="password_confirm" class="form-control" required/>
												</div>
											</div>
										</div>
									</div>
									<footer class="panel-footer pb-3">
										<div class="row">
											<div class="col-sm-6 offset-sm-3 text-center">
												<a href="<?= site_url('Accueil/') ?>" class="btn btn-default"><i class="fa fa-mail-reply-all"></i> Quitter</a>
												<button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-save"></i> Créer l'utilisateur</button>
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
						<section role="main" class="content-body">
							<h2 class="text-center pt-3">Liste Utilisateur</h2>
							<table id="zero_config" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th><?php echo lang('index_username_th');?></th>
										<th><?php echo lang('index_fname_th');?></th>
										<th><?php echo lang('index_lname_th');?></th>
										<th><?php echo lang('index_email_th');?></th>
										<th class="hidden"><?php echo lang('index_groups_th');?></th>
										<th><?php echo lang('index_status_th');?></th>
										<th><?php echo lang('index_action_th');?></th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($users as $user):?>
									<tr>
										<td><?php echo htmlspecialchars($user->username,ENT_QUOTES,'UTF-8');?></td>
										<td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
										<td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
										<td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
										<td>
											<?php foreach ($user->groups as $group):?>
												<?php if($group->name != "members"): ?>
													<span class="">
															<a href="<?= site_url("auth/edit_group/".$group->id) ?>" class="btn btn-primary"><?= htmlspecialchars($group->name,ENT_QUOTES,'UTF-8') ?></a>
														</span>
												<?php endif?>
											<?php endforeach?>
										</td>
										<td class="text-center">
											<?php
											if ($user->active){
												?>

												<span class="">
															<?php echo ($user->active) ? "<a class='btn btn-success' href='".site_url("auth/deactivate/".$user->id)."'>Activer</a>": "<a class='btn btn-danger'  href='".site_url("auth/activate/".$user->id)."'>Desactiver</a>";?>
														</span>
												<?php
											}else{
												?>
												<span class="">
															<?php echo ($user->active) ? "<a class='btn btn-success' href='".site_url("auth/deactivate/".$user->id)."'>Activer</a>": "<a class='btn btn-danger'  href='".site_url("auth/activate/".$user->id)."'>Desactiver</a>";?>
														</span>
												<?php
											}
											?>
										</td>
										<td class="text-center">
												<span class="">
													<a href="<?= site_url("auth/edit_user/".$user->id) ?>" class="btn btn-warning">Modifier</a>
												</span>
										</td>
									</tr>
								<?php endforeach;?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="6" class="text-right">
											<a href="" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Imprimer</a>
										</td>
									</tr>
								</tfoot>
							</table>

							<!-- end: page -->
						</section>
						</div>
						</section>
				</div>
			</div>
    	</div>
    </div>
</div>
