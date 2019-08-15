<h3>Tất cả thể loại</h3>
<hr>
<?php if (!empty($success)): ?>
	<div class="alert alert-success"><?php echo $success; ?></div>
<?php endif ?>
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>Thể loại</th>
			<th class="text-center">Tùy chọn</th>
		</tr>
	</thead>
	<tbody>
		<?php if (!empty($tags)): ?>
			<?php foreach ($tags as $t): ?>
				<tr>
					<td><?php echo $t->name; ?></td>
					<td class="text-center">
						<a href="<?php echo base_url('admin/the-loai/chinh-sua-'.$t->slug.'.html') ?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>
						<a href="<?php echo base_url('admin/the-loai/xoa-'.$t->slug.'.html') ?>" class="btn btn-default del-tag"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
			<?php endforeach ?>
		<?php endif ?>
	</tbody>
</table>