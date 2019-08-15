<h2>Tác giả <?php echo $stories[0]['author']; ?> <i class="fa fa-pencil"></i></h2>
<hr>

<?php if (!empty($stories)): ?>
	<?php foreach ($stories as $s): ?>
		<!-- List story is recently updated. -->
		<div class="story clearfix">
			<div class="pull-left"><i class="fa fa-chevron-right"></i> <a href="<?php echo base_url('truyen-'.$s['slug']) ?>"><?php echo $s['name']; ?></a></div>
			<div class="pull-right"><?php echo to_time($s['updated_at']) ?></div>
		</div>
		<hr>
		<!-- List story is recently updated. -->
	<?php endforeach ?>
	<?php echo $this->pagination->create_links(); ?>
<?php else: ?>
	Hiện chưa có truyện nào thuộc thể loại này.
<?php endif ?>