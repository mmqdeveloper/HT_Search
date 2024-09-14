<?php

add_shortcode('show_time_header','mm_show_time_open_header');
if( !function_exists( 'mm_show_time_open_header' ) ){
	function mm_show_time_open_header(){
		$offset = timezone_offset_get( new DateTimeZone( 'Pacific/Honolulu' ), new DateTime() );
		$num = ($offset >= 0 ) ? '+' : '-';
		$time_zone = $num.(abs( $offset / 3600 ));
		$time_hawaii =date('Y-m-d H:i:s',strtotime($time_zone.' hours',time()));
		$representation  =  date('D',strtotime($time_hawaii));
		$time_now = strtotime($time_hawaii);
		$day = date('Y-m-d',$time_now);
		$time_start = strtotime($day.' 05:00:00');
		$time_end = strtotime($day.' 21:00:00');
		$date = new DateTime("now", new DateTimeZone( 'Pacific/Honolulu' ) );
		if($time_now >= $time_start && $time_now <= $time_end){
			$status = 'OPEN';
		}else{
			$status = 'CLOSED';
		}
		ob_start();
		if( $status == 'OPEN' ){
			?>
			<div class="phone-number">808-379-3701</div>
			<div class="time_open_wrrap open"><span class="now_is">Call Us Now</span></div>
			<?php

		}else{
			?>
<!--			<div class="phone-number">808-379-3701</div>-->
			<div class="time_open_wrrap closed">
				<span class="">GOT A QUESTION?</span>
				<span class="">We are currently</span>
				<span class="">CLOSED</span>
				<a href="/contact-us/">Email Us</a>
			</div>
			<?php
		}

		return ob_get_clean();
	}
}


