    <!--
        imageLinkPathHead   :图片连接位置
    -->
	<main>
        <!-- 子菜单导航! 0417丢弃-->
        <!-- 子菜单导航! 0423补充-->
        <?php print $secondMenuNav?>
        <?php $build=""?>
        <div id="class_form_list">
		<section class="w80">
			<div class="bar">
              <img class="icon" src="<?php print $imageLinkPathHead?>/images/icons/classes_icon.png">
			  <h1>课程</h1>
            </div>
			<div class="search floatRight">
                <a href="#" id="search_class_button" class="local_search_form_div form-submit">搜索</a>
                <div class="form-item form-type-textfield form-item-farm-keywords">
 					<input type="text" id="search_class_form" name="farm_keywords" value="" size="60" maxlength="128" class="form-text">
				</div>
             </div> 
            <!--动态获取课程列表 -->
            <div class="search_class_form_list">
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
            </div>
		</section>
        
		<section class="w80 search_class_form_list_append">
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
		<section class="w80 search_class_form_list_append">
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