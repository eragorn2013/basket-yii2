<?php 
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\web\View;		
	$this->registerCssFile('@css-basket/basketPreview.css');
	$this->registerJsFile('@js-basket/settings-preview.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<section id='basket-yii2-preview'>	
		<div class='content'>
			<div class='item basket'>
				<?= Html::a('', Url::toRoute('/basket'), ['id'=>'basket-yii2-open']); ?>
				<span id='count-good-basket'><?= $amountCount ?></span>
			</div>
			<div class='item list'>				
				<?php if($goods): ?>
					<?php foreach($goods as $good): ?>
					<div class='point'>
						<div class='info'>
							<div class='img'><?= Html::img($good['good']->img, ['alt'=>$good['good']->name]); ?></div>
							<div class='name'><?= $good['good']->name ?></div>
						</div>
						<div class='edit'>
							<div class='count'>
								<div data-id='<?= $good['good']->id ?>' class='arrow left-count'><?= Html::img('@img-basket/left.png', ['alt'=>'Уменьшить']); ?></div>
								<span class='count-good-basket'><?= $good['count'] ?></span>
								<div data-id='<?= $good['good']->id ?>' class='arrow right-count'><?= Html::img('@img-basket/right.png', ['alt'=>'Увеличить']); ?></div>
							</div>
							<div class='price'>
								<span data-price='<?= $good["good"]->price ?>' class='price-good-basket'><?= $good['price'] ?></span> руб.
							</div>
							<div class='delete'>
								<?= Html::img('@img-basket/remove.png', ['alt'=>'Удалить товар из корзины', 'class'=>'delete-good', 'data-id'=>$good['good']->id]);?>
							</div>
						</div>
					</div>
					<?php endforeach; ?>					
				<?php else: ?>
					<h4>Корзина пуста</h4>
				<?php endif; ?>
				<div class='amount'>
						<div class='sum'>
							Итого: <span id='amountPrice'>
								<?php if($amountPrice): ?>
									<?= $amountPrice; ?>
								<?php else: ?>
									0
								<?php endif; ?>
							</span> руб.
						</div>
						<div class='call-to-action'>
							<a id='call-basket' href="/basket">Оформить</a>
						</div>
					</div>	

			</div>
		</div>	
</section>

