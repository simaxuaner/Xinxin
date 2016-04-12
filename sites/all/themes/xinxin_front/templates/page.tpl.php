<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>title><?php print $head_title ?></title>
    <?php print $styles ?>
    <script type="text/javascript" src="../js/scripts.js"></script>
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body onLoad="startSlider()">
<script src="../js/scripts.js"></script>
<header>
    <div class="logo">
        <a href="#">
            <img src="../images/icons/#" alt="logo"/>
        </a>
    </div>
    <nav class="mainmenu">
        <ul>
            <li>
                <a href="#">About</a>
            </li>
            <li>
                <a href="#">News</a>
            </li>
            <li>
                <a href="#">Exhibition</a>
            </li>
            <li>
                <a href="#">Members</a>
            </li>
        </ul>
    </nav>
</header>
<main>
    <div id="slider">
        <img id="sliderImg" src="../images/slider/2.jpg" alt="slider"/>
    </div>
    <nav class="homenav">
        <a href="#">
            <div class="bigbutton">
                <img src="../images/icons/news.png" alt="news"/>
                <h2>News</h2>
            </div>
        </a>
        <a href="#">
            <div class="bigbutton">
                <img src="../images/icons/farms.png" alt="farms"/>
                <h2>Farms</h2>
            </div>
        </a>
        <a href="#">
            <div class="bigbutton">
                <img src="../images/icons/products.png" alt="products"/>
                <h2>Products</h2>
            </div>
        </a>
        <a href="#">
            <div class="bigbutton">
                <img src="../images/icons/training.png" alt="training"/>
                <h2>Training</h2>
            </div>
        </a>
    </nav>
</main>
<footer>
    <div class="links">
        <p>
            <a href="#">sdfsdf</a>
        </p>
        <p>
            <a href="#">sdfsdf</a>
        </p>
        <p>
            <a href="#">sdfsdf</a>
        </p>
    </div>
    <div class="social">
        <a href="#"><img src="images/icons/qq.png" alt="qq"/></a>
        <a href="#"><img src="images/icons/wechat.png" alt="wechat"/></a>
        <a href="#"><img src="images/icons/weibo.png" alt="weibo"/></a>
    </div>
    <div class="copyright">
        <p>Copyright 2016</p>
    </div>
</footer>
</body>
</html>