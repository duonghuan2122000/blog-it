<h2>Kết quả tìm kiếm cho: <?php echo $search; ?> <i class="fa fa-pencil"></i></h2>
<hr>

<?php if (!empty($stories)): ?>
	<?php foreach ($stories as $s): ?>
		<!-- List story is recently updated. -->
		<div class="story clearfix">
			<div class="pull-left"><i class="fa fa-chevron-right"></i> <a href="<?php echo base_url('truyen-'.$s->slug) ?>"><?php echo $s->name; ?></a></div>
			<div class="pull-right"><?php echo to_time($s->updated_at) ?></div>
		</div>
		<hr>
		<!-- List story is recently updated. -->
	<?php endforeach ?>
<?php else: ?>
	Hiện chưa có truyện nào cho kết quả tìm kiếm này.
<?php endif ?>