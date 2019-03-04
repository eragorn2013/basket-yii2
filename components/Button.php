<?php 

namespace app\modules\basket\components;
use yii\base\Widget;
use Yii;

class Button extends Widget
{
	public $id;
	public $name;
	public $cl;	
	public function run()
	{		
		return $this->render('button', [
			'id'=>$this->id,
			'name'=>$this->name,
			'class'=>$this->cl,			
		]);
	}
}