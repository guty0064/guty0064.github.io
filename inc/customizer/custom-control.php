<?php 
if(class_exists( 'WP_Customize_control')):

	/**
      * Repeater Custom Control Function
    */
	class Blogger_Buzz_Repeater_Control extends WP_Customize_Control{

		/**
	     * The control type.
	     *
	     * @access public
	     * @var string
	    */

	    public $type = 'repeater';

	    public $bb_box_label = '';

	    public $bb_box_add_control = '';

	    /**
	     * The fields that each container row will contain.
	     *
	     * @access public
	     * @var array
	    */
	    public $fields = array();

	    /**
	     * Repeater drag and drop controler
	     *
	     * @since  1.0.0
	    */

	    public function __construct( $manager, $id, $args = array(), $fields = array() ) {
		    $this->fields = $fields;
		    $this->bb_box_label = $args['bb_box_label'] ;
		    $this->bb_box_add_control = $args['bb_box_add_control'];
		    $this->cats = get_categories(array( 'hide_empty' => false ));
		    parent::__construct( $manager, $id, $args );
	    }

	    public function render_content() {

	     	$values = json_decode($this->value());

	        ?>
	        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

	        <?php if($this->description){ ?>
	            <span class="description customize-control-description">
		        <?php echo wp_kses_post($this->description); ?>
		        </span>
	        <?php } ?>

		    <ul class="bb-repeater-field-control-wrap">
		        <?php $this->bb_get_fields(); ?>
		    </ul>

	      	<input type="hidden" <?php esc_attr( $this->link() ); ?> class="bb-repeater-collector" value="<?php echo esc_attr( $this->value() ); ?>" />

	      	<button type="button" class="button bb-add-control-field">
	      		<?php echo esc_html( $this->bb_box_add_control ); ?>
	      			
	      	</button>
	    	<?php
	    }

	    private function bb_get_fields(){

		    $fields = $this->fields;

		    $values = json_decode($this->value());

		    if(is_array($values)){

		        foreach($values as $value){
		        	?>
				    <li class="bb-repeater-field-control">

				        <h3 class="bb-repeater-field-title accordion-section-title">
				        	<?php echo esc_html( $this->bb_box_label ); ?>
				        </h3>

				        <div class="bb-repeater-fields">
				            <?php
				              foreach ($fields as $key => $field) {

				              $class = isset( $field['class'] ) ? $field['class'] : '';
				            ?>
				            <div class="bb-fields bb-type-<?php echo esc_attr( $field['type'] ).' '.esc_attr( $class ); ?>">

				                <?php

				                  $label = isset($field['label']) ? $field['label'] : '';

				                  $description = isset($field['description']) ? $field['description'] : '';

				                if($field['type'] != 'checkbox'){ ?>

				                    <span class="customize-control-title">
				                    	<?php echo esc_html( $label ); ?>
				                    </span>

				                    <span class="description customize-control-description">
				                    	<?php echo esc_html( $description ); ?>
				                    </span>

				                <?php }

				                  $new_value = isset($value->$key) ? $value->$key : '';

				                  $default = isset($field['default']) ? $field['default'] : '';

				                  switch ( $field['type'] ) {

				                    case 'text':
				                      echo '<input data-default="'.esc_attr($default).'" data-name="'.esc_attr($key).'" type="text" value="'.esc_attr($new_value).'"/>';
				                    break;

				                    case 'url':
				                        echo '<input data-default="'.esc_attr($default).'" data-name="'.esc_attr($key).'" type="text" value="'.esc_attr($new_value).'"/>';

				                    break;

				                    case 'icons':
				                        echo '<div class="bb-repeater-selected-icon">';
				                        echo '<i class="'.esc_attr($new_value).'"></i>';
				                        echo '<span><i class="fa fa-angle-down"></i></span>';
				                        echo '</div>';
				                        echo '<ul class="bb-repeater-icon-list clearfix">';
				                          $blogger_buzz_awesome_icon = blogger_buzz_awesome_icon();

				                          foreach ($blogger_buzz_awesome_icon as $bb_awesome_icon) {
				                            $icon_class = $new_value == $bb_awesome_icon ? 'icon-active' : '';
				                            echo '<li class='.esc_attr( $icon_class ).'><i class="'.esc_attr( $bb_awesome_icon ).'"></i></li>';
				                          }
				                        echo '</ul>';
				                        echo '<input data-default="'.esc_attr($default).'" type="hidden" value="'.esc_attr($new_value).'" data-name="'.esc_attr($key).'"/>';
				                    break;

				                    default:
				                    break;
				                  }
				                ?>
				            </div>
				            <?php } ?>

				            <div class="clearfix bb-repeater-footer">
					            <div class="alignright">
					                <a class="bb-repeater-field-remove" href="#remove"><?php esc_html_e('Delete', 'blogger-buzz') ?></a> |
					                <a class="bb-repeater-field-close" href="#close"><?php esc_html_e('Close', 'blogger-buzz') ?></a>
					            </div>
				            </div>
				        </div>
				    </li>
		      		<?php
		      	}
		    }
		}

	} //end repeater control

	 /**
     * Switch Controller ( Enable or Disable )
    */
    class Blogger_Buzz_Switch_Control extends WP_Customize_Control{

        public $type = 'switch';

        public $switch_label = array();

        public function __construct($manager, $id, $args = array() ){
	        $this->switch_label = $args['switch_label'];
	        parent::__construct( $manager, $id, $args );
        }

        public function render_content(){
        ?>
            <span class="customize-control-title">
               <?php echo esc_html( $this->label ); ?>
            </span>

            <?php if($this->description){ ?>
                <span class="description customize-control-description">
                 <?php echo wp_kses_post( $this->description ); ?>
                </span>
            <?php } ?>

            <?php
                $switch_class = ($this->value() == 'enable') ? 'switch-on' : '';
                $switch_label = $this->switch_label;
            ?>
            <div class="onoffswitch <?php echo esc_attr( $switch_class ); ?>">
                <div class="onoffswitch-inner">
                    <div class="onoffswitch-active">
                        <div class="onoffswitch-switch"><?php echo esc_html( $switch_label['enable'] ) ?></div>
                    </div>

                    <div class="onoffswitch-inactive">
                        <div class="onoffswitch-switch"><?php echo esc_html( $switch_label['disable'] ) ?></div>
                    </div>
                </div>  
            </div>

            <input <?php $this->link(); ?> type="hidden" value="<?php echo esc_attr($this->value()); ?>"/>
         <?php }
    }


	/**
	  * Multiple Check
	*/
    class Blogger_Buzz_Multiple_Check_Control extends WP_Customize_Control {

       /**
        * The type of customize control being rendered.
        *
        * @since  1.0.0
        * @access public
        * @var    string
        */
       public $type = 'checkbox-multiple';

       /**
        * Displays the control content.
        *
        * @since  1.0.0
        * @access public
        * @return void
        */
       	public function render_content() {

			if ( empty( $this->choices ) )
			   return; ?>
			 
			<?php if ( !empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>

			<?php if ( !empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>

			<?php $multi_values = !is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>
				<ul>
					<?php foreach ( $this->choices as $value => $label ) : ?>
				    	<li>
				        	<label>
				            	<input type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values ) ); ?> /> 
				            	<?php echo esc_html( $label ); ?>
				        	</label>
				    	</li>
					<?php endforeach; ?>
				</ul>
			<input type="hidden" <?php esc_url( $this->link() ); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
       <?php } 
    }


    /**
     * Pro Version
     *
     * @since 1.0.1
    */
    class Blogger_Buzz_Customize_Pro_Version extends WP_Customize_Control {

        public $type = 'pro_options';

        public function render_content() {
            echo '<span>'.esc_html_e('Want more ','blogger-buzz').'<strong>'. esc_html( $this->label ) .'</strong>?</span>';
            echo '<a href="'. esc_url( $this->description ) .'" target="_blank">';
              echo '<span class="dashicons dashicons-info"></span>';
              echo '<strong> '. esc_html__( 'See Blogger Buzz Pro', 'blogger-buzz' ) .'<strong></a>';
            echo '</a>';
        }
    }

endif;