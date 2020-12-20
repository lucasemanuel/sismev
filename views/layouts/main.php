<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AdminLteAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
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

<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed">
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
						<div class="dropdown-divider"></div>
						<a href=<?= Url::to(['/employee/profile']) ?> class="dropdown-item">
							<i class="fas fa-user mr-2"></i> <?= Yii::t('app', 'Profile') ?>
						</a>
						<div class="dropdown-divider"></div>
						<a href=<?= Url::to(['site/logout']) ?> class="dropdown-item" data-method="post">
							<i class="fas fa-sign-out-alt mr-2"></i><?= Yii::t('app', 'Logout') ?>
						</a>
					</div>
				</li>
			</ul>
		</nav>

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<a href=<?= Url::to(['/site/index']) ?> class="brand-link">
				<p class="brand-text font-weight-bold text-center" style="margin: auto;"><?= Yii::$app->name ?></p>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
						<!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
						<li class="nav-header text-uppercase"><?= Yii::t('app', 'Organization') ?></li>
						<li class="nav-item">
							<a href="<?= Url::to(['/company']) ?>" class="nav-link">
								<i class="nav-icon fas fa-building"></i>
								<p><?= Yii::t('app', 'Company') ?></p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= Url::to(['/employee']) ?>" class="nav-link">
								<i class="nav-icon fas fa-users"></i>
								<p><?= Yii::t('app', 'Employees') ?></p>
							</a>
						</li>
						<li class="nav-header text-uppercase"><?= Yii::t('app', 'Product') ?></li>
						<li class="nav-item">
							<a href="<?= Url::to(['/category']) ?>" class="nav-link">
								<i class="nav-icon fas fa-tag"></i>
								<p><?= Yii::t('app', 'Categories') ?></p>
							</a>
						</li>
						<li class="nav-item">
						<a href="<?= Url::to(['/variation']) ?>" class="nav-link">
							<i class="nav-icon fas fa-tags"></i>
							<p><?= Yii::t('app', 'Variations') ?></p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= Url::to(['/product', 'active' => 0]) ?>" class="nav-link">
								<i class="nav-icon fas fa-box"></i>
								<p><?= Yii::t('app', 'Products') ?></p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= Url::to(['/operation']) ?>" class="nav-link">
								<i class="nav-icon fas fa-exchange-alt"></i>
								<p><?= Yii::t('app', 'Operations') ?></p>
							</a>
						</li>
						<li class="nav-header text-uppercase"><?= Yii::t('app', 'Finance') ?></li>
						<li class="nav-item">
							<a href="<?= Url::to(['/expense']) ?>" class="nav-link">
								<i class="nav-icon fas fa-file-invoice-dollar"></i>
								<p><?= Yii::t('app', 'Expenses') ?></p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= Url::to(['/payment-method']) ?>" class="nav-link">
								<i class="nav-icon far fa-credit-card"></i>
								<p><?= Yii::t('app', 'Payment Methods') ?></p>
							</a>
						</li>
						<li class="nav-header text-uppercase"><?= Yii::t('app', 'Sell') ?></li>
						<li class="nav-item">
							<a href="<?= Url::to(['/pos']) ?>" class="nav-link">
								<i class="nav-icon fas fa-shopping-cart"></i>
								<p><?= Yii::t('app', 'Point of Sale') ?></p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= Url::to(['/order']) ?>" class="nav-link">
								<i class="nav-icon fas fa-clipboard-list"></i>
								<p><?= Yii::t('app', 'Orders') ?></p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= Url::to(['/sale']) ?>" class="nav-link">
								<i class="nav-icon fas fa-hand-holding-usd"></i>
								<p><?= Yii::t('app', 'Sales') ?></p>
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
			<strong>&copy; <?= Yii::$app->name . ' ' . date('Y') ?></strong> <?= Yii::powered() ?>
			<div class="float-right d-sm-inline-block">
				<b><?= Yii::t('app', 'Version') ?></b> <?= Yii::$app->params['version'] ?>
			</div>
		</footer>

	</div>
	<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>