<?php
if (!defined("FEEDBLITZ_MAILVERIFY_URL")) {
  define("FEEDBLITZ_MAILVERIFY_URL", "http://www.feedblitz.com/f/f.fbz?AddNewUserDirect&ajax=4");
  
}


function feedblitz_shortcode( $atts ) {
	extract(shortcode_atts(array(
		'id'		=> '',
		'publisher_id'		=> '',		
		'instructions'	=> '',
		'text'	=>'',
		'submit'		=> 'Subscribe'
	), $atts ));
		
	$html='
    <form name="feedblitzform"  method="POST" target="popupwindow" action="'.FEEDBLITZ_MAILVERIFY_URL.'"  onsubmit="window.open(\''.FEEDBLITZ_MAILVERIFY_URL.'\', \'popupwindow\', \'scrollbars=yes,width=550,height=520\');return true" _lpchecked="1">
 <p class="sub_instruct"> '.$instructions .'</p>
 <p class="sub_instruct"> <input class="feedblitz-shortcode"  name="EMAIL" maxlength="64" type="text"  value="'.$text.'">
 <input name="EMAIL_" maxlength="64" type="hidden"  value="">
 <input name="EMAIL_ADDRESS" maxlength="64" type="hidden" size="25" value=""></p>
 <input name="FEEDID" type="hidden" value="'.$id.'">
 <input name="PUBLISHER" type="hidden" value="'.$publisher_id.'">
 <input type="submit" value="'.$submit.'">
</form>
  ';
	 return $html;
?>
<script language="Javascript">function feedblitzformi(){var x=document.getElementsByName('feedblitzform');for(i=0;i<x.length;i++){x[i].EMAIL.style.display='block';}}feedblitzformi();</script>
 
     
<?php 
}

add_shortcode('feedblitz', 'feedblitz_shortcode');

?>