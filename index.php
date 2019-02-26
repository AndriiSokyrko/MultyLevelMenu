<?php
//Устанавливаем кодировку и вывод всех ошибок
header('Content-Type: text/html; charset=UTF-8');
error_reporting(E_ALL);
$categories=[
["id"=>1,  "title"=>'Автомобили', "parent"=>0],
["id"=>2,  "title"=>'Мотоциклы', "parent"=>0],
["id"=>3,  "title"=>'Мазда', "parent"=>1],
["id"=>4,  "title"=>'Хонда', "parent"=>1],
["id"=>5,  "title"=>'Кавасаки', "parent"=>2],
["id"=>6,  "title"=>'Харлей', "parent"=>2],
["id"=>7,  "title"=>'Мазда 3', "parent"=>3],
["id"=>8,  "title"=>'Мазда 6', "parent"=>3],
["id"=>9,  "title"=>'Седан', "parent"=>7],
["id"=>10, "title"=> 'Хечбэк', "parent"=>7],
["id"=>11, "title"=> 'Лодки', "parent"=>0],
["id"=>12, "title"=> 'Лифтбэк', "parent"=>8],
["id"=>13, "title"=> 'Кроссовер', "parent"=>8],
["id"=>14, "title"=> 'Белый', "parent"=>13],
["id"=>15, "title"=> 'Красный', "parent"=>13],
["id"=>16, "title"=> 'Черный', "parent"=>13],
["id"=>17, "title"=> 'Зеленый', "parent"=>13],
["id"=>18, "title"=> 'Мазда CX', "parent"=>3],
["id"=>19, "title"=> 'Мазда MX',"parent"=>3],
];
//Объектно-ориентированный стиль
//$mysqli = new mysqli('localhost', 'user', 'pass', 'db');

//Устанавливаем кодировку utf8
//$mysqli->query("SET NAMES 'utf8'");

/*
 * Это "официальный" объектно-ориентированный способ сделать это
 * однако $connect_error не работал вплоть до версий PHP 5.2.9 и 5.3.0.
 */
/*if ($mysqli->connect_error) {
    die('Ошибка подключения (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}*/

/*
 * Если нужно быть уверенным в совместимости с версиями до 5.2.9,
 * лучше использовать такой код
 */
/*if (mysqli_connect_error()) {
    die('Ошибка подключения (' . mysqli_connect_errno() . ') '
        . mysqli_connect_error());
}*/

//Получаем массив нашего меню из БД в виде массива
function getCat($mysqli){
    $sql = 'SELECT * FROM `categories`';
    $res = $mysqli->query($sql);

    //Создаем масив где ключ массива является ID меню
    $cat = array();
    while($row = $res->fetch_assoc()){
        $cat[$row['id']] = $row;
    }
    return $cat;
}

//Функция построения дерева из массива от Tommy Lacroix
function getTree($dataset) {
    $tree = array();

    foreach ($dataset as $id => &$node) {
        //Если нет вложений
        if (!$node['parent']){
            $tree[$id] = &$node;
        }else{
            //Если есть потомки то перебераем массив
            $dataset[$node['parent']]['childs'][$id] = &$node;
        }
    }
    return $tree;
}

//Получаем подготовленный массив с данными
//$cat  = getCat($mysqli);
$cat =$categories;
//Создаем древовидное меню
$tree = getTree($cat);

//Шаблон для вывода меню в виде дерева
function tplMenu($category){
    $menu = '<li>
		<a href="#" title="'. $category['title'] .'">'.
        $category['title'].'</a>';

    if(isset($category['childs'])){
        $menu .= '<ul>'. showCat($category['childs']) .'</ul>';
    }
    $menu .= '</li>';

    return $menu;
}

/**
 * Рекурсивно считываем наш шаблон
 **/
function showCat($data){
    $string = '';
    foreach($data as $item){
        $string .= tplMenu($item);
    }
    return $string;
}

//Получаем HTML разметку
$cat_menu = showCat($tree);

//Выводим на экран
echo '<ul>'. $cat_menu .'</ul>';


?>
