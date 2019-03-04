<?php 

namespace app\modules\basket\components;
use yii\base\Widget;
use Yii;

class SimplePoint extends Widget
{	
	public $img;
	public $name;
	public $id;
	public $price;
	public function run()
	{		
		return $this->render('simplePoint', [
			'img'=>$this->img,
			'name'=>$this->name,
			'id'=>$this->id,
			'price'=>$this->price
		]);
	}
}