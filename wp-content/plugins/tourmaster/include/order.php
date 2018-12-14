<?php
	/*	
	*	Ordering Page
	*/

	add_action('admin_menu', 'tourmaster_init_order_page', 99);
	if( !function_exists('tourmaster_init_order_page') ){
		function tourmaster_init_order_page(){
			add_submenu_page(
				'tourmaster_admin_option', 
				esc_html__('Transaction Order', 'tourmaster'), 
				esc_html__('Transaction Order', 'tourmaster'),
				'manage_tour_order', 
				'tourmaster_order', 
				'tourmaster_create_order_page'
			);
		}
	}

	// add the script when opening the theme option page
	add_action('admin_enqueue_scripts', 'tourmaster_order_page_script');
	if( !function_exists('tourmaster_order_page_script') ){
		function tourmaster_order_page_script($hook){
			if( strpos($hook, 'page_tourmaster_order') !== false ){
				tourmaster_include_utility_script(array(
					'font-family' => 'Open Sans'
				));

				wp_enqueue_style('tourmaster-order', TOURMASTER_URL . '/include/css/order.css');
				wp_enqueue_script('tourmaster-order', TOURMASTER_URL . '/include/js/order.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), false, true);
			}
		}
	}

	if( !function_exists('tourmaster_create_order_page') ){
		function tourmaster_create_order_page(){
			if( !isset($_GET['single']) ){
				$action_url = remove_query_arg(array('order_id', 'from_date', 'to_date', 'action', 'id'));

				$statuses = array(
					'all' => esc_html__('All', 'tourmaster'),
					'pending' => esc_html__('Pending', 'tourmaster'),
					'approved' => esc_html__('Approved', 'tourmaster'),
					'receipt-submitted' => esc_html__('Receipt Submitted', 'tourmaster'),
					'online-paid' => esc_html__('Online Paid', 'tourmaster'),
					'deposit-paid' => esc_html__('Deposit Paid', 'tourmaster'),
					'departed' => esc_html__('Departed', 'tourmaster'),
					'rejected' => esc_html__('Rejected', 'tourmaster'),
					'cancel' => esc_html__('Cancel', 'tourmaster'),
				);
?>
<div class="tourmaster-order-filter-wrap" >
	<form class="tourmaster-order-search-form" method="get" action="<?php echo esc_url($action_url); ?>" >
		<label><?php esc_html_e('Search by order id :', 'tourmaster'); ?></label>
		<input type="text" name="order_id" value="<?php echo empty($_GET['order_id'])? '': esc_attr($_GET['order_id']); ?>" />
		<input type="hidden" name="page" value="tourmaster_order" />
		<input type="submit" value="<?php esc_html_e('Search', 'tourmaster'); ?>" />
	</form>
	<form class="tourmaster-order-search-form" method="get" action="<?php echo esc_url($action_url); ?>" >
		<label><?php esc_html_e('Date Filter :', 'tourmaster'); ?></label>
		<span class="tourmaster-separater" ><?php esc_html_e('From', 'tourmaster') ?></span>
		<input class="tourmaster-datepicker" type="text" name="from_date" value="<?php echo empty($_GET['from_date'])? '': esc_attr($_GET['from_date']); ?>" />
		<span class="tourmaster-separater" ><?php esc_html_e('To', 'tourmaster') ?></span>
		<input class="tourmaster-datepicker" type="text" name="to_date" value="<?php echo empty($_GET['to_date'])? '': esc_attr($_GET['to_date']); ?>" />
		<input type="hidden" name="page" value="tourmaster_order" />
		<input type="submit" value="<?php esc_html_e('Filter', 'tourmaster'); ?>" />
	</form>
	<div class="tourmaster-order-filter" >
	<?php
		$order_status = empty($_GET['order_status'])? 'all': $_GET['order_status'];
		foreach( $statuses as $status_slug => $status ){
			echo '<span class="tourmaster-separator" >|</span>';
			echo '<a href="' . esc_url(add_query_arg(array('order_status'=>$status_slug), $action_url)) . '" ';
			echo 'class="tourmaster-order-filter-status ' . ($status_slug == $order_status? 'tourmaster-active': '') . '" >';
			echo $status;
			echo '</a>';
		}
	?>
	</div>
</div>
<?php				
			}

			echo '<div class="tourmaster-order-page-wrap" >';
			echo '<div class="tourmaster-order-page-head" >';
			echo '<i class="fa fa-check-circle-o" ></i>';
			echo esc_html__('Transaction Order', 'tourmaster');
			echo '</div>'; // tourmaster-order-page-head

			echo '<div class="tourmaster-order-page-content" >';
			if( isset($_GET['single']) ){
				tourmaster_get_single_order();
			}else{
				tourmaster_get_order_list();
			}

			echo '</div>'; // tourmaster-order-page-content
			echo '</div>'; // tourmaster-order-page-wrap
		}
	}

	if( !function_exists('tourmaster_get_order_list') ){
		function tourmaster_get_order_list(){

			// order action
			if( !empty($_GET['action']) && !empty($_GET['id']) ){
 				if( $_GET['action'] == 'remove' ){
 					tourmaster_mail_notification('booking-reject-mail', $_GET['id']);
 					tourmaster_remove_booking_data($_GET['id']);

 				}else if( in_array($_GET['action'], array('approved', 'rejected')) ){

 					$old_result = tourmaster_get_booking_data(array(
 						'id' => $_GET['id']
 					), array( 'single' => true ), 'order_status');

 					$updated = tourmaster_update_booking_data(
 						array('order_status' => $_GET['action']),
 						array('id' => $_GET['id']),
 						array('%s'),
 						array('%d')
 					);

 					// send the mail
 					if( !empty($updated) ){
 						if( $_GET['action'] == 'approved' ){
 							if( $old_result->order_status != 'online-paid' ){
 								tourmaster_mail_notification('payment-made-mail', $_GET['id']);
 							}
 						}else if( $_GET['action'] == 'rejected' ){
 							tourmaster_mail_notification('booking-reject-mail', $_GET['id']);
 						} 
 					}
 				}
 			}

			// print the order
 			$paged = empty($_GET['paged'])? 1: $_GET['paged'];
 			$num_fetch = 20;
 			$max_num_page = ceil(tourmaster_get_booking_data(array(), array(), 'COUNT(*)') / $num_fetch);
 			$query_args = array();
			if( !empty($_GET['order_status']) && $_GET['order_status'] != 'all' ){
				$query_args['order_status'] = $_GET['order_status'];
			}
			if( !empty($_GET['order_id']) ){
				$query_args['id'] = $_GET['order_id'];
			}
			if( !empty($_GET['from_date']) ){
				$custom_condition = ' >= \'' . esc_sql($_GET['from_date']) . '\''; 
				if( !empty($_GET['to_date']) ){
					$custom_condition .= ' AND travel_date <= \'' . esc_sql($_GET['to_date']) . '\' ';
				}
				$query_args['travel_date'] = array( 
					'custom' => $custom_condition
				);
			}

			$results = tourmaster_get_booking_data($query_args, array(
				'paged' => $paged,
				'num-fetch' => $num_fetch
			));


			echo '<table>';
			echo tourmaster_get_table_head(array(
				esc_html__('Order', 'tourmaster'),
				esc_html__('Contact Detail', 'tourmaster'),
				esc_html__('Customer\'s Note', 'tourmaster'),
				esc_html__('Travel Date', 'tourmaster'),
				esc_html__('Total', 'tourmaster'),
				esc_html__('Payment Status', 'tourmaster'),
				esc_html__('Action', 'tourmaster'),
			));
			$statuses = array(
				'all' => esc_html__('All', 'tourmaster'),
				'pending' => esc_html__('Pending', 'tourmaster'),
				'approved' => esc_html__('Approved', 'tourmaster'),
				'receipt-submitted' => esc_html__('Receipt Submitted', 'tourmaster'),
				'online-paid' => esc_html__('Online Paid', 'tourmaster'),
				'deposit-paid' => esc_html__('Deposit Paid', 'tourmaster'),
				'departed' => esc_html__('Departed', 'tourmaster'),
				'rejected' => esc_html__('Rejected', 'tourmaster'),
				'cancel' => esc_html__('Cancel', 'tourmaster'),
			);

			foreach( $results as $result ){

				$order_title  = '<div class="tourmaster-head" >#' . $result->id . '</div>';
				$order_title .= '<div class="tourmaster-content" ><a href="' . add_query_arg(array('single'=>$result->id), remove_query_arg(array('id','action'))) . '" >';
				$order_title .= get_the_title($result->tour_id);
				$order_title .= '</a></div>';

				$contact_detail = empty($result->contact_info)? array(): json_decode($result->contact_info, true);
				$buyer_info  = '<div class="tourmaster-head" >';
				$buyer_info .= empty($contact_detail['first_name'])? '': $contact_detail['first_name'] . ' ';
				$buyer_info .= empty($contact_detail['last_name'])? '': $contact_detail['last_name'] . ' ';
				$buyer_info .= '</div>';
				$buyer_info .= '<div class="tourmaster-content" >';
				$buyer_info .= empty($contact_detail['phone'])? '': $contact_detail['phone'] . ' ';
				$buyer_info .= empty($contact_detail['email'])? '': '<a href="mailto:' . esc_attr($contact_detail['email']) . '" ><i class="fa fa-envelope-o" ></i></a>';
				$buyer_info .= '</div>';

				$additional_note = '';
				if( !empty($contact_detail['additional_notes']) ){
					$additional_note  = wp_trim_words($contact_detail['additional_notes'], 15);
				}

				$travel_date = $result->travel_date;

				$tour_price = tourmaster_money_format($result->total_price);

				$order_status  = '<span class="tourmaster-order-status tourmaster-status-' . esc_attr($result->order_status) . '" >';
				if( $result->order_status == 'approved' ){
					$order_status .= '<i class="fa fa-check" ></i>';
				}else if( $result->order_status == 'departed' ){
					$order_status .= '<i class="fa fa-check-circle-o" ></i>';
				}else if( $result->order_status == 'rejected' || $result->order_status == 'cancel' ){
					$order_status .= '<i class="fa fa-remove" ></i>';
				}	
				$order_status .= $statuses[$result->order_status];
				if( $result->order_status == 'pending' && empty($result->user_id) ){
					$order_status .= ' <br>' . esc_html__('(Via E-mail)', 'tourmaster');
				}
				$order_status .= '</span>';

				$action  = '<a href="' . add_query_arg(array('single'=>$result->id), remove_query_arg(array('id','action'))) . '" class="tourmaster-order-action" title="' . esc_html__('View', 'tourmaster') . '" >';
				$action .= '<i class="fa fa-eye" ></i>';
				$action .= '</a>';
				$action .= '<a href="' . add_query_arg(array('id'=>$result->id, 'action'=>'approved')) . '" class="tourmaster-order-action" title="' . esc_html__('Approve', 'tourmaster') . '" ';
				$action .= 'data-confirm="' . esc_html__('After approving the transaction, invoice and payment receipt will be sent to customer\'s billing email.', 'tourmaster') . '" ';
				$action .= '>';
				$action .= '<i class="fa fa-check" ></i>';
				$action .= '</a>';
				$action .= '<a href="' . add_query_arg(array('id'=>$result->id, 'action'=>'rejected')) . '" class="tourmaster-order-action" title="' . esc_html__('Reject', 'tourmaster') . '" ';
				$action .= 'data-confirm="' . esc_html__('After rejected the transaction, the rejection message will be sent to customer\'s contact email.', 'tourmaster') . '" ';
				$action .= '>';
				$action .= '<i class="fa fa-remove" ></i>';
				$action .= '</a>';
				$action .= '<a href="' . add_query_arg(array('id'=>$result->id, 'action'=>'remove')) . '" class="tourmaster-order-action" title="' . esc_html__('Remove', 'tourmaster') . '" ';
				$action .= 'data-confirm="' . esc_html__('The transaction you selected will be permanently removed from the system.', 'tourmaster') . '" ';
				$action .= '>';
				$action .= '<i class="fa fa-trash-o" ></i>';
				$action .= '</a>';

				tourmaster_get_table_content(array($order_title, $buyer_info, $additional_note, $travel_date, $tour_price, $order_status, $action));
			}

			echo '</table>';

			if( !empty($max_num_page) && $max_num_page > 1 ){
				echo '<div class="tourmaster-transaction-pagination" >';
				for( $i = 1; $i <= $max_num_page; $i++ ){
					if( $i == $paged ){
						echo '<span class="tourmaster-transaction-pagination-item tourmaster-active" >' . $i . '</span>';
					}else{
						echo '<a href="' . add_query_arg(array('paged'=>$i), remove_query_arg(array('id','action'))) . '" class="tourmaster-transaction-pagination-item" >' . $i . '</a>';
					}
				}
				echo '</div>';
			}

		}
	}

	if( !function_exists('tourmaster_get_single_order') ){
		function tourmaster_get_single_order(){

			if( !empty($_GET['single']) && !empty($_GET['status']) ){
				$updated = tourmaster_update_booking_data(
					array('order_status' => $_GET['status']),
					array('id' => $_GET['single']),
					array('%s'),
					array('%d')
				);

				// send the mail
				if( !empty($updated) ){
					if( !empty($_GET['action']) && in_array($_GET['action'], array('approved', 'online-paid', 'deposit-paid')) ){
						tourmaster_mail_notification('payment-made-mail', $_GET['single']);
					}else if( $_GET['status'] == 'rejected' ){
						tourmaster_mail_notification('booking-reject-mail', $_GET['single']);
					} 
				}
			}

			$result = tourmaster_get_booking_data(array(
				'id' => $_GET['single']
			), array('single' => true));

			// from my-booking-single.php
			$contact_fields = tourmaster_get_payment_contact_form_fields();
			$contact_detail = empty($result->contact_info)? array(): json_decode($result->contact_info, true);
			$billing_detail = empty($result->billing_info)? array(): json_decode($result->billing_info, true);
			$booking_detail = empty($result->booking_detail)? array(): json_decode($result->booking_detail, true);

			// sidebar
			echo '<div class="tourmaster-my-booking-single-sidebar" >';
			$statuses = array(
				'all' => esc_html__('All', 'tourmaster'),
				'pending' => esc_html__('Pending', 'tourmaster'),
				'approved' => esc_html__('Approved', 'tourmaster'),
				'receipt-submitted' => esc_html__('Receipt Submitted', 'tourmaster'),
				'online-paid' => esc_html__('Online Paid', 'tourmaster'),
				'deposit-paid' => esc_html__('Deposit Paid', 'tourmaster'),
				'departed' => esc_html__('Departed', 'tourmaster'),
				'rejected' => esc_html__('Rejected', 'tourmaster'),
				'cancel' => esc_html__('Cancel', 'tourmaster'),
			);
			echo '<h3 class="tourmaster-my-booking-single-title">' . esc_html__('Order Status', 'tourmaster') . '</h3>';
			echo '<div class="tourmaster-booking-status tourmaster-status-' . esc_attr($result->order_status) . '" >';
			echo '<form action="' . add_query_arg(array('action' => 'update-status')) . '" method="GET" >';
			echo '<div class="tourmaster-custom-combobox" >';
			echo '<select name="status" >';
			foreach( $statuses as $status_slug => $status_title ){
				if( $status_slug == 'all' ) continue;
				echo '<option value="' . esc_attr($status_slug) . '" ' . ($status_slug == $result->order_status? 'selected': '') . '>';
				echo esc_html($status_title);
				if( $status_slug == 'pending' && empty($result->user_id) ){
					echo ' ' . esc_html__('(Via E-mail)', 'tourmaster');
				}
				echo '</option>';
			}
			echo '</select>';
			echo '</div>'; // tourmaster-combobox
			echo '<input class="tourmaster-button" id="tourmaster-update-booking-status" type="submit" value="' . esc_html__('Update Status', 'tourmaster') . '" />';
			if( !empty($_GET['page']) ){
				echo '<input name="page" type="hidden" value="' . esc_attr($_GET['page']) . '" />';
			}
			if( !empty($_GET['single']) ){
				echo '<input name="single" type="hidden" value="' . esc_attr($_GET['single']) . '" />';
			}
			echo '</form>';
			echo '</div>'; // tourmaster-booking-status
			
			echo '<h3 class="tourmaster-my-booking-single-sub-title">' . esc_html('Bank Payment Receipt') . '</h3>';
			if( !in_array($result->order_status, array('pending', 'rejected')) && !empty($result->payment_info) ){

				// print payment info
				$payment_info = json_decode($result->payment_info, true);
				
				if( !empty($payment_info['file_url']) ){
					echo '<div class="tourmaster-my-booking-single-payment-receipt" >';
					echo '<a href="' . esc_url($payment_info['file_url']) . '" >';
					echo '<img src="' . esc_url($payment_info['file_url']) . '" alt="receipt" />';
					echo '</a>';
					echo '</div>';			
				}

				if( !empty($payment_info['submission_date']) ){
					echo '<div class="tourmaster-my-booking-single-field clearfix" >';
					echo '<span class="tourmaster-head">' . esc_html__('Submission Date', 'tourmaster') . ' :</span> ';
					echo '<span class="tourmaster-tail">' . $payment_info['submission_date'] . '</span>';
					echo '</div>';			
				}else if( !empty($result->payment_date) && $result->payment_date != '0000-00-00 00:00:00' ){
					echo '<div class="tourmaster-my-booking-single-field clearfix" >';
					echo '<span class="tourmaster-head">' . esc_html__('Payment Date', 'tourmaster') . ' :</span> ';
					echo '<span class="tourmaster-tail">' . $result->payment_date . '</span>';
					echo '</div>';				
				} 
				
				if( !empty($payment_info['payment_method']) ){
					echo '<div class="tourmaster-my-booking-single-field clearfix" >';
					echo '<span class="tourmaster-head">' . esc_html__('Payment Method', 'tourmaster') . ' :</span> ';
					echo '<span class="tourmaster-tail">' . $payment_info['payment_method'] . '</span>';
					echo '</div>';			
				}
				
				$transaction_id = '';
				if( !empty($payment_info['transaction_id']) ){
					$transaction_id = $payment_info['transaction_id'];
				}else if( !empty($payment_info['transaction-id']) ){
					$transaction_id = $payment_info['transaction-id'];
				}
				if( !empty($transaction_id) ){
					echo '<div class="tourmaster-my-booking-single-field clearfix" >';
					echo '<span class="tourmaster-head">' . esc_html__('Transaction ID', 'tourmaster') . ' :</span> ';
					echo '<span class="tourmaster-tail">' . $transaction_id . '</span>';
					echo '</div>';			
				}
				
				if( $result->order_status == 'deposit-paid' || $result->order_status == 'receipt-submitted' ){
					$pricing_info = json_decode($result->pricing_info, true);
					
					if( !empty($pricing_info['deposit-price']) && !empty($pricing_info['deposit-paypal-amount']) && 
						tourmaster_compare_price($pricing_info['deposit-paypal-amount'], $payment_info['amount']) ){
						
						echo '<div class="tourmaster-my-booking-single-field clearfix" >';
						echo '<span class="tourmaster-head">' . sprintf(esc_html__('Deposit Amount', 'tourmaster'), $pricing_info['deposit-paypal-service-rate']) . ' :</span> ';
						echo '<span class="tourmaster-tail">' . tourmaster_money_format($pricing_info['deposit-price']) . '</span>';
						echo '</div>';

						echo '<div class="tourmaster-my-booking-single-field clearfix" >';
						echo '<span class="tourmaster-head">' . sprintf(esc_html__('Paypal Fee (%d%%)', 'tourmaster'), $pricing_info['deposit-paypal-service-rate']) . ' :</span> ';
						echo '<span class="tourmaster-tail">' . tourmaster_money_format($pricing_info['deposit-paypal-service-fee']) . '</span>';
						echo '</div>';
					}else if( !empty($payment_info['deposit-rate']) && !empty($payment_info['deposit-price']) ){
						echo '<div class="tourmaster-my-booking-single-field clearfix" >';
						echo '<span class="tourmaster-head">' . esc_html__('Deposit Rate', 'tourmaster') . ' :</span> ';
						echo '<span class="tourmaster-tail">' . $payment_info['deposit-rate'] . '%</span>';
						echo '</div>';			

						echo '<div class="tourmaster-my-booking-single-field clearfix" >';
						echo '<span class="tourmaster-head">' . esc_html__('Deposit Price', 'tourmaster') . ' :</span> ';
						echo '<span class="tourmaster-tail">' . tourmaster_money_format($payment_info['deposit-price']) . '</span>';
						echo '</div>';			
					}		
				}

				if( !empty($payment_info['amount']) ){
					echo '<div class="tourmaster-my-booking-single-field clearfix" >';
					echo '<span class="tourmaster-head">' . esc_html__('Paid Amount', 'tourmaster') . ' :</span> ';
					echo '<span class="tourmaster-tail">' . tourmaster_money_format($payment_info['amount']) . '</span>';
					echo '</div>';
				}

				if( !empty($payment_info['error']) ){
					echo '<div class="tourmaster-my-booking-single-field clearfix" >';
					echo '<span class="tourmaster-head">' . esc_html__('Error', 'tourmaster') . ' :</span> ';
					echo '<span class="tourmaster-tail">' . $payment_info['error'] . '</span>';
					echo '</div>';			
				}
			}
			echo '</div>'; // tourmaster-my-booking-single-sidebar

			// content
			echo '<div class="tourmaster-my-booking-single-content" >';
			echo '<div class="tourmaster-item-rvpdlr clearfix" >';
			echo '<div class="tourmaster-my-booking-single-order-summary-column tourmaster-column-20 tourmaster-item-pdlr" >';
			echo '<h3 class="tourmaster-my-booking-single-title">' . esc_html__('Order Summary', 'tourmaster') . '</h3>';

			if( $result->order_status == 'pending' && empty($result->user_id) ){
				echo '<div class="tourmaster-my-booking-pending-via-email" >';
				echo esc_html__('This booking has been made manually via email. Customer won\'t see from their dashboard. You should contact back to customer manually.', 'tourmaster');
				echo '</div>';
			}

			echo '<div class="tourmaster-my-booking-single-field clearfix" >';
			echo '<span class="tourmaster-head">' . esc_html__('Order Number', 'tourmaster') . ' :</span> ';
			echo '<span class="tourmaster-tail">#' . $result->id . '</span>';
			echo '</div>';

			echo '<div class="tourmaster-my-booking-single-field clearfix" >';
			echo '<span class="tourmaster-head">' . esc_html__('Booking Date', 'tourmaster') . ' :</span> ';
			echo '<span class="tourmaster-tail">' . tourmaster_date_format($result->booking_date) . '</span>';
			echo '</div>';

			echo '<div class="tourmaster-my-booking-single-field clearfix" >';
			echo '<span class="tourmaster-head">' . esc_html__('Tour', 'tourmaster') . ' :</span> ';
			echo '<span class="tourmaster-tail"><a href="' . get_permalink($result->tour_id) . '" target="_blank">' . get_the_title($result->tour_id) . '</a></span>';
			echo '</div>';

			echo '<div class="tourmaster-my-booking-single-field clearfix" >';
			echo '<span class="tourmaster-head">' . esc_html__('Travel Date', 'tourmaster') . ' :</span> ';
			echo '<span class="tourmaster-tail">' . tourmaster_date_format($result->travel_date) . '</span>';
			echo '</div>';

			if( !empty($booking_detail['package']) ){
				echo '<div class="tourmaster-my-booking-single-field clearfix" >';
				echo '<span class="tourmaster-head">' . esc_html__('Package', 'tourmaster') . ' :</span> ';
				echo '<span class="tourmaster-tail">' . $booking_detail['package'] . '</span>';
				echo '</div>';
			}

			if( !empty($contact_detail['additional_notes']) ){
				echo '<div class="tourmaster-my-booking-single-field tourmaster-additional-note clearfix" >';
				echo '<span class="tourmaster-head">' . esc_html__('Customer\'s Note', 'tourmaster') . ' :</span> ';
				echo '<span class="tourmaster-tail">' . $contact_detail['additional_notes'] . '</span>';
				echo '</div>';
			}
			echo '</div>'; // tourmaster-my-booking-single-order-summary-column

			echo '<div class="tourmaster-my-booking-single-contact-detail-column tourmaster-column-20 tourmaster-item-pdlr" >';
			echo '<h3 class="tourmaster-my-booking-single-title">' . esc_html__('Contact Detail', 'tourmaster') . '</h3>';
			foreach( $contact_fields as $field_slug => $contact_field ){
				if( !empty($contact_detail[$field_slug]) ){
					echo '<div class="tourmaster-my-booking-single-field clearfix" >';
					echo '<span class="tourmaster-head">' . $contact_field['title'] . ' :</span> ';
					echo '<span class="tourmaster-tail">' . $contact_detail[$field_slug] . '</span>';
					echo '</div>';
				}
			}
			echo '</div>'; // tourmaster-my-booking-single-contact-detail-column

			echo '<div class="tourmaster-my-booking-single-billing-detail-column tourmaster-column-20 tourmaster-item-pdlr" >';
			echo '<h3 class="tourmaster-my-booking-single-title">' . esc_html__('Billing Detail', 'tourmaster') . '</h3>';
			foreach( $contact_fields as $field_slug => $contact_field ){
				if( !empty($billing_detail[$field_slug]) ){
					echo '<div class="tourmaster-my-booking-single-field clearfix" >';
					echo '<span class="tourmaster-head">' . $contact_field['title'] . ' :</span> ';
					echo '<span class="tourmaster-tail">' . $billing_detail[$field_slug] . '</span>';
					echo '</div>';
				}
			}
			echo '</div>'; // tourmaster-my-booking-single-billing-detail-column
			echo '</div>'; // tourmaster-item-rvpdl

			// traveller info
			if( !empty($result->traveller_info) ){
				$title_types = tourmaster_payment_traveller_title();
				$traveller_info = json_decode($result->traveller_info, true);

				if( !empty($traveller_info) ){
					echo '<div class="tourmaster-my-booking-single-traveller-info" >';
					echo '<h3 class="tourmaster-my-booking-single-title">' . esc_html__('Traveller Info', 'tourmaster') . '</h3>';
					for( $i=0; $i<sizeof($traveller_info['first_name']); $i++ ){
						if( !empty($traveller_info['first_name'][$i]) || !empty($traveller_info['last_name'][$i]) ){
							echo '<div class="tourmaster-my-booking-single-field clearfix" >';
							echo '<span class="tourmaster-head">' . esc_html__('Traveller', 'tourmaster') . ' ' . ($i+1) . ' :</span> ';
							echo '<span class="tourmaster-tail">';
							if( !empty($traveller_info['title'][$i]) ){
								if( !empty($title_types[$traveller_info['title'][$i]]) ){
									echo $title_types[$traveller_info['title'][$i]] . ' ';
								}
							}
							echo $traveller_info['first_name'][$i] . ' ' . $traveller_info['last_name'][$i];
							if( !empty($traveller_info['passport'][$i]) ){
								echo '<br>' . esc_html__('Passport ID :', 'tourmaster') . ' ' . $traveller_info['passport'][$i];
							}
							echo '</span>';
							echo '</div>';
						}
					}
					echo '</div>'; // tourmaster-my-booking-single-traveller-info
				}
			}

			// price breakdown
			if( !empty($result->pricing_info) ){
				$pricing_info = json_decode($result->pricing_info, true);
				echo '<div class="tourmaster-my-booking-single-price-breakdown" >';
				echo '<h3 class="tourmaster-my-booking-single-title">' . esc_html__('Price Breakdown', 'tourmaster') . '</h3>';
				echo tourmaster_get_tour_price_breakdown($pricing_info['price-breakdown']);

				echo '<div class="tourmaster-my-booking-single-total-price clearfix" >';
				echo '<div class="tourmaster-my-booking-single-field clearfix" >';
				echo '<span class="tourmaster-head">' . esc_html__('Total', 'tourmaster') . '</span> ';
				echo '<span class="tourmaster-tail">' . tourmaster_money_format($result->total_price) . '</span>';
				echo '</div>';
				echo '</div>';
				echo '</div>'; // tourmaster-my-booking-single-traveller-info
			}

			echo '</div>'; // tourmaster-my-booking-single-content

		}
	}
