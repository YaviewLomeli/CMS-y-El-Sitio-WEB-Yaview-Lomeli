<?php

/*
 * Woo Shortcodes Kit
 * @get_cf7as_sidebar_options()
 * @get_cf7as_sidebar_content()
 * */
 if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 


/* WOO GLOBAL ORDERS/ DOWNLOADS COUNTER */
// If you want to show the global orders/downloads count on any page or post, use this Shortcode: [woo_global_sales]

function wshk_my_global_sales() {

global $wpdb;

$order_totals = apply_filters( 'woocommerce_reports_sales_overview_order_totals', $wpdb->get_row( "

SELECT SUM(meta.meta_value) AS total_sales, COUNT(posts.ID) AS total_orders FROM {$wpdb->posts} AS posts

LEFT JOIN {$wpdb->postmeta} AS meta ON posts.ID = meta.post_id

WHERE meta.meta_key = '_order_total'

AND posts.post_type = 'shop_order'

AND posts.post_status IN ( '" . implode( "','", array( 'wc-completed', 'wc-processing', 'wc-on-hold' ) ) . "' )

" ) );

return absint( $order_totals->total_orders);

}
add_shortcode('woo_global_sales', 'wshk_my_global_sales');



/* INDIVIDUAL PRODUCT SALES/DOWNLOADS COUNT FUNCTION*/ 
// If you want to show the invididual product sales/downloads with a  automatic counter just need a clic

	function get_wshk_sidebar_options() {
		global $wpdb;
		$ctOptions = $wpdb->get_results("SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE 'wshk_%'");				
		foreach ($ctOptions as $option) {
			$ctOptions[$option->option_name] =  $option->option_value;
		}
		return $ctOptions;	
	}
	// Get plugin options
    
global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();

/** Check if is active */

if(isset($pluginOptionsVal['wshk_enable']) && $pluginOptionsVal['wshk_enable']==1)
{
	/* Start Sales Count Code */

  if(!function_exists('wshk_product_sold_count')):
	add_action( 'woocommerce_single_product_summary', 'wshk_product_sold_count', 11 );
	add_action( 'woocommerce_after_shop_loop_item', 'wshk_product_sold_count', 11 );
function wshk_product_sold_count() {
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $post, $woocommerce, $product;

if ($product->is_downloadable('yes')) {
    
    // It will happen if the product is downloable.

		global $product;
		$pluginOptionsVal=get_wshk_sidebar_options();
		if(isset($pluginOptionsVal['wshk_text']) && $pluginOptionsVal['wshk_text']!='')
		{
			$salesTxt=$pluginOptionsVal['wshk_text'];
			}else {
				$salesTxt="Downloads";
				}
		$units_sold = get_post_meta( $product->id, 'total_sales', true );

    //Since v.1.4
		
		if($units_sold >= $pluginOptionsVal['wshk_min']){
		echo '<p class="wshk">' . sprintf( __( '<span class="wshk-count">%s</span> <span class="wshk-text">%s</span>', 'woocommerce' ), $units_sold,$salesTxt ) . '</p>';}
		
	} else {
	    
	    // It will happen if the product is not downloable
	    
	global $product;
		$pluginOptionsVal=get_wshk_sidebar_options();
	if(isset($pluginOptionsVal['wshk_textsales']) && $pluginOptionsVal['wshk_textsales']!='')
		{
			$saleTxt=$pluginOptionsVal['wshk_textsales'];
			}else {
				$saleTxt="Sales";
				}
				$units_sold = get_post_meta( $product->id, 'total_sales', true );

    //Since v.1.4
		
		if($units_sold >= $pluginOptionsVal['wshk_minsales']){
		echo '<p class="wshk">' . sprintf( __( '<span class="wshk-count">%s</span> <span class="wshk-text">%s</span>', 'woocommerce' ), $units_sold,$saleTxt ) . '</p>';}
	}
	} 
  endif;
  
  add_action('wp_head','add_wshk_inline_style');

	/** Default Counter CSS */
	if(!function_exists('add_wshk_inline_style')):
	function add_wshk_inline_style()
	{
		$pluginOptionsVal=get_wshk_sidebar_options();
		$wshk_style='<style>'.$pluginOptionsVal['wshk-inlinecss'].'</style>';
		print $wshk_style;
		}
	endif;
}

//Since v.1.3

/*ADD PRODUCT IMAGE IN ORDER EMAIL*/
//If you want show the product image in the Order email, just enable this function.

global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();

if(isset($pluginOptionsVal['wshk_test']) && $pluginOptionsVal['wshk_test']==2)
{
add_filter( 'woocommerce_email_order_items_args', 'wshk_woocommerce_email_order_items_args', 10, 1 );
 
function wshk_woocommerce_email_order_items_args( $args ) {
$emailordersizes = get_option('wshk_emailordersizes');
 
    $args['show_image'] = true;
    $args['image_size'] = array( $emailordersizes, $emailordersizes );
 
    return $args;
 
}
}


/* WOO TOTAL PRODUCT COUNTER */
//If you want to show total products on any page or post, use this Shortcode: [woo_total_product_count] and if you want exclude any category from the total count just add [woo_total_product_count cat_id="Here write the category ID number"]

function wshk_product_count_shortcode( $atts ) {
    ob_start();
extract( shortcode_atts( array(
        'product_count' => 0
    ), $atts ) );

    $data = shortcode_atts( array(
        'cat_id'    => '',
        'taxonomy'  => 'category'
    ), $atts );
    
    // loop through all categories to collect the count.
   foreach (get_terms('product_cat') as $term)
      $product_count += $term->count;

   //Since v.1.3

    $category = get_term( $data['cat_id'], $data['taxonomy'] );
    $count = $category->count;
    $count_posts = wp_count_posts( 'product' );
    return (int)$count_posts->publish - (int)$count;
    return ob_get_clean();
}
add_shortcode( 'woo_total_product_count', 'wshk_product_count_shortcode' );


//Since v.1.4

/*PRODUCT PER PAGE*/
//if you want manage the product per page to display in shop page, just enable the function and write the number of products to display (Write -1 to show all product in the same page)

global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();


if(isset($pluginOptionsVal['wshk_perpage']) && $pluginOptionsVal['wshk_perpage']==3)
{

add_filter( 'loop_shop_per_page', create_function( '$cols', 'return get_option("wshk_nperpage");' ), 20 );
}


//Since v.1.5

/*SHOW SPECIFIC CATEGORIES IN SHOP PAGE*/
//if you want display only specifics categories in the shop page, just write the slug of each category
global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();


if(isset($pluginOptionsVal['wshk_enablecat']) && $pluginOptionsVal['wshk_enablecat']==4)
{


function wshk_specifics_categories( $q ) {

//Since 1.6.2 - To fix the problem was hide the products in categories pages.

 if ( ! is_admin() && is_shop() ){

$cat1 = get_option('wshk_firstcat');
$cat2 = get_option('wshk_secondcat');
$cat3 = get_option('wshk_thirdcat');
    $tax_query = (array) $q->get( 'tax_query' );

    $tax_query[] = array(
           'taxonomy' => 'product_cat',
           'field' => 'slug',
           'terms' => array( $cat1, $cat2, $cat3 ), // Display only products of these categories on the shop page.
           'operator' => 'IN'
    );


    $q->set( 'tax_query', $tax_query );
}
}
add_action( 'woocommerce_product_query', 'wshk_specifics_categories' );
}



//Since v.1.6.4

/*EXCLUDE PRODUCTS OF SPECIFIS CATEGORIES IN THE SHOP PAGE*/
//If you want exclude products of some categories, just need enable this function and write the category slug to exlude in each field. You can exclude 3 categories how much by now.

global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();


if(isset($pluginOptionsVal['wshk_excludecat']) && $pluginOptionsVal['wshk_excludecat']==16)
{
    
function wshk_exclude_categories( $q ) {
    if ( ! is_admin() && is_shop() ){ 
$excat1 = get_option('wshk_exfirstcat');
$excat2 = get_option('wshk_exsecondcat');
$excat3 = get_option('wshk_exthirdcat');

    $tax_query = (array) $q->get( 'tax_query' );

    $tax_query[] = array(
           'taxonomy' => 'product_cat',
           'field' => 'slug',
           'terms' => array( $excat1, $excat2, $excat3 ),
           'operator' => 'NOT IN'
    );


    $q->set( 'tax_query', $tax_query );

}
}
add_action( 'woocommerce_product_query', 'wshk_exclude_categories' );
}



//Since v.1.5

/*PRODUCTS BOUGHT BY A USER*/
//if you want display which products has bought a user, use this Shortcode: [woo_bought_products]

add_shortcode( 'woo_bought_products', 'wshk_user_products_bought' );
 
function wshk_user_products_bought() {
global $product, $woocommerce, $woocommerce_loop;

$columns = 3;
$current_user = wp_get_current_user();
$args = array(
    'post_type'             => 'product',
    'posts_per_page'        => '-1',
    'post_status'           => 'publish',
    'meta_query'            => array(
        array(
            'key'           => '_visibility',
            'value'         => array('catalog', 'visible'),
            'compare'       => 'IN'
        )
    )
);

$loop = new WP_Query($args);


ob_start(); 
woocommerce_product_loop_start();
 
while ( $loop->have_posts() ) : $loop->the_post();
$theid = get_the_ID();
if (wc_customer_bought_product( $current_user->user_email, $current_user->ID, $theid)){ 
wc_get_template_part( 'content', 'product' );
} 

endwhile; 
woocommerce_product_loop_end(); 
woocommerce_reset_loop();
wp_reset_postdata();

//return ob_get_clean(); 
/*return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';*/
if ($product >=1){

//return ob_get_clean(); 
return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
}else {
    $mbaselink = wc_get_page_permalink( 'shop' );
    //$linksh = wc_get_page_permalink( 'shop' );
    $tesprue = sprintf( __( 'No products has been bought yet.', 'woo-shortcodes-kit' ) );
    
    $tesbuton = sprintf( __( 'Go shop', 'woocommerce' ) );
    echo '
    <div class="woocommerce-Message woocommerce-Message--info woocommerce-info">
    '. $tesprue . '
		<a class="woocommerce-Button button" href="' . $mbaselink . '">' . $tesbuton . '</a><br />
		
	</div>
    
    ';
}
} 




//Since v.1.5

/*SHOW GRAVATAR USER IMAGE*/
//Display the user's Gravatar image, if you want show the Gravata'r image in any page or post, use this shortcode [woo_gravatar_image]

global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();


if(isset($pluginOptionsVal['wshk_enablegravatar']) && $pluginOptionsVal['wshk_enablegravatar']==15)
{

function wshk_gravatar_image(){
$textgravasize = get_option('wshk_textgravasize');
$textgravashd = get_option('wshk_textgravashd');
$textgravabdsz = get_option('wshk_textgravabdsz');
$textgravabdtp = get_option('wshk_textgravabdtp');
$textgravabdcl = get_option('wshk_textgravabdcl');
$textgravabdrd = get_option('wshk_textgravabdrd');

$user_id = get_current_user_id();
?>
<style>
.icon-image-container {
  height: <?php echo $textgravasize ?>px;
  width: <?php echo $textgravasize ?>px;
  border: <?php echo $textgravabdsz ?>px <?php echo $textgravabdtp ?> <?php echo $textgravabdcl ?>;  
  border-radius: <?php echo $textgravabdrd ?>%;
  box-shadow: <?php echo $textgravashd ?>;
  overflow: hidden;
  margin: 0 auto;
  
}
</style>
<?php
ob_start();
echo '<p class="icon-image-container">' . get_avatar( get_the_author_meta( 'ID' ), $textgravasize . '</p>' );
return ob_get_clean();
}
}
add_shortcode( 'woo_gravatar_image', 'wshk_gravatar_image' );





//Since v.1.5

/* CHANGE ADD TO CART TEXT BUTTON*/
// The button's text will change in the single product shop page loop & single product summary, when the user have purchase the product. Just need Enable the function and write the text to show.

global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();


if(isset($pluginOptionsVal['wshk_enablebought']) && $pluginOptionsVal['wshk_enablebought']==5)
{


add_filter('woocommerce_loop_add_to_cart_link','wshk_add_to_cart_link_customer_has_bought');
add_filter( 'woocommerce_product_single_add_to_cart_text', 'wshk_add_to_cart_link_customer_has_bought' );

    function wshk_add_to_cart_link_customer_has_bought() {

        global $product;

        if( empty( $product->id ) ){

            $wc_pf = new WC_Product_Factory();
            $product = $wc_pf->get_product( $id );

        }

        $current_user = wp_get_current_user();

        if( wc_customer_bought_product( $current_user->user_email, $current_user->ID, $product->id ) ){

            $product_url = get_permalink();
            $textbutton = get_option('wshk_buttontext');
            $button_label =  $textbutton;  

        } else {

            $product_url =  $product->add_to_cart_url();  
            $button_label = $product->add_to_cart_text();

        };

        echo sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="single_%s button product_type_simple add_to_cart_button ajax_add_to_cart single_add_to_cart_button button alt" style="text-decoration:none;">%s</a>',       
            esc_url( $product_url ),
            esc_attr( $product->id ),
            esc_attr( $product->get_sku() ),
            esc_attr( isset( $quantity ) ? $quantity : 1 ),
            $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
            //esc_attr( $product->product_type ),
            esc_html( $button_label )
        );

    }
    }
    

//Since v.1.5    

/*HOW MUCH PRODUCTS BOUGHT A USER (NUMBER ONLY)*/
//With a shortcode you can show the number of products that a user bought. If you want show in any page or post, use this shortcode : [woo_total_bought_products]



global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();


if(isset($pluginOptionsVal['wshk_enablectbp']) && $pluginOptionsVal['wshk_enablectbp']==6)
{

   add_shortcode( 'woo_total_bought_products', 'wshk_current_customer_month_count' );
function wshk_current_customer_month_count( $user_id=null ) {
    if ( empty($user_id) ){
        $user_id = get_current_user_id();
    }
    // Date calculations to limit the query
    $today_year = date( 'Y' );
    $today_month = date( 'm' );
    $day = date( 'd' );
    if ($today_month == '01') {
        $month = '12';
        $year = $today_year - 1;
    } else{
        $month = $today_month - 1;
        $month = sprintf("%02d", $month);
        $year = $today_year - 1;
    }

    // ORDERS FOR LAST 30 DAYS (Time calculations)
    $now = strtotime('now');
    // Set the gap time (here 30 days)
    $gap_days = 30;
    $gap_days_in_seconds = 60*60*24*$gap_days;
    $gap_time = $now - $gap_days_in_seconds;

    // The query arguments
    $args = array(
        // WC orders post type
        'post_type'   => 'shop_order',        
        // Only orders with status "completed" (others common status: 'wc-on-hold' or 'wc-processing')
        'post_status' => 'wc-completed', 
        // all posts
        'numberposts' => -1,
        // for current user id
        'meta_key'    => '_customer_user',
        'meta_value'  => $user_id,
        'date_query' => array(
            //orders published on last 30 days
            'relation' => 'OR',
            array(
                'year' => $today_year,
                'month' => $today_month,
            ),
            array(
                'year' => $year,
                'month' => $month,
            ),
        ),
    );

    // Get all customer products
    $customer_orders = get_posts( $args );
    $textprefix = get_option('wshk_textprefix');
    $textsuffix = get_option('wshk_textsuffix');
    $textpsuffix = get_option('wshk_textpsuffix');
    $textnobp = get_option('wshk_textnobp');
    $aligntheproducts = get_option('wshk_aligntheproducts');
    $caunt = 1;
    $count = 0;
    ob_start();
    if (!empty($customer_orders)) {
        $customer_orders_date = array();
        // Going through each current customer orders
        foreach ( $customer_orders as $customer_order ){
            // Conveting order dates in seconds
            $customer_order_date = strtotime($customer_order->post_date);
            // Only past 30 days orders
            if ( $customer_order_date > $gap_time ) {
                $customer_order_date;
                $order = new WC_Order( $customer_order->ID );
                $order_items = $order->get_items();
                // Going through each current customer items in the order
                foreach ( $order_items as $order_item ){
                    $count++;
                }                
            } 
        }
        if ($count > $caunt){
        return '<p style="text-align:' . $aligntheproducts .';">' . $textprefix . ' ' . $count . ' ' . $textpsuffix . '</p>';
        }
    }
    if ($count == $caunt){
        echo '<p style="text-align:' . $aligntheproducts .';">' . $textprefix . ' ' . $count . ' ' . $textsuffix . '</p>';
        
        } else{
            echo '<p style="text-align:' . $aligntheproducts .';">' . $textnobp . '</p>' ;
            }
            
           return ob_get_clean(); 
}
}





//Since v.1.5

/*GET ALL ORDERS FOR A USER*/
//Show the total orders that a user have made, if you want display in any page or post, use this shortcode: [woo_customer_total_orders]


global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();

if(isset($pluginOptionsVal['wshk_enablectbo']) && $pluginOptionsVal['wshk_enablectbo']==7)
{

add_shortcode( 'woo_customer_total_orders', 'wshk_get_customer_total_orders' );
function wshk_get_customer_total_orders( $user_id=null ) {
        

    if ( empty($user_id) ){
        $user_id = get_current_user_id();
    }
    // Date calculations to limit the query
    $today_year = date( 'Y' );
    $today_month = date( 'm' );
    $day = date( 'd' );
    if ($today_month == '01') {
        $month = '12';
        $year = $today_year - 1;
    } else{
        $month = $today_month - 1;
        $month = sprintf("%02d", $month);
        $year = $today_year - 1;
    }

    // ORDERS FOR LAST 30 DAYS (Time calculations)
    $now = strtotime('now');
    // Set the gap time (here 30 days)
    $gap_days = 30;
    $gap_days_in_seconds = 60*60*24*$gap_days;
    $gap_time = $now - $gap_days_in_seconds;

    // The query arguments
    $args = array(
        // WC orders post type
        'post_type'   => 'shop_order',        
        // Only orders with status "completed" (others common status: 'wc-on-hold' or 'wc-processing')
        'post_status' => 'wc-completed', 
        // all posts
        'numberposts' => -1,
        // for current user id
        'meta_key'    => '_customer_user',
        'meta_value'  => $user_id,
        'date_query' => array(
            //orders published on last 30 days
            'relation' => 'OR',
            array(
                'year' => $today_year,
                'month' => $today_month,
            ),
            array(
                'year' => $year,
                'month' => $month,
            ),
        ),
    );

    // Get all customer orders
    $customer_orders = get_posts( $args );
    $tordersprefix = get_option('wshk_tordersprefix');
    $torderssuffix = get_option('wshk_torderssuffix');
    $torderspsuffix = get_option('wshk_torderspsuffix');
    $textnobo = get_option('wshk_textnobo');
    $aligntheorders = get_option('wshk_aligntheorders');
    $caunt = 1;
    $count = 0;
    
    ob_start();

    if (!empty($customer_orders)) {
        $customer_orders_date = array();
        // Going through each current customer orders
        foreach ( $customer_orders as $customer_order ){
            // Conveting order dates in seconds
            $customer_order_date = strtotime($customer_order->post_date);
            // Only past 30 days orders
            if ( $customer_order_date > $gap_time ) {
                $customer_order_date;
                $order = new WC_Order( $customer_order->ID );
                
                    $count++;
                                
            } 
        }
        if ($count > $caunt){
        return '<p style="text-align:' . $aligntheorders .';">' .$tordersprefix . ' ' . $count . ' ' . $torderspsuffix . '</p>' ;
        }
    }
    if ($count == $caunt){
        echo '<p style="text-align:' . $aligntheorders .';">' . $tordersprefix . ' ' . $count . ' ' . $torderssuffix . '</p>' ;
        
        } else{
            echo '<p style="text-align:' . $aligntheorders .';">' . $textnobo . '</p>';
            }
            
          return ob_get_clean();  

    

}
}



//Since v.1.5

/*DISPLAY A MESSAGE IF HAVE MADE A NUMBER OF ORDERS*/
//Show a custom message if the customer has a number of orders made, if you want display in any page or post, use this shortcode: [woo_message]



function wshk_detect_customer_total_orders() {
    
    // Get all customer orders
    $customer_orders = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => get_current_user_id(),
        'post_type'   => wc_get_order_types(),
        'post_status' => array_keys( wc_get_order_statuses() ),
    ) );
    
    $customer = wp_get_current_user();
  
    // Order count for a "loyal" customer
    $setnumber =  get_option('wshk_wmorders');
    $textwmssg =  get_option('wshk_textwmssg');
    $textnonotice = get_option('wshk_nonotice');
    $textmorenotice = get_option('wshk_morenotice');
    $orders_count =  $setnumber;
    $descuento = 20;
    
    global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enablewmessage']) && $pluginOptionsVal['wshk_enablewmessage']==8)
{
    ob_start();
    // Check if the message is empty for don't display nothing
    $notice_text = sprintf( $textwmssg, $customer->display_name, $orders_count );
    if (empty($textwmssg)) {
    return false;
    }
     // Display this notice if the customer has less orders than the orders number selected in the plugin settings.
    if ( count( $customer_orders ) < $orders_count ) {
        echo $textnonotice;
    }
     // Display this notice if the customer has more orders than the orders number selected in the plugin settings.
    if ( count( $customer_orders ) > $orders_count ) {
        echo $textmorenotice;
    }
    // Display the message if the customer has the same number of orders than the orders number selected in the plugin settings.
    if ( count( $customer_orders ) == $orders_count ) {
        wc_print_notice( $notice_text, 'notice' );
        //echo $notice_text;
    }
    return ob_get_clean();
}
}
add_shortcode( 'woo_message', 'wshk_detect_customer_total_orders' );


//Since v.1.5

/*SHOW COMMENTS BY A USER (Only products)*/
//Display all the products reviews made by a user with just a shortcode, If you want display in any page or post, use this shortcode [woo_review_products]



function wshk_show_reviews_by_user(){
    ob_start();
$user_id = get_current_user_id();
$args = array(
	'user_id' => $user_id, // get the user by ID
	'post_type' => 'product',	
	'post_ID' =>$product->id,  // Product Id  
	'meta_key' => '',
	'meta_value' => '',
	'status' => "approve", // Status you can also use 'hold', 'spam', 'trash'
);

$acreviews =  get_option('wshk_enablereviews');
$textavsize =  get_option('wshk_textavsize');
$textavbdsize = get_option('wshk_textavbdsize');
$textavbdradius = get_option('wshk_textavbdradius');
$textavbdtype = get_option('wshk_textavbdtype');
$textavbdcolor = get_option('wshk_textavbdcolor');
$texttbwsize = get_option('wshk_texttbwsize');
$textbxfsize =  get_option('wshk_textbxfsize');
$textbxbdsize = get_option('wshk_textbxbdsize');
$textbxbdradius = get_option('wshk_textbxbdradius');
$textbxbdtype = get_option('wshk_textbxbdtype');
$textbxbdcolor = get_option('wshk_textbxbdcolor');
$textbxbgcolor = get_option('wshk_textbxbgcolor');
$textbtnbdsize = get_option('wshk_textbtnbdsize');
$textbtnbdradius = get_option('wshk_textbtnbdradius');
$textbtnbdtype = get_option('wshk_textbtnbdtype');
$textbtnbdcolor = get_option('wshk_textbtnbdcolor');
$textbtntarget = get_option('wshk_textbtntarget');
$textbtntxd = get_option('wshk_textbtntxd');
$textbxpadding = get_option('wshk_textbxpadding');
$textbtntxt = get_option('wshk_textbtntxt');
$avshadow = get_option('wshk_avshadow');
    global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enablereviews']) && $pluginOptionsVal['wshk_enablereviews']==9)
{
$gravatar = get_avatar( get_the_author_meta( 'ID' ), $textavsize ) . ' ';
$url = home_url();
$comments = get_comments($args);
if (!empty ($comments)){
foreach($comments as $comment) :
?>
<style>
.mcon-image-container {
  height: <?php echo $textavsize ?>px;
  width: <?php echo $textavsize ?>px;
  border: <?php echo $textavbdsize ?>px <?php echo $textavbdtype ?> <?php echo $textavbdcolor ?>;  
  border-radius: <?php echo $textavbdradius ?>%;
  box-shadow: <?php echo $avshadow ?>;
    overflow: hidden;  
}
</style>
<?php
$product = wc_get_product( $comment->comment_post_ID );
$teprodu = $product->get_name();

echo('<div style="background:' .$textbxbgcolor . '; font-size:' . $textbxfsize . 'px; border:' . $textbxbdsize . 'px' . ' ' . $textbxbdtype . ' ' . $textbxbdcolor . '; border-radius:' . $textbxbdradius . 'px; padding:' . $textbxpadding . 'px;">' . '<ul><table><tr><th style="width:' . $texttbwsize . 'px;"><p class="mcon-image-container">' . $gravatar . '</p></th><th>' . '<div class="star-rating" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating"><span style="width:' . ( get_comment_meta( $comment->comment_ID, 'rating', true ) / 5 ) * 100 . '%"><strong itemprop="ratingValue">' . get_comment_meta( $comment->comment_ID, 'rating', true ) . '</strong></span></div><a href="' . $url . '/?p=' . $comment->comment_post_ID . '/#comments' . '">' . $teprodu . '</a><br /><strong>' . $comment->comment_author . '</strong><br /><small>' . get_comment_date( '', $comment) . '</small></th></tr></table>' . $comment->comment_content . '<br /><br />' . '<a class="woocommerce-Button button" target="' .$textbtntarget . '" style="border:' . $textbtnbdsize . 'px' . ' ' . $textbtnbdtype . ' ' . $textbtnbdcolor . '; border-radius:' . $textbtnbdradius . 'px; text-decoration:' . $textbtntxd . ';" href="' . $url . '/?p=' . $comment->comment_post_ID . '/#comments' . '">' . $textbtntxt . '</a>' . '</ul>' . '</div>' . '<br />');


endforeach;
} else {
    $mrbaselink = wc_get_page_permalink( 'shop' );
    //$linksh = wc_get_page_permalink( 'shop' );
    $tesprue = sprintf( __( 'No reviews has been made yet.', 'woo-shortcodes-kit' ) );
    
    $tesbuton = sprintf( __( 'Make your first review', 'woo-shortcodes-kit' ) );
    echo '
    <div class="woocommerce-Message woocommerce-Message--info woocommerce-info">
    '. $tesprue . '
		<a class="woocommerce-Button button" href="' . $mrbaselink . '">' . $tesbuton . '</a><br />
		
	</div>
    
    ';
}
return ob_get_clean();
}
}
add_shortcode( 'woo_review_products', 'wshk_show_reviews_by_user' );





//Since v.1.6.6
/*SHOW THE WOOCOMMERCE REVIEWS EVERYWHERE YOU WANT*/
//Display the product valorations made by all the users, If you want display in any page or post, use this shortcode [woo_display_reviews]




global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enabledisplayreviews']) && $pluginOptionsVal['wshk_enabledisplayreviews']==40)
{




function wshk_get_woo_reviews()
{
    ob_start();
$disreacreviews =  get_option('wshk_enabledisplayreviews');
$disretextavsize =  get_option('wshk_disretextavsize');
$disretextavbdsize = get_option('wshk_disretextavbdsize');
$disretextavbdradius = get_option('wshk_disretextavbdradius');
$disretextavbdtype = get_option('wshk_disretextavbdtype');
$disretextavbdcolor = get_option('wshk_disretextavbdcolor');
$disretexttbwsize = get_option('wshk_disretexttbwsize');

$disretextbxfsize =  get_option('wshk_disretextbxfsize');

$disretextbxbdsize = get_option('wshk_disretextbxbdsize');
$disretextbxbdradius = get_option('wshk_disretextbxbdradius');
$disretextbxbdtype = get_option('wshk_disretextbxbdtype');
$disretextbxbdcolor = get_option('wshk_disretextbxbdcolor');
$disretextbxbgcolor = get_option('wshk_disretextbxbgcolor');
$disretextbxpadding = get_option('wshk_disretextbxpadding');
$disretextbxminheight = get_option('wshk_disretextbxminheight');

$disretextlinktarget = get_option('wshk_disretextlinktarget');
$disretextlinktxd = get_option('wshk_disretextlinktxd');
$disretextlinktxtsize = get_option('wshk_disretextlinktxtsize');
$disretextlinktxtcolor = get_option('wshk_disretextlinktxtcolor');

$disredisplaynumber = get_option('wshk_disredisplaynumber');
$disrecolumnsnumber = get_option('wshk_disrecolumnsnumber');
$disretextmargintop = get_option('wshk_disretextmargintop');
    
    
$count = 0;
$html_r = "";
$title="";
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$number = $disredisplaynumber; // all for show all the comments, for other quantity just write the number 1,2,3,4...
$offset = ( $paged - 1 ) * $number;
$args = array(
  'number' => $number,
    'offset' => $offset,
    'paged' => $paged,
'post_type' => 'product',

);
?> 
  <style>
  .wshk-grava {
border: <?php echo $disretextavbdsize ?>px <?php echo $disretextavbdtype ?> <?php echo $disretextavbdcolor ?>;
border-radius: <?php echo $disretextavbdradius ?>%;
margin-top: <?php echo $disretextmargintop ?>px;

}


@media screen and (max-width: 659px) and (min-width: 320px) { 
   .wshk-reviews{ 
    display: initial;
   }
}
  </style>
  
  <?php
$comments_query = new WP_Comment_Query;
$comments = $comments_query->query( $args );


$ggravatar = get_avatar( get_the_author_meta( 'ID' ), $disretextavsize, null, null, array('class' => array('wshk-grava') ) ) . ' ';
$ccomments = get_comments($args);
  

foreach($comments as $comment) :
  
$title = '<div style="border:'. $disretextbxbdsize. 'px ' . $disretextbxbdtype . ' ' .  $disretextbxbdcolor .'; border-radius:' . $disretextbxbdradius .'px;background-color:' .$disretextbxbgcolor .';color: white;padding:' . $disretextbxpadding . 'px;max-width:100%;min-height:' . $disretextbxminheight .'px;height:100%;margin-bottom: 20px;font-size:' .$disretextbxfsize . 'px;">'.get_the_title( $comment->comment_post_ID ).'';
  
$html_r = $html_r. '<a style="font-size:' . $disretextlinktxtsize . 'px; color:' . $disretextlinktxtcolor . ';text-decoration:' . $disretextlinktxd . ';" href="' . $url . '/?p=' . $comment->comment_post_ID . '/#comments" target="' .$disretextlinktarget . '">' . $title . '</a><span class="star-rating" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating"><span style="width:' . ( get_comment_meta( $ccomment->comment_ID, 'rating', true ) / 5 ) * 100 . '%"><strong itemprop="ratingValue">' . get_comment_meta( $ccomment->comment_ID, 'rating', true ) . '</strong></span></span><br />';
  
$html_r = $html_r. '<table style="border: 1px solid transparent;"><tr><td width="' .$disretexttbwsize . 'px"><span>' .$ggravatar.'</span></td>';
$html_r = $html_r.'<td><span><small>Publicado por <strong>'.$comment->comment_author. '</strong> el ' . get_comment_date( "", $comment) . '</small></span></td></tr></table>';
$html_r = $html_r. '<span style="padding-left: 20px;">' .$comment->comment_content.'<br /></span></div>';
/*$html_r = $html_r."<small>Publicado por ".$comment->comment_author." el ".$comment->comment_date. "</small></div>";*/
  
  
endforeach;
  
return '<div class="wshk-reviews" style="column-count:' .$disrecolumnsnumber . '; width: 100%;">'.$html_r.'</div>';
  

ob_get_clean();
}

add_shortcode('woo_display_reviews', 'wshk_get_woo_reviews');

}







//Since v.1.5

/*SHOW TOTAL OF COMMENTS BY USER (Only products)*/
//Display a product reviews counter made by a user, If you want display in any page or post, use this shortcode [woo_total_count_reviews] 

function wshk_count_reviews_by_user(){
$user_id = get_current_user_id();
$args = array(
	'user_id' => $user_id, // get the user by ID
	'post_type' => 'product',	
        'count' => true //return only the count
);
  global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enablerwcounter']) && $pluginOptionsVal['wshk_enablerwcounter']==10)
{
ob_start();
$treviewprefix = get_option('wshk_treviewprefix');
$treviewsuffix = get_option('wshk_treviewsuffix');
$treviewpsuffix = get_option('wshk_treviewpsuffix');
$textnoreview = get_option('wshk_textnoreview');
$alignthereviews = get_option('wshk_alignthereviews');

$comments = get_comments($args);


 // Display the message if the customer has 1 review.
    if ( $comments == 1 ) {
        echo '<p style="text-align:' . $alignthereviews .';">' . $treviewprefix . ' '  . $comments . ' ' . $treviewsuffix. '</p>';
 // Display this notice if the customer hasn't reviews yet.       
    } elseif( $comments == 0 ) {
        echo '<p style="text-align:' . $alignthereviews .';">' . $textnoreview. '</p>';
    }
     // Display this notice if the customer has more than 1 review.
    else if( $comments >= 2 ) {
        echo '<p style="text-align:' . $alignthereviews .';">' . $treviewprefix . ' ' . $comments . ' ' . $treviewpsuffix. '</p>';
    } 
    return ob_get_clean();
}
} 
add_shortcode( 'woo_total_count_reviews', 'wshk_count_reviews_by_user' );








//SINCE v.1.6.6 
//CHECK IF EASY MY ACCOUNT BUILDER IS ACTIVE

if ( in_array( 'easy-myaccount-builder/easy-myaccount-builder-for-wshk.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    
       include( ABSPATH . '/wp-content/plugins/easy-myaccount-builder/emab-functions.php' );
    

        }



  
//Since v.1.6.6

/*SHOW THE DASHBOARD*/
//Display the account edit form and let customize the data, If you want display in any page or post, use this shortcode [woo_edit_myaccount]

function wshk_newstyle_mydashboard() {
    /*wc_get_template( 'myaccount/form-edit-account.php', array( 'user' => get_user_by( 'id', get_current_user_id() ) ) ); */
    if (  is_user_logged_in() && ( is_account_page() ) ) {
        ob_start();
    require dirname( __FILE__ ) . '/mytemplates/dashboard.php';
    return ob_get_clean();
    }
}
add_shortcode ('woo_mydashboard', 'wshk_newstyle_mydashboard');


//Since v.1.6.6

/*SHOW THE ORDERS*/
//Display the account edit form and let customize the data, If you want display in any page or post, use this shortcode [woo_edit_myaccount]

function wshk_newstyle_myorders() {
    /*wc_get_template( 'myaccount/form-edit-account.php', array( 'user' => get_user_by( 'id', get_current_user_id() ) ) ); */
    
   
    if (  is_user_logged_in() && ( is_account_page() ) ) {
ob_start();
    require dirname( __FILE__ ) . '/mytemplates/my-orders.php';
    
    global $wp;

    if ( ! empty( $wp->query_vars ) ) {
      foreach ( $wp->query_vars as $key => $value ) {
        // Ignore pagename param.
        if ( 'edit-address' === $key ) {
          continue;
        }
        
        if ( 'add-payment-method' === $key ) {
          continue;
        }
        
        if ( 'payment-methods' === $key ) {
          continue;
        }


        if ( has_action( 'woocommerce_account_' . $key . '_endpoint' ) ) {
          do_action( 'woocommerce_account_' . $key . '_endpoint', $value );
          return ob_get_clean();
          
        }
      }
    }

    // No endpoint found? Default to dashboard.
    /*wc_get_template( 'myaccount/', array(
      'current_user' => get_user_by( 'id', get_current_user_id() ),
    ) );*/
    return ob_get_clean();
} 
}
add_shortcode ('woo_myorders', 'wshk_newstyle_myorders');

//Sustituir plantilla del tema por la del plugin
add_filter( 'wc_get_template', 'wshk_cma_get_templatee', 10, 5 );
function wshk_cma_get_templatee( $located, $template_name, $args, $template_path, $default_path ) {    
    if ( 'myaccount/view-order.php' == $template_name ) {
        $located = plugin_dir_path( __FILE__ ) . '/mytemplates/view-order.php';
    }
    
    return $located;
}







//Since v.1.6.6

/*SHOW THE DOWNLOADS*/
//Display the account edit form and let customize the data, If you want display in any page or post, use this shortcode [woo_edit_myaccount]

function wshk_newstyle_mydownloads() {
    /*wc_get_template( 'myaccount/form-edit-account.php', array( 'user' => get_user_by( 'id', get_current_user_id() ) ) ); */
    if (  is_user_logged_in() && ( is_account_page() ) ) {
        ob_start();

    require dirname( __FILE__ ) . '/mytemplates/downloads.php';
    return ob_get_clean();
}
}
add_shortcode ('woo_mydownloads', 'wshk_newstyle_mydownloads');


//Since v.1.6.6

/*SHOW THE ADDRESSES*/
//Display the account edit form and let customize the data, If you want display in any page or post, use this shortcode [woo_edit_myaccount]

function wshk_newstyle_myaddress() {
    /*wc_get_template( 'myaccount/form-edit-account.php', array( 'user' => get_user_by( 'id', get_current_user_id() ) ) ); */
    
    if (  is_user_logged_in() && ( is_account_page() ) ) {
    ob_start();    
        
    require dirname( __FILE__ ) . '/mytemplates/my-address.php';
    
    ?> <?php
    
    global $wp;

    if ( ! empty( $wp->query_vars ) ) {
      foreach ( $wp->query_vars as $key => $value ) {
        // Ignore pagename param.
        if ( 'view-order' === $key ) {
          continue;
        }
        
        if ( 'add-payment-method' === $key ) {
          continue;
        }
        
        if ( 'payment-methods' === $key ) {
          continue;
        }


        if ( has_action( 'woocommerce_account_' . $key . '_endpoint' ) ) {
          
          //ob_start();
          do_action( 'woocommerce_account_' . $key . '_endpoint', $value );
          return ob_get_clean();
          
        }
      }
    }

    // No endpoint found? Default to dashboard.
   /* wc_get_template( 'myaccount/', array(
      'current_user' => get_user_by( 'id', get_current_user_id() ),
    ) );*/
return ob_get_clean();    
}

}

add_shortcode ('woo_myaddress', 'wshk_newstyle_myaddress');

//Sustituir plantilla del tema por la del plugin

function wshk_cma_get_template( $located, $template_name, $args, $template_path, $default_path ) {   
        
    if ( 'myaccount/form-edit-address.php' == $template_name ) {
        $located = plugin_dir_path( __FILE__ ) . '/mytemplates/form-edit-address.php';
    }
    
    return $located;
    
}
add_filter( 'wc_get_template', 'wshk_cma_get_template', 10, 5 );

//Since v.1.6.6

/*SHOW THE PAYMENTS METHODS*/
//Display the account edit form and let customize the data, If you want display in any page or post, use this shortcode [woo_edit_myaccount]





function wshk_newstyle_mypayment() {
    //wc_get_template( 'myaccount/form-edit-account.php', array( 'user' => get_user_by( 'id', get_current_user_id() ) ) ); 
    if (  is_user_logged_in() && ( is_account_page() ) ) {
        ob_start();
    require dirname( __FILE__ ) . '/mytemplates/payment-methods.php';
    
    //require dirname( __FILE__ ) . '/mytemplates/form-add-payment-method.php';
    ?>
   <br /><br /><br /><br /><?php
    global $wp;

    if ( ! empty( $wp->query_vars ) ) {
        
      foreach ( $wp->query_vars as $key => $value ) {
        // Ignore pagename param.

        if ( 'edit-address' === $key ) {
          continue;

        }
        
        if ( 'view-order' === $key ) {
          continue;

        }
        
        if ( 'payment-methods' === $key ) {
          continue;

        }


        if ( has_action( 'woocommerce_account_' . $key . '_endpoint' ) ) {
            //ob_start();
          do_action( 'woocommerce_account_' . $key . '_endpoint', $value );
          return ob_get_clean();
          
          
        }
      }
      
    }

    // No endpoint found? Default to dashboard.
   /* wc_get_template( 'myaccount/', array(
      'current_user' => get_user_by( 'id', get_current_user_id() ),
    ) );*/
    return ob_get_clean();
    }
}
add_shortcode ('woo_mypayment', 'wshk_newstyle_mypayment');

//Sustituir plantilla del tema por la del plugin

function wshk_pcma_get_templatee( $located, $template_name, $args, $template_path, $default_path ) {    
    if ( 'myaccount/payment-methods.php' == $template_name ) {
         
        $located = plugin_dir_path( __FILE__ ) . '/mytemplates/payment-methods.php';
        
    }
    
    return $located;
    
}
add_filter( 'wc_get_template', 'wshk_pcma_get_templatee', 10, 5 );
//Since v.1.6.6

/*SHOW THE EDIT ACCOUNT*/
//Display the account edit form and let customize the data, If you want display in any page or post, use this shortcode [woo_edit_myaccount]

function wshk_newstyle_myeditaccount() {
    /*wc_get_template( 'myaccount/form-edit-account.php', array( 'user' => get_user_by( 'id', get_current_user_id() ) ) ); */
    if (  is_user_logged_in() && ( is_account_page() ) ) {
    ob_start();
    require dirname( __FILE__ ) . '/mytemplates/form-edit-account.php';
    return ob_get_clean();
}
}
add_shortcode ('woo_myedit_account', 'wshk_newstyle_myeditaccount');




//Since v.1.5

/*SHOW THE LOGIN & REGISTER FORM*/
//If you are building your own myaccount page, you need use this function to display the login/register form. Just need use this shortcode [woo_login_form]

function wshk_login_form() {

 global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enableloginform']) && $pluginOptionsVal['wshk_enableloginform']==13)
{
if ( ! is_user_logged_in() ) {
        ob_start();
         echo do_shortcode( '[woocommerce_my_account]' );
    /*wc_get_template( 'myaccount/form-edit-account.php', array( 'user' => get_user_by( 'id', get_current_user_id() ) ) ); */
   
     
        
     /*OLD method*/
//wc_get_template( 'myaccount/form-lost-password.php' ); /*OLD method*/
//wc_get_template( 'myaccount/form-reset-password.php' ); /*OLD method*/
//require dirname( __FILE__ ) . '/mytemplates/login.php';
//echo wp_login_form();


} 
}
}

//Sustituir plantilla del tema por la del plugin
add_filter( 'wc_get_template', 'wshk_logma_get_templatee', 10, 5 );
function wshk_logma_get_templatee( $located, $template_name, $args, $template_path, $default_path ) {    
    if ( 'myaccount/form-login.php' == $template_name ) {
        $located = plugin_dir_path( __FILE__ ) . '/mytemplates/form-login.php';
    }
    
    return $located;
}

//Since v.1.5

/*RESTRICT THE ACCESS TO MY ACCOUNT PAGE IF THE USER IS NOT LOGGED IN + CUSTOM REDIRECT*/
//If you are building your own myaccount page, you need use this function to protect the page to non logged in users. Just need activate and write the slug of the page that you want redirect to the user. For example "shop"

add_action( 'template_redirect', 'wc_redirect_non_logged_to_login_access');
function wc_redirect_non_logged_to_login_access() {

global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enableloginform']) && $pluginOptionsVal['wshk_enableloginform']==13)
{

    /*if ( ! is_user_logged_in() && ( is_account_page() ) ) {
        
    $blockmya = get_option('wshk_blockmya');
        wp_redirect( home_url( '/' . $blockmya ) );
        exit();
    }*/
    return ob_get_clean();
}
}


add_shortcode ('woo_login_form', 'wshk_login_form');



//Since v.1.5
/*REDIRECT USERS TO CUSTOM URL AFTER LOGIN (BASE ON THEIR ROLE)*/
//If you are building your own myaccount page, you need use it to redirect the user after the login to a page. Just need activate and write the page slug. For exmaple "myownaccount".

/**
 * Redirect users to custom URL based on their role after login
 *
 * @param string $redirect
 * @param object $user
 * @return string
 */
function wshk_custom_user_redirect( $redirect, $user ) {

global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enableloginform']) && $pluginOptionsVal['wshk_enableloginform']==13)
{
	// Get the first of all the roles assigned to the user
	$loginredi = get_option('wshk_loginredi');
	$role = $user->roles[0];
	$dashboard = admin_url();
	$myaccount = home_url( '/' . $loginredi );
	
	if( $role == 'administrator' ) {
		//Redirect administrators to the dashboard
		$redirect = $dashboard;
	} elseif ( $role == 'shop-manager' ) {
		//Redirect shop managers to the dashboard
		$redirect = $dashboard;
	} elseif ( $role == 'editor' ) {
		//Redirect editors to the dashboard
		$redirect = $dashboard;
	} elseif ( $role == 'author' ) {
		//Redirect authors to the dashboard
		$redirect = $dashboard;
	} elseif ( $role == 'customer' || $role == 'subscriber' ) {
		//Redirect customers and subscribers to the "My Account" page
		$redirect = $myaccount;
	} else {
		//Redirect any other role to the previous visited page or, if not available, to the home
		//$redirect = wp_get_referer() ? wp_get_referer() : home_url();
		$redirect = $myaccount;
	}
	return $redirect;
}
}
add_filter( 'woocommerce_login_redirect', 'wshk_custom_user_redirect', 10, 2 );

//Since v.1.5

/*SHOW LOGOUT BUTTON*/
//If you are building your own myaccount page, you will need this function to let the user make a logout. Just need activate and use this shortcode: [woo_logout_button]
add_shortcode ('woo_logout_button', 'wshk_logout_button');
function wshk_logout_button() {

 global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enablelogoutbtn']) && $pluginOptionsVal['wshk_enablelogoutbtn']==12)
{
    
    
if ( is_user_logged_in() && ( is_account_page() ) ) {
$logbtnbdsize = get_option('wshk_logbtnbdsize');
$logbtnbdradius = get_option('wshk_logbtnbdradius');
$logbtnbdtype = get_option('wshk_logbtnbdtype');
$logbtnbdcolor = get_option('wshk_logbtnbdcolor');
$logbtntext = get_option('wshk_logbtntext');
$logbtntd = get_option('wshk_logbtntd');
$logbtnta = get_option('wshk_logbtnta');
$logbtnwd = get_option('wshk_logbtnwd');



//the get page id myaccount can be changed for shop to redirect after logout to the shop page
ob_start();
print '<a class="woocommerce-Button button" style="border:' . ' ' . $logbtnbdsize . 'px' . ' ' . $logbtnbdtype . ' ' . $logbtnbdcolor . '; border-radius:' . ' ' . $logbtnbdradius . 'px; text-decoration:' . ' ' . $logbtntd . '; margin: 0 auto;  text-align:' . ' ' . $logbtnta . '; display:block; width:' . ' ' . $logbtnwd . 'px;" href="' . wp_logout_url( get_permalink( wc_get_page_id( "myaccount" ) ) ) . '">' . ' ' . $logbtntext . ' ' . '</a>';

return ob_get_clean();
}

}
}

//Since 1.6.6
/*Redirect after logout to a custom page*/

function wshk_custom_logout_redirect() {
    
    global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enablelogoutbtn']) && $pluginOptionsVal['wshk_enablelogoutbtn']==12)
{
    
    $clogpage = get_option( 'wshk_btnlogoutredi' );
    $baselink = home_url( '/' . $clogpage );
    if (!empty ($clogpage)) {
        wp_redirect($baselink);
        exit();
    }
    
}
}
add_action('wp_logout', 'wshk_custom_logout_redirect', PHP_INT_MAX);

//Since v.1.5

/*SHOW THE USERNAME*/
//If you are building your own myaccount page, maybe need this function to get the username. Just need activate and use this shortcode: [woo_user_name]
add_shortcode('woo_user_name', 'wshk_get_user');
function wshk_get_user() {

  global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enableusername']) && $pluginOptionsVal['wshk_enableusername']==11)
{
ob_start();
	if ( is_user_logged_in()) {
$usernmtc = get_option('wshk_usernmtc');
$usernmts = get_option('wshk_usernmts');
$usernmta = get_option('wshk_usernmta');
$textusernmpf = get_option('wshk_textusernmpf');
$textusernmsf = get_option('wshk_textusernmsf');
		$user = wp_get_current_user();
		echo '<p style="color:' . ' ' . $usernmtc . '; text-align:' . ' ' . $usernmta . '; font-size:' . ' ' . $usernmts . 'px;">' . $textusernmpf . ' ' . $user->first_name . ' ' . $textusernmsf . '</p>';
		
		return ob_get_clean();
	}
}
}

//Since v1.5

/*CHANGE THE ADD TO CART BUTTON TEXT*/
//If you want change the add to cart button text for: external, grouped, simple, and variable products, just activate this function and change the texts. If the function is active, you need complet all the fields.  


global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enableaddtocarttxt']) && $pluginOptionsVal['wshk_enableaddtocarttxt']==14)
{
function wshk_custom_woocommerce_product_add_to_cart_text() {


	global $product;
	$atctxtexternal = get_option('wshk_atctxtexternal');
	$atctxtgrouped = get_option('wshk_atctxtgrouped');
	$atctxtsimple = get_option('wshk_atctxtsimple');
	$atctxtvariable = get_option('wshk_atctxtvariable');
	/*$atctxtntin = get_option('wshk_atctxtntin');	*/
	
	$product_type = $product->product_type;
	
	switch ( $product_type ) {
		case 'external':
			return __( $atctxtexternal, 'woocommerce' );
		break;
		case 'grouped':
			return __( $atctxtgrouped, 'woocommerce' );
		break;
		case 'simple':
			return __( $atctxtsimple, 'woocommerce' );
		break;
		case 'variable':
			return __( $atctxtvariable, 'woocommerce' );
	/*	break;
		default:
			return __( $atctxtntin, 'woocommerce' );*/
	}
	
}
add_filter( 'woocommerce_product_add_to_cart_text' , 'wshk_custom_woocommerce_product_add_to_cart_text' ); 
}

//Since 1.6.4
/*CUSTOM MENU FOR LOGGED IN AND NON LOGGED IN USERS*/
//If you want display a different menu for logged in & non logged in users, just need activate this function and write the menu name in each field.
global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enablecustomenu']) && $pluginOptionsVal['wshk_enablecustomenu']==17)
{
    
    
function wshk_custom_menus( $args ) {
    //can be change top for primary or secondary
   $menloca = get_option('wshk_menulocation');
   
      if ( $args['theme_location'] ==  $menloca) {
         
    $loggedinmenu = get_option('wshk_logmenu');
    $nonloggedinmenu = get_option('wshk_nonlogmenu');
    
 if( is_user_logged_in() ) {
      
   


 $args['menu'] = $loggedinmenu;
 } else {
     
 $args['menu'] = $nonloggedinmenu;
 }
 }
 return $args;
    
}
 add_filter( 'wp_nav_menu_args', 'wshk_custom_menus' );
}


//Since 1.6.4
/*ENABLE ADD SHORTCODES IN MENU ITEM TITLES*/
//If you want insert shortcodes in your menu item titles, just need activate this function and nothing more!

global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enableshtmenu']) && $pluginOptionsVal['wshk_enableshtmenu']==18)
{

function wshk_shortcodes_in_menu( $menu ){ 
        return do_shortcode( $menu ); 
} 
add_filter('wp_nav_menu', 'wshk_shortcodes_in_menu'); 
}

//Since 1.6.4
/*ENABLE DISPLAY USERNAME IN MENU*/
//If you want show the username in the menu, just need activate this function.

global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enableuserinmenu'])  && $pluginOptionsVal['wshk_enableuserinmenu']==19)
{
   

function displayname_on_menu(){
    ob_start();
    $user = wp_get_current_user();
    return $user->first_name;
    return ob_get_clean();
}



add_shortcode( 'wshk_user_in_menu' , 'displayname_on_menu' );
}


//Since 1.6.6
/*ENABLE BLOCK WP-ADMIN & WP-LOGIN-PHP + REDIRECT TO SHOP PAGE*/
//If you want block the access to this urls and redirect to the custom login form, just need activate this function. Can be used with the WooCommerce's custom myaccount shortcode and with your custom myaccount page.

global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enablesloginsec'])  && $pluginOptionsVal['wshk_enablesloginsec']==20)
{
   

function wshk_redirect_custom_account_page(){

    // Get the user current page
    
    $page_viewed = basename( $_SERVER['REQUEST_URI'] );

    // Get permalink to the account page
    
    $caccount_page  = get_permalink( get_option('woocommerce_myaccount_page_id') );
      
	/* Check if a non logged in user is trying to view wp-login.php */
	
	global $pagenow;
    if ($pagenow == 'wp-login.php' && !is_user_logged_in())
        {
            // Redirect
            wp_redirect( $caccount_page );
            exit();
        }

    // Block wp-login for logged in users
    if( $page_viewed == "wp-login.php" && is_user_logged_in()) {
        wp_redirect( $caccount_page );
        exit();
    }
    
     
}

add_action( 'init','wshk_redirect_custom_account_page' );
}



//Since 1.6.6
/*ENABLE BLOCK WP-ADMIN BAR FOR NON ADMINS*/
//If you want block the access via admin top bar to the non admins users, just need activate this function.

global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enablesadminbar'])  && $pluginOptionsVal['wshk_enablesadminbar']==21)
{
   

function wshk_block_admin_bar(){

if (!current_user_can('administrator') && !is_admin()) {
  add_filter('show_admin_bar', '__return_false');
}
}
add_action('after_setup_theme', 'wshk_block_admin_bar');
}



//Since v.1.6.6

/*RESTRICT CONTENT TO NON LOGGED IN USERS*/
//Hide the content that you want for non logged in users everywhere! If you want restrict some content in any page or post, use this shortcode [wshk] my contente [/wshk]

global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enablerestrictctnt']) && $pluginOptionsVal['wshk_enablerestrictctnt']==22)
{
function wshk_hide_content_shortcode($atts = [], $content = null)
{
    // do something to $content
    
    if ( is_user_logged_in() ) {
 ob_start();
    // run shortcode parser recursively
    $content = do_shortcode($content);
 
    // always return
    return $content;
    return ob_get_clean();
}
}
add_shortcode('wshk', 'wshk_hide_content_shortcode');
}

//Since v.1.6.6

/*RESTRICT CONTENT TO LOGGED IN USERS*/
//Hide the content that you want for logged in users everywhere! If you want restrict some content in any page or post, use this shortcode [off] my contente [/off]

global $pluginOptionsVal;
$pluginOptionsVal=get_wshk_sidebar_options();
      if(isset($pluginOptionsVal['wshk_enableoffctnt']) && $pluginOptionsVal['wshk_enableoffctnt']==23)
{
function wshk_off_content_shortcode($atts = [], $content = null)
{
    // do something to $content
    
    if ( ! is_user_logged_in() ) {
 ob_start();
    // run shortcode parser recursively
    $content = do_shortcode($content);
 
    // always return
    return $content;
    return ob_get_clean();
}
}
add_shortcode('off', 'wshk_off_content_shortcode');
}