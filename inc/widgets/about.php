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
function blogger_buzz_about() {

    register_widget( 'blogger_buzz_about' );

}

add_action( 'widgets_init', 'blogger_buzz_about' );

/*
* About Widget.
*/

if (!class_exists('blogger_buzz_about')):

	class blogger_buzz_about extends WP_Widget{

		private $defaults = array(

			'bg_image'    => '',
            'page_id'     => 0, 
			'title'       => '',                       
            'designation' => '',
            'facebook'    => '',
            'twitter'     => '',
            'instagram'   => '',
            'youtube'     => '',
        );

        function __construct(){
            parent:: __construct( 
            	'blogger_buzz_about', //ID
				esc_html__('BB : About', 'blogger-buzz'), //Name
				array('description' => esc_html__('Displays About Me', 'blogger-buzz'),) //args
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
        public function widget($args, $instance){

            $instance      = wp_parse_args((array)$instance, $this->defaults);

            $title       = $instance['title'];
            $bg_image    = $instance['bg_image'];            
            $about_page  = $instance['page_id'];
            $designation = $instance['designation'];
            $facebook    = $instance['facebook'];
            $twitter     = $instance['twitter'];
            $instagram   = $instance['instagram'];
            $youtube     = $instance['youtube'];

            echo $args['before_widget'];

            $aboutus_args = array(
                'page_id' => $about_page,
                'posts_per_page' => 1,
            );

            $aboutus_query = new WP_Query($aboutus_args);

            if ($aboutus_query->have_posts()) : while ($aboutus_query->have_posts()) : $aboutus_query->the_post(); ?>
	            <div class="widget bz_about_me">
	            	<?php 
		            	if (!empty($title)):
		            		echo '<h2 class="'.esc_attr('widget-title').'">'.esc_html($title).'</h2>';
		            	endif;
	            	?>

			        <div class="aspen-bio-block image-circle align-center">
			            
                        <div class="bio-background"style="background-image: url(<?php echo esc_url( $bg_image ); ?>);"></div>
			            
                        <div class="bio-header">
			                <a href="<?php the_permalink(); ?>">
                                
			                    <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="bio-inner">
                                        <?php the_post_thumbnail('thumbnail'); ?>
                                    </div>
                                <?php endif; ?>

			                    <div class="bio-info">

			                        <h3><?php the_title(); ?></h3>

			                        <?php 
				                        if (!empty($designation)):
				                        	echo '<p class="'.esc_attr('bio-job').'">'.esc_html($designation).'</p>';
				                        endif;
			                        ?>
			                    </div>
			                </a>
			            </div>

			            <?php the_excerpt(); ?>

			            <div class="social-link">
			                <ul>
			                	<?php 
				                	if ($facebook):
				                		echo '<li><a href="'.esc_url($facebook).'"><i class="'.esc_attr('fab fa-facebook-f').'"></i> </a></li>';
				                	endif;

				                	if ($twitter):
				                		echo '<li><a href="'.esc_url($twitter).'"><i class="'.esc_attr('fab fa-twitter').'"></i> </a></li>';
				                	endif;

				                	if ($instagram):
				                		echo '<li><a href="'.esc_url($instagram).'" ><i class="'.esc_attr('fab fa-instagram').'"></i> </a></li>';
				                	endif;

				                	if ($youtube):
				                		echo '<li><a href="'.esc_url($youtube).'" ><i class="'.esc_attr('fab fa-youtube').'"></i> </a></li>';
				                	endif;
			                	?>
			                </ul>
			            </div>
			        </div>
			    </div>

		    <?php endwhile; wp_reset_postdata(); endif;
            
            echo $args['after_widget'];
        }


        /**
         * Widget Backend
         */

        public function form($instance){

        	$instance       = wp_parse_args((array)$instance, $this->defaults);

        	$title          = $instance['title'];
        	$bg_image       = $instance['bg_image'];
        	$page_id 		= absint($instance['page_id']);
        	$designation 	= $instance['designation'];
            $facebook 		= $instance['facebook'];
            $twitter 		= $instance['twitter'];
            $instagram 		= $instance['instagram'];
            $youtube       	= $instance['youtube'];

            ?>

            <!-- title -->
            <p>
                <label class="cons_light_title" for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                	<?php esc_html_e('Enter Widget Title', 'blogger-buzz'); ?> :
                </label>

                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
            </p>

            <!-- bcakground Image -->
            <p>
                <label class="cons_light_title" for="<?php echo esc_attr($this->get_field_id('bg_image')); ?>">
                    <?php esc_html_e('Select Background Image', 'blogger-buzz'); ?>:
                </label><br>

                <?php

                $blogger_buzz_display_none = '';

                if (empty($bg_image)){ $blogger_buzz_display_none = ' style="display:none;" '; }

                ?>
                <span class="img-preview-wrap" <?php echo wp_kses_post($blogger_buzz_display_none); ?>>
                    <img class="widefat" src="<?php echo esc_url($bg_image); ?>" alt="<?php esc_attr_e('Image preview', 'blogger-buzz'); ?>"/>
                </span><!-- .img-preview-wrap -->

                <input type="hidden" class="widefat" name="<?php echo esc_attr($this->get_field_name('bg_image')); ?>" id="<?php echo esc_attr($this->get_field_id('bg_image')); ?>" value="<?php echo esc_url($bg_image); ?>"/>

                <input type="button" value="<?php esc_attr_e('Upload Image', 'blogger-buzz'); ?>" class="button media-image-upload" data-title="<?php esc_attr_e('Select Background Image', 'blogger-buzz'); ?>" data-button="<?php esc_attr_e('Select Background Image', 'blogger-buzz'); ?>"/>

                <input type="button" value="<?php esc_attr_e('Remove Image', 'blogger-buzz'); ?>"class="button media-image-remove"/>

            </p>

            <p>
                <label class="cons_light_title" for="<?php echo esc_attr($this->get_field_id('page_id')); ?>">
                	<?php esc_html_e('Select Page', 'blogger-buzz'); ?> :
                </label>
                <br/>
                <?php
                    /* see more here https://codex.wordpress.org/Function_Reference/wp_dropdown_pages*/
                    $args = array(
                        'selected'    		=> $page_id,
                        'name'        		=> $this->get_field_name('page_id'),
                        'id' 		  		=> $this->get_field_id('page_id'),
                        'class' 	        => 'widefat',
                        'show_option_none'  => esc_html__('Select Page', 'blogger-buzz'),
                        'option_none_value' => 0 // string
                    );
                    wp_dropdown_pages($args);
                ?>
            </p>

            <!-- designation -->
            <p>
                <label class="cons_light_title" for="<?php echo esc_attr($this->get_field_id('designation')); ?>">
                	<?php esc_html_e('Enter Designation', 'blogger-buzz'); ?> :
                </label>

                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('designation')); ?>" name="<?php echo esc_attr($this->get_field_name('designation')); ?>" type="text" value="<?php echo esc_attr($designation); ?>"/>
            </p>

            <!-- facebook -->
            <p>
                <label class="cons_light_title" for="<?php echo esc_attr($this->get_field_id('facebook')); ?>">
                	<?php esc_html_e('Enter Facebook Link', 'blogger-buzz'); ?> :
                </label>

                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('facebook')); ?>" name="<?php echo esc_attr($this->get_field_name('facebook')); ?>" type="text" value="<?php echo esc_attr($facebook); ?>"/>
            </p>

            <!-- twitter -->
            <p>
                <label class="cons_light_title" for="<?php echo esc_attr($this->get_field_id('twitter')); ?>">
                	<?php esc_html_e('Enter Twitter Link', 'blogger-buzz'); ?> :
                </label>

                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('twitter')); ?>" name="<?php echo esc_attr($this->get_field_name('twitter')); ?>" type="text" value="<?php echo esc_attr($twitter); ?>"/>
            </p>

            <!-- instagram -->
            <p>
                <label class="cons_light_title" for="<?php echo esc_attr($this->get_field_id('instagram')); ?>">
                	<?php esc_html_e('Enter Instagram Link', 'blogger-buzz'); ?> :
                </label>

                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('instagram')); ?>" name="<?php echo esc_attr($this->get_field_name('instagram')); ?>" type="text" value="<?php echo esc_attr($instagram); ?>"/>
            </p>

            <!-- youtube -->
            <p>
                <label class="cons_light_title" for="<?php echo esc_attr($this->get_field_id('youtube')); ?>">
                	<?php esc_html_e('Enter Youtube Link', 'blogger-buzz'); ?> :
                </label>

                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('youtube')); ?>" name="<?php echo esc_attr($this->get_field_name('youtube')); ?>" type="text" value="<?php echo esc_attr($youtube); ?>"/>
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

        public function update($new_instance, $old_instance){

        	$instance = $old_instance;

        	$instance['title'] = ! empty( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';

        	$instance['bg_image'] = isset($new_instance['bg_image']) ? esc_url_raw($new_instance['bg_image']) : '';

        	$instance['page_id'] = ! empty( $new_instance['page_id'] ) ? absint( $new_instance['page_id'] ) : '';

        	$instance['designation'] = ! empty( $new_instance['designation'] ) ? sanitize_text_field( $new_instance['designation'] ) : '';

        	$instance['facebook'] = ! empty( $new_instance['facebook'] ) ? esc_url_raw( $new_instance['facebook'] ) : '';

        	$instance['twitter'] = ! empty( $new_instance['twitter'] ) ? esc_url_raw( $new_instance['twitter'] ) : '';

        	$instance['instagram'] = ! empty( $new_instance['instagram'] ) ? esc_url_raw( $new_instance['instagram'] ) : '';

        	$instance['youtube'] = ! empty( $new_instance['youtube'] ) ? esc_url_raw( $new_instance['youtube'] ) : '';

        	 return $instance;
		
        }

	}

endif;