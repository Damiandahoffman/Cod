<?php
	
/**
 * Theme the summary table at the bottom of the default shopping cart block.
 *
 * @param $item_count
 *   The number of items in the shopping cart.
 * @param $item_text
 *   A textual representation of the number of items in the shopping cart.
 * @param $total
 *   The unformatted total of all the products in the shopping cart.
 * @param $summary_links
 *   An array of links used in the summary.
 * @ingroup themeable
 *//*
function cod_uc_cart_block_summary($item_count, $item_text, $total, $summary_links) {
  $context = array(
    'revision' => 'themed-original',
    'type' => 'amount',
  );
  // Build the basic table with the number of items in the cart and total.
  $output = '<table class="cart-block-summary"><tbody><tr>'
           .'<td class="cart-block-summary-items">'. $item_text .'</td>'
           .'<td class="cart-block-summary-total"><label>'. t('Total:')
           .'</label> '. uc_price($total, $context) .'</td></tr>';

  // If there are products in the cart...
  if ($item_count > 0) {
    // Add a view cart link.
    $output .= '<tr class="cart-block-summary-links"><td colspan="2">'
             . theme('links', $summary_links) .'</td></tr>';
  }

  $output .= '</tbody></table>';

  return $output;
}*/

function cod_node_form($form) {
    global $user;

    if ($form['form_id']['#value'] == 'event_node_form')
    {
        $before = '';
        $after = '';
        
        $before .= '<div style="float:right;">';
        $before .= drupal_render($form['title']);
        $before .= drupal_render($form['base']['model']);
        $before .= drupal_render($form['event_settings_link']);
        $before .= '</div>';
        
        $before .= '<div style="float:right;width:200px;margin-right:20px;">';
        $before .= drupal_render($form['base']['prices']['sell_price']);
        $before .= drupal_render($form['base']['store_credit_value']);
        $before .= '</div>';
        $before .= '<div style="clear:both;"></div>';



        $after  .= drupal_render($form['buttons']);

        return $before . drupal_render($form) . $after;
    }
    else if ($form['form_id']['#value'] == 'session_node_form')
    {
        //$rooms = $form['field_session_room']['nid']['nid']['#options'];
        
        $before = '';
        $after = '';

        $before .= '<div style="float:right;width:555px;">';
        $before .= drupal_render($form['title']);
        $before .= drupal_render($form['body_field']);
        $before .= drupal_render($form['field_speakers']);
        $before .= drupal_render($form['cod_session']);
        $before .= '</div>';
            
        $before .= '<div style="float:right;width:180px;margin-right:20px;">';
        $before .= drupal_render($form['field_session_slot']);
        $before .= drupal_render($form['field_session_room']);
        $before .= drupal_render($form['field_track']);
        $before .= drupal_render($form['field_pricegroup']);
        $before .= drupal_render($form['field_contentcategory']);
        $before .= drupal_render($form['field_contenttags']);
        $before .= drupal_render($form['field_punctures']);
        //$before .= drupal_render($form['field_accepted']);
        //$before .= drupal_render($form['event_settings_link']);
        $before .= drupal_render($form['options']['status']);
        $before .= '</div>';
        $before .= '<div style="clear:both;"></div>';
        
        $after  .= drupal_render($form['buttons']);

        return $before . drupal_render($form) . $after;
    }
    else if ($form['form_id']['#value'] == 'profile_node_form') {
        //drupal_render($form['title']);
        $before = '';
        $after = '';
        $before .= drupal_render($form['account']['mail']);
        $before .= drupal_render($form['account']['pass']);
        $before .= drupal_render($form['field_first_name']);
        $before .= drupal_render($form['field_last_name']);
        $before .= drupal_render($form['account']['status']);
        $before .= drupal_render($form['account']['roles']);
        $before .= drupal_render($form['group_address']);

        $after  .= drupal_render($form['buttons']);

        return $before . drupal_render($form) . $after;
    }
}
/*
function cod_signup_user_form($node)
{
      global $user;
  $form = array();
  if (variable_get('signup_ignore_default_fields', 0)) {
    return $form;
  }
  // If this function is providing any extra fields at all, the following
  // line is required for form form to work -- DO NOT EDIT OR REMOVE.
  $form['signup_form_data']['#tree'] = TRUE;

  $form['signup_form_data']['Name'] = array(
    '#type' => 'textfield',
    '#title' => t('Name'),
    '#size' => 40, '#maxlength' => 64,
    '#required' => TRUE,
  );
  $form['signup_form_data']['Phone'] = array(
    '#type' => 'textfield',
    '#title' => t('Phone'),
    '#size' => 40, '#maxlength' => 64,
  );

  // If the user is logged in, fill in their name by default.
  if ($user->uid) {
    $form['signup_form_data']['Name']['#default_value'] = $user->name;
  }

  return $form;
}*/

/*
function cod_theme($existing, $type, $theme, $path) {
    $s = 2;
}
*/

function cod_signup_node_admin_page($node, $signup_node_admin_summary_form, $signup_node_admin_details_form) {
  $output = '';

  // Administrative summary table to control signups for this node.
  $output .= $signup_node_admin_summary_form;

    $view_name = 'signup_requests';
    $view_display = 'block_1';
    $view = views_get_view($view_name);
    $view->override_path = 'node/%/signups/admin';
    $view_args = array($node->nid);
    $signuprequests_form = $view->preview($view_display, $view_args);
    $output .= $signuprequests_form;

  // Details for each user who signed up.
  $output .= $signup_node_admin_details_form;
   $sc = '<script> var p = $("#views-bulk-operations-select").parent(); $("#views-bulk-operations-select").appendTo(p); </script>';
   $output .= $sc;
  return $output;
}


function cmp($a, $b)
{
    $timeslotArrayA = explode(" ", $a['view']);
    $dayA = intval($timeslotArrayA[0]);

    $timeslotArrayB = explode(" ", $b['view']);
    $dayB = intval($timeslotArrayB[0]);
        
    if ($dayA == $dayB) {
        return 0;
    }
    return ($dayA < $dayB) ? 1 : -1;
}

function format_dates($date_array)
{
    usort($date_array, "cmp");
    
    $startNode = node_load($date_array[count($date_array)-1]['nid']);
    $endNode = node_load($date_array[0]['nid']);
    $timezoneoffset = variable_get('cod_daylightsaving', '0');
    $timezonestring = ($timezoneoffset+2) . ' hours';
	
    /* add 2 hours to start date */
     $startDateObj = new DateTime();
     $startDateObj->setTimestamp(strtotime($startNode->field_slot_datetime[0]['value']));
     date_add($startDateObj, date_interval_create_from_date_string($timezonestring));
    $startDate = getdate($startDateObj->getTimestamp());
    
    /* add 2 hours to end date */
     $endDateObj = new DateTime();
     $endDateObj->setTimestamp(strtotime($endNode->field_slot_datetime[0]['value2']));
     date_add($endDateObj, date_interval_create_from_date_string($timezonestring));
    $endDate = getdate($endDateObj->getTimestamp());
   
   //$startNode->field_slot_datetime[0]['value']
    $dayName = date_format_date($startDateObj, 'custom', 'l');
    
    $startHour = $startDate['hours'];
    $endHour = $endDate['hours'];
    if ($endDate['minutes']==59) 
    {
        $endHour += 1;
    }
    return 'יום '.$dayName.', '.$startDate['mday'].'/'.$startDate['mon'].', '.$startHour.':00 - '. $endHour . ':00'; 
}

function format_names($name_array)
{ 
   $st = '';
    foreach ($name_array as $key => $val)
    {
        $lect = user_load($val['uid']);
        if ($lect)
        {
            $st .= $lect->realname . ', ';
        }
    }
    $st = substr_replace($st,'',strrpos($st,','),1);
    return $st;
}

function format_tags($name_array)
{ 
   $st = '';
    foreach ($name_array as $key => $val)
    {
        $v = $val['view'];
        if ($v)
        {
            $st .= $v . ', ';
        }
    }
    $st = substr_replace($st,'',strrpos($st,','),1);
    return $st;
}
   
function cod_theme($existing, $type, $theme, $path) {
  return array(
    // tell Drupal what template to use for the user register form
    'user_register' => array(
      'arguments' => array('form' => NULL),
      'template' => 'user-register', // this is the name of the template
    ),
    'createtickets_myform' => array(
      'arguments' => array('form' => NULL),
      'template' => 'createtickets_myform', // this is the name of the template
    ),
    
  );
}
   
?>