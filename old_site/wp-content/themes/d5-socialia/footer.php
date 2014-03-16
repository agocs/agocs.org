<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 * A D5 Creation Theme
 
 */
?>

	</div><!-- #main -->

	</div><!-- #page -->

<div id="background-bottom">
	<footer id="colophon" role="contentinfo">

			<?php
				/* A sidebar in the footer? Yep. You can can customize
				 * your footer with four columns of widgets.
				 */
				get_sidebar( 'footer' );
			?>


			<div id="creditline">
            
            <a href="#" target="_blank">Terms of Use</a> |
<a href="#" target="_blank">Privacy Policy</a> |  <a href="#" target="_blank">Sitemap</a>&nbsp;&nbsp;&nbsp;
            
        
&copy; Copyright <script type="text/javascript">document.write(new Date().getFullYear())</script>: <?php bloginfo('name'); ?>.&nbsp;&nbsp;&nbsp;

<strong>D5 Socialia</strong> Theme by: <a href="http://d5creation.com" target="_blank"><img  width="30px" src="<?php echo get_template_directory_uri(); ?>/images/d5logofooter.png" /> <strong>D5 Creation</strong></a> | Powered by: <a href="http://wordpress.org" target="_blank">WordPress</a> 

				
			</div>
	</footer><!-- #colophon -->



<?php wp_footer(); ?>
</div> <!-- #background-bottom -->

</body>
</html>