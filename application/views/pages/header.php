<nav class="navbar navbar-default navbar-static">
    <div class="navbar-header">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="<?php echo base_url('') ?>" class="navbar-brand">BlogTruyen</a>
    </div>

    <div class="collapse navbar-collapse js-navbar-collapse">
        <ul class="nav navbar-nav">
            <li class="dropdown dropdown-large">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Thể loại <b class="caret"></b></a>
                <ul class="dropdown-menu dropdown-menu-large row">
                    <?php $separate = ceil(count($tagsAll) / 3); ?>
                    <li class="col-sm-4">
                        <ul>
                            <?php for ($i=0; $i < $separate; $i++) { ?>
                                <?php if (isset($tagsAll[$i])): ?>
                                    <li><a href="<?php echo base_url('the-loai-'.$tagsAll[$i]['slug']) ?>"><?php echo $tagsAll[$i]['name']; ?></a></li>
                                <?php endif ?>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="col-sm-4">
                        <ul>
                            <?php for ($i=$separate; $i < $separate*2; $i++) { ?>
                                <?php if (isset($tagsAll[$i])): ?>
                                    <li><a href="<?php echo base_url('the-loai-'.$tagsAll[$i]['slug']) ?>"><?php echo $tagsAll[$i]['name']; ?></a></li>
                                <?php endif ?>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="col-sm-4">
                        <ul>
                            <?php for ($i=$separate*2; $i < $separate*3; $i++) { ?>
                                <?php if (isset($tagsAll[$i])): ?>
                                    <li><a href="<?php echo base_url('the-loai-'.$tagsAll[$i]['slug']) ?>"><?php echo $tagsAll[$i]['name']; ?></a></li>
                                <?php endif ?>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
        	<form method="get" action="tim-kiem" class="navbar-form navbar-left">
		        <div class="form-group">
		          <input type="text" name="q" class="form-control" placeholder="Tìm kiếm...">
		        </div>
		        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
		      </form>
        </ul>
    </div><!-- /.nav-collapse -->
</nav>