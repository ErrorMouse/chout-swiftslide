=== Chout - SwiftSlide ===
Contributors:      nmtnguyen56
Tags:              elementor, image, slider, animation, effect
Requires at least: 5.2
Tested up to:      7.0
Requires PHP:      7.4
Stable tag:        1.0.1
Requires Elementor (free) at least: 4.2.1
License:           GPLv2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

Elementor widgets with elegant image animation effects.

== Description ==

**Chout - SwiftSlide** adds multiple premium Elementor widgets that bring stunning image animation effects to your pages — no coding required.

= Widgets =

**Five Elastic Columns**
Displays a single image split into 5 elastic columns. On hover, the columns smoothly expand and contract, creating a dynamic elastic effect. Fully configurable width, height (aspect ratio), border radius and hover transition speed.

**Three Columns Slide Out**
A slideshow that cycles through multiple images. Each image appears with a dramatic 3-column vertical slide-up reveal animation — with staggered column delays for a polished, professional look. Configurable slide duration, animation speed and border radius.

= Features =

* 2 unique Elementor widgets in a dedicated "Chout - SwiftSlide" panel
* Select images directly from the WordPress Media Library
* Set Width & Height independently — the widget automatically computes `aspect-ratio: W/H` to keep the frame proportional on all screen sizes
* Lightweight: CSS animations only (no heavy JS libraries)
* Slideshow JS is loaded only when the Three Columns Slide Out widget is used
* Live preview in Elementor editor

= Requirements =

* WordPress 5.2 or higher
* [Elementor](https://wordpress.org/plugins/elementor/) (free version is sufficient)
* PHP 7.4 or higher

== Installation ==

1. Upload the `chout-swiftslide` folder to the `/wp-content/plugins/` directory, or install it directly from the WordPress plugin screen.
2. Activate the plugin through the **Plugins** menu in WordPress.
3. Make sure **Elementor** is installed and activated.
4. Open any page in Elementor, search for **"Chout"** in the widget panel.

== Frequently Asked Questions ==

= Does this plugin work without Elementor? =
No. Both widgets are built exclusively for Elementor. The plugin will display an admin notice if Elementor is not active.

= Can I use my own images? =
Yes. Images are selected directly from the WordPress Media Library via the standard Elementor media control.

= How does the aspect ratio work? =
You set a **Width** value and a **Height** value (both in pixels). The plugin calculates `aspect-ratio: Width / Height` as an inline CSS rule. This means the widget scales responsively with the browser window while always maintaining the correct proportions — no distortion.

= Is there a limit to the number of images I can add to a slideshow? =
No limit. All slideshow widgets in this plugin use an Elementor Repeater, allowing you to add an unlimited number of images.

= Will the widgets slow down my site? =
No. CSS files are registered and enqueued only on pages where the widgets are used. The slideshow JavaScript is similarly loaded on demand and has no external dependencies.

== Changelog ==

= 1.0.1 =
* Tweak: Improved compatibility with Autoptimize's CSS code optimization feature.

= 1.0.0 =
* Initial release
* Five Elastic Columns widget
* Three Columns Slide Out widget

== Upgrade Notice ==

= 1.0.1 =
Improved compatibility with Autoptimize's CSS code optimization feature.

= 1.0.0 =
Initial release.