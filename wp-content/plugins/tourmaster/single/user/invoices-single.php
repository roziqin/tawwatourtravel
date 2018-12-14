<?php
	echo '<div class="tourmaster-user-content-inner tourmaster-user-content-inner-invoices-single" >';
	tourmaster_get_user_breadcrumb();

	// booking table block
	tourmaster_user_content_block_start();

	global $current_user;
	$result = tourmaster_get_booking_data(array(
		'id' => $_GET['id'],
		'user_id' => $current_user->data->ID,
		'order_status' => array(
			'condition' => '!=',
			'value' => 'cancel'
		)
	), array('single' => true));

	echo '<div class="tourmaster-invoice-wrap clearfix" id="tourmaster-invoice-wrap" >';

	$invoice_logo = tourmaster_get_option('general', 'invoice-logo');
	$billing_info = empty($result->billing_info)? array(): json_decode($result->contact_info, true);
	
	echo '<div class="tourmaster-invoice-head clearfix" >';
	echo '<div class="tourmaster-invoice-head-left" >';
	echo '<div class="tourmaster-invoice-logo" >';
	if( empty($invoice_logo) ){
		echo tourmaster_get_image(TOURMASTER_URL . '/images/invoice-logo.png');
	}else{
		echo tourmaster_get_image($invoice_logo);
	}
	echo '</div>'; // tourmaster-invoice-logo
	echo '<div class="tourmaster-invoice-id" >' . esc_html__('Invoice ID :', 'tourmaster') . ' #' . $result->id . '</div>';
	echo '<div class="tourmaster-invoice-date" >' . esc_html__('Invoice date :', 'tourmaster') . ' ' . tourmaster_date_format($result->booking_date) . '</div>';
	echo '<div class="tourmaster-invoice-receiver" >';
	echo '<div class="tourmaster-invoice-receiver-head" >' . esc_html('Invoice To', 'tourmaster') . '</div>';
	echo '<div class="tourmaster-invoice-receiver-info" >';
	echo '<span class="tourmaster-invoice-receiver-name" >' . $billing_info['first_name'] . ' ' . $billing_info['last_name'] . '</span>';
	echo '<span class="tourmaster-invoice-receiver-address" >' . (empty($billing_info['contact_address'])? '': $billing_info['contact_address']) . '</span>';
	echo '</div>';
	echo '</div>';
	echo '</div>'; // tourmaster-invoice-head-left
	
	$company_name = tourmaster_get_option('general', 'invoice-company-name', '');
	$company_info = tourmaster_get_option('general', 'invoice-company-info', '');
	echo '<div class="tourmaster-invoice-head-right" >';
	echo '<div class="tourmaster-invoice-company-info" >';
	echo '<div class="tourmaster-invoice-company-name" >' . $company_name . '</div>';
	echo '<div class="tourmaster-invoice-company-info" >' . tourmaster_content_filter($company_info) . '</div>';
	echo '</div>';
	echo '</div>'; // tourmaster-invoice-head-right
	echo '</div>'; // tourmaster-invoice-head

	// price breakdown
	if( !empty($result->pricing_info) ){
		$pricing_info = json_decode($result->pricing_info, true);
		echo '<div class="tourmaster-invoice-price-breakdown" >';
		echo '<div class="tourmaster-invoice-price-head" >';
		echo '<span class="tourmaster-head" >' . esc_html__('Description', 'tourmaster') . '</span>';
		echo '<span class="tourmaster-tail" >' . esc_html__('Total', 'tourmaster') . '</span>';
		echo '</div>'; // tourmaster-invoice-price-head

		echo tourmaster_get_tour_invoice_price($result->tour_id, $pricing_info['price-breakdown']);

		echo '<div class="tourmaster-invoice-total-price clearfix" >';
		echo '<span class="tourmaster-head">' . esc_html__('Total', 'tourmaster') . '</span> ';
		echo '<span class="tourmaster-tail">' . tourmaster_money_format($result->total_price) . '</span>';
		echo '</div>'; // tourmaster-invoice-total-price
		echo '</div>'; // tourmaster-invoice-price-breakdown
	}

	if( !empty($result->order_status) && in_array($result->order_status, array('approve', 'online-paid', 'departed')) ){
		$payment_date = tourmaster_date_format($result->payment_date);
		$payment_info = json_decode($result->payment_info, true);

		echo '<div class="tourmaster-invoice-payment-info clearfix" >';
		echo '<div class="tourmaster-invoice-payment-info-item" >';
		echo '<div class="tourmaster-head" >' . esc_html__('Payment Method') . '</div>';
		echo '<div class="tourmaster-tail" >';
		if( !empty($payment_info['payment_method']) && $payment_info['payment_method'] == 'receipt' ){
			echo esc_html__('Bank Transfer', 'tourmaster');
		}else if( !empty($payment_info['payment_method']) ){
			echo esc_html__('Online Payment', 'tourmaster');
		}
		echo '</div>';
		echo '</div>'; // tourmaster-invoice-payment-info-item

		echo '<div class="tourmaster-invoice-payment-info-item" >';
		echo '<div class="tourmaster-head" >' . esc_html__('Date') . '</div>';
		echo '<div class="tourmaster-tail" >' . $payment_date . '</div>';
		echo '</div>'; // tourmaster-invoice-payment-info-item
		
		$transaction_id = '';
		if( !empty($payment_info['transaction_id']) ){
			$transaction_id = $payment_info['transaction_id'];
		}else if( !empty($payment_info['transaction-id']) ){
			$transaction_id = $payment_info['transaction-id'];
		}
		if( !empty($transaction_id) ){
			echo '<div class="tourmaster-invoice-payment-info-item" >';
			echo '<div class="tourmaster-head" >' . esc_html__('Transaction ID') . '</div>';
			echo '<div class="tourmaster-tail" >' . $transaction_id . '</div>';
			echo '</div>'; // tourmaster-invoice-payment-info-item
		}
		echo '</div>';
	}

	echo '</div>'; // tourmaster-invoice-wrap

	echo '<div class="tourmaster-invoice-button" >';
	if( empty($result->order_status) || !in_array($result->order_status, array('approve', 'online-paid', 'departed', 'deposit-paid')) ){
		echo '<a href="' . esc_url(add_query_arg(array('page_type'=>'my-booking'))) . '" class="tourmaster-button" >' . esc_html__('Make a Payment', 'tourmaster') . '</a>';
	}
	echo '<a href="#" class="tourmaster-button tourmaster-print" data-id="tourmaster-invoice-wrap" ><i class="fa fa-print" ></i>' . esc_html__('Print', 'tourmaster') . '</a>';
	// echo '<a href="#" class="tourmaster-button tourmaster-pdf-download" data-id="tourmaster-invoice-wrap" ><i class="fa fa-file-pdf-o" ></i>' . esc_html__('Download Pdf', 'tourmaster') . '</a>';
	echo '</div>'; // tourmaster-invoice-button

	tourmaster_user_content_block_end();
	echo '</div>'; // tourmaster-user-content-inner