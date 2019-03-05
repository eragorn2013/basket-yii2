<?php 

namespace app\modules\basket\components;
use yii\base\Widget;
use Yii;

class Button extends Widget
{
	public $id;
	public $name;
	public $background;
	public $color;
	public $nameAdded;
	public $backgroundAdded;
	public $colorAdded;
	public $cl;	
	public function run()
	{
		$name=$this->name;
		$background=$this->background;
		$color=$this->color;
		$basket=Yii::$app->session->get('basket');		
		if($basket)
		{
			foreach($basket as $good)
			{
				if($good['id']==(int)$this->id)
				{
					$name=$this->nameAdded;
					$background=$this->backgroundAdded;
					$color=$this->colorAdded;
					break;
				}
			}
		}		
		return $this->render('button', [
			'id'=>(int)$this->id,
			'name'=>$name,
			'nameAdded'=>$this->nameAdded,
			'background'=>$background,
			'color'=>$color,
			'backgroundAdded'=>$this->backgroundAdded,
			'colorAdded'=>$this->colorAdded,
			'class'=>$this->cl,			
		]);
	}
}