<?php print '<style>
			#pid-volunteer-shift tr.odd td ,th,td,thead, tr.even,tr.even td,td {background-color:white;border: 2px solid;font-size: 14px;}
			#pid-volunteer-shift .tablegroup-item{border: 2px solid;font-size: 14px;text-align: center;}
			#pid-volunteer-shift tr.odd, tr.odd td { background-color: white; }
			#pid-volunteer-shift tr.even, tr.even td {background-color: white; }
			#pid-volunteer-shift .view-content a, a:link, a:visited {color:blue;}
			#pid-volunteer-shift table td {max-width:120px;}
			</style>'; ?>


<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php print $table; ?>


<?php print '<script type="text/javascript"> 
			$(function(){
			var y = document.getElementsByClassName("tablegroup-item");
			for	(index = 0; index < y.length; index++) {
				var status = y[index].children[0].children[0].innerHTML;
				switch (status) {
					case "המשמרת אושרה":
						y[index].style.background= "#00CC00";
						break;
					case "לא שובץ מתנדב":
						y[index].style.background= "#CC0000";
						break;
					case "ממתין לאישור מתנדב":
						y[index].style.background= "#CCCC00";
						break;
					case "לא נדרש מתנדב":
						y[index].style.background= "#800080";
						break;
					}
			}
				})
				</script>'; ?>