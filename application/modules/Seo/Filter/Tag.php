<?php

class Seo_Filter_Tag implements Zend_Filter_Interface
{
  public function filter($value)
  {
    $tmp = explode(',', $value);
    $tags = array();
    foreach ($tmp as $tag) {
      $tags[] = trim($tag);
    }
    return join(',', $tags);
  }
}
