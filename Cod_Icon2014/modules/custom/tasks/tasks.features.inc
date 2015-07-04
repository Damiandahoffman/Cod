<?php

/**
 * Implementation of hook_ctools_plugin_api().
 */
function tasks_ctools_plugin_api() {
  list($module, $api) = func_get_args();
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => 1);
  }
}

/**
 * Implementation of hook_node_info().
 */
function tasks_node_info() {
  $items = array(
    'task' => array(
      'name' => t('משימה'),
      'module' => 'features',
      'description' => t('משימת פיתוח. יכול להיות תיקון תקלה או תכונה חדשה.'),
      'has_title' => '1',
      'title_label' => t('כותרת'),
      'has_body' => '1',
      'body_label' => t('תוכן'),
      'min_word_count' => '0',
      'help' => '',
    ),
  );
  return $items;
}

/**
 * Implementation of hook_views_api().
 */
function tasks_views_api() {
  return array(
    'api' => '2',
  );
}
