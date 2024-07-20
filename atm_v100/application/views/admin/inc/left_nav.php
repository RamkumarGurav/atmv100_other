<style>
	.left_nav_icon_img {
		width: 15px;
	}

	.nav-icon {
		font-size: 10px !important
	}
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<a href="<?php echo MAINSITE_Admin . 'wam' ?>" class="brand-link">
		<img src="<?php echo _lte_files_ ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
			class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light"><?php echo _brand_name_ ?></span>
	</a>

	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<?php echo form_open("", array('method' => 'get', 'id' => 'sidebar-form', "name" => "sidebar-form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'onsubmit' => 'return false', 'autocomplete' => 'on')); ?>
		<div class="input-group">
			<input type="text" name="q" class="form-control" autocomplete="off" placeholder="Search..." id="search-input">

		</div>
		<?php echo form_close() ?>
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column sidebar-menu tree" data-widget="treeview" role="menu"
				data-accordion="false">
				<!--Company Profile-->
				<?
				if (!empty($left_menu_company_profile)) {
					$is_open = "";
					$active = "";
					if (!empty($page_is_master)) {
						if ($page_is_master == 3) {
							$is_open = "menu-open";
							$active = "active";
						}
					}
					?>
					<li class="nav-item has-treeview <?php echo $is_open ?>">
						<a href="#" class="nav-link <?php echo $active ?>"><i class="nav-icon fas fa-th"></i>
							<p>Company Profile<i class="fas fa-angle-left right"></i></p>
						</a>
						<ul class="nav nav-treeview"><?php echo $left_menu_company_profile ?></ul>
					</li>
				<?
				}
				?>
				<!--Humne Resource-->
				<?
				if (!empty($left_menu_employee)) {
					$is_open = "";
					$active = "";
					if (!empty($page_is_master)) {
						if ($page_is_master == 2) {
							$is_open = "menu-open";
							$active = "active";
						}
					}
					?>
					<li class="nav-item has-treeview <?php echo $is_open ?>">
						<a href="#" class="nav-link <?php echo $active ?>"><i class="nav-icon fas fa-th"></i>
							<p>Human Resource<i class="fas fa-angle-left right"></i></p>
						</a>
						<ul class="nav nav-treeview"><?php echo $left_menu_employee ?></ul>
					</li>
				<?
				}
				?>
				<!--User Employees-->
				<?
				if (!empty($left_menu_user_employee)) {
					$is_open = "";
					$active = "";
					if (!empty($page_is_master)) {
						if ($page_is_master == 11) {
							$is_open = "menu-open";
							$active = "active";
						}
					}
					?>
					<li class="nav-item has-treeview <?php echo $is_open ?>">
						<a href="#" class="nav-link <?php echo $active ?>"><i class="nav-icon fas fa-th"></i>
							<p>User Employees<i class="fas fa-angle-left right"></i></p>
						</a>
						<ul class="nav nav-treeview"><?php echo $left_menu_user_employee ?></ul>
					</li>
				<?
				}
				?>

				<!--Ip Addresses-->
				<?
				if (!empty($left_menu_ip_address)) {
					$is_open = "";
					$active = "";
					if (!empty($page_is_master)) {
						if ($page_is_master == 11) {
							$is_open = "menu-open";
							$active = "active";
						}
					}
					?>
					<li class="nav-item has-treeview <?php echo $is_open ?>">
						<a href="#" class="nav-link <?php echo $active ?>"><i class="nav-icon fas fa-th"></i>
							<p>IP Addresses<i class="fas fa-angle-left right"></i></p>
						</a>
						<ul class="nav nav-treeview"><?php echo $left_menu_ip_address ?></ul>
					</li>
				<?
				}
				?>

				<!--Catalog-->
				<?
				if (!empty($left_menu_catalog)) {
					$is_open = "";
					$active = "";
					if (!empty($page_is_master)) {
						if ($page_is_master == 4) {
							$is_open = "menu-open";
							$active = "active";
						}
					}
					?>
					<li class="nav-item has-treeview <?php echo $is_open ?>">
						<a href="#" class="nav-link <?php echo $active ?>"><i class="nav-icon fas fa-th"></i>
							<p>Catalog<i class="fas fa-angle-left right"></i></p>
						</a>
						<ul class="nav nav-treeview"><?php echo $left_menu_catalog ?></ul>
					</li>
				<?
				}
				?>

				<!--Booking-->
				<?
				if (!empty($left_menu_booking)) {
					$is_open = "";
					$active = "";
					if (!empty($page_is_master)) {
						if ($page_is_master == 4) {
							$is_open = "menu-open";
							$active = "active";
						}
					}
					?>
					<li class="nav-item has-treeview <?php echo $is_open ?>">
						<a href="#" class="nav-link <?php echo $active ?>"><i class="nav-icon fas fa-th"></i>
							<p>Booking<i class="fas fa-angle-left right"></i></p>
						</a>
						<ul class="nav nav-treeview"><?php echo $left_menu_booking ?></ul>
					</li>
				<?
				}
				?>


				<!--Media-->
				<?
				if (!empty($left_menu_media)) {
					$is_open = "";
					$active = "";
					if (!empty($page_is_master)) {
						if ($page_is_master == 4) {
							$is_open = "menu-open";
							$active = "active";
						}
					}
					?>
					<li class="nav-item has-treeview <?php echo $is_open ?>">
						<a href="#" class="nav-link <?php echo $active ?>"><i class="nav-icon fas fa-th"></i>
							<p>Media<i class="fas fa-angle-left right"></i></p>
						</a>
						<ul class="nav nav-treeview"><?php echo $left_menu_media ?></ul>
					</li>
				<?
				}
				?>

				<!--Enquiry-->
				<?
				if (!empty($left_menu_enquiry)) {
					$is_open = "";
					$active = "";
					if (!empty($page_is_master)) {
						if ($page_is_master == 5) {
							$is_open = "menu-open";
							$active = "active";
						}
					}
					?>
					<li class="nav-item has-treeview <?php echo $is_open ?>">
						<a href="#" class="nav-link <?php echo $active ?>"><i class="nav-icon fas fa-th"></i>
							<p>Enquiry<i class="fas fa-angle-left right"></i></p>
						</a>
						<ul class="nav nav-treeview"><?php echo $left_menu_enquiry ?></ul>
					</li>
				<?
				}
				?>

				<!--Customers-->
				<?
				if (!empty($left_menu_customers)) {
					$is_open = "";
					$active = "";
					if (!empty($page_is_master)) {
						if ($page_is_master == 8) {
							$is_open = "menu-open";
							$active = "active";
						}
					}
					?>
					<li class="nav-item has-treeview <?php echo $is_open ?>">
						<a href="#" class="nav-link <?php echo $active ?>"><i class="nav-icon fas fa-th"></i>
							<p>Customers<i class="fas fa-angle-left right"></i></p>
						</a>
						<ul class="nav nav-treeview"><?php echo $left_menu_customers ?></ul>
					</li>
				<?
				}
				?>

				<!--Banner-->
				<?
				if (!empty($left_menu_banner)) {
					$is_open = "";
					$active = "";
					if (!empty($page_is_master)) {
						if ($page_is_master == 6) {
							$is_open = "menu-open";
							$active = "active";
						}
					}
					?>
					<li class="nav-item has-treeview <?php echo $is_open ?>">
						<a href="#" class="nav-link <?php echo $active ?>"><i class="nav-icon fas fa-th"></i>
							<p>Banner<i class="fas fa-angle-left right"></i></p>
						</a>
						<ul class="nav nav-treeview"><?php echo $left_menu_banner ?></ul>
					</li>
				<?
				}
				?>

				<!--Videos-->
				<?
				if (!empty($left_menu_videos)) {
					$is_open = "";
					$active = "";
					if (!empty($page_is_master)) {
						if ($page_is_master == 9) {
							$is_open = "menu-open";
							$active = "active";
						}
					}
					?>
					<li class="nav-item has-treeview <?php echo $is_open ?>">
						<a href="#" class="nav-link <?php echo $active ?>"><i class="nav-icon fas fa-th"></i>
							<p>Videos<i class="fas fa-angle-left right"></i></p>
						</a>
						<ul class="nav nav-treeview"><?php echo $left_menu_videos ?></ul>
					</li>
				<?
				}
				?>
				<!--Working Method-->
				<?
				if (!empty($left_menu_working_method)) {
					$is_open = "";
					$active = "";
					if (!empty($page_is_master)) {
						if ($page_is_master == 10) {
							$is_open = "menu-open";
							$active = "active";
						}
					}
					?>
					<li class="nav-item has-treeview <?php echo $is_open ?>">
						<a href="#" class="nav-link <?php echo $active ?>"><i class="nav-icon fas fa-th"></i>
							<p>Working Method<i class="fas fa-angle-left right"></i></p>
						</a>
						<ul class="nav nav-treeview"><?php echo $left_menu_working_method ?></ul>
					</li>
				<?
				}
				?>

				<!--Gallery-->
				<?
				if (!empty($left_menu_gallery)) {
					$is_open = "";
					$active = "";
					if (!empty($page_is_master)) {
						if ($page_is_master == 7) {
							$is_open = "menu-open";
							$active = "active";
						}
					}
					?>
					<li class="nav-item has-treeview <?php echo $is_open ?>">
						<a href="#" class="nav-link <?php echo $active ?>"><i class="nav-icon fas fa-th"></i>
							<p>Curating Ideas<i class="fas fa-angle-left right"></i></p>
						</a>
						<ul class="nav nav-treeview"><?php echo $left_menu_gallery ?></ul>
					</li>
				<?
				}
				?>


				<!--Orders-->
				<?
				if (!empty($left_menu_orders)) {
					$is_open = "";
					$active = "";
					if (!empty($page_is_master)) {
						if ($page_is_master == 13) {
							$is_open = "menu-open";
							$active = "active";
						}
					}
					?>
					<li class="nav-item has-treeview <?php echo $is_open ?>">
						<a href="#" class="nav-link <?php echo $active ?>"><i class="nav-icon fas fa-th"></i>
							<p>Orders<i class="fas fa-angle-left right"></i></p>
						</a>
						<ul class="nav nav-treeview"><?php echo $left_menu_orders ?></ul>
					</li>
				<?
				}
				?>
				<!--Masters-->
				<?
				if (!empty($left_menu_master)) {
					$is_open = "";
					$active = "";
					if (!empty($page_is_master)) {
						if ($page_is_master == 1) {
							$is_open = "menu-open";
							$active = "active";
						}
					}
					?>
					<li class="nav-item has-treeview <?php echo $is_open ?>">
						<a href="#" class="nav-link <?php echo $active ?>"><i class="nav-icon fas fa-th"></i>
							<p>Masters<i class="fas fa-angle-left right"></i></p>
						</a>
						<ul class="nav nav-treeview"><?php echo $left_menu_master ?></ul>
					</li>
				<?
				}
				?>

			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
</aside>