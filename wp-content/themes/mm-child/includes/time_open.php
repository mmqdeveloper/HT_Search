<?php

add_shortcode('show_time_open','show_time_open_press');
function show_time_open_press(){
	$offset = timezone_offset_get( new DateTimeZone( 'Pacific/Honolulu' ), new DateTime() );
	$num = ($offset >= 0 ) ? '+' : '-';
	$time_zone = $num.(abs( $offset / 3600 ));
	$time_hawaii =date('Y-m-d H:i:s',strtotime($time_zone.' hours',time()));
	$representation  =  date('D',strtotime($time_hawaii)); 
	$time_now = strtotime($time_hawaii); 
	$day = date('Y-m-d',$time_now);
	$time_start = strtotime($day.' 5:00:00'); 
	$time_end = strtotime($day.' 21:00:00');
	$date = new DateTime("now", new DateTimeZone( 'Pacific/Honolulu' ) );
	if($time_now >= $time_start && $time_now <= $time_end){   
		$status = 'OPEN';
	}else{ 
		$status = 'CLOSED';
	}
	ob_start();
	?>
		<div class="time_open_wrrap <?php print_r($date->format('Y-m-d H:i:s')); ?> ">
			<span class="now_is">Now is:</span>
			<span class="time_<?php echo strtolower($status);?>"><?php echo $status; ?></span>
		</div>
	<?php
	return ob_get_clean();
} 
