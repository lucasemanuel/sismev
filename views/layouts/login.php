<?php

use app\assets\AdminLteAsset;
use yii\bootstrap4\Html;

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

<body class="hold-transition login-page">
	<?php $this->beginBody() ?>
	<div class="login-box">
		<div class="login-logo">
			<a href="#"><b><?= Yii::$app->name ?></b></a>
		</div>
		<div class="card">
			<div class="card-body login-card-body">
				<?= $content ?>
				<hr>
				<?= Html::a(Yii::t('app', 'Create an Account'), ['signup/index']); ?>
			</div>
			<!-- /.login-card-body -->
		</div>
	</div>
	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>