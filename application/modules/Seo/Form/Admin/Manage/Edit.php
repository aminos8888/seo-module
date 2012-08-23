<?php

class Seo_Form_Admin_Manage_Edit extends Engine_Form
{
  public function init()
  {
    $this->setAttrib('class', 'global_form_popup');
    $this->setAction($_SERVER['REQUEST_URI']);

    $this->addElement('text', 'url', array(
      'label' => 'URL',
      'description' => 'the text after ' . $_SERVER['HTTP_HOST'] . '/',
      'filters' => array(
        new Seo_Filter_UrlEncode(),
      ),
      'validators' => array(
        array('Db_NoRecordExists', true, array('table' => 'engine4_seo_pages', 'field' => 'url'))
      )
    ));

    $this->addElement('text', 'title', array(
      'label' => 'Title',
      'filters' => array(
        new Engine_Filter_Censor(),
        new Engine_Filter_HtmlSpecialChars()
      )
    ));

    $this->addElement('textarea', 'description', array(
      'label' => 'Description',
    ));

    $this->addElement('textarea', 'tags', array(
      'description' => 'Separate tags with comma.',
      'label' => 'Tags',
      'filters' => array(
        new Engine_Filter_Censor(),
        new Engine_Filter_HtmlSpecialChars(),
        new Seo_Filter_Tag()
      )
    ));

    $this->addElement('button', 'submit', array(
      'type' => 'submit',
      'label' => 'Edit',
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('cancel', 'cancel', array(
      'link' => true,
      'label' => 'Cancel',
      'prependText' => ' or ' ,
      'onclick' => 'parent.Smoothbox.close()',
      'decorators' => array('ViewHelper')
    ));

    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }
}
