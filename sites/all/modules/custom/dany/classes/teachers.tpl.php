    
<main>
    <!-- 子菜单导航! 0423补充-->
    <?php print $secondMenuNav?>
    <section class="w80">
        <div class="bar">
            <img class="icon" src="<?php print $imageLinkPathHead?>/images/icons/teachers_icon.png">
        	<h1>农业名师</h1>
        	<div class="search floatRight">
                <a href="#"><img src="<?php print $imageLinkPathHead?>/images/icons/search_bar.png" alt="search">
                </a><input type="text" name="search">
            </div> 
        </div>
        
        <!--动态获取课程列表 -->
        <?php 
        foreach($teacherList as $key => $value)
        {
        ?>  
            <a href="<?php print $value['detailurl']?>" >         
                <div class="block1 <?php if(($key+1)%4==0) print "noMarginRight" ?>"> 
                    <span class="fav">收藏</span> 
                        <img src="<?php print $value['imgurl']?>" />
				        <h3><?php print $value['teacherName']?></h3>
				        <p>
                            <span class="farmName"><?php print $value['career']?></span>
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