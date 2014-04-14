<?php
add_action('widgets_init', create_function('', 'return register_widget("NotificationWidgetFeedblitz");'));

class NotificationWidgetFeedblitz extends DW_Widget {

// Setup class vars
	var $prefix;
	var $textdomain;

  function NotificationWidgetFeedblitz() {  // construct the widget Feedblitz() 
  
	  // Set up the widget options
        $this->prefix = 'feedblitz-email-subscription';
		$this->textdomain = 'feedblitz-email-subscription';	
		$widget_options = array(
			'classname' => 'feedblitz-email-subscription',
			'description' => esc_html__( 'The best way to keep up with your content feed by placing a feedblitz email subscription 			widget on your site.', $this->textdomain )
		);

		// Set up the widget control options
		$control_options = array(
			'width' => 'auto',
			'height' => 'auto',
			'id_base' => $this->prefix
		);
	
parent::WP_Widget(
	$this->prefix, esc_attr__( 'Feedblitz Email Subscription', $this->textdomain ), $widget_options,$control_options );
	
	//attached some css files
	if ( is_active_widget( false, false, $this->id_base ) && ! is_admin() ) {
			wp_enqueue_style("feedblitz-email-subscription", FEEDBLITZ_EMAIL_SUBSCRIPTION_URL . "css/feedblitz-widget.css");
		}
}//close constructor

  function widget($args, $instance) {
    extract( $args );
  	$title = apply_filters('widget_title', $instance['title']);	
	$text = $instance['text'];
    $feed_id = $instance['feed_id']?$instance['feed_id']:get_option('FEEDID') ;
	$publisher_id = $instance['publisher_id']?$instance['publisher_id']:get_option('PUBLISHER');
	$instructions = $instance['instructions'];
	$intro_text = $instance['intro_text'];
	$submit = $instance['submit']?$instance['submit']:'Subscribe';
	$outro_text = $instance['outro_text'];	
    echo $before_widget;
	
	/*	checks if feed id and publisher id are configured ,display the form if configured properly, else returns error message*/
	if ((!empty($feed_id) && !empty($publisher_id))){
	if ($title) echo $before_title . $title . $after_title;	 
?>
  
  
  
  <form name="feedblitzform"  method="POST" target='popupwindow' action="<?php echo FEEDBLITZ_MAILVERIFY_URL; ?>&ajax=4#0"  onsubmit="window.open('<?php echo FEEDBLITZ_MAILVERIFY_URL; ?>&ajax=4#0', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true" _lpchecked="1">
 <p class="sub_instruct"><?php echo $instructions; ?></p>
 <p class="sub_instruct"><?php echo $intro_text; ?></p>
 <p class="feedblitz-email-subscription"> <input style="display:none" name="EMAIL" maxlength="64" type="text"  value="<?php echo $text; ?>" onblur="if(this.value == '') { this.value='<?php echo $text; ?>'}" onfocus="if (this.value == '<?php echo $text; ?>') {this.value=''}">
 <input name="EMAIL_" maxlength="64" type="hidden"  value="">
 <input name="EMAIL_ADDRESS" maxlength="64" type="hidden" size="25" value=""></p>
 <input name="FEEDID" type="hidden" value="<?php  echo $feed_id; ?>">
 <input name="PUBLISHER" type="hidden" value="<?php echo $publisher_id; ?>">
 <input type="submit" value="<?php echo $submit; ?>">
  <p class="sub_instruct"><?php echo $outro_text; ?></p>
</form>



<script language="Javascript">function feedblitzformi(){var x=document.getElementsByName('feedblitzform');for(i=0;i<x.length;i++){x[i].EMAIL.style.display='block';}}feedblitzformi();</script>

  
  
  <?php 
  
  }else{
	  echo '<span style="background-color:#FF0000;color:#fff;padding:20px 15px;font-size:12px">WARNING!,Feed ID and Publisher ID Required!</span>';	  
	  }
	  
  echo $after_widget;
  
  }

  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
	$instance['text'] = $new_instance['text'];
	$instance['instructions'] = $new_instance['instructions'];
    $instance['feed_id'] = $new_instance['feed_id'];
	$instance['publisher_id'] = $new_instance['publisher_id'];
	$instance['intro_text'] = $new_instance['intro_text'];
	$instance['outro_text'] = $new_instance['outro_text'];
	$instance['submit'] = $new_instance['submit']; 
	
    return $instance;
  }

  function form($instance) {
	 // Set up the default form values
		$defaults = array(
			'title' 		=> __( 'Email Subscription', $this->textdomain ),
			'text' 			=> __( 'Your email here', $this->textdomain ),
			'submit' 		=> __( 'Subscribe', $this->textdomain ),
			'intro_text'	=> '',
			'outro_text' 	=> ''
		);

		// Merge the user-selected arguments with the defaults
		$instance = wp_parse_args( (array) $instance,$defaults); 
         extract($instance);
		 
	
	
    $this->text_field("title", $title);
	$this->text_field("text", $text); 
	$this->text_area("instructions", $instructions);
    $this->text_field("feed_id", $feed_id);
	$this->text_field("publisher_id", $publisher_id);
	$this->text_area("intro_text", $intro_text); 
	$this->text_area("outro_text", $outro_text); 
	$this->text_field("submit", $submit); 
	
  }
  
  
}
?>