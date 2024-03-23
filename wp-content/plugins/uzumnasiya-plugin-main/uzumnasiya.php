<?php
/*
 * Plugin Name: Uzumnasiya Payment Plugin
 * Plugin URI:  https://github.com/isxoq/uzumnasiya-wp-plugin
 * Description: Uzumnasiya Checkout Plugin for WooCommerce
 * Version: 1.0
 * Author: Isxoqjon Axmedov
 * Author URI: https://github.com/isxoq
 * Text Domain: Uzumnasiya
 * Telegram: @isxoq_ibroximovich
 */

use Uzumnasiya\Uzumnasiya;

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
require('core/uzumnasiya.php');

add_action('plugins_loaded', 'woocommerce_uzumnasiya', 0);


function woocommerce_uzumnasiya()
{
    load_plugin_textdomain('uzumnasiya', false, dirname(plugin_basename(__FILE__)) . '/lang/');

    // Do nothing, if WooCommerce is not available
    if (!class_exists('WC_Payment_Gateway')) {
        return;
    }

    // Do not re-declare class
    if (class_exists('WC_UZUMNASIYA')) {
        return;
    }

    class WC_UZUMNASIYA extends WC_Payment_Gateway
    {


        use Uzumnasiya;

        public $api_key;
        public $apiUrl;
        public $isMocked;
        public $companyId;
        public $default_user;


        function formatPriceType($price)
        {
            return " " . number_format($price, 0, " ", " ");
        }

        public function __construct()
        {
            $plugin_dir = plugin_dir_url(__FILE__);


            // Populate options from the saved settings
//            $this->api_key = $this->get_option('api_key');
//            $this->apiUrl = $this->get_option('api_url');
//            $this->isMocked = $this->get_option('isMocked');
//            $this->companyId = $this->get_option('company_id');
//            $this->default_user = $this->get_option('default_user');
            // Populate options from the saved settings
         $this->api_key = "5e9b1757b3915e43fa06a20c0ccefc6e";
            $this->apiUrl = "https://cabinet.paymart.uz";
            $this->isMocked = true;
            $this->companyId = "222536";
            $this->default_user = "758634";


            $this->id = 'uzumnasiya';
            $this->title = 'Uzumnasiya';
            $cart = WC()->cart;

            if (isset($cart->total)) {

                $total = $cart->total;

                $text = "";
                foreach ($this->calculatePre($total) as $month) {
                    $month_price = $this->formatPriceType($month->month);
                    $text .= "<div class='row'>На {$month->title_ru}ев по {$month_price} сум</div>";
                }
                $this->description = "
            
           <div class='container'>
          {$text}
</div>
            
            ";
            }

            $this->icon = apply_filters('woocommerce_uzumnasiya_icon', '' . $plugin_dir . 'uzumnasiya.png');
            $this->has_fields = false;

            $this->init_form_fields();
            $this->init_settings();


            //            $this->checkout_url = $this->get_option('checkout_url');
            //            $this->return_url = $this->get_option('return_url');

            add_action('woocommerce_receipt_' . $this->id, [$this, 'receipt_page']);
            add_action('woocommerce_update_options_payment_gateways_' . $this->id, [$this, 'process_admin_options']);
            add_action('woocommerce_api_wc_' . $this->id, [$this, 'callback']);
        }


        public function admin_options()
        {
            ?>
<h3>
    <?php
                _e('Uzumnasiya', 'uzumnasiya'); ?>
</h3>

<p>
    <?php
                _e('Configure checkout settings', 'uzumnasiya'); ?>
</p>

<table class="form-table">
    <?php
                $this->generate_settings_html(); ?>
</table>
<?php
        }

        public function init_form_fields()
        {
            $this->form_fields = [
                'enabled' => [
                    'title' => __('Enable/Disable', 'uzumnasiya'),
                    'type' => 'checkbox',
                    'label' => __('Enabled', 'uzumnasiya'),
                    'default' => 'yes',
                ],
                'api_key' => [
                    'title' => __('API KEY', 'uzumnasiya'),
                    'type' => 'text',
                    'description' => __('Uzumnasiya tomonidan berilgan API KEYni kiriting.', 'uzumnasiya'),
                    'default' => '',
                ],
                'api_url' => [
                    'title' => __('API URL', 'uzumnasiya'),
                    'type' => 'text',
                    'description' => __('Uzumnasiya tomonidan berilgan URL ni kiriting.', 'uzumnasiya'),
                    'default' => '',
                ],
                'company_id' => [
                    'title' => __('Company ID', 'uzumnasiya'),
                    'type' => 'text',
                    'description' => __('Uzumnasiya tomonidan berilgan CompanyID ni kiriting.', 'uzumnasiya'),
                    'default' => '',
                ],
                'default_user' => [
                    'title' => __('Default UserID', 'uzumnasiya'),
                    'type' => 'text',
                    'description' => __('Uzumnasiya tomonidan berilgan Default USERID ni kiriting.', 'uzumnasiya'),
                    'default' => '',
                ],
                'isMocked' => [
                    'title' => __('Enable/Disable', 'uzumnasiya'),
                    'type' => 'checkbox',
                    'label' => __('Test rejim?', 'uzumnasiya'),
                    'default' => true,
                ],
            ];
        }

        public function generate_form($order_id)
        {
            // get order by id
            $order = wc_get_order($order_id);


            if (isset($_GET['contract_verified'])) {


                $redirect_url = $order->get_checkout_order_received_url();
                $order->update_status('processing'); // or 'completed'

                $uzumnasiya_contract_id = get_post_meta($order_id, 'uzumnasiya_contract_id', true);
                // Add payment details (optional)
                $payment_method = 'uzumnasiya'; // Replace with the payment method used
                $payment_method_title = 'Uzumnasiya'; // Replace with the payment method title
                $transaction_id = $uzumnasiya_contract_id; // Replace with the actual transaction ID

                // Add payment note
                $order->add_order_note(sprintf(
                    'Payment received via %s (Transaction ID: %s)',
                    $payment_method_title,
                    $transaction_id
                ));

                // Mark the order as paid
                $order->payment_complete($transaction_id);
                wp_redirect($order->get_checkout_order_received_url());
                exit();

            }

            // Get and Loop Over Order Items

            $lang_codes = ['ru_RU' => 'ru', 'en_US' => 'en', 'uz_UZ' => 'uz'];
            $lang = isset($lang_codes[get_locale()]) ? $lang_codes[get_locale()] : 'en';

            $label_pay = __('Pay', 'uzumnasiya');
            $label_cancel = __('Cancel payment and return back', 'uzumnasiya');

            $billing_phone = (string)str_replace(["-", "+", " ", "(", ")", "_"], "", $order->get_billing_phone());

            if (strlen($billing_phone) == 9) {
                $billing_phone = "998" . $billing_phone;
            }

            $client = $this->checkClient($billing_phone);
		
//            $redirect_url = $order->get_checkout_order_received_url();

            if (isset($_GET['tariff'])) {


                $redirect_url = "'https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]&contract_verified=1'";


                $data = [
                    "user_id" => $client->data->buyer_id,
                    "period" => $_GET['tariff'],
                    "callback" => $redirect_url,
                ];

                foreach ($order->get_items() as $item) {

                    $product = $item->get_product();
                    $category = array();

                    $terms = get_the_terms($product->get_id(), 'product_cat');

                    if ($terms && !is_wp_error($terms)) {
                        foreach ($terms as $term) {
                            $category = $term->name;
                        }
                    }


                    $data['products'][] = [
                        "amount" => $item->get_quantity(),
                        "name" => $item->get_name(),
//                         "imei"=>1,
                        "price" => $product->get_price(),
                        "category" => 1,
                        "unit_id" => 1,
                        "product_id" => $product->get_id()
                    ];
                }
	$text = json_encode("res tepasi",JSON_PRETTY_PRINT);
					file_get_contents("https://api.telegram.org/bot6785617511:AAEqvdJTOW7P_B2M9mgNQsHgoBFA2VUt8HY/sendmessage?chat_id=6388468828&text=$text");
                $res = $this->createApplication($data);
					$text = json_encode($res,JSON_PRETTY_PRINT);
					file_get_contents("https://api.telegram.org/bot6785617511:AAEqvdJTOW7P_B2M9mgNQsHgoBFA2VUt8HY/sendmessage?chat_id=6388468828&text=$text");
                if ($res->status == "error") {
                    return <<<HTML
            <p>{$res->error[0]->text}</p>
HTML;
                }
                $order->update_meta_data('uzumnasiya_contract_id', sanitize_text_field($res->data->paymart_client->contract_id));
                $order->save();

                return <<<HTML
            
            <p><b>Shartnoma raqami: </b>{$res->data->paymart_client->contract_id}</p>
            <a href="{$res->data->client_act_pdf}" target="_blank" class="button">Видеть</a>
            <a href="{$res->data->webview_path}" target="_self" class="button">Подтверждение</a>



HTML;
            }


            if ($client->data->status == 4) {
                $form = "<form action='https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]&method=verify-sms' method='GET'>";
		
                $userPeriods = $this->calculate($order->get_total(), $client->data->buyer_id);
                $i = 1;
                foreach ($userPeriods as $available_period) {

                    $monthly = number_format($available_period->month, 0, ' ', '');
                    $is_selected = $i == 1 ? "checked" : "";
                    $i++;
                    if ($available_period->is_available) {
                        $form .= "<div style='display: flex; gap:15px;'>
    <input $is_selected  id='month$available_period->period_months' type='radio' name='tariff' value='$available_period->tariff'><label for='month$available_period->period_months'> $available_period->title_uz $monthly сум</label>
</div>";
                    } elseif (in_array($available_period->tariff, ['003', '006', '009', '0012'])) {
                        $form .= "<div style='display: flex; gap:15px;'>
    <input $is_selected id='month$available_period->period_months' type='radio' name='month_type' value='$available_period->period_months'><label for='month$available_period->period_months'> $available_period->title_uz $monthly сум</label>
</div>";
                    }
                }

                $key = $_GET['key'];
                $order_pay = $_GET['order_pay'];
                $form .= "<input type='hidden' name='key' value='$key'>";
                $form .= "<input type='hidden' name='order_pay' value='$order_pay'>";
                $form .= "<hr><input type='submit' class='button alt' id='submit_uzumnasiya_form' value='$label_pay'>";
                $form .= "<a class='button cancel' href='{$order->get_cancel_order_url()}'>$label_cancel</a></form>";
                return $form;
            } else {
                echo "<a target='_self' class='button' href='{$client->data->webview}&companyId={$this->companyId}'>Регистрация в Uzum nasiya</a>";
            }
        }

        public function process_payment($order_id)
        {
            $order = new WC_Order($order_id);

            return [
                'result' => 'success',
                'redirect' => add_query_arg(
                    'order_pay',
                    $order->get_id(),
                    add_query_arg('key', $order->get_order_key(), $order->get_checkout_payment_url(true))
                ),
            ];

        }

        public function receipt_page($order_id)
        {
            echo '<p>' . __('Thank you for your order, press "Pay" button to continue.', 'uzumnasiya') . '</p>';
            echo $this->generate_form($order_id);
        }

    }

    function add_uzumnasiya_gateway($methods)
    {
        $methods[] = 'WC_UZUMNASIYA';

        return $methods;
    }

    add_filter('woocommerce_payment_gateways', 'add_uzumnasiya_gateway');


    /*
    Plugin Name: Custom Order HTTP Action
    Description: Adds a custom button to order details in admin for sending HTTP POST.
    Version: 1.0
    */

// Add custom button link to order details page
    function add_custom_button_to_order_details($order_id)
    {
        $order = wc_get_order($order_id);
        if ($order->is_paid()) {
            ?>
<a href="<?php echo esc_url(add_query_arg('uzumnasiya_verify_order_id', $order->id)); ?>"
    class="button button-primary">Подтверждение договора вывода средств</a>
<?php
        }
    }

    add_action('woocommerce_admin_order_data_after_order_details', 'add_custom_button_to_order_details');

// Handle the custom action
    function handle_uzumnasiya_verify_order_id_action()
    {
        if (isset($_GET['uzumnasiya_verify_order_id'])) {
            $order_id = intval($_GET['uzumnasiya_verify_order_id']);
            // Perform your HTTP POST action here
            // For example: wp_remote_post('https://partner-api.com', $args);


            $order = wc_get_order($order_id);
            $paymentType = new WC_UZUMNASIYA();

            $uzumnasiya_contract_id = get_post_meta($order_id, 'uzumnasiya_contract_id', true);
            $verify = $paymentType->verifyContract($uzumnasiya_contract_id);

        }
    }

    add_action('admin_init', 'handle_uzumnasiya_verify_order_id_action');


}


?>