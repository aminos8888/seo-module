<?php

class Seo_Filter_UrlEncode implements Zend_Filter_Interface
{
  public function filter($value)
  {
    return urlencode($value);
  }
}
