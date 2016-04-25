<main>
	<?php print $secondMenuNav?>
	<section class="w80">
		<div class="bar">
			<h1><a class="underline" href="teachers.php">农业名师</a> &gt;详细信息</h1>
		</div><img alt="<?php print $teacher['teacherName']?>" class="alignCenter w100" src="<?php print $teacher['imgurl']?>">
	</section>
	<section class="w80">
		<div class="bar w100">
			<h2><?php print $teacher['teacherName']?></h2>
			<h3><?php print $teacher['career']?></h3>
			<div class="floatRight alignRight">
				<a class="favLink" href="#">加入收藏</a>
			</div>
		</div>
		<div class="w100">
			<p><?php print $teacher['info']?></p>
		</div>
	</section>
	<section class="w80">
		<div class="bar">
			<h2>相关课程</h2>
		</div>
		<!--动态获取课程列表 -->
    <?php 
    foreach($refClassList as $key => $value)
    {
    ?>  
			<a href="<?php print $value['dataurl']?>">
					<div class="block1">
					<span class="fav">收藏</span> 
					<img alt="class" src="<?php print $value['imgurl']?>">
					<h3><?php print $value['name']?></h3>
					<p>
						<span class="farmName"><?php print $value['teacherName']?></span>
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
