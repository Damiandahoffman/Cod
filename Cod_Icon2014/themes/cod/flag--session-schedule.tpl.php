<?php
// $Id: flag.tpl.php,v 1.1.2.7 2009/03/17 02:10:30 quicksketch Exp $

/**
 * @file
 * Default theme implementation to display a flag link, and a message after the action
 * is carried out.
 *
 * Available variables:
 *
 * - $flag: The flag object itself. You will only need to use it when the
 *   following variables don't suffice.
 * - $flag_name_css: The flag name, with all "_" replaced with "-". For use in 'class'
 *   attributes.
 * - $flag_classes: A space-separated list of CSS classes that should be applied to the link.
 *
 * - $action: The action the link is about to carry out, either "flag" or "unflag".
 * - $last_action: The action, as a passive English verb, either "flagged" or
 *   "unflagged", that led to the current status of the flag.
 *
 * - $link_href: The URL for the flag link.
 * - $link_text: The text to show for the link.
 * - $link_title: The title attribute for the link.
 *
 * - $message_text: The long message to show after a flag action has been carried out.
 * - $after_flagging: This template is called for the link both before and after being
 *   flagged. If displaying to the user immediately after flagging, this value
 *   will be boolean TRUE. This is usually used in conjunction with immedate
 *   JavaScript-based toggling of flags.
 * - $setup: TRUE when this template is parsed for the first time; Use this
 *   flag to carry out procedures that are needed only once; e.g., linking to CSS
 *   and JS files.
 *
 * NOTE: This template spaces out the <span> tags for clarity only. When doing some
 * advanced theming you may have to remove all the whitespace.
 */

  if ($setup) {
    drupal_add_css(drupal_get_path('module', 'flag') .'/theme/flag.css');
    drupal_add_js(drupal_get_path('module', 'flag') .'/theme/flag.js');
  
  }
     global $base_url;
     global $theme_path;

   $showlink = 0; 
   $text ="";
  if (in_array('קופאי',$user->roles) || in_array('מנהל כנס',$user->roles) || in_array('מנהל אתר',$user->roles))
   { // cachier/manager
        $showlink = 1;
		$ticketsLeft = $signup_status_limit[2]['limit'] - $signup_status_limit[2]['total']; 
		$text = $ticketsLeft . ' נותרו למכירה <br>';
		$img = "<span title='$title' style='cursor:default;color:#red;font-weight:bold;'><img src='$iconPath' style='height:20px; margin-top: -8px;vertical-align: middle;' alt='$title' 
title='$title'/> $text</span>";
   }
   else
   // normal logged in site visitor
   { 												
		if (variable_get('sale_state', '0')==1)
		//sale is open
		{
		$showlink = 1;
		$closedLinkTitle = 'לחץ להוספה לסל';
		}
		else
		//sale is closed
		{
		$closedLinkTitle = 'המכירה סגורה';
		$link_text = 'המכירה סגורה';
		}
	}
   	
//no tickets left
 $ticketsLeft = $signup_status_limit[2]['limit'] - $signup_status_limit[2]['total']; 
	if (user_access('free tickets')) 
	{
		$ticketsLeft=$ticketsLeft+$signup_status_limit[1]['limit'] - $signup_status_limit[1]['total']; //allow to order free tickets, even if all paid tickets are sold
	}
 
 if (!($ticketsLeft >0 ))
	{
		$closedLinkTitle = 'אזלו הכרטיסים לארוע זה';
		$showlink = 0;
		$link_text = 'אזלו הכרטיסים';
	}
	
 if (($signup_status_limit[2]['limit'] ==0 )) // no tickets needed
{
	$closedLinkTitle = 'הכנס לפרטים';
	$showlink = 0;
	$link_text = ' הכנס לפרטים';
}
	
        {        
            if ($usertickets && !($user->uid == 1 || in_array('קופאי',$user->roles)) )
            {
                $iconPath = $base_url.'/'.$theme_path.'/images/green-checkmark.png';
                $text =$text.  $usertickets . ' כרטיסים נרכשו ';
				$img = "<span title='$title' style='cursor:default;color:#red;font-weight:bold;'><img src='$iconPath' style='height:20px; margin-top: -8px;vertical-align: middle;' alt='
						$title' title='$title'/> $text</span>";
				$link_text = "<br>הוסף לסל";
				$linkclass = 'unflagged';
				if (!($last_action == 'flagged'))
				/*if (!($flag->is_flagged($node->nid))) */
				{
					$link_text = "<br>הוסף לסל";
					$linkclass = 'unflagged';
				}
				else 
				{
					$link_text = "<br>הסר מהסל";
					$linkclass = 'flagged';
				}
            }
            else 
				if ($last_action == 'unflagged')
            {
                $linkclass = 'unflagged';
                $ticketsLeft = $signup_status_limit[2]['limit'] - $signup_status_limit[2]['total']; 
				if (user_access('free tickets')){
				$ticketsLeft=$ticketsLeft+$signup_status_limit[1]['limit'] - $signup_status_limit[1]['total']; //allow to order free tickets, even if all paid tickets are sold
			}
				if (!( $ticketsLeft > 0 ))
                {
					$linkclass = 'unflagged';
                    $showlink = 0;
                }
            }
            else
            {
                $linkclass = 'flagged';
                $showlink = 1;
            }
        }
  

    $fl = flag_flag_link($flag,'flag',$content_id);
	if ($flag->current_display == 'page_1NOT') {
    ?>

<span class="flag-wrapper flag-<?php echo $flag_name_css; ?> unflagged">
  <a href="<?php echo $fl['href'].'?'.$fl['query']; ?>" title="הוסף ארוע לסל הארועים" class="flag flag-action flag-link-normal" rel="nofollow">
    הוסף לסל
  </a>
</span>

<?php
}
else {
?>
<span class="flag-wrapper flag-<?php echo $flag_name_css; ?> <?php echo $linkclass; ?>">
  <?php 
  if($img) {
    print $img;
	if ($showlink) {
	?>
	<!-- <br> <a href="<?php echo $fl['href'].'?'.$fl['query']; ?>" title="הוסף ארוע לסל הארועים" class="flag flag-action flag-link-normal" rel="nofollow"> 
    הוסף לסל
  </a>-->
  <a href="<?php echo $link_href; ?>" title="<?php echo $link_title; ?>" class="<?php print $flag_classes; ?>" rel="nofollow">
	<?php echo $link_text; }?>
  </a>
<?php	} 
  else if ($showlink) 
  { ?>
  <a href="<?php echo $link_href; ?>" title="<?php echo $link_title; ?>" class="<?php print $flag_classes; ?>" rel="nofollow">
    <?php echo $link_text; ?>
  </a>
    <?php 
	} 
	else { ?>
  <span title="<?php print $closedLinkTitle ?>" class="<?php print $flag_classes ?>" rel="nofollow" style="color: gray;">
    <?php echo $link_text; ?>
  </span>
  <?php } ?>
  
  <span class="flag-throbber">&nbsp;</span>
  <?php if ($after_flagging): ?>
    <span class="flag-message flag-<?php echo $last_action; ?>-message">
      <?php echo $message_text; ?>
    </span>
  <?php endif; ?>
</span>

<?php }?>