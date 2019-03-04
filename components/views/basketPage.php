<?php 
	use yii\helpers\Html;
	use yii\helpers\Url;
	$this->registerCssFile('@css-basket/basketPage.css');	
?>
<?= Html::a($name, Url::toRoute('/basket'), ['id'=>'basket-page']); ?>