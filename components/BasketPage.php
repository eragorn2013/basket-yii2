<?php 

namespace app\modules\basket\components;
use yii\base\Widget;
use app\models\GoodsModel;
use Yii;

class BasketPage extends Widget
{
	public $name;	
	public function run()
	{		
		return $this->render('basketPage', [
			'name'=>$this->name,			
		]);
	}
}