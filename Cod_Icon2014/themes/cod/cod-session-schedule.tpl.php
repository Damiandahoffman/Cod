
 <style>
.page {width: 100%;}
#main, .grid16-16 {width:100%;}
.session-calendar-container {max-width:95%;} 
 #page-inner {min-width: 95%;}
</style>


<div><?php echo variable_get('cod_schedule_header_text', ''); ?> </div>
 
<!-- Cart reminder area -->
<?php 
// Cart reminder area
if (!($user->uid == 0))
{
	$results = db_query('SELECT nid FROM {node} WHERE type="cart" AND uid=%s', $user->uid);
	if (!(($results->num_rows)==0)) 
	{
	while($nid = db_result($results)) {
		$carts[] = node_load($nid);
	}
	

		echo ('<div id="pending" style="font-size: 16px; font-weight: bold; border: 1px solid; text-align: center;height:auto;">');
		foreach($carts as $cart) 
		{
			if ((($cart->field_ispaid[0]['value'])==0)&(($cart->field_price[0]['value'])>1)) 
			{
			print("הזמנה מספר " . $cart->nid ." טרם שולמה. לתשלום <a href=payment&cart=". $cart->nid. "> לחץ כאן </a>");
			echo("<br><br>");
			}
		}
		echo('</div>');
		echo('<br><br>');
	}
}
// Cart reminder area end

if ($user->uid == 1 || user_access('access cashier')) {
?>
    <div class="ScheduleCashierButtons">
        <span class="DarkButton PrintTicketsButton">
            <?php print l('צור כרטיסים','createtickets'); ?>
        </span>
        <span class="DarkButton EmptyTicketsButton">
            <?php print  l('נקה סל','clearrequests'); ?>
        </span>
        <span class="DarkButton TicketsStatusButton">
            <?php print  l('מצב כרטיסים','ticketstatus',array('attributes' => array('target' => 'ticketstatus'))  ); ?>
        </span>
    </div>
	
<?php  }
?>


<?php if(!empty($days) && !empty($rooms) && !empty($arranged_slots)): ?>
<!--
<div class="ColorIndex"> </div>
 -->
<div style="clear: both;"></div>


<!-- הוסף לסל סדנאות -->
<?php 
if (variable_get('cod_schedule_show_extrasessions', '0') && ($user->uid == 1 || user_access('access cashier'))) {
?>

<?php  }
?>
<div style="clear: both;"></div>


<!-- Days links -->
<a id =  "day_links"></a>
<div id = "day_links">
<?php foreach ($days as $day_key => $day_title): ?>
<a href =  "#<?php print $day_key?>">
<?php print $day_title; ?>
</a>
<?php endforeach ?>
<a href = "<?php print base_path();?>/session_brief"> לתקצירי האירועים</a>
</div>

<!-- Briefs links -->



<!-- אזור תגיות -->

<div class="TermsMenu" id="TermsMenu">
<div class="TermsTitle">תגיות:</div> 

<?php 
	$terms = taxonomy_get_tree(1);
	print "";
	foreach ( $terms as $term ) {
	  $count = db_result(db_query("SELECT COUNT(nid) FROM {term_node} WHERE tid = %d ", $term->tid));
	  if ($count) {   
		 print "<span class='Term' data-term='$term->tid'>$term->name</span>";
	   }
	} 
	print "";	
?> 
<div style="clear: both;"></div>
</div>

<!-- אזור תגיות -->




<!-- floating scrollbar-->

<div style="overflow-x: scroll; height: 17px; position:fixed; z-index: 999; margin-right: 5px; bottom:0px;" class="wrapper"> 
<div style="overflow-x: scroll;" class="scroll-bar"> </div></div> 

<script type="text/javascript">
$(function(){
	$("div.scroll-bar").width($("table.session-calendar").width());
	$("div.wrapper").width($("div.session-calendar-container").width());

window.onresize = function(event) {
    $("div.scroll-bar").width($("table.session-calendar").width());
	$("div.wrapper").width($("div.session-calendar-container").width());
};
	
	
	
  $("div.wrapper").scroll(function(){
    $("div.session-calendar-container").scrollLeft($("div.wrapper").scrollLeft());
  });
  
$("div.session-calendar-container").scroll(function(){
    $("div.wrapper").scrollLeft($("div.session-calendar-container").scrollLeft());
  });
  
 });
</script>

<!-- end floating scrollbar-->


<!-- לוח ארועים -->
<?php if (!empty($day_links)): ?>
<ul>
<?php foreach ($day_links as $link): ?>
<li><?php print $link; ?></li>
<?php endforeach ?>
</ul>
<?php endif ?>
<?php
 
 foreach ($days as $day_key => $day_title): 
 $needPrint = 0;
 foreach ($arranged_slots[$day_key] as $s) {
        $timeslotArray = explode(":", $s['start']);
        $startHour = intval($timeslotArray[0]);
        if ($startHour <= 5) 
            continue;
        
        $needPrint = 1;
 }

 if ($needPrint == 0) continue;
 ?>
 <a id =  "<?php print $day_key?>" href = "#day_links">
  <h2 style="margin-right: 115px;">
  <?php print $day_title; ?>
  </h2>
 </a>
  
<h2 id = "more" style="float: left; margin-top: -30px; margin-left: 5%; height: 10px;">  יש לגלול לאולמות נוספים >>> </h2> 
  
  
  <div class="session-calendar-container" data-time="<?php print $day_title; ?>">
  
  <table class="session-calendar" cellpadding="0" cellspacing="0" border="0" >
    <thead>
    <tr class="fixedheader">
      <th data-priority="persist"><?php /*print t('Time');*/ ?></th>
      <?php foreach ($rooms as $room_nid => $room): ?>
      <?php if (1 || $show_rooms[$day_key][$room_nid]): ?>
        <th style="min-width: 120px;><span class="room-label"><?php print $room['title']; ?></span><?php if(!empty($room['sponsor'])): ?><div class="sponsor-label"><?php print $room['sponsor']; ?></div><?php endif; ?></th>
      <?php endif; ?>
      <?php endforeach ?>
    </tr>
    </thead>
    <?php foreach ($arranged_slots[$day_key] as $slot): 
        $timeslotArray = explode(":", $slot['start']);
        $startHour = intval($timeslotArray[0]);
        if ($startHour <= 5) continue;

    ?>
    <tr class="<?php print $zebra = $zebra == 'even' ? 'odd':'even'; ?> <?php print $slot['class']; ?>">
        <td class="time-label"><span class="time-label-wrapper">
          <?php print $slot['start']; ?></span>
        </td>
        <?php foreach ($room_nids as $room_nid): ?>
            <?php // Are there scheduled items to print in this cell?
            if (!empty($schedule_grid[$day_key][$slot['nid']][$room_nid]['sessions'])): ?>
            <?php $arr = array_values($schedule_grid[$day_key][$slot['nid']][$room_nid]['sessions']); ?>
              <td id="<?php print $arr[0]['session']->nid; ?>" class="session occupied<?php print $schedule_grid[$day_key][$slot['nid']][$room_nid]['class']; ?>" colspan="<?php print $schedule_grid[$day_key][$slot['nid']][$room_nid]['colspan']; ?>">
              <?php foreach($schedule_grid[$day_key][$slot['nid']][$room_nid]['sessions'] as $session): ?>
                <div data-tags="<?php print GetSessionTexonomy($session['session']->taxonomy); ?>" class="views-item type-<?php print check_plain($session['session']->type); ?>">
                <?php print $view_results[$session['session']->nid]; ?>
                           
                </div>
              <?php endforeach ?>
              <?php // Room availability if set.
              if (isset($schedule_grid[$day_key][$slot['nid']][$room_nid]['availability'])): ?>
                <div><?php print $schedule_grid[$day_key][$slot['nid']][$room_nid]['availability']; ?></div>
              <?php endif ?>
              <?php // Cell call-to-action if set.
              if (isset($schedule_grid[$day_key][$slot['nid']][$room_nid]['cta'])): ?>
                <div><?php print $schedule_grid[$day_key][$slot['nid']][$room_nid]['cta']; ?></div>
              <?php endif ?>
            <?php // Print a cell if it's not being spanned.
             else: //temp solution to the moving events - Damian 21022015
			 // elseif (!$schedule_grid[$day_key][$slot['nid']][$room_nid]['spanned'] && $show_rooms[$day_key][$room_nid]): ?>	 
              <td class="session empty">&nbsp;
              <?php // Room availability if set.
              if (isset($schedule_grid[$day_key][$slot['nid']][$room_nid]['availability'])): ?>
                <div><?php print $schedule_grid[$day_key][$slot['nid']][$room_nid]['availability']; ?></div>
              <?php endif ?>
              <?php // Cell call-to-action if set.
              if (isset($schedule_grid[$day_key][$slot['nid']][$room_nid]['cta'])): ?>
                <div><?php print $schedule_grid[$day_key][$slot['nid']][$room_nid]['cta']; ?></div>
              <?php endif ?>
            <?php endif ?>
            
            <?php // Only end the table cell if there were items or spanning.
            if (!empty($schedule_grid[$day_key][$slot['nid']][$room_nid]['sessions']) || !$schedule_grid[$day_key][$slot['nid']][$room_nid]['spanned']): ?>
              </td>
            <?php endif ?>
        <?php endforeach ?>
    </tr>
    <?php endforeach ?>
    
    <?php // add night events that technicaly occurs the next day: 
         $nextDay = FindNextKey($days,$day_key);
         $day_key = $nextDay;
         if ($day_key != 0) {
    ?>
    
     <?php foreach ($arranged_slots[$day_key] as $slot): 
        
        $timeslotArray = explode(":", $slot['start']);
        $startHour = intval($timeslotArray[0]);
        if ($startHour > 5) continue;
     ?>
    <tr class="<?php print $zebra = $zebra == 'even' ? 'odd':'even'; ?> <?php print $slot['class']; ?>">
        <td class="time-label"><span class="time-label-wrapper">
          <?php print $slot['start']; ?></span>
        </td>
        <?php foreach ($room_nids as $room_nid): ?>
            <?php // Are there scheduled items to print in this cell?
            if (!empty($schedule_grid[$day_key][$slot['nid']][$room_nid]['sessions'])): ?>
            <?php $arr = array_values($schedule_grid[$day_key][$slot['nid']][$room_nid]['sessions']); ?>
              <td id="<?php print $arr[0]['session']->nid; ?>" class="session occupied<?php print $schedule_grid[$day_key][$slot['nid']][$room_nid]['class']; ?>" colspan="<?php print $schedule_grid[$day_key][$slot['nid']][$room_nid]['colspan']; ?>">
              <?php foreach($schedule_grid[$day_key][$slot['nid']][$room_nid]['sessions'] as $session): ?>
                <div data-tags="<?php print GetSessionTexonomy($session['session']->taxonomy); ?>" class="views-item type-<?php print check_plain($session['session']->type); ?>">
                <?php print $view_results[$session['session']->nid]; ?>           
                </div>
              <?php endforeach ?>
              <?php // Room availability if set.
              if (isset($schedule_grid[$day_key][$slot['nid']][$room_nid]['availability'])): ?>
                <div><?php print $schedule_grid[$day_key][$slot['nid']][$room_nid]['availability']; ?></div>
              <?php endif ?>
              <?php // Cell call-to-action if set.
              if (isset($schedule_grid[$day_key][$slot['nid']][$room_nid]['cta'])): ?>
                <div><?php print $schedule_grid[$day_key][$slot['nid']][$room_nid]['cta']; ?></div>
              <?php endif ?>
            <?php // Print a cell if it's not being spanned.
			else: //temp solution to the moving events - Damian 21022015
            //elseif (!$schedule_grid[$day_key][$slot['nid']][$room_nid]['spanned']): ?>
              <td class="session empty">&nbsp;
              <?php // Room availability if set.
              if (isset($schedule_grid[$day_key][$slot['nid']][$room_nid]['availability'])): ?>
                <div><?php print $schedule_grid[$day_key][$slot['nid']][$room_nid]['availability']; ?></div>
              <?php endif ?>
              <?php // Cell call-to-action if set.
              if (isset($schedule_grid[$day_key][$slot['nid']][$room_nid]['cta'])): ?>
                <div><?php print $schedule_grid[$day_key][$slot['nid']][$room_nid]['cta']; ?></div>
              <?php endif ?>
			 <?php endif ?>
            
            <?php // Only end the table cell if there were items or spanning.
            if (!empty($schedule_grid[$day_key][$slot['nid']][$room_nid]['sessions']) || !$schedule_grid[$day_key][$slot['nid']][$room_nid]['spanned']): ?>
              </td>
            <?php endif ?>
        <?php endforeach ?>
    </tr>
    <?php endforeach ?>
    <?php } ?>
  </table>
  
  <div class="FootNote">
    <?php echo variable_get('cod_schedule_footer_text', '');?>
  </div>
  
  </div>

<?php endforeach ?>
<?php endif ?>

<?php if (variable_get('cod_schedule_show_download_program', '1')) { ?>
    <div class="downloadschedule"> הורד תוכניה כ:
        <span style="display: inline-table;"><a href="<?php print base_path();?>sites/default/files/Program_Olamot_2015.doc">מיקרוסופט וורד (DOC)</a></span>, 
        <span style="display: inline-table;"><a href="<?php print base_path();?>sites/default/files/Program_Olamot_2015.pdf">PDF</a></span>,
	<!--	<span style="display: inline-table;"><a href="<?php print base_path();?>sites/default/files/kipulit_2014-final-for-internet.pdf">תוכניה צבעונית</a></span>,
		<span style="display: inline-table;"><a href="<?php print base_path();?>sites/default/files/Icon2014_brief.pdf">תקצירי האירועים</a></span> -->
    </div>
  <?php } ?>

<script type="text/javascript">
$(function(){
    var tdToRemove = [];
    
    $(".session-calendar").each(function(){
        var rooms = $(this).find("th").length;
        for(roomIndex=2;roomIndex<=rooms;roomIndex++)
        {
            var col = $(this).find("td:nth-child("+roomIndex+")");
            var index = 0;
            while (index < col.length)
            {
                var sameEvents = 0;
                while (col.eq(index + sameEvents).attr("id") == col.eq(index + sameEvents + 1).attr("id")) {
                    tdToRemove.push(col.eq(index + sameEvents + 1)[0]);
                    sameEvents++;
                } 
        
                if (sameEvents>0){
                    col.eq(index).attr("rowspan",sameEvents + 1);
                    index += sameEvents;
                }
                index++;
            }
        }
    });
    
    for (i=0;i<tdToRemove.length;i++){
         $(tdToRemove[i]).remove();
    }
});
</script>

<?php 
function FindNextKey($thearray, $searchkey)
{
    $myarray = $thearray;
    $nextkey = false; 
    $foundit = false; 
    foreach($myarray as $key => $value) { 
        if ($foundit) {$nextkey = $key; break;} 
        if ($key == $searchkey) {$foundit = true;} 
    }
    return $nextkey; 
} 

function GetSessionTexonomy($TexonomyArray)
{
	$termsstring = ' ';
	 foreach($TexonomyArray as $term) {
		$termsstring .= $term->tid . ' ';
	} 
	return $termsstring;
}
?>
