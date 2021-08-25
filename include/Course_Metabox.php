<?php
/**
 * Created by PhpStorm.
 * User: m
 * Date: 4/30/2021
 * Time: 6:35 PM
 */

namespace DWP;


class Course_Metabox
{
    function __construct()
    {
        add_action('add_meta_boxes',function (){
            add_meta_box(
                '_product_discount_information',       // $id
                'تخفیف',                  // $title
                array($this,'product_discount_field_cb'),  // $callback
                'product',                 // $page
                'normal',                  // $context
                'high'                     // $priority
            );
        });
        add_action( 'save_post', array($this,'product_discount_save_postdata') );

    }
    function product_discount_field_cb($post){
        $products =  get_posts(array(
            'post_type' => 'product',
            'numberposts' => -1,
            'post_status' => 'publish'
        ));
        $discount_product_id = get_post_meta( $post->ID, '_discount_product_id', true );
        $discount_product_type = get_post_meta( $post->ID, '_discount_product_type', true );
        $discount_product_value = get_post_meta( $post->ID, '_discount_product_value', true );
        ?>
        <select class=""  id="discount-product-id" name="discount-product-id[]"   multiple="multiple" >
            <option value="">انتخاب محصول</option>
            <?php
            if($products){
                foreach($products  as $product){
                    ?>
                    <option value="<?php echo $product->ID; ?>" <?php if(in_array($product->ID,$discount_product_id)) echo 'selected="selected"'; ?>>
                        <?php
                        echo  $product->post_title;
                        ?>
                    </option>
                    <?php
                }
            }
            ?>
        </select>
        <select name="discount-product-type">
            <option value="percent"  <?php if($discount_product_type=='percent') echo 'selected="selected"'; ?>>درصدی</option>
            <option value="fixed"  <?php if($discount_product_type=='fixed') echo 'selected="selected"'; ?>>ثابت</option>
        </select>

        <input name="discount-product-value" type="text" placeholder="مقدار درصد ثابت یا درصدی را وارد کنید" value="<?php echo $discount_product_value?>"/>
        <?php
    }
    function product_discount_save_postdata( $post_id ) {

        // verify if this is an auto save routine.
        // If it is our form has not been submitted, so we dont want to do anything
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;

        // Check permissions
        if ( ( isset ( $_POST['post_type'] ) ) && ( 'page' == $_POST['post_type'] )  ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return;
            }
        }
        else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }
        }

        // OK, we're authenticated: we need to find and save the data
        if ( isset ( $_POST['discount-product-id'] ) ) {
            update_post_meta( $post_id, '_discount_product_id', $_POST['discount-product-id'] );
        }
        if ( isset ( $_POST['discount-product-type'] ) ) {
            update_post_meta( $post_id, '_discount_product_type', $_POST['discount-product-type'] );
        }
        if ( isset ( $_POST['discount-product-value'] ) ) {
            update_post_meta( $post_id, '_discount_product_value', $_POST['discount-product-value'] );
        }

    }

}