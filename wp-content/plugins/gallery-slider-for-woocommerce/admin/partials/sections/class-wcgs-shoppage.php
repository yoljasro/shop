<?php
/**
 * The gallery tab functionality of this plugin.
 *
 * Defines the sections of gallery tab.
 *
 * @package    Woo_Gallery_Slider_Pro
 * @subpackage Woo_Gallery_Slider_Pro/admin
 * @author     Shapedplugin <support@shapedplugin.com>
 */

/**
 * WCGSP_Lightbox
 */
class WCGSP_Shoppage {
	/**
	 * Specify the Gallery tab for the Woo Gallery Slider.
	 *
	 * @since    1.0.0
	 * @param string $prefix Define prefix wcgs_settings.
	 */
	public static function section( $prefix ) {
		WCGS::createSection(
			$prefix,
			array(
				'name'   => 'shop_page_video',
				'icon'   => 'sp_wgs-icon-video-01-1',
				'title'  => __( 'Shop Page Video', 'gallery-slider-for-woocommerce' ),
				'fields' => array(

					array(
						'id'         => 'wcgs_video_shop',
						'type'       => 'switcher',
						'class'      => 'pro_switcher',
						'title'      => __( 'Show Product Video on the Shop or Archive Page', 'gallery-slider-for-woocommerce' ),
						'title_help' => __( 'The featured image will be replaced by image video.', 'gallery-slider-for-woocommerce' ),
						'title_help' => '<div class="wcgs-img-tag big-tooltip"><img src="' . plugin_dir_url( __DIR__ ) . '/shapedplugin-framework/assets/images/help-visuals/video-shop-page.svg" alt=""></div><a class="wcgs-open-docs" href="https://docs.shapedplugin.com/docs/gallery-slider-for-woocommerce-pro/configurations/how-to-show-product-video-on-the-shop-page/" target="_blank">Open Docs</a><a class="wcgs-open-live-demo" href="https://demo.shapedplugin.com/woo-gallery-slider-pro/shop-or-archive-page-video/" target="_blank">Live Demo</a>',
						'text_on'    => __( 'Show', 'gallery-slider-for-woocommerce' ),
						'text_off'   => __( 'Hide', 'gallery-slider-for-woocommerce' ),
						'text_width' => 80,
						'default'    => false,
					),
					array(
						'id'      => 'zoom_notice',
						'type'    => 'notice',
						'style'   => 'normal',
						'class'   => 'wcgs-light-notice',
						'content' => 'Want to show multiple types of product videos on the <a class="wcgs-open-live-demo" href="https://demo.shapedplugin.com/woo-gallery-slider-pro/shop/" target="_blank"><strong>Shop Page</strong></a> and speed up customer decision-making? <a href="https://shapedplugin.com/plugin/woocommerce-gallery-slider-pro/?ref=143" target="_blank" class="btn"><strong>Upgrade To Pro!</strong></a>',
					),
				),
			)
		);
	}
}
