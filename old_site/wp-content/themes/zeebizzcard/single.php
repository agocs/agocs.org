<?php get_header(); ?>

	<div id="content">

		<?php if (have_posts()) : while (have_posts()) : the_post();
		
			get_template_part( 'loop', 'single' );
		
		endwhile; ?>

		<?php endif; ?>
			
<?php // Show Author Box
	$options = get_option('themezee_options');
	if(isset($options['themeZee_show_author_box']) and $options['themeZee_show_author_box'] == 'true') : ?>
		<div class="author_box">
			<div class="author_image"><?php echo get_avatar( get_the_author_meta('user_email'), '70'); ?></a></div>
			<div class="author_info">       
				<h5><?php _e('About the Author:', 'themezee_lang'); ?> <?php the_author_meta('display_name') ?></h5>
				<div class="author_description"><?php the_author_meta('description') ?></div>
					
				<?php if(get_the_author_meta('user_url') != '') : ?>
					<div class="author_website">
						<?php _e('Author Website: ', 'themezee_lang'); ?>
						<a href="<?php the_author_meta('user_url'); ?>" title="Author Website"><?php the_author_meta('user_url'); ?></a>
					</div>
				<?php endif; ?>
			</div>
			<div class="clear"></div>
		</div>
<?php endif; ?>

		<?php comments_template(); ?>
		
	</div>
	
	<?php get_footer(); ?>
<?php get_sidebar(); ?>	