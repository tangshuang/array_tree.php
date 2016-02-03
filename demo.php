<?php

require 'array_tree.php';


/*
 * 使用演示，要进行处理的数组必须为二维数组，顶层元素的键名不允许有[0]，第二层元素必须有[id]键
 */

// 演示1，按从大到小规则排序的菜单
$demo1 = array(
  1 => array('id' => 1,'title' => 'title1','pid' => 0),
  2 => array('id' => 2,'title' => 'title2','pid' => 1),
  3 => array('id' => 3,'title' => 'title3','pid' => 1),
  4 => array('id' => 4,'title' => 'title4','pid' => 2),
  5 => array('id' => 5,'title' => 'title5','pid' => 2),
  6 => array('id' => 6,'title' => 'title6','pid' => 0)
);
//$demo1 = array_tree($demo1);
//print_r($demo1);

// 演示2，菜单排列不规律，父菜单在后面
$demo2 = array(
  1 => array('id' => 1,'title' => 'title1','parent_id' => 2),
  2 => array('id' => 2,'title' => 'title2','parent_id' => 0),
  3 => array('id' => 3,'title' => 'title3','parent_id' => 1),
  4 => array('id' => 4,'title' => 'title4','parent_id' => 2),
  5 => array('id' => 5,'title' => 'title5','parent_id' => 6),
  6 => array('id' => 6,'title' => 'title6','parent_id' => 0)
);
//$demo2 = array_tree($demo2,'parent_id');
//print_r($demo2);

// 演示3，含排序值，排序，默认排序是排序值越大越靠前，排序仅限于同级数组，顶层和第二层各自按自己的排序值进行排序
$demo3 = array(
  1 => array('id' => 1,'title' => 'title1','parent_id' => 2,'sort' => 0),
  2 => array('id' => 2,'title' => 'title2','parent_id' => 0,'sort' => 2),
  3 => array('id' => 3,'title' => 'title3','parent_id' => 1,'sort' => 0),
  4 => array('id' => 4,'title' => 'title4','parent_id' => 2,'sort' => 1),
  5 => array('id' => 5,'title' => 'title5','parent_id' => 6,'sort' => 0),
  6 => array('id' => 6,'title' => 'title6','parent_id' => 0,'sort' => 1)
);
$demo3 = array_tree($demo3,'parent_id','sort');
print_r($demo3);
