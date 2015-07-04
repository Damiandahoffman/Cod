<div class="profileheader">
    <div style="font-size: 60px; font-weight: bold; font-style: italic;" >פרטי חבר</div>
    <div style="margin-top: 10px; "></div> 
</div>
<div class="profilebody" id="registration_form">

  <div class="fieldtitle">שם:</div> 
   <div class="fieldvalue"><?php print $content_profile->get_variable('profile', 'realname'); ?></div>

  <div class="fieldtitle">דואר:</div>
  <div class="fieldvalue"><?php print $account->mail; ?></div>

  <div class="fieldtitle">תפקיד:</div> 
  <div class="fieldvalue"><?php print implode(',',array_slice($account->roles,1)); ?></div>

  <div>
    <br /><br />
    <?php print l("עדכון פרטים וסיסמה","user/$content_profile->uid/profile/profile"); ?>
    <br /><br />
    <a href="/cod">חזרה לתוכניה</a>
  </div>
   <div class="" style="font-size: 12px; font-weight: normal;">
      <?php print $profile['login_one_time']; ?>
  </div>
</div>
<div style="clear: both;"> </div>