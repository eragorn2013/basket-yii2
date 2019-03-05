<?php 

namespace app\modules\basket\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use app\models\GoodsModel;
use app\models\OrdersModel;
use app\models\ProductsModel;
use app\modules\basket\components\SimplePoint;

class BasketController extends Controller 
{
	public function actionIndex($message=null)
	{
		$orders=new OrdersModel;		
		$basket=Yii::$app->session->get('basket');
		$goods=[];
		$amount=0;
		$amountPrice=0;
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
		if($orders->load(Yii::$app->request->post()) && $orders->validate())
		{
			$orders->amount=$amountPrice;
			$orders->save();
			$idOrder=$orders->id;			
			foreach($goods as $good)
			{
				$products=new ProductsModel();
				$products->name=$good['good']->name;
				$products->price=$good['good']->price;
				$products->count=$good['count'];
				$products->amount=$good['price'];
				$products->good_id=$good['good']->id;
				$products->order_id=$idOrder;
				$products->save();
			}			
			Yii::$app->session->remove('basket');
			$this->redirect([Url::toRoute(['/basket', 'message'=>'true'])]);
		}		
		return $this->render('index',[
			'goods'=>$goods, 
			'amountCount'=>$i,
			'amountPrice'=>$amountPrice,
			'orders'=>$orders,
			'message'=>$message
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
	public function actionDropBasket()
	{
		Yii::$app->session->remove('basket');
		$this->redirect([Url::toRoute(['/basket'])]);
	}
}