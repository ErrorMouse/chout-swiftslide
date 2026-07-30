<?php
/**
 * Widget: Three Columns Slide Out
 *
 * Multi-image slideshow where each image appears via a 3-column slide-up effect.
 * Controls: images (repeater), width, height, slide_duration, anim_duration, border_radius.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Chout_Widget_Three_Columns_Slide_Out extends \Elementor\Widget_Base {

    public function get_name() {
        return 'chout_three_columns_slide_out';
    }

    public function get_title() {
        return esc_html__( 'Three Columns Slide Out', 'chout-swiftslide' );
    }

    public function get_icon() {
        return 'chout-icon-tcso';
    }

    public function get_categories() {
        return [ 'chout-swiftslide' ];
    }

    public function get_keywords() {
        return [ 'chout', 'slide', 'slideshow', 'image', 'effect' ];
    }

    /** CSS handle registered in plugin.php */
    public function get_style_depends() {
        return [ 'chout-three-columns-slide-out' ];
    }

    /** JS handle registered in plugin.php */
    public function get_script_depends() {
        return [ 'chout-three-columns-slide-out' ];
    }

    // -------------------------------------------------------------------------
    // Controls
    // -------------------------------------------------------------------------
    protected function register_controls() {

        /* ---- TAB: Content – Images ---- */
        $this->start_controls_section(
            'section_images',
            [
                'label' => esc_html__( 'Images', 'chout-swiftslide' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Repeater: each item is one image
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'image',
            [
                'label'   => esc_html__( 'Choose Image', 'chout-swiftslide' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'images',
            [
                'label'       => esc_html__( 'Images', 'chout-swiftslide' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [ 'image' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ] ],
                    [ 'image' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ] ],
                    [ 'image' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ] ],
                ],
                'title_field' => esc_html__( 'Image', 'chout-swiftslide' ),
            ]
        );

        $this->end_controls_section();

        /* ---- TAB: Content – Settings ---- */
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
                'description' => esc_html__( 'Maximum width. Combined with Height to calculate the aspect ratio.', 'chout-swiftslide' ),
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
                'description' => esc_html__( 'Combined with Width → aspect-ratio: W/H. The frame scales correctly on any screen size.', 'chout-swiftslide' ),
            ]
        );

        $this->add_control(
            'slide_duration',
            [
                'label'       => esc_html__( 'Slide Duration (ms)', 'chout-swiftslide' ),
                'type'        => \Elementor\Controls_Manager::NUMBER,
                'default'     => 4000,
                'min'         => 500,
                'max'         => 30000,
                'step'        => 100,
                'description' => esc_html__( 'Time (milliseconds) before switching to the next image.', 'chout-swiftslide' ),
            ]
        );

        $this->add_control(
            'anim_duration',
            [
                'label'       => esc_html__( 'Animation Duration (s)', 'chout-swiftslide' ),
                'type'        => \Elementor\Controls_Manager::NUMBER,
                'default'     => 1,
                'min'         => 0.1,
                'max'         => 5,
                'step'        => 0.1,
                'description' => esc_html__( 'Speed of the column slide-up animation when a new image appears.', 'chout-swiftslide' ),
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label'   => esc_html__( 'Border Radius (px)', 'chout-swiftslide' ),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 0,
                'min'     => 0,
                'max'     => 100,
                'step'    => 1,
            ]
        );

        $this->add_control(
            'gap',
            [
                'label'       => esc_html__( 'Gap (px)', 'chout-swiftslide' ),
                'type'        => \Elementor\Controls_Manager::NUMBER,
                'default'     => 2,
                'min'         => 0,
                'max'         => 100,
                'step'        => 1,
                'description' => esc_html__( 'Distance between columns.', 'chout-swiftslide' ),
            ]
        );

        $this->end_controls_section();
    }

    // -------------------------------------------------------------------------
    // Render HTML
    // -------------------------------------------------------------------------
    protected function render() {
        $settings = $this->get_settings_for_display();

        $images         = ! empty( $settings['images'] ) ? $settings['images'] : [];
        $width          = max( 1, intval( $settings['width']          ?? 550  ) );
        $height         = max( 1, intval( $settings['height']         ?? 650  ) );
        $slide_duration = max( 100, intval( $settings['slide_duration'] ?? 4000 ) );
        $anim_duration  = max( 0.1, floatval( $settings['anim_duration']  ?? 1    ) );
        $border_radius  = max( 0, intval( $settings['border_radius']  ?? 0    ) );
        $gap            = max( 0, intval( $settings['gap'] ?? 2 ) );

        // Unique ID for each widget instance
        $uid = 'chout-tcso-' . esc_attr( $this->get_id() );
        ?>

        <style>
            #<?php echo $uid; ?> {
                max-width: <?php echo $width; ?>px;
                aspect-ratio: <?php echo $width; ?> / <?php echo $height; ?>;
                --tcso-anim-duration: <?php echo $anim_duration; ?>s;
                --tcso-border-radius: <?php echo $border_radius; ?>px;
                --tcso-gap: <?php echo $gap; ?>px;
            }
        </style>

        <div id="<?php echo $uid; ?>"
             class="chout-tcso"
             data-slide-duration="<?php echo $slide_duration; ?>">

            <?php foreach ( $images as $idx => $item ) :
                $img_url = ! empty( $item['image']['url'] ) ? esc_url( $item['image']['url'] ) : '';
                $img_alt = ! empty( $item['image']['alt'] ) ? esc_attr( $item['image']['alt'] ) : '';
                $active  = ( $idx === 0 ) ? ' active' : '';
            ?>
            <div class="image-slide<?php echo $active; ?>" data-index="<?php echo $idx; ?>">
                <?php for ( $col = 1; $col <= 3; $col++ ) : ?>
                <div class="slide-out">
                    <div class="layout">
                        <?php if ( $img_url ) : ?>
                            <img src="<?php echo $img_url; ?>"
                                    alt="<?php echo $img_alt; ?>"
                                    decoding="async" />
                        <?php endif; ?>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
            <?php endforeach; ?>

        </div>
        <?php
    }

    /** Live preview template for Elementor editor */
    protected function content_template() {
        ?>
        <#
        var uid    = 'chout-tcso-preview';
        var width  = settings.width  || 550;
        var height = settings.height || 650;
        var animD  = settings.anim_duration  || 1;
        var radius = settings.border_radius  || 0;
        var gap    = (typeof settings.gap !== 'undefined') ? settings.gap : 2;
        var slideD = settings.slide_duration || 4000;
        var images = settings.images || [];
        #>
        <style>
            #{{ uid }} {
                max-width: {{ width }}px;
                aspect-ratio: {{ width }} / {{ height }};
                --tcso-anim-duration: {{ animD }}s;
                --tcso-border-radius: {{ radius }}px;
                --tcso-gap: {{ gap }}px;
            }
        </style>
        <div id="{{ uid }}" class="chout-tcso" data-slide-duration="{{ slideD }}">
            <# _.each( images, function( item, idx ) {
                var activeClass = ( idx === 0 ) ? ' active' : '';
                var imgUrl = item.image ? item.image.url : '';
            #>
            <div class="image-slide{{ activeClass }}" data-index="{{ idx }}">
                <# for ( var c = 0; c < 3; c++ ) { #>
                <div class="slide-out">
                    <div class="layout">
                        <# if ( imgUrl ) { #>
                        <img src="{{ imgUrl }}" alt="" />
                        <# } #>
                    </div>
                </div>
                <# } #>
            </div>
            <# }); #>
        </div>
        <?php
    }
}
