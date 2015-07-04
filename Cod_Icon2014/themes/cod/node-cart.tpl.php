<div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">

<?php print $picture ?>

<?php if ($page == 0): ?>
  <h2><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
<?php endif; ?>

  <?php if ($submitted): ?>
    <span class="submitted"><?php print $submitted; ?></span>
  <?php endif; ?>

  <div class="content clear-block">
    <?php print $content ?>
  </div>

  <div class="clear-block">
    <div class="meta">
    <?php if ($taxonomy): ?>
      <div class="terms"><?php print $terms ?></div>
    <?php endif;?>
    </div>

    <?php if ($links): ?>
      <div class="links"><?php print $links; ?></div>
    <?php endif; ?>
  </div>
  
  <div class="order"> 
  <h3> כרטיסים בהזמנה : </h3>
  <?php
$sids = json_decode($node ->field_singups[0]['value']);
$paid_flag=1;
print '<div style="font-size:14px;">';
foreach ($sids as &$sid)
		{
			$signup = signup_load_signup($sid);
			$paid = unserialize($signup->form_data);
			print($signup->title);
			if ($paid['member']) { print(' - כרטיס במחיר חבר');}
			print("<br>");
			if ($paid['printed']==-1) { $paid_flag=0; }
		}
print '<br><br></div>';
if ($paid_flag==0) print(' <div style="color:red;font-size:16px"> לא שולם </div>');
 ?> 
 </div>
</div>
