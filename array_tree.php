<?php

/**
 * 构建层级（树状）数组
 * @param array $array 要进行处理的一维数组，经过该函数处理后，该数组自动转为树状数组
 * @param string $pid 父级ID的字段名
 * @return array|bool
 */
function array_tree(&$array,$pid = 'pid') {
  // 子元素计数器
  function array_children_count($array,$pid) {
    $counter = array();
    foreach($array as $item) {
      $count = isset($counter[$item[$pid]]) ? $counter[$item[$pid]] : 0;
      $count  ++;
      $counter[$item[$pid]] = $count;
    }
    return $counter;
  }
  // 把元素插入到对应的父元素children字段
  function array_child_append($parent,$pid,$child) {
    foreach($parent as &$item) {
      if($item['id'] == $pid) {
        if(!isset($item['children']))
          $item['children'] = array();
        $item['children'][] = $child;
      }
    }
    return $parent;
  }

  // 开始程序
  $counter = array_children_count($array,$pid);
  // 如果顶级元素为0个，那么直接返回false
  if($counter[0] == 0) 
    return false;
  // 过滤原始数组，把其键名和id字段等同（保险起见，一定要操作这一步）
  foreach($array as $i => $item) {
    unset($array[$i]);
    $array[$item['id']] = $item;
  }
  // 准备顶级元素
  $tree = array();
  // 位移
  while(isset($counter[0]) && $counter[0] > 0) { // 如果顶级栏目的子元素计数器仍然大于0，那么仍然往下执行循环
    $temp = array_shift($array);
    if(isset($counter[$temp['id']]) && $counter[$temp['id']] > 0) { // 如果数组的第一个元素的子元素个数大于0，那么把该元素放置到数组的末端
      array_push($array,$temp);
    }
    else { // 相反，如果该数组的第一个元素没有子元素，那么把该元素移动到其父元素的children字段中，同时，该元素从原数组中被删除
      if($temp[$pid] == 0)
        $tree[] = $temp;
      else
        $array = array_child_append($array,$temp[$pid],$temp);
    }
    $counter = array_children_count($array,$pid);
  }

  $array = $tree;
  return $tree;
}
