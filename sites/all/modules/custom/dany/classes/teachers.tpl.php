    
<main>
    <section class="w80">
        <div class="bar">
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
            <div class="block1 <?php if(($key+1)%4==0) print "noMarginRight" ?>"> 
                <span class="fav">收藏</span> 
                <img src="<?php print $imageLinkPathHead."/".$value['imgurl']?>" />
				    <a href="teachers/teacher0.php" ><h3>"<?php print $value['teacherName']?>"教师名</h3></a>
				<p>
                    <span class="farmName">专业领域/职位</span>
                    <span class="floatRight">01</span>
                    <span class="floatRight">02</span>
                </p>
			   </div>
        <?php
        }
        ?>
    </section>
</main>    