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
            <li> <a href="<?php print $farm_page?>">农庄</a> </li>
            <li class="activeNavItem"> <a href="<?php print $product_page?>">农产品</a> </li>
        </ul>
    </nav>
    <section class="w80">
        <?php print $content?>
    </section>

</main>