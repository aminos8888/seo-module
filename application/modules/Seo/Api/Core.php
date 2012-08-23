<?php

class Seo_Api_Core extends Core_Api_Abstract
{
  /**
   * getSeo_page 
   * 
   * @param mixed $id or $url
   * @access public
   * @return void
   */
  public function getSeo_page($id)
  {
    $table = Engine_Api::_()->getDbTable('pages', 'seo');
    $page = $table->find($id)->current();
    if ($page) {
      return $page;
    }
    $select = $table->select()->where('url = ?', $id);
    return $table->fetchRow($select);
  }

}
