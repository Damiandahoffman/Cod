<style type="text/css">
    .pivot_story { border-bottom: 1px solid #202020; color: black; padding: 5px; cursor: default; }
        .pivot_story_delivered{ background-color: #D8EECE; }
        .pivot_story_finished{ background-color: #FFFFEF; }
        .pivot_story_started{ background-color: #F5FFFA; }
        .pivot_story_accepted{ background-color: #F3F3D1; }

        .pivot_title{ margin-bottom: 5px; margin-left: 30px; }

        .pivot_state { color: white; float: left; font-size: 10px; font-weight: bold; margin-left: 10px; padding: 3px; text-align: center; width: 70px; border-radius:4px; display: block; }
            .pivot_state_started { background-color: #58ABD2; border: 1px solid #386E87; }
            .pivot_state_delivered { background-color: #A8253F; border: 1px solid #771B2E; }
            .pivot_state_finished { background-color: #58ABD2; border: 1px solid #386E87; }
            .pivot_state_accepted { background-color: #6A9913; border: 1px solid #48680D;}
    
        .pivot_type { height: 17px; margin: 0px 3px 3px 3px; width: 18px; }
            .pivot_type_feature { background: url("http://www.unknownworlds.com/templates/ns2/images/feature_icon.png") no-repeat scroll left top transparent; display: block; float: right; }

</style>

<?php
 $translate = array('started'=>'התחיל',
                       'finished'=>'הסתיים',
                       'delivered'=>'בבדיקה',
                       'accepted'=>'התקבל',
                       'rejected'=>'נדחה',
                       'feature'=>'תכונה',
                       'bug'=>'באג',
                       'chore'=>'מטלה',
                       'release'=>'הפצה',
                       );
                       
 $projectId = 325477;
    $pt = new PivotalTracker();
    $pt->username = 'keeperoflogic@gmail.com';
    $pt->password = 'Aa123456';   
    $pt->authenticate();
    $project = $pt->projects_get($projectId);
    $stories = $pt->stories_get($projectId);
?>

<div>
    העבודה מתבצעת
</div>

<?php foreach ($stories as $story):?>
    <div class="pivot_story pivot_story_<?php print $story['current_state'] ?> ">
      
      <div>
        <div class="pivot_type pivot_type_<?php print $story['story_type'] ?>" title="<?php print $translate[$story['story_type']] ?>" ></div>
        <div class="pivot_state pivot_state_<?php print $story['current_state']?>"><?php print $translate[$story['current_state']] ?></div>
        <div class="pivot_title">
            <a href="<?php print $story['url'] ?>" title="<?php if(!empty($story['description'])) echo $story['description']; ?>" target="_blank">
                <?php print $story['name'] ?>
            </a>
        </div>
      </div>
      
    </div>
<?php endforeach ?>