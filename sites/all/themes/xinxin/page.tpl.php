<div id="wrapper">
	<div id="header" class="clearfix navbar navbar-default navbar-fixed-top rp-navbar">
		<div class="container">
			<div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand rp-logo" href="<?php print $front_page; ?>"><span><?php if ($site_name): print $site_name; endif; ?></span></a>
		    </div>
		    <div class="collapse navbar-collapse">
		      <ul class="nav navbar-nav navbar-right">
		      	<?php if ($primary_nav): print $primary_nav; endif; ?>
		      	<?php if ($search_form): ?>
		      	<li><?php print render($search_form); ?></li>
		      	<?php endif; ?>
		      	<?php if (user_is_logged_in()): ?>
		      	<li class="dropdown rp-account">
		              <a href="#" class="dropdown-toggle rp-thumbnail" data-toggle="dropdown">
		                <?php print $user_avatar; ?>
		              </a>
		              <?php if ($secondary_nav): print $secondary_nav; endif; ?>
		        </li>
		        <?php else : ?>
		      	<a class="navbar-right navbar-btn btn rp-login" href="<?php print url('user/login'); ?>"><?php print t('Sign in'); ?></a>
		      	<a class="navbar-right navbar-btn btn rp-register" href="<?php print url('user/register'); ?>"><?php print t('Sign up'); ?></a>
		        <?php endif; ?>
		      </ul>
		      
		    </div>
		</div>
	</div>
	<div id="container" class="clearfix container">
	  <div class="row rp-row">
	  	<?php if ($messages): print $messages; endif; ?>
		<div id="center" class="clearfix col-xs-12 rp-container">
			<?php if ($page['highlighted']): ?>
			<div id="highlighted">
			<?php print render($page['highlighted']); ?>
			</div>
			<?php endif; ?>
			<?php if ($tabs): ?>
			<div id="tabs-wrapper" class="clearfix">
			<?php print render($tabs); ?>
			</div>
			<?php endif; ?>
			<div class="clearfix">
			<?php print render($page['content']); ?>
			</div>
		</div> <!-- /#center -->
      </div>
	</div> <!-- /#container -->
	<div class="footer">
	    <div class="container">
	      <div class="address">
	        <?php print t('Copyright © 2016, XINHUIDA.'); ?>
	      </div>
	    </div>
	</div> <!-- /#footer -->
</div> <!-- /#wrapper -->
