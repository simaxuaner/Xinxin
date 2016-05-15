<!--
	modulePath 	:模块的地址前缀
	fileList 	:文件列表
	content 	:下载介绍
-->
<?php print $secondMenuNav?>
<div class="bar w80">		
	<img class="icon" src="<?php print $modulePath?>/images/icons/files_icon.png"><h1>资料下载</h1>
</div>
<section class="w80">
	<p><?php print $content?></p>
	<br/>
	<ul>
		<!--动态获取文档列表 -->
        <?php 
        foreach($fileList as $key => $value)
        {
        ?>  
			<li>
				<a href="<?php print $value['url']?>">
				<?php print $value['filename']?>
				<img class="icon" src="<?php print $modulePath?>/images/icons/pdf.png" alt=".pdf"/></a>				
			</li>
        <?php
        }
        ?>
		
	</ul>			
</section>