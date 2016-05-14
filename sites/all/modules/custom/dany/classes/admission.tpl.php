<!--
	$modulePath :模块连接位置
	$admission 	:招生信息内容
	$title 			:招生简章的标题
-->
<main>
		<?php print $secondMenuNav?>
		<div class="bar w80">
			<img class="icon" src="<?php print $modulePath?>/images/icons/admission_icon.png">
			<h1><?php print $title?></h1>
		</div>
    <section class="w80">
			<p>
				<?php print $admission?>
			</p>
    </section>
</main>