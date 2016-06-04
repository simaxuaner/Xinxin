<!--
    $detailClass:array 	:课程信息
	$teacher:array 		:老师信息
-->
<main>
	<?php print $secondMenuNav?>
	<section class="w80">
		<div class="bar">
			<h1><a class="underline" href="?q=classes.php">农业课堂</a> &gt;详细信息</h1>
		</div>
		<div class="paddingRight w80 floatLeft">
			<video controls preload=""><source src="<?php print $detailClass['dataurl']?>"></video>
		</div>
		<!--等待填充-->
		
			<div id="node-<?php print $teacher['id'];?>" class="block1 w20 floatRight noMargin">
				<?php print $teacher['collectLink'] ?>
				<img src="<?php print $teacher['imgurl']?>">
				<a href="<?php print $teacher['dataurl'] ?>">
					<h3><?php print $teacher['name']?></h3>
				</a>
				<p><span class="farmName"><?php print $teacher['career']?></span><span class="floatRight">01</span><span class="floatRight">02</span></p>
			</div>
		
	</section>
	<section class="w80">
		<!--0604丢弃
		<div class="bar">
			<div class="w20 floatRight marginLeft alignRight">
				<a class="favLink" href="#">加入收藏</a>
			</div>
			<div class="w80">
				<h2><?php print $detailClass['className']?></h2>
				<div class="button floatRight">
					<a href="#">立即报名!</a>
				</div>
			</div>
		</div>
		-->
		<table class="schedule w20 floatRight">
			<tr>
				<td>讲师:</td>
				<td class="alignRight" colspan="2"><?php print $detailClass['teacherName']?></td>
			</tr>
			<tr>
				<td>开课方:</td>
				<td class="alignRight" colspan="2"><?php print $detailClass['owner']?></td>
			</tr>
			<tr>
				<td>开课地点:</td>
				<td class="alignRight" colspan="2"><?php print $detailClass['classRoom']?></td>
			</tr>
			<tr>
				<td>课时:</td>
				<td class="alignRight" colspan="2"><?php print $detailClass['lessons']?></td>
			</tr>
			<tr>
				<td>课程类型:</td>
				<td class="alignRight" colspan="2"><?php print $detailClass['classType']?></td>
			</tr>
			<!--动态获取课程列表 -->
            <?php 
            foreach($classList as $key => $value)
            {
            ?>  
				<tr class="lighter">
					<td class="hour alignLeft w20"><?php print $value['index']?></td>
					<td class="subject alignCenter"><?php print $value['teacherName']?></td>
					<td class="progress alignRight w20"><?php print $value['V']?></td>
				</tr>         
            <?php
            }
            ?>
			
			
		</table>
		<div class="w80 floatLeft paddingRight">
			<p><?php print $detailClass['info']?></p>
		</div>
	</section>
	<!--
	<section class="w80">
		<div class="bar">
			<h2>评论</h2>
		</div>
		<table class="comments w100">
			<tr class="comment lighter">
				<td>
					<table>
						<tr>
							<td class="profilePicture" rowspan="3"><img alt="profilePicture" src="images/users/user0.jpg"></td>
							<td class="commenter" colspan="3">
								<a href="#">Guus</a>
							</td>
						</tr>
						<tr>
							<td class="message" colspan="3">表示很赞</td>
						</tr>
						<tr class="alignRight">
							<td>
								<a class="likes" href="#">12 点赞</a>
							</td>
							<td>
								<a class="reply" href="#">回复</a>
							</td>
							<td>
								<a class="share" href="#">分享</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr class="comment">
				<td>
					<table>
						<tr>
							<td class="profilePicture" rowspan="3"><img alt="profilePicture" src="images/users/user0.jpg"></td>
							<td class="commenter" colspan="3">
								<a href="#">蔡某某</a>
							</td>
						</tr>
						<tr>
							<td class="message" colspan="3">表示很赞</td>
						</tr>
						<tr class="alignRight">
							<td>
								<a class="likes" href="#">12 点赞</a>
							</td>
							<td>
								<a class="reply" href="#">回复</a>
							</td>
							<td>
								<a class="share" href="#">分享</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr class="comment lighter">
				<td>
					<table>
						<tr>
							<td class="profilePicture" rowspan="3"><img alt="profilePicture" src="images/users/user0.jpg"></td>
							<td class="commenter" colspan="3">
								<a href="#">陈某某</a>
							</td>
						</tr>
						<tr>
							<td class="message" colspan="3">表示很赞</td>
						</tr>
						<tr class="alignRight">
							<td>
								<a class="likes" href="#">12 点赞</a>
							</td>
							<td>
								<a class="reply" href="#">回复</a>
							</td>
							<td>
								<a class="share" href="#">分享</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</section>
	-->
</main>
