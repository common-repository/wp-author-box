<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://ptheme.com/
 * @since      1.0.0
 *
 * @package    Wp_Author_Box
 * @subpackage Wp_Author_Box/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Author_Box
 * @subpackage Wp_Author_Box/public
 * @author     Leo <newbiesup@gmail.com>
 */
class Wp_Author_Box_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	// filter to add author box after post content
	public function WPAB_author_box_filter($content){

		if ( is_singular() ){
			$content .= $this->WPAB_return_author_box();
		}
		return $content;
	}

	// author box function
	private function WPAB_return_author_box() {
		global $post;
		$userID = $post->post_author;

		$fields = array('twitter', 'facebook', 'googleplus');

		$url = get_the_author_meta( 'user_url', $userID );
		$twitter = get_the_author_meta( 'twitter', $userID );
		$facebook = get_the_author_meta( 'facebook', $userID );
		$googleplus = get_the_author_meta( 'googleplus', $userID );

		$bio_avatar = '<div class="pt_bio_avatar">'.get_avatar( get_the_author_meta( 'user_email',$userID ), 60 ).'</div>';

		$content = '<div class="pt-author-box"><div id="pt-author-tabs" class="pt-author-tabs"><ul class="pt-tab-list"><li><a href="#pt_bio"><i class="fa fa-user"></i><span>'.__( 'Author Bio', $this->plugin_name ).'</span></a></li>';

		if ($twitter) {
			$content .= '<li><a href="#pt_twitter"><i class="fa fa-twitter-square"></i><span>'.__( 'Twitter', $this->plugin_name ).'</span></a></li>';
		}
		if ($facebook) {
			$content .= '<li><a href="#pt_facebook"><i class="fa fa-facebook-square"></i><span>'.__('Facebook' , $this->plugin_name ).'</span></a></li>';
		}
		if ($googleplus) {
			$content .= '<li><a href="#pt_googleplus"><i class="fa fa-google-plus-square"></i><span>'.__( 'Google+', $this->plugin_name ).'</span></a></li>';
		}			

		$content .= '<li><a href="#pt_latest_posts"><i class="fa fa-bookmark"></i><span>Latest Posts</span></a></li></ul>';
		$content .= '<div id="pt_bio" class="pt-author-tab">'
						.$bio_avatar.
						'<div class="pt_bio_text"><h4>'.get_the_author_meta( 'display_name', $userID).'</h4>'.get_the_author_meta( 'description',$userID );
		if ($url) {
			$content .= '<a rel="nofollow" target="_blank" href="'.$url.'"><br />'.__('Visit my website', $this->plugin_name).'</a>';
		}			
			$content .=	'</div></div>';

		if ($twitter) {
			$content .= '<div id="pt_twitter" class="pt-author-tab">'
							.$bio_avatar.
							'<div class="pt_bio_text"><h4><a href="http://twitter.com/'.$twitter.'" target="_blank" rel="nofollow external">@'.$twitter.'</a></h4>
							<iframe
							  src="//platform.twitter.com/widgets/follow_button.html?screen_name='.$twitter.'"
							  style="width: 300px; height: 20px;"
							  allowtransparency="true"
							  frameborder="0"
							  scrolling="no">
							</iframe></div>
						</div>';
		}
		if ($facebook) {
			$content .= '<div id="pt_facebook" class="pt-author-tab">'
							.$bio_avatar.
							'<div class="pt_bio_text"><iframe src="//www.facebook.com/plugins/likebox.php?href='.$facebook.'&amp;width&amp;height=62&amp;colorscheme=light&amp;show_faces=false&amp;header=false&amp;stream=false&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:62px;" allowTransparency="true"></iframe></div>
						</div>';
		}
		if ($googleplus) {
			$content .= '<div id="pt_googleplus" class="pt-author-tab">'
							.$bio_avatar.
							'<div class="pt_bio_text">
								<h4><a href="'.$googleplus.'" target="_blank" rel="nofollow external">+1 '.get_the_author_meta( 'display_name', $userID).'</a></h4>
								<div class="g-follow" data-annotation="bubble" data-height="20" data-href="'.$googleplus.'" data-rel="author"></div></div>
						</div>';
		}

		$content .= '<div id="pt_latest_posts" class="pt-author-tab">'
						.$bio_avatar.
						'<div class="pt_bio_text">
							<h4><a href="'.get_author_posts_url( $userID ).'">'.__('Latest posts by ', $this->plugin_name).get_the_author_meta( 'display_name', $userID).' (see all)</a></h4>';
		$args = array(
			'posts_per_page'      	 => 5,
			'post_type' 			 => 'post',
			'author'    			 => $userID,
			'ignore_sticky_posts' 	 => 1,
			'no_found_rows' 		 => true,
			'update_post_term_cache' => false,
	    	'update_post_meta_cache' => false,
		);
		$query = new WP_Query( $args );
		if ($query->have_posts()) : 
			$content .= '<ul class="pt-author-latest">'; 
			while ( $query->have_posts() ) : $query->the_post();
				$content .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a><span> - '.get_the_date().'</span></li>'; 
			endwhile;
			$content .= '</ul>'; 
		endif; wp_reset_postdata();					

		$content .= '</div></div></div></div>';

		return $content;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Author_Box_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Author_Box_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( 'FontAwesome', plugin_dir_url( __FILE__ ) . 'css/fa/css/font-awesome.min.css', array(), '4.6.3', 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-author-box-public.css', array(), $this->version, 'all' );

		$css = '';

		$css .= 'ul.pt-tab-list li a {';
		if ( get_option('wpab_background') ) {
			$css .= 'background: '.get_option('wpab_background', '#E9E9E9').';';
		}
		if ( get_option('wpab_font_color') ) {
			$css .= 'color: '.get_option('wpab_font_color', '#333333').';';
		}
		$css .= '}';

		$css .= 'ul.pt-tab-list li.ui-tabs-active a, ul.pt-tab-list li a:hover {';
		if ( get_option('wpab_background_hover') ) {
			$css .= 'background: '.get_option('wpab_background_hover', '#41A62A').';';
		}
		if ( get_option('wpab_font_color_hover') ) {
			$css .= 'color: '.get_option('wpab_font_color_hover', '#ffffff').';';
		}
		$css .= '}';

		wp_add_inline_style( $this->plugin_name, $css );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Author_Box_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Author_Box_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		if (! wp_script_is( 'jquery', 'enqueued' )) {
			wp_enqueue_script( 'jquery' );
		} // Don't enqueue jQuery if your theme has already loaded jQuery

		if (! wp_script_is( 'jquery-ui-tabs', 'enqueued' )) {
			wp_enqueue_script( 'jquery-ui-tabs' );
		}

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-author-box-public.js', array( 'jquery' ), $this->version, true );	

	}

}
