<?php

class Seo_View_Helper_HeadTitle extends Zend_View_Helper_HeadTitle
{
  protected $_locked = false;

  public function set($title)
  {
    if (!$this->_locked) {
      parent::set($title);
    }
    return $this;
  }

  public function append($title)
  {
    if (!$this->_locked) {
      parent::append($title);
    }
    return $this;
  }

  public function prepend($title)
  {
    if (!$this->_locked) {
      parent::prepend($title);
    }
    return $this;
  }

  public function setLocked($flag = true)
  {
    $this->_locked = $flag;
    return $this;
  }

  public function getLocked()
  {
    return $this->_locked;
  }
}
