<?php

class Seo_IndexController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
    if (!($guid = $this->_getParam('guid')) || !($resource = Engine_Api::_()->getItemByGuid($guid))) {
      return $this->_helper->viewRenderer()->setNoRender();
    }
    $router = Zend_Controller_Front::getInstance()->getRouter();
    $req = new Zend_Controller_Request_Http();
    $req->setPathInfo($resource->getHref());
    $req = $router->route($req);
    $this->_forward(
      $req->getActionName(),
      $req->getControllerName(),
      $req->getModuleName(),
      $req->getParams());
  }
}
