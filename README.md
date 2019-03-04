# Корзина для интернет-каталога (модуль yii2)

## Описание
Модуль корзины для интернет-магазинов и интернет-каталогов на yii2 с отправкой заказа по почте и записью в базу данных MySQL. Используется три виджета:

- **position: fixed виджет:** Это корзина для предварительного просмотра добавленных товаров. Отображается иконкой с правой верхней стороны экрана. Фиксированное позиционирование. При нажатии на иконку там же справа выезжает содержимое корзины (фото, название, цена, возможность изменить количество, возможность удалить конкретный товар, кнопка "Оформить", которая ведет на отдельную страницу с корзиной, на которой можно отправить заказ). Данное окно адаптировано под мобильные устройства. Если содержимое окна выше высоты экрана, виджет прокручивается скроллом.

- **Кнопка-виджет "В корзину"**: Эта кнопка напрямую взаимодействует с position: fixed виджетом. Создается для каждого товара. При нажатии на нее, в корзину добавляется конкретный товар. Виджету в качестве параметра передается идентификатор товара и пользовательский класс (для css)

- **Кнопка-виджет "Перейти в корзину":** это ссылка, которая веден на основную страницу корзины, где можно отправить заказ. 

## Предварительные настройки проекта

- Необходимо избавиться от web в uri. Для этого создаем файл .htaccess в корне сайта и добавляем в него следующий код:
```
Options +FollowSymLinks
IndexIgnore */*
RewriteEngine on

RewriteCond %{REQUEST_URI} ^/.*    
RewriteRule ^(.*)$ web/$1 [L]

RewriteCond %{REQUEST_URI} !^/web    
RewriteCond %{REQUEST_FILENAME} !-f [OR]
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^.*$ web/index.php
```

- Создаем файл .htaccess в папке /web и добавляем в него следующий код:
```
RewriteEngine On RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . index.php
RewriteCond %{HTTP_HOST} ^www.technology-21.ru$ [NC]
RewriteRule ^(.*)$ http://technology-21.ru/$1 [R=301,L] 
Options -Indexes 
```

- Подулючитесь к базе данных в файле /config/db.php

- В конфигурации приложения (/config/web.php) необходимо раскомментировать urlManager:
```php
'urlManager' => [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [                                          
    ],
],
```

## Установка

- Необходимо в папку modules в корне проекта (если ее нет - создайте), поместить папку basket. В папку basket установить данный репозиторий. (/modules/basket/тут_файлы_репозитория)
- В конфигурации приложения (/config/web.php) подключить загруженный модуль добавив в массив $config следующий код:
```php
'modules'=>[
    'basket'=>[
        'class'=>'app\modules\basket\Basket',
    ]
]
```
- В конфигурации приложения (/config/web.php) в массив $config добавить следующий код:
```php
'bootstrap' => ['app\modules\basket\bootstrap\Bootstrap'],
```
скорее всего 'bootstrap' там уже есть в таком виде:
```php
'bootstrap' => ['log'],
```
Поэтому этот путь 'app\modules\basket\bootstrap\Bootstrap' необходимо добавить через запятую после 'log'

- В базе данных должна быть таблица для товаров под названием "goods" со следующими обязательными полями: id INT, name TEXT, price TEXT, img TEXT(Это главное фото товара. Сюда должен добавляться полный путь до изображения. Например: /web/img/1.jpg или @web/img/1.jpg). Код для создания таблицы:
```sql
CREATE TABLE goods (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name TEXT,
	price TEXT,
	img TEXT
);
```
- в папке проект /models должен быть файл GoodsModel.php c классом GoodsModel:
```php
namespace app\models;
class GoodsModel extends \yii\db\ActiveRecord
{   
    public static function tableName()
    {
        return 'goods';
    }
}
```

## Использование
- Для использованиия виджета предварительного просмотра корзины в представлении необходимо подключить класс виджета:
```php
use app\modules\basket\components\BasketPreview;
```
После открывающего тега body добавить виджет:
```php
BasketPreview::widget(); //Виджет предарительного просмотра корзины с фиксированный позиционированием в верхнем правом углу экрана
```
- Можно добавить виджет, который формирует ссылку на основную страницу с корзиной с которой отправляется заказ в любую часть представления. Например в header. Для этого подключаем класс виджета:
```php
use app\modules\basket\components\BasketPage;
```
и используем сам виджет:
```php
BasketPage::widget([
    'name'=>'Корзина', //текст ссылки           
]);
```

- Виджет кнопки, которая добавляет товар в корзину. Подключаем класс кнопки:
```php
use app\modules\basket\components\Button;
```
Создаем виджет кнопки:
```php
Button::widget([
	'id'=>$good->id,      //идентификатор товара 
	'name'=>'В корзину',  //название кнопки                                
	'cl'=>'in-basket',    //пользовательский класс (для стилей) *необязательно
]);                   
                           
```






 


