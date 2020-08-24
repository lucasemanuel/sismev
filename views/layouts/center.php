<?php

use app\assets\AdminLteAsset;
use yii\bootstrap4\Html;

AdminLteAsset::register($this);

$this->registerCss(
	<<< CSS
		.lockscreen-wrapper {
			max-width: 600px;
		}
	CSS
)
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php $this->registerCsrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body class="hold-transition lockscreen">
	<?php $this->beginBody() ?>
	
	<!-- Automatic element centering -->
	<div class="lockscreen-wrapper">
		<div class="lockscreen-logo">
			<a href=<?= Yii::$app->getHomeUrl() ?>><b>SISMEC</b></a>
		</div>
		<?= $content ?>
	</div>
	<!-- /.center -->

	<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>