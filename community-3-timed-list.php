<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

widget_css();

$icon_url = widget_data_url( $widget_config['code'], 'icon' );

$file_headers = @get_headers($icon_url);

if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
    $icon_url = null;
}

if( $widget_config['title'] ) $title = $widget_config['title'];
else $title = 'no title';

if( $widget_config['forum1'] ) $bo_table = $widget_config['forum1'];
else $bo_table = bo_table(1);

$limit = 5;

$list = g::posts( array(
			"bo_table" 	=>	$bo_table,
			"limit"		=>	$limit
				)
		);		
?>

<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->
<div class="comm3_timed_list">
    <div class="timed_list_title">		
		<?/*x::url()?>/widget/<?=$widget_config['name']*/?>
		<?if( $icon_url ) echo "<img class='icon' src='".$icon_url."'/>";?>
		<a href='<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>'><?=$title?></a>
		<a class='more_button' href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?=$bo_table?>">자세히</a>
	</div>
    <ul>
	<?php 
	
		// 코멘트가 가장 많은 글 1개의 글번호를 가져온다.
			$most_commented_wr_id = array();
			foreach ( $list as $li ) {
				$most_commented_wr_id[$li['wr_id']] = $li['comment_cnt'];
				
			}
			arsort( $most_commented_wr_id );
			array_pop($most_commented_wr_id);
			array_pop($most_commented_wr_id);
			array_pop($most_commented_wr_id);
			array_pop($most_commented_wr_id);
			
		
		
	?>
	
	
    <?php for ($i=0; $i<count($list); $i++) {
			if ( $list[$i]['comment_cnt'] ) {
				foreach ( $most_commented_wr_id as $key => $value ) {
					if ( $key == $list[$i]['wr_id'] ) $add_color = "style='color: #cc4235; font-weight: bold;'";
					else $add_color = null;
				}
			}
			else $add_color = null;
	?>
        <li>
		
            <?php 			
            echo "<span class='subject'><img class='dot' src='".x::url()."/widget/".$widget_config['name']."/img/square-icon.png' /><a $add_color href=\"".$list[$i]['url']."\">".$list[$i]['wr_subject']."</a></span>";
			
			if( !$list[$i]['comment_cnt'] ) $comment_count = "<span class='comment_count no-comment'>0</span>";
			else $comment_count = "<span class='comment_count'>".$list[$i]['comment_cnt']."</span>";
			$date_and_time = explode(" ",$list[$i]['wr_datetime']);
			if( $date_and_time[0] == date("Y-m-d") ) $post_date = $date_and_time[1];
			else $post_date = $date_and_time[0];
			?>				
				<div class='comment_and_time'>
					<?=$comment_count?>
					<span class='time'><?=$post_date?></span>
				</div>
			<div style='clear:both'></div>
        </li>
    <?php }  ?>
    <?php if (count($list) == 0) { //게시물이 없을 때  ?>
		<li><span class='subject'><img class='dot' src='<?=$latest_skin_url?>/img/square-icon.png' /><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=5'>사이트 만들기 안내</a></span></li>
		<li><span class='subject'><img class='dot' src='<?=$latest_skin_url?>/img/square-icon.png' /><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=4'>블로그 만들기</a></span></li>
		<li><span class='subject'><img class='dot' src='<?=$latest_skin_url?>/img/square-icon.png' /><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=3' style='color: #cc4235; font-weight: bold;'>커뮤니타 사이트 만들기</a></span></li>
		<li><span class='subject'><img class='dot' src='<?=$latest_skin_url?>/img/square-icon.png' /><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=2'>여행사 사이트 만들기</a></span></li>
		<li><span class='subject'><img class='dot' src='<?=$latest_skin_url?>/img/square-icon.png' /><a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=1'>(모바일)홈페이지, 스마트폰 앱</a></span></li>
    <?php }  ?>
    </ul>
    <div style='clear:both'></div>
</div>
<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->