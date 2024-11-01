<?php
/*
Plugin Name: twitterLink for Wordpress Comment
Plugin URI: http://www.seunze.com/twitterLINK/for_wp_com.html?m=wp
Description: to use twitter as word press comment system via twitterlink
Version: 0.1
Author: Rogi073
Author URI: http://d.hatena.ne.jp/dzd12061/
*/
/*  Copyright rogi073 (email : dzd12061@nifty.ne.jp)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
define('MAGPIE_CACHE_ON', 0); //2.7 Cache Bug
define('MAGPIE_INPUT_ENCODING', 'UTF-8');

// submit text form
function twlink_for_wpcomment_submit($blogowner){
	if (is_single()){
?>
		<form name="tlfc_commentform" id="tlfc_commentform" method="POST" action="http://www.seunze.com/twitterLINK/publish.html?t=fc">
			<p>このサイトのオーナーのtwitterユーザー名:<?PHP echo $blogowner; ?></p>
			<input type="hidden" name="owner" id="owner" value="<?PHP echo $blogowner; ?>" />
			<input type="hidden" name="url" id="url" value="<?PHP echo get_permalink(); ?>" />
			<textarea name="contents" id="contents" cols="100%" rows="3"></textarea>
			twitterユーザー名(orメールアドレス)：<input type="text" name="twitterid" id="twitterid" size="50" style="width:100px" maxlength="200" value=""> 
			<input type="submit" value="確認画面へ" /> powered by <a target="_blank" href="http://www.seunze.com/twitterLINK/index.html">twitterLink</a>
	 	</form>
<?PHP
	}else{
		
	}
}
//link for twitterlink 
function twlink_for_wpcomment_link(){
	return 'http://www.seunze.com/twitterLINK/site.html?url='.rawurlencode(get_permalink());
}
//output comment list
function twlink_for_wpcomment_recieve($count = "all",$list = true){
	include_once(ABSPATH . WPINC . '/rss.php');
	
	$comments = fetch_rss('http://www.seunze.com/twitterLINK/rss/?url='.rawurlencode(get_permalink()));
	if (is_single()){
		$outputted = 0;
		if ($list) echo '<ul class="twitterlink_fwpc">'."\n";;
		
		if ( empty($comments->items) ) {
			if ($list) echo '<li>'."\n";
			echo 'No comment.';
			if ($list) echo '</li>'."\n";
		} else {
			if ($count == "all") {
				$count = count( $comments->items );
			} else {
				if( $count > count( $comments->items ) or $count < 1) $count = count( $comments->items ) ;
			}
			for ( $i = 0; $i < $count; $i++ ){
				$comment = $comments->items[$i];
				if( !in_array( strtolower( $comment['dc']['creator'] ) , explode(',',strtolower( get_option( 'twitterlink-fwpc_opt' ) ) ) )){					
					$com = $comment['dc']['creator'].' ';
					$com.= $comment['description'].' ';
					$com.= '<a target="_blank" href="'.$comment['link'].'">'.date('Y/m/d H:i:s', strtotime( $comment['pubdate'] ) ).'</a>'."\n";
					if ( $list ) echo '<li>'."\n";
					echo $com;
					if ( $list ) echo '</li>'."\n";
					$outputted++;
				}else{
					if ( $count < count($comments->items) ) $count++ ;
				}
			}
			if ( $outputted==0 ){
				if ($list) echo '<li>'."\n";
				echo 'No comment.';
				if ($list) echo '</li>'."\n";
			}
		}
		if ($list) echo '</ul>';
	} else {
		echo count($comments->items).'comments (from twitter)'."\n";
	}
	echo '<p>powered by <a target="_blank" href="http://www.seunze.com/twitterLINK/index.html">twitterLink</a></p>'."\n";
}

// Administration Panel
/*
Plugin Name: twitterLink for Wordpress Comment
Plugin URI: http://www.seunze.com/twitterLINK/for_wp_com.html?m=wp
Description: twitterLInk for WordPress comment option setting
Author: Rogi073
Author URI: http://d.hatena.ne.jp/dzd12061/
*/
add_action('admin_menu', 'twitterlink_fc_menu');

function twitterlink_fc_menu() {
  add_options_page('twitterLink for Wordpress comment Options', 'twitterLink for Wordpress comment', 5, __FILE__, 'twitterlink_fwpc_options');
}

function twitterlink_fwpc_options() {
    // variables for the field and option names 
    $opt_name = 'twitterlink-fwpc_opt';
	$hidden_field_name = 'tlfwpc_h';
    $data_field_name = 'tlfwpc_blocklist';
    // Get Option
    $opt_val = get_option( $opt_name );
    // Update option
    if( $_POST[ $hidden_field_name ]=="Y") {
        // Read their posted value
        $opt_val = $_POST[ $data_field_name ];
        // Save the posted value in the database
        update_option( $opt_name, $opt_val );
        // Put an options updated message on the screen
?>
<div class="updated"><p><strong>Options saved</strong></p></div>
<?php
    }
    // Now display the options editing screen
    echo '<div class="wrap">';
    // header
    echo "<h2>twitterLink for WordPress comment : Option Setting</h2>";
    // options form
    ?>
<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p>コメントを表示しないユーザー名を入力してください（複数の場合は、カンマ区切り　例：abc,cde）。</p>
<p>ここに入力されたユーザーについては、コメントが投稿されたとしても、あなたのサイトの twitterLink のコメントには表示されません。</p>
<textarea name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" cols="50%" rows="3"><?PHP echo $opt_val; ?></textarea>
</p><hr />

<p class="submit">
<input type="submit" name="Submit" value="Update Options" />
</p>

</form>
</div>

<?php
}
?>
