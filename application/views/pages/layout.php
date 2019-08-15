<!DOCTYPE html>
<html lang="en">

<head>
	<?php $this->load->view('pages/head') ?>
	<title><?php echo $title; ?> - BlogTruyen</title>
</head>

<body>

	<div class="container">

		<!-- navbar -->
		<?php $this->load->view('pages/header') ?>
		<!-- navbar -->

		<!-- breadcrumb -->
		<?php if (isset($breadcrumb_story) && $breadcrumb_story): ?>
			<ol class="breadcrumb">
			  <li><a href="<?php echo base_url('') ?>">Trang chủ</a></li>
			  <li><?php echo $story->name; ?></li>
			</ol>
		<?php endif ?>

		<?php if (isset($breadcrumb_chapter) && $breadcrumb_chapter): ?>
			<ol class="breadcrumb">
			  <li><a href="<?php echo base_url('') ?>">Trang chủ</a></li>
			  <li><a href="<?php echo base_url('truyen-'.$story->slug) ?>"><?php echo $story->name; ?></a></li>
			  <li class="active">Chương <?php echo $chapter->num; ?></li>
			</ol>
		<?php endif ?>

		<div class="col-sm-9">
			<?php $this->load->view('pages/'.$temp); ?>

		</div>
		<?php $this->load->view('pages/sidebar') ?>

		<div class="clearfix"></div>

		<!-- Footer -->
		<?php $this->load->view('pages/footer') ?>
		<!-- Footer -->
	</div>

	<!-- jQuery Plugins -->
	<script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
	<script type="text/javascript">
		$(function(){
			var url = $('.control select').attr('data-url');
			$('.control select').change(function(){
				var redirect = url.replace('(:num)', $(this).val());
				window.location = redirect;
			});
		});
	</script>
</body>

</html>
