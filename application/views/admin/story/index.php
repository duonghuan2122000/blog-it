
<h3>Tất cả truyện</h3>
<hr>

<?php if (!empty($success)): ?>
	<div class="alert alert-success"><?php echo $success; ?></div>
<?php endif ?>

<?php if (!empty($stories)): ?>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>Tên truyện</th>
				<th class="text-center">Tùy chọn</th>
			</tr>
		</thead>
		<tbody>
				<?php foreach ($stories as $s): ?>
					<tr>
						<td><a href="<?php echo base_url('admin/truyen-'.$s->slug.'/danh-sach-chuong') ?>"><?php echo $s->name; ?></a></td>
						<td class="text-center">
							<a href="<?php echo base_url('admin/truyen/chinh-sua-'.$s->slug.'.html') ?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>
							<a href="<?php echo base_url('admin/truyen/xoa-'.$s->slug.'.html') ?>" class="btn btn-default del-story"><i class="fa fa-trash"></i></a>
						</td>
					</tr>
				<?php endforeach ?>
		</tbody>
	</table>
<?php endif ?>
