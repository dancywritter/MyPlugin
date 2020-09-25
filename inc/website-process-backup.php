<?php
global $woocommerce;

// Export posts functions
/*add_action( 'manage_posts_extra_tablenav', 'admin_post_list_top_export_button', 20, 1 );
function admin_post_list_top_export_button( $which ) {
    global $typenow;
    print_r($typenow);
 
    if ( 'fruits-order' === $typenow && 'top' === $which ) {
        ?>
        <input type="submit" name="export_all_posts" id="export_all_posts" class="button button-primary" value="Export All Orders" />
        <?php
    }
}

add_action( 'init', 'func_export_all_posts' );
function func_export_all_posts() {
    if(isset($_GET['export_all_posts'])) {
        $arg = array(
                'post_type' => 'fruits-order',
                'post_status' => 'publish',
                'posts_per_page' => -1,
            );
 
        global $post;
        $arr_post = get_posts($arg);
        if ($arr_post) {
 
            header('Content-type: text/csv');
            header('Content-Disposition: attachment; filename="orders.csv"');
            header('Pragma: no-cache');
            header('Expires: 0');
 
            $file = fopen('php://output', 'w');
 
            fputcsv($file, array('Post Title', 'URL', 'Categories', 'Tags'));
 
            foreach ($arr_post as $post) {
                setup_postdata($post);
                 
                $categories = get_the_category();
                $cats = array();
                if (!empty($categories)) {
                    foreach ( $categories as $category ) {
                        $cats[] = $category->name;
                    }
                }
 
                $post_tags = get_the_tags();
                $tags = array();
                if (!empty($post_tags)) {
                    foreach ($post_tags as $tag) {
                        $tags[] = $tag->name;
                    }
                }
 
                fputcsv($file, array(get_the_title(), get_the_permalink(), implode(",", $cats), implode(",", $tags)));
            }
 
            exit();
        }
    }
}*/


// add_action( 'woocommerce_before_cart', 'esouq_wcfmmp_sold_by_cart' );
// add_action( 'woocommerce_checkout_before_customer_details', 'esouq_wcfmmp_sold_by_cart' );
// add_filter('woocommerce_get_item_data', array( &$this, 'esouq_wcfmmp_sold_by_cart' ), 50, 2 );
function esouq_wcfmmp_sold_by_cart() {
	global $WCFM, $WCFMmp;

	$vendor_sold_by_position = isset( $WCFMmp->wcfmmp_marketplace_options['vendor_sold_by_position'] ) ? $WCFMmp->wcfmmp_marketplace_options['vendor_sold_by_position'] : 'below_atc';
	$is_look_hook_defined = false;

	$cart_item_meta = array();
	$product_store = '';
	// Iterating through cart items and check
    foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
	
    	if( !apply_filters( 'wcfmmp_is_allow_cart_sold_by', true ) ) return;
    	
    	if( $WCFMmp->wcfmmp_vendor->is_vendor_sold_by() ) {
    		$product_id = $cart_item['product_id'];
    		if( !$product_id ) {
    			$variation_id 	= sanitize_text_field( $cart_item['variation_id'] );
    			if( $variation_id ) {
    				$product_id = wp_get_post_parent_id( $variation_id );
    			}
    		}
    		$vendor_id = wcfm_get_vendor_id_by_post( $product_id );
    		if( $vendor_id ) {
    			if( apply_filters( 'wcfmmp_is_allow_sold_by', true, $vendor_id ) && wcfm_vendor_has_capability( $vendor_id, 'sold_by' ) ) {
    				// Check is store Online
    				$is_store_offline = get_user_meta( $vendor_id, '_wcfm_store_offline', true );
    				if ( !$is_store_offline ) {
    					$sold_by_text = $WCFMmp->wcfmmp_vendor->sold_by_label( absint($vendor_id) );
    					
    					if( apply_filters( 'wcfmmp_is_allow_sold_by_linked', true ) ) {
    						$store_name = wcfm_get_vendor_store( absint($vendor_id) );
    					} else {
    						$store_name = wcfm_get_vendor_store_name( absint($vendor_id) );
    					}
    					
    					do_action('before_wcfmmp_sold_by_label_cart_page', $vendor_id, $product_id );
    					if( !is_array( $cart_item_meta ) ) $cart_item_meta = (array) $cart_item_meta;
    				// 	$cart_item_meta = array_merge( $cart_item_meta, array( array( 'name' => $sold_by_text, 'value' => $store_name ) ) );
    					$cart_item_meta = array_merge( $cart_item_meta, array( array( 'value' => $store_name ) ) );

    					/*echo '<pre>';
    					print_r($cart_item_meta);
    				// 	echo '<br>' . $cart_item_meta['value'] . '<br>';
    					echo '</pre>';*/
    					do_action('after_wcfmmp_sold_by_label_cart_page', $vendor_id, $product_id );
    				}
    			}
    		}
    	}
    }
    
    foreach ($cart_item_meta as $object) {
        if ($object[value] == '<a class="wcfm_dashboard_item_title" target="_blank" href="'. esc_url( home_url() ) .'/store/efruits/">eFruits</a>') {
		    echo 'This item is belongs to eFruit Store<br>';
		} else {
		    echo 'This item is not belongs to eFruit Store<br>';
		}
    }
}

/*add_action( 'woocommerce_before_cart', 'esouq_find_product_in_cart' );
add_action( 'woocommerce_checkout_before_customer_details', 'esouq_find_product_in_cart' );
function esouq_find_product_in_cart() {
    global $woocommerce, $wp, $WCFM, $WCFMmp, $post;

    $store_id           = $WCFM->wcfm_vendor_support->wcfm_get_vendor_id_from_product( $post->ID );

	// WCFM Categories
	$wcfm_store_url    = wcfm_get_option( 'wcfm_store_url', 'store' );
	$wcfm_store_name   = apply_filters( 'wcfmmp_store_query_var', get_query_var( $wcfm_store_url ) );
	$seller_info       = get_user_by( 'slug', $wcfm_store_name );
	if( !$seller_info ) return;
	
	$store_user        = wcfmmp_get_store( $seller_info->data->ID );
	$is_store_offline = get_user_meta( $store_user->get_id(), '_wcfm_store_offline', true );
	
	$store_name = get_user_meta( $store_user->get_id(), 'store_name', true );
	$storeUrl = wcfmmp_get_store_url( $store_id );
	
	wc_print_notice( $store_name, 'notice' );
	
    $product_id = 6355;
    $product_cart_id = WC()->cart->generate_cart_id( $product_id );
    $in_cart = WC()->cart->find_product_in_cart( $product_cart_id );

    if ( $in_cart ) {
        $notice = 'Product ID ' . $product_id . ' is in the Cart!';
        wc_print_notice( $notice, 'notice' );

    } else {
        $notice = 'Product ID ' . $product_id . ' is not in the Cart!';
        wc_print_notice( $notice, 'notice' );

    }

    // Set here your product IDS (in the array)
    $product_ids = array( 6355, 7595, 7593 );

    // Iterating through cart items and check
    foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        if( in_array( $cart_item['data']->get_id(), $product_ids ) ){
            $ids = implode(", ",$product_ids);
            $msg = 'Product ' . $cart_item['data']->get_id() . ' are in the Cart!';
            wc_print_notice( $msg, 'notice' );
            break; // At east one product, we stop the loop
        }
    }
}*/

// Add Fee Based on City on checkout
// Part 1: assign fee
add_action( 'woocommerce_cart_calculate_fees', 'esouq_add_checkout_fee_for_gateway' );
function esouq_add_checkout_fee_for_gateway() {
	global $woocommerce, $wp, $WCFM, $WCFMmp, $post;

	$vendor_sold_by_position = isset( $WCFMmp->wcfmmp_marketplace_options['vendor_sold_by_position'] ) ? $WCFMmp->wcfmmp_marketplace_options['vendor_sold_by_position'] : 'below_atc';
	$is_look_hook_defined = false;

	$cart_item_meta = array();
	$product_store = '';
	// Iterating through cart items and check
    foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
	
    	if( !apply_filters( 'wcfmmp_is_allow_cart_sold_by', true ) ) return;
    	
    	if( $WCFMmp->wcfmmp_vendor->is_vendor_sold_by() ) {
    		$product_id = $cart_item['product_id'];
    		if( !$product_id ) {
    			$variation_id 	= sanitize_text_field( $cart_item['variation_id'] );
    			if( $variation_id ) {
    				$product_id = wp_get_post_parent_id( $variation_id );
    			}
    		}
    		$vendor_id = wcfm_get_vendor_id_by_post( $product_id );
    		if( $vendor_id ) {
    			if( apply_filters( 'wcfmmp_is_allow_sold_by', true, $vendor_id ) && wcfm_vendor_has_capability( $vendor_id, 'sold_by' ) ) {
    				// Check is store Online
    				$is_store_offline = get_user_meta( $vendor_id, '_wcfm_store_offline', true );
    				if ( !$is_store_offline ) {
    					$sold_by_text = $WCFMmp->wcfmmp_vendor->sold_by_label( absint($vendor_id) );
    					
    					if( apply_filters( 'wcfmmp_is_allow_sold_by_linked', true ) ) {
    						$store_name = wcfm_get_vendor_store( absint($vendor_id) );
    					} else {
    						$store_name = wcfm_get_vendor_store_name( absint($vendor_id) );
    					}
    					
    					do_action('before_wcfmmp_sold_by_label_cart_page', $vendor_id, $product_id );
    					if( !is_array( $cart_item_meta ) ) $cart_item_meta = (array) $cart_item_meta;
    				// 	$cart_item_meta = array_merge( $cart_item_meta, array( array( 'name' => $sold_by_text, 'value' => $store_name ) ) );
    					$cart_item_meta = array_merge( $cart_item_meta, array( array( 'value' => $store_name ) ) );

    					do_action('after_wcfmmp_sold_by_label_cart_page', $vendor_id, $product_id );
    				}
    			}
    		}
    	}
    }

    $product_id = 6355;

    $product_cart_id = WC()->cart->generate_cart_id( $product_id );
    $in_cart = WC()->cart->find_product_in_cart( $product_cart_id );

    // Will get you cart object
    $cart = WC()->cart;
    // Will get you cart object
    $cart_total = $woocommerce->cart->get_subtotal();
    $billing_city = WC()->customer->get_billing_city();
  	$chosen_gateway = WC()->session->get( 'chosen_payment_method' );

	//location
	$outside_doha = ['semismia', 'alkhor', 'shamal', 'alkhartiyat'];
	$far_doha = ['duhail', 'wakra', 'mauither', 'azezia', 'murra', 'gharrafa', 'madinatkhalifa', 'dafna'];
	$doha = ['alsadd', 'mansoura', 'muntaza', 'hilal', 'alnasr'];

	$ship1 = ['madinatkhalifanorth', 'madinatkhalifasouth', 'gharrafa', 'ghuwariyah', 'albidda', 'almarkhiya', 'westbay', 'dafna', 'onaiza', 'alsadd', 'almirqab', 'almessila', 'hamadMedicalCity', 'rumeilah', 'binOmran', 'alThumama', 'oldAirport', 'abuHamour', 'ummGhuwailina', 'rasAbuAboud', 'oldAlGhanim', 'newSalata', 'fereejAlGhanim', 'musherib', 'najma', 'alMamoura', 'alMansoura', 'alHilal', 'alNajada', 'asSalatah', 'alSouq', 'rawdatAlKhail', 'adDawhahAlJadidah', 'fereejAbdelAziz'];
	$ship2 = ['luqta', 'Kharaitiyat', 'ummsalal', 'alkheesa', 'simaisma', 'raslafan', 'alkhor', 'the_pearl', 'lusail', 'barwa', 'alWakrah', 'alWukair', 'salwaRoad', 'fereejAlMurra', 'ainKhalid', 'alSailiya', 'alAziziya', 'alWaab', 'muaither', 'mesaimeer', 'oldRayyan', 'newAlRayyan'];
	$ship3 = ['mesaieed', 'mesaieedIndustrialArea', 'alshahaniya', 'industrialArea', 'baniHajer', 'duhail', 'dukhan'];
	$ship4 = ['abuSamra'];
	$ship5 = ['shonidharti'];
	$ship6 = ['mesaieedcommunity'];


	if($in_cart) {
    	if ($chosen_gateway !== 'cod') {
    	  	WC()->cart->add_fee( '', 0 );
    	} else if (in_array($billing_city, $ship1 ) && $chosen_gateway === 'cod') {
    		WC()->cart->add_fee( 'Delivery Fee (Calculated per City):', 15 );
    	} else if (in_array($billing_city, $ship2) && $chosen_gateway === 'cod') {
    		WC()->cart->add_fee( 'Delivery Fee (Calculated per City):', 20 );
    	} else if (in_array($billing_city, $ship3) && $chosen_gateway === 'cod') {
    		WC()->cart->add_fee( 'Delivery Fee (Calculated per City):', 25 );
    	} else if (in_array($billing_city, $ship4) && $chosen_gateway === 'cod') {
    		WC()->cart->add_fee( 'Delivery Fee (Calculated per City):', 30 );
    	} else if (in_array($billing_city, $ship5) && $chosen_gateway === 'cod') {
    	    foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                if($cart_item['quantity'] < 3) {  
        		    WC()->cart->add_fee( 'Delivery Fee (Calculated per City):', 10 );
        	    } else {
        		    WC()->cart->add_fee( 'Delivery Fee (Calculated per City):', 0 );
        	    }
            }
    	} else if (in_array($billing_city, $ship6) && $chosen_gateway === 'cod') {
    		WC()->cart->add_fee( 'Delivery Fee (Calculated per City):', 5 );
    	} else {
    		WC()->cart->add_fee( '', 0 );
    	}
	} else {
	    global $WCFM, $WCFMmp;

    	$vendor_sold_by_position = isset( $WCFMmp->wcfmmp_marketplace_options['vendor_sold_by_position'] ) ? $WCFMmp->wcfmmp_marketplace_options['vendor_sold_by_position'] : 'below_atc';
    	$is_look_hook_defined = false;
    
    	$cart_item_meta = array();
    	$product_store = '';
    	// Iterating through cart items and check
        foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
    	
        	if( !apply_filters( 'wcfmmp_is_allow_cart_sold_by', true ) ) return;
        	
        	if( $WCFMmp->wcfmmp_vendor->is_vendor_sold_by() ) {
        		$product_id = $cart_item['product_id'];
        		if( !$product_id ) {
        			$variation_id 	= sanitize_text_field( $cart_item['variation_id'] );
        			if( $variation_id ) {
        				$product_id = wp_get_post_parent_id( $variation_id );
        			}
        		}
        		$vendor_id = wcfm_get_vendor_id_by_post( $product_id );
        		if( $vendor_id ) {
        			if( apply_filters( 'wcfmmp_is_allow_sold_by', true, $vendor_id ) && wcfm_vendor_has_capability( $vendor_id, 'sold_by' ) ) {
        				// Check is store Online
        				$is_store_offline = get_user_meta( $vendor_id, '_wcfm_store_offline', true );
        				if ( !$is_store_offline ) {
        					$sold_by_text = $WCFMmp->wcfmmp_vendor->sold_by_label( absint($vendor_id) );
        					
        					if( apply_filters( 'wcfmmp_is_allow_sold_by_linked', true ) ) {
        						$store_name = wcfm_get_vendor_store( absint($vendor_id) );
        					} else {
        						$store_name = wcfm_get_vendor_store_name( absint($vendor_id) );
        					}
        					
        					do_action('before_wcfmmp_sold_by_label_cart_page', $vendor_id, $product_id );
        					if( !is_array( $cart_item_meta ) ) $cart_item_meta = (array) $cart_item_meta;
        				// 	$cart_item_meta = array_merge( $cart_item_meta, array( array( 'name' => $sold_by_text, 'value' => $store_name ) ) );
        					$cart_item_meta = array_merge( $cart_item_meta, array( array( 'value' => $store_name ) ) );

        					do_action('after_wcfmmp_sold_by_label_cart_page', $vendor_id, $product_id );
        				}
        			}
        		}
        	}
        }
        
        foreach ($cart_item_meta as $object) {
            if ($object[value] == '<a class="wcfm_dashboard_item_title" target="_blank" href="'. esc_url( home_url() ) .'/store/efruits/">eFruits</a>' && $in_cart) {
    		    echo 'This is eFruit Store items and There are mangoes too in the cart<br>';
    		    
    		    if ($chosen_gateway !== 'cod') {
            	  	WC()->cart->add_fee( '', 0 );
            	} else if (in_array($billing_city, $ship1 ) && $chosen_gateway === 'cod') {
            		WC()->cart->add_fee( 'Delivery Fee (Calculated per City):', 15 );
            	} else if (in_array($billing_city, $ship2) && $chosen_gateway === 'cod') {
            		WC()->cart->add_fee( 'Delivery Fee (Calculated per City):', 20 );
            	} else if (in_array($billing_city, $ship3) && $chosen_gateway === 'cod') {
            		WC()->cart->add_fee( 'Delivery Fee (Calculated per City):', 25 );
            	} else if (in_array($billing_city, $ship4) && $chosen_gateway === 'cod') {
            		WC()->cart->add_fee( 'Delivery Fee (Calculated per City):', 30 );
            	} else if (in_array($billing_city, $ship5) && $chosen_gateway === 'cod') {
            	    foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                        if($cart_item['quantity'] < 3) {  
                		    WC()->cart->add_fee( 'Delivery Fee (Calculated per City):', 10 );
                	    } else {
                		    WC()->cart->add_fee( 'Delivery Fee (Calculated per City):', 0 );
                	    }
                    }
            	} else if (in_array($billing_city, $ship6) && $chosen_gateway === 'cod') {
            		WC()->cart->add_fee( 'Delivery Fee (Calculated per City):', 5 );
            	} else {
            		WC()->cart->add_fee( '', 0 );
            	}

    		} elseif ($object[value] == '<a class="wcfm_dashboard_item_title" target="_blank" href="'. esc_url( home_url() ) .'/store/efruits/">eFruits</a>' && !$in_cart) {
    		    echo 'This item is belongs to eFruit Store<br>';

    		} else {
    		    echo 'This item is not belongs to eFruit Store<br>';
    		}
        }
	}
}

// Part 2: reload checkout on payment gateway change
add_action( 'woocommerce_review_order_before_payment', 'esouq_refresh_checkout_on_payment_methods_change' );
function esouq_refresh_checkout_on_payment_methods_change(){
    ?>
    <script type="text/javascript">
        (function($){
			$('#billing_city').on('change', function() {
			    $('body').trigger('update_checkout');
			});
		    $( 'form.checkout' ).on( 'change', 'input[name^="payment_method"]', function() {
                $('body').trigger('update_checkout');
            });
        })(jQuery);
    </script>
    <?php
}

// Part 3: disable enable button
add_filter('woocommerce_order_button_html', 'esouq_inactive_order_button_html' );
function esouq_inactive_order_button_html( $button ) {
    global $woocommerce;
    $product_id = 6355;
    
    $product_cart_id = WC()->cart->generate_cart_id( $product_id );
    $in_cart = WC()->cart->find_product_in_cart( $product_cart_id );

    // Will get you cart object
    $cart = WC()->cart;
    // Will get you cart object
    $cart_total = $woocommerce->cart->get_subtotal();
    $billing_city = WC()->customer->get_billing_city();
  	$chosen_gateway = WC()->session->get( 'chosen_payment_method' );

	//location
	$outside_doha = ['semismia', 'alkhor', 'shamal', 'alkhartiyat'];
	$far_doha = ['duhail', 'wakra', 'mauither', 'azezia', 'murra', 'gharrafa', 'madinatkhalifa', 'dafna'];
	$doha = ['alsadd', 'mansoura', 'muntaza', 'hilal', 'alnasr'];

	$route1 = ['madinatkhalifanorth', 'madinatkhalifasouth', 'gharrafa', 'ghuwariyah', 'luqta', 'Kharaitiyat', 'ummsalal', 'alkheesa', 'simaisma', 'raslafan', 'alkhor'];
	$route2 = ['albidda', 'almarkhiya', 'westbay', 'dafna', 'onaiza', 'the_pearl', 'lusail'];
	$route3 = ['binmahmoud', 'alsadd', 'almirqab', 'almessila', 'hamadMedicalCity', 'rumeilah', 'binOmran'];
	$route4 = ['alThumama', 'oldAirport', 'barwa', 'alWakrah', 'alWukair', 'mesaieed', 'mesaieedIndustrialArea'];
	$route5 = ['abuHamour', 'salwaRoad', 'fereejAlMurra', 'ainKhalid', 'alSailiya', 'alshahaniya', 'industrialArea', 'abuSamra'];
	$route6 = ['alAziziya', 'alWaab', 'muaither', 'mesaimeer', 'oldRayyan', 'newAlRayyan', 'baniHajer', 'duhail', 'dukhan'];
	$route7 = ['ummGhuwailina', 'rasAbuAboud', 'oldAlGhanim', 'newSalata', 'fereejAlGhanim', 'musherib', 'najma', 'alMamoura', 'alMansoura', 'alHilal', 'alNajada', 'asSalatah', 'alSouq', 'rawdatAlKhail', 'adDawhahAlJadidah', 'fereejAbdelAziz'];

	$ship1 = ['madinatkhalifanorth', 'madinatkhalifasouth', 'gharrafa', 'ghuwariyah', 'albidda', 'almarkhiya', 'westbay', 'dafna', 'onaiza', 'alsadd', 'almirqab', 'almessila', 'hamadMedicalCity', 'rumeilah', 'binOmran', 'alThumama', 'oldAirport', 'abuHamour', 'ummGhuwailina', 'rasAbuAboud', 'oldAlGhanim', 'newSalata', 'fereejAlGhanim', 'musherib', 'najma', 'alMamoura', 'alMansoura', 'alHilal', 'alNajada', 'asSalatah', 'alSouq', 'rawdatAlKhail', 'adDawhahAlJadidah', 'fereejAbdelAziz'];
	$ship2 = ['luqta', 'Kharaitiyat', 'ummsalal', 'alkheesa', 'simaisma', 'raslafan', 'alkhor', 'the_pearl', 'lusail', 'barwa', 'alWakrah', 'alWukair', 'salwaRoad', 'fereejAlMurra', 'ainKhalid', 'alSailiya', 'alAziziya', 'alWaab', 'muaither', 'mesaimeer', 'oldRayyan', 'newAlRayyan'];
	$ship3 = ['mesaieed', 'mesaieedIndustrialArea', 'alshahaniya', 'industrialArea', 'baniHajer', 'duhail', 'dukhan'];
	$ship4 = ['abuSamra'];
	$ship5 = ['shonidharti', 'mesaieedcommunity'];

	$found = false;
	if($in_cart) {
      	if (in_array($billing_city, $route1 ) && $chosen_gateway === 'cod' || in_array($billing_city, $route2) && $chosen_gateway === 'cod' || in_array($billing_city, $route2) && $chosen_gateway === 'cod' || in_array($billing_city, $route2) && $chosen_gateway === 'cod' || in_array($billing_city, $route2) && $chosen_gateway === 'cod' || in_array($billing_city, $route2) && $chosen_gateway === 'cod') {
    		$found = true;
    	} else {
    		$found = false;
    	}
	} else {
	    if ($chosen_gateway !== 'cod') {
    	  	$found = true;
    	} else if (in_array($billing_city, $outside_doha ) && $cart_total > 175 && $chosen_gateway === 'cod') {
    		$found = true;
    	} else if (in_array($billing_city, $far_doha) && $cart_total > 90 && $chosen_gateway === 'cod') {
    		$found = true;
    	} else if (in_array($billing_city, $doha) && $cart_total > 90 && $chosen_gateway === 'cod') {
    		$found = true;
    	} else {
    		$found = false;
    	}
	}

	
    if ( $in_cart ) {} else {
        // If found we replace the button by an inactive greyed one
        if( !$found ) {
    		$message = "wrong answer";
            $style = 'style="background:Silver !important; color:white !important; cursor: not-allowed !important; width: 100%;font-size: 15px; line-height: 1.6; padding: 16px 20px;"';
            $button_text = apply_filters( 'woocommerce_order_button_text', __( 'Place order', 'woocommerce' ) );
            $button = '<a class="button" '.$style.'>' . $button_text . '</a>';
    		
    		?>
    		<script type='text/javascript'>
    			(function($){
    				$( ".woocommerce-privacy-policy-text" ).after( "<div style='background-color: rgba(255,0,0,.1);padding: 15px;'><p style='margin: 0; color: #666'><b>Sorry!</b> You cannot place an order.<br>- For inside Doha minimum order is 90 QAR.<br>- For outside Doha minimum Order is 175 QAR.</p></div>" );
    			})(jQuery);
    		</script>
    		<?php
        }
    }
    return $button;
}

add_filter( 'woocommerce_checkout_fields' , 'esouq_custom_checkout_fields' );
function esouq_custom_checkout_fields( $fields ) {
    unset($fields['billing']['billing_state']);
    return $fields;
}

// City Dropdown on Checkout
function esouq_change_city_to_dropdown( $fields ) {
	$city_args = wp_parse_args( array(
		'type' => 'select',
		'options' => array(
			'shonidharti'               => 'Sohni Dharti Community',
			'mesaieedcommunity'         => 'Mesaieed Community',
			'madinatkhalifanorth'       => 'Madinat Khalifa North',
			'madinatkhalifasouth'       => 'Madinat Khalifa South',
			'gharrafa'                  => 'Al Gharrafa',
			'ghuwariyah'                => 'Al Ghuwariyah',
			'luqta'                     => 'Al Luqta',
			'Kharaitiyat'               => 'Al Kharaitiyat',
			'ummsalal'                  => 'Umm Salal',
			'alkheesa'                  => 'Al Kheesa',
			'simaisma'                  => 'Simaisma',
			'raslafan'                  => 'Ras Lafan',
			'alkhor'                    => 'Al Khor',

			'albidda'                   => 'Al Bidda',
			'almarkhiya'                => 'Al Markhiya',
			'westbay'                   => 'Westbay',
			'dafna'                     => 'Dafna',
			'onaiza'                    => 'Onaiza',
			'the_pearl'                 => 'The Pearl',
			'lusail'                    => 'Lusail',
			'binmahmoud'                => 'Bin Mahmoud',

			'alsadd'                    => 'Al Sadd',
			'almirqab'                  => 'Al Mirqab',
			'almessila'                 => 'Al Messila',
			'hamadMedicalCity'          => 'Hamad Medical City',
			'rumeilah'                  => 'Rumeilah',
			'binOmran'                  => 'Bin Omran',

			'alThumama'                 => 'Al Thumama',
			'oldAirport'                => 'Old Airport',
			'barwa'                     => 'Barwa',
			'alWakrah'                  => 'Al Wakrah',
			'alWukair'                  => 'Al Wukair',
			'mesaieed'                  => 'Mesaieed',
			'mesaieedIndustrialArea'    => 'Mesaieed Industrial Area',

			'abuHamour'                 => 'Abu Hamour',
			'salwaRoad'                 => 'Salwa Road',
			'fereejAlMurra'             => 'Fereej Al Murra',
			'ainKhalid'                 => 'Ain Khalid',
			'alSailiya'                 => 'Al Sailiya',
			'alshahaniya'               => 'Al Shahaniya',
			'industrialArea'            => 'Industrial Area',
			'abuSamra'                  => 'Abu Samra',

			'alAziziya'                 => 'Al Aziziya',
			'alWaab'                    => 'Al Waab',
			'muaither'                  => 'Muaither',
			'mesaimeer'                 => 'Mesaimeer',
			'oldRayyan'                 => 'Old Rayyan',
			'newAlRayyan'               => 'New Al Rayyan',
			'baniHajer'                 => 'Bani Hajer',
			'duhail'                    => 'Duhail',
			'dukhan'                    => 'Dukhan',

			'ummGhuwailina'             => 'Umm Ghuwailina',
			'rasAbuAboud'               => 'Ras Abu Aboud',
			'oldAlGhanim'               => 'Old Al Ghanim',
			'newSalata'                 => 'New Salata',
			'fereejAlGhanim'            => 'Fereej Al Ghanim',
			'musherib'                  => 'Musherib',
			'najma'                     => 'Najma',
			'alMamoura'                 => 'Al Mamoura',
			'alMansoura'                => 'Al Mansoura',
			'alHilal'                   => 'Al Hilal',
			'alNajada'                  => 'Al Najada',
			'asSalatah'                 => 'As Salatah',
			'alSouq'                    => 'Al Souq',
			'rawdatAlKhail'             => 'Rawdat Al Khail',
			'adDawhahAlJadidah'         => 'Ad Dawhah Al Jadidah',
			'fereejAbdelAziz'           => 'Fereej Abdel Aziz',
		),
	), $fields['shipping']['shipping_city'] );
	$fields['shipping']['shipping_city'] = $city_args;
	$fields['billing']['billing_city'] = $city_args; // Also change for billing field
	return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'esouq_change_city_to_dropdown' );

