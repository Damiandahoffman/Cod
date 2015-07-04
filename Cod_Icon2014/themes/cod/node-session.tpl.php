
<div style="display:none;">
<?php
$specialEventsArray = array(4628);
$isSpecialEvent = in_array($node->nid, $specialEventsArray , false);
?>
	
</div>

  <div class="content clear-block">
    <div class="sessionheader">
      <div class="sessionpagetitle">
		<?php if(!empty($node->field_track[0]['view'])) { ?>
			<div class=" sessiontrack category category<?php print $node->field_contentcategory[0]['value']?> track<?php print $node->field_track[0]['view']; ?>">
			<?php print $node->field_track[0]['view']; ?>:
			</div>
		<?php } else { ?>
			<div style= "background-color: transparent;" class=" sessiontrack category category<?php print $node->field_contentcategory[0]['value']?> track<?php print $node->field_track[0]['view']; ?>">
			</div>
		<?php } ?>
		</div>
    </div>
    <div class="sessionbody">
        <span class="sessiotitle"><?php print $title ?></span>
        
        <?php
        $lect_names = format_names($node->field_speakers);
        if ($lect_names) {
            print "<div class='sessionspeaker'>".$lect_names."</div>";
        ?>        
        <?php } ?>
        
        <span><?php print $node->content['body']['#value']; ?></span>

        <?php if ($links): ?>
          <div class="links"><?php print $links; ?></div>
        <?php endif; ?>

    </div>
    <div class="sessionmeta">
        <div>
            <?php print $picture ?>
        </div>
        
        <div>
            <span class="sessionmetatitle">יום ושעה</span>
            <span class="sessionmetavalue"><?php 
                print format_dates($node->field_session_slot);
                ?>
            </span>
        </div>
        
        <?php if ($node->field_track[0]['view']) { ?>
        <div>
            <span class="sessionmetatitle">סוג ארוע</span>
            <span class="sessionmetavalue"><?php print $node->field_track[0]['view']; ?></span>
        </div>
        <?php } ?>

        <?php if ($node->field_contentcategory[0]['view']) { ?>
        <div>
            <span class="sessionmetatitle">קטגוריה</span>
            <span class="sessionmetavalue"><?php print $node->field_contentcategory[0]['view']; ?></span>
        </div>
        <?php } ?>

        <?php
        $lect_names = format_names($node->field_speakers);
        if ($lect_names) {	
        ?>        
        <div>
            <span class="sessionmetatitle">מרצים</span>
            <span class="sessionmetavalue"><?php 
               print $lect_names;
                ?></span>
        </div>
        <?php } ?> 

        <?php if ($node->field_session_room[0]['view']) { ?>
        <div>
            <span class="sessionmetatitle">מיקום</span>
            <span class="sessionmetavalue"><?php print $node->field_session_room[0]['view']; ?></span>
        </div>
        <?php } ?>

        <?php if ($node->field_pricegroup[0]['view']) { ?>
        <div>
            <span class="sessionmetatitle">מחיר</span>
            <span class="sessionmetavalue"><?php 
                if ($node->field_pricegroup[0]['value'] == 0)
                {
                    print 'חינם';
                }
				else if ($isSpecialEvent) {
                    print "<b>רגיל:</b> ".$node->field_pricegroup[0]['view'].' ש"ח';
                    print "<br>";
                    print "<b>תעריף עמותות מארגנות:</b> ".($node->field_pricegroup[0]['view']-15).' ש"ח';
				}
                else
                {
                    print "<b>רגיל:</b> ".$node->field_pricegroup[0]['view'].' ש"ח';
                    print "<br>";
				//	Modified for Meorot 2014 - Probably should be a variable from payment module - need to change both here and in the eran.module
	            //    print "<b>תעריף עמותות מארגנות:</b> ".($node->field_pricegroup[0]['view']-5).' ש"ח';
              
                    print "<b>תעריף עמותות מארגנות:</b> ".($node->field_pricegroup[0]['view']-10).' ש"ח';
                }
                ?></span>
        </div>
        <?php } ?>

        <?php if ($node->field_punctures[0]['view']) { ?>
        <div>
            <span class="sessionmetatitle">ניקובים</span>
            <span class="sessionmetavalue"><?php print $node->field_punctures[0]['view']; ?></span>
        </div>
        <?php } ?>
		
        <?php
        $tags = format_tags($node->field_contenttags);
        if ($tags) {	
        ?>        
        <div>
            <span class="sessionmetatitle">תגיות</span>
            <span class="sessionmetavalue"><?php 
               print $tags;
                ?></span>
        </div>
        <?php } ?> 
        
        <?php
        if (user_access('access session edit panels'))
        { ?>
            <div>
                <span class="sessionmetatitle">[מצב פירסום]</span>
                <span class="sessionmetavalue"><?php print ($node->status?'פורסם':'לא פורסם'); ?></span>
            </div>
        <?php 
        } ?>
    </div>
	 <div id="flag_session" style="font-size:25px;">
    <?php print flag_create_link('session_schedule', $node->nid); ?>
	<br>
	<p style="font-size: 12px;"> הסל יתרענן לאחר החזרה לתוכנייה </p>
  </div>
  </div>
</div>
