<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Selection du Magasin</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url("Accueil/index") ?>">Accueil</a></li>
						<li class="breadcrumb-item active">Stock</li>
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
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 text-center pb-5">
									<h3>Sélectionnez Magasin</h3>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 text-center">
									<?php
										foreach ($entrepots as $entrepot) {
											?>
											<a href="<?= site_url("inventaire/ajouter/".$entrepot->identrepot) ?>" class="btn btn-success btn-lg col-sm-4 mb-2"><i class="fa fa-warehouse"></i>  <?= $entrepot->designation ?></a>
											<?php
										}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
