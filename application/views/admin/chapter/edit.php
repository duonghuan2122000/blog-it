
    <h3>Cập nhật chương</h3>
	<hr>
	<?php if (!empty($success)): ?>
		<div class="alert alert-success"><?php echo $success; ?></div>
	<?php endif ?>
	<form action="" method="POST" role="form">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>">
		<div class="form-group
			<?php echo form_error('num') ? 'has-error' : '' ?>
		">
			<label for="chapter">Chương</label>
			<input type="number" class="form-control" name="num" id="chapter" placeholder="Nhập số chương của truyện" value="<?php echo $chapter->num; ?>">
			<?php if (form_error('num')): ?>
				<small class="help-block"><?php echo form_error('num') ?></small>
			<?php endif ?>
		</div>

		<div class="form-group">
			<label for="name_chapter">Tên chương</label>
			<input type="text" class="form-control" id="name_chapter" name="name" placeholder="Nhập tên của chương truyện nếu có" value="<?php echo $chapter->name; ?>">
		</div>			
		
		<div class="form-group
			<?php echo form_error('content') ? 'has-error' : '' ?>
		">
			<label for="content">Nội dung</label>
			<textarea id="content" name="content"><?php echo $chapter->content; ?></textarea>
			<?php if (form_error('content')): ?>
				<small class="help-block"><?php echo form_error('content') ?></small>
			<?php endif ?>
		</div>

		<div class="form-group
			<?php echo form_error('story') ? 'has-error' : '' ?>
		">
			<label for="chapter">Tên truyện</label>
			<?php if (!empty($stories)): ?>
				<select name="story" id="story" class="form-control">
					<option value="">Vui lòng chọn tên truyện.</option>
					<?php foreach ($stories as $s): ?>
						<option value="<?php echo $s->id; ?>"
							<?php echo ($story->id === $s->id) ? 'selected': ''; ?>
						><?php echo $s->name; ?></option>
					<?php endforeach ?>
				</select>
			<?php else: ?>
				Hiện chưa có truyện. Vui lòng thêm truyện.
			<?php endif ?>
			<?php if (form_error('story')): ?>
				<small class="help-block"><?php echo form_error('story') ?></small>
			<?php endif ?>
		</div>

		<button type="submit" class="btn btn-default">Cập nhật</button>
	</form>