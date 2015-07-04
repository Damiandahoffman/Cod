<?php
// $Id: views-view-unformatted.tpl.php,v 1.6 2008/10/01 20:52:11 merlinofchaos Exp $
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<table cellpadding="3" cellspacing="0" border="1">
<?php 
if ($rows != null) {
foreach ($rows as $id => $row): 
    print $row;
endforeach; }?>
</table>
