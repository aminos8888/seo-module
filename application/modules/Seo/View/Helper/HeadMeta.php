<?php

class Seo_View_Helper_HeadMeta extends Zend_View_Helper_HeadMeta
{
  protected $_locked = false;

  public function appendName($keyValue, $content, $modifiers = array())
  {
    if (!$this->_locked) {
      parent::appendName($keyValue, $content, $modifiers);
    }
    return $this;
  }

  public function setName($keyValue, $content, $modifiers = array())
  {
    if (!$this->_locked) {
      parent::setName($keyValue, $content, $modifiers);
    }
    return $this;
  }

  public function prependtName($keyValue, $content, $modifiers = array())
  {
    if (!$this->_locked) {
      parent::prependName($keyValue, $content, $modifiers);
    }
    return $this;
  }

  public function setLocked($flag = true)
  {
    $this->_locked = $flag;
    return $this;
  }
}
