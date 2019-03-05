$(document).ready(function(){	
	$('body').on('click', '#basket-yii2-page .left-count', function(){
		var num=Number($(this).next('#basket-yii2-page .count-good-basket').text());
		if((num-1) < 1) return false;
		$(this).next('#basket-yii2-page .count-good-basket').text(num-1);		
		var price=$(this)
			.parent('#basket-yii2-page .count')
			.next('#basket-yii2-page .price')
			.children('#basket-yii2-page .price-good-basket');
		var currentSum=Number(price.text());
		var currentPrice=Number(price.attr('data-price'));		
		price.text(currentSum-currentPrice);
		$('#basket-yii2-page #amountPrice').text(Number($('#basket-yii2-page #amountPrice').text())-currentPrice);

		var id=$(this).attr('data-id');
		$.post('/left-count-basket', {'id':id}, function(){});
		return false;
	});
	$('body').on('click', '#basket-yii2-page .right-count', function(){
		var num=Number($(this).prev('#basket-yii2-page .count-good-basket').text());
		$(this).prev('#basket-yii2-page .count-good-basket').text(num+1);
		var price=$(this)
			.parent('#basket-yii2-page .count')
			.next('#basket-yii2-page .price')
			.children('#basket-yii2-page .price-good-basket');
		var currentSum=Number(price.text());
		var currentPrice=Number(price.attr('data-price'));		
		price.text(currentSum+currentPrice);
		$('#basket-yii2-page #amountPrice').text(Number($('#basket-yii2-page #amountPrice').text())+currentPrice);

		var id=$(this).attr('data-id');
		$.post('/right-count-basket', {'id':id}, function(){});
		return false;
	});
	$('body').on('click', '#basket-yii2-page .delete-good', function(){
		var id=$(this).attr('data-id');		
		var price=Number($(this)
			.parent('#basket-yii2-page .delete')
			.prev('#basket-yii2-page .price')
			.children('#basket-yii2-page .price-good-basket')
			.text());		
		$('#basket-yii2-page #amountPrice').text(Number($('#basket-yii2-page #amountPrice').text())-price);
		$(this)
			.parent('#basket-yii2-page .delete')
			.parent('#basket-yii2-page .edit')
			.parent('#basket-yii2-page .point')
			.remove();
		var count=Number($('#basket-yii2-page #count-good-basket').text());
		$('#basket-yii2-page #count-good-basket').text(count-1);		
		$.post('/delete-good', {'id':id}, function(){});
	});
	$("#ordersmodel-phone").mask("+7(000)000-00-00", {
	    placeholder: "Телефон",
	    clearIfNotMatch: true
  	});
});