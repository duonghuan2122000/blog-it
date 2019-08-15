
<h3>Danh sách chương của truyện <?php echo $story->name; ?></h3>
<hr>
<?php if (!empty($success)): ?>
	<div class="alert alert-success">
		<?php echo $success; ?>
	</div>
<?php endif ?>
  
<?php if (!empty($chapters)): ?>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>Chương</th>
				<th class="text-center">Tùy chọn</th>
			</tr>
		</thead>
		<tbody>
				<?php foreach ($chapters as $c): ?>
					<tr>
				    	<?php if (!empty($c->name)): ?>
				    		<td><a href="">Chương <?php echo $c->num; ?>: <?php echo $c->name; ?></a></td>
						<?php else: ?>
							<td><a href="">Chương <?php echo $c->num; ?></a></td>
				    	<?php endif ?>
						<td class="text-center">
							<a href="<?php echo base_url('admin/truyen-'.$story->slug.'/chinh-sua-chuong-'.$c->num.'.html') ?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>
							<a href="<?php echo base_url('admin/truyen'.$story->slug.'/xoa-chuong-'.$c->num.'.html') ?>" class="btn btn-default del-chapter"><i class="fa fa-trash"></i></a>
						</td>
					</tr>
				<?php endforeach ?>
		</tbody>
	</table>
	<?php echo $this->pagination->create_links(); ?>
<?php else: ?>
	<h4>Hiện chưa có chương nào của truyện này.</h4>
<?php endif ?>