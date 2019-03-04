<?php 
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\web\View;
?>
<div class='point'>
	<div class='info'>
		<div class='img'><?= Html::img($img, ['alt'=>$name]); ?></div>
		<div class='name'><?= $name ?></div>
	</div>
	<div class='edit'>
		<div class='count'>
			<div data-id='<?= $id ?>' class='arrow left-count'><?= Html::img('@img-basket/left.png', ['alt'=>'Уменьшить']); ?></div>
			<span class='count-good-basket'>1</span>
			<div data-id='<?= $id ?>' class='arrow right-count'><?= Html::img('@img-basket/right.png', ['alt'=>'Увеличить']); ?></div>
		</div>
		<div class='price'>
			<span data-price='<?= $price ?>' class='price-good-basket'><?= $price ?></span> руб.
		</div>
		<div class='delete'>
			<?= Html::img('@img-basket/remove.png', ['alt'=>'Удалить товар из корзины', 'class'=>'delete-good', 'data-id'=>$id]);?>
		</div>
	</div>
</div>