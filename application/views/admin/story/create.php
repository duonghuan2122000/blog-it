
<h3>Thêm truyện</h3>
<hr>
<form action="" method="POST" role="form" enctype="multipart/form-data">
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>">
	<div class="form-group 
		<?php echo form_error('name') ? 'has-error' : '' ?>
	">
		<label for="name">Tên truyện</label>
		<input type="text" class="form-control" name="name" id="name" placeholder="Nhập tên của truyện" value="<?php echo set_value('name') ?>">
		<?php if (form_error('name')): ?>
			<small class="help-block"><?php echo form_error('name') ?></small>
		<?php endif ?>
	</div>

	<div class="form-group">
		<label for="author">Tác giả (nếu có)</label>
		<input type="text" class="form-control" name="author" id="author" placeholder="Nhập tên của tác giả" value="<?php echo set_value('author') ?>">
	</div>

	<div class="form-group">
		<label for="img">Ảnh đại diện (nếu có)</label>
		<input type="file" class="form-control" id="img" name="img" placeholder="Chọn ảnh đại diện nếu cần">
	</div>			
	
	<div class="form-group">
		<label for="description">Tóm tắt</label>
		<textarea id="description" name="description"><?php echo set_value('description') ?></textarea>
	</div>

	<div class="form-group">
		<label for="tags">Thể loại</label>
		<input type="text" id="tags" name="tags" class="form-control" value="<?php echo set_value('tags') ?>">
	</div>			

	<button type="submit" class="btn btn-default">Cập nhật</button>
</form>

