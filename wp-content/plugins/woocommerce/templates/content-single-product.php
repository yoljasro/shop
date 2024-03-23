<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summary' );
		
	// $product_id = electro_wc_get_product_id( $product );
	$product_id = $product->get_id(); 
	$product_title = $product->get_title();
	$product_price = $product->get_price();
	$product_url = get_permalink( $product_id );

	$curl = curl_init();

	$url = "https://pay.intend.uz/api/v1/front/calculate?api_key=859C1656C79F6279EA9DC1E5A21DF&price=".$product_price;


	curl_setopt_array($curl, array(
	  CURLOPT_URL => $url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
	    "cache-control: no-cache"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	$month = number_format($product_price/100*139/12);


	$response = json_decode($response, true); //because of true, it's in an array
	$oyliksumma = number_format($response['data']['items'][0]['per_month'], 0, ',', ' ');

		?>

	
	<form action="https://pay.intend.uz" method="post"><input type="hidden" name="duration" value="12">
	<input type="hidden" name="api_key" value="859C1656C79F6279EA9DC1E5A21DF">
	                            <input type="hidden" name="redirect_url" value="<?php echo $product_url; ?>">
	                            <input type="hidden" name="products[0][id]" value="<?php echo $product_id; ?>">
	                            <input type="show" name="products[0][name]" value="<?php echo $product_title; ?>">
	                            <input type="hidden" name="products[0][price]" value="<?php echo $product_price; ?>">
	                            <input type="hidden" name="products[0][weight]" value="1">
	                            <input type="hidden" name="products[0][quantity]" value="1">
	                            <input type="hidden" name="duration" value="12">
	<p style="text-align:center;">
	</p><div class="price_intend">
	<span class="intendlogo">
	<img src="https://intend.uz/wp-content/themes/itrust/images/logo.png?v=1" alt="Intend" title="Рассрочку Intend" style="width: 100px;display: unset;"></span>
	<span class="rassrochkaprice"><?php echo $month; ?> сум/мес</span></div><p></p>
	<div class="product_hover_block"><div class="action">
	<button type="submit" class="cart_button" title="Купить в рассрочку" style="margin-right: 10px;padding: 10px;font-size: 16px;">Bo'lib to'lash</button>
	</div></div></form>

	</div>
                   <p style="text-align:center;"><h5>Hurmatli mijoz! Buyurtma berishdan oldin maxsulot mavjudligini<a href="tel:+998997907240"> (+998 99 790 72 40) </a> <a href="tel:+998772907240"> (+998 77 290 72 40) </a>qo'ng'iroq orqali aniqlashtirib olishingizni so'raymiz!</h5></p>
	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
