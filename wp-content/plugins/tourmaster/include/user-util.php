<?php
	/*	
	*	Utility function for uses
	*/

	if( !function_exists('tourmaster_get_country_list') ){
		function tourmaster_get_country_list( $with_none = false ){
			$ret = array(
				'Afghanistan' => 'Afghanistan', 'Albania' => 'Albania', 'Algeria' => 'Algeria', 'Andorra' => 'Andorra', 'Angola' => 'Angola', 'Antigua and Barbuda' => 'Antigua and Barbuda', 'Argentina' => 'Argentina', 'Armenia' => 'Armenia', 'Australia' => 'Australia', 'Austria' => 'Austria', 'Azerbaijan' => 'Azerbaijan', 'Bahamas' => 'Bahamas', 'Bahrain' => 'Bahrain', 'Bangladesh' => 'Bangladesh', 'Barbados' => 'Barbados', 'Belarus' => 'Belarus', 'Belgium' => 'Belgium', 'Belize' => 'Belize', 'Benin' => 'Benin', 'Bhutan' => 'Bhutan', 'Bolivia' => 'Bolivia', 'Bosnia and Herzegovina' => 'Bosnia and Herzegovina', 'Botswana' => 'Botswana', 'Brazil' => 'Brazil', 'Brunei' => 'Brunei', 'Bulgaria' => 'Bulgaria', 'Burkina Faso' => 'Burkina Faso', 'Burundi' => 'Burundi', 'Cabo Verde' => 'Cabo Verde', 'Cambodia' => 'Cambodia', 'Cameroon' => 'Cameroon', 'Canada' => 'Canada', 'Central African Republic (CAR)' => 'Central African Republic (CAR)', 'Chad' => 'Chad', 'Chile' => 'Chile', 'China' => 'China', 'Colombia' => 'Colombia', 'Comoros' => 'Comoros', 'Democratic Republic of the Congo' => 'Democratic Republic of the Congo', 'Republic of the Congo' => 'Republic of the Congo', 'Costa Rica' => 'Costa Rica', 'Cote d\'Ivoire' => 'Cote d\'Ivoire', 'Croatia' => 'Croatia', 'Cuba' => 'Cuba', 'Cyprus' => 'Cyprus', 'Czech Republic' => 'Czech Republic', 'Denmark' => 'Denmark', 'Djibouti' => 'Djibouti', 'Dominica' => 'Dominica', 'Dominican Republic' => 'Dominican Republic', 'Ecuador' => 'Ecuador', 'Egypt' => 'Egypt', 'El Salvador' => 'El Salvador', 'Equatorial Guinea' => 'Equatorial Guinea', 'Eritrea' => 'Eritrea', 'Estonia' => 'Estonia', 'Ethiopia' => 'Ethiopia', 'Fiji' => 'Fiji', 'Finland' => 'Finland', 'France' => 'France', 'Gabon' => 'Gabon', 'Gambia' => 'Gambia', 'Georgia' => 'Georgia', 'Germany' => 'Germany', 'Ghana' => 'Ghana', 'Greece' => 'Greece', 'Grenada' => 'Grenada', 'Guatemala' => 'Guatemala', 'Guinea' => 'Guinea', 'Guinea-Bissau' => 'Guinea-Bissau', 'Guyana' => 'Guyana', 'Haiti' => 'Haiti', 'Honduras' => 'Honduras', 'Hungary' => 'Hungary', 'Iceland' => 'Iceland', 'India' => 'India', 'Indonesia' => 'Indonesia', 'Iran' => 'Iran', 'Iraq' => 'Iraq', 'Ireland' => 'Ireland', 'Israel' => 'Israel', 'Italy' => 'Italy', 'Jamaica' => 'Jamaica', 'Japan' => 'Japan', 'Jordan' => 'Jordan', 'Kazakhstan' => 'Kazakhstan', 'Kenya' => 'Kenya', 'Kiribati' => 'Kiribati', 'Kosovo' => 'Kosovo', 'Kuwait' => 'Kuwait', 'Kyrgyzstan' => 'Kyrgyzstan', 'Laos' => 'Laos', 'Latvia' => 'Latvia', 'Lebanon' => 'Lebanon', 'Lesotho' => 'Lesotho', 'Liberia' => 'Liberia', 'Libya' => 'Libya', 'Liechtenstein' => 'Liechtenstein', 'Lithuania' => 'Lithuania', 'Luxembourg' => 'Luxembourg', 'Macedonia' => 'Macedonia', 'Madagascar' => 'Madagascar', 'Malawi' => 'Malawi', 'Malaysia' => 'Malaysia', 'Maldives' => 'Maldives', 'Mali' => 'Mali', 'Malta' => 'Malta', 'Marshall Islands' => 'Marshall Islands', 'Mauritania' => 'Mauritania', 'Mauritius' => 'Mauritius', 'Mexico' => 'Mexico', 'Micronesia' => 'Micronesia', 'Moldova' => 'Moldova', 'Monaco' => 'Monaco', 'Mongolia' => 'Mongolia', 'Montenegro' => 'Montenegro', 'Morocco' => 'Morocco', 'Mozambique' => 'Mozambique', 'Myanmar (Burma)' => 'Myanmar (Burma)', 'Namibia' => 'Namibia', 'Nauru' => 'Nauru', 'Nepal' => 'Nepal', 'Netherlands' => 'Netherlands', 'New Zealand' => 'New Zealand', 'Nicaragua' => 'Nicaragua', 'Niger' => 'Niger', 'Nigeria' => 'Nigeria', 'North Korea' => 'North Korea', 'Norway' => 'Norway', 'Oman' => 'Oman', 'Pakistan' => 'Pakistan', 'Palau' => 'Palau', 'Palestine' => 'Palestine', 'Panama' => 'Panama', 'Papua New Guinea' => 'Papua New Guinea', 'Paraguay' => 'Paraguay', 'Peru' => 'Peru', 'Philippines' => 'Philippines', 'Poland' => 'Poland', 'Portugal' => 'Portugal', 'Qatar' => 'Qatar', 'Romania' => 'Romania', 'Russia' => 'Russia', 'Rwanda' => 'Rwanda', 'Saint Kitts and Nevis' => 'Saint Kitts and Nevis', 'Saint Lucia' => 'Saint Lucia', 'Saint Vincent and the Grenadines' => 'Saint Vincent and the Grenadines', 'Samoa' => 'Samoa', 'San Marino' => 'San Marino', 'Sao Tome and Principe' => 'Sao Tome and Principe', 'Saudi Arabia' => 'Saudi Arabia', 'Senegal' => 'Senegal', 'Serbia' => 'Serbia', 'Seychelles' => 'Seychelles', 'Sierra Leone' => 'Sierra Leone', 'Singapore' => 'Singapore', 'Slovakia' => 'Slovakia', 'Slovenia' => 'Slovenia', 'Solomon Islands' => 'Solomon Islands', 'Somalia' => 'Somalia', 'South Africa' => 'South Africa', 'South Korea' => 'South Korea', 'South Sudan' => 'South Sudan', 'Spain' => 'Spain', 'Sri Lanka' => 'Sri Lanka', 'Sudan' => 'Sudan', 'Suriname' => 'Suriname', 'Swaziland' => 'Swaziland', 'Sweden' => 'Sweden', 'Switzerland' => 'Switzerland', 'Syria' => 'Syria', 'Taiwan' => 'Taiwan', 'Tajikistan' => 'Tajikistan', 'Tanzania' => 'Tanzania', 'Thailand' => 'Thailand', 'Timor-Leste' => 'Timor-Leste', 'Togo' => 'Togo', 'Tonga' => 'Tonga', 'Trinidad and Tobago' => 'Trinidad and Tobago', 'Tunisia' => 'Tunisia', 'Turkey' => 'Turkey', 'Turkmenistan' => 'Turkmenistan', 'Tuvalu' => 'Tuvalu', 'Uganda' => 'Uganda', 'Ukraine' => 'Ukraine', 'United Arab Emirates (UAE)' => 'United Arab Emirates (UAE)', 'United Kingdom (UK)' => 'United Kingdom (UK)', 'United States of America (USA)' => 'United States of America (USA)', 'Uruguay' => 'Uruguay', 'Uzbekistan' => 'Uzbekistan', 'Vanuatu' => 'Vanuatu', 'Vatican City (Holy See)' => 'Vatican City (Holy See)', 'Venezuela' => 'Venezuela', 'Vietnam' => 'Vietnam', 'Yemen' => 'Yemen', 'Zambia' => 'Zambia', 'Zimbabwe' => 'Zimbabwe'
			);

			if( $with_none ){
				$ret = array( '' => esc_html__('None', 'tourmaster') ) + $ret;
			} 

			return $ret;
		}
	}

	if( !function_exists('tourmaster_user_content_block_start') ){
		function tourmaster_user_content_block_start( $settings = array() ){
			echo '<div class="tourmaster-user-content-block" >';
			if( !empty($settings['title']) ){
				echo '<div class="tourmaster-user-content-title-wrap" >';
				echo '<h3 class="tourmaster-user-content-title">' . $settings['title'] . '</h3>';
				
				if( !empty($settings['title-link']) ){
					echo '<a class="tourmaster-user-content-title-link" href="' . esc_url($settings['title-link']) . '" >';
					echo $settings['title-link-text'];
					echo '</a>';
				}
				echo '</div>'; // tourmaster-user-content-title-wrap

				echo '<div class="tourmaster-user-content-block-content" >';
			}
			
		} // tourmaster_user_content_block_start
	}

	if( !function_exists('tourmaster_user_update_notification') ){
		function tourmaster_user_update_notification( $content, $success = true ){

			echo '<div class="tourmaster-user-update-notification tourmaster-' . ($success? 'success': 'failure') . '" >';
			if( $success ){
				echo '<i class="fa fa-check" ></i>';
			}else if( $success == 'fail' ){
				echo '<i class="fa fa-remove" ></i>';
			}
			echo $content;
			echo '</div>';

		} // tourmaster_user_update_notification
	}

	if( !function_exists('tourmaster_user_content_block_end') ){
		function tourmaster_user_content_block_end(){

			echo '</div>'; // tourmaster-user-content-block-content
			echo '</div>'; // tourmaster-user-content-block

		} // tourmaster_user_content_block_end
	}

	if( !function_exists('tourmaster_get_user_meta') ){
		function tourmaster_get_user_meta( $user_id = null, $type = 'full_name', $default = ''){

			if( $type == 'full_name' ){
				$name  = get_the_author_meta('first_name', $user_id);
				if( !empty($name) ){
					$name .= ' ' . get_the_author_meta('last_name', $user_id);
				}else{
					$name  = get_the_author_meta('display_name', $user_id);
				}

				if( !empty($name) ){
					return $name;
				}
			}else{
				$user_meta = get_the_author_meta($type, $user_id);

				if( !empty($user_meta) ){
					return $user_meta;
				}
			}

			return $default;

		} // tourmaster_get_user_meta
	}

	if( !function_exists('tourmaster_validate_profile_field') ){
		function tourmaster_validate_profile_field( $fields ){

			$error = new WP_ERROR();

			foreach( $fields as $slug => $field ){
				$error_message = $error->get_error_message('1');
				if( !empty($field['required']) && empty($_POST[$slug]) && empty($error_message) ){
					$error->add('1', esc_html__('Please fill all required fields.', 'tourmaster'));
				}

				if( !empty($field['type']) && $field['type'] == 'email' && !is_email($_POST[$slug]) ){
					$error->add('2', esc_html__('Incorrect email address.', 'tourmaster'));
				}
			}

			$error_message = $error->get_error_message();
			if( !empty($error_message) ){
				return $error;
			}else{
				return true;
			}

		} // tourmaster_validate_profile_field
	}

	if( !function_exists('tourmaster_update_profile_field') ){
		function tourmaster_update_profile_field( $fields, $user_id = '' ){
			global $current_user;

			if( empty($user_id) ){
				$user_id = $current_user->ID;
			}

			foreach( $fields as $slug => $field ){
				if( $slug == 'email' ){
					if( !empty($_POST['email']) ){
			        	wp_update_user(array(
			                'ID' => $user_id,
			                'user_email' => $_POST['email']
			            ));
			        }
				}else{
					$value = empty($_POST[$slug])? '': $_POST[$slug];
					update_user_meta($user_id, $slug, $value);
				}
			}

		} // tourmaster_update_profile_field
	}

	if( !function_exists('tourmaster_get_profile_fields') ){
		function tourmaster_get_profile_fields(){
			return apply_filters('tourmaster_profile_fields', array(
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
				'gender' => array(
					'title' => esc_html__('Gender', 'tourmaster'),
					'type' => 'combobox',
					'options' => array(
						'' => '-',
						'male' => esc_html__('Male', 'tourmaster'),
						'female' => esc_html__('Female', 'tourmaster')
					)
				),
				'birth_date' => array(
					'title' => esc_html__('Birth Date', 'tourmaster'),
					'type' => 'date'
				),
				'email' => array(
					'title' => esc_html__('Email', 'tourmaster'),
					'type' => 'email',
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
					'options' => tourmaster_get_country_list(),
					'required' => true,
					'default' => tourmaster_get_option('general', 'user-default-country', '')
				),
				'contact_address' => array(
					'title' => esc_html__('Contact Address', 'tourmaster'),
					'type' => 'textarea'
				),
			));
		}
	}	

	// user nav list
	if( !function_exists('tourmaster_get_user_nav_list') ){
		function tourmaster_get_user_nav_list(){
			return apply_filters('tourmaster_user_nav_list', array(
				'my-account-title' => array(
					'type' => 'title',
					'title' => esc_html__('My Account', 'tourmaster')
				),
				'dashboard' => array(
					'title' => esc_html__('Dashboard', 'tourmaster'),
					'icon' => 'fa fa-dashboard',
					'top-bar' => true,
				),
				'edit-profile' => array(
					'title' => esc_html__('Edit Profile', 'tourmaster'),
					'icon' => 'fa fa-edit',
					'top-bar' => true,
				),
				'change-password' => array(
					'title' => esc_html__('Change Password', 'tourmaster'),
					'icon' => 'fa fa-unlock-alt'
				),
				'tour-booking-title' => array(
					'type' => 'title',
					'title' => esc_html__('Tour Booking', 'tourmaster')
				),
				'my-booking' => array(
					'title' => esc_html__('My Bookings', 'tourmaster'),
					'icon' => 'icon_document_alt'
				),
				'invoices' => array(
					'title' => esc_html__('Invoices', 'tourmaster'),
					'icon' => 'icon_wallet'
				),
				'reviews' => array(
					'title' => esc_html__('Reviews', 'tourmaster'),
					'icon' => 'fa fa-star'
				),
				'wish-list' => array(
					'title' => esc_html__('Wish List', 'tourmaster'),
					'icon' => 'fa fa-heart-o',
					'top-bar' => true,
				),
				'sign-out' => array(
					'title' => esc_html__('Sign Out', 'tourmaster'),
					'icon' => 'icon_lock-open_alt',
					'link' => wp_logout_url( home_url('/') ),
					'top-bar' => true,
				),
			));
		}
	}

	// user page breadcrumbs
	if( !function_exists('tourmaster_get_user_breadcrumb') ){
		function tourmaster_get_user_breadcrumb(){

			$main_page = empty($_GET['page_type'])? 'dashboard': $_GET['page_type'];
			$sub_page = empty($_GET['sub_page'])? '': $_GET['sub_page'];
			$nav_list = tourmaster_get_user_nav_list();

			echo '<div class="tourmaster-user-breadcrumbs" >';

			// dashboard
			if( !empty($nav_list['dashboard']['title']) ){
				$page_link = tourmaster_get_template_url('user', array('page_type'=>'dashboard'));

				echo '<a class="tourmaster-user-breadcrumbs-item ' . (($main_page == 'dashboard')? 'tourmaster-active': '') . '" href="' . esc_url($page_link) . '" >';
				echo $nav_list['dashboard']['title'];
				echo '</a>';

				if( $main_page != 'dashboard' ){
					echo '<span class="tourmaster-sep" >></span>';
				}
			}

			// main navigation
			if( $main_page != 'dashboard' ){
				if( !empty($nav_list[$main_page]['title']) ){
					$main_nav_title = $nav_list[$main_page]['title'];
				}else{
					$main_nav_title = $main_page;
				}

				if( empty($sub_page) ){
					echo '<span class="tourmaster-user-breadcrumbs-item tourmaster-active" >' . $main_nav_title . '</span>';
				}else{
					$page_link = tourmaster_get_template_url('user', array('page_type'=>$main_page));
					echo '<a class="tourmaster-user-breadcrumbs-item" href="' . $page_link . '" >' . $main_nav_title . '</a>';
					echo '<span class="tourmaster-sep" >></span>';
				}	
			}

			// sub navigation
			if( !empty($sub_page) ){
				if( !empty($_GET['tour_id']) ){
					$sub_nav_title = get_the_title($_GET['tour_id']);
				}else{
					$sub_nav_title = $sub_page;
				}

				echo '<span class="tourmaster-user-breadcrumbs-item tourmaster-active" >' . $sub_nav_title . '</span>';
			}

			echo '</div>';

		} // tourmaster_get_user_breadcrumb
	}	

	// for user top bar
	if( !function_exists('tourmaster_user_top_bar') ){
		function tourmaster_user_top_bar(){

			if( is_user_logged_in() ){
				global $current_user;

				$ret  = '<div class="tourmaster-user-top-bar tourmaster-user" >';
				$ret .= get_avatar($current_user->data->ID, 30);
				$ret .= '<span class="tourmaster-user-top-bar-name" >' . tourmaster_get_user_meta($current_user->data->ID, 'full_name') . '</span>';
				$ret .= '<i class="fa fa-sort-down" ></i>';

				$nav_list = tourmaster_get_user_nav_list();
				$user_page = tourmaster_get_template_url('user');
				$ret .= '<div class="tourmaster-user-top-bar-nav" >';
				$ret .= '<div class="tourmaster-user-top-bar-nav-inner" >';
				foreach( $nav_list as $nav_slug => $nav ){
					if( !empty($nav['top-bar']) && !empty($nav['title']) ){
						$nav_link = empty($nav['link'])? add_query_arg(array('page_type'=>$nav_slug), $user_page): $nav['link'];

						$ret .= '<div class="tourmaster-user-top-bar-nav-item tourmaster-nav-' . esc_attr($nav_slug) . '" >';
						$ret .= '<a href="' . esc_url($nav_link) . '" >' . $nav['title'] . '</a>';
						$ret .= '</div>';
					}
				}
				$ret .= '</div>'; // tourmaster-user-top-bar-nav-inner
				$ret .= '</div>'; // tourmaster-user-top-bar-nav
				$ret .= '</div>'; // tourmaster-user-top-bar
			}else{
				$ret  = '<div class="tourmaster-user-top-bar tourmaster-guest" >';
				$ret .= '<span class="tourmaster-user-top-bar-login" data-tmlb="login" >';
				$ret .= '<i class="icon_lock_alt" ></i>';
				$ret .= '<span class="tourmaster-text" >' . esc_html__('Login', 'tourmaster') . '</span>';
				$ret .= '</span>';
				$ret .= tourmaster_lightbox_content(array(
					'id' => 'login',
					'title' => esc_html__('Login', 'tourmaster'),
					'content' => tourmaster_get_login_form(false)
				));
				$ret .= '<span class="tourmaster-user-top-bar-signup" data-tmlb="signup" >';
				$ret .= '<i class="fa fa-user" ></i>';
				$ret .= '<span class="tourmaster-text" >' . esc_html__('Sign Up', 'tourmaster') . '</span>';
				$ret .= '</span>';
				$ret .= tourmaster_lightbox_content(array(
					'id' => 'signup',
					'title' => esc_html__('Sign Up', 'tourmaster'),
					'content' => tourmaster_get_registration_form(false)
				));
				$ret .= '</div>';
			}
			
			return $ret;
		}
	}

	// login form
	if( !function_exists('tourmaster_get_login_form') ){
		function tourmaster_get_login_form( $echo = true ){
			if( !$echo ){
				ob_start();
			}
?>
<form class="tourmaster-login-form tourmaster-form-field tourmaster-with-border" method="post" action="<?php echo esc_url(site_url('wp-login.php', 'login_post')); ?>">
	<div class="tourmaster-login-form-fields clearfix" >
		<p class="tourmaster-login-user">
			<label><?php echo esc_html__('Username', 'tourmaster'); ?></label>
			<input type="text" name="log" />
		</p>
		<p class="tourmaster-login-pass">
			 <label><?php echo esc_html__('Password', 'tourmaster'); ?></label>
			 <input type="password" name="pwd" />
		</p>
	</div>
	<?php do_action('login_form'); ?> 
	<p class="tourmaster-login-submit" >
		<input type="submit" name="wp-submit" class="tourmaster-button" value="<?php echo esc_html__('Sign In!', 'tourmaster'); ?>" />
	</p>
	<p class="tourmaster-login-lost-password" >
		<a href="<?php echo add_query_arg(array('source'=>'tm'), wp_lostpassword_url()); ?>" ><?php echo esc_html__('Forget Password?','tourmaster'); ?></a>
	</p>

	<input type="hidden" name="rememberme"  value="forever" />
	<input type="hidden" name="redirect_to" value="<?php echo esc_url(add_query_arg(null, null)); ?>" />
	<input type="hidden" name="source"  value="tm" />
</form>

<div class="tourmaster-login-bottom" >
	<h3 class="tourmaster-login-bottom-title" ><?php echo esc_html__('Do not have an account?', 'tourmaster'); ?></h3>
	<a class="tourmaster-login-bottom-link" href="<?php echo tourmaster_get_template_url('register'); ?>" ><?php echo esc_html__('Create an Account', 'tourmaster'); ?></a>
</div>
<?php
			if( !$echo ){
				$ret = ob_get_contents();
				ob_end_clean();

				return $ret;
			}
		} // tourmaster_get_login_form
	} 

	// login form
	if( !function_exists('tourmaster_get_login_form2') ){
		function tourmaster_get_login_form2( $echo = true, $settings = array() ){
			if( !$echo ){
				ob_start();
			}
?>
<div class="tourmaster-login-form2-wrap clearfix" >
<form class="tourmaster-login-form2 tourmaster-form-field tourmaster-with-border" method="post" action="<?php echo esc_url(site_url('wp-login.php', 'login_post')); ?>">
	<h3 class="tourmaster-login-title"><?php esc_html_e('Already A Member?', 'tourmaster'); ?></h3>
	<div class="tourmaster-login-form-fields clearfix" >
		<p class="tourmaster-login-user">
			<label><?php echo esc_html__('Username', 'tourmaster'); ?></label>
			<input type="text" name="log" />
		</p>
		<p class="tourmaster-login-pass">
			 <label><?php echo esc_html__('Password', 'tourmaster'); ?></label>
			 <input type="password" name="pwd" />
		</p>
	</div>
	<?php do_action('login_form'); ?> 
	<p class="tourmaster-login-submit" >
		<input type="submit" name="wp-submit" class="tourmaster-button" value="<?php echo esc_html__('Sign In!', 'tourmaster'); ?>" />
	</p>
	<p class="tourmaster-login-lost-password" >
		<a href="<?php echo add_query_arg(array('source'=>'tm'), wp_lostpassword_url()); ?>" ><?php echo esc_html__('Forget Password?','tourmaster'); ?></a>
	</p>

	<input type="hidden" name="rememberme"  value="forever" />
	<input type="hidden" name="redirect_to" value="<?php 
		if( !empty($settings['redirect']) ){
			$redirect_url = tourmaster_get_template_url($settings['redirect']);
			$redirect_url = empty($redirect_url)? $settings['redirect']: $redirect_url;
			echo esc_url($redirect_url);
		}else{
			echo esc_url(add_query_arg(null, null)); 
		}	
	?>" />
	<input type="hidden" name="source"  value="tm" />
</form>

<div class="tourmaster-login2-right" >
	<h3 class="tourmaster-login2-right-title" ><?php esc_html_e('Don\'t have an account? Create one.', 'tourmaster'); ?></h3>
	<div class="tourmaster-login2-right-content" >
		<div class="tourmaster-login2-right-description" ><?php 
			esc_html_e('When you book with an account, you will be able to track your payment status, track the confirmation and you can also rate the tour after you finished the tour.', 'tourmaster');
		?></div>
		<a class="tourmaster-button" href="<?php 
			$register_url = tourmaster_get_template_url('register');
			if( !empty($settings['redirect']) ){
				$register_url = add_query_arg(array('redirect' => $settings['redirect']), $register_url);
			}else if( get_the_ID() ){
				$register_url = add_query_arg(array('redirect' => get_the_ID()), $register_url);
			}
			echo esc_url($register_url); 
		?>" ><?php 
			esc_html_e('Sign Up', 'tourmaster');
		?></a>
	</div>
	<?php if( !empty($settings['continue-as-guest']) ){ ?>
		<h3 class="tourmaster-login2-right-title" ><?php esc_html_e('Or Continue As Guest', 'tourmaster'); ?></h3>
		<a class="tourmaster-button" href="<?php echo tourmaster_get_template_url('payment'); ?>" ><?php esc_html_e('Continue As Guest', 'tourmaster'); ?></a>
	<?php } ?>
</div>
</div>
<?php
			if( !$echo ){
				$ret = ob_get_contents();
				ob_end_clean();

				return $ret;
			}
		} // tourmaster_get_login_form
	} 

	// registration form
	if( !function_exists('tourmaster_get_registration_form') ){
		function tourmaster_get_registration_form( $echo = true ){
			if( !$echo ){
				ob_start();
			}

			$profile_fields = array_merge(array(
				'username' => array(
					'title' => esc_html__('Username', 'tourmaster'),
					'type' => 'text',
					'required' => true
				),
				'password' => array(
					'title' => esc_html__('Password', 'tourmaster'),
					'type' => 'password',
					'required' => true
				),
				'confirm-password' => array(
					'title' => esc_html__('Confirm Password', 'tourmaster'),
					'type' => 'password',
					'required' => true
				),
			), tourmaster_get_profile_fields());

			echo '<form class="tourmaster-register-form tourmaster-form-field tourmaster-with-border" action="' . esc_url(tourmaster_get_template_url('register')) . '" method="post" >';

			echo '<div class="tourmaster-register-message" >';
			echo esc_html__('After creating an account, you\'ll be able to track your payment status, track the confirmation and you can also rate the tour after you finished the tour.', 'tourmaster');
			echo '</div>';

			echo '<div class="tourmaster-register-form-fields clearfix" >';
			foreach( $profile_fields as $slug => $profile_field ){
				if( !empty($profile_field['required']) ){
					$profile_field['slug'] = $slug;
					tourmaster_get_form_field($profile_field, 'profile');
				}
			}
			echo '</div>';

			echo '<input type="hidden" name="redirect" value="';
			if( !empty($_GET['redirect']) ){
				echo esc_attr($_GET['redirect']);
			}else if( !empty($_POST['redirect']) ){
				echo esc_attr($_POST['redirect']);
			}else{
				global $tourmaster_template;
				if( empty($tourmaster_template) ){
					echo add_query_arg(array());
				}
			}
			echo '" >';
			echo '<input type="submit" class="tourmaster-register-submit tourmaster-button" value="' . esc_html__('Sign Up', 'tourmaster') . '" />';
			
			$our_term = tourmaster_get_option('general', 'register-term-of-service-page', '#');
			$our_term = is_numeric($our_term)? get_permalink($our_term): $our_term; 
			$privacy = tourmaster_get_option('general', 'register-privacy-statement-page', '#');
			$privacy = is_numeric($privacy)? get_permalink($privacy): $privacy; 
			echo '<div class="tourmaster-register-term" >';
			echo sprintf(wp_kses(
				__('* Creating an account means you\'re okay with our <a href="%s" target="_blank">Terms of Service</a> and <a href="%s" target="_blank">Privacy Statement</a>.', 'tourmaster'), 
				array('a' => array( 'href'=>array(), 'target'=>array() ))
			), $our_term, $privacy);
			echo '</div>';

			echo '<input type="hidden" name="security" value="' . esc_attr(wp_create_nonce('tourmaster-registration')) . '" />';
			echo '</form>';

			echo '<div class="tourmaster-register-bottom" >';
			echo '<h3 class="tourmaster-register-bottom-title" >' . esc_html__('Already a member?', 'tourmaster') . '</h3>';
			echo '<a class="tourmaster-register-bottom-link" href="' . tourmaster_get_template_url('login') . '" >' . esc_html__('Login', 'tourmaster') . '</a>';
			echo '</div>';

			if( !$echo ){
				$ret = ob_get_contents();
				ob_end_clean();

				return $ret;
			}
		} // tourmaster_get_registration_form
	}

	// add wish list ajax
	add_action('wp_ajax_tourmaster_add_wish_list', 'tourmaster_ajax_add_wish_list');
	add_action('wp_ajax_nopriv_tourmaster_add_wish_list', 'tourmaster_ajax_add_wish_list');
	if( !function_exists('tourmaster_ajax_add_wish_list') ){
		function tourmaster_ajax_add_wish_list(){

			if( is_user_logged_in() && !empty($_POST['tour-id']) ){
				global $current_user;
				
				$wish_list = get_user_meta($current_user->ID, 'tourmaster-wish-list', true);
				$wish_list = empty($wish_list)? array(): $wish_list;

				if( !in_array($_POST['tour-id'], $wish_list) ){
					$wish_list[] = $_POST['tour-id'];
					update_user_meta($current_user->ID, 'tourmaster-wish-list', $wish_list);
				}
			}

			die(json_encode($_POST));
		} // tourmaster_ajax_add_wish_list
	}