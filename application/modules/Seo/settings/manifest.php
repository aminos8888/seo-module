<?php return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'seo',
    'version' => '4.0.0',
    'path' => 'application/modules/Seo',
    'title' => 'SEO',
    'description' => 'SEO',
    'author' => 'Marco Enrico Alviar',
    'callback' => 
    array (
      'class' => 'Engine_Package_Installer_Module',
    ),
    'actions' => 
    array (
      0 => 'install',
      1 => 'upgrade',
      2 => 'refresh',
      3 => 'enable',
      4 => 'disable',
    ),
    'directories' => 
    array (
      0 => 'application/modules/Seo',
    ),
    'files' => 
    array (
      0 => 'application/languages/en/seo.csv',
    ),
  ),
  'items' => array(
    'seo_page'
  ),
  'hooks' => array(
    array(
      'event' => 'onRenderLayoutDefault',
      'resource' => 'Seo_Plugin_Core'
    ),
    array(
      'event' => 'onItemDeleteBefore',
      'resource' => 'Seo_Plugin_Core'
    ),
  ),
); ?>
