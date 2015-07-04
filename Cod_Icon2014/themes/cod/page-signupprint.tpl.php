<?php
// $Id: page.tpl.php 7156 2010-04-24 16:48:35Z chris $
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>">

<head>
  <title><?php print $head_title; ?></title>
  <?php print $scripts; ?>
 

  <style>
    html, body {margin: 0pt; padding: 0pt;}
    .views-hide, #admin-menu, #admin-toolbar {display: none;}
    .page-break  { display:block; page-break-after:always; }
	.logo {text-align:center;}
    .PrintTickets { background-repeat: no-repeat; overflow:hidden;  direction: rtl; }
	.title {font-size: 16pt;font-weight:bold;}
	.lecturer {font-size: 14pt;margin-bottom:10pt;}
	.roomandtimeslot {font-size: 14pt;}
	.price {font-size: 14pt;}
	.ticketnumber {font-size: 12pt; font-style:italic;margin-top:2pt; text-align:center;}
	.disclaimer {font-size: 10pt;border-top: 2px solid black; margin-top: 8px; padding-top: 2px;}
  </style>
</head> 

<body id="<?php print $body_id; ?>">
<div style="width:194pt;">
<?php 
    if ($_SESSION['ticketsarr'] != null)
    { ?>
     <script>
    $(function(){
        window.print();
        window.close();
    });
    
  </script>
    <?php
		global $base_url;
        $i=0; 
        $ticketsarr = $_SESSION['ticketsarr'];
        $totaltickets = count($ticketsarr);
        foreach ($ticketsarr as $ticketind => $ticket) {
            $i++;
            ?>
            
            <div class='PrintTickets'>
				<br/>
				<div class="logo">
				<img src="<?php echo $base_url.'/'.path_to_theme(). '/images/' .variable_get('ticket_logo', '') ?>" style="width:148pt;" />
					<br/>
				</div>
				<div class="title"> <?php print $ticket['session'] ?> </div>
				<div class="lecturer"> 
					<?php 
                            $st = '';
                            foreach ($ticket['lectures'] as $lect) {
                                $st .= $lect.', ';
                            }
                            $st = substr_replace($st,'',strrpos($st,','),1);
                            print $st;
                                 ?>
				</div>
				<div class="roomandtimeslot">
				   <?php if ($ticket['room'] != '') {print $ticket['room'].' | ';}?><?php print $ticket['timeslot']?>
				</div>
				<div class="price">
					<?php 
							if ($ticket['price'] == 'חינם') {print 'חינם';} else { ?>
							מחיר: <?php print $ticket['price'];?> ש"ח
							<? }?>	
					<?php if ($ticket['status']=="1") 
							{print '<br>כרטיס חינם';} 
							else {			
								if ($ticket['member']==1) 
								{echo('<br>הנחת חבר'); }
								}
					 ?>
				</div>
				<div class="ticketnumber">&nbsp; מס' כרטיס: <?php print $ticket['sid']?></div>
				<div class="disclaimer">
					<?php echo variable_get('ticket_footer', '');?>
				</div> 
				<div><br/><br/><br/><br/><br/>.</div>
            </div>
            <div class='page-break'> </div>
            <?php
        }
    }
    else
    {
        print $content;
    }
?>

<script>//;</script>
</div>
</body>
</html>
