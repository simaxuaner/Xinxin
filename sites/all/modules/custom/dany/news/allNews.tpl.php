<!-- 
    newsTitle   :該頁面的主題
    noteList    :帖子列表
    magzineList :底部推薦的雜誌列表
    imageLinkPathHead   :图片连接位置
-->
<main id="mainSection">
	<section class="w100">
		<div class="bar">
			<h1><?php print $newsTitle?></h1>
            <select>
			  <option value="volvo">2011</option>
			  <option value="saab">2012</option>
			  <option value="mercedes">2013</option>
			  <option value="audi">2014</option>
              <option value="audi">2014</option>
			</select> 
            <select>
			  <option value="volvo">参会指南</option>
			  <option value="saab">论坛介绍</option>
			  <option value="mercedes">园区信息</option>
			</select> 
		</div>
        <article class="newsItem onClick="expandParent(this)">
        <!--动态获取课程列表 -->
        <?php 
        foreach($noteList as $key => $value)
        {
        ?>
            <div class="newsItem">
                <span class="dateBlock"><?php print $value['date'] ?></span>
                <img class="floatRight w40" src="<?php print $imageLinkPathHead.'/'.$value['imgurl']?>"/>
                <div class="floatRight w100">
                <h2><?php print $value['title'] ?></h2>
                <p>
                    <?php print $value['content'] ?>
                </p>
                </div>
            </div>
        <?php
        }
        ?>
	</section>
	<section class="w100">
        <div class="bar">
			<h1>Magazines</h1>
		</div>
        <!--动态获取课程列表 -->
        <?php 
        foreach($magzineList as $key => $value)
        {
        ?>
            <div class="block <?php if(($key+1)%4==0) print "noMarginRight" ?>"> 
                <span class="fav">喜爱</span> 
                <img src="<?php print $imageLinkPathHead.'/'.$value['imgurl']?>"/>
                <a href="#" ><h3>Magazine</h3></a>
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
