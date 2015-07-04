<?php					

chdir($_SERVER['DOCUMENT_ROOT']. "/cod");
require_once ($_SERVER['DOCUMENT_ROOT'] . "/cod/includes/bootstrap.inc");
drupal_bootstrap(DRUPAL_BOOTSTRAP_SESSION);														
$block = module_invoke('views', 'block', 'view', 'cod_schedule-block_2');
//print $block['content'];
print $user->uid;
 ?>