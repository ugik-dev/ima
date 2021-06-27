<?php

class DataStructure
{

  public static function unique_multidim_array($array, $key)
  {
    $temp_array = array();
    $i = 0;
    $key_array = array();

    foreach ($array as $val) {
      if (!empty($val[$key]) && !in_array($val[$key], $key_array)) {
        $key_array[$i] = $val[$key];
        $temp_array[$i] = $val;
      }
      $i++;
    }
    return $temp_array;
  }


  public static function to2DArray($data, $key, $idName = NULL)
  {
    $ret = [];
    $counter = 1;
    foreach ($data as $d) {
      if (!empty($idName)) $ret[] = [$key => $d, $idName => $counter++];
      else $ret[] = [$key => $d];
    }
    return $ret;
  }

  public static function getNewAndUpdates($new, $existing)
  {
    return [
      'new' => array_diff_key($new, $existing),
      'updates' => array_intersect_key($new, $existing),
      'removed' => array_diff_key($existing, $new),
    ];
  }

  public static function flatten($arr, $key = False)
  {
    $ret = [];
    foreach ($arr as $k => $a) {
      foreach ($a as $aa) {
        if ($key) {
          $ret[$k] = $aa;
        } else {
          $ret[] = $aa;
        }
      }
    }
    return $ret;
  }

  public static function transform($arr, $fields)
  {
    $ret = [];
    foreach ($arr as $k => $a) {
      $ret[$k] = $a;
      foreach ($fields as $sk => $tk) {
        $ret[$k][$tk] = $a[$sk];
        unset($ret[$k][$sk]);
      }
    }
    return $ret;
  }

  public static function merge($target, $source, $key, $fields)
  {
    $ret = [];
    foreach ($target as $tk => $tv) {
      if (isset($source[$tv[$key]])) {
        $src = $source[$tv[$key]];
        $ret[$tk] = $target[$tk];
        foreach ($fields as $fs => $ft) {
          $ret[$tk][$ft] = $src[$fs];
        }
      }
    }
    return $ret;
  }

  public static function count($arr, $val, $key)
  {
    $count = 0;
    foreach ($arr as $a) {
      if ($a[$key] == $val) {
        $count++;
      }
    }
    return $count;
  }

  public static function broadcast($arr, $vals, $keys, $assoc = TRUE)
  {
    for ($i = 0; $i < count($vals); $i++) {
      foreach ($arr as $k => $a) {
        $arr[$k][$keys[$i]] = $vals[$i];
      }
    }
    if (!$assoc) $arr = DataStructure::associativeToArray($arr);
    return $arr;
  }

  public static function associativeToArray($arr)
  {
    $ret = array();
    if ($arr == NULL) return $ret;
    foreach ($arr as $a) {
      $ret[] = $a;
    }
    return $ret;
  }

  public static function keyValue($arr, $key, $value = NULL)
  {
    $ret = array();
    if ($arr == NULL) return $ret;
    foreach ($arr as $a) {
      $ret[$a[$key]] = $value != NULL ? $a[$value] : $a;
    }
    return $ret;
  }

  // arr: [{a: 'gg', b: 'wp'}, {a: 'ee', b: 'tt'}]
  // key: a
  // output: ['gg', 'ee']
  public static function toOneDimension($arr, $key, $object = FALSE)
  {
    $ret = array();
    if ($arr == NULL) return $ret;
    foreach ($arr as $a) {
      if ($object) {
        $ret[$a[$key]] = $a[$key];
      } else {
        $ret[] = $a[$key];
      }
    }
    return $ret;
  }

  public static function slice($arr, $fields, $empty = FALSE)
  {
    $ret = array();
    if ($fields == NULL) return $ret;

    foreach ($fields as $f) {
      if ((isset($arr[$f]) || array_key_exists($f, $arr)) && (!$empty || !empty($arr[$f])))
        $ret[$f] = $arr[$f];
    }
    return $ret;
  }

  public static function slice2D($arr, $fields)
  {
    $ret = [];
    foreach ($arr as $k => $a) {
      $ret[$k] = DataStructure::slice($a, $fields);
    }
    return $ret;
  }

  public static function selfGrouping($arr, $parentForeign, $childName)
  {
    $ret = array();
    foreach ($arr as $a) {
      if ($a[$parentForeign] == null) {
        $ret[$a['id']] = $a;
        $ret[$a['id']][$childName] = array();
      }
    }

    foreach ($arr as $a) {
      if ($a[$parentForeign] != null) {
        $ret[$a[$parentForeign]][$childName][] = $a;
      }
    }

    return $ret;
  }

  public static function groupByRecursive2($arr, $columns, $childKeys, $parentFields, $childNames, $assoc = TRUE)
  {
    if (count($columns) == 0) {
      return DataStructure::slice2D($arr, $parentFields[0]);
    }
    $childName = $childNames[0];
    $ret = DataStructure::groupBy2($arr, array_shift($columns), array_shift($childKeys), array_shift($parentFields), array_shift($childNames));
    $ret = !$assoc ? DataStructure::associativeToArray($ret) : $ret;
    foreach ($ret as $k => $r) {
      $ret[$k][$childName] = DataStructure::groupByRecursive2(DataStructure::flatten($r[$childName], count($columns) == 0 || !$assoc), $columns, $childKeys, $parentFields, $childNames, $assoc);
    }
    return $ret;
  }

  // arr: [{a: 'gg', b: 'wp'}, {a: 'gg', b: 'tt'}, {a: 'yy', b: 'oo'}]
  // column: a
  // output: ['gg': [{a: 'gg', b: 'wp'}, {a: 'gg', b: 'tt'}], 'yy': [{a: 'yy', b: 'oo'}]]
  public static function groupBy2($arr, $column, $childKey, $parentField, $childName)
  {

    $ret = array();
    foreach ($arr as $a) {
      $groupKey = $a[$column];
      if (!isset($ret[$groupKey])) {
        $ret[$groupKey] = DataStructure::slice($a, $parentField);
        $ret[$groupKey][$childName] = [];
      }
      if ($a[$childKey] == null) continue;
      if (!isset($ret[$groupKey][$childName][$a[$childKey]])) {
        $ret[$groupKey][$childName][$a[$childKey]] = [];
      }
      $ret[$groupKey][$childName][$a[$childKey]][] = $a;
    }
    return $ret;
  }

  public static function groupByRecursive($arr, $columns, $childKey)
  {
    if (count($columns) == 0) return $arr;
    $ret = DataStructure::groupBy($arr, array_shift($columns), count($columns) == 0 ? $childKey : NULL);
    foreach ($ret as $k => $r) {
      $ret[$k] = DataStructure::groupByRecursive($r, $columns, $childKey);
    }
    return $ret;
  }

  // arr: [{a: 'gg', b: 'wp'}, {a: 'gg', b: 'tt'}, {a: 'yy', b: 'oo'}]
  // column: a
  // output: ['gg': [{a: 'gg', b: 'wp'}, {a: 'gg', b: 'tt'}], 'yy': [{a: 'yy', b: 'oo'}]]
  public static function groupBy($arr, $column, $childKey = NULL, $childCol = NULL)
  {
    $ret = array();
    foreach ($arr as $a) {
      $groupName = $a[$column];
      if (!isset($ret[$groupName])) {
        $ret[$groupName] = array();
      }
      if ($childKey != NULL) {
        $ret[$groupName][$a[$childKey]] = !empty($childCol) ? $a[$childCol] : $a;
      } else {
        $ret[$groupName][] = $a;
      }
    }
    return $ret;
  }

  public static function groupAndFlatten($arr, $parentKey, $childKey)
  {
    $ret = array();
    foreach ($arr as $a) {
      $key = $a[$parentKey];
      if (!isset($ret[$key])) {
        $ret[$key] = array();
      }
      $ret[$key][$a[$childKey]] = $a[$childKey];
    }
    return $ret;
  }

  public static function filter($arr, $cond)
  {
    $ret = [];
    foreach ($arr as $k => $a) {
      $satisfy = true;
      foreach ($cond as $field => $value) {
        if (!isset($a[$field]) || $a[$field] != $value) $satisfy = $satisfy && false;
      }
      if ($satisfy == true) $ret[$k] = $a;
    }
    return $ret;
  }

  // arr: [{a: '###', b: 'wp'}, {a: 'gg', b: '###'}, {a: 'yy', b: '###'}]
  // value: ###
  // output: [{a: 'gg'}, {b: 'tt'}, {a: 'yy''}]
  public static function deleteColumnWhere($arr = array(), $value)
  {
    $ret = array();
    foreach ($arr as $a) {
      $item = array();
      foreach ($a as $cname => $cvalue) {
        if ($cvalue != $value) {
          $item[$cname] = $cvalue;
        }
      }
      $ret[] = $item;
    }
    return $ret;
  }
}
