    <!--
        imageLinkPathHead   :图片连接位置
    -->
	<main>
        <!-- 子菜单导航! 0417丢弃-->
		<section class="w80">
			<div class="bar">
			  <h1>课程</h1> <select>
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
                <div class="block1 <?php if(($key+1)%4==0) print "noMarginRight" ?>"> 
                    <span class="fav">收藏</span> 
                    <img src="<?php print $imageLinkPathHead."/".$value['imgurl']?>" />
				    <a href="classes/class0.php" >
                        <h3>课程名称</h3>
                    </a>
				    <p>
                        <span class="farmName">讲师名</span>
                        <span class="floatRight">01</span>
                        <span class="floatRight">02</span>
                    </p>
			   </div>
            <?php
            }
            ?>
            <!--动态获取课程列表 -->
            <!--重复填充，观察效果-->
            <?php 
            foreach($classList as $key => $value)
            {
            ?>           
                <div class="block1 <?php if(($key+1)%4==0) print "noMarginRight" ?>"> 
                    <span class="fav">收藏</span> 
                    <img src="<?php print $imageLinkPathHead."/".$value['imgurl']?>" />
				    <a href="classes/class0.php" >
                        <h3>课程名称</h3>
                    </a>
				    <p>
                        <span class="farmName">讲师名</span>
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
                <div class="block1 <?php if(($key+1)%4==0) print "noMarginRight" ?>"> 
                    <span class="fav">收藏</span> 
                    <img src="<?php print $imageLinkPathHead."/".$value['imgurl']?>" />
				    <a href="classes/class0.php" >
                        <h3>课程名称</h3>
                    </a>
				    <p>
                        <span class="farmName">讲师名</span>
                        <span class="floatRight">01</span>
                        <span class="floatRight">02</span>
                    </p>
			   </div>
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
                <div class="block1 <?php if(($key+1)%4==0) print "noMarginRight" ?>"> 
                    <span class="fav">收藏</span> 
                    <img src="<?php print $imageLinkPathHead."/".$value['imgurl']?>" />
				    <a href="classes/class0.php" >
                        <h3>课程名称</h3>
                    </a>
				    <p>
                        <span class="farmName">讲师名</span>
                        <span class="floatRight">01</span>
                        <span class="floatRight">02</span>
                    </p>
			   </div>
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
                <div class="block1 <?php if(($key+1)%4==0) print "noMarginRight" ?>"> 
                    <span class="fav">喜爱</span> 
                    <img src="<?php print $imageLinkPathHead."/".$value['imgurl']?>" />
				    <a href="classes/class0.php" >
                        <h3>课程名称</h3>
                    </a>
				    <p>
                        <span class="farmName">讲师名</span>
                        <span class="floatRight">01</span>
                        <span class="floatRight">02</span>
                    </p>
			   </div>
            <?php
            }
            ?>
		</section>
	</main>