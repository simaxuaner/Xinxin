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

    <highlighted>
        <div id="slider">
            <img id="sliderImg" src="sites/all/themes/xinxin_front/images/slider/2.jpg" alt="slider"/>
        </div>
    </highlighted>

    <main id="mainSection">
        <nav class="homenav">
            <?php if ($page['home_content']): print render($page['home_content']); endif; ?>
        </nav>
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