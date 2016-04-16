<div id="wrapper">
    <header>
        <div class="logo">
            <a href="index.html"><img alt="logo" src="sites/all/themes/xinxin_front/images/icons/logo.png"></a>
        </div>
        <nav class="mainmenu">
            <?php if ($primary_nav): print $primary_nav; endif; ?>
        </nav>

        <ul class="usermenu">
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
    </header>

    <?php if ($page['highlighted']): ?>
        <highlighted id="highlighted">
            <?php print render($page['highlighted']); print "123"?>
        </highlighted>
    <?php endif; ?>

    <main id="mainSection">
        <nav class="sideNav" id="sideNav">
            <?php if ($page['sidebar_left']): print render($page['sidebar_left']); endif; ?>
        </nav>
        <div id="container" class="clearfix container">
            <?php print render($page['content']); ?>
        </div>
    </main>

    <footer>
        <div class="links">
            <p>
                <a href="#">6.6涂岭论坛</a>
            </p>
            <p>
                <a href="#">12.12论坛</a>
            </p>
            <p>
                <a href="#">在线商城</a>
            </p>
        </div>
        <div class="social">
            <a href="#"><img src="sites/all/themes/xinxin_front/images/icons/qq.png" alt="qq"/></a>
            <a href="#"><img src="sites/all/themes/xinxin_front/images/icons/wechat.png" alt="wechat"/></a>
            <a href="#"><img src="sites/all/themes/xinxin_front/images/icons/weibo.png" alt="weibo"/></a>
        </div>
        <div class="copyright">
            <p>Copyright 2016</p>
        </div>
    </footer>
</div>