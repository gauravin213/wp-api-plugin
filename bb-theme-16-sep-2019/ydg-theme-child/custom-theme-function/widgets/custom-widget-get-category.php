<?php
/*
*  Custom Widget Get Category
*/

function wpiw_widget() {
  register_widget( 'custom_widget_get_category' );
}
add_action( 'widgets_init', 'wpiw_widget' );

Class custom_widget_get_category extends WP_Widget {

  function __construct() {
    parent::__construct(
      'null-custom-menu',__( 'Custom Widget Get Category By Slug', 'wp-Custom menu-widget' ),
      array(
        'classname' => 'null-custom-menu',
        'description' => esc_html__( 'Custom Widget Get Category By Slug', 'wp-Custom menu-widget' ),
        'customize_selective_refresh' => true,
      )
    );
  }

  function widget( $args, $instance ) {

    $title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
  
    $target = empty( $instance['target'] ) ? '_self' : $instance['target'];
    
    echo $args['before_widget'];

    if ( ! empty( $title ) ) { echo $args['before_title'] . wp_kses_post( $title ) . $args['after_title']; };

    do_action( 'wpiw_before_widget', $instance );

    /**************/
    echo "==>".$title; echo "<br>";
    echo "==>".$target;
    /**************/

    do_action( 'wpiw_after_widget', $instance );

    echo $args['after_widget'];
  }

  function form( $instance ) {
    $instance = wp_parse_args( (array) $instance, array(
      'title' => __( 'Custom menu', 'wp-Custom menu-widget' ),
      'target' => '_self',
    ) );
    $title = $instance['title'];
    $target = $instance['target'];
    ?>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
        <?php esc_html_e( 'Title', 'wp-Custom menu-widget' ); ?>: 
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
      </label>
    </p>

    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php esc_html_e( 'Select menu', 'wp-Custom menu-widget' ); ?>:
      </label>

      <select id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" class="widefat">

        <option value="regions_menu" <?php selected( 'regions_menu', $target ); ?>>
          <?php esc_html_e( 'regions_menu', 'wp-Custom menu-widget' ); ?>
        </option>

        <option value="popular_destinations_menu" <?php selected( 'popular_destinations_menu', $target ); ?>>
          <?php esc_html_e( 'popular_destinations_menu', 'wp-Custom menu-widget' ); ?>
        </option>
      </select>
    </p>

    <?php

  }

  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags( $new_instance['title'] );
  
    $instance['target'] = $new_instance['target'];

    return $instance;
  }

}