<h3>Tạo thể loại</h3>
<hr>
<form action="" method="POST" role="form">
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>">
	<div class="form-group 
		<?php echo form_error('name') ? 'has-error' : '' ?>
	">
		<label for="name">Tên thể loại</label>
		<input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên của thể loại" value="<?php echo $tag->name ?>">
		<?php if (form_error('name')): ?>
			<small class="help-block"><?php echo form_error('name') ?></small>
		<?php endif ?>
	</div>			

	<button type="submit" class="btn btn-default">Cập nhật</button>
</form>    
