<?php

class Seo_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
  public function __construct($application)
  {
    parent::__construct($application);
    $this->initViewHelperPath();
    Zend_Controller_Front::getInstance()->registerPlugin(new Seo_Controller_Plugin_Core());
  }

}
