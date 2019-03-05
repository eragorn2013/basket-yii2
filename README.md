# Корзина для интернет-каталога (модуль yii2)

Демонстрация корзины (видео): <https://youtu.be/gfjwLUCa1BY>

## Описание
Модуль корзины для интернет-магазинов и интернет-каталогов на yii2 с отправкой заказа по почте и записью в базу данных MySQL. Рекомендуется устанавливать на "голый" проект на yii2. Установка корзины подразумевает создание таблиц для товаров и заказов в БД, на которые ориентируется данный модуль (описание таблиц ниже в разделе "Установка"). Т.е. в дальнейшем, организуя, например, каталог товаров, необходимо использовать именно эти таблицы, либо переделывать исходный код модуля, подключая к нему свои уже готовые таблицы. 

Используется три виджета:

- **position: fixed виджет:** Это корзина для предварительного просмотра добавленных товаров. Отображается иконкой с правой верхней части экрана. Фиксированное позиционирование. При нажатии на иконку там же справа "выезжает" содержимое корзины (фото, название, цена, возможность изменить количество, возможность удалить конкретный товар, кнопка "Оформить", которая ведет на отдельную страницу с корзиной, на которой можно отправить заказ). Данное окно адаптировано под мобильные устройства. Если содержимое окна выше высоты экрана, виджет прокручивается скроллом.

- **Кнопка-виджет "В корзину"**: Эта кнопка напрямую взаимодействует с position: fixed виджетом. Создается для каждого товара. При нажатии на нее, в корзину добавляется конкретный товар. Виджету в качестве параметров передается идентификатор товара и другие настройки, описанные ниже

- **Кнопка-виджет "Перейти в корзину":** это ссылка, которая ведет на основную страницу корзины, где можно отредактировать содержимое корзины и отправить заказ, заполнив форму с данными пользователя. 

## Предварительные настройки проекта

- Необходимо настроить ЧПУ и избавиться от web в url. Для этого создаем файл .htaccess в корне сайта и добавляем в него следующий код:
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

- В конфигурации приложения (/config/web.php) необходимо раскомментировать urlManager:
```php
'urlManager' => [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [                                          
    ],
],
```
- В конфигурации приложения (/config/web.php) необходимо в раздел 'request' добавить код:
```php
'baseUrl'=>'',
```
- Подключитесь к базе данных в файле /config/db.php

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
Поэтому это пространство имен 'app\modules\basket\bootstrap\Bootstrap' необходимо добавить через запятую после 'log'

- В базе данных должна быть таблица для товаров под названием "goods" со следующими обязательными полями: id INT, name TEXT, price TEXT, img TEXT(Это главное фото товара. Сюда должен добавляться полный путь до изображения. Например: /web/img/1.jpg или @web/img/1.jpg). Код для создания таблицы:
```sql
CREATE TABLE goods (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name TEXT,
	price TEXT,
	img TEXT
);
```

- В базе данных должна быть таблица для заказов под названием "orders" со следующими обязательными полями: id INT, name TEXT, phone TEXT, email TEXT, comment TEXT, amount DOUBLE; Код для создания таблицы:
```sql
CREATE TABLE orders (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name TEXT,
    phone TEXT,
    email TEXT,
    comment TEXT,
    amount DOUBLE
);
```

- В базе данных должна быть таблица для списков заказанных товаров под названием 'products' со следующими обязательными полями: id INT, name TEXT, price DOUBLE, count INT, amount DOUBLE, good_id INT, order_id INT. Код для создания таблицы:
```sql
CREATE TABLE products (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name TEXT,
    price DOUBLE,
    count INT,
    amount DOUBLE,
    good_id INT,
    order_id INT
);
```

- в папке проекта /models должен быть файл GoodsModel.php c классом GoodsModel:
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

- в папке проекта /models должен быть файл OrdersModel.php c классом OrdersModel:
```php
namespace app\models;
class OrdersModel extends \yii\db\ActiveRecord
{    
    public static function tableName()
    {
        return 'orders';
    }   
    public function rules()
    {
        return [
            [['name', 'phone', 'email', 'comment'], 'string', 'message'=>'Разрешены только строковые значения'],
            [['name', 'phone', 'email'], 'required', 'message'=>'Поле не может быть пустым'],
            [['email'], 'email', 'message'=>'Введите корректный email'],
            ['phone', 'match', 'pattern' => '/\\+7\\([0-9]+\\)[0-9]{3}-[0-9]{2}-[0-9]{2}/']
        ];
    }   
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'phone' => 'Phone',
            'email' => 'Email',
            'comment' => 'Comment',
            'amount' => 'Amount',
        ];
    }
}
```

- в папке проекта /models должен быть файл ProductsModel.php c классом ProductsModel:
```php
namespace app\models;
class ProductsModel extends \yii\db\ActiveRecord
{    
    public static function tableName()
    {
        return 'products';
    }
    
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['price', 'amount'], 'number'],
            [['count', 'good_id', 'order_id'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'count' => 'Count',
            'amount' => 'Amount',
            'good_id' => 'Good ID',
            'order_id' => 'Order ID',
        ];
    }
}
```
Для ускорения процесса, все вышеописанные классы моделей рекомендуется генерировать через gii.

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
    'id'=>$good->id,                        //идентификатор товара 
    'name'=>'В корзину',                    //название кнопки
    'background'=>'#92c409',                //цвет фона кнопки 
    'color'=>'#fff',                        //цвет текста кнопки
    'nameAdded'=>'Добавлено',               //название кнопки, если товар добавлен
    'backgroundAdded'=>'#7daa00',           //цвет фона кнопки после добавления товара в корзину 
    'colorAdded'=>'#fff',                   //цвет текста кнопки после добавления товара в корзину 
    'cl'=>'in-basket',                      //пользовательский класс (для стилей) *необязательно
]);                                    
```






 


