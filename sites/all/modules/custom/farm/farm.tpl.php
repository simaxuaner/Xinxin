<?php
/**
 * Created by PhpStorm.
 * User: yunjia
 * Date: 2016/4/21
 * Time: 15:53
 */
?>
<main>
    <nav id="sideNav" class="w20">
        <ul>
            <li class="activeNavItem"> <a href="<?php print $farm_page?>">农庄</a> </li>
            <li> <a href="<?php print $product_page?>">农产品</a> </li>

        </ul>
    </nav>
    <section class="w80">
        <div class="bar">
            <h1>农庄</h1>

            <div class="search floatRight"><a href="#"><img src="images/icons/search_bar.png" alt="search"></a><input type="text" name="search"></div>
            <div class="button floatRight"><a href="farms1.php">+</a></div>
        </div>
        <?php print $farm_term?>
    </section>

</main>
