$(document).ready(function(){
	var flag='hidden';
	$('#basket-yii2-preview #basket-yii2-open').on('click', function(){			
		if(flag=='hidden') 
		{
			$('#basket-yii2-preview').animate({'right': '-20px'}, 200);
			$('#basket-yii2-preview #basket-yii2-open').css('background-image', 'url("/modules/basket/web/img/close.png")');
			flag='visible';
		}
		else if(flag=='visible')
		{
			$('#basket-yii2-preview').animate({'right': '-290px'}, 200);
			$('#basket-yii2-preview #basket-yii2-open').css('background-image', 'url("/modules/basket/web/img/basket.png")');
			flag='hidden';
		}			
		return false;
	});

	$('.action-in-basket').on('click', function(){		
		var id=$(this).attr('data-id');
		$.post('/add-in-basket', {'id':id}, function(data){
			var d=JSON.parse(data);
			if(d.error) 
			{
				alert(d.message);
				return false;
			}
			$('#basket-yii2-preview h4').remove();
			$('#basket-yii2-preview .amount').before(d.point);
			var amountPrice=Number($('#basket-yii2-preview #amountPrice').text());
			$('#basket-yii2-preview #amountPrice').text(amountPrice+Number(d.price));
			var count=Number($('#basket-yii2-preview #count-good-basket').text());
			$('#basket-yii2-preview #count-good-basket').text(count+1);
		});		
	});
	$('body').on('click', '#basket-yii2-preview .left-count', function(){
		var num=Number($(this).next('#basket-yii2-preview .count-good-basket').text());
		if((num-1) < 1) return false;
		$(this).next('#basket-yii2-preview .count-good-basket').text(num-1);		
		var price=$(this)
			.parent('#basket-yii2-preview .count')
			.next('#basket-yii2-preview .price')
			.children('#basket-yii2-preview .price-good-basket');
		var currentSum=Number(price.text());
		var currentPrice=Number(price.attr('data-price'));		
		price.text(currentSum-currentPrice);
		$('#basket-yii2-preview #amountPrice').text(Number($('#basket-yii2-preview #amountPrice').text())-currentPrice);

		var id=$(this).attr('data-id');
		$.post('/left-count-basket', {'id':id}, function(){});
		return false;
	});
	$('body').on('click', '#basket-yii2-preview .right-count', function(){
		var num=Number($(this).prev('#basket-yii2-preview .count-good-basket').text());
		$(this).prev('#basket-yii2-preview .count-good-basket').text(num+1);
		var price=$(this)
			.parent('#basket-yii2-preview .count')
			.next('#basket-yii2-preview .price')
			.children('#basket-yii2-preview .price-good-basket');
		var currentSum=Number(price.text());
		var currentPrice=Number(price.attr('data-price'));		
		price.text(currentSum+currentPrice);
		$('#basket-yii2-preview #amountPrice').text(Number($('#basket-yii2-preview #amountPrice').text())+currentPrice);

		var id=$(this).attr('data-id');
		$.post('/right-count-basket', {'id':id}, function(){});
		return false;
	});
	$('body').on('click', '#basket-yii2-preview .delete-good', function(){
		var id=$(this).attr('data-id');		
		var price=Number($(this)
			.parent('#basket-yii2-preview .delete')
			.prev('#basket-yii2-preview .price')
			.children('#basket-yii2-preview .price-good-basket')
			.text());		
		$('#basket-yii2-preview #amountPrice').text(Number($('#basket-yii2-preview #amountPrice').text())-price);
		$(this)
			.parent('#basket-yii2-preview .delete')
			.parent('#basket-yii2-preview .edit')
			.parent('#basket-yii2-preview .point')
			.remove();
		var count=Number($('#basket-yii2-preview #count-good-basket').text());
		$('#basket-yii2-preview #count-good-basket').text(count-1);		
		$.post('/delete-good', {'id':id}, function(){});
	});
});