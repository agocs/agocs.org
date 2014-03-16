<?php
	// Add Theme Twitter Widget
	class themezee_Twitter_Widget extends WP_Widget {
		
		function themezee_Twitter_Widget() {
			$widget_ops = array('classname' => 'themezee_twitter', 'description' => __('Show your latest Tweets', 'themezee_lang') );
			$this->WP_Widget('themezee_twitter', 'ThemeZee Twitter Widget', $widget_ops);
		}
 
		function widget($args, $instance) {        
			extract( $args );
        
			$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
			$user	= empty($instance['user']) ? 'themezee'	: esc_attr($instance['user']);
			
			if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
				$number = 10;
			
			$link = (int)$instance['followme'];
        ?>
			<?php echo $before_widget; ?>
				<?php echo $before_title . $title . $after_title; ?>
				
				<div class="widget-twitter">
					<ul id="twitter_update_list"><li></li></ul>
					
					<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
					<script type="text/javascript" src="http://api.twitter.com/1/statuses/user_timeline/<?php echo $user; ?>.json?count=<?php echo $number; ?>&callback=twitterCallback2"></script>
					  
					<?php if($link == 1) : ?>
						<p><a href="http://twitter.com/<?php echo $user; ?>" class="twitter-follow-button" data-show-count="false">Follow @<?php echo $user; ?></a>
						<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script></p>
					<?php endif; ?>
				</div>
				
			<?php echo $after_widget; ?>
        <?php
		}

		function update($new_instance, $old_instance) {  
			$instance = $old_instance;
			$instance['title'] = isset($new_instance['title']) ? esc_attr($new_instance['title']) : '';
			$instance['user'] = esc_attr($new_instance['user']);
			$instance['number'] =  isset($new_instance['number']) ? (int)$new_instance['number'] : 10;
			$instance['followme'] = isset($new_instance['followme']) ? 1 : 0;
			
			return $instance;
		}
 
		function form($instance) {
			$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
			$user = empty($instance['user']) ? 'themezee'	: esc_attr($instance['user']);
			$number = isset($instance['number']) ? absint($instance['number']) : 5;
			$followme = (isset($instance['followme']) and $instance['followme'] == 1) ? 'checked="checked"' : '';
	?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'themezee_lang'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

			<p><label for="<?php echo $this->get_field_id('user'); ?>"><?php _e('User', 'themezee_lang'); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('user'); ?>" name="<?php echo $this->get_field_name('user'); ?>" type="text" value="<?php echo esc_attr($user); ?>" /></p>
			
			<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of tweets to show:', 'themezee_lang'); ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

			<p><input class="checkbox" type="checkbox" <?php echo $followme; ?> id="<?php echo $this->get_field_id('followme'); ?>" name="<?php echo $this->get_field_name('followme'); ?>" />
			<label for="<?php echo $this->get_field_id('followme'); ?>"><?php _e('Show Follow Button', 'themezee_lang'); ?></label></p>
	<?php
		}
	}
	register_widget('themezee_Twitter_Widget');
?>