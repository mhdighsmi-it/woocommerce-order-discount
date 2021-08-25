<?php


namespace DWP;


class Cart
{
    
    function __construct(){
        add_action( 'woocommerce_checkout_order_processed', array($this,'add_custom_price'), 1000, 1);
    }
    function add_custom_price( $order_id ) {
        $order=wc_get_order($order_id);
        $billing_phone = $order->billing_phone;
        $user=get_user_by('login',$billing_phone);
        if($user){
            foreach( $order->get_items() as $item_id => $item ){
                $product_id =  $item->get_product_id(); // product Quantity
                $discount_product_ids= get_post_meta($product_id,'_discount_product_id',true);
                $discount_product_type= get_post_meta($product_id,'_discount_product_type',true);
                $discount_product_value= get_post_meta($product_id,'_discount_product_value',true);
                if(!empty($discount_product_ids)&&$discount_product_type!=''&&$discount_product_value!=''){
                    $new_price='';
                    $product=wc_get_product($product_id);
                    $product_price=$product->get_price();
                    foreach($discount_product_ids as $discount_product_id) {
                        if ($this->get_orders_ids_by_product_id($discount_product_id, $user->ID)
                        ) {
                            if ($discount_product_type == 'fixed') {
                                $new_price = $product_price - $discount_product_value;
                            }
                            if ($discount_product_type == 'percent') {
                                $new_price = $product_price - ($discount_product_value * $product_price / 100);
                            }
                            // Set the new price
                            $item->set_subtotal($new_price);
                            $item->set_total($new_price);
                            $item->save(); // Save line item data
                            break;
                        }
                    }
                }
            }
            $order->calculate_totals();
        }


    }
    function get_orders_ids_by_product_id( $product_id,$user_id ){
        global $wpdb;
        $customer_id = $user_id == 0 || $user_id == '' ? get_current_user_id() : $user_id;
        $status      = 'wc-completed';

        if( ! $customer_id )
            return false;

        // Count the number of products
        $count = $wpdb->get_var( "
        SELECT woi.order_id FROM {$wpdb->prefix}posts AS p
        INNER JOIN {$wpdb->prefix}postmeta AS pm ON p.ID = pm.post_id
        INNER JOIN {$wpdb->prefix}woocommerce_order_items AS woi ON p.ID = woi.order_id
        INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS woim ON woi.order_item_id = woim.order_item_id
        WHERE p.post_status = '$status'
        AND pm.meta_key = '_customer_user'
        AND pm.meta_value = '$customer_id'
        AND woim.meta_key IN ('_product_id','_variation_id')
        AND woim.meta_value = '$product_id'
    " );

        // Return a boolean value if count is higher than 0
        return $count ;
    }

}