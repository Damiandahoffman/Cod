<?php
// $Id: views_customfield_handler_field_markup.inc,v 1.1.2.5 2008/11/19 13:53:47 casey Exp $

/**
 * @file
 * Contains the 'customfield' markup field handler.
 */

/**
 * Field handler to display custom markup text.
 */
class eran_handler_field_markup extends views_handler_field {

  function query() {
    $this->field_alias = 'cod_'. $this->position;
    
    $value = db_escape_string($this->options['value']);
    $value = 0;
    $this->query->add_field('', "'$value'", $this->field_alias);
  }
  
  function option_definition() {
    $options = parent::option_definition();
    $options['value'] = array('default' => '');
    $options['format'] = array('default' => FILTER_FORMAT_DEFAULT);
    return $options;
  }

  function options_form(&$form, &$form_state) {
    parent::options_form($form, $form_state);
    $form['value'] = array(
      '#type' => 'select',
      '#title' => t('Type'),
      '#default_value' => $this->options['value'],
      '#options' => array(
            'Free' => t('Free Limit'),
            'Paid' => t('Paid Limit'),
            'ApprovedTickets' => t('Approved Tickets'),
            'EventSoldTickets' => t('Event Sold Tickets'),
            'PaidTickets' => t('Paid Tickets'),
            'RquestByRole' => t('RquestByRole'),
      ),
    );
    $form['format'] = filter_form($this->options['format'], NULL, array('options', 'format'));
  }

  function render($values) {
    $value = $values->{$this->field_alias};


    if ($this->options['value'] == 'Paid')
    {
         $query = db_query("SELECT cid, status_limit FROM {signup_status_limit_node_limit} WHERE nid = %d", $values->nid);
          while ($limit = db_fetch_object($query)) {
            $limits[$limit->cid] = $limit->status_limit;
          }
        $values->{$this->field_alias} =  $limits[2];
        return $limits[2];
    }
    elseif ($this->options['value'] == 'Free')
    {
         $query = db_query("SELECT cid, status_limit FROM {signup_status_limit_node_limit} WHERE nid = %d", $values->nid);
          while ($limit = db_fetch_object($query)) {
            $limits[$limit->cid] = $limit->status_limit;
          }
        $values->{$this->field_alias} =  $limits[1];
        return $limits[1];
    }
    elseif ($this->options['value'] == 'ApprovedTickets')
    {
        $d = db_result(db_query("SELECT SUM(count_towards_limit) FROM {signup_log} WHERE nid = %d AND uid = %d", $values->nid,$values->users_flag_content_uid ));
        if ($d == null)
            $d = 0;
        $values->{$this->field_alias} = $d;   
        return $d;
    }
    elseif ($this->options['value'] == 'EventSoldTickets')
    {
        $d = db_result(db_query("SELECT SUM(count_towards_limit) FROM {signup_log} WHERE nid = %d AND status = 1", $values->nid));
        if ($d == null)
            $d = 0;
        $values->{$this->field_alias} = $d;   
        return $d;
    }
	elseif ($this->options['value'] == 'PaidTickets')
    {
        $d = db_result(db_query("SELECT SUM(count_towards_limit) FROM {signup_log} WHERE nid = %d AND status = 2", $values->nid));
        if ($d == null)
            $d = 0;
        $values->{$this->field_alias} = $d;   
        return $d;
    }
    elseif ($this->options['value'] == 'RquestByRole')
    {
        if ($values->roletickets == null)
        {
            $query =  "SELECT RoleName name, count(RoleName) num FROM 
                        (SELECT flag_content.uid UserID,COALESCE(users_roles.rid,0) RoleID ,COALESCE(role.name,'לקוח') RoleName FROM flag_content
                            LEFT JOIN users_roles ON users_roles.uid = flag_content.uid
                            LEFT JOIN role ON role.rid = users_roles.rid
                            WHERE content_id = %d
                            GROUP BY flag_content.uid) as temp
                        GROUP BY RoleName";
            $result = db_query($query,$values->nid);
            $sum = 0;
            while ($role = db_fetch_object($result)) {
                $roles["$role->name"] = $role->num;
                $sum += $role->num;
            }
            $roles['סה"כ בקשות'] = $sum;
            
            $values->roletickets = $roles;
        }
        $cur_role = $this->options['label'];
        if ($cur_role == 'הפרש')
        {
            $res = $values->cod_12 - $values->cod_11;
            $values->{$this->field_alias} = $res;
            return $res;   
        }
        else
        {
            $res = $values->roletickets["$cur_role"];
            if ($res == null)
                $res = 0;
    
            $values->{$this->field_alias} = $res;
            return $res;
        }
        
    }
    else 
        return '';
    //return check_markup($value, $this->options['format'], FALSE);
  }
}
