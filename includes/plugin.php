<?php
/**
 * Chout SwiftSlide – Plugin Manager
 * Registers assets and widgets with Elementor.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Chout_SwiftSlide_Plugin {

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {
        // Register a custom widget category
        add_action( 'elementor/elements/categories_registered', [ $this, 'register_category' ] );

        // Register CSS & JS once Elementor is ready
        add_action( 'elementor/frontend/after_register_styles',  [ $this, 'register_styles'  ] );
        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'register_scripts' ] );

        // Load icon CSS in the Elementor editor panel (admin)
        add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_icons' ] );

        // Register widgets
        add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
    }

    /**
     * Register the "Chout - SwiftSlide" category in the Elementor panel.
     */
    public function register_category( $elements_manager ) {
        $elements_manager->add_category(
            'chout-swiftslide',
            [
                'title' => esc_html__( 'Chout - SwiftSlide', 'chout-swiftslide' ),
                'icon'  => 'fa fa-plug',
            ]
        );
    }

    /**
     * Register CSS for each widget (loaded only when the widget is used).
     */
    public function register_styles() {
        wp_register_style(
            'chout-five-elastic-columns',
            CHOUT_SWIFTSLIDE_URL . 'widgets/five-elastic-columns/style.css',
            [],
            CHOUT_SWIFTSLIDE_VERSION
        );

        wp_register_style(
            'chout-three-columns-slide-out',
            CHOUT_SWIFTSLIDE_URL . 'widgets/three-columns-slide-out/style.css',
            [],
            CHOUT_SWIFTSLIDE_VERSION
        );
    }

    /**
     * Enqueue the custom icon CSS in the Elementor editor so widget icons
     * appear correctly in the panel sidebar.
     */
    public function enqueue_editor_icons() {
        wp_enqueue_style(
            'chout-widget-icons',
            CHOUT_SWIFTSLIDE_URL . 'assets/css/icons.css',
            [],
            CHOUT_SWIFTSLIDE_VERSION
        );
    }

    /**
     * Register JS (loaded only when the TCSO widget is used).
     */
    public function register_scripts() {
        wp_register_script(
            'chout-three-columns-slide-out',
            CHOUT_SWIFTSLIDE_URL . 'widgets/three-columns-slide-out/script.js',
            [],
            CHOUT_SWIFTSLIDE_VERSION,
            true // load at footer
        );
    }

    /**
     * Register widget classes with Elementor.
     */
    public function register_widgets( $widgets_manager ) {
        require_once CHOUT_SWIFTSLIDE_PATH . 'widgets/five-elastic-columns/widget.php';
        require_once CHOUT_SWIFTSLIDE_PATH . 'widgets/three-columns-slide-out/widget.php';

        $widgets_manager->register( new \Chout_Widget_Five_Elastic_Columns() );
        $widgets_manager->register( new \Chout_Widget_Three_Columns_Slide_Out() );
    }
}

Chout_SwiftSlide_Plugin::instance();
