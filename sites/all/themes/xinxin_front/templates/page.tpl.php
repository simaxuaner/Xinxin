<div id="wrapper">
    <header>
        <div class="logo">
            <a href="?q=homepage"><img alt="logo" src="sites/all/themes/xinxin_front/images/icons/logo colored.png"></a>
        </div>
        <nav class="mainmenu">
            <?php if ($primary_nav): print $primary_nav; endif; ?>
        </nav>
    </header>

    <main id="mainSection">
        <div id="container" class="clearfix container">
            <?php print render($page['content']); ?>
        </div>
    </main>

    <highlighted id="highlighted">
        <?php if ($page['highlighted']): print render($page['highlighted']); endif; ?>
    </highlighted>


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