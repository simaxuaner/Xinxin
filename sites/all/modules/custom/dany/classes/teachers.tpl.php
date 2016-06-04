    
<main>
    <!-- 子菜单导航! 0423补充-->
    <?php print $secondMenuNav?>
    <section class="w80">
        <div class="bar">
            <img class="icon" src="<?php print $imageLinkPathHead?>/images/icons/teachers_icon.png">
        	<h1>农业名师</h1>
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
        foreach($teacherList as $key => $value)
        {
        ?>     
                <div id="node-<?php print $value['id'];?>" class="block1 <?php if(($key+1)%4==0): print "noMarginRight"; endif; ?>"> 
                    <?php print $value['collectionLink'];?>
                        <img src="<?php print $value['imgurl']?>" />
				        <a href="<?php print $value['detailurl']?>" > 
                            <h3><?php print $value['teacherName']?></h3>
				        </a>
                        <p>
                            <span class="farmName"><?php print $value['career']?></span>
                            <span class="floatRight">01</span>
                            <span class="floatRight">02</span>
                        </p>
			   </div>
        <?php
        }
        ?>
        </div>
    </section>
</main>    