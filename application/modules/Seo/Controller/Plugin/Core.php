<?php

class Seo_Controller_Plugin_Core extends Zend_Controller_Plugin_Abstract
{
  public function preDispatch(Zend_Controller_Request_Abstract $request)
  {
    $router = Zend_Controller_Front::getInstance()->getRouter();
    if ($router->getCurrentRouteName() != 'default') {
      return;
    }
    $url = trim($_SERVER['REQUEST_URI'], '/');
    $page = Engine_Api::_()->getItem('seo_page', $url);
    if (!$page) {
      return;
    }
    $request->setControllerName('index')
      ->setModuleName('seo')
      ->setActionName('index')
      ->setParam('guid', $page->page_id)
      ;
  }

  public function postDispatch(Zend_Controller_Request_Abstract $request)
  {
    if (Zend_Layout::getMvcInstance()->getLayout() != 'default') {
      return;
    }
    /**
     *  not everyone might want this
     */
    $body = $this->getResponse()->getBody();
    for ($i = 1; $i < 7; $i++) {
      $body = preg_replace("|<h$i|", "<h$i", $body);
    }
    $this->getResponse()->setBody($body);
  }
}
