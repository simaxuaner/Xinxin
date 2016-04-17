    <!--
        imageLinkPathHead   :图片连接位置
    -->
	<main>
        <!-- 子菜单导航! -->
		<nav id="sideNav" class="w20">
			<ul>

				<li class="activeNavItem"> <a href="classes">精品推荐</a> </li>
				<li> <a href="teachers">课程</a> </li>
			</ul>
		</nav>
        
        <!-- 标题不份额-->
		<section class="w80">
			<div class="bar">
				<h1>精品推荐</h1>
			</div>
			<div id="slider" class="w100"> <img id="sliderImg" src="<?php print $imageLinkPathHead?>/images/slider/2.jpg" alt="slider" /> </div>
		</section>
        
		<section class="w80">
			<div class="bar">
			  <h1>课程</h1> <select>
			  <option value="volvo">种植培养</option>
			  <option value="saab">市场</option>
			  <option value="mercedes">管理</option>
			  <option value="audi">金融</option>
			  </select> 
                <div class="search floatRight">
                    <a href="#"><img src="<?php print $imageLinkPathHead?>/images/icons/search.jpg" alt="search"></a>
                    <input type="text" name="search">
                </div> 
            </div>
			
            <!--动态获取课程列表 -->
            <?php 
            foreach($classList as $key => $value)
            {
            ?>           
                <div class="block <?php if(($key+1)%4==0) print "noMarginRight" ?>"> 
                    <span class="fav">喜爱</span> 
                    <img src="<?php print $imageLinkPathHead."/".$value['imgurl']?>" />
				    <a href="classes/class0.php" >
                        <h3>The best class ever</h3>
                    </a>
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
        
		<section class="w80">
            <div class="bar">
				<h2>Recommended</h2>
			</div>
		    <!--动态获取课程列表 -->
            <?php 
            foreach($classList as $key => $value)
            {
            ?> 
                <div class="block <?php if(($key+1)%4==0) print "noMarginRight" ?>"> 
                    <span class="fav">喜爱</span> 
                    <img src="<?php print $imageLinkPathHead."/".$value['imgurl']?>" />
				    <a href="classes/class0.php" >
                        <h3>The best class ever</h3>
                    </a>
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
		<section class="w40">
            <div class="bar">
				<h2>Favorites</h2>
			</div>
			<!--动态获取课程列表 -->
            <?php 
            foreach($classList as $key => $value)
            {
            ?>    
                <div class="block <?php if(($key+1)%4==0) print "noMarginRight" ?>"> 
                    <span class="fav">喜爱</span> 
                    <img src="<?php print $imageLinkPathHead."/".$value['imgurl']?>" />
				    <a href="classes/class0.php" >
                        <h3>The best class ever</h3>
                    </a>
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
		<section class="w40">
			<div class="bar">
				<h2>Recently visited</h2>
			</div>
			<!--动态获取课程列表 -->
            <?php 
            foreach($classList as $key => $value)
            {
            ?>
                <div class="block <?php if(($key+1)%4==0) print "noMarginRight" ?>"> 
                    <span class="fav">喜爱</span> 
                    <img src="<?php print $imageLinkPathHead."/".$value['imgurl']?>" />
				    <a href="classes/class0.php" >
                        <h3>The best class ever</h3>
                    </a>
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