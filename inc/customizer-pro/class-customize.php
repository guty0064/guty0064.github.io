<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Blogger_Buzz_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		require_once get_theme_file_path('inc/customizer-pro/section-pro.php');

		// Register custom section types.
		$manager->register_section_type( 'Blogger_Buzz_Customize_Section_Pro' );

		// Register Upgrade Pro Section.
		$manager->add_section(
			new Blogger_Buzz_Customize_Section_Pro(
				$manager,
				'bloggerbuzzpro',
				array(
					'title'    => '',
					'pro_text' => esc_html__( 'Upgrade To Blogger Buzz Pro','blogger-buzz' ),
					'pro_url'  => 'https://sparklewpthemes.com/wordpress-themes/bloggerbuzzpro/',
					'priority'  => 1,
				)
			)
		);

		// Register Documentation Section.
		$manager->add_section(
			new Blogger_Buzz_Customize_Section_Pro(
				$manager,
				'bloggerbuzzdoc',
				array(
					'title'    => esc_html__( 'Documentation', 'blogger-buzz' ),
					'pro_text' => esc_html__( 'View','blogger-buzz' ),
					'pro_url'  => 'http://docs.sparklewpthemes.com/bloggerbuzz/',
					'priority'  => 1,
				)
			)
		);

	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'bloggerbuzzpro-customize-controls', trailingslashit( get_template_directory_uri() ) . 'inc/customizer-pro/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'bloggerbuzzpro-customize-controls', trailingslashit( get_template_directory_uri() ) . 'inc/customizer-pro/customize-controls.css' );
	}
}

// Doing this customizer thang!
Blogger_Buzz_Customize::get_instance();


if ( class_exists( 'WP_Customize_Control' ) ) {
	if ( !class_exists( 'Blogger_Buzz_Upgrade_Text' ) ) {
		class Blogger_Buzz_Upgrade_Text extends WP_Customize_Control {

	        public $type = 'blogger-buzz-upgrade-text';

	        public function render_content() {
	            ?>
	            <label>
	                <span class="dashicons dashicons-info"></span>

	                <?php if ($this->label) { ?>
	                    <span>
	                        <?php echo wp_kses_post($this->label); ?>
	                    </span>
	                <?php } ?>

	                <a href="<?php echo esc_url('https://sparklewpthemes.com/wordpress-themes/bloggerbuzzpro/'); ?>" target="_blank"> <strong><?php echo esc_html__('Upgrade to PRO', 'blogger-buzz'); ?></strong></a>
	            </label>

	            <?php if ($this->description) { ?>
	                <span class="description customize-control-description">
	                    <?php echo wp_kses_post($this->description); ?>
	                </span>
	                <?php
	            }

	            $choices = $this->choices;
	            if ($choices) {
	                echo '<ul>';
	                foreach ($choices as $choice) {
	                    echo '<li>' . esc_html($choice) . '</li>';
	                }
	                echo '</ul>';
	            }
	        }

	    }
	}
}