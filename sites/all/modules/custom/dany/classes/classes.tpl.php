    <!--
        imageLinkPathHead   :图片连接位置
    -->
	<main>
        <!-- 子菜单导航! 0417丢弃-->
        <!-- 子菜单导航! 0423补充-->
        <?php print $secondMenuNav?>
		<section class="w80">
			<div class="bar">
              <img class="icon" src="<?php print $imageLinkPathHead?>/images/icons/classes_icon.png">
			  <h1>课程</h1>
              <!-- 
              <select>
                <option value="volvo">种植培养</option>
                <option value="saab">市场</option>
                <option value="mercedes">管理</option>
                <option value="audi">金融</option>
			  </select> -->
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
                <div id="node-<?php print $value['id'];?>" class="block1 <?php if(($key+1)%4==0):print "noMarginRight"; endif; ?>" title="<?php print $value['title']?>"> 
                        <?php print $value['collectionLink'];?>
                        <img src="<?php print $value['imgurl']?>" />
                        <a href="<?php print $value['detailurl']?>">
                            <h3><?php print $value['shortTitle']?></h3>
                        </a>             
                        <p>
                            <span class="farmName"><?php print $value['teachername']?></span>
                            <span class="floatRight">01</span>
                            <span class="floatRight">02</span>
                        </p>
               </div>
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
                    <div id="node-<?php print $value['id'];?>"  class="block1 <?php if(($key+1)%4==0):print "noMarginRight"; endif; ?>" title="<?php print $value['title']?>"> 
                        <?php print $value['collectionLink'];?>
                        <img src="<?php print $value['imgurl']?>" />
                        <a href="<?php print $value['detailurl']?>">
                            <h3><?php print $value['shortTitle']?></h3>
                        </a>             
                        <p>
                            <span class="farmName"><?php print $value['teachername']?></span>
                            <span class="floatRight">01</span>
                            <span class="floatRight">02</span>
                        </p>
               </div>
            <?php
            }
            ?>
		</section>		
		<section class="w80">
            <div class="bar">
				<h2>收藏</h2>
			</div>
		    <!--动态获取课程列表 -->
            <?php 
            foreach($favClassList as $key => $value)
            {
            ?>           
                    <div id="node-<?php print $value['id'];?>"  class="block1 <?php if(($key+1)%4==0):print "noMarginRight"; endif; ?>" title="<?php print $value['title']?>"> 
                        <?php print $value['collectionLink'];?>
                        <img src="<?php print $value['imgurl']?>" />
                        <a href="<?php print $value['detailurl']?>">
                            <h3><?php print $value['shortTitle']?></h3>
                        </a>             
                        <p>
                            <span class="farmName"><?php print $value['teachername']?></span>
                            <span class="floatRight">01</span>
                            <span class="floatRight">02</span>
                        </p>
               </div>
            <?php
            }
            ?>
		</section>
	</main>