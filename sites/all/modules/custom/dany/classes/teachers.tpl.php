    
<main>
    <!-- 子菜单导航! 0423补充-->
    <?php print $secondMenuNav?>
    <section class="w80">
        <div class="bar">
            <img class="icon" src="<?php print $imageLinkPathHead?>/images/icons/teachers_icon.png">
        	<h1>农业名师</h1>
        	<div class="search floatRight">
                <a href="#" id="search_class_button"><img src="<?php print $imageLinkPathHead?>/images/icons/search_bar.png" alt="search">
                </a><input type="text" name="search" id="search_class_form">
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