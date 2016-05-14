    <!--
        imageLinkPathHead   :图片连接位置
    -->
	<main>
        <!-- 子菜单导航! 0417丢弃-->
        <!-- 子菜单导航! 0423补充-->
        <?php print $secondMenuNav?>
		<section class="w80">
			<div class="bar">
              <img class="icon" src="images/icons/classes_icon.png">
			  <h1>课程</h1> 
              <select>
                <option value="volvo">种植培养</option>
                <option value="saab">市场</option>
                <option value="mercedes">管理</option>
                <option value="audi">金融</option>
			  </select> 
              <div class="search floatRight">
                <a href="#"><img src="<?php print $imageLinkPathHead?>/images/icons/search_bar.png" alt="search"></a>
                <input type="text" name="search">
              </div> 
            </div>
			
            <!--动态获取课程列表 -->
            <?php 
            foreach($classList as $key => $value)
            {
            ?>           
                <a href="<?php print $value['detailurl']?>">
                    <div class="block1 <?php if(($key+1)%4==0) print "noMarginRight" ?>" title="<?php print $value['title']?>"> 
                        <span class="fav">收藏</span> 
                        <img src="<?php print $value['imgurl']?>" />
                            <h3><?php print $value['shortTitle']?></h3>
                        <p>
                            <span class="farmName"><?php print $value['teachername']?></span>
                            <span class="floatRight">01</span>
                            <span class="floatRight">02</span>
                        </p>
                    </div>
			    </a>
            <?php
            }
            ?>
		</section>
        
		<section class="w80">
            <div class="bar">
				<h2>推荐</h2>
			</div>
		    <!--动态获取课程列表 -->
            <?php 
            foreach($classList as $key => $value)
            {
            ?>           
                <a href="<?php print $value['detailurl']?>">
                    <div class="block1 <?php if(($key+1)%4==0) print "noMarginRight" ?>" title="<?php print $value['title']?>"> 
                        <span class="fav">收藏</span> 
                        <img src="<?php print $value['imgurl']?>" />
                            <h3><?php print $value['shortTitle']?></h3>
                        <p>
                            <span class="farmName"><?php print $value['teachername']?></span>
                            <span class="floatRight">01</span>
                            <span class="floatRight">02</span>
                        </p>
                    </div>
			    </a>
            <?php
            }
            ?>
		</section>		
		<section class="w40" id="section401">
            <div class="bar">
				<h2>收藏列表</h2>
			</div>
			<!--动态获取课程列表 -->
            <?php 
            foreach($classList as $key => $value)
            {
            ?>           
                <a href="<?php print $value['detailurl']?>">
                    <div class="block1 <?php if(($key+1)%4==0) print "noMarginRight" ?>" title="<?php print $value['title']?>"> 
                        <span class="fav">收藏</span> 
                        <img src="<?php print $value['imgurl']?>" />
                            <h3><?php print $value['shortTitle']?></h3>
                        <p>
                            <span class="farmName"><?php print $value['teachername']?></span>
                            <span class="floatRight">01</span>
                            <span class="floatRight">02</span>
                        </p>
                    </div>
			    </a>
            <?php
            }
            ?>
		</section>		
		<section class="w40" id="section402">
			<div class="bar">
				<h2>最近访问</h2>
			</div>
			<!--动态获取课程列表 -->
            <?php 
            foreach($classList as $key => $value)
            {
            ?>           
                <a href="<?php print $value['detailurl']?>">
                    <div class="block1 <?php if(($key+1)%4==0) print "noMarginRight" ?>" title="<?php print $value['title']?>"> 
                        <span class="fav">收藏</span> 
                        <img src="<?php print $value['imgurl']?>" />
                            <h3><?php print $value['shortTitle']?></h3>
                        <p>
                            <span class="farmName"><?php print $value['teachername']?></span>
                            <span class="floatRight">01</span>
                            <span class="floatRight">02</span>
                        </p>
                    </div>
			    </a>
            <?php
            }
            ?>
		</section>
	</main>