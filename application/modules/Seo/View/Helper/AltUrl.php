<?php

class Seo_View_Helper_AltUrl extends Zend_View_Helper_Abstract
{
  protected $_memo;

  public function altUrl(Core_Model_Item_Abstract $item)
  {
    $db = Engine_Db_Table::getDefaultAdapter();

    if (isset($this->_memo[$item->getGuid()])) {
      return $this->_memo[$item->getGuid()];
    }

    $url = $db->select()
      ->from('engine4_seo_pages', 'url')
      ->where('page_id = ?', $item->getGuid())
      ->query()
      ->fetchColumn();
    $this->_memo[$item->getGuid()] = $url;
    return $url;
  }
}
