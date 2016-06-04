<main>
	<?php print $secondMenuNav?>
	<section class="w80">
		<div class="bar">
			<h1><a class="underline" href="teachers">农业名师</a> &gt;详细信息</h1>
		</div><img alt="<?php print $teacher['teacherName']?>" class="alignCenter w100" src="<?php print $teacher['imgurl']?>">
	</section>
	<section class="w80">
		<div class="bar w100">
			<h2><?php print $teacher['teacherName']?></h2>
			<h3><?php print $teacher['career']?></h3>
			<div id="node-<?php print $teacher['id'];?>" class="floatRight alignRight">
				<?php print $teacher['collectLink'] ?>
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
					<div id="node-<?php print $value['id'];?>" class="block1">
					<?php print $value['collectLink'] ?>
					<img alt="image Here" src="<?php print $value['imgurl']?>">
					<a href="<?php print $value['dataurl']?>" title="<?php print $value['name']?>">
						<h3><?php print $value['shortName']?></h3>
					</a>
					<p>
						<span class="farmName"><?php print $value['teacherName']?></span>
						<span class="floatRight">01</span>
						<span class="floatRight">02</span>
					</p>
					</div>      
    <?php
    }
    ?>
	</section>
</main>
