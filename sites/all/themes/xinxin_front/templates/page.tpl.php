<div id="wrapper">
	<header>
		<div class="logo">
			<a href="?q=homepage"><img alt="logo"
				src="sites/all/themes/xinxin_front/images/icons/logo colored.png"></a>
		</div>
		<nav class="mainmenu">
			<ul class="mainmenu-link-left">
				<?php if ($primary_nav): print $primary_nav; endif; ?>
				<div class="loginMenu floatRight">
					<?php if (user_is_logged_in()): ?>
						<a href="<?php print url("user/logout"); ?>">退出</a>
					<?php else : ?>
						<a href="<?php print url("user/login"); ?>">登录</a>
						|
						<a href="<?php print url("user/register"); ?>">注册</a>
					<?php endif; ?>
				</div>
				<?php print render($search_form); ?>
			</ul>
        </nav>
	</header>

	<main id="mainSection"> 
		<div id="container" class="clearfix container">
			<?php if (isset($page['content_before'])): ?>
				<div id="content-before">
					<?php print render($page['content_before']); ?>
				</div>
			<?php endif; ?>
	    	<div id="main-content">
	       		<?php if ($page['content']): print render($page['content']); endif; ?>
	       	</div>
	     </div>
	</main>

	<highlighted id="highlighted">
        <?php if ($page['highlighted']): print render($page['highlighted']); endif; ?>
    </highlighted>


	<footer>
		<div class="w100 contact alignCenter">
			<p class="w30 alignLeft">
				地址： 广东深圳新辉大宝安区
			</p>		
			<p class="w30 alignRight">
				联系方式： 88888888
			</p>
		</div>
		<div class="copyright">
			<span>Copyright 2016</span>
		</div>
    </footer>
</div>