<?php
/**
 * Adds Newsmatic_Carousel_Widget widget.
 * 
 * @package Newsmatic
 * @since 1.0.0
 */
class Newsmatic_Carousel_Widget extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'newsmatic_carousel_widget',
            esc_html__( 'Newsmatic : Carousel Posts', 'newsmatic' ),
            array( 'description' => __( 'A collection of posts from specific category for carousel slide.', 'newsmatic' ) )
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        $widget_title = isset( $instance['widget_title'] ) ? $instance['widget_title'] : '';
        $posts_category = isset( $instance['posts_category'] ) ? $instance['posts_category'] : '';
        $image_size = isset( $instance['image_size'] ) ? $instance['image_size'] : 'newsmatic-grid';
        $image_ratio = isset( $instance['image_ratio'] ) ? $instance['image_ratio'] : json_encode(array('desktop'   => 0.6,'tablet'    => 0.6,'smartphone'=> 0.6));
        $image_border_radius = isset( $instance['image_border_radius'] ) ? $instance['image_border_radius'] : json_encode(array('desktop'   => 0,'tablet'    => 0,'smartphone'=> 0));
        
        echo wp_kses_post($before_widget);

        if( isset( $args['widget_id'] ) ) :
            ?>
            <style id="<?php echo esc_attr( $args['widget_id'] ); ?>">
                <?php
                    $image_ratio = json_decode($image_ratio);

                    echo "#" .$args['widget_id']. " figure.post-thumb-wrap { padding-bottom: calc( " .$image_ratio->desktop. " * 100% ) }\n";
                    echo "@media (max-width: 769px){ #" .$args['widget_id']. " figure.post-thumb-wrap { padding-bottom: calc( " .$image_ratio->tablet. " * 100% ) } }\n";
                    echo "@media (max-width: 548px){ #" .$args['widget_id']. " figure.post-thumb-wrap { padding-bottom: calc( " .$image_ratio->smartphone. " * 100% ) } }\n";


                    $image_border_radius = json_decode($image_border_radius);

                    echo "#" .$args['widget_id']. " figure.post-thumb-wrap img { border-radius: " .$image_border_radius->desktop. "px }\n";
                    echo "@media (max-width: 769px){ #" .$args['widget_id']. " figure.post-thumb-wrap img { border-radius: " .$image_border_radius->tablet. "px } }\n";
                    echo "@media (max-width: 548px){ #" .$args['widget_id']. " figure.post-thumb-wrap img { border-radius: " .$image_border_radius->smartphone. "px } }\n";
                ?>
            </style>
            <?php 
        endif;

            // Slider direction
            $newsmatic_widget_attr = '';
            $newsmatic_widget_attr .= ' newsmatic_horizontal_slider';
            if( empty( $widget_title ) ) $newsmatic_widget_attr .= ' no_heading_widget';
            $newsmatic_widget_attr .= ' layout--one';
            ?>
            <div class="newsmatic-widget-carousel-posts<?php echo esc_attr($newsmatic_widget_attr); ?>">
                <?php if ($widget_title ): ?>
                    <h2 class="widget-title">
                        <span><?php echo esc_html($widget_title); ?></span>
                    </h2>
                <?php endif; ?>
                <div class="carousel-posts-wrap" data-auto="true" data-arrows="true" data-loop="true" data-vertical="horizontal">
                    <?php
                        $carousel_posts_args = array( 
                                    'numberposts' => -1,
                                    'category_name' => esc_html( $posts_category )
                                );
                        if( empty( $posts_category ) ) $carousel_posts_args['numberposts'] = 4;
                        $carousel_posts_args = apply_filters( 'newsmatic_query_args_filter', $carousel_posts_args );
                        $carousel_posts = get_posts( $carousel_posts_args );
                        if( $carousel_posts ) :
                            $total_posts = sizeof($carousel_posts);
                            foreach( $carousel_posts as $carousel_post_key => $carousel_post ) :
                                $carousel_post_id  = $carousel_post->ID;
                            ?>
                                    <article class="post-item <?php if(!has_post_thumbnail($carousel_post_id)){ echo esc_attr('no-feat-img');} ?>">
                                        <figure class="post-thumb-wrap">
                                            <?php if( has_post_thumbnail($carousel_post_id) ): ?> 
                                                <a href="<?php echo esc_url(get_the_permalink($carousel_post_id)); ?>">
                                                    <img src="<?php echo esc_url( get_the_post_thumbnail_url($carousel_post_id, $image_size) ); ?>"/>
                                                </a>
                                            <?php endif; ?>
                                            <?php newsmatic_get_post_categories($carousel_post_id,2); ?>
                                        </figure>
                                        <div class="post-element">
                                            <?php newsmatic_get_post_categories($carousel_post_id,2); ?>
                                            <h2 class="post-title"><a href="<?php the_permalink($carousel_post_id); ?>"><?php echo wp_kses_post( get_the_title($carousel_post_id) ); ?></a></h2>
                                            <div class="post-meta">
                                                <?php newsmatic_posted_on(); ?>
                                            </div>
                                        </div>
                                    </article>
                            <?php
                            endforeach;
                        endif;
                    ?>
                </div>
            </div>
    <?php
        echo wp_kses_post($after_widget);
    }

    /**
     * Widgets fields
     * 
     */
    function widget_fields() {
        $categories = get_categories();
        $categories_options[''] = esc_html__( 'Select category', 'newsmatic' );
        foreach( $categories as $category ) :
            $categories_options[$category->slug] = $category->name. ' (' .$category->count. ') ';
        endforeach;
        return array(
                array(
                    'name'      => 'widget_title',
                    'type'      => 'text',
                    'title'     => esc_html__( 'Widget Title', 'newsmatic' ),
                    'description'=> esc_html__( 'Add the widget title here', 'newsmatic' ),
                    'default'   => esc_html__( 'Highlights', 'newsmatic' )
                ),
                array(
                    'name'      => 'posts_category',
                    'type'      => 'select',
                    'title'     => esc_html__( 'Categories', 'newsmatic' ),
                    'description'=> esc_html__( 'Choose the category to display for carousel posts', 'newsmatic' ),
                    'options'   => $categories_options
                ),
                array(
                    'name'      => 'image_setting_heading',
                    'type'      => 'heading',
                    'label'     => esc_html__( 'Image Setting', 'newsmatic' )
                ),
                array(
                    'name'      => 'image_size',
                    'type'      => 'select',
                    'title'     => esc_html__( 'Image Size', 'newsmatic' ),
                    'default'   => 'newsmatic-grid',
                    'options'   => newsmatic_get_image_sizes_option_array()
                ),
                array(
                    'name'  => 'image_ratio',
                    'type'  => 'responsive-number',
                    'title' => esc_html__( 'Image Ratio', 'newsmatic' ),
                    'min'   => 0,
                    'max'   => 2,
                    'step'  => 0.1,
                    'default'   => json_encode(array(
                        'desktop'   => 0.6,
                        'tablet'    => 0.6,
                        'smartphone'=> 0.6
                    ))
                ),
                array(
                    'name'  => 'image_border_radius',
                    'type'  => 'responsive-number',
                    'title' => esc_html__( 'Image Border Radius', 'newsmatic' ),
                    'min'   => 0,
                    'max'   => 200,
                    'step'  => 1,
                    'default'   => json_encode(array(
                        'desktop'   => 0,
                        'tablet'    => 0,
                        'smartphone'=> 0
                    ))
                )
            );
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $widget_fields = $this->widget_fields();
        foreach( $widget_fields as $widget_field ) :
            if ( isset( $instance[ $widget_field['name'] ] ) ) {
                $field_value = $instance[ $widget_field['name'] ];
            } else if( isset( $widget_field['default'] ) ) {
                $field_value = $widget_field['default'];
            } else {
                $field_value = '';
            }
            newsmatic_widget_fields( $this, $widget_field, $field_value );
        endforeach;
    }
 
    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $widget_fields = $this->widget_fields();
        if( ! is_array( $widget_fields ) ) {
            return $instance;
        }
        foreach( $widget_fields as $widget_field ) :
            $instance[$widget_field['name']] = newsmatic_sanitize_widget_fields( $widget_field, $new_instance );
        endforeach;

        return $instance;
    }
 
} // class Newsmatic_Carousel_Widget