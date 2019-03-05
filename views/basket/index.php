<?php 
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\web\View;	
	use yii\widgets\ActiveForm;	
	$this->registerCssFile('@css-basket/basketPage.css');
	$this->registerJsFile('@js-basket/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
	$this->registerJsFile('@js-basket/settings-page.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<section id='basket-yii2-page'>
	<div class='container'>
		<h1>Корзина</h1>
		<?php if($message=='true'): ?>			
			<?= Html::a('Ваш заказ отправлен. Ожидайте звонка менеджера', Url::toRoute(['/basket']), ['id'=>'ok-order']); ?>
		<?php endif; ?>		
		<div class='content'>			
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
					<h3>Корзина пуста</h3>
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
				</div>
			</div>
			<div class='item form'>
				<?php $f=ActiveForm::begin(); ?>
					<?= Html::tag('p', 'Заполните форму и отправьте заказ') ?>
					<?= $f->field($orders, 'name')->textInput(['placeholder'=>'Имя'])->label(''); ?>
					<?= $f->field($orders, 'phone')->textInput(['placeholder'=>'Телефон'])->label(''); ?>
					<?= $f->field($orders, 'email')->textInput(['placeholder'=>'E-mail'])->label(''); ?>
					<?= $f->field($orders, 'comment')->textarea(['placeholder'=>'Комментарий'])->label(''); ?>
					<?= Html::submitButton('Отправить'); ?>
					<?php if($goods): ?>
						<?= Html::a('Очистить корзину', Url::toRoute('/drop-basket')); ?>
					<?php endif; ?>
				<?php ActiveForm::end(); ?>
			</div>
		</div>		
	</div>
</section>

