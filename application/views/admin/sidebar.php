<div class="nav-side-menu col-sm-3">
	<div class="row">
		<div class="brand">Blog</div>
	    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
	  
	        <div class="menu-list">
	  
	            <ul id="menu-content" class="menu-content collapse out">
	                <li>
	                  <a href="">
	                  	<i class="fa fa-dashboard fa-lg"></i> Dashboard
	                  </a>
	                </li>

	                <li  data-toggle="collapse" data-target="#story" class="collapsed">
	                  <a href="#"><i class="fa fa-book fa-lg"></i> Truyện <span class="arrow"></span></a>
	                </li>
	                <ul class="sub-menu collapse" id="story">
	                    <li><a href="<?php echo base_url('admin/truyen') ?>">Tất cả truyện</a></li>
	                    <li><a href="<?php echo base_url('admin/truyen/them-moi.html') ?>">Thêm mới truyện</a></li>
	                </ul>


	                <li data-toggle="collapse" data-target="#tag" class="collapsed">
	                  <a href="#"><i class="fa fa-tag fa-lg"></i> Thể loại <span class="arrow"></span></a>
	                </li>  
	                <ul class="sub-menu collapse" id="tag">
	                  <li><a href="<?php echo base_url('admin/the-loai') ?>">Tất cả thể loại</a></li>
	                  <li><a href="<?php echo base_url('admin/the-loai/them-moi.html') ?>">Thêm mới thể loại</a></li>
	                </ul>


	                 <li>
	                  <a href="<?php echo base_url('admin/them-chuong-moi.html') ?>">
	                  <i class="fa fa-folder-o fa-lg"></i> Thêm chương mới
	                  </a>
	                  </li>

	                 <li>
	                  <a href="">
	                  <i class="fa fa-sign-out fa-lg"></i> Đăng xuất
	                  </a>
	                </li>
	            </ul>
	     </div>
	</div>
</div>