<?php

namespace XVR\Latest_Post\Admin\Widget;

class Post
{

    private $default_num_of_posts = 5;
    private $default_sorting = 'ASC';
    
    private $widget_id = 'xvr_latest_posts_widget';
    protected $query;

    public function __construct()
    {
        add_action('admin_init', [$this, 'process_widget_form']);
        add_action('wp_dashboard_setup', [$this, 'add_latest_posts']);
    }

    public function add_latest_posts()
    {
        wp_add_dashboard_widget($this->widget_id, __('Latest Posts', 'xvr-latest-posts'), [$this, 'render']);
    }

    public function render() {
        include dirname( __DIR__, 1 ) . '/views/latest-post-widget.php';

        if( empty( $this->query ) ) {
            $this->query = $this->get_filtered_posts( [ 'posts_per_page' => $this->default_num_of_posts ] );
        }

        if ( $this->query->have_posts() ) {
            while ($this->query->have_posts()) {
                $this->query->the_post();
                ?>
                    <h3><a href="<?php echo get_permalink() ?>"><?php echo the_title() ?></a></h3>
                <?php
            }
        }
        wp_reset_postdata();
    }

    public function process_widget_form() {
        if (!isset($_POST['submit_post_widget'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['_wpnonce'], 'xvr_pw_nonce')) {
            wp_die('Action not available');
        }

        if (!current_user_can('manage_options')) {
            wp_die('No permision to see this page');
        }

        $num_of_posts = isset($_POST['num-of-posts']) ? sanitize_text_field($_POST['num-of-posts']) : '';
        $sort_posts_by = isset($_POST['sort-posts-by']) ? sanitize_option( 'sort-posts-by', $_POST['sort-posts-by']) : '';

        if ( ! $num_of_posts ) {
            $num_of_posts = $this->default_num_of_posts;
        }

        if ( ! $sort_posts_by) {
            $sort_posts_by = $this->default_sorting;
        }

        $params = [
            'posts_per_page' => $num_of_posts,
            'orderby'        => 'title',
            'order'          => $sort_posts_by,
        ];

        $this->query = $this->get_filtered_posts($params);
    }

    public function get_filtered_posts( $params ) {
        return new \WP_Query($params);
    }
}
