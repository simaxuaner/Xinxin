<!-- 
    newsTitle   :該頁面的主題
    noteList    :帖子列表
    magzineList :底部推薦的雜誌列表
    imageLinkPathHead   :图片连接位置
-->
<main id="mainSection">
	<section class="w80">
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
        <!--动态获取课程列表 -->
        <?php 
        foreach($noteList as $key => $value)
        {
        ?>
            <article class="newsItem onClick="expandParent(this)">
                <span class="dateBlock"><?php print $value['date'] ?></span>
                <img src="<?php print $imageLinkPathHead.'/'.$value['imgurl']?>"/>
                <h2><?php print $value['title'] ?></h2>
                <?php print $value['content'] ?>
            </article>
        <?php
        }
        ?>
	</section>
	<section class="w80">
        <div class="bar">
			<h1>电子杂志</h1>
		</div>
        <!--动态获取课程列表 -->
        <?php 
        foreach($magzineList as $key => $value)
        {
        ?>
            <div class="block1 <?php if(($key+1)%4==0) print "noMarginRight" ?>"> 
                <span class="fav">收藏</span> 
                <img src="<?php print $imageLinkPathHead.'/'.$value['imgurl']?>"/>
                <a href="#" ><h3>论坛杂志</h3></a>
                <p>
                    <span class="farmName">2016.4.10</span>
                </p>
            </div>           
         <?php
         }
         ?>
	</section>
</main>
