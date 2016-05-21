<!-- 
    newsTitle   :該頁面的主題
    noteList    :帖子列表
    magzineList :底部推薦的雜誌列表
    imageLinkPathHead   :图片连接位置
-->
<main id="mainSection">
    <?php print $secondMenuNav ?>
	<section class="w80">
		<div class="bar">
            <img class="icon" src="<?php print $imageLinkPathHead?>/images/icons/<?php print $icon_image?>.png">
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
        <!--动态获取资讯列表 -->
        <?php 
        foreach($noteList as $key => $value)
        {
        ?>
            <article class="newsItem">
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
            <div class="block1 <?php if(($key+1)%4==0) print "noMarginRight" ?>" title="<?php print $value['title']?>"> 
                <span class="fav">收藏</span> 
                <img src="<?php print $value['imgurl']?>"/>
                <a href="<?php print $value['downloadUrl']?>" ><h3><?php print $value['shortTitle']?></h3></a>
                <p>
                    <span class="farmName"><?php print $value['date']?></span>
                </p>
            </div>           
         <?php
         }
         ?>
	</section>
</main>
