<h2><i class="fa fa-chevron-right"></i> Thông tin truyện: <?php echo $story->name; ?></h2>
<hr>

<div class="col-sm-4">
	<img src="<?php echo $story->img ? base_url('assets/img/'.$story->img) : base_url('assets/img/default.png') ?>" alt="<?php echo $story->name; ?>" class="img-responsive">
	<hr>
	<p><b>Tác giả: </b>
		<?php if ($story->author): ?>
			<a href="<?php echo base_url('tac-gia-'.$story->author_slug) ?>"><?php echo $story->author; ?></a>
		<?php else: ?>
			<?php echo 'Đang cập nhật'; ?>
		<?php endif ?>
	</p>
	<p><b>Thể loại: </b>
		<?php foreach ($tags as $t): ?>
			<a href=""><?php echo $t['name']; ?></a>
		<?php endforeach ?>
	</p>
	<p><b>Trạng thái: </b><?php echo $story->status == 1 ? 'Đang ra' : 'Full'; ?></p>
	<?php if (!empty($chapters)): ?>
		<p>
			<a href="<?php echo base_url('truyen-'.$story->slug.'/chuong-'.$chapter_first->num.'.html'); ?>" class="btn btn-default btn-sm">Đọc chap đầu</a>
			<a href="<?php echo base_url('truyen-'.$story->slug.'/chuong-'.$chapter_last->num.'.html'); ?>" class="btn btn-default btn-sm">Đọc chap mới nhất</a>

		</p>
	<?php endif ?>

</div>
<div class="col-sm-8">
	<h4>Tóm tắt: </h4>
	<p>
		<?php echo $story->description ? $story->description : 'Đang cập nhật'; ?>
	</p>
</div>

<div class="clearfix"></div>

<h3><i class="fa fa-list"></i> Danh sách chương</h3>

<?php if (!empty($chapters)): ?>
	<!-- List chapter -->
	<?php foreach ($chapters as $c): ?>
		<div class="col-sm-6 clearfix">
			<div class="pull-left"><a href="<?php echo base_url('truyen-'.$story->slug.'/chuong-'.$c->num.'.html') ?>">
				<?php if ($story->name): ?>
					Chương <?php echo $c->num; ?>: <?php echo $c->name; ?>
				<?php else: ?>
					Chương <?php echo $c->num; ?>
				<?php endif ?>
			</a></div>
			<div class="pull-right"><i class="fa fa-eye"></i> <?php echo $c->view ? number_format($c->view) : 0 ?> lượt xem</div>
			<hr>
		</div>
	<?php endforeach ?>
	<!-- List chapter -->

	<?php echo $this->pagination->create_links(); ?>
<?php else: ?>
	Đang cập nhật
<?php endif ?>
<hr>

<div id="disqus_thread"></div>
<script>

/**
*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
/*
var disqus_config = function () {
this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};
*/
(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');
s.src = 'https://http-blogtruyen-byethost11-com.disqus.com/embed.js';
s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>