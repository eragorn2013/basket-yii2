<?php

namespace app\modules\basket\bootstrap;

use yii\base\BootstrapInterface;
use Yii;


class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
    	/*Маршруты модуля*/
        Yii::$app->getUrlManager()->addRules([
	        '/basket'=>'basket/basket/index',
	        '/add-in-basket'=>'basket/basket/add-in-basket',
	        '/left-count-basket'=>'basket/basket/left-count-basket',
	        '/right-count-basket'=>'basket/basket/right-count-basket',
	        '/delete-good'=>'basket/basket/delete-good',
	    ], false);

	    /*Алиасы модуля*/
	    Yii::setAlias("@img-basket", '/modules/basket/web/img');
	    Yii::setAlias("@css-basket", '/modules/basket/web/css');
	    Yii::setAlias("@js-basket", '/modules/basket/web/js');
	    Yii::setAlias("@simples-basket", './modules/basket/views/simples');
    }
}