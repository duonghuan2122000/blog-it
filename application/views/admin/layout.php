<!DOCTYPE html>
<html lang="en">

<head>
	<?php $this->load->view('admin/head') ?>
	<title><?php echo $title; ?> - Admin</title>
	<?php if (isset($script_story) && $script_story): ?>
		<link rel="stylesheet" href="<?php echo base_url('assets/css/summernote.css') ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/tagsinput.css') ?>">
	<?php endif ?>

	<?php if (isset($script_chapter) && $script_chapter): ?>
		<link rel="stylesheet" href="<?php echo base_url('assets/css/summernote.css') ?>">
	<?php endif ?>
	
</head>

<body>

	<?php $this->load->view('admin/sidebar') ?>

	
	<div class="col-sm-offset-3 col-sm-9">
		<?php $this->load->view('admin/'.$temp) ?>
	</div>

	<!-- jQuery Plugins -->
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
	<?php if (isset($js_tag) && $js_tag): ?>
		<script type="text/javascript">
			$(function(){
				$('.del-tag').click(function(){
					var conf = confirm('Bạn vừa nhấn hành động xóa thể loại. Xóa thể loại sẽ không thể khôi phục. Bạn có chắc chắn muốn xóa không ?');
					if(!conf){
						return false;
					} else {
						return true;
					}
				});
			});
		</script>
	<?php endif ?>

	<?php if (isset($script_story) && $script_story): ?>
		<script type="text/javascript" src="<?php echo base_url('assets/js/summernote.min.js') ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/typeahead.js') ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/tagsinput.js') ?>"></script>
		<script type="text/javascript">
	    	$(function(){
				$('#description').summernote({
					lang: 'vi-VN',
					placeholder: 'Nhập tóm tắt cho truyện'
				});

				$('#tags').tagsinput({
					typeahead: {
						url: '<?php echo base_url('tag/getjson') ?>',
						addOther: false
					}
				});
				$('.del-story').click(function(){
					var conf = confirm('Xóa truyện sẽ không thể khôi phục. Bạn có chắc muốn xóa ?');
					if(!conf)
					{
						return false;
					} else {
						return true;
					}
				});
			});
	    </script>
	<?php endif ?>

	<?php if (isset($script_chapter) && $script_chapter): ?>
		<script type="text/javascript" src="<?php echo base_url('assets/js/summernote.min.js') ?>"></script>
		<script type="text/javascript">
	    	$(function(){
	    		$('#content').summernote({
	    			lang: 'vi-VN',
	    			placeholder: 'Nhập nội dung của chương'
	    		});

	    		$('.del-chapter').click(function(){
	    			var conf = confirm('Bạn đang thực hiện hành động xóa chương. Bạn có chắc chắn muốn tiếp tục ?');
	    			if(!conf){
	    				return false;
	    			} else {
	    				return true;
	    			}
	    		});
	    	});
	    </script>
	<?php endif ?>
</body>

</html>
