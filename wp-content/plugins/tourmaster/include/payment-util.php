<?php
	/*	
	*	Tourmaster Plugin
	*	---------------------------------------------------------------------
	*	for payment page
	*	---------------------------------------------------------------------
	*/

	if( !function_exists('tourmaster_get_payment_page') ){
		function tourmaster_get_payment_page($booking_detail, $is_single = false){

			// initiate the variable
			if( !empty($booking_detail['tour-id']) && !empty($booking_detail['tour-date']) ){
				$tour_option = tourmaster_get_post_meta($booking_detail['tour-id'], 'tourmaster-tour-option');
				$date_price = tourmaster_get_tour_date_price($tour_option, $booking_detail['tour-id'], $booking_detail['tour-date']);
				$date_price = tourmaster_get_tour_date_price_package($date_price, $booking_detail);
			}

			// if booking data is invalid
			if( empty($date_price) ){
				$ret  = '<div class="tourmaster-tour-booking-error" >';
				$ret .= esc_html__('An error occurred while processing your request.','tourmaster');
				if( !empty($booking_detail['tour-id']) ){
					$ret .= '<br><br><a href="' . get_permalink($booking_detail['tour-id']) . '" >' . esc_html__('Back to Tour Page', 'tourmaster') . '</a>';
				}else{
					$ret .= '<br><br><a href="' . home_url('/') . '" >' . esc_html__('Back to Home Page', 'tourmaster') . '</a>';
				}
				$ret .= '</div>';

				return array( 'content' => $ret, 'sidebar' => '' );
			}

			// booking step 2
			if( empty($booking_detail['step']) || $booking_detail['step'] == '2' ){
				return array(
					'content' => tourmaster_payment_traveller_form( $tour_option, $date_price, $booking_detail ) . 
								 tourmaster_payment_contact_form( $booking_detail ),
					'sidebar' => tourmaster_get_booking_bar_summary( $tour_option, $date_price, $booking_detail, true)
				);

			// booking step 3
			}else if( $booking_detail['step'] == '3' ){
				return array(
					'content' => tourmaster_payment_service_form( $tour_option, $booking_detail ) . 
								 tourmaster_payment_contact_detail( $booking_detail ) . 
								 tourmaster_payment_traveller_detail( $tour_option, $booking_detail ) . 
								 tourmaster_payment_method(),
					'sidebar' => tourmaster_get_booking_bar_summary( $tour_option, $date_price, $booking_detail )
				);

			// booking step 4
			}else if( $booking_detail['step'] == '4' ){
				
				if( $is_single ){
					return array(
						'content' => tourmaster_payment_complete_delay(),
						'sidebar' => tourmaster_get_booking_bar_summary( $tour_option, $date_price, $booking_detail ),
						'cookie' => '' 
					);
				}else if( $booking_detail['payment-method'] == 'booking' ){
					$tour_price = tourmaster_get_tour_price($tour_option, $date_price, $booking_detail);
					if( $date_price['pricing-method'] == 'group' ){
						$traveller_amount = 1;
					}else{
						$traveller_amount = tourmaster_get_tour_people_amount($tour_option, $date_price, $booking_detail);
					}
					$package_group_slug = empty($date_price['group-slug'])? '': $date_price['group-slug'];
					
					if( $tid = tourmaster_insert_booking_data($booking_detail, $tour_price, $traveller_amount, $package_group_slug) ){

						if( is_user_logged_in() ){
							tourmaster_mail_notification('booking-made-mail', $tid);
							tourmaster_mail_notification('admin-booking-made-mail', $tid);
						}else{
							tourmaster_mail_notification('guest-booking-made-mail', $tid);
							tourmaster_mail_notification('admin-guest-booking-made-mail', $tid);
						}

						return array(
							'content' => tourmaster_payment_complete(),
							'sidebar' => tourmaster_get_booking_bar_summary($tour_option, $date_price, $booking_detail),
							'cookie' => '' 
						);
					}else{
						// cannot insert to database
					}

				}

			}

			return array();

		} // tourmaster_get_payment_page
	}

	// get booking bar summary
	if( !function_exists('tourmaster_get_booking_bar_summary') ){
		function tourmaster_get_booking_bar_summary( $tour_option, $date_price, $booking_detail, $editable = false ){

			$ret  = '<div class="tourmaster-tour-booking-bar-summary" >';
			$ret .= '<h3 class="tourmaster-tour-booking-bar-summary-title" >' . get_the_title($booking_detail['tour-id']) . '</h3>';
			
			$ret .= '<div class="tourmaster-tour-booking-bar-summary-info tourmaster-summary-travel-date" >';
			$ret .= '<span class="tourmaster-head" >' . esc_html__('Travel Date', 'tourmaster') . ' : </span>';
			$ret .= '<span class="tourmaster-tail" >';
			$ret .= tourmaster_date_format($booking_detail['tour-date']);
			if( $editable ){
				$ret .= ' ( <span class="tourmaster-tour-booking-bar-date-edit" >' . esc_html__('edit', 'tourmaster') . '</span> )';
				$ret .= '<form class="tourmaster-tour-booking-temp" action="' . get_permalink($booking_detail['tour-id']) . '" method="post" ></form>';
			}
			$ret .= '</span>';
			$ret .= '</div>';		

			if( !empty($booking_detail['package']) ){
				$ret .= '<div class="tourmaster-tour-booking-bar-summary-info tourmaster-summary-package" >';
				$ret .= '<span class="tourmaster-head" >' . esc_html__('Package', 'tourmaster') . ' : </span>';
				$ret .= '<span class="tourmaster-tail" >' . $booking_detail['package'] . '</span>';
				$ret .= '</div>';				
			}

			if( $tour_option['tour-type'] == 'multiple' && !empty($tour_option['multiple-duration']) ){
				$tour_duration = intval($tour_option['multiple-duration']);
				$end_date = strtotime('+ ' . ($tour_duration - 1)  . ' day', strtotime($booking_detail['tour-date']));

				$ret .= '<div class="tourmaster-tour-booking-bar-summary-info tourmaster-summary-end-date" >';
				$ret .= '<span class="tourmaster-head" >' . esc_html__('End Date', 'tourmaster') . ' : </span>';
				$ret .= '<span class="tourmaster-tail" >' . tourmaster_date_format($end_date) . '</span>';
				$ret .= '</div>';

				$ret .= '<div class="tourmaster-tour-booking-bar-summary-info tourmaster-summary-period" >';
				$ret .= '<span class="tourmaster-head" >' . esc_html__('Period', 'tourmaster') . ' : </span>';
				$ret .= '<span class="tourmaster-tail" >' . $tour_duration . ' ';
				$ret .= ($tour_option['multiple-duration'] > 1)? esc_html__('Days', 'tourmaster'): esc_html__('Day', 'tourmaster');
				$ret .= '</span>';
				$ret .= '</div>';
			}

			// group price
			if( $date_price['pricing-method'] == 'group' ){

			// no room based
			}else if( $tour_option['tour-type'] == 'single' || $date_price['pricing-room-base'] == 'disable' ){

				$ret .= '<div class="tourmaster-tour-booking-bar-summary-people-wrap" >';

				// fixed price
				if( $date_price['pricing-method'] == 'fixed' ){
					$ret .= '<div class="tourmaster-tour-booking-bar-summary-people-amount" >';
					$ret .= '<span class="tourmaster-head" >' . esc_html__('Traveller', 'tourmaster') . ' : </span>';
					$ret .= '<span class="tourmaster-tail" >' . $booking_detail['tour-people'] . '</span>';
					$ret .= '</div>';

				// variable price
				}else{
					$ret .= '<div class="tourmaster-tour-booking-bar-summary-people tourmaster-variable clearfix" >';
					if( !empty($date_price['adult-price']) ){
						$ret .= '<div class="tourmaster-tour-booking-bar-summary-people-amount tourmaster-adult" >';
						$ret .= '<span class="tourmaster-head" >' . esc_html__('Adult', 'tourmaster') . ' : </span>';
						$ret .= '<span class="tourmaster-tail" >' . (empty($booking_detail['tour-adult'])? '0': $booking_detail['tour-adult']) . '</span>';
						$ret .= '</div>'; // tourmaster-tour-booking-bar-summary-people-amount
					}
					if( !empty($date_price['children-price']) ){
						$ret .= '<div class="tourmaster-tour-booking-bar-summary-people-amount tourmaster-children" >';
						$ret .= '<span class="tourmaster-head" >' . esc_html__('Children', 'tourmaster') . ' : </span>';
						$ret .= '<span class="tourmaster-tail" >' . (empty($booking_detail['tour-children'])? '0': $booking_detail['tour-children']) . '</span>';
						$ret .= '</div>'; // tourmaster-tour-booking-bar-summary-people-amount
					}
					if( !empty($date_price['student-price']) ){
						$ret .= '<div class="tourmaster-tour-booking-bar-summary-people-amount tourmaster-student" >';
						$ret .= '<span class="tourmaster-head" >' . esc_html__('Student', 'tourmaster') . ' : </span>';
						$ret .= '<span class="tourmaster-tail" >' . (empty($booking_detail['tour-student'])? '0': $booking_detail['tour-student']) . '</span>';
						$ret .= '</div>'; // tourmaster-tour-booking-bar-summary-people-amount
					}
					if( !empty($date_price['infant-price']) ){
						$ret .= '<div class="tourmaster-tour-booking-bar-summary-people-amount tourmaster-infant" >';
						$ret .= '<span class="tourmaster-head" >' . esc_html__('Infant', 'tourmaster') . ' : </span>';
						$ret .= '<span class="tourmaster-tail" >' . (empty($booking_detail['tour-infant'])? '0': $booking_detail['tour-infant']) . '</span>';
						$ret .= '</div>'; // tourmaster-tour-booking-bar-summary-people-amount
					}
					$ret .= '</div>'; // tourmaster-tour-booking-bar-summary-people
				}
				$ret .= '</div>'; // tourmaster-tour-booking-bar-summary-people-wrap

			// room based	
			}else{	

				$ret .= '<div class="tourmaster-tour-booking-bar-summary-room-wrap clearfix" >';

				for( $i = 0; $i < $booking_detail['tour-room']; $i++ ){
					$ret .= '<div class="tourmaster-tour-booking-bar-summary-room" >';
					$ret .= '<div class="tourmaster-tour-booking-bar-summary-room-text" >' . esc_html__('Room', 'tourmaster') . ' ' . ($i + 1) . '</div>';
					// fixed price
					if( $date_price['pricing-method'] == 'fixed' ){
						$ret .= '<div class="tourmaster-tour-booking-bar-summary-people-amount" >';
						$ret .= '<span class="tourmaster-head" >' . esc_html__('Traveller', 'tourmaster') . ' : </span>';
						$ret .= '<span class="tourmaster-tail" >' . $booking_detail['tour-people'][$i] . '</span>';
						$ret .= '</div>';

					// variable price
					}else{
						$ret .= '<div class="tourmaster-tour-booking-bar-summary-people tourmaster-variable clearfix" >';
						if( !empty($date_price['adult-price']) ){
							$ret .= '<div class="tourmaster-tour-booking-bar-summary-people-amount tourmaster-adult" >';
							$ret .= '<span class="tourmaster-head" >' . esc_html__('Adult', 'tourmaster') . ' : </span>';
							$ret .= '<span class="tourmaster-tail" >' . (empty($booking_detail['tour-adult'][$i])? '0': $booking_detail['tour-adult'][$i]) . '</span>';
							$ret .= '</div>'; // tourmaster-tour-booking-bar-summary-people-amount
						}
						if( !empty($date_price['children-price']) ){
							$ret .= '<div class="tourmaster-tour-booking-bar-summary-people-amount tourmaster-children" >';
							$ret .= '<span class="tourmaster-head" >' . esc_html__('Children', 'tourmaster') . ' : </span>';
							$ret .= '<span class="tourmaster-tail" >' . (empty($booking_detail['tour-children'][$i])? '0': $booking_detail['tour-children'][$i]) . '</span>';
							$ret .= '</div>'; // tourmaster-tour-booking-bar-summary-people-amount
						}
						if( !empty($date_price['student-price']) ){
							$ret .= '<div class="tourmaster-tour-booking-bar-summary-people-amount tourmaster-student" >';
							$ret .= '<span class="tourmaster-head" >' . esc_html__('Student', 'tourmaster') . ' : </span>';
							$ret .= '<span class="tourmaster-tail" >' . (empty($booking_detail['tour-student'][$i])? '0': $booking_detail['tour-student'][$i]) . '</span>';
							$ret .= '</div>'; // tourmaster-tour-booking-bar-summary-people-amount
						}
						if( !empty($date_price['infant-price']) ){
							$ret .= '<div class="tourmaster-tour-booking-bar-summary-people-amount tourmaster-infant" >';
							$ret .= '<span class="tourmaster-head" >' . esc_html__('Infant', 'tourmaster') . ' : </span>';
							$ret .= '<span class="tourmaster-tail" >' . (empty($booking_detail['tour-infant'][$i])? '0': $booking_detail['tour-infant'][$i]) . '</span>';
							$ret .= '</div>'; // tourmaster-tour-booking-bar-summary-people-amount
						}
						$ret .= '</div>'; // tourmaster-tour-booking-bar-summary-people
					}
					$ret .= '</div>'; // tourmaster-tour-booking-bar-summary-room
				}
				$ret .= '</div>'; // tourmaster-tour-booking-bar-summary-room-wrap
			}		

			if( $editable ){
				$ret .= '<div class="tourmaster-tour-booking-bar-coupon-wrap" >';
				$ret .= '<input type="text" class="tourmaster-tour-booking-bar-coupon" name="coupon-code" placeholder="' . esc_html__('Coupon Code', 'tourmaster') . '" ';
				$ret .= ' value="' . (empty($booking_detail['coupon-code'])? '': esc_attr($booking_detail['coupon-code'])) . '" ';
				$ret .= ' />';
				$ret .= '<a class="tourmaster-tour-booking-bar-coupon-validate" ';
				$ret .= ' data-ajax-url="' . esc_url(TOURMASTER_AJAX_URL) . '" ';
				$ret .= ' data-tour-id="' . esc_attr($booking_detail['tour-id']) . '" ';
				$ret .= ' >' . esc_html__('Apply', 'tourmaster') . '</a>';
				$ret .= '<div class="tourmaster-tour-booking-coupon-message" ></div>';
				$ret .= '</div>';
			}

			$tour_price = tourmaster_get_tour_price($tour_option, $date_price, $booking_detail);
			$ret .= '<div class="tourmaster-tour-booking-bar-price-breakdown-wrap" >';
			$ret .= '<span class="tourmaster-tour-booking-bar-price-breakdown-link" id="tourmaster-tour-booking-bar-price-breakdown-link" >' . esc_html__('View Price Breakdown', 'tourmaster') . '</span>';
			$ret .= tourmaster_get_tour_price_breakdown($tour_price['price-breakdown']);
			$ret .= '</div>'; // tourmaster-tour-booking-bar-price-breakdown-wrap
		
			$ret .= '</div>'; // tourmaster-tour-booking-bar-summary

			// deposit payment
			$enable_deposit_payment = tourmaster_get_option('payment', 'enable-deposit-payment', 'disable');
			if( $enable_deposit_payment == 'enable' ){
				$current_date = strtotime(current_time('Y-m-d'));
				$deposit_before_days = intval(tourmaster_get_option('payment', 'display-deposit-payment-day', '0'));
				$travel_date = strtotime($booking_detail['tour-date']);
				if( $current_date + ($deposit_before_days * 86400) > $travel_date ){
					$payment_type = 'full';
				}else{
					$payment_type = empty($booking_detail['payment-type'])? 'full': $booking_detail['payment-type'];
					$deposit_amount = tourmaster_get_option('payment', 'deposit-payment-amount', '0');
				}
			}else{
				$payment_type = 'full';
			}

			$ret .= '<div class="tourmaster-tour-booking-bar-total-price-wrap ' . ($payment_type == 'partial'? 'tourmaster-deposit': '') . '" >';

			if( $enable_deposit_payment == 'enable' && !empty($deposit_amount) && $editable ){
				$ret .= '<div class="tourmaster-tour-booking-bar-deposit-option" >';
				$ret .= '<label class="tourmaster-deposit-payment-full" >';
				$ret .= '<input type="radio" name="payment-type" value="full" ' . ($payment_type == 'full'? 'checked': '') . ' />';
				$ret .= '<span class="tourmaster-content" >';
				$ret .= '<i class="icon_check_alt2" ></i>';
				$ret .= esc_html__('Pay Full Amount', 'tourmaster');
				$ret .= '</span>';
				$ret .= '</label>'; 

				$ret .= '<label class="tourmaster-deposit-payment-partial" >';
				$ret .= '<input type="radio" name="payment-type" value="partial" ' . ($payment_type == 'partial'? 'checked': '') . ' />';
				$ret .= '<span class="tourmaster-content" >';
				$ret .= '<i class="icon_check_alt2" ></i>';
				$ret .= sprintf(esc_html__('Pay %d%% Deposit', 'tourmaster'), $deposit_amount);
				$ret .= '</span>';
				$ret .= '</label>';
				$ret .= '</div>';
			}else{
				$ret .= '<input type="hidden" name="payment-type" value="' . esc_attr($payment_type) . '" />';
			}

			$ret .= '<i class="icon_tag_alt" ></i>';
			$ret .= '<span class="tourmaster-tour-booking-bar-total-price-title" >' . esc_html__('Total Price', 'tourmaster') . '</span>';
			$ret .= '<span class="tourmaster-tour-booking-bar-total-price" >' . tourmaster_money_format($tour_price['total-price']) . '</span>';
			$ret .= '</div>';

			// deposit display
			if( $enable_deposit_payment == 'enable' && !empty($deposit_amount) ){

				// for price with paypal service fee
				if( !empty($tour_price['deposit-price']) ){
					$deposit_price = $tour_price['deposit-price'];
				}else{
					$deposit_price = ($tour_price['total-price'] * floatval($deposit_amount)) / 100;
				}
				$ret .= '<div class="tourmaster-tour-booking-bar-deposit-text ' . ($payment_type == 'partial'? 'tourmaster-active': '') . '" >';
				$ret .= '<span class="tourmaster-tour-booking-bar-deposit-title" >' . sprintf(esc_html__('%d%% deposit'), $deposit_amount) . '</span>';
				$ret .= '<span class="tourmaster-tour-booking-bar-deposit-price" >' . tourmaster_money_format($deposit_price) . '</span>';
				$ret .= '<span class="tourmaster-tour-booking-bar-deposit-caption" >' . esc_html__('*Pay the rest later', 'tourmaster') . '</span>';
				$ret .= '</div>';
			}

			if( $editable ){
				$ret .= '<a class="tourmaster-tour-booking-continue tourmaster-button tourmaster-payment-step" data-step="3" >' . esc_html__('Next Step', 'tourmaster') . '</a>';
			}

			return $ret;
		}
	}

	// service form
	if( !function_exists('tourmaster_payment_service_form') ){
		function tourmaster_payment_service_form( $tour_option, $booking_detail ){

			$ret = '';

			if( !empty($tour_option['tour-service']) ){
				if( !empty($booking_detail['service']) && !empty($booking_detail['service-amount']) ){
					$services = tourmaster_process_service_data($booking_detail['service'], $booking_detail['service-amount']);
				}

				$ret .= '<div class="tourmaster-payment-service-form-wrap" >';
				$ret .= '<h3 class="tourmaster-payment-service-form-title" >' . esc_html__('Please select your preferred additional services.', 'tourmaster') . '</h3>';
				
				$ret .= '<div class="tourmaster-payment-service-form-item-wrap" >';
				foreach($tour_option['tour-service'] as $service_id){
					$service_option = get_post_meta($service_id, 'tourmaster-service-option', true);
					if( empty($service_option) ) continue;

					$ret .= '<div class="tourmaster-payment-service-form-item" >';
					$ret .= '<input type="checkbox" name="service[]" value="' . esc_attr($service_id) . '" ';
					$ret .= empty($services[$service_id])? '': 'checked';
					$ret .= ' />';
					$ret .= '<span class="tourmaster-payment-service-form-item-title" >' . get_the_title($service_id) . '</span>';
				
					$ret .= '<span class="tourmaster-payment-service-form-price-wrap" >';
					$ret .= '<span class="tourmaster-head" >' . tourmaster_money_format($service_option['price'], -2) . '</span>';
					$ret .= '<span class="tourmaster-tail tourmaster-type-' . esc_attr($service_option['per']) . '" >';
					if( $service_option['per'] == 'person' ){
						$ret .= '<span class="tourmaster-sep" >/</span>' . esc_html__('Person', 'tourmaster');
						$ret .= '<input type="hidden" name="service-amount[]" value="1" />';
					}else if( $service_option['per'] == 'group' ){
						$ret .= '<span class="tourmaster-sep" >/</span>' . esc_html__('Group', 'tourmaster');
						$ret .= '<input type="hidden" name="service-amount[]" value="1" />';
					}else if( $service_option['per'] == 'room' ){
						$ret .= '<span class="tourmaster-sep" >/</span>' . esc_html__('Room', 'tourmaster');
						$ret .= '<input type="hidden" name="service-amount[]" value="1" />';
					}else if( $service_option['per'] == 'unit' ){
						$ret .= '<span class="tourmaster-sep" >x</span>' . '<input type="text" name="service-amount[]" '; 
						$ret .= ' value="' . (empty($services[$service_id])? '1': esc_attr($services[$service_id])) . '" ';
						$ret .= ' />';
					}
					$ret .= '</span>';
					$ret .= '</span>';
					$ret .= '</div>';
				}
				$ret .= '</div>';
				
				$ret .= '</div>';
			}

			return $ret;
		}	
	}
	if( !function_exists('tourmaster_process_service_data') ){
		function tourmaster_process_service_data( $services, $services_amount ){
			$ret = array();

			if( !empty($services) ){
				foreach( $services as $service_key => $service ){
					if( !empty($service) && !empty($services_amount[$service_key]) ){
						$ret[$service] = $services_amount[$service_key];
					}
				}
			}

			return $ret;
		}
	}

	// traveller form
	if( !function_exists('tourmaster_payment_traveller_title') ){
		function tourmaster_payment_traveller_title(){
			return apply_filters('tourmaster_traveller_title_types', array(
				'mr' => esc_html__('Mr', 'tourmaster'),
				'mrs' => esc_html__('Mrs', 'tourmaster'),
				'ms' => esc_html__('Ms', 'tourmaster'),
				'miss' => esc_html__('Miss', 'tourmaster'),
				'master' => esc_html__('Master', 'tourmaster'),
			));
		}
	}
	if( !function_exists('tourmaster_payment_traveller_input') ){
		function tourmaster_payment_traveller_input($tour_option, $booking_detail, $i, $required = true){

			$extra_class = '';
			
			$title = empty($booking_detail['traveller_title'][$i])? '': $booking_detail['traveller_title'][$i];
			$title_html = '';
			if( $tour_option['require-traveller-info-title'] == 'enable' ){
				$extra_class .= ' tourmaster-with-info-title';

				$title_html .= '<div class="tourmaster-combobox-wrap tourmaster-traveller-info-title" >';
				$title_html .= '<select name="traveller_title[]" >';
				$title_types = tourmaster_payment_traveller_title();
				foreach( $title_types as $title_slug => $title_type ){
					$title_html .= '<option value="' . esc_attr($title_slug) . '" ' . ($title_slug == $title? 'selected': '') . ' >' . $title_type . '</option>';
				}
				$title_html .= '</select>';
				$title_html .= '</div>';
			}
			$first_name = empty($booking_detail['traveller_first_name'][$i])? '': $booking_detail['traveller_first_name'][$i];
			$last_name = empty($booking_detail['traveller_last_name'][$i])? '': $booking_detail['traveller_last_name'][$i];
			$passport = empty($booking_detail['traveller_passport'][$i])? '': $booking_detail['traveller_passport'][$i];
			$data_required = $required? 'data-required': '';

			$ret  = '<div class="tourmaster-traveller-info-field clearfix ' . esc_attr($extra_class) . '">';
			$ret .= '<span class="tourmaster-head">' . esc_html__('Traveller', 'tourmaster') . ' ' . ($i + 1) . '</span>';
			$ret .= '<span class="tourmaster-tail clearfix">';
			$ret .= $title_html;
			$ret .= '<input type="text" class="tourmaster-traveller-info-input" name="traveller_first_name[]" value="' . esc_attr($first_name) . '" placeholder="' . esc_html__('First Name', 'tourmaster') . ($required? ' *': '') . '" ' . $data_required . ' />';
			$ret .= '<input type="text" class="tourmaster-traveller-info-input" name="traveller_last_name[]" value="' . esc_attr($last_name) . '" placeholder="' . esc_html__('Last Name', 'tourmaster') . ($required? ' *': '') . '" ' . $data_required . ' />';
			if( !empty($tour_option['require-traveller-passport']) && $tour_option['require-traveller-passport'] == 'enable' ){
				$ret .= '<input type="text" class="tourmaster-traveller-info-passport" name="traveller_passport[]" value="' . esc_attr($passport) . '" placeholder="' . esc_html__('Passport Number', 'tourmaster') . ($required? ' *': '') . '" ' . $data_required . ' />';
			}
			$ret .= '</span>';
			$ret .= '</div>';

			return $ret;
		}
	}
	if( !function_exists('tourmaster_payment_traveller_form') ){
		function tourmaster_payment_traveller_form( $tour_option, $date_price, $booking_detail ){
			
			$ret  = '';

			// traveller detail
			if( !empty($tour_option['require-each-traveller-info']) && $tour_option['require-each-traveller-info'] == 'enable' ){
				$tour_option['require-traveller-info-title'] = empty($tour_option['require-traveller-info-title'])? 'enable': $tour_option['require-traveller-info-title'];

				$ret .= '<div class="tourmaster-payment-traveller-info-wrap tourmaster-form-field tourmaster-with-border" >';
				// group 
				if( $date_price['pricing-method'] == 'group' ){
					$traveller_amount = $date_price['max-group-people'];
					
					if( $traveller_amount > 0 ){
						$ret .= '<h3 class="tourmaster-payment-traveller-info-title" ><i class="fa fa-suitcase" ></i>';
						$ret .= esc_html__('Traveller Details', 'tourmaster');
						$ret .= '</h3>';

						$required = true;
						for( $i = 0; $i < $traveller_amount; $i++ ){
							$ret .= tourmaster_payment_traveller_input($tour_option, $booking_detail, $i, $required);
							$required = false;
						}
					}

				// normal
				}else{

					$ret .= '<h3 class="tourmaster-payment-traveller-info-title" ><i class="fa fa-suitcase" ></i>';
					$ret .= esc_html__('Traveller Details', 'tourmaster');
					$ret .= '</h3>';

					$traveller_amount = tourmaster_get_tour_people_amount($tour_option, $date_price, $booking_detail);
					for( $i = 0; $i < $traveller_amount; $i++ ){
						$ret .= tourmaster_payment_traveller_input($tour_option, $booking_detail, $i);
					}
				}
				$ret .= '</div>';
			}

			return $ret;
		} // tourmaster_payment_traveller_form
	}
	if( !function_exists('tourmaster_payment_traveller_detail') ){
		function tourmaster_payment_traveller_detail( $tour_option, $booking_detail ){
			$tour_option['require-traveller-info-title'] = empty($tour_option['require-traveller-info-title'])? 'enable': $tour_option['require-traveller-info-title'];
			if( $tour_option['require-traveller-info-title'] == 'enable' ){
				$title_types = tourmaster_payment_traveller_title();
			}

			$ret = '';

			if( !empty($tour_option['require-each-traveller-info']) && $tour_option['require-each-traveller-info'] == 'enable' && !empty($booking_detail['traveller_first_name']) ){
				$ret  = '<div class="tourmaster-payment-traveller-detail" >';
				$ret .= '<h3 class="tourmaster-payment-detail-title" ><i class="fa fa-file-text-o" ></i>';
				$ret .= esc_html__('Traveller Details', 'tourmaster');
				$ret .= '</h3>';
				for( $i = 0; $i < sizeof($booking_detail['traveller_first_name']); $i++ ){
					if( !empty($booking_detail['traveller_first_name'][$i]) || !empty($booking_detail['traveller_last_name'][$i]) ){
						$ret .= '<div class="tourmaster-payment-detail clearfix" >';
						$ret .= '<span class="tourmaster-head" >' . esc_html__('Traveller', 'tourmaster') . ' ' . ($i + 1) . ' :</span>';
						$ret .= '<span class="tourmaster-tail" >';
						if( $tour_option['require-traveller-info-title'] == 'enable' ){
							if( !empty($title_types[$booking_detail['traveller_title'][$i]]) ){
								$ret .= $title_types[$booking_detail['traveller_title'][$i]] . ' ';
							}	
						}
						$ret .= ($booking_detail['traveller_first_name'][$i] . ' ' . $booking_detail['traveller_last_name'][$i]);
						if( !empty($booking_detail['traveller_passport'][$i]) ){
							$ret .= '<br>' . esc_html__('Passport ID :', 'tourmaster') . ' ' . $booking_detail['traveller_passport'][$i];
						}
						$ret .= '</span>';
						$ret .= '</div>';
					}
				}
				$ret .= '</div>'; // tourmaster-payment-traveller- detail-wrap
			}
			
			return $ret;
		} // tourmaster_payment_traveller_detail
	}

	// contact form
	if( !function_exists('tourmaster_get_payment_contact_form_fields') ){
		function tourmaster_get_payment_contact_form_fields(){

			return array(
				'first_name' => array(
					'title' => esc_html__('First Name', 'tourmaster'),
					'type' => 'text',
					'required' => true
				),
				'last_name' => array(
					'title' => esc_html__('Last Name', 'tourmaster'),
					'type' => 'text',
					'required' => true
				),
				'email' => array(
					'title' => esc_html__('Email', 'tourmaster'),
					'type' => 'text',
					'required' => true
				),
				'phone' => array(
					'title' => esc_html__('Phone', 'tourmaster'),
					'type' => 'text',
					'required' => true
				),
				'country' => array(
					'title' => esc_html__('Country', 'tourmaster'),
					'type' => 'combobox',
					'required' => true, 
					'options' => tourmaster_get_country_list(),
					'default' => tourmaster_get_option('general', 'user-default-country', '')
				),
				'contact_address' => array(
					'title' => esc_html__('Address', 'tourmaster'),
					'type' => 'textarea'
				),
			);

		} // tourmaster_get_payment_contact_form_fields
	}
	if( !function_exists('tourmaster_payment_contact_form') ){
		function tourmaster_payment_contact_form( $booking_detail ){

			// form field
			$contact_fields = tourmaster_get_payment_contact_form_fields();

			$ret  = '<div class="tourmaster-payment-contact-wrap tourmaster-form-field tourmaster-with-border" >';
			$ret .= '<h3 class="tourmaster-payment-contact-title" ><i class="fa fa-file-text-o" ></i>';
			$ret .= esc_html__('Contact Details', 'tourmaster');
			$ret .= '</h3>';
			foreach( $contact_fields as $field_slug => $contact_field ){
				$contact_field['echo'] = false;
				$contact_field['slug'] = $field_slug;

				$value = empty($booking_detail[$field_slug])? '': $booking_detail[$field_slug];

				$ret .= tourmaster_get_form_field($contact_field, 'contact', $value);
			}
			$ret .= '</div>';

			// billing address
			$ret .= '<div class="tourmaster-payment-billing-wrap tourmaster-form-field tourmaster-with-border" >';
			$ret .= '<h3 class="tourmaster-payment-billing-title" ><i class="fa fa-file-text-o" ></i>';
			$ret .= esc_html__('Billing Details', 'tourmaster');
			$ret .= '</h3>';

			$ret .= '<div class="tourmaster-payment-billing-copy-wrap" ><label>';
			$ret .= '<input type="checkbox" class="tourmaster-payment-billing-copy" id="tourmaster-payment-billing-copy" ></i>';
			$ret .= '<span class="tourmaster-payment-billing-copy-text" >' . esc_html__('The same as contact details', 'tourmaster') . '</span>';
			$ret .= '</label></div>'; // tourmaster-payment-billing-copy-wrap

			foreach( $contact_fields as $field_slug => $contact_field ){

				$contact_field['echo'] = false;
				$contact_field['slug'] = 'billing_' . $field_slug;
				$contact_field['data'] = array(
					'slug' => 'contact-detail',
					'value' => $field_slug
				);

				$value = empty($booking_detail['billing_' . $field_slug])? '': $booking_detail['billing_' . $field_slug];

		 		$ret .= tourmaster_get_form_field($contact_field, 'billing', $value);
			}
			$ret .= '</div>'; // tourmaster-payment-billing-wrap

			// additional notes
			$additional_notes = empty($booking_detail['additional_notes'])? '': $booking_detail['additional_notes'];
			$ret .= '<div class="tourmaster-payment-additional-note-wrap tourmaster-form-field tourmaster-with-border" >';
			$ret .= '<h3 class="tourmaster-payment-additional-note-title" ><i class="fa fa-file-text-o" ></i>';
			$ret .= esc_html__('Notes', 'tourmaster');
			$ret .= '</h3>';
			$ret .= '<div class="tourmaster-additional-note-field clearfix">';
			$ret .= '<span class="tourmaster-head">' . esc_html__('Additional Notes', 'tourmaster') . '</span>';
			$ret .= '<span class="tourmaster-tail clearfix">';
			$ret .= '<textarea name="additional_notes" >' . esc_textarea($additional_notes) . '</textarea>';
			$ret .= '</span>';
			$ret .= '</div>'; // additional-note-field
			$ret .= '</div>'; // tourmasster-payment-additional-note-wrap

			$ret .= '<div class="tourmaster-tour-booking-required-error tourmaster-notification-box tourmaster-failure">' . esc_html__('Please fill all required fields.', 'tourmaster') . '</div>';
			$ret .= '<a class="tourmaster-tour-booking-continue tourmaster-button tourmaster-payment-step" data-step="3" >' . esc_html__('Next Step', 'tourmaster') . '</a>';

			return $ret;

		} // tourmaster_payment_contact_form
	}

	if( !function_exists('tourmaster_payment_contact_detail') ){
		function tourmaster_payment_contact_detail( $booking_detail ){

			// form field
			$contact_fields = tourmaster_get_payment_contact_form_fields();

			// contact detail
			$ret  = '<div class="tourmaster-payment-contact-detail-wrap clearfix tourmaster-item-rvpdlr" >';
			$ret .= '<div class="tourmaster-payment-detail-wrap tourmaster-payment-contact-detail tourmaster-item-pdlr" >';
			$ret .= '<h3 class="tourmaster-payment-detail-title" ><i class="fa fa-file-text-o" ></i>';
			$ret .= esc_html__('Contact Details', 'tourmaster');
			$ret .= '</h3>';
			foreach( $contact_fields as $slug => $contact_field ){
				$ret .= '<div class="tourmaster-payment-detail" >';
				$ret .= '<span class="tourmaster-head" >' . $contact_field['title'] . ' :</span>';
				$ret .= '<span class="tourmaster-tail" >' . (empty($booking_detail[$slug])? '-': $booking_detail[$slug]) . '</span>';
				$ret .= '</div>';
			}
			$ret .= '</div>'; // tourmaster-payment-detail-wrap

			// billing detail
			$ret .= '<div class="tourmaster-payment-detail-wrap tourmaster-payment-billing-detail tourmaster-item-pdlr" >';
			$ret .= '<h3 class="tourmaster-payment-detail-title" ><i class="fa fa-file-text-o" ></i>';
			$ret .= esc_html__('Billing Details', 'tourmaster');
			$ret .= '</h3>';
			foreach( $contact_fields as $slug => $contact_field ){
				$ret .= '<div class="tourmaster-payment-detail" >';
				$ret .= '<span class="tourmaster-head" >' . $contact_field['title'] . ' :</span>';
				$ret .= '<span class="tourmaster-tail" >' . (empty($booking_detail['billing_' . $slug])? '-': $booking_detail['billing_' . $slug]) . '</span>';
				$ret .= '</div>';
			}
			$ret .= '</div>'; // tourmaster-payment-detail-wrap
			$ret .= '</div>'; // tourmaster-payment-contact-detail-wrap

			// additional note
			if( !empty($booking_detail['additional_notes']) ){
				$ret .= '<div class="tourmaster-payment-detail-notes-wrap" >';
				$ret .= '<h3 class="tourmaster-payment-detail-title" ><i class="fa fa-file-text-o" ></i>';
				$ret .= esc_html__('Notes', 'tourmaster');
				$ret .= '</h3>';
				$ret .= '<div class="tourmaster-payment-detail" >';
				$ret .= '<span class="tourmaster-head" >' . esc_html__('Additional Notes') . ' :</span>';
				$ret .= '<span class="tourmaster-tail" >' . esc_html($booking_detail['additional_notes']) . '</span>';
				$ret .= '</div>'; // tourmaster-payment-detail
				$ret .= '</div>'; // tourmaster-payment-detail-wrap
				$ret .= '<div class="clear" ></div>';
			}

			return $ret;

		} // tourmaster_payment_contact_detail
	}

	if( !function_exists('tourmaster_payment_method') ){
		function tourmaster_payment_method(){

			$payment_method = tourmaster_get_option('payment', 'payment-method', array('booking', 'paypal', 'credit-card'));
			$paypal_enable = in_array('paypal', $payment_method);
			$credit_card_enable = in_array('credit-card', $payment_method);

			$extra_class = '';
			if( $paypal_enable && $credit_card_enable ){
				$extra_class .= ' tourmaster-both-online-payment';
			}else if( !$paypal_enable && !$credit_card_enable ){
				$extra_class .= ' tourmaster-none-online-payment';
			}
			$ret  = '<div class="tourmaster-payment-method-wrap ' . esc_attr($extra_class) . '" >';
			$ret .= '<h3 class="tourmaster-payment-method-title" >' . esc_html__('Please select a payment method', 'tourmaster') . '</h3>';
			
			if( $paypal_enable || $credit_card_enable ){
				$ret .= '<div class="tourmaster-payment-gateway clearfix" >';
				if( $paypal_enable ){
					$paypal_button_atts = apply_filters('tourmaster_paypal_button_atts', array());
					$ret .= '<div class="tourmaster-online-payment-method tourmaster-payment-paypal" >';
					$ret .= '<img src="' . esc_attr(TOURMASTER_URL) . '/images/paypal.png" alt="paypal" width="170" height="76" ';
					if( !empty($paypal_button_atts['method']) && $paypal_button_atts['method'] == 'ajax' ){
						$ret .= 'data-method="ajax" data-action="tourmaster_payment_selected" data-ajax="' . esc_url(TOURMASTER_AJAX_URL) . '" ';
						if( !empty($paypal_button_atts['type']) ){
							$ret .= 'data-action-type="' . esc_attr($paypal_button_atts['type']) . '" ';
						} 
					}
					$ret .= ' />';

					if( !empty($paypal_button_atts['service-fee']) ){
						if( $paypal_button_atts['service-fee'] == intval($paypal_button_atts['service-fee']) ){
							$paypal_service_fee = number_format(floatval($paypal_button_atts['service-fee']), 0, '.', ',');
						}else{
							$paypal_service_fee = number_format(floatval($paypal_button_atts['service-fee']), 2, '.', ',');
						}

						$ret .= '<div class="tourmaster-payment-paypal-service-fee-text" >';
						$ret .= sprintf(esc_html__('Additional %s%% is charged for PayPal payment.', 'tourmaster'), $paypal_service_fee);
						$ret .= '</div>';
					}
					$ret .= '</div>';
				}

				if( $credit_card_enable ){
					$payment_attr = apply_filters('goodlayers_plugin_payment_attribute', array());
					$ret .= '<div class="tourmaster-online-payment-method tourmaster-payment-credit-card" >';
					$ret .= '<img src="' . esc_attr(TOURMASTER_URL) . '/images/credit-card.png" alt="credit-card" width="170" height="76" ';
					if( !empty($payment_attr['method']) && $payment_attr['method'] == 'ajax' ){
						$ret .= 'data-method="ajax" data-action="tourmaster_payment_selected" data-ajax="' . esc_url(TOURMASTER_AJAX_URL) . '" ';
						if( !empty($payment_attr['type']) ){
							$ret .= 'data-action-type="' . esc_attr($payment_attr['type']) . '" ';
						} 
					}
					$ret .= ' />';

					$credit_card_types = tourmaster_get_option('payment', 'accepted-credit-card-type', array('visa', 'master-card', 'american-express', 'jcb'));
					if( !empty($credit_card_types) ){
						$ret .= '<div class="tourmaster-payment-credit-card-type" >';
						foreach( $credit_card_types as $type ){
							$ret .= '<img src="' . esc_attr(TOURMASTER_URL) . '/images/' . esc_attr($type) . '.png" alt="' . esc_attr($type) . '" />';
												
						}
						$ret .= '</div>';	
					}
					$ret .= '</div>';
				}
				$ret .= '</div>'; // tourmaster-payment-gateway
			}

			if( in_array('booking', $payment_method) ){

				if( sizeof($payment_method) > 1 ){
					$ret .= '<div class="tourmaster-payment-method-or" id="tourmaster-payment-method-or" >';
					$ret .= '<span class="tourmaster-left" ></span>';
					$ret .= '<span class="tourmaster-middle" >' . esc_html__('OR', 'tourmaster') . '</span>';
					$ret .= '<span class="tourmaster-right" ></span>';
					$ret .= '</div>'; // tourmaster-payment-method-or
				}

				$ret .= '<div class="tourmaster-payment-method-booking" >';
				if( is_user_logged_in() ){
					$ret .= '<a class="tourmaster-button tourmaster-payment-method-booking-button tourmaster-payment-step" data-name="payment-method" data-value="booking" data-step="4" >';
					$ret .= esc_html__('Book and pay later', 'tourmaster');
					$ret .= '</a>';
				}else{
					$book_by_email = tourmaster_get_option('general', 'enable-booking-via-email', 'enable');

					if( $book_by_email == 'enable' ){
						$ret .= '<a class="tourmaster-button tourmaster-payment-method-booking-button tourmaster-payment-step" data-name="payment-method" data-value="booking" data-step="4" >';
						$ret .= esc_html__('Book now via email', 'tourmaster');
						$ret .= '</a>';
					}else{
						$ret .= '<a class="tourmaster-button tourmaster-payment-method-booking-button" data-tmlb="book-and-pay-later-login" >';
						$ret .= esc_html__('Book and pay later', 'tourmaster');
						$ret .= '</a>';
						$ret .= tourmaster_lightbox_content(array(
							'id' => 'book-and-pay-later-login',
							'title' => esc_html__('To book and pay later requires an account', 'tourmaster'),
							'content' => tourmaster_get_login_form2(false, array(
								'redirect'=>'payment'
							))
						));	
					}
				}
				if( is_user_logged_in() ){
					$ret .= '<div class="tourmaster-payment-method-description" >';
					$ret .= esc_html__('* If you wish to do a bank transfer, please select "Book and pay later" button.', 'tourmaster'); 
					$ret .= '<br>' . esc_html__('You will have an option to submit payment receipt on your dashboard page.', 'tourmaster');
					$ret .= '</div>';
				}
				$ret .= '</div>'; // tourmaster-payment-method-booking
			}

			$our_term = tourmaster_get_option('payment', 'term-of-service-page', '#');
			$our_term = is_numeric($our_term)? get_permalink($our_term): $our_term; 
			$privacy = tourmaster_get_option('payment', 'privacy-statement-page', '#');
			$privacy = is_numeric($privacy)? get_permalink($privacy): $privacy; 
			$ret .= '<div class="tourmaster-payment-terms" >';
			$ret .= sprintf(wp_kses(
				__('* To continue means you\'re okay with our <a href="%s" target="_blank">Terms of Service</a> and <a href="%s" target="_blank">Privacy Statement</a>.', 'tourmaster'), 
				array('a' => array( 'href'=>array(), 'target'=>array() ))
			), $our_term, $privacy);
			$ret .= '</div>'; // tourmaster-payment-terms

			$ret .= '</div>'; // tourmaster-payment-method-wrap

			return $ret;
		}
	}	

	if( !function_exists('tourmaster_payment_complete') ){
		function tourmaster_payment_complete(){

			$ret  = '<div class="tourmaster-payment-complete-wrap" >';
			$ret .= '<div class="tourmaster-payment-complete-head" >' . esc_html__('Booking Completed!', 'tourmaster') . '</div>';
			$ret .= '<div class="tourmaster-payment-complete-content-wrap" >';
			$ret .= '<i class=" icon_check_alt2 tourmaster-payment-complete-icon" ></i>';
			$ret .= '<div class="tourmaster-payment-complete-thank-you" >' . esc_html__('Thank you!', 'tourmaster') . '</div>';
			$ret .= '<div class="tourmaster-payment-complete-content" >';
			$ret .= wp_kses(__('Your booking detail has been sent to your email. <br> You can check the payment status from your dashboard.', 'tourmaster'), array('br'=>array()));
			$ret .= '</div>'; // tourmaster-payment-complete-content

			if( is_user_logged_in() ){
				$ret .= '<a class="tourmaster-payment-complete-button tourmaster-button" href="' . tourmaster_get_template_url('user') . '" >' . esc_html__('Go to my dashboard', 'tourmaster') . '</a>';
			}else{
				$ret .= '<a class="tourmaster-payment-complete-button tourmaster-button" href="' . esc_url(home_url("/")) . '" >' . esc_html__('Go to homepage', 'tourmaster') . '</a>';
			}

			$bottom_text = tourmaster_get_option('general', 'payment-complete-bottom-text', '');
			if( !empty($bottom_text) ){
				$ret .= '<div class="tourmaster-payment-complete-bottom-text" >';
				$ret .= tourmaster_content_filter($bottom_text);
				$ret .= '</div>';
			}
			$ret .= '</div>'; // tourmaster-payment-complete-content-wrap
			$ret .= '</div>'; // tourmaster-payment-complete-wrap

			return $ret;
		}
	}
	if( !function_exists('tourmaster_payment_complete_delay') ){
		function tourmaster_payment_complete_delay(){

			$ret  = '<div class="tourmaster-payment-complete-wrap" >';
			$ret .= '<div class="tourmaster-payment-complete-head" >' . esc_html__('Booking Completed!', 'tourmaster') . '</div>';
			$ret .= '<div class="tourmaster-payment-complete-content-wrap" >';
			$ret .= '<i class=" icon_check_alt2 tourmaster-payment-complete-icon" ></i>';
			$ret .= '<div class="tourmaster-payment-complete-thank-you" >' . esc_html__('Thank you!', 'tourmaster') . '</div>';
			$ret .= '<div class="tourmaster-payment-complete-content" >';
			$ret .= wp_kses(__('Your booking detail will be sent to your email shortly. <br> You can check the payment status from your dashboard.<br> ( There might be some delay processing the paypal payment )', 'tourmaster'), array('br'=>array()));
			$ret .= '</div>'; // tourmaster-payment-complete-content

			if( is_user_logged_in() ){
				$ret .= '<a class="tourmaster-payment-complete-button tourmaster-button" href="' . tourmaster_get_template_url('user') . '" >' . esc_html__('Go to my dashboard', 'tourmaster') . '</a>';
			}else{
				$ret .= '<a class="tourmaster-payment-complete-button tourmaster-button" href="' . esc_url(home_url("/")) . '" >' . esc_html__('Go to homepage', 'tourmaster') . '</a>';
			}

			$bottom_text = tourmaster_get_option('general', 'payment-complete-bottom-text', '');
			if( !empty($bottom_text) ){
				$ret .= '<div class="tourmaster-payment-complete-bottom-text" >';
				$ret .= tourmaster_content_filter($bottom_text);
				$ret .= '</div>';
			}
			$ret .= '</div>'; // tourmaster-payment-complete-content-wrap
			$ret .= '</div>'; // tourmaster-payment-complete-wrap

			return $ret;
		}
	}

	//////////////////////////////////////////////////////////////////
	/////////////////            lightbox             ////////////////
	//////////////////////////////////////////////////////////////////
	if( !function_exists('tourmaster_lb_payment_receipt') ){
		function tourmaster_lb_payment_receipt( $transaction_id ){
			
			$form_fields = array(
				'receipt' => array(
					'title' => esc_html__('Select Image', 'tourmaster'),
					'type' => 'file',
				),
				'transaction-id' => array(
					'title' => esc_html__('Transaction ID ( from the receipt )', 'tourmaster'),
					'type' => 'text',
					'required' => true
				)
			);

			$ret  = '<form class="tourmaster-payment-receipt-form tourmaster-form-field tourmaster-with-border" ';
			$ret .= 'method="post" enctype="multipart/form-data" ';
			$ret .= 'action="' . remove_query_arg(array('error_code')) . '" ';
			$ret .= '>';

			// deposit payment
			$result = tourmaster_get_booking_data(array('id'=>$transaction_id), array('single'=>true));
			$enable_deposit_payment = tourmaster_get_option('payment', 'enable-deposit-payment', 'disable');
			$deposit_amount = tourmaster_get_option('payment', 'deposit-payment-amount', '0');
			
			if( $enable_deposit_payment == 'enable' ){
				$current_date = strtotime(current_time('Y-m-d'));
				$deposit_before_days = intval(tourmaster_get_option('payment', 'display-deposit-payment-day', '0'));
				if( $current_date + ($deposit_before_days * 86400) > $result->travel_date ){
					$enable_deposit_payment == 'disable';
				}
			}

			if( $enable_deposit_payment == 'enable' && !empty($deposit_amount) ){
				$pricing_info = json_decode($result->pricing_info, true);
				
				$ret .= '<div class="tourmaster-payment-receipt-field tourmaster-payment-receipt-field-payment-type clearfix" >';
				$ret .= '<div class="tourmaster-head" >' . esc_html__('Select Payment Type', 'tourmaster') . '</div>';
				$ret .= '<div class="tourmaster-tail clearfix" >';
				$ret .= '<div class="tourmaster-payment-receipt-deposit-option" >';
				$ret .= '<label class="tourmaster-deposit-payment-full" >';
				$ret .= '<input type="radio" name="payment-type" value="full" checked />';
				$ret .= '<span class="tourmaster-content" >';
				$ret .= '<i class="icon_check_alt2" ></i>';
				$ret .= sprintf(esc_html__('Pay Full Amount : %s', 'tourmaster'), tourmaster_money_format($pricing_info['total-price']));
				$ret .= '</span>';
				$ret .= '</label>'; 

				$deposit_price = ($pricing_info['total-price'] * intval($deposit_amount)) / 100;
				$ret .= '<label class="tourmaster-deposit-payment-partial" >';
				$ret .= '<input type="radio" name="payment-type" value="partial" />';
				$ret .= '<span class="tourmaster-content" >';
				$ret .= '<i class="icon_check_alt2" ></i>';
				$ret .= sprintf(esc_html__('Pay %d%% Deposit : %s', 'tourmaster'), $deposit_amount, tourmaster_money_format($deposit_price));
				$ret .= '<input type="hidden" name="deposit-rate" value="' . esc_attr($deposit_amount) . '" />';
				$ret .= '<input type="hidden" name="deposit-price" value="' . esc_attr($deposit_price) . '" />';
				$ret .= '</span>';
				$ret .= '</label>';
				$ret .= '</div>';

				$ret .= '</div>';
				$ret .= '</div>';
			}

			foreach( $form_fields as $field_slug => $form_field ){
				$form_field['echo'] = false;
				$form_field['slug'] = $field_slug;
				$ret .= tourmaster_get_form_field($form_field, 'payment-receipt');
			}

			$ret .= '<div class="tourmaster-lb-submit-error tourmaster-notification-box tourmaster-failure" >';
			$ret .= esc_html__('Please fill all required fields', 'tourmaster');
			$ret .= '</div>';

			$ret .= '<div class="tourmaster-payment-receipt-field-submit" >';
			$ret .= '<input class="tourmaster-payment-receipt-field-submit-button tourmaster-button" type="submit" value="' . esc_html__('Submit', 'tourmaster') . '" />';
			$ret .= '</div>';

			$ret .= '<div class="tourmaster-payment-receipt-description" >';
			$ret .= esc_html__('* Please wait for the verification process after submitting the receipt. This could take up to couple days. You can check the status of submission from your "Dashboard" or "My Booking" page.', 'tourmaster');
			$ret .= '</div>';

			$ret .= '<input type="hidden" name="action" value="payment-receipt" />';
			$ret .= '<input type="hidden" name="id" value="'. esc_attr($transaction_id) . '" />';

			$ret .= '</form>';

			return $ret;
		}
	}

	//////////////////////////////////////////////////////////////////
	/////////////////            ajax action          ////////////////
	//////////////////////////////////////////////////////////////////

	add_action('wp_ajax_tourmaster_payment_template', 'tourmaster_ajax_payment_template');
	add_action('wp_ajax_nopriv_tourmaster_payment_template', 'tourmaster_ajax_payment_template');
	if( !function_exists('tourmaster_ajax_payment_template') ){
		function tourmaster_ajax_payment_template(){

			$booking_detail = empty($_POST['booking_detail'])? array(): tourmaster_process_post_data($_POST['booking_detail']);
			
			$ret = tourmaster_get_payment_page($booking_detail);
			
			if( !empty($_POST['sub_action']) && $_POST['sub_action'] == 'update_sidebar' ){
				unset($ret['content']);
			} 

			if( $booking_detail['step'] != 4 ){ 
				$ret['cookie'] = $_POST['booking_detail'];
			}

			die(json_encode($ret));

		} // tourmaster_ajax_payment_template
	}

	add_action('wp_ajax_tourmaster_validate_coupon_code', 'tourmaster_ajax_validate_coupon_code');
	add_action('wp_ajax_nopriv_tourmaster_validate_coupon_code', 'tourmaster_ajax_validate_coupon_code');
	if( !function_exists('tourmaster_validate_coupon_code') ){
		function tourmaster_validate_coupon_code( $coupon_code, $tour_id ){
			global $wpdb;

			$coupons = get_posts(array(
				'post_type' => 'tour_coupon', 
				'posts_per_page' => 1, 
				'meta_key' => 'tourmaster-coupon-code', 
				'meta_value' => $coupon_code
			));

			if( !empty($coupons) ){

				$coupon_status = true;
				$coupon_option = get_post_meta($coupons[0]->ID, 'tourmaster-coupon-option', true);

				// check expiry
				if( !empty($coupon_option['coupon-expiry']) ){
					if( strtotime(date("Y-m-d")) > strtotime($coupon_option['coupon-expiry']) ){
						return array(
							'status' => 'failed',
							'message' => esc_html__('This coupon has been expired, please try again with different coupon', 'tourmaster')
						);
					}
				}

				// check specific tour
				if( !empty($coupon_option['apply-to-specific-tour']) ){
					$allow_tours = array_map('trim', explode(',', $coupon_option['apply-to-specific-tour']));
					if( !in_array($tour_id, $allow_tours) ){
						return array(
							'status' => 'failed',
							'message' => esc_html__('This coupon is not available for this tour, please try again with different coupon', 'tourmaster')
						);
					}
				}

				// check the available number
				if( !empty($coupon_option['coupon-amount']) ){
					$used_coupon = tourmaster_get_booking_data(array('coupon_code'=>$coupon_code), array(), 'COUNT(*)');

					if( $used_coupon >= $coupon_option['coupon-amount'] ){
						return array(
							'status' => 'failed',
							'message' => esc_html__('This coupon has been used up, please try again with different coupon', 'tourmaster')
						);
					}
				}

				// coupon is valid
				$discount_amount = 0;
				if( !empty($coupon_option['coupon-discount-type']) ){
					if( $coupon_option['coupon-discount-type'] == 'percent' ){
						$discount_amount = $coupon_option['coupon-discount-amount'] . '%';
					}else if( $coupon_option['coupon-discount-type'] == 'amount' ){
						$discount_amount = tourmaster_money_format($coupon_option['coupon-discount-amount']);
					} 		
				}
				$message = sprintf(__('You got %s discount', 'tourmaster'), $discount_amount);
				return array(
					'status' => 'success',
					'message' => $message, 
					'data' => $coupon_option
				);

			}else{
				return array(
					'status' => 'failed',
					'message' => esc_html__('Invalid coupon code, please try again with different coupon', 'tourmaster')
				);
			}
		}
	}
	if( !function_exists('tourmaster_ajax_validate_coupon_code') ){
		function tourmaster_ajax_validate_coupon_code(){

			$ret = array();

			if( empty($_POST['coupon_code']) ){
				die(json_encode(array(
					'status' => 'failed',
					'message' => esc_html__('Please fill in the coupon code', 'tourmaster')
				)));
			}else{

				$status = tourmaster_validate_coupon_code($_POST['coupon_code'], $_POST['tour_id']);
				unset($status['data']);

				die(json_encode($status));
			}

		} // tourmaster_ajax_payment_template
	}

	//////////////////////////////////////////////////////////////////
	/////////////////     payment plugin supported    ////////////////
	//////////////////////////////////////////////////////////////////
	add_filter('goodlayers_payment_get_transaction_data', 'tourmaster_goodlayers_payment_get_transaction_data', 10, 3);
	if( !function_exists('tourmaster_goodlayers_payment_get_transaction_data') ){
		function tourmaster_goodlayers_payment_get_transaction_data( $ret, $tid, $types ){
			$result = tourmaster_get_booking_data(array('id'=>$tid), array('single'=>true));
			if( !empty($result) ){
				$ret = array();

				foreach( $types as $type ){
					if( $type == 'price' ){
						$pricing_info = json_decode($result->pricing_info, true);
						if( $pricing_info['deposit-price'] ){
							$ret[$type] = $pricing_info['deposit-price'];
						}else{
							$ret[$type] = $pricing_info['total-price'];
						}

					}else if( $type == 'email' ){
						$contact_info = json_decode($result->contact_info, true);
						$ret[$type] = $contact_info[$type];
					}else if( $type == 'tour_id' ){
						$ret[$type] = $result->tour_id;
					}
				}
			}

			return $ret;
		}
	}

	add_filter('goodlayers_payment_get_option', 'tourmaster_goodlayers_payment_get_option', 10, 2);
	if( !function_exists('tourmaster_goodlayers_payment_get_option') ){
		function tourmaster_goodlayers_payment_get_option($value, $key){
			return tourmaster_get_option('payment', $key, $value);
		}
	}

	add_action('goodlayers_set_payment_complete', 'tourmaster_goodlayers_set_payment_complete', 10, 2);
	if( !function_exists('tourmaster_goodlayers_set_payment_complete') ){
		function tourmaster_goodlayers_set_payment_complete($tid, $payment_info){

			$result = tourmaster_get_booking_data(array('id'=>$tid), array('single'=>true));
			if( empty($payment_info['amount']) || tourmaster_compare_price($result->total_price, $payment_info['amount']) ){
				$order_status = 'online-paid';
			}else{
				$order_status = 'deposit-paid';
			}

			tourmaster_update_booking_data( 
				array(
					'payment_info' => json_encode($payment_info),
					'payment_date' => current_time('mysql'),
					'order_status' => $order_status
				),
				array('id' => $tid),
				array('%s', '%s', '%s'),
				array('%d')
			);

			tourmaster_mail_notification('payment-made-mail', $tid);
			tourmaster_mail_notification('admin-online-payment-made-mail', $tid);
		}
	}

	add_action('wp_ajax_tourmaster_payment_plugin_complete', 'tourmaster_payment_plugin_complete');
	add_action('wp_ajax_nopriv_tourmaster_payment_plugin_complete', 'tourmaster_payment_plugin_complete');
	if( !function_exists('tourmaster_payment_plugin_complete') ){
		function tourmaster_payment_plugin_complete(){
			die(json_encode(array(
				'cookie' => '',
				'content' => tourmaster_payment_complete()
			)));
		}
	}

	add_action('wp_ajax_tourmaster_payment_selected', 'tourmaster_ajax_payment_selected');
	add_action('wp_ajax_nopriv_tourmaster_payment_selected', 'tourmaster_ajax_payment_selected');
	if( !function_exists('tourmaster_ajax_payment_selected') ){
		function tourmaster_ajax_payment_selected(){

			$ret = array();

			if( !empty($_POST['booking_detail']) ){
				$booking_detail = tourmaster_process_post_data($_POST['booking_detail']);
				
				if( !empty($booking_detail['tour-id']) && !empty($booking_detail['tour-date']) ){
					$tour_option = tourmaster_get_post_meta($booking_detail['tour-id'], 'tourmaster-tour-option');
					$date_price = tourmaster_get_tour_date_price($tour_option, $booking_detail['tour-id'], $booking_detail['tour-date']);
					$date_price = tourmaster_get_tour_date_price_package($date_price, $booking_detail);
				
					$tour_price = tourmaster_get_tour_price($tour_option, $date_price, $booking_detail);
					
					if( $date_price['pricing-method'] == 'group' ){
						$traveller_amount = 1;
					}else{
						$traveller_amount = tourmaster_get_tour_people_amount($tour_option, $date_price, $booking_detail);
					}
					
					$package_group_slug = empty($date_price['group-slug'])? '': $date_price['group-slug'];
					$tid = tourmaster_insert_booking_data($booking_detail, $tour_price, $traveller_amount, $package_group_slug);

					if( $tour_price['total-price'] <= 0 ){
						$ret['content'] = tourmaster_payment_complete();
						$ret['cookie'] = '';
						
					}else if( !empty($_POST['type']) ){
						$booking_detail['tid'] = $tid;

						$ret['content'] = apply_filters('goodlayers_' . $_POST['type'] . '_payment_form', '', $tid);
						$ret['cookie'] = $booking_detail;
						
						if( $_POST['type'] == 'paypal' ){
							$booking_detail['payment_method'] = 'paypal';
							$ret['sidebar'] = tourmaster_get_booking_bar_summary( $tour_option, $date_price, $booking_detail );
						}
					}
				}
			}

			die(json_encode($ret));
		} // tourmaster_ajax_payment_selected
	}