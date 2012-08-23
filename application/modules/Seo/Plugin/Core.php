<?php

class Seo_Plugin_Core extends Core_Plugin_Abstract
{
  public function onRenderLayoutDefault($event)
  {
    extract(Zend_Controller_Front::getInstance()->getRequest()->getParams());
    $view = $event->getPayload();
    if (!($view instanceof Zend_View)) {
      return;
    }

    if (Engine_Api::_()->core()->hasSubject() &&
      ($subject = Engine_Api::_()->core()->getSubject())) {
      $page = Engine_Api::_()->getItem('seo_page', $subject->getGuid());
      if (!$page) {
        return;
      }

      if ($page->title) {
        $view->headTitle()->set($page->title);
        $view->headTitle()->setLocked();
      }

      if ($page->description && $page->tags) {
        $view->headMeta()->setName('description', $page->description)
          ->setName('keywords', $page->tags)
          ->setLocked();
      }
    } else if ($controller == 'pages' && $module == 'core') {
      // Have to un inflect
      if( is_string($action) ) {
        $actionNormal = strtolower(preg_replace('/([A-Z])/', '-\1', $action));
        // @todo This may be temporary
        $actionNormal = str_replace('-', '_', $actionNormal);
      }
      // Get page object
      $pageTable = Engine_Api::_()->getDbtable('pages', 'core');
      $pageSelect = $pageTable->select();

      if( is_numeric($actionNormal) ) {
        $pageSelect->where('page_id = ?', $actionNormal);
      } else {
        $pageSelect
          ->orWhere('name = ?', str_replace('-', '_', $actionNormal))
          ->orWhere('url = ?', str_replace('_', '-', $actionNormal));
      }

      $pageObject = $pageTable->fetchRow($pageSelect);

      if (!$pageObject) {
        return;
      }
      $page = Engine_Api::_()->getItem('seo_page', $pageObject->getGuid());
      $view->headTitle()->set($page->title);
      $view->headTitle()->setLocked();

      $view->headMeta()->setName('description', $page->description)
        ->setName('keywords', $page->tags)
        ->setLocked();
    }
  }

  public function onItemDeleteBefore($event)
  {
    $item = $event->getPayload();

    if ($item instanceof Core_Model_Item_Abstract) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->delete('engine4_seo_pages', array(
        'page_id = ?' => $item->getGuid()
      ));
    }
  }
}
