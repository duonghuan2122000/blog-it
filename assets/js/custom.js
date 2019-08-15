$(function(){
	$('.del-story').click(function(){
		var conf = confirm('Xóa truyện đồng nghĩa với việc không thể khôi phục. Bạn có chắc muốn xóa không ?');
		if(!conf){
			return false;
		}
		return true;
	});
	$('.del-tag').click(function(){
		var conf = confirm('Xóa thể loại đồng nghĩa với việc không thể khôi phục. Bạn có chắc muốn xóa không ?');
		if(!conf){
			return false;
		}
		return true;
	});
});