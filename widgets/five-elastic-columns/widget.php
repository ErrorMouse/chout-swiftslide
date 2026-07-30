<?php
/**
 * Widget: Five Elastic Columns
 *
 * Displays a single image split into 5 elastic columns with a hover effect.
 * Controls: image, width, height, border_radius, transition_duration.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Chout_Widget_Five_Elastic_Columns extends \Elementor\Widget_Base {

    public function get_name() {
        return 'chout_five_elastic_columns';
    }

    public function get_title() {
        return esc_html__( 'Five Elastic Columns', 'chout-swiftslide' );
    }

    public function get_icon() {
        return 'chout-icon-fec';
    }

    public function get_categories() {
        return [ 'chout-swiftslide' ];
    }

    public function get_keywords() {
        return [ 'chout', 'elastic', 'columns', 'image', 'hover', 'effect' ];
    }

    /** CSS handle registered in plugin.php */
    public function get_style_depends() {
        return [ 'chout-five-elastic-columns' ];
    }

    // -------------------------------------------------------------------------
    // Controls
    // -------------------------------------------------------------------------
    protected function register_controls() {

        /* ---- TAB: Content ---- */
        $this->start_controls_section(
            'section_image',
            [
                'label' => esc_html__( 'Image', 'chout-swiftslide' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'image',
            [
                'label'   => esc_html__( 'Choose Image', 'chout-swiftslide' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'description' => esc_html__( 'The image will be split evenly into 5 columns.', 'chout-swiftslide' ),
            ]
        );

        $this->end_controls_section();

        /* ---- TAB: Settings ---- */
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__( 'Settings', 'chout-swiftslide' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'width',
            [
                'label'       => esc_html__( 'Width (px)', 'chout-swiftslide' ),
                'type'        => \Elementor\Controls_Manager::NUMBER,
                'default'     => 550,
                'min'         => 100,
                'max'         => 2000,
                'step'        => 1,
                'description' => esc_html__( 'Maximum widget width. Combined with Height to calculate the aspect ratio.', 'chout-swiftslide' ),
            ]
        );

        $this->add_control(
            'height',
            [
                'label'       => esc_html__( 'Height (px)', 'chout-swiftslide' ),
                'type'        => \Elementor\Controls_Manager::NUMBER,
                'default'     => 650,
                'min'         => 100,
                'max'         => 2000,
                'step'        => 1,
                'description' => esc_html__( 'Combined with Width → aspect-ratio: W/H. The frame keeps its ratio on any screen size.', 'chout-swiftslide' ),
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label'   => esc_html__( 'Border Radius (px)', 'chout-swiftslide' ),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 8,
                'min'     => 0,
                'max'     => 100,
                'step'    => 1,
            ]
        );

        $this->add_control(
            'transition_duration',
            [
                'label'       => esc_html__( 'Hover Transition Duration (s)', 'chout-swiftslide' ),
                'type'        => \Elementor\Controls_Manager::NUMBER,
                'default'     => 0.5,
                'min'         => 0.1,
                'max'         => 3,
                'step'        => 0.05,
            ]
        );

        $this->end_controls_section();
    }

    // -------------------------------------------------------------------------
    // Render HTML
    // -------------------------------------------------------------------------
    protected function render() {
        $settings = $this->get_settings_for_display();

        $image_url  = ! empty( $settings['image']['url'] ) ? esc_url( $settings['image']['url'] ) : '';
        $image_alt  = ! empty( $settings['image']['alt'] ) ? esc_attr( $settings['image']['alt'] ) : '';
        $width      = max( 1, intval( $settings['width'] ?? 550 ) );
        $height     = max( 1, intval( $settings['height'] ?? 650 ) );
        $radius     = max( 0, intval( $settings['border_radius'] ?? 8 ) );
        $transition = max( 0.05, floatval( $settings['transition_duration'] ?? 0.5 ) );

        // Unique ID for each widget instance
        $uid = 'chout-fec-' . esc_attr( $this->get_id() );
        ?>

        <style>
            #<?php echo $uid; ?> {
                max-width: <?php echo $width; ?>px;
                aspect-ratio: <?php echo $width; ?> / <?php echo $height; ?>;
                --fice-border-radius: <?php echo $radius; ?>px;
                --fice-transition: <?php echo $transition; ?>s;
            }
        </style>

        <div id="<?php echo $uid; ?>" class="chout-fec">

            <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
            <div class="layout-1">
                <div class="layout-2">
                    <div class="layout-3">
                        <?php if ( $image_url ) : ?>
                            <img src="<?php echo $image_url; ?>"
                                 alt="<?php echo $image_alt; ?>"
                                 loading="lazy" />
                        <?php endif; ?>
                    </div>
                    <div class="fiec-boder"></div>
                </div>
            </div>
            <?php endfor; ?>

        </div>
        <?php
    }

    /** Live preview template for Elementor editor */
    protected function content_template() {
        ?>
        <#
        var uid = 'chout-fec-preview';
        var imageUrl = settings.image.url || '';
        var width  = settings.width  || 550;
        var height = settings.height || 650;
        var radius = settings.border_radius || 8;
        var trans  = settings.transition_duration || 0.5;
        #>
        <style>
            #{{ uid }} {
                max-width: {{ width }}px;
                aspect-ratio: {{ width }} / {{ height }};
                --fice-border-radius: {{ radius }}px;
                --fice-transition: {{ trans }}s;
            }
        </style>
        <div id="{{ uid }}" class="chout-fec">
            <# for( var i = 0; i < 5; i++ ) { #>
            <div class="layout-1">
                <div class="layout-2">
                    <div class="layout-3">
                        <# if ( imageUrl ) { #>
                        <img src="{{ imageUrl }}" alt="" />
                        <# } #>
                    </div>
                    <div class="fiec-boder"></div>
                </div>
            </div>
            <# } #>
        </div>
        <?php
    }
}
