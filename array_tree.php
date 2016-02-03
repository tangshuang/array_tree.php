<?php

function array_tree(&$array,$pid = 'pid',$sort = false,$sort_type = 'desc') {
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
  // 获取最高级别的元素
  array_sort($tree,$sort,$sort_type);
  $array = $tree;
  return $tree;
}

// 排序
function array_sort(&$array,$field = false,$type = 'desc') { // 默认为数值越大越靠前
  if($field == false)
    return $array;
  $key_value = $new_array = array();
  foreach($array as $k => $v) {
    $key_value[$k] = $v[$field];
  }
  if($type == 'asc') {
    asort($key_value);
  }
  else {
    arsort($key_value);
  }
  reset($key_value);
  foreach($key_value as $k => $v) {
    $new_array[$k] = $array[$k];
    // 如果有children
    if(isset($new_array[$k]['children'])) {
      $new_array[$k]['children'] = array_sort($new_array[$k]['children']);
    }
  }
  $new_array = array_values($new_array);
  $array = $new_array;
  return $new_array;
}
