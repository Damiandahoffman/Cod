<?php
// $Id: page.tpl.php 7156 2010-04-24 16:48:35Z chris $
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>">

<head>
  <title><?php print $head_title; ?></title>
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
 

  <style>
    html, body {margin: 0pt; padding: 0pt;}
    body{direction: rtl;}
    .views-hide, #admin-menu, #admin-toolbar {display: none !important;}
    .freegreen, .paidgreen {}
    .freeorange, .paidorange {background-color: orange !important;}
    .freered,.paidred  {background-color: red !important;}
    .currentdate {background-color: yellow !important;}
  </style>
  <script>
    var starttime = null;
    $(function(){
       starttime =new Date();
       startTime();
    });
    
    function startTime()
    {
        var today = new Date();
        var diff = today - starttime;
        
        var h=parseInt(diff/(1000*3600));
        var m=parseInt( (diff/(1000*60))%3600 );
        var s=parseInt( (diff/(1000))%60 );
        // add a zero in front of numbers<10
        m=checkTime(m);
        s=checkTime(s);
        $("#timer").text(h+":"+m+":"+s);
        t=setTimeout('startTime()',500);
    }
        
    function checkTime(i)
    {
        if (i<10)
          {
          i="0" + i;
          }
        return i;
    }
  </script>
</head>

<body id="<?php print $body_id; ?>" onload="" >

<div style="">
<div style="text-align: center;margin-top: 50px;">
<h2>מצב כרטיסים</h2>
<div style="font-size: 14px;" >עודכן לאחרונה לפני <span style="font-weight: bold; color:green;" id="timer">0</span> שניות. לעדכון יש  <a href="javascript:location.href=location.href"> לטעון מחדש את הדף</a></div>
</div>

<table style="margin: 30px auto; vertical-align: top; text-align: center; width: 100%; max-width: 1000px;font-size: 1.5em;" cellpadding="3" cellspacing="0" border="1">
    <tr>
        <th>#</th>
        <th>ארוע</th>
        <th>מועד התחלה</th>
        <th style="width: 10px;">מכסה חינם</th>
        <th style="width: 10px;">מכסה תשלום</th>
        <th style="width: 10px;">נמכרו חינם</th>
        <th style="width: 10px;">נמכרו תשלום</th>
    </tr>
<?php 



    function my_array_search($needle, $haystack) {
        if (empty($needle) || empty($haystack)) {
            return null;
        }
        foreach ($haystack as $key => $value) {
            if ($value['nid'] == $needle) return $key;
        }
        return null;
    }

    $sessions = $_SESSION['sessions'];
   
   //var_dump($sessions);
	//$type = 'session';
	
	//$sessions =  db_query('SELECT nid FROM {node} WHERE type="%s"', $type); //Probably much saner. Damian 04102014
	
	
	
    $currentDateFound = 0;
    $currentDate = new DateTime;
    
    $table = array();
    foreach ($sessions as $i=>$session) {
        //find if this session already in table, if so update the record
        $key = my_array_search($session->nid, $table);
        if ($key !== null)
        {
            $table[$key]["total$session->status"] = $session->total;
        }
        else
        {
            //create new row
            $row = array();
            $row['nid'] = $session->nid;
            $row['title'] = $session->title;
            $row['startdate'] = date_format_date($session->startdate,'custom','l, d/m, H:i' );
            $row['freelimit'] = $session->freelimit;
            $row['paidlimit'] = $session->paidlimit;
            $row["total$session->status"] = $session->total;
            if (($currentDateFound == 0) && ($currentDate < $session->startdate))
            {
                $row['currentdate'] = 'currentdate';
                $currentDateFound = 1;
            }
            $table[] = $row;
        }
    }
    
    $freelimittotal = 0;
    $paidlimittotal = 0;
    $freetotal = 0;
    $paidtotal = 0;
    
    foreach ($table as $i=>$tablerow) {
    $cls = ($i%2)?'odd':'even';
    $freeleft = intval($tablerow['freelimit']) - intval($tablerow['total1']);
    $paidleft = intval($tablerow['paidlimit']) - intval($tablerow['total2']);

    $freeclass = 'freegreen';
    if ($freeleft <= 0)
    {
        $freeclass = 'freered';
    }
    else if ($freeleft <= 4)
    {
        $freeclass = 'freeorange';
    }   

    $paidclass = 'paidgreen';
    if ($paidleft <= 0)
    {
        $paidclass = 'paidred';
    }
    else if ($paidleft <= 4)
    {
        $paidclass = 'paidorange';
    }   
    $freelimittotal += $tablerow['freelimit'];
    $paidlimittotal += $tablerow['paidlimit'];
    $freetotal += $tablerow['total1'];
    $paidtotal += $tablerow['total2'];
    
?>
    <tr class="<?php print $cls?>">
        <td class="<?php print $tablerow['currentdate'];?>" ><?php print $i+1; ?></td>
        <td class="<?php print $tablerow['currentdate'];?>" style="text-align: right;"> <?php print l($tablerow['title'],'node/'.$tablerow['nid']) ?></td>
        <td class="<?php print $tablerow['currentdate'];?>"><?php print $tablerow['startdate']; ?></td>
        <td class="<?php print $freeclass;?>"><?php print $tablerow['freelimit'] ?></td>
        <td class="<?php print $paidclass;?>"><?php print $tablerow['paidlimit'] ?></td>
        <td class="<?php print $freeclass;?>"><?php print $tablerow['total1'] ?></td>
        <td class="<?php print $paidclass;?>"><?php print $tablerow['total2'] ?></td>
        
    </tr>
<?php 
    }
?>
    <tr style="font-weight: bold; font-style: italic;">
        <td colspan="2"> </td>
        <td> סה"כ </td>
        <td><?php print $freelimittotal ?></td>
        <td><?php print $paidlimittotal ?></td>
        <td><?php print $freetotal ?></td>
        <td><?php print $paidtotal ?></td>
    </tr>
</table>
<table style="margin: 30px auto; vertical-align: top; text-align: center;width:auto;" cellpadding="3" cellspacing="0" border="1">
    <tr>
        <td>מקרא:</td>
        <td class="freeorange">פחות מ-5 כרטיסים נותרו</td>
        <td class="freered">לא נותרו כרטיסים</td>
        <td class="currentdate">הארועים הבאים</td>
    </tr>
</table>
</div>
</body>
</html>
