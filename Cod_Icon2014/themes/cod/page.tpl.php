<?php
// $Id: page.tpl.php 7156 2010-04-24 16:48:35Z chris $
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>" prefix="og: http://ogp.me/ns#" dir="rtl" >

<head>
  <title> 
    
    <?php 
        if ($title)
        {
            print $title . ' - ' . variable_get('site_name', 'מערכת כו"ד'); 
        }
        else
            print 'תוכניה והזמנת כרטיסים' . ' - ' . variable_get('site_name', 'מערכת כו"ד');;
    ?>
  </title>
<meta property="og:image" content="http://iconfestival.com/cod/sites/all/themes/cod/images/iconsquare-200200.gif" /> 
  <?php print $head; ?>
  <?php print $styles; ?>
  <?php print $setting_styles; ?>
  <!--[if IE 8]>
  <?php print $ie8_styles; ?>
  <![endif]-->
  <!--[if IE 7]>
  <?php print $ie7_styles; ?>
  <![endif]-->
  <!--[if lte IE 6]>
  <?php print $ie6_styles; ?>
  <![endif]-->
  <?php if ($local_styles): ?>
  <?php print $local_styles; ?> 
    <link type="text/css" rel="stylesheet" media="all" href="<?php print base_path() . path_to_theme() . '/css/dark-hive/jquery-ui-1.7.3.custom.css'?>" />
  <?php endif; ?>
  <?php print $scripts; ?>
  <meta name="robots" content="no index, no follow" /> 
</head>
 
<body id="<?php print $body_id; ?>" class="<?php print $body_classes; ?>">
  <div id="page" class="page">
    <div id="page-inner" class="page-inner">

      <!-- header-top row: width = grid_width -->
      <!-- header-group row: width = grid_width -->
      <div id="header-group-wrapper" class="header-group-wrapper full-width">
       <a href="/cod">
        <div class="HeaderLogo">
            <div style="">
            <?php
             if (views_check_roles(array('3'=>3,'6'=>6)))
             {
                 $block = module_invoke('nice_menus', 'block', 'view', '1');
                 print $block['content'];
             }
            ?>
            </div>
        </div>
        </a>
      </div><!-- /header-group-wrapper -->
      
		
    <!-- main row: width = grid_width -->
    <div id="main-wrapper" class="main-wrapper full-width">
	<div class="ActionsBar">
                
				<div class="ActionItem ActionItemSchedule">
                    <div class="Leaf Leaf1"> </div> <a href="<?php print base_path();?>program/session-schedule"><div class="ActionItemCommand">תוכניה</div></a>
				</div>
				<div class="ActionItem ActionItemLogin">
					<div class="ActionItemCommand">
    					<div class="Leaf Leaf2"> </div>
                        <?php
						 global $user;
    					 if ($user->uid)
    					 {
							 print '<!--';
								echo "(".$user->uid.")";

								$var = content_profile_load('profile', $user->uid);
								$name = $var->field_first_name[0]['value']; 
								print "00|".$name;		               
                             if ($name == null || $name == '')
                             {
                                $name =$user->field_first_name;
								echo "|1".$user->field_first_name;
                             }
                             if ($name == null || $name == '')
                             {
                                $a = $content_profile->get_variable('profile', 'profile_first');
                                $name = $a[0]['value'];
								echo "|2".$a[0]['value'];

                             }
                             if ($name == null || $name == '')
                             {
                                $a = $content_profile->get_variable('profile', 'field_first_name');
                                $name = $a[0]['value'];
								echo "|3".$a[0]['value'];
								echo "|4".$user->realname;

                             }
                             if ($name == null || $name == '') {
                                $name = $user->realname;																
                             }
                             print '-->';
    						 print "שלום, $name";
    					 }
    					 else
    					 {
    						 print "התחברות/הצטרפות";
    					 }
    					?>
    					 </div>
    				
    					 <div class="ActionItemFloat">
                         	<?php
    					    if  ($user->uid == 0) {
    					    ?>
                                <div>על מנת להזמין כרטיסים עליך להתחבר למערכת. אם לא נרשמת בעבר 
                                    <?php print l('לחץ כאן.','user/register'); ?>
                                </div>
        					    <?php
        						$block1 = module_invoke('user', 'block', 'view', '0');
        						print $block1['content'];
        					    ?>
                    	    <?php 
                            } else { 
                                $userlink = l('שינוי פרטים וסיסמה','user/'.$user->uid.'/');
                                $disconnectlink = l('התנתקות','logout');

                                print $userlink . '<br/><br/>';
                                print $disconnectlink . '<br/><br/><br/>';
                            }?>
                         </div>
					 </div>
				<div class="ActionItem ActionItemHowTo" style="position: relative;">
					<div class="ActionItemCommand">
                    <div class="Leaf Leaf3"> </div>
					איך מזמינים כרטיסים?
					</div>
					<div class="ActionItemFloat" >
					  <div style="padding:0px 10px;">
						<p> 
							להזמנת כרטיסים אנא עקבו אחרי השלבים הבאים,
							</p>
						
						<ol>
							<li><?php print l('הרשמו','user/register'); ?> וקבלו סיסמא במייל.</li>
							<li><?php print l('התחברו','user'); ?> למערכת.</li>
							<li>הוסיפו לסל את האירועים המבוקשים. 
							<br> מבצע 10 ש״ח הנחה על הכרטיס השלישי!</li>
							<li>בסיום ההזמנה<?php print l(' לחצו כאן ','createtickets'); ?> או על סיכום הזמנה בסל ההזמנות.  </li>
							<li> בחרו במספר הכרטיסים לכל אירוע ולחצו על "שלח בקשת הרשמה".</li>
							<li> שלמו במערכת המאובטחת.</li>
						</ol>
						<div>
							<span>לשאלות ובירורים ניתן לפנות</span>
							<span style="font-weight:bold;"><a href="mailto:<?php echo variable_get('ticket_mail', 'IT@sf-f.org.il');?>?subject=הזמנת כרטיסים"> לדוא"ל</a></span>
							<br>
							<span> או למוקד הסיוע הטלפוני: 052-6605637 <br>
							שעות פעילות המוקד: ימים א', ג', ה' 21:00-16:00 </span>

							<br/>
							</div>
						</br></br>
					  </div>
					</div>
				</div>
			
				<div class="ActionItem ActionItemBasket">
					<div class="ActionItemCommand">
                    <div class="Leaf Leaf4"> </div>
					<?php
					$flag = flag_get_flag('session_schedule');
					$count = $flag->get_user_count($user->uid);
					print "סל הזמנות <span class='total'>($count)</span>";			
                    ?>
					</div>
					<div class="ActionItemFloat">                    
					<?php
                    if ($user->uid == 0)
                    {
    					?>
                         <div style="padding: 10px;font-size: 14px;font-weight: bold;">על מנת להזמין כרטיסים עליך להתחבר למערכת. אם לא נרשמת בעבר 
                         <?php print l('לחץ כאן.','user/register'); ?>
                         </div>                        
                    <?php
                    }
                    else
                    {
					echo('<div id="view_block">');
	 					$block = module_invoke('views', 'block', 'view', 'cod_schedule-block_2');
    					print $block['content'];
					echo('</div>');
						
						
						if ($user->uid == 1 || user_access('access cashier')) {
						?> 
						<span class="DarkButton TicketsStatusButton">
                                <?php print  l('מצב כרטיסים','ticketstatus',array('attributes' => array('target' => 'ticketstatus'))  ); ?>
                            </span>
						<?php }
                        if ($user->uid == 1 || user_access('access cashier')||(variable_get('sale_state', '0')==1)) {
                        ?>                            
						<span class="DarkButton PrintTicketsButton">
							<?php print l('סיכום הזמנה','createtickets'); ?>
						</span>	
						<span class="DarkButton EmptyTicketsButton">
                                <?php print  l('נקה סל','clearrequests'); ?>
                            </span>						
						<?php
						}	
					} ?>
                    <br /><br />
                    </div>
                    <div style="clear:both;"></div>
				</div>
				
					<div class="ActionItem ActionItemTickets">
					<div class="ActionItemCommand">
                    <div class="Leaf Leaf5" style="text-align:center;"> </div>
					<?php
					print "כרטיסים";			
                    ?>
					</div>
					<div class="ActionItemFloat">
                    <?php
                    if ($user->uid == 0)
                    {
    					?>
                         <div style="padding: 10px;font-size: 14px;font-weight: bold;">על מנת להזמין כרטיסים עליך להתחבר למערכת. אם לא נרשמת בעבר 
                         <?php print l('לחץ כאן.','user/register'); ?>
                         </div>                        
                    <?php
                    }
                    else
                    {
					echo('<div id="view_block">');
	 					$block = module_invoke('views', 'block', 'view', 'approved_tickets-block_1');
    					print $block['content'];
					echo('</div>');
					} 
					?>
                    <br /><br />
                    </div>
                    <div style="clear:both;"></div>
				</div>
				
				
				<div style="clear: both;"> </div>
			</div>
            <div style="clear: both;"> </div>
            </div>
				<div style="clear: both;"> </div>
			</div>
            <div style="clear: both;"> </div>
            </div>
	
	<div style="clear:both;"></div>
      <div id="main" class="main row <?php print $grid_width; ?>">
        <div id="main-inner" class="main-inner inner clearfix">
            
          <?php print theme('grid_row', $sidebar_first, 'sidebar-first', 'nested', $sidebar_first_width); ?>

          <!-- main group: width = grid_width - sidebar_first_width -->
          <div id="main-group" class="main-group row nested <?php print $main_group_width; ?>">
            <div id="main-group-inner" class="main-group-inner inner clearfix">
            
              <?php print theme('grid_row', $preface_bottom, 'preface-bottom', 'nested'); ?>

              <div id="main-content" class="main-content row nested">
                <div id="main-content-inner" class="main-content-inner inner clearfix">
                  <!-- content group: width = grid_width - (sidebar_first_width + sidebar_last_width) -->
                    <div id="content-group" class="content-group row nested <?php print $content_group_width; ?>">
                      <div id="content-group-inner" class="content-group-inner inner clearfix">
                      

                        <?php if ($content_top || $help || $messages): ?>
                        <div id="content-top" class="content-top row nested">
                          <div id="content-top-inner" class="content-top-inner inner clearfix">
                            <?php print theme('grid_block', $help, 'content-help'); ?>
                            <?php print theme('grid_block', $messages, 'content-messages'); ?>
                            <?php print $content_top; ?>
                          </div><!-- /content-top-inner -->
                        </div><!-- /content-top -->
                        <?php endif; ?>

                        <div id="content-region" class="content-region row nested">
                          <div id="content-region-inner" class="content-region-inner inner clearfix">
                            <a name="main-content-area" id="main-content-area"></a>
                            <?php print theme('grid_block', $tabs, 'content-tabs'); ?>
                            <div id="content-inner" class="content-inner block">
                              <div id="content-inner-inner" class="content-inner-inner inner clearfix">
                                <?php if (0 && $title): ?>
                                <h1 class="title"><?php print $title; ?></h1>
                                <?php endif; ?>
                                
                                <?php if ($content): ?>
                                <div id="content-content" class="content-content">
                                  <?php print $content; ?>
                                  <?php print $feed_icons; ?>
                                </div><!-- /content-content -->
                                <?php endif; ?>
                              </div><!-- /content-inner-inner -->
                            </div><!-- /content-inner -->
                          </div><!-- /content-region-inner -->
                        </div><!-- /content-region -->

                        <?php print theme('grid_row', $content_bottom, 'content-bottom', 'nested'); ?>
                      </div><!-- /content-group-inner -->
                    </div><!-- /content-group -->

                    <?php print theme('grid_row', $sidebar_last, 'sidebar-last', 'nested', $sidebar_last_width); ?>
                  </div><!-- /main-content-inner -->
                </div><!-- /main-content -->

                <?php print theme('grid_row', $postscript_top, 'postscript-top', 'nested'); ?>
              </div><!-- /main-group-inner -->
            </div><!-- /main-group -->
          </div><!-- /main-inner -->
        </div><!-- /main -->

           <?php
    //get all user flags
    $o = flag_get_user_flags('node',NULL,$GLOBALS['user']->uid);
    if ($o != null)
    {
        print "<script> $(function(){ ";
        foreach ($o['session_schedule'] as $f) {
            $link = str_replace(array("\r", "\r\n", "\n"),'',(flag_create_link('session_schedule', $f->content_id)));
            $link = str_replace("'","\"",$link);
            print "$('.session-calendar td[id=$f->content_id] .views-field-ops').html('$link');";
        }
        print "  $('.flag-session-schedule.flagged, .flag-session-schedule.approved').parents('td').addClass('cellhighlight');  });</script>";
    }
?>
      </div><!-- /main-wrapper -->

      <!-- postscript-bottom row: width = grid_width -->
      <?php print theme('grid_row', $postscript_bottom, 'postscript-bottom', 'full-width', $grid_width); ?>

      <!-- footer row: width = grid_width -->
      <?php print theme('grid_row', $footer, 'footer', 'full-width', $grid_width); ?>

      <!-- footer-message row: width = grid_width -->
      <div id="footer-message-wrapper" class="footer-message-wrapper full-width">
        <div id="footer-message" class="footer-message row <?php print $grid_width; ?>">
          <div id="footer-message-inner" class="footer-message-inner inner clearfix">
            <?php print theme('grid_block', $footer_message, 'footer-message-text'); ?>
              <?php
                 if ($user->uid)
                 {
                     $userr =user_load($user->uid);
                     $userrlink = l($userr->profile_first,'user/'.$user->uid.'/profile/profile',array('attributes' => array('title' => 'פרופיל משתמש')));
                     $disconnectlink = l('(התנתק)','logout');
                     print "<span>שלום, <a>$userrlink</span> $disconnectlink</span>";
                 }
                 else
                 {
                     $connectlink = l('כניסה/הצטרפות','user');
                     print "<span>$connectlink</span>";
                 }
                ?>
          </div><!-- /footer-message-inner -->
        </div><!-- /footer-message -->
      </div><!-- /footer-message-wrapper -->

    </div><!-- /page-inner -->
  </div><!-- /page -->
 <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-39364941-9', 'auto');
  ga('send', 'pageview');

</script>
  
  <script language="javascript">
// disabling password security check
Drupal.behaviors.password = function(context) {
  return;
}
</script>
  
  
  
  <?php print $closure; ?>
  <?php 
global $user;
if ($user->uid== 241 ) {
echo " <style> .session-calendar-container { background-image:url('http://iconfestival.com/cod/sites/all/themes/cod/images/Sivan.jpg'); margin-bottom: 20px; </style> ";
} ?>
</body>
</html>
