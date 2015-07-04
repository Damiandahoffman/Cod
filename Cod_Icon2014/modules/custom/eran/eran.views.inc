<?php
// $Id: views_customfield.views.inc,v 1.1.2.5 2009/01/09 18:32:33 casey Exp $

/**
 * Implementation of hook_views_handlers().
 *
 * @return array
 */
function eran_views_handlers() {
  return array(
    'info' => array(
      'path' => drupal_get_path('module', 'eran') .'/includes',
    ),
    'handlers' => array(
      'eran_handler_field_markup' => array(
        'parent' => 'views_handler_field',
      ),
    ),
  );
}

/**
 * Implementation of hook_views_data().
 *
 * @return array
 */
function eran_views_data() {
  $data['cod']['table']['group'] = t('CoD');
  $data['cod']['table']['join'] = array(
    '#global' => array(),
  );
  
  $data['cod']['markup'] = array(
    'title' => t('Status Limit - Free'),
    'help' => t('Status Limit - Free'),
    'field' => array(
      'handler' => 'eran_handler_field_markup',
      'click sortable' => FALSE,
      'notafield' => TRUE,
    ),
  );
  
  return $data;
}