<?php
	if ($form['#action'] == '/cod/admin/user/user/create')
    {
        $form['account']['mail']['#default_value'] = ''; 
        
        print drupal_render($form['account']['mail']);
        print drupal_render($form['field_first_name']);
        print drupal_render($form['field_last_name']);
        print drupal_render($form['account']['status']);
        print drupal_render($form['account']['roles']);
        print drupal_render($form['account']['pass']);
        print drupal_render($form['account']['notify']);
        print drupal_render($form);
    }
    else
    {
?>
<div class="registrationheader">
    <div style="font-size: 60px; font-weight: bold; font-style: italic;" >הרשמה</div>
    <div style="margin-top: 10px; ">הכנס כתובת דואר, שם פרטי ומשפחה. הסיסמה תשלח לכתובת שציינת.</div> 
</div>
<div class="registrationbody" id="registration_form">
  <div class="user field">
    <?php
	  print drupal_render($form['field_first_name']);
      print drupal_render($form['field_last_name']);
	  print drupal_render($form['mail']); // prints the username field
    ?>
  </div> 
  <div class="submit_field">
    <?php
        print drupal_render($form['submit']); // print the submit button
		print drupal_render($form); // print the submit button
	?>
  </div>
  </div>
<div class="registrationmeta">
   <!-- <div class="registrationmetanumbers"> </div> -->
    <div class="registrationmetatext">
        <div style="margin-top: 0px;">הירשם, קבל סיסמה לכתובת המייל והתחבר למערכת.</div>
        <div style="margin-top: 80px;">בחר ארועים מלוח הזמנים, ניתן להזמין יותר מכרטיס אחד במועד התשלום.</div>
    </div>
    <!-- <div class="registrationmetadiagram"> 
        <div class="registrationmetacall">
            <div style="padding:0px 10px;text-align: center; color:white">
                        <div style="float:right;width:130px;margin-left:1px;margin-right:20px;">
                        
                        <span style="font-size: 18px; font-weight: bold;line-height: 1.2;">
                        
                        </span>
                        </div>
                        <div class="callcenter"></div>
                        <div style="clear:both;"></div>
					</div>
        </div>
    </div> -->
    <div style="clear: both;"> </div>
</div>
<div style="clear: both;"> </div>
<?php
	}
?>