<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AdminLteAsset;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;

AdminLteAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php $this->registerCsrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed">
	<?php $this->beginBody() ?>

	<!-- Wrapper -->
	<div class="wrapper">

		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
			</ul>

			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
				<!-- User -->
				<li class="nav-item dropdown">
					<a class="nav-link" data-toggle="dropdown" href="#">
						<i class="fas fa-user mr-2"></i>
						<span><?= Yii::$app->user->identity->usual_name ?></span>
					</a>

					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<span class="dropdown-item dropdown-header">15 Notifications</span>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-envelope mr-2"></i> 4 new messages
						</a>
						<a href="#" class="dropdown-item">
							<i class="fas fa-users mr-2"></i> 8 friend requests
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-file mr-2"></i> 3 new reports
						</a>
						<div class="dropdown-divider"></div>
						<a href=<?= Url::to(['site/logout']) ?> class="dropdown-item" data-method="post">
							<i class="fas fa-sign-out-alt mr-2"></i> Logout
						</a>
					</div>
				</li>
			</ul>
		</nav>

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<a href=<?= Url::to(['/site/index']) ?> class="brand-link">
				<p class="brand-text font-weight-bold text-center" style="margin: auto;">SISMEC</p>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
						<!-- Add icons to the links using the .nav-icon class
					with font-awesome or any other icon font library -->
						<li class="nav-item menu-open">
							<a href="#" class="nav-link active">
								<i class="nav-icon fas fa-tachometer-alt"></i>
								<p>
									Dashboard
									<i class="right fas fa-angle-left"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="./index.html" class="nav-link active">
										<i class="far fa-circle nav-icon"></i>
										<p>Dashboard v1</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="./index2.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Dashboard v2</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="./index3.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Dashboard v3</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item">
							<a href="pages/widgets.html" class="nav-link">
								<i class="nav-icon fas fa-th"></i>
								<p>
									Widgets
									<span class="right badge badge-danger">New</span>
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-copy"></i>
								<p>
									Layout Options
									<i class="fas fa-angle-left right"></i>
									<span class="badge badge-info right">6</span>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="pages/layout/top-nav.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Top Navigation</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/layout/top-nav-sidebar.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Top Navigation + Sidebar</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/layout/boxed.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Boxed</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/layout/fixed-sidebar.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Fixed Sidebar</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/layout/fixed-sidebar-custom.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Fixed Sidebar <small>+ Custom Area</small></p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/layout/fixed-topnav.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Fixed Navbar</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/layout/fixed-footer.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Fixed Footer</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/layout/collapsed-sidebar.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Collapsed Sidebar</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-chart-pie"></i>
								<p>
									Charts
									<i class="right fas fa-angle-left"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="pages/charts/chartjs.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>ChartJS</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/charts/flot.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Flot</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/charts/inline.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Inline</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-tree"></i>
								<p>
									UI Elements
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="pages/UI/general.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>General</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/UI/icons.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Icons</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/UI/buttons.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Buttons</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/UI/sliders.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Sliders</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/UI/modals.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Modals & Alerts</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/UI/navbar.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Navbar & Tabs</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/UI/timeline.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Timeline</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/UI/ribbons.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Ribbons</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-edit"></i>
								<p>
									Forms
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="pages/forms/general.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>General Elements</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/forms/advanced.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Advanced Elements</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/forms/editors.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Editors</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/forms/validation.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Validation</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-table"></i>
								<p>
									Tables
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="pages/tables/simple.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Simple Tables</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/tables/data.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>DataTables</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/tables/jsgrid.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>jsGrid</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-header">EXAMPLES</li>
						<li class="nav-item">
							<a href="pages/calendar.html" class="nav-link">
								<i class="nav-icon far fa-calendar-alt"></i>
								<p>
									Calendar
									<span class="badge badge-info right">2</span>
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="pages/gallery.html" class="nav-link">
								<i class="nav-icon far fa-image"></i>
								<p>
									Gallery
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon far fa-envelope"></i>
								<p>
									Mailbox
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="pages/mailbox/mailbox.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Inbox</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/mailbox/compose.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Compose</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/mailbox/read-mail.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Read</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-book"></i>
								<p>
									Pages
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="pages/examples/invoice.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Invoice</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/examples/profile.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Profile</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/examples/e-commerce.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>E-commerce</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/examples/projects.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Projects</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/examples/project-add.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Project Add</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/examples/project-edit.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Project Edit</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/examples/project-detail.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Project Detail</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/examples/contacts.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Contacts</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon far fa-plus-square"></i>
								<p>
									Extras
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="pages/examples/login.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Login</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/examples/register.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Register</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/examples/forgot-password.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Forgot Password</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/examples/recover-password.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Recover Password</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/examples/lockscreen.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Lockscreen</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/examples/legacy-user-menu.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Legacy User Menu</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/examples/language-menu.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Language Menu</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/examples/404.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Error 404</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/examples/500.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Error 500</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/examples/pace.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Pace</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="pages/examples/blank.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Blank Page</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="starter.html" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Starter Page</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-header">MISCELLANEOUS</li>
						<li class="nav-item">
							<a href="https://adminlte.io/docs/3.0/" class="nav-link">
								<i class="nav-icon fas fa-file"></i>
								<p>Documentation</p>
							</a>
						</li>
						<li class="nav-header">MULTI LEVEL EXAMPLE</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="fas fa-circle nav-icon"></i>
								<p>Level 1</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-circle"></i>
								<p>
									Level 1
									<i class="right fas fa-angle-left"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="#" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Level 2</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="#" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>
											Level 2
											<i class="right fas fa-angle-left"></i>
										</p>
									</a>
									<ul class="nav nav-treeview">
										<li class="nav-item">
											<a href="#" class="nav-link">
												<i class="far fa-dot-circle nav-icon"></i>
												<p>Level 3</p>
											</a>
										</li>
										<li class="nav-item">
											<a href="#" class="nav-link">
												<i class="far fa-dot-circle nav-icon"></i>
												<p>Level 3</p>
											</a>
										</li>
										<li class="nav-item">
											<a href="#" class="nav-link">
												<i class="far fa-dot-circle nav-icon"></i>
												<p>Level 3</p>
											</a>
										</li>
									</ul>
								</li>
								<li class="nav-item">
									<a href="#" class="nav-link">
										<i class="far fa-circle nav-icon"></i>
										<p>Level 2</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="fas fa-circle nav-icon"></i>
								<p>Level 1</p>
							</a>
						</li>
						<li class="nav-header">LABELS</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon far fa-circle text-danger"></i>
								<p class="text">Important</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon far fa-circle text-warning"></i>
								<p>Warning</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="#" class="nav-link">
								<i class="nav-icon far fa-circle text-info"></i>
								<p>Informational</p>
							</a>
						</li>
					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">

				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark"><?= $this->title ?></h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<!-- <ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active">Dashboard v1</li>
							</ol> -->
							<?= Breadcrumbs::widget([
								'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
								'options' => [
									'class' => 'float-sm-right'
								],
							]) ?>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>
			<!-- /.content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<?= Alert::widget() ?>
					<?= $content ?>
				</div><!-- /.container-fluid -->
			</section>
			<!-- /.content -->
		</div>

		<!-- Footer -->
		<footer class="main-footer">
			<strong>&copy; <?= Yii::$app->name.' '.date('Y') ?></strong> <?= Yii::powered() ?>
			<div class="float-right d-sm-inline-block">
				<b>Version</b> - dev
			</div>
		</footer>

	</div>
	<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>