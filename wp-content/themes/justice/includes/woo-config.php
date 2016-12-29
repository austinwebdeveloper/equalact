<?php
/**
* Woocommerce Config
*
* @package TemplatePath
*/

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
    die;
}

if( ! class_exists( 'JusticeWooConfig' ) ) {
	
    class JusticeWooConfig {

    	function __construct() {

    		add_filter( 'woocommerce_show_page_title', array( $this, 'justice_woo_shop_title'), 10 );
			        
    		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
    		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
			// Add Woocommerce Shop Title with Divider
			add_action( 'woocommerce_before_main_content', array( $this, 'justice_woo_shop_page_title' ), 10 );
    		add_action( 'woocommerce_before_main_content', array( $this, 'justice_woo_before_container' ), 10 );
    		add_action( 'woocommerce_after_main_content', array( $this, 'justice_woo_after_container' ), 10 );			
						
			// Remove Woocommerce Default Sidebar
			remove_action( 'woocommerce_sidebar' , 'woocommerce_get_sidebar', 10 );

    	}
		
		function justice_woo_before_container() {
			global $tpath_options, $post;
			
			$shop_page_id = $layout = $content_class = $primary_class = '';
			
			if( is_shop() ) {
				$shop_page_id = get_option('woocommerce_shop_page_id');
				if( is_object( $post ) ) {
					$layout = get_post_meta( $shop_page_id, 'tpath_layout', true );
				}
				if( isset( $layout ) && $layout == '' ) {
					$layout = 'one-col';
				}
			} 
			
			if( is_product_category() || is_product_tag() ) {
				$layout = $tpath_options['tpath_woo_archive_layout'];
				if( isset( $layout ) && $layout == '' ) {
					$layout = 'one-col';
				}
			}
			
			if( is_product() ) {
				$layout = $tpath_options['tpath_woo_single_layout'];
				if( isset( $layout ) && $layout == '' ) {
					$layout = 'two-col-right';
				}
			}
			
			if( $layout == 'two-col-left' || $layout == 'two-col-right' ) {
				$primary_class = 'content-col-small';
			}
			elseif( $layout == 'one-col' ) {
				$primary_class = 'content-col-full';
			}

			echo '<div class="container tpath-woocommerce-wrapper">
				<div id="main-wrapper" class="tpath-row row">
					<div id="single-sidebar-container" class="single-sidebar-container main-col-full">
						<div class="tpath-row row">
							<div id="primary" class="content-area '.$primary_class.'">
								<div id="content" class="site-content">';
		}
		
		function justice_woo_after_container() {
			global $tpath_options, $post;
			
			echo '</div>
				</div>';
			
			$shop_page_id = $layout = $layouts = $pm_sidebar_widget = '';
			
			if( is_shop() ) {
				$shop_page_id = get_option('woocommerce_shop_page_id');
				if( is_object( $post ) ) {
					$layout = get_post_meta( $shop_page_id, 'tpath_layout', true );
				}
				if( isset( $layout ) && $layout == '' ) {
					$layout = 'one-col';
				}
				$pm_sidebar_widget = get_post_meta( $post->ID, 'tpath_primary_sidebar', true );
			} 
			
			if( is_product_category() || is_product_tag() ) {
				$layout = $tpath_options['tpath_woo_archive_layout'];
				if( isset( $layout ) && $layout == '' ) {
					$layout = 'one-col';
				}
			}
			
			if( is_product() ) {
				$layout = $tpath_options['tpath_woo_single_layout'];
				if( isset( $layout ) && $layout == '' ) {
					$layout = 'two-col-right';
				}
			}
			
			if( $pm_sidebar_widget == '' || $pm_sidebar_widget == '0' ) {
				$pm_sidebar_widget = 'shop-sidebar';
			}
			
			if( $layout != 'one-col' ) {
				if ( is_active_sidebar( $pm_sidebar_widget ) ) {				
					echo '<div id="sidebar" class="primary-sidebar sidebar pm-sidebar">';
						dynamic_sidebar( $pm_sidebar_widget );
					echo '</div>';
				}
			}
			
				echo '</div>
					</div>
				</div>
			</div>';
		}
				
		function justice_woo_shop_title() {
			return false;
		}		
		
		function justice_woo_shop_page_title() {
			get_template_part( 'partials/page', 'header' );
		}
		
	}
}
new JusticeWooConfig();

global $tpath_options;

// Remove Breadcrumbs
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

// Remove result count
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

// Move Rating After Price
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 10 );

// Change number of products per page
add_filter('loop_shop_per_page', 'justice_woo_loop_shop_per_page');

function justice_woo_loop_shop_per_page() {
	global $tpath_options;
	
	parse_str($_SERVER['QUERY_STRING'], $params);

	if( isset( $tpath_options['tpath_loop_products_per_page'] ) && $tpath_options['tpath_loop_products_per_page'] != '' ) {
		$products_per_page = $tpath_options['tpath_loop_products_per_page'];
	} else {
		$products_per_page = 12;
	}
	
	$product_count = !empty($params['product_count']) ? $params['product_count'] : $products_per_page;

	return $product_count;
}

// Change number of products per row to 4
add_filter('loop_shop_columns', 'justice_woo_loop_columns');

function justice_woo_loop_columns() {

	global $tpath_options;
	
	if( isset( $tpath_options['tpath_loop_shop_columns'] ) && $tpath_options['tpath_loop_shop_columns'] != '' ) {
		$product_columns = $tpath_options['tpath_loop_shop_columns'];
	} else {
		$product_columns = 3;
	}
	
	return $product_columns;
}

// Related Products Count
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action('woocommerce_after_single_product_summary', 'justice_woocommerce_output_related_products', 15);

function justice_woocommerce_output_related_products() {
	global $tpath_options;
	
	if( isset( $tpath_options['tpath_related_products_count'] ) && $tpath_options['tpath_related_products_count'] != '' ) {
		$related_count = $tpath_options['tpath_related_products_count'];
	} else {
		$related_count = 3;
	}
	
	$args = array(
		'posts_per_page' => $related_count,
		'columns' => $related_count,
		'orderby' => 'rand'
	);

	woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );
}

// Ajax Add to Cart Update
add_filter( 'add_to_cart_fragments', 'justice_woocommerce_add_to_cart_fragment' );
function justice_woocommerce_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	ob_start();
	?>
	<div class="woo-header-cart">
		<?php if( ! $woocommerce->cart->cart_contents_count ) { ?>
		<a class="cart-empty cart-contents" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><span class="cart-count"><?php echo esc_attr( $woocommerce->cart->cart_contents_count ); ?></span><i class="fa fa-shopping-cart"></i></a>
		<?php } else { ?>
		<a class="cart-icon cart-contents" href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>"><span class="cart-count"><?php echo esc_attr( $woocommerce->cart->cart_contents_count ); ?></span><i class="fa fa-shopping-cart"></i></a>
		
		<div class="woo-cart-contents">			
			<?php foreach( $woocommerce->cart->cart_contents as $cart_item_key => $cart_item ) { ?>
				<div class="woo-cart-item">
					<a href="<?php echo get_permalink($cart_item['product_id']); ?>" title="<?php echo esc_html( $cart_item['data']->post->post_title ); ?>">
						<?php $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id']; ?>
						<?php echo get_the_post_thumbnail($thumbnail_id, 'thumbnail'); ?>
						<div class="cart-item-content">
							<h5 class="cart-product-name"><?php echo wp_kses_post( $cart_item['data']->post->post_title ); ?></h5>
							<h5 class="cart-product-quantity"><?php echo wp_kses_post( $cart_item['quantity'] ); ?> x <?php echo wp_kses_post( $woocommerce->cart->get_product_subtotal($cart_item['data'], 1) ); ?></h5>
						</div>
					</a>					
					<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove remove-cart-item" title="%s" data-cart_id="%s">&times;</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __('Remove this item', 'Templatepath'), $cart_item_key ), $cart_item_key ); ?>
                    <div class="ajax-loading"></div>
				</div>
			<?php } ?>
			
			<div class="woo-cart-total">
				<h5 class="cart-total"><?php esc_html_e('Total: ', 'Templatepath'); ?> <?php echo wp_kses_post( $woocommerce->cart->get_cart_total() ); ?></h5>
			</div>
					
			<div class="woo-cart-buttons clearfix">
				<div class="cart-button"><a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>" title="<?php esc_html_e('Cart', 'Templatepath'); ?>"><?php esc_html_e('View Cart', 'Templatepath'); ?></a></div>
				<div class="checkout-button"><a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>" title="<?php esc_html_e('Checkout', 'Templatepath'); ?>"><?php esc_html_e('Checkout', 'Templatepath'); ?></a></div>
			</div>
		</div>
		<?php } ?>
	</div>
	
	<?php $fragments['.header-top-cart .woo-header-cart'] = ob_get_clean();
	
	return $fragments;

}

// Ajax Remove Item
add_action( 'wp_ajax_justice_product_remove', 'justice_ajax_product_remove' );
add_action( 'wp_ajax_nopriv_justice_product_remove', 'justice_ajax_product_remove' );
function justice_ajax_product_remove() {

    $cart = WC()->instance()->cart;
    $cart_id = $_POST['cart_id'];
    $cart_item_id = $cart->find_product_in_cart($cart_id);

    if ($cart_item_id) {
        $cart->set_quantity($cart_item_id, 0);
    }

    $cart_ajax = new WC_AJAX();
    $cart_ajax->get_refreshed_fragments();

    exit();
}

// Shop Ordering
if( isset( $tpath_options['tpath_woo_shop_ordering'] ) && ! $tpath_options['tpath_woo_shop_ordering'] ) {
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	add_action('woocommerce_before_shop_loop', 'justice_woocommerce_catalog_ordering', 30);
	add_action('woocommerce_get_catalog_ordering_args', 'justice_woocommerce_overwrite_catalog_ordering', 20);
}

function justice_woocommerce_catalog_ordering() {

	global $wp_query, $tpath_options;
	
	$product_order = array();
	$product_sort = array();
	
	$product_order['default'] 	 = esc_html__('Default Order', 'Templatepath');
	$product_order['title'] 	 = esc_html__('Name', 'Templatepath');
	$product_order['price'] 	 = esc_html__('Price', 'Templatepath');
	$product_order['date'] 		 = esc_html__('Date', 'Templatepath');
	$product_order['popularity'] = esc_html__('Popularity', 'Templatepath');

	$product_sort['asc'] 		 = esc_html__('Products ascending',  'Templatepath');
	$product_sort['desc'] 		 = esc_html__('Products descending',  'Templatepath');
	
	// Set the products per page options
	if( $tpath_options['tpath_loop_products_per_page'] ) {
		$per_page = $tpath_options['tpath_loop_products_per_page'];
	} else {
		$per_page = 12;
	}
	
	parse_str($_SERVER['QUERY_STRING'], $params);

	$product_order_key = !empty($params['product_order']) ? $params['product_order'] : 'default';
	$product_sort_key  = !empty($params['product_sort'])  ? $params['product_sort'] : 'asc';
	$product_count_key = !empty($params['product_count']) ? $params['product_count'] : $per_page;

	$product_sort_key = strtolower($product_sort_key);
	
	$output = '';
	
	$output .= '<div class="woo-catalog-ordering clearfix">';
		
		// Products Orderby
		$output .= '<div class="tpath-woo-orderby-container">';
		$output .= '<ul class="orderby-dropdown woo-ordering woo-dropdown">';
			$output .= '<li>';
				$output .= '<span class="current-li"><span class="current-li-content">'.esc_html__('Sort by: ', 'Templatepath').' <strong>'.$product_order[$product_order_key].'</strong></span></span>';
				$output .= '<ul class="order-sub-dropdown">';
					// Default
					$output .= '<li class="'.(($product_order_key == 'default') ? 'current': '').'"><a href="'.justice_woo_build_query_string($params, 'product_order', 'default').'"><strong>'.$product_order['default'].'</strong></a></li>';
					// Title
					$output .= '<li class="'.(($product_order_key == 'title') ? 'current': '').'"><a href="'.justice_woo_build_query_string($params, 'product_order', 'title').'"><strong>'.$product_order['title'].'</strong></a></li>';
					// Price
					$output .= '<li class="'.(($product_order_key == 'price') ? 'current': '').'"><a href="'.justice_woo_build_query_string($params, 'product_order', 'price').'"><strong>'.$product_order['price'].'</strong></a></li>';
					// Date
					$output .= '<li class="'.(($product_order_key == 'date') ? 'current': '').'"><a href="'.justice_woo_build_query_string($params, 'product_order', 'date').'"><strong>'.$product_order['date'].'</strong></a></li>';
					// Popularity
					$output .= '<li class="'.(($product_order_key == 'popularity') ? 'current': '').'"><a href="'.justice_woo_build_query_string($params, 'product_order', 'popularity').'"><strong>'.$product_order['popularity'].'</strong></a></li>';
				$output .= '</ul>';
			$output .= '</li>';
		$output .= '</ul>';
		$output .= '</div>';
		
		// Products Sorting
		$output .= '<div class="tpath-woo-sorting-container">';
		$output .= '<ul class="sorting-dropdown woo-sort-ordering">';
			if($product_sort_key == 'desc') {			
				$output .= '<li class="sort-desc"><a title="'.$product_sort['asc'].'" href="'.justice_woo_build_query_string($params, 'product_sort', 'asc').'"><i class="fa fa-arrow-down"></i></a></li>';
			}
			
			if($product_sort_key == 'asc') {			
				$output .= '<li class="sort-asc"><a title="'.$product_sort['desc'].'" href="'.justice_woo_build_query_string($params, 'product_sort', 'desc').'"><i class="fa fa-arrow-up"></i></a></li>';
			}
		$output .= '</ul>';
		$output .= '</div>';
		
		// Products Count
		$output .= '<div class="tpath-woo-count-container">';
		$output .= '<ul class="count-dropdown woo-product-count woo-dropdown">';
		
			$output .= '<li>';
				$output .= '<span class="current-li"><span class="current-li-content">'.esc_html__('Show: ', 'Templatepath').' <strong>'.$product_count_key.' '.esc_html__(' Products', 'Templatepath').'</strong></span></span>';
				$output .= '<ul class="order-sub-dropdown">';
					$output .= '<li class="'.(($product_count_key == $per_page) ? 'current': '').'"><a href="'.justice_woo_build_query_string($params, 'product_count', $per_page).'"><strong>'.$per_page.' '.esc_html__(' Products', 'Templatepath').'</strong></a></li>';
					
					$output .= '<li class="'.(($product_count_key == $per_page * 2) ? 'current': '').'"><a href="'.justice_woo_build_query_string($params, 'product_count', $per_page * 2).'"><strong>'.( $per_page * 2 ).' '.esc_html__(' Products', 'Templatepath').'</strong></a></li>';
					
					$output .= '<li class="'.(($product_count_key == $per_page * 3) ? 'current': '').'"><a href="'.justice_woo_build_query_string($params, 'product_count', $per_page * 3).'"><strong>'.( $per_page * 3 ).' '.esc_html__(' Products', 'Templatepath').'</strong></a></li>';
					
				$output .= '</ul>';
			$output .= '</li>';
		$output .= '</ul>';
		$output .= '</div>';
			
	$output .= '</div>';
	
	echo wp_kses_post( $output );
}

// Function to overwrite default query parameters
if( !function_exists('justice_woocommerce_overwrite_catalog_ordering') ) {	

	function justice_woocommerce_overwrite_catalog_ordering($args) {
			
		global $woocommerce;

		// Check parameters and session vars. if they are set overwrite the defaults
		$check = array('product_order', 'product_count', 'product_sort');		

		foreach($check as $key) {
			if(isset($_GET[$key]) ) $_SESSION['tpath_woocommerce'][$key] = esc_attr($_GET[$key]);			
		}

		// is user wants to use new product order remove the old sorting parameter
		if(isset($_GET['product_order']) && !isset($_GET['product_sort']) && isset($_SESSION['tpath_woocommerce']['product_sort'])) {
			unset($_SESSION['tpath_woocommerce']['product_sort']);
		}
		
		parse_str($_SERVER['QUERY_STRING'], $params);
		
		$product_order = !empty($params['product_order']) ? $params['product_order'] : 'default';
		$product_sort = !empty($params['product_sort'])  ? $params['product_sort'] : 'asc';

		// Product order
		if(!empty($product_order)) {
			switch( $product_order ) {
				case 'date': 
					$orderby = 'date'; 
					$order = 'desc'; 
					$meta_key = '';  
					break;
				case 'price': 
					$orderby = 'meta_value_num'; 
					$order = 'asc'; 
					$meta_key = '_price'; 
					break;
				case 'popularity': 
					$orderby = 'meta_value_num'; 
					$order = 'desc'; 
					$meta_key = 'total_sales'; 
					break;
				case 'title': 
					$orderby = 'title'; 
					$order = 'asc'; 
					$meta_key = ''; 
					break;
				case 'default':
				default: 
					$orderby = 'menu_order title'; 
					$order = 'asc'; 
					$meta_key = ''; 
					break;
			}
		}

		// Product sorting
		if(!empty($product_sort))
		{
			switch( $product_sort ) {
				case 'desc': 
					$order = 'desc'; 
					break;
				case 'asc': 
					$order = 'asc'; 
					break;
				default: 
					$order = 'asc'; 
					break;
			}
		}


		if(isset($orderby)) $args['orderby'] = $orderby;
		if(isset($order)) 	$args['order'] = $order;
		
		if (!empty($meta_key)) {
			$args['meta_key'] = $meta_key;
		}
				
		return $args;
	}
}