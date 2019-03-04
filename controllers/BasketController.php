<?php 

namespace app\modules\basket\controllers;
use Yii;
use yii\web\Controller;
use app\models\GoodsModel;
use app\modules\basket\components\SimplePoint;

class BasketController extends Controller 
{
	public function actionIndex()
	{
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
		
		return $this->render('index',[
			'goods'=>$goods, 
			'amountCount'=>$i,
			'amountPrice'=>$amountPrice
		]);
	}
	public function actionAddInBasket()
	{
		$id=(int)Yii::$app->request->post('id');		
		Yii::$app->session->open();
		if($_SESSION['basket'])
		{
			foreach($_SESSION['basket'] as $good)
			{
				if($good['id'] == $id) return json_encode(['error'=>true, 'message'=>'Товар уже добавлен в корзину']);
			}
		}		
		$_SESSION['basket'][]=[
			'id'=>$id, 
			'count'=>1, 
			'img'=>$img
		];
		$good=GoodsModel::find()->where(['id'=>$id])->one();
		$simplePoint=SimplePoint::widget([
			'img'=>$good->img,
			'name'=>$good->name,
			'id'=>$good->id,
			'price'=>$good->price,
		]);		
		return json_encode([
			'error'=>false, 
			'message'=>'', 
			'point'=>$simplePoint,
			'price'=>$good->price,
		]);
	}
	public function actionLeftCountBasket()
	{
		$id=(int)Yii::$app->request->post('id');
		Yii::$app->session->open();
		if($_SESSION['basket'])
		{
			foreach($_SESSION['basket'] as &$good)
			{
				if($good['id'] == $id)
				{
					if(($good['count']-1) < 1 ) break;
					$good['count']-=1;
					break;
				}
			}
		}
	}
	public function actionRightCountBasket()
	{
		$id=(int)Yii::$app->request->post('id');
		Yii::$app->session->open();
		if($_SESSION['basket'])
		{
			foreach($_SESSION['basket'] as &$good)
			{
				if($good['id'] == $id)
				{					
					$good['count']+=1;
					break;
				}
			}
		}
	}
	public function actionDeleteGood()
	{
		$id=(int)Yii::$app->request->post('id');
		Yii::$app->session->open();
		if($_SESSION['basket'])
		{
			$basket=&$_SESSION['basket'];
			$count=count($basket);
			for($i=0; $i<$count;$i++)
			{
				if($basket[$i]['id']==$id)
				{
					unset($basket[$i]);
					break;
				}
			}
			$basket=array_values($basket);
		}
	}
}