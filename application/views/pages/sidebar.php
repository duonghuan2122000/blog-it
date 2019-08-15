<div class="col-sm-3 bg">
	<h2>Truyện hot <i class="fa fa-fire"></i></h2>
	<hr>
	<ol>
		<?php foreach ($hotStories as $s): ?>
			<li><a href="<?php echo base_url('truyen-'.$s->slug) ?>"><?php echo $s->name; ?></a></li>
			<hr>
		<?php endforeach ?>
	</ol>
</div>