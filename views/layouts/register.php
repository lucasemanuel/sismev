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

<body class="hold-transition register-page">
	<?php $this->beginBody() ?>
	<div class="register-box">
  		<div class="register-logo">
			<a href="#"><b><?= Yii::$app->name ?></b></a>
		</div>

		<div class="card">
    		<div class="card-body register-card-body">

				<?= $content ?>
				
				<hr>
				<?= Html::a(Yii::t('app', 'I already have a membership'), ['site/login']); ?>
			</div>
			<!-- /.register-card-body -->
		</div>
	</div>
	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>