<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 09/07/2019
 * Time: 12:34
 */
?>
<style>
	.nav-treeview{
		padding-left: 30px !important;
	}
</style>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark">
	<!-- Left navbar links -->
	<ul class="navbar-nav d-none">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="index3.html" class="nav-link">Home</a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="#" class="nav-link">Contact</a>
		</li>
	</ul>

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">

		<!-- Notifications Dropdown Menu -->
		<li class="nav-item dropdown">
			<a class="nav-link p-0" data-toggle="dropdown" href="#">
				<img src="<?= base_url("assets/dist/img/avatar.jpg") ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
					 style="height: 100%; width: auto">
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<a href="javascript:void(0)" class="dropdown-item">
					<i class="fa fa-user m-r-5 m-l-5"></i> <?= ucfirst($this->ion_auth->user()->row()->username) ?>
				</a>

				<a href="<?= site_url('auth/logout'); ?>" class="dropdown-item">
					<i class="fa fa-power-off m-r-5 m-l-5"></i> Déconnexion
				</a>
			</div>
		</li>
	</ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="<?= site_url("accueil/") ?>" class="brand-link d-block text-xl-center">
		<img src="<?= base_url("assets/dist/img/logo.jpg") ?>" alt="AdminLTE Logo" class="" style="width: 100%">
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
					 with font-awesome or any other icon font library -->
				<li class="nav-item has-treeview <?= (isset($menu) && $menu == 'config') ? 'menu-open' : "" ?>">
					<a href="#" class="nav-link <?= (isset($menu) && $menu == 'config') ? 'active' : "" ?>">
						<i class="nav-icon fas fa-cogs"></i>
						<p>
							Configuration
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url("auth/index") ?>" class="nav-link">
								<i class="fas fa-users-cog nav-icon"></i>
								<p>Utilisateurs</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url("entrepot/ajouter") ?>" class="nav-link">
								<i class="fas fa-warehouse nav-icon"></i>
								<p>Magasins</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url("fournisseur/ajouter") ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Fournisseurs</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url("famille/ajouter") ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Famille Produit</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url("produit/ajouter") ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Produit</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item has-treeview <?= (isset($menu) && $menu == 'stock') ? 'menu-open' : "" ?>">
					<a href="#" class="nav-link <?= (isset($menu) && $menu == 'stock') ? 'active' : "" ?>">
						<i class="nav-icon fas fa-cogs"></i>
						<p>
							Gestion de Stock
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url("Commande/ajouter") ?>" class="nav-link">
								<i class="fas fa-users-cog nav-icon"></i>
								<p>Bon de Commande</p>
							</a>
						</li>
					</ul>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url("Stock/entrepot") ?>" class="nav-link">
								<i class="fas fa-users-cog nav-icon"></i>
								<p>Etat du Stock</p>
							</a>
						</li>
					</ul>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url("inventaire/entrepot") ?>" class="nav-link">
								<i class="fas fa-users-cog nav-icon"></i>
								<p>Inventaire</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item has-treeview <?= (isset($menu) && $menu == 'commerciale') ? 'menu-open' : "" ?>">
					<a href="#" class="nav-link <?= (isset($menu) && $menu == 'commerciale') ? 'active' : "" ?>">
						<i class="nav-icon fas fa-cogs"></i>
						<p>
							Gestion Commerciale
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url("commercial/ajouter") ?>" class="nav-link">
								<i class="fas fa-users-cog nav-icon"></i>
								<p>Commerciaux</p>
							</a>
						</li>
					</ul>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url("client/ajouter") ?>" class="nav-link">
								<i class="fas fa-users-cog nav-icon"></i>
								<p>Clients</p>
							</a>
						</li>
					</ul>

					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url("vente/ajouter") ?>" class="nav-link">
								<i class="fas fa-users-cog nav-icon"></i>
								<p>Vendre</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item has-treeview <?= (isset($menu) && $menu == 'caisse') ? 'menu-open' : "" ?>">
					<a href="#" class="nav-link <?= (isset($menu) && $menu == 'caisse') ? 'active' : "" ?>">
						<i class="nav-icon fas fa-cogs"></i>
						<p>
							Caisse
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url("depense/ajouter") ?>" class="nav-link">
								<i class="fas fa-users-cog nav-icon"></i>
								<p>Sasir Dépense</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= site_url("versement/ajouter") ?>" class="nav-link">
								<i class="fas fa-circle nav-icon"></i>
								<p>Approvisionnement</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item has-treeview <?= (isset($menu) && $menu == 'comptabilite') ? 'menu-open' : "" ?>">
					<a href="#" class="nav-link <?= (isset($menu) && $menu == 'comptabilite') ? 'active' : "" ?>">
						<i class="nav-icon fas fa-cogs"></i>
						<p>
							Comptabilité
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url("fournisseur/dettes") ?>" class="nav-link">
								<i class="fas fa-users-cog nav-icon"></i>
								<p>Créances Fournisseur</p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= site_url("client/detteClient") ?>" class="nav-link">
								<i class="fas fa-users-cog nav-icon"></i>
								<p>Créances Client</p>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item has-treeview <?= (isset($menu) && $menu == 'edition') ? 'menu-open' : "" ?>">
					<a href="#" class="nav-link <?= (isset($menu) && $menu == 'edition') ? 'active' : "" ?>">
						<i class="nav-icon fas fa-cogs"></i>
						<p>
							Edition
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url("auth/index") ?>" class="nav-link">
								<i class="fas fa-users-cog nav-icon"></i>
								<p>Liste des Utilisateurs</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url("entrepot/index") ?>" class="nav-link">
								<i class="fas fa-warehouse nav-icon"></i>
								<p>Liste des Magasins</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url("fournisseur/index") ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Liste des Fournisseurs</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url("famille/index") ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Liste des Familles</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url("produit/index") ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Liste des Produits</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url("Commande/index") ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Liste des Commandes</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url("inventaire/index") ?>" class="nav-link">
								<i class="fas fa-users-cog nav-icon"></i>
								<p>Liste des Inventaires</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url("inventaire/historiquedetaille") ?>" class="nav-link">
								<i class="fas fa-users-cog nav-icon"></i>
								<p>Inventaire Détaillé </p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url("client/index") ?>" class="nav-link">
								<i class="fas fa-users-cog nav-icon"></i>
								<p>Liste des Clients </p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= site_url("vente/index") ?>" class="nav-link">
								<i class="fas fa-users-cog nav-icon"></i>
								<p>Liste des Ventes </p>
							</a>
						</li>

						<li class="nav-item">
							<a href="<?= site_url("paiement/index") ?>" class="nav-link">
								<i class="fas fa-users-cog nav-icon"></i>
								<p>Liste des Paiements </p>
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>
