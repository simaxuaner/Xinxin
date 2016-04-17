/**
* Created by IntelliJ IDEA.
* User: Sadako
* Date: 2016/4/17
* Time: 10:43
*/
<main>
    <nav id="sideNav" class="w20">
        <ul>
            <li><a href="farms.php">农庄</a></li>
            <li class="activeNavItem"><a href="products.php">农产品</a></li>
        </ul>
    </nav>
    <section class="w80">
        <?php if ($product): print render($product); endif; ?>
        <!--<div class="bar">
            <h1>农产品</h1>
            <select>
                <option value="volvo">种植培养</option>
                <option value="saab">市场</option>
                <option value="mercedes">管理</option>
                <option value="audi">金融</option>
            </select>

            <div class="search floatRight"><a href="#"><img src="images/icons/search.jpg" alt="search"></a><input
                    type="text" name="search"></div>
        </div>
        <div class="block"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>
        <div class="block"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>
        <div class="block"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>
        <div class="block noMarginRight"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>
        <div class="block"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>
        <div class="block"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>
        <div class="block"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>
        <div class="block noMarginRight"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>
    </section>-->
    <section class="w80">
        <div class="bar">
            <h2>Recommended for you</h2>
        </div>
        <?php if ($recommend): print render($recommend); endif; ?>
        <!--<div class="block"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>
        <div class="block"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>
        <div class="block"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>
        <div class="block noMarginRight"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>-->
    </section>
    <section class="w40">
        <div class="bar">
            <h2>Favorites</h2>
        </div>
        <?php if ($favorites): print render($favorites); endif; ?>
        <!--<div class="block"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>
        <div class="block"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>
        <div class="block"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>
        <div class="block noMarginRight"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>-->
    </section>
    <section class="w40">
        <div class="bar">
            <h2>Recently Visited</h2>
        </div>
        <?php if ($recently_visited): print render($recently_visited); endif; ?>
        <!--<div class="block"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>
        <div class="block"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>
        <div class="block"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>
        <div class="block noMarginRight"><span class="fav">喜爱</span> <img src="images/products/product0.jpg"/>
            <a href="products/product0.php"><h3>产品名称</h3></a>

            <p><span class="farmName">asdf</span><span class="floatRight">01</span><span class="floatRight">02</span>
            </p>
        </div>-->
    </section>
</main>