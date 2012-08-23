<?php

class Seo_AdminManageController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('seo_admin_main', array(), 'seo_admin_main_manage');

    $items = array();
    foreach (Engine_Api::_()->getItemTypes() as $itemType) {
      $class = Engine_Api::_()->getItemClass($itemType);
      if (@class_exists($class)) {
        $reflector = new ReflectionMethod($class, 'getHref');
        if ($reflector->getDeclaringClass()->getName() == $class) {
          $items[$itemType] = ucfirst(Engine_Api::typeToShort($itemType, Engine_Api::_()->getItemModule($itemType))) . ' (' . $itemType . ')';
        }
      }
    }

    $this->view->formFilter = $formFilter = new Seo_Form_Admin_Manage_Filter();
    // Populate types
    foreach ($items as $k => $v) {
      $formFilter->type->addMultiOption($k, $v);
    }

    // Process form
    $values = array();
    if( $formFilter->isValid($this->_getAllParams()) ) {
      $values = $formFilter->getValues();
    }

    foreach( $values as $key => $value ) {
      if( null === $value ) {
        unset($values[$key]);
      }
    }

    
    $this->view->assign($values);

    if (isset($values['type'])) {
      try {
        $table = Engine_Api::_()->getItemTable($values['type']);
        $select = $table->select();
      } catch (Engine_Api_Exception $e) {
      }
    }

    $this->view->paginator = $paginator = Zend_Paginator::factory(isset($select) ? $select : array());
    $paginator->setItemCountPerPage(25);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));


    if (!isset($select)) {
      return;
    }

    // Set up select info
    $primary = array_shift($table->info('primary'));
    $values = array_merge(array(
      'order' => $primary,
      'order_direction' => 'DESC',
    ), $values);

    $select->order(( !empty($values['order']) ? ($values['order'] == 'id' ? $primary : (in_array($values['order'], $table->info('cols')) ? $values['order'] : $primary)) : $primary) . ' ' . ( !empty($values['order_direction']) ? $values['order_direction'] : 'DESC' ));

    if(in_array('title', $table->info('cols')) && !empty($values['title']) ) {
      $select->where('title LIKE ?', '%' . $values['title'] . '%');
    }
    
    // Filter out junk
    $valuesCopy = array_filter($values);
    // Reset enabled bit
    if( isset($values['enabled']) && $values['enabled'] == 0 ) {
      $valuesCopy['enabled'] = 0;
    }
  }

  public function editAction()
  {
    $guid = $this->_getParam('id');
    if (!$guid || !($resource = Engine_Api::_()->getItemByGuid($guid))) {
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => 3000,
        'messages' => 'Object not found'
      ));
    }
    $this->view->form = $form = new Seo_Form_Admin_Manage_Edit();
    $page = Engine_Api::_()->getItem('seo_page', $guid);

    if ($page) {
      $form->populate($page->toArray());
    }

    if (!$this->_request->isPost()) {
      return;
    }


    if (!$form->isValid($this->_request->getPost())) {
      return;
    }

    $values = $form->getValues();

    // Process form
    if (!$page) {
      $page = Engine_Api::_()->getDbtable('pages', 'seo')->createRow();
      $page->page_id = $resource->getGuid();
    }
    $page->setFromArray($values);
    $page->save();

    return $this->_forward('success', 'utility', 'core', array(
      'parentRefresh' => true,
      'messages' => 'Changes Saved'
    ));
  }

}
