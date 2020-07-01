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
				<?php
					if(isset($_SESSION['message'])){
						?>

							<div class="alert alert-success col-md-12" role="alert">
								<?= $_SESSION['message'] ?>
							</div>

						<?php
					}
				?>
				<div class="col-md-12">
					<table class="datatableset table table-striped table-bordered">
						<thead>
							<tr>
								<th><?php echo lang('index_username_th');?></th>
								<th><?php echo lang('index_fname_th');?></th>
								<th><?php echo lang('index_lname_th');?></th>
								<th><?php echo lang('index_email_th');?></th>
								<th><?php echo lang('index_groups_th');?></th>
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
								<td colspan="7" class="text-right">
									<a target="_blank" href="<?= site_url("auth/printIndex") ?>" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Imprimer</a>
								</td>
							</tr>
						</tfoot>
					</table>

					<p class="col-sm-12">
						<a class="btn btn-outline-info" href="<?= site_url("auth/create_user") ?>">Créer un Utilisateur</a> |
						<a class="btn btn-outline-primary" href="<?= site_url("auth/create_group") ?>">Créer un Groupe</a>
					</p>
				</div>
			</div>
			<!-- /.row (main row) -->
		</div><!-- /.container-fluid -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

