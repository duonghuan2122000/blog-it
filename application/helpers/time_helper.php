<?php 
if (!function_exists('to_time')) {
	function to_time(int $time)
	{
		$ago = time() - $time;
		if($ago < 60){
			return date('s', $ago).' giây trước';
		}
		if($ago < 3600){
			return date('i', $ago).' phút trước';
		}

		if($ago < 86400){
			return date('H', $ago).' giờ trước';
		}

		if($ago < 86400 * 7){
			return date('d', $ago).' ngày trước';
		}

		return 'Ngày '.date('d - m - Y', $time);
	}
}
 ?>