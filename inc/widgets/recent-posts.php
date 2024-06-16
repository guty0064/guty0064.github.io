<?php 
/**
 * Function to Register and load the widget About Us
 *
 * @since 1.0.0
 *
 * @param null
 *
 * @return null
 *
 */
function blogger_buzz_recent_posts() {

    register_widget( 'blogger_buzz_recent_posts' );

}

add_action( 'widgets_init', 'blogger_buzz_recent_posts' );

/*
* Recent Posts Widget.
*/

if (!class_exists('Blogger_Buzz_Recent_Posts')):

	class Blogger_Buzz_Recent_Posts extends WP_Widget{

		private $defaults = array(
            'title'           => '',
            'number_of_posts' => 1,
            'show_date'       => '1',
        );

		function __construct() { 
	        parent:: __construct( 'blogger_buzz_recent_posts', //Base ID
            	esc_html__('BB : Recent Posts', 'blogger-buzz'), //Name
				array('description' => esc_html__('Displays Recent Blog Posts', 'blogger-buzz'),) //args
            );
	    }

	    /**
         * Function to Creating widget front-end. This is where the action happens
         *
         * @access public
         * @since 1.0.0
         *
         * @param array $args widget setting
         * @param array $instance saved values
         *
         * @return void
         *
         */

	    public function widget( $args, $instance ) {

		    $instance = wp_parse_args((array)$instance, $this->defaults);

		    $blog_title      = $instance['title'];
		    $number_of_posts = $instance['number_of_posts'];
		    $show_date		 = $instance['show_date'];

		    echo $args['before_widget'];
		    ?>

		    <div class="custom-recent-post">
		    	<?php 
			    	if (!empty($blog_title)):
			    		echo '<h2 class="'.esc_attr('widget-title').'">'.esc_html($blog_title).'</h2>';
			    	endif;
		    	?>

		        <ul>
		        	<?php 
		        		$blog_args = array(
					        'posts_per_page'   => $number_of_posts,
					        'orderby'          => 'post_date',
					        'order'            => 'DESC',
					        'post_type'        => 'post',
					        'post_status'      => 'publish',
					    );

	                    $blog_query = new WP_Query ($blog_args);

	                    if ( $blog_query->have_posts() ): while ( $blog_query->have_posts() ) : $blog_query->the_post();
                   	?>
                		<li>
                			<?php if (has_post_thumbnail()) :
                    			?>
				                <div class="thumb">
				                    <a href="<?php the_permalink(); ?>">
				                        <?php the_post_thumbnail('thumbnail'); ?>
				                    </a>
				                </div>
				            <?php endif; ?>

			                <div class="info">
			                    <a href="<?php the_permalink(); ?>" class="custom-recent-post-title"><?php the_title(); ?></a>

			                    <?php 
			                    if ( $show_date == 1) :
				                    ?>
				                    <div class="meta-title">
				                        <?php echo get_the_date(); ?>
				                    </div>
				                <?php endif; ?>
			                </div>
			            </li>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
		        </ul>
		    </div>

		    <?php
		    
		    echo $args['after_widget'];
		}

	    /**
         * Widget Backend
         */

	    public function form( $instance ) {

			$instance       = wp_parse_args((array)$instance, $this->defaults);

            $title           = $instance['title'];
            $number_of_posts = $instance['number_of_posts'];
		    $show_date		 = $instance['show_date'];

		    ?>
		    <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                	<?php esc_html_e('Enter Widget Title', 'blogger-buzz'); ?> :
                </label>

                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
            </p>

		    <p>
                <label for="<?php echo esc_attr($this->get_field_id('number_of_posts')); ?>">
                	<?php esc_html_e('Enter Number Of Posts To Display', 'blogger-buzz'); ?> :
                </label>

                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('number_of_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('number_of_posts')); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number_of_posts); ?>"/>

            </p>

            <p>
            	<input class="widefat" id="<?php echo esc_attr($this->get_field_id('show_date')); ?>" name="<?php echo esc_attr($this->get_field_name('show_date')); ?>" type="checkbox" value="1" <?php checked( '1', $show_date ); ?> />

            	<label for="<?php echo esc_attr($this->get_field_id('show_date')); ?>">
                	<?php esc_html_e('Show Post Date', 'blogger-buzz'); ?> :
                </label>
              
            </p>

		    <?php

		}

		/**
         * Function to Updating widget replacing old instances with new
         *
         * @access public
         * @since 1.0.0
         *
         * @param array $new_instance new arrays value
         * @param array $old_instance old arrays value
         *
         * @return array
         *
         */

		public function update( $new_instance, $old_instance ) {
		    $instance = $old_instance;

		    $instance['title'] = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';

		    $instance['number_of_posts'] = ! empty( $new_instance['number_of_posts'] ) ? intval( $new_instance['number_of_posts'] ) : '';

		    $instance['show_date'] = ! empty( $new_instance['show_date'] ) ? isset( $new_instance['show_date'] ) : '';
            
		    return $instance;
		}

	}

endif;