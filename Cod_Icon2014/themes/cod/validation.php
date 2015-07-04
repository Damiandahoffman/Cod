<?php

if( ! function_exists("node_load"))
	 {
	chdir($_SERVER['DOCUMENT_ROOT']. "/cod");
	require_once ($_SERVER['DOCUMENT_ROOT'] . "/cod/includes/bootstrap.inc");
	drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);										
	}

$posted_values = array();
$nids=array();
$tickets=array();
$valid_order = true;
$message = "Order confirmed";
$msg='הזמנתך אושרה בהצלחה <br>';
if (count($_REQUEST))
{

    $posted_values = $_REQUEST;
	$cart = $posted_values['StateData'];
	$paid_sum = $posted_values['Total'];
	$auth = $posted_values['OkNumber'];

	$node = node_load($cart);
	$sum= $node->field_price[0]['value'];
	if ($sum!=intval($paid_sum)) $valid_order = false;
	if (intval($auth)!=0) $valid_order = false;
	$sids = json_decode($node ->field_singups[0]['value']);	
	
	foreach ($sids as &$sid)
	{
		$signup = signup_load_signup($sid);
		$signup_data = unserialize($signup->form_data);
		if (($signup_data['printed'] == -1))
			{
				$signup_data['printed']=0;
			}
			$signup->form_data = serialize($signup_data);
			signup_save_signup($signup);
			$unids[] = $signup->nid;
			$mail = $signup->mail;
	}
			$unids=array_count_values($unids);
			
			while($element = current($unids))
			{
				$nids[] = key($unids);
				$tickets[] = $element;
				next($unids);
			}
			unset($unids);
		
		for ($i=0;$i<count($nids);$i++) //replace with $signup->title
		{
		  $sql = "SELECT `title` FROM `node` WHERE `nid` = %d";
		  $query_result = db_query($sql,$nids[$i]);
		  $result = db_fetch_object($query_result);
		  $title = $result->title;
		  $msg .= "  עבור האירוע: ".$title." שולמו ".$tickets[$i]." כרטיסים <br>"; 
		}
		$msg .= "ניתן יהיה לאסוף את הכרטיסים ביום הכנס בקופה המיועדת לכך <br>";
		
		$from = 'codbot@iconfestival.org.il';
		$params = array(
		'body' => $msg,
		'subject' => 'אישור תשלום על אירועים לכנס',
		);
    if ($valid_order === true)
    {
       drupal_set_message($msg);
	   if (drupal_mail('createtickets_myform', 'some_mail_key', $mail, language_default(), $params, $from, TRUE))
		{	
        drupal_set_message('An email has been sent to '.$mail);
		} else {
        drupal_set_message('There was an error sending your email','error');
		}	
    }
    else
	{
	drupal_set_message('ארעה תקלה בהזמנתך. אנא שלח מייל ל tickets@olamot-con.org.il','error');
	} 
	
			
   
}
drupal_goto("");  
?>