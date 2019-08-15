<?php 
if(!function_exists('to_control')){
	function to_control($chapters, $num, $slug){
		if(empty($chapters)){
			return;
		}
		$prev = '';
		$next = '';
		$select = '<select class="btn btn-default btn-sm" data-url="'.base_url('truyen-'.$slug.'/chuong-(:num).html').'">';
		foreach ($chapters as $k => $c) {
			$select .= '<option value="'.$c['num'].'"';
			if($c['num'] == $num){
				if(isset($chapters[$k-1])){
					$prev .= '<a href="'.base_url('truyen-'.$slug.'/chuong-'.$chapters[$k-1]['num'].'.html').'" class="btn btn-default btn-sm url_prev">Chương trước</a>';
				}
				if(isset($chapters[$k+1])){
					$next .= '<a href="'.base_url('truyen-'.$slug.'/chuong-'.$chapters[$k+1]['num'].'.html').'" class="btn btn-default btn-sm url_prev">Chương tiếp theo</a>';
				}
				$select .= 'selected';
			}
			$select .= '>Chương '.$c['num'].'</option>';
		}
		$select .= '</select>';
		return $prev.$select.$next;
	}
}
 ?>
