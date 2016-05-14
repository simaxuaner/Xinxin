<!--
	modulePath   :模块连接位置
	$pioneeringContext 	：创业园地内容
	$imageurl 			：创业园地的图片链接地址
    $baseFacilities 	：基础设施
    $trainGuide 		：培训指导
    $careerGuide 		：就业指导
    $careerFinance 		：创业金融
-->
<main>
	<?php print $secondMenuNav?>
	<div class="bar w80">		
		<img class="icon" src="<?php print $modulePath?>/images/icons/campus_icon.png">
		<h1>创业园地</h1>
	</div>
	<section class="w80">
		<img class="w40 floatRight marginLeft marginBottom" src="<?php print $imgurl?>"/>
		<?php print $pioneeringContext?>
	</section>
	<section class="w80">
		<div class="bar">
			<h2>基地设施</h2>
		</div>
		<?php print $baseFacilities?>
	</section>		
	<section class="w80">
		<div class="bar">
			<h2>培训指导</h2>
		</div>
		<?php print $trainGuide?>
	</section>		
	<section class="w80">
		<div class="bar">
			<h2>就业指南</h2>
		</div>
		<?php print $careerGuide?>
	</section>		
	<section class="w80">
		<div class="bar">
			<h2>创业金融</h2>
        </div>
	    <?php print $careerFinance?>
    </section>
</main>