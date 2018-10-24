<?php

function tplMenu($category,$str)
 {   
    if($category['parent'] == 0){
       $menu = '<option value="'.$category['id'].'">'.$category['title'].'</option>';
    }else{   
       $menu = '<option value="'.$category['id'].'">'.$str.' '.$category['title'].'</option>';
    }
    
	if(isset($category['childs'])){
		$i = 1;
		for($j = 0; $j < $i; $j++){
			$str .= '→';
		}		  
		$i++;
		
		$menu .= showCat($category['childs'], $str);
	}
    return $menu;
 }

/**
* Рекурсивно считываем наш шаблон
**/
function showCat($data, $str){
	$string = '';
	$str = $str;
	foreach($data as $item){
		$string .= tplMenu($item, $str);
	}
	return $string;
}

//Получаем HTML разметку
$cat_menu = showCat($tree, '');

//Выводим на экран
echo '<select><option value="0">Выбери '. $cat_menu .'</select>';
?>