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

<!-- <body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed"> -->

<body class="hold-transition layout-top-nav">
	<?php $this->beginBody() ?>

	<!-- Wrapper -->
	<div class="wrapper">

		<nav class="main-header navbar navbar-expand-md navbar-light navbar-white ">
			<div class="container-xl">
				<a href=<?= Url::to(['/site/index']) ?> class="navbar-brand">
					<span class="brand-text font-weight-bold"><?= Yii::$app->name ?></span>
				</a>

				<button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse order-3" id="navbarCollapse">
					<!-- Left navbar links -->
					<ul class="navbar-nav">
						<li class="nav-item">
							<a href=<?= Url::to(['/site/index']) ?> class="nav-link">Home</a>
						</li>
					</ul>
				</div>

				<!-- Right navbar links -->
				<ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
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
			</div>
		</nav>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-xl">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0 text-dark"><?= $this->title ?></h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
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
				<div class="container-xl">
					<?= Alert::widget() ?>
					<?= $content ?>
				</div><!-- /.container-fluid -->
			</section>
			<!-- /.content -->
		</div>

		<!-- Footer -->
		<footer class="main-footer">
			<strong>&copy; <?= Yii::$app->name . ' ' . date('Y') ?></strong> <?= Yii::powered() ?>
			<div class="float-right d-none d-sm-inline">
				<b>Version</b> - dev
			</div>
		</footer>

	</div>
	<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>