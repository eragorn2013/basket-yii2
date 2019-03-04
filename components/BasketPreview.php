<?php 

namespace app\modules\basket\components;
use yii\base\Widget;
use app\models\GoodsModel;
use Yii;

class BasketPreview extends Widget
{
	public function run()
	{
		if(Yii::$app->request->pathInfo == 'basket') return false;
		$basket=Yii::$app->session->get('basket');
		$goods=[];
		$amount=0;
		$i=0;
		if($basket)
		{			
			foreach($basket as $good)
			{
				$goods[$i]['good']=GoodsModel::find()->where(['id'=>$good['id']])->one();
				$goods[$i]['count']=$good['count'];	
				$goods[$i]['price']=$good['count']*$goods[$i]['good']->price;
				$amountPrice+=$goods[$i]['price'];	
				$i++;		
			}
		}
		return $this->render('basketPreview', [
			'goods'=>$goods, 
			'amountCount'=>$i,
			'amountPrice'=>$amountPrice
		]);
	}
}