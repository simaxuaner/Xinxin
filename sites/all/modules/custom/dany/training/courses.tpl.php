    <!--
        使用的变量
        imageLinkPathHead   :图像文件的头位置
        productsList        :展示的商品列表
    -->
   <main id="mainSection">
       <!-- 子菜单导航 -->
		<nav class="sideNav" id="sideNav">
			<ul>
				<li id="sideNavItem0" onClick="loadSubPage(0)">
					精品推荐
				</li>
				<li id="sideNavItem1" onClick="loadSubPage(1)">
					课程
				</li>
			</ul>
		</nav>
        
        <!-- 页面信息-->
		<content id="subPage0">
            <h1>精品推荐</h1>
            <div id="slider">
                <img id="sliderImg" src="<?php print $imageLinkPathHead ?>/images/slider/2.jpg" alt="slider"/>
            </div>		
            
            <!--筛选信息-->
            <div class="filterBar"><h1>Classes</h1>
                <select>
                <option value="volvo">Growing</option>
                <option value="saab">Marketing</option>
                <option value="mercedes">Management</option>
                <option value="audi">Financial</option>
                </select>
                <input type="text" name="firstname">
            </div>
            
            <!--动态获取物品列表 -->
            <?php 
            foreach($productList as $key => $value)
            {
            ?>    
                <div class="block <?php if(($key+1)%4==0) print "noMarginRight" ?>">
                <span class="fav">favorite</span>
                    <img src="<?php print $imageLinkPathHead."/".$value['imgurl']?>"/>
                    <p class="productName"><?php print $value['productName'] ?></p>
                    <p>
                        <span class="farmName"><?php print $value['farmName'] ?></span>
                        <span class="customers"><?php print $value['customers'] ?></span>
                        <span class="comments"><?php print $value['comments'] ?></span>
                    </p>
            </div>
            <?php
            }
            ?>		
		</content>		
		<content id="subPage1" class="hidden">
		<h1>Teachers</h1>
		</content>
	</main>