<script type="text/javascript" src="sites/all/themes/cod/js/discount.js"></script>

<?php 
global $user;
if (!($user->uid ) )
{
drupal_set_message("אנא התחבר למערכת כדי להזמין כרטיסים",'warning');
drupal_goto('user');
}

if  ($form['#ticketsarr'] == null )
{
drupal_set_message("הסל ריק! לא ניתן לבצע הזמנה",'warning');
drupal_goto('');
}

?>

<?php if (($user->uid == 1 || user_access('access cashier'))) {  ?>
<?php } else { ?>
<?php } ?>
<div style="margin:20px; color:black; font-style:italic; text-align: center; font-weight: bold; font-size: 20px;">
	הזמנת הכרטיסים
</div>

<div style="margin:20px; color:black; text-align: right; font-weight: bold; font-size: 18px;"> 
<?php
// get text from the payment module
 echo(variable_get('tickets_text', ''));  
?> 
</div>
	

<table cellpadding="0" cellspacing="0" border="0" class="AddTicketsTable" >
<tr style="" >
    <th style='text-align:right;'>זמן בקשה</th>
    <th style='text-align:right;'>ארוע</th>
    <th style=''>תאריך</th>
    <th style=''>אולם</th>

    <th style=''>כרטיסים נותרו למכירה<span style=''>*</span></th>
    <th style=''>מחיר</span></th>
    <th style=''> כרטיסים רגילים</th>
    <th style=''>כרטיסים לחברים</th> 
    <th style=" width: 60px;">סה"כ</th>

</tr>
<?php

$i = 0;
if ($form['#ticketsarr'] != null )
{
    foreach ($form['#ticketsarr'] as $ticketitem)
    {
        $sessionNode = node_load($ticketitem->content_id);   		
        $freeTicketsLeft = $sessionNode->signup_status_limit[1]['limit'] - $sessionNode->signup_status_limit[1]['total']; 
        $paidTicketsLeft = $sessionNode->signup_status_limit[2]['limit'] - $sessionNode->signup_status_limit[2]['total']; 
        $sessionLink = l($sessionNode->title,$sessionNode->path);        
        $startTime = date_format_date(SessionStartTime($sessionNode),'custom','l, d/m, H:i' );
		$puncturesIndex = $sessionNode->field_punctures[0]['value'];
		$puncturesValues = content_allowed_values(content_fields('field_punctures'));
		$punctures = $puncturesValues[$puncturesIndex];
		
        $field_session_slot = node_load($sessionNode->field_session_slot[0]['nid']);
        $field_session_room = node_load($sessionNode->field_session_room[0]['nid']);
         $field_pricegroup = content_fields('field_pricegroup');
         $pricegroup_values = content_allowed_values($field_pricegroup);
         if ($sessionNode->field_pricegroup[0]['value'] == 0)
         {
            $paidPrice = 0;
            $memberPrice = 0; 
         }
         else
         {
             $paidPrice = $pricegroup_values[$sessionNode->field_pricegroup[0]['value']];
			 //	Modified for Meorot 2014 - Probably should be a variable from payment module - need to change both here and in the eran.module
             $memberPrice = $paidPrice - 10;
			//	$memberPrice = $paidPrice - 5;
			 
         }
         $cls = ($i%2)?'odd':'even'; 
            
        print "<tr class='$cls'>";    
    
           print "<td style='text-align:right;'>".format_date($ticketitem->timestamp)."</td>";    
           print "<td style='text-align:right;'>$sessionLink</td>";    
           print "<td>".$startTime."</td>";    
           print "<td style=''>".$field_session_room->title."</td>";    
           print "<td style='' class='paidTicketsLeft paidTicketsLeft$paidTicketsLeft'>$paidTicketsLeft</td>";   
           print "<td style=''><span class='RegularPrice'>$paidPrice</span><span class='MemberPrice'>$memberPrice</span>₪</td>";    
           print "<td style=''>".drupal_render($form['paidtickets']["paidticket_$ticketitem->content_id"])."</td>";
           print "<td style=''>".drupal_render($form['paidtickets']["memberpaidticket_$ticketitem->content_id"])."</td>";
           print "<td style=''><span class='LineTotal'></span>₪</td>";      
        print "</tr>";   
        
        $i++; 
    }
}
?>
<tr style="font-weight: bold;border-top:black double 7px; font-size: 14px;">
    <td colspan="7">
		<div class="" style="float:left; width:170px;border: 0px solid black;font-size: 18px;display:none;">
			<?php print drupal_render($form['ismember']); ?> 
		</div>  
	</td>
    <td style="padding-top: 5px;" colspan="1">סה"כ<span id="GroupType"></span>:</td>
    <td style="padding-top: 5px;"><span id="RegularTotal" class="RegularPrice"></span><span id="MemberTotal" class="MemberPrice"></span>₪</td>
</tr>

<tr style="font-weight: bold; font-size: 14px;">
    <td colspan="7">
		<div class="" style="float:left; width:170px;">
			
		</div>
	</td>
    <td style="padding-top: 5px;" colspan="1"> סה"כ לאחר הנחה:</td>
    <td style="padding-top: 5px;"><span id="RegularDiscTotal" class="RegularPrice"></span><span id="MemberDiscTotal" class="MemberPrice"></span>₪</td>
</tr>



</table>

<br />

<?php print drupal_render($form['submit']); ?>
<?php print drupal_render($form); ?>


<span class="DarkButton" style="float:left;">
    <?php print  l('חזרה לתוכניה',''); ?>
</span>

<div style="clear:both; font-size: 14px;"><br/>
	* כמות הכרטיסים הנותרת נכונה לתאריך 
	<?php echo date('H:i:s j/n/Y'); ?>
	</div>


<script type="text/javascript">
    $(function(){
        $(".AddTicketsTable input.form-text:not(:disabled)").each(function(){
            var ticketsleft = $(this).parents("tr").eq(0).find("td.paidTicketsLeft").text();
			if (ticketsleft<0) {ticketsleft = 0};
            $(this).spinner({'min': 0, 'max': ticketsleft});
			 var ticketsleft = $(this).parents("tr").eq(0).find("td.memberpaidTicketsLeft").text();
			if (ticketsleft<0) {ticketsleft = 0};
            $(this).spinner({'min': 0, 'max': ticketsleft});
        });      
        UpdateTotals();
        $(".AddTicketsTable input[id*='paidtickets']").change(function(){
            UpdateTotals();
        });
		
		$(".AddTicketsTable input[id*='memberpaidticket']").change(function(){
            UpdateTotals();
        });
		
        $("input[name='ismember']").click(function(){
            ToggleTicketGroup();
        });
        ToggleTicketGroup();
    });
    
    function ToggleTicketGroup()
    {
        //var group = $('input:radio[name=ismember]:checked').val();
		var group = 0;
        if (group == "1")
        {
            $(".AddTicketsTable .RegularPrice").hide();
            $(".AddTicketsTable .MemberPrice").show();
            $("#GroupType").text('חבר');
        }
        else
        {
            $(".AddTicketsTable .RegularPrice").show();
			$(".AddTicketsTable .MemberPrice").hide();
		 // $("#GroupType").text('רגיל');
        }
        UpdateTotals();
    }
	
		
	function UpdateTotals()
	{
		var totalRegPrice = 0; var totalMemPrice = 0; var totalPunctures = 0;
		
		var RegPrices=new Array(); var MemPrices=new Array();
		
		$("#createtickets-myform table tr").each(function(){
			var regPrice = $(".RegularPrice",this);
			if (regPrice.length == 0)
				return;
				
			var memPrice = $(".MemberPrice",this);
			if (memPrice.length == 0)
				return;

			var ticketsInput = $("input[id*='paidtickets']",this);
			var memberticketsInput = $("input[id*='memberpaidticket']",this);;
			
			
			
			if (ticketsInput.length == 0)
				return;			
		
			var ticketsNum = ticketsInput.val();
			var memberticketsNum = memberticketsInput.val()
			
			if (regPrice.text()>0)
			{
				for (var i=0;i<ticketsNum;i++)
					{
					RegPrices.push(parseInt(regPrice.text()));
					}	
				for (var i=0;i<memberticketsNum;i++)
					{
					MemPrices.push(parseInt(memPrice.text()));
					}	
					
			}
			totalRegPrice += parseInt(regPrice.text()) * ticketsNum + parseInt(memPrice.text())*memberticketsNum;
			$(".LineTotal",this).text(parseInt(regPrice.text()) * ticketsNum + parseInt(memPrice.text())*memberticketsNum);
		});
		
		//set discounts
		
		var Minticket = <?php echo variable_get(Minticket,3); ?>;
		var MinDiscount = <?php echo variable_get(MinDiscount,10); ?>;
	
		RegPrices = RegPrices.concat(MemPrices);
		totalRegPriceDisc = calculatediscounts(RegPrices,Minticket,MinDiscount);
	
		$("#RegularDiscTotal").text(totalRegPriceDisc);
		$("#RegularTotal").text(totalRegPrice);
		$("input[id*='edit-final-price']").val(totalRegPriceDisc);
				
	}

</script>
<style>
#main, .grid16-16 {width:100%;}
.form-radios {margin:0px;}
.form-radios .form-item { width: 60px; float: right; direction:rtl;}
.AddTicketsTable td , .AddTicketsTable th {text-align:center;}
.AddTicketsTable .form-item {text-align:center;}
</style>