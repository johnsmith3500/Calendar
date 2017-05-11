<?php	// calender.php - simple web calender; tested on php 7.0.1
	$months=array(	'January'=>'',
			'February'=>'',
			'March'=>'',
			'April'=>'',
			'May'=>'',
			'June'=>'',
			'July'=>'',
			'August'=>'',
			'September'=>'',
			'October'=>'',
			'November'=>'',
			'December'=>'');	// this array for forming input date form
	$time=time();	// default time (month) - current time
	$year=date('Y');	// default year - current year
	$month=date('n');	// default month - current month
	$current_month=1;	// check if we show current month then show current day blinking
	
	if(!empty($_POST['year']) && !empty($_POST['month']))	// take year and month from input form, if they are 
	{
		$time=strtotime($_POST['month'].' '.$_POST['year']);
		$year=$_POST['year'];
		$months[$_POST['month']]='selected';
		$current_month=0;
	}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Calender</title>
	<link rel="stylesheet" href="styles.css">
	<h1>Calender</h1>
</head>
<body>
<!-------------------------------INPUT FORM BEGIN---------------------------------------------->
	<form method="POST">
		<p>Enter year: <input type="text" name="year" size="4" value="<?= $year ?>"></p>
		<p>Choose month:  <select name="month">
					<?php
					foreach($months as $key => $value)
						print '<option value="'.$key.'" '.$value.'>'.$key.'</option>'."\n";
					?>
					</select></p>
		<input type="submit" value="Show">
	</form>
<!-------------------------------INPUT FORM END------------------------------------------------>
	
	<pre>
	<?php
// horizontal version
	function get_wday1($mday, $wday)	// function calculate day of week of 1st day in the month; return 1..7
	{
		$retval=$wday-($mday-floor($mday/7)*7)+1;
		return $retval;
	}
	$date=date('j:N:t', $time);
	sscanf($date, "%d:%d:%d", $mday, $wday, $tdays); // $mday - this day of month; $wday - this day of week; $tdays - number of days in this month
	$wday1=get_wday1($mday, $wday); // get day of week from which starts this month
	print '<table>';
	$day=1;
	$week=1;
	while($day<=$tdays)
	{
		print '<tr>';
		for($i=1; $i<=7; $i++)
		{
			print '<td bgcolor="'.($i>5 ? 'darkred' : '').'">';
			if($i<$wday1 && $week==1)	// fill first week with ' '
			{
				print ' ';
			}
			else if($day<=$tdays)
			{
				if($day==$mday && $current_month) // today day
				{
					print '<span class="blink">';
				}
				printf("%2d", $day);
				if($day==$mday && $current_month) // today day
				{
					print '</span>';
				}
				$day++;
			}
			else			// fill last week with ' '
			{
				print ' ';
			}
			print '</td>';
		}
		print '</tr>'."\n";
		$week++;
	}
	print '</table>';
	
// vertical version
	// calculate number of weeks(full and not full) in this month
	$weeks=floor($tdays/7);	// number of full weeks
	$rem=$tdays%7; // number of days out of full week
	if($rem>0)
	{
		if($wday1+$rem>7)
		{
			$weeks+=2;
		}
		else
		{
			$weeks+=1;
		}
	}
	$startday=2-$wday1;	// what number is monday (may be negative)
	print '<br><table>';
	for($i=$startday; $i<=$startday+6; $i++)
	{
		print '<tr>';
		for($j=0; $j<$weeks; $j++)
		{
			print '<td bgcolor="'.($i<($startday+5) ? '' : 'darkred').'">';
			if(($i+$j*7)<1 || ($i+$j*7)>$tdays)	// ($i+$j*7) - current day
			{
				print ' ';
			}
			else
			{
				if($i+$j*7==$mday && $current_month) // today day
				{
					print '<span class="blink">';
				}
				printf("%2d", $i+$j*7);
				if($i+$j*7==$mday && $current_month) // today day
				{
					print '</span>';
				}
			}
			print '</td>';
		}
		print '</tr>'."\n";
	}
	print '</table>';
	?>
	</pre>
</body>
</html>	
