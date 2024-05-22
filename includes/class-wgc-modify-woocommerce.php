<?php

class WGC_Modify_WooCommerce {

    protected $processed_products = [];

    public function __construct() {
        add_action('woocommerce_before_calculate_totals', array($this, 'adjust_price_for_cart_items'), 10);
        add_filter('woocommerce_add_cart_item_data', array($this, 'add_custom_cart_item_data'), 10, 4);
        add_filter('woocommerce_get_cart_item_from_session', array($this, 'set_price_from_session_data'), 20, 3);
        add_filter('woocommerce_cart_item_price', array($this, 'modify_cart_product_price'), 10, 3);
    }

    /**
     * Checks if the product being added has associated addon data.
     */
    public function add_custom_cart_item_data($cart_item_data, $product_id, $variation_id, $quantity) {
        // Retrieve any existing addon data from the product's meta data.
        $addons = maybe_unserialize(get_post_meta($product_id, 'product-addons', true));

       // Check if there is an addon price and if so, add it to the cart item data.
        if (!empty($addons) && isset($addons['item-0']['product-addons-price'])) {
            $cart_item_data['addon_price'] = (float) $addons['item-0']['product-addons-price'];
        }

        // Return the potentially modified cart item data.
        return $cart_item_data;
    }

    /**
     * Triggered when WooCommerce loads cart items from the session.
     */
    public function set_price_from_session_data($cart_item, $session_data) {
        // Check if addon price was stored in the session and restore it to the current cart item data
        if (!empty($session_data['addon_price'])) {
            $cart_item['addon_price'] = $session_data['addon_price'];
        }
        // Return the updated cart item data
        return $cart_item;
    }

    public function adjust_price_for_cart_items($cart) {
        if (is_admin() && !defined('DOING_AJAX')) return;

        foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
            $product_id = $cart_item['product_id'];

            if (!in_array($product_id, $this->processed_products)) {
                if (isset($cart_item['include_addon']) && $cart_item['include_addon'] === 'yes')  {
                    $product = $cart_item['data'];
                    $original_price = $product->get_price();
                    $addon_price = $cart_item['addon_price'];

                    if (class_exists('WC_Subscriptions_Product') && WC_Subscriptions_Product::is_subscription($product)) {
                        if (WC_Subscriptions_Product::get_length($product) > 0) {
                            $addon_price /= 4;
                        }
                    }

                    $new_price = $original_price + $addon_price;
                    $product->set_price($new_price);

                    // Add product ID to processed list
                    $this->processed_products[] = $product_id;
                }
            }
        }
    }
    
    /**
     * Modify the display of each product prices in the cart.
     */
    public function modify_cart_product_price($price_html, $cart_item, $cart_item_key) {
        if (isset($cart_item['include_addon']) && $cart_item['include_addon'] === 'yes') {
            return wc_price($cart_item['data']->get_price());
        }
        return $price_html;
    }

}



