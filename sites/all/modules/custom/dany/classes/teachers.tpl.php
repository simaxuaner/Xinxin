    
<main>
    <section class="w100">
        <div class="bar">
        	<h1>课程</h1>
        	<div class="search floatRight">
                <a href="#"><img src="<?php print $imageLinkPathHead?>/images/farms/search_bar.png" alt="search">
                </a><input type="text" name="search">
            </div> 
        </div>
        
        <!--动态获取课程列表 -->
        <?php 
        foreach($teacherList as $key => $value)
        {
        ?>           
            <div class="block <?php if(($key+1)%4==0) print "noMarginRight" ?>"> 
                <span class="fav">喜爱</span> 
                <img src="<?php print $imageLinkPathHead."/".$value['imgurl']?>" />
				    <a href="teachers/teacher0.php" ><h3>"<?php print $value['teacherName']?>"</h3></a>
				<p>
                    <span class="farmName">asdf</span>
                    <span class="floatRight">01</span>
                    <span class="floatRight">02</span>
                </p>
			   </div>
        <?php
        }
        ?>
    </section>
</main>    