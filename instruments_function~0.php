<?php
add_filter('use_block_editor_for_post', '__return_false', 10);

//Front CSS 
function add_css_fron(){
	wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/bootstrap/css/bootstrap.min.css' );
	wp_enqueue_style( 'theme-css', get_stylesheet_directory_uri() . '/css/theme-css.css' );
	wp_enqueue_style( 'select-css', 'https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css');
}
add_action( 'wp_enqueue_scripts', 'add_css_fron' );

//Front JS
function add_js_front() {
	wp_dequeue_script( 'wppayform_public' );
	wp_enqueue_script( 'proper-js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js');
	wp_enqueue_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/bootstrap/js/bootstrap.min.js',  array( 'jquery' ));
	wp_enqueue_script( 'select-js', 'https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js');
	wp_enqueue_script( 'wppayform_public', get_stylesheet_directory_uri() . '/js/custom-pay.js');
	wp_localize_script('wppayform_public', 'wp_payform_' . $form->ID, apply_filters('wppayform/checkout_vars', array(
		'form_id'              => $form->ID,
		'checkout_description' => $form->post_title,
		'currency_settings'    => $currencySettings,
	), $form));
	wp_enqueue_script( 'maskjs', get_stylesheet_directory_uri() . '/js/jquery.mask.js');  
	wp_enqueue_script( 'cusom-js', get_stylesheet_directory_uri() . '/js/custom.js');
	wp_localize_script( 'cusom-js', '_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));    

}

function my_enqueue($hook) {
    // Only add to the edit.php admin page.
    // See WP docs.
    // if ('edit.php' !== $hook) {
    //     return;
    // }
    
    wp_enqueue_script( 'cusom-js', get_stylesheet_directory_uri() . '/js/custom.js');
	wp_localize_script( 'cusom-js', '_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
	
}

add_action('admin_enqueue_scripts', 'my_enqueue');

add_action( 'wp_footer', 'add_js_front' );
//Front CSS and JS
function commonJS_CSS(){

}

//Register Postypes

function book_setup_post_type() {
    $args = array(
        'public'    => true,
        'label'     => __( 'Districts', 'textdomain' ),
        'menu_icon' => 'dashicons-admin-home',
    );
    register_post_type( 'districts', $args );
	$args = array(
        'public'    => true,
		'label'     => __( 'Orders', 'textdomain' ),
		'supports'	=> array( 'title')
    );
    register_post_type( 'orders', $args );

}
add_action( 'init', 'book_setup_post_type' );

//Add Form
function booking_form(){
	?>
	<div class="booking-form">
		<div id="booking" action="">
			<?php  get_template_part('booking', 'form');?>
		</div>	
	</div>
	<?php
}
add_shortcode('booking','booking_form');

function update_instruments(){
	session_start();

	$POSTID         		= 	$_POST['post_id'];
	$_SESSION['post_ID']	=	$_POST['post_id'];	
	
	//$INSTRUMENTS    = get_field( "instrument", $POSTID );
    $SESSIONS       = get_field( "sessions", $POSTID );
    $JSON_DATA      = array();
	
	$gropu_violin 	= get_field('violin', $POSTID);
	$gropu_viola 	= get_field('viola', $POSTID);
	$gropu_cello 	= get_field('cello', $POSTID);

	$e_e_book 			= get_field('essential_elements_', $POSTID);
	$suzuki_book 		= get_field('suzuki_book_', $POSTID);
	$event_shooulder 	= get_field('everest_shoulder_rest', $POSTID);
	$first_things_first = get_field('first_things_first', $POSTID);
	$music_stand 		= get_field('music_stand', $POSTID);

	//Require Book
	$RB_essential_elements_ = get_field('RB_essential_elements_', $POSTID);
	$RB_essential_elements_2 = get_field('RB_essential_elements_2', $POSTID);

	//String Book
	$string_basics_book 		= get_field('string_basics_book', $POSTID);

	$ITESM_ARRAY 	=	array();
	$SIZE_ARRAY		=	array();
	$RENT_ARRAY		=	array();
	$RENT_TITLE		=	array();
	$RENT_INS		=	array();

	$OPTIONALS 		= array();
	$REQUIRE_BOOK 	= array();


	// extra optionsls created at 07-04-2021
	$EXTRA_OPTS = get_field('extra_optionals', $POSTID);


	// if($_POST['rule'] == 'update_district'){
	// 	$DISTRICT_ARRAY = array();

	// 	$args = array(
	// 		'post_type'			=> 'districts',
	// 		'order'    			=> 'ASC',
	// 		'posts_per_page'	=> -1
	// 	); 
	// 	$the_query = new WP_Query( $args );
	// 	//echo '<option value="0">Select District </option>';
	// 	if($the_query->have_posts() ) : 
	// 		while ( $the_query->have_posts() ) : $the_query->the_post(); 
	// 				$DISTRICT_ARRAY[] = array('id' => get_the_ID(), 'value' => get_the_title());	
	// 		endwhile;
	// 	else: 
		
	// 	endif;
	// 	$JSON_DATA['districts'] = $DISTRICT_ARRAY;
	// 	$obj =  json_encode($JSON_DATA);
	// 	echo $obj;
	// 	die;
		
	// }


	if($_POST['rule'] == 'update_size_terms'){
		$ints 	= 	$_POST['data_value'];
		$ITEM	=	get_field($ints, $POSTID);
		//print_r($ITEM);
		//get size by item
		if($ITEM['sizes']):
			foreach($ITEM['sizes'] as $size):
				$SIZE_ARRAY[] = $size;
			endforeach;
		endif;
		// get size term by item
		if($ITEM['rent_terms']):
			foreach($ITEM['rent_terms'] as $t_term):
				$RENT_ARRAY[]	= 	array('tern_name' => $t_term['term_name'], 'term_value' => $t_term['title'] ) ;
				$RENT_TITLE[]	=	$t_term['title'];
			endforeach;

			$RENT_INS[] =  $ITEM['instruction'];
		endif;		

		if($_POST['size_val']) {
			$sizes_aarray = $ITEM['sizes_with_terms'];
			
			if($sizes_aarray) :
				
				foreach($sizes_aarray as $SA) :
					if($_POST['size_val'] == $SA['size'] ){
						$RENT_TITLE = array();
						$RENT_ARRAY = array();
					

						$RENT_ARRAY[]	= 	array('tern_name' =>$SA['term_name'], 'term_value' => $SA['title'] ) ;
						$RENT_TITLE[]	=	$SA['title'];
						if($SA['instruction']) :
							$RENT_INS = array(); 
							$RENT_INS[] 	=  	$SA['instruction'];
						else:

						endif;
					}
				endforeach;
			endif;
			
			$instrument = $_POST['data_value'];
			
			if($EXTRA_OPTS) :
				$SIZE_OPTIONS = array();
				$size_array = '';
				foreach($EXTRA_OPTS as $key =>  $EXOP):
					
					if($EXOP['choose_instrument'] == 'All'){
						array_push($SIZE_OPTIONS, array('name'=> $EXOP['option_name'], 'price'=> $EXOP['price'], 'arryaof' => 's_'.$instrument, 'acf_feild' => 'extra_optionals' )) ;
					}
										
					if($instrument == strtolower($EXOP['choose_instrument']) ) :
						$keyname = strtolower('s_'.$EXOP['choose_instrument']);
						$size_array = $EXOP[$keyname]; 
						if(in_array($_POST['size_val'], $size_array)) {
							array_push($SIZE_OPTIONS, array('name'=> $EXOP['option_name'], 'price'=> $EXOP['price'], 'arryaof' => 's_'.$instrument, 'acf_feild' => 'extra_optionals' )) ;
						}
					endif;
				endforeach;
			endif;
		}
		$JSON_DATA['sizes'] 	= $SIZE_ARRAY;
		$JSON_DATA['rterm'] 	= $RENT_ARRAY;
		$JSON_DATA['title'] 	= $RENT_TITLE;
		$JSON_DATA['extra_optionals'] 	= $SIZE_OPTIONS;
		$JSON_DATA['term_ins'] 	= $RENT_INS;
		$obj =  json_encode($JSON_DATA);
		echo $obj;
		die;
	}
	
	if($_POST['rule'] == 'changedistrict'){
		// Get all session which exist in distric
		if($SESSIONS):
		$SESSIONS_ARRAY = array();
			foreach($SESSIONS as $SNAME) :
				if($SNAME == 'Other'){
					$SNAME = 'Other - Call House of Note To Reserve Instrument';
				}
				$SESSIONS_ARRAY[] = $SNAME; 
			endforeach;
		endif;


		//get all items which are exist in posts
		// var_dump($gropu_violin);
		// die;
		if($gropu_violin['available'] == 'Yes'):
			$ITESM_ARRAY[] = 'violin';
			//get default sizes
			if($gropu_violin['sizes']):
				foreach($gropu_violin['sizes'] as $size):
					$SIZE_ARRAY[] = $size;
				endforeach;
			endif;
			// get default rent terms
			if($gropu_violin['rent_terms']):
				foreach($gropu_violin['rent_terms'] as $t_term):
					//$RENT_ARRAY[] 	= 	$t_term['term_name'];
					$RENT_ARRAY[]	= 	array('tern_name' => $t_term['term_name'], 'term_value' => $t_term['title']) ;
					$RENT_TITLE[]	=	$t_term['title'];
				endforeach;
				$RENT_INS[] =  $gropu_violin['instruction'];
			endif;

		endif;

		if($gropu_viola['available'] == 'Yes'):
			$ITESM_ARRAY[] = 'viola';
		endif;
		if($gropu_cello['available'] == 'Yes'):
			$ITESM_ARRAY[] = 'cello';
		endif;
		

		if($e_e_book['available'][0] == '1'):
			$OPTIONALS['essential_elements_'] = array('name'=> 'Essential Elements Book 1', 'price'=> $e_e_book['price'] );
		endif;
		if($suzuki_book['available'][0] == '1'):
			$OPTIONALS['suzuki_book_'] = array('name'=> 'Suzuki Book', 'price'=> $suzuki_book['price']. ' For Bailey and Liberty Ridge' );
		endif;
		if($event_shooulder['available'][0] == '1'):
			$OPTIONALS['everest_shoulder_rest'] = array('name'=> 'Everest Shoulder Rest', 'price'=> $event_shooulder['price'] );
		endif;
		if($first_things_first['available'][0] == '1'):
			$OPTIONALS['first_things_first'] = array('name'=> 'First Things First', 'price'=> $first_things_first['price'] );
		endif;
		if($music_stand['available'][0] == '1'):
			$OPTIONALS['music_stand'] = array('name'=> 'Music Stand', 'price'=> $music_stand['price'], 'colors'=> $music_stand['color']);
		endif;

		if($RB_essential_elements_['available'][0] == '1'):
			$REQUIRE_BOOK['RB_essential_elements_'] = array('name'=> 'Essential Elements Book 1', 'price'=> $RB_essential_elements_['price'] );
		endif;

		if($RB_essential_elements_2['available'][0] == '1'):
			$REQUIRE_BOOK['RB_essential_elements_2'] = array('name'=> 'Essential Elements Book 2', 'price'=> $RB_essential_elements_2['price'] );
		endif;


		if($string_basics_book['available'][0] == '1'):
			$OPTIONALS['string_basics_book'] = array('name'=> 'String Basics Book ', 'price'=> $string_basics_book['price'] );
		endif;



			
		// if extra
		if($EXTRA_OPTS):
			$EXTRA_OPTIONALS = array();
			foreach($EXTRA_OPTS as $key => $EX_OP):
				if($EX_OP['available'][0] == '1'):
					array_push($EXTRA_OPTIONALS, array('name' => $EX_OP['name'], 'price' => $EX_OP['price']));
				endif;
			endforeach;
			//$OPTIONALS['EXTRA_OPTIONALS'] 	= $EXTRA_OPTIONALS;
		endif;

	
		$JSON_DATA['session'] 	= $SESSIONS_ARRAY;
		$JSON_DATA['items'] 	= $ITESM_ARRAY;
		$JSON_DATA['sizes'] 	= $SIZE_ARRAY;
		$JSON_DATA['rterm'] 	= $RENT_ARRAY;
		$JSON_DATA['term_ins'] 	= $RENT_INS;
		$JSON_DATA['title'] 	= $RENT_TITLE;
		$JSON_DATA['postid'] 	= $POSTID;
		$JSON_DATA['post_title'] 	= get_the_title($POSTID);
		$JSON_DATA['optional'] 	= $OPTIONALS;
		
		$JSON_DATA['require_book'] 	= $REQUIRE_BOOK;

		$obj =  json_encode($JSON_DATA);
		echo $obj;
		die;
	}
	
	if($_POST['rule'] == 'get_price') {
		$feildname 	= 	$_POST['instruments'];
	
		$tername 	= 	$_POST['terms'];
		$total = 0;
		$feild_info	= get_field($feildname, $POSTID);
		$TAX_AMOUNT	= get_field('tax_amoount', $POSTID);
		
		
		
		foreach($feild_info['rent_terms'] as $FI):
			
			if($FI['title'] ==  $tername):
				$price 		= 	number_format($FI['price'], 2);
				//$tax 		= 	number_format($FI['tax'], 2 );
				$insurance 	= 	$FI['insurance'];
				$title 		=	$FI['title'];

			endif;
		endforeach;
		
		if($feild_info['sizes_with_terms']) {
			// $SD = Size Data
			foreach($feild_info['sizes_with_terms'] as $SD) :
				if($SD['title'] == $tername) {
					$price 		= 	number_format($SD['price'], 2);
					//$tax 		= 	number_format($FI['tax'], 2 );
					$insurance 	= 	$SD['insurance'];
					$title 		=	$SD['title'] .' - ' .$SD['size'] ;
					
				}
			endforeach;
		}

		$optname = array();
		
		if($_POST['arroff']):
			$sizes_added = array();
			foreach($_POST['arroff'] as $arrayoff) {
				$instrument = $_POST['instruments'];
				$EXTRA_OPTS = get_field('extra_optionals', $POSTID);
				
				foreach($EXTRA_OPTS as $key =>  $EXOP):
					$SIZE_OPTIONS = array();
					$size_array = '';
					
					if($instrument == strtolower($EXOP['choose_instrument']) || $EXOP['choose_instrument'] == 'All'  ) :
						$keyname = strtolower('s_'.$EXOP['choose_instrument']);
						$size_array = $EXOP[$keyname]; 
						if(in_array($_POST['currentsize'], $size_array) && $arrayoff == $EXOP['option_name'] || $EXOP['choose_instrument'] == 'All' &&  $arrayoff == $EXOP['option_name']) {
						//	echo $EXOP['option_name'].'=>'. $EXOP['price'];
							//array_push($SIZE_OPTIONS, array('name'=> $EXOP['option_name'], 'price'=> $EXOP['price'], 'arryaof' => 's_'.$instrument, 'acf_feild' => 'extra_optionals' )) ;
							$optname[] = array('opt_price'=> $EXOP['price'], 'opt_name' => $EXOP['option_name'] );
							$opt_prie += $EXOP['price'];
						}
					endif;
				endforeach;

			}

		endif;

		if($_POST['optname']) {
			
			foreach($_POST['optname']  as $key => $OPT) :
				$options = get_field($OPT, $POSTID);
				$opt_prie += $options['price'];
				if($OPT == 'essential_elements_'):
					$optname[] = array('opt_price'=> $options['price'], 'opt_name' => 'Essential Elements Book');
				endif;
				if($OPT == 'music_stand'):
					$optname[] = array('opt_price'=> $options['price'], 'opt_name' => 'Music Stand');
				endif;

				if($OPT == 'RB_essential_elements_'):
					$optname[] = array('opt_price'=> $options['price'], 'opt_name' => 'Essential Elements Book 1' , 'type' => 'reuirebook' );
				endif;

				if($OPT == 'RB_essential_elements_2'):
					$optname[] = array('opt_price'=> $options['price'], 'opt_name' => 'Essential Elements Book 2', 'type' => 'reuirebook');
				endif;

				if($OPT == 'string_basics_book'):
					$optname[] = array('opt_price'=> $options['price'], 'opt_name' => 'String Basics Book', );
				endif;
				

				
			endforeach;

			$extraprice = round($opt_prie, 2);
		}
		
		

		
        $tax = $TAX_AMOUNT;
        //echo $price + $extraprice + $insurance;
		
		$totalTax = number_format(($tax / 100) * ($price + $extraprice ),2);
		$total = $price + $totalTax + $insurance;
		
		

		$JSON_DATA['name'] 		= $feildname;
		$JSON_DATA['term'] 		= $tername;
		$JSON_DATA['title']		= $title;
		$JSON_DATA['price'] 	= ($price 		!= '' ? number_format($price, 2) 		: 0);
		

		$JSON_DATA['tax'] 			= ($totalTax	!= '' ? $totalTax	: 0);
		$JSON_DATA['insurance']		= ($insurance 	!= '' ? $insurance 	: 0);
		$JSON_DATA['options']		= ($extraprice 	!= '' ? number_format($extraprice, 2) : 0);
		$JSON_DATA['options_name']	= $optname;
		$JSON_DATA['total']			= $total += $extraprice;
		$JSON_DATA['postid'] 		=  $POSTID;
		$obj =  json_encode($JSON_DATA);
		echo $obj;
		die;
	}

	if($_POST['rule'] == 'add_optionals') {
		echo 'yes';
		die;
	}

	die;   
}
add_action("wp_ajax_update_instruments", "update_instruments");
add_action("wp_ajax_nopriv_update_instruments", "update_instruments");


// function wpf_submit_form_custom(){
	
	
// }

// add_action("wp_ajax_wpf_submit_form_custom", "wpf_submit_form_custom");
// add_action("wp_ajax_nopriv_wpf_submit_form_custom", "wpf_submit_form_custom");

function email_to_customer(){
	

	

	$orderID = $_POST['post_id'];
	$admin_email = get_option('admin_email');
	$hash = get_post_meta($orderID,'payment_information_submission_hash');
	$hash = $hash[0];
	$submission = wpPayFormDB()->table('wpf_submissions')->where('submission_hash', '=', $hash)->first();
	//$submission->form_data_raw = maybe_unserialize($submission->form_data_raw);
    $submission->form_data_formatted = maybe_unserialize($submission->form_data_raw);

	$newdate	=	date_create($submission->form_data_formatted['created_at']);
	
	$useremail = get_post_meta($orderID, 'sudent_information_email', true  );

	$total += $submission->form_data_formatted['custom_payment_input'] + $submission->form_data_formatted['custom_payment_input_1'] +$submission->form_data_formatted['custom_payment_input_2'] +$submission->form_data_formatted['custom_payment_input_3'];
	$to = $useremail;
	$subject = 'Your Instrument is reserved';
	$body = '<table width="700" style="margin:0 auto">
		<tr>
			<td width="50%"><img src="'.get_stylesheet_directory_uri().'/images/hoseofnote.jpg" width="100%"/></td>
			<td>
				<h3 style="margin: 10px 0;">Customer Name:'.$submission->form_data_formatted['hidden_input_9'].' '.$submission->form_data_formatted['hidden_input_10'].'</h3>
				<h3 style="margin: 10px 0;">Your Receipt from House of Note </h3>
				<p style="margin: 10px 0;">Recipt ID: '.$submission->form_data_formatted['submission_hash'].' '.date_format($newdate,"M d, Y h:i:s A").'</p>
			</td>
		</tr>
		<tr>
			<td colspan="2"><hr style="border: 1px solid #000;"></td>
		</tr>
	</table>
	<table width="700" style="margin:0 auto">
		<!---->
		<tr>
		<td><h3 style="margin: 10px 0;">Order Reply</h3></td>
		</tr>
		<tr>
			<td>
				<table width="80%">
					<tr>
						<td style=" font-size: 16px;font-weight: bold;">'.$_POST['message'].'</td>
					</tr>
				</table>
			</td>
		</tr>
		<!---->
		<tr>
			<td>
				<h3 style="margin: 10px 0;">Terms and Condition: Apply</h3>';
			
				$my_id = 325;
				$post_id_5369 = get_post($my_id);
				$content = $post_id_5369->post_content;
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]>', $content);
				$body .= $content;
				$body .= '
			</td>
		</tr>
		<!-- -->
		<tr><td><hr></td></tr>
		<tr>
			<td align="center"><p style="margin-top: 10px;">Have additional questions? Give us a call at <a style="color: blue; font-weight: bold;" href="tel:9529290026">952-929-0026</a> <br> or send us a note to  <a style="color: blue; font-weight: bold;" href="mailto:info@houseofnote.com">info@houseofnote.com</a></p></td>
		</tr>
		<tr> 
			<td align="center">
				<a href="tel:9529290026" style="margin: 20px 10px 0; display: inline-flex; align-items: center; text-decoration: none; font-weight: bold;color: blue;"><span style="line-height: normal; padding: 5px 0;">952-929-0026</span></a>  
				<a href="mailto:info@houseofnote.com" style="margin: 0 10px; display: inline-flex; align-items: center; text-decoration: none; font-weight: bold;color: blue;">span style="line-height: normal; padding: 5px 0;"> info@houseofnote.com</span></a>
			</td>
		</tr>
	</table>';
	$headers = array('Content-Type: text/html; charset=UTF-8');
	wp_mail( $to, $subject, $body, $headers );
	echo "111";
	exit;
}

add_action("wp_ajax_email_to_customer", "email_to_customer");
add_action("wp_ajax_nopriv_email_to_customer", "email_to_customer");


add_action("wp_ajax_get_customer", "get_customer");
add_action("wp_ajax_nopriv_get_customer", "get_customer");

function get_customer()
{
    global $wpdb;

	/* Get Stripe API Key */
	$getKey = get_option( 'wppayform_stripe_payment_settings' );

	if( $getKey['live_pub_key'] ) {
	    $secretKey = $getKey['live_secret_key'];
	} else {
	    $secretKey = $getKey['test_secret_key'];
	}
    require_once(get_theme_root().'/music-instruments/stripe-php/init.php');
    \Stripe\Stripe::setApiKey($secretKey);
    
    /* Check customer key */
    $checkCustomer = $wpdb->get_results("SELECT * FROM wprv_wpf_customers WHERE email = '".$_POST['email']."'");

    if( !$checkCustomer ) {
        
        /* Insert New Customer */
        $createCustomer = \Stripe\Customer::create([
          "email" =>  $_POST['email'],
          "name" => $_POST['name'],
          "phone"=> $_POST['phone'],
        ]);

        $data = array(
            'email' => $_POST['email'],
            'customer_key' => $createCustomer->id,
            'created' => date('Y-m-d H:i:s')
            );
        $insertCustomerData = $wpdb->insert("wprv_wpf_customers",$data);
        if( $insertCustomerData )
        {
            $key = $createCustomer->id;
        }
    } else {
        $key = $checkCustomer[0]->customer_key;
    }
    
    if( $getKey['live_pub_key'] ) {
        echo "https://dashboard.stripe.com/customers/".$key;
    } else {
        echo "https://dashboard.stripe.com/test/customers/".$key;
    }
    exit;
}

function get_thankyou(){

	session_start();

    global $wpdb;


	$hash = $_GET['wpf_submission'];
	$submission = wpPayFormDB()->table('wpf_submissions')->where('submission_hash', '=', $hash)->first();
	//$submission->form_data_raw = maybe_unserialize($submission->form_data_raw);
    $submission->form_data_formatted = maybe_unserialize($submission->form_data_raw);
	
	$elements = get_post_meta($submission->form_id, 'wppayform_paymentform_builder_settings', true);
	if (!$elements) {
		return array();
	}
	$inputValues = $submission->form_data_formatted;
	$add_order = get_post_meta( $submission->id, 'order_post', true );

	//$add_order = $wpdb->get_results( "SELECT * FROM wp_wpf_order_items WHERE submission_id = $submission->id" );



	// echo '<pre>';
	// 	var_dump($submission->form_data_formatted);
	// echo '</pre>';

	// die;
	if($add_order) :
		echo '<div id="thanksyou">
				<h3>Your Instrument Has Been Reserved!</h3>
				<span class="mark"></span>
				<p>Thank you for placing your order with House of Note. A receipt of your order is on its way to your inbox and the instrument will be available at the designated school on the first day of the selected session. </p>
				<p>If your player is part of the Minnetonka or Edina school districts, please call House of Note at (952)-929-0026 for instrument pick-up time one week before the start of the selected session.</p>
		</div>';
	else:

		$add_post = array(
			'post_title'    => strtoupper( $inputValues['hidden_input_3'] ),
			'post_content'  => '',
			'post_status'   => 'publish',
			'post_author'   => '',
			'post_type'		=> 'orders',
		);

		$orderID = wp_insert_post( $add_post );
		//$orderID = 334;
		if($orderID) {
			$student_information 			= 'sudent_information_';
			$instrument_reuest_information 	= 'instrument_reuest_information_';
			$payment_information 			= 'payment_information_';
			//$district = get_the_title($submission->form_data_formatted['hidden_input']);
			//$district = $submission->form_data_formatted['hidden_input_19'];

			$district = $submission->form_data_formatted['hidden_input'];
			 

			$text = $submission->form_data_formatted['hidden_input_6'];
			//$post_d_id = $submission->form_data_formatted['hidden_input'];
			
			$post_d_id = $_SESSION['post_ID'];
			
			$options_array = explode(',', $text );
			update_post_meta( $orderID, 'order_submission', $submission->id);
			
			update_post_meta( $orderID, $instrument_reuest_information.'instrument_type', 	$submission->form_data_formatted['hidden_input_3']);
			update_post_meta( $orderID, $instrument_reuest_information.'size', 			$submission->form_data_formatted['hidden_input_4']);
			update_post_meta( $orderID, $instrument_reuest_information.'term', 			$submission->form_data_formatted['hidden_input_5']);
			update_post_meta( $orderID, $instrument_reuest_information.'optionlas_accessories', $submission->form_data_formatted['hidden_input_6']);
			update_post_meta( $orderID, $instrument_reuest_information.'colors', $submission->form_data_formatted['hidden_input_20']);

			update_post_meta( $orderID, $student_information.'student_district', 	$district);
			update_post_meta( $orderID, $student_information.'student_attendance',	$submission->form_data_formatted['hidden_input_1']);
			update_post_meta( $orderID, $student_information.'session', 		$submission->form_data_formatted['hidden_input_2']);
			update_post_meta( $orderID, $student_information.'order_owner', 			$submission->form_data_formatted['hidden_input_7']);
			update_post_meta( $orderID, $student_information.'student_first_name', 		$submission->form_data_formatted['hidden_input_9']);
			update_post_meta( $orderID, $student_information.'student_last_name', 		$submission->form_data_formatted['hidden_input_10']);
			update_post_meta( $orderID, $student_information.'student_p_fn', 	$submission->form_data_formatted['hidden_input_4']);
			update_post_meta( $orderID, $student_information.'student_p_ln', 	$submission->form_data_formatted['hidden_input_8']);
			update_post_meta( $orderID, $student_information.'address',			$submission->form_data_formatted['hidden_input_11']);
			update_post_meta( $orderID, $student_information.'phone',			$submission->form_data_formatted['hidden_input_15']);
			update_post_meta( $orderID, $student_information.'email', 			$submission->customer_email);
			
			update_post_meta( $orderID, $payment_information.'order_currency', 	$submission->currency);
			update_post_meta( $orderID, $payment_information.'payment_status', 	$submission->payment_status);
			update_post_meta( $orderID, $payment_information.'amount', 			$submission->form_data_formatted['hidden_input_17']);
			update_post_meta( $orderID, $payment_information.'payment_method', 	$submission->payment_method);
			update_post_meta( $orderID, $payment_information.'submission_hash', 	$submission->submission_hash);
			update_post_meta( $orderID, $payment_information.'order_commnts', 	$submission->form_data_formatted['textarea']);
			
			update_post_meta( $orderID, $payment_information.'card_no', 	'date');
			update_post_meta( $orderID, $payment_information.'date', 			date('Y-m-d',strtotime($submission->created_at)));
			update_post_meta( $orderID, $payment_information.'time', 			date('H:i:s',strtotime($submission->created_at)));
			update_post_meta( $orderID, $payment_information.'address',			$submission->form_data_formatted['hidden_input_11']);
			update_post_meta( $orderID, $payment_information.'phone',			$submission->form_data_formatted['hidden_input_15']);
			update_post_meta( $orderID, $payment_information.'email', 			$submission->customer_email);

			update_post_meta( $orderID, $payment_information.'instrument_price',	$submission->form_data_formatted['custom_payment_input']);
			update_post_meta( $orderID, $payment_information.'tax_amount', 			$submission->form_data_formatted['custom_payment_input_1']);
			update_post_meta( $orderID, $payment_information.'optional_amount',		$submission->form_data_formatted['custom_payment_input_2']);
			
			if($post_d_id == '248' || $post_d_id == '443') {
				update_post_meta( $orderID, $payment_information.'insurance_amount',	'Included First 3 Months');
			}else{
				update_post_meta( $orderID, $payment_information.'insurance_amount',	$submission->form_data_formatted['custom_payment_input_3']);
			}

			update_post_meta( $orderID, 'customer_message',	$submission->form_data_formatted['textarea']);

			update_post_meta( $submission->id, 'order_post_check', $orderID);
			$my_post = array(
				'ID'           => $orderID,
				'post_title'   => 'ORDER-'.$orderID,
			);
			wp_update_post( $my_post );
			$admin_email = get_option('admin_email');
			$newdate	=	date_create($submission->form_data_formatted['created_at']);
			
			$useremail = get_post_meta($orderID, 'sudent_information_email', true  );
			
			/* Get Stripe API Key */
			$getKey = get_option( 'wppayform_stripe_payment_settings' );

			if( $getKey['live_pub_key'] ) {
			    $secretKey = $getKey['live_secret_key'];
			} else {
			    $secretKey = $getKey['test_secret_key'];
			}
			

            /* Stripe Payment */
            $getChargeId = $wpdb->get_results( "SELECT charge_id FROM wprv_wpf_order_transactions WHERE submission_id = $submission->id" );
            require_once(get_theme_root().'/music-instruments/stripe-php/init.php');
            \Stripe\Stripe::setApiKey($secretKey);

            /* Retrieve Charge id of order */
            $retrieve = \Stripe\Charge::retrieve(
             $getChargeId[0]->charge_id
            );
            
            /* Check customer key */
            $checkCustomer = $wpdb->get_results("SELECT * FROM wprv_wpf_customers WHERE email = '".$submission->customer_email."'");

            $key = $checkCustomer[0]->customer_key;
            
            /* Update Charge id of order */
            $update = \Stripe\Charge::update(
             $getChargeId[0]->charge_id,
             [ 
                 'customer' => $key
             ]
            );

			$total += $submission->form_data_formatted['custom_payment_input'] + $submission->form_data_formatted['custom_payment_input_1'] +$submission->form_data_formatted['custom_payment_input_2'] + $submission->form_data_formatted['custom_payment_input_3'];
			
			$line_item += $submission->form_data_formatted['custom_payment_input'] + $submission->form_data_formatted['custom_payment_input_2'];
			
			$to = $useremail;
    		$subject = 'Your instrument is reserved';
    		$body = '<table width="700" style="margin:0 auto">
				<tr>
					<td width="50%"><img src="https://nsiteinc.com/images/houseofnote.png" width="100%"/></td>
					<td>
						<h3 style="margin: 10px 0;">Customer Name: <br>'.$submission->form_data_formatted['hidden_input_9'].' '.$submission->form_data_formatted['hidden_input_10'].'</h3>
						<h3 style="margin: 10px 0;">Your Receipt from House of Note</h3>
						<p style="margin: 10px 0;">Receipt ID: '.$submission->form_data_formatted['submission_hash'].' '.date_format($newdate,"M d, Y h:i:s A").'</p>
					</td>
				</tr>
				<tr>
					<td colspan="2"><hr style="border: 1px solid #000;"></td>
				</tr>
			</table>
			<table width="700" style="margin:0 auto">
				<!---->
				<tr>
				<td><h3 style="margin: 10px 0;">Order Details</h3></td>
				</tr>
				<tr>
					<td>
						<table width="80%">
							<tr>
								<td style="font-size: 16px; color: blue;font-weight:bold;">'.$submission->form_data_formatted['hidden_input_5'].'</td>
								<td align="right" style=" font-size: 16px;font-weight: bold;">$'.$submission->form_data_formatted['custom_payment_input'].'</td>
							</tr>
							<tr><td>&nbsp;</td></tr>';
							
								$totaltax =  $submission->form_data_formatted['custom_payment_input_1'] * 100 / $line_item;
									$body .=' <tr>
										<td style="font-size: 16px; color: blue;font-weight:bold;">Tax ('.number_format($totaltax, 2).'%)</td>
										<td align="right" style=" font-size: 16px;font-weight: bold;">$'.$submission->form_data_formatted['custom_payment_input_1'].'</td>
									</tr>';
							

						$body .='<tr><td>&nbsp;</td></tr>';
						if($post_d_id == '248' || $post_d_id == '443') {
							$body .=' <tr>
								<td style="font-size: 16px; color: blue;font-weight:bold;">Insurance</td>
									<td align="right" style=" font-size: 16px;font-weight: bold;">Included First 3 Months</td>
								</tr>';
						}else{
							$body .= '<tr>
							<td style="font-size: 16px; color: blue;font-weight:bold;">Insurance</td>
							<td align="right" style=" font-size: 16px;font-weight: bold;">$'.$submission->form_data_formatted['custom_payment_input_3'].'</td>
						</tr>';
						}
						
							
						$body .= '<tr><td>&nbsp;</td></tr>';
							foreach($options_array as $OPT) :
								$options = get_field($OPT, $post_d_id);
								if($OPT == 'essential_elements_'):
								$body .= '<tr>
									<td style="font-size: 16px; color: blue;font-weight:bold;">Essential Elements Book </td>
									<td align="right" style=" font-size: 16px;font-weight: bold;">$'.$options['price'].'</td>
								</tr>';
								$body .= '	<tr><td>&nbsp;</td></tr>';
								endif;
								
								if($OPT == 'music_stand'):
									$body .= '<tr>
										<td style="font-size: 16px; color: blue;font-weight:bold;">Music Stand</td>
										<td align="right" style=" font-size: 16px;font-weight: bold;">$'.$options['price'].'</td>
									</tr>';
									$body .= '	<tr><td>&nbsp;</td></tr>';
								endif;


							
							endforeach;

				$body .= '	<tr><td>&nbsp;</td></tr>
							<tr>
								<td style="font-size: 16px; color: blue;font-weight:bold;"><strong>Total</strong></td>
								<td align="right" style=" font-size: 16px;font-weight: bold;">$'.number_format($total, 2).'</td>
							</tr>
						</table>
					</td>
				</tr>
				<!---->
				<tr><td><hr></td></tr>
				<tr>
					<td><h3 style="margin: 10px 0;">Payment</h3></td>
				</tr>
				<tr>
					<td>
						<table width="80%">
							<tr>
								<td style="font-size: 16px; color: blue;font-weight:bold;">VISA **** '.$retrieve->payment_method_details->card->last4.'</td>
								<td style=" font-size: 16px;font-weight: bold;" align="right">$'.number_format($total, 2) .'</td>
							</tr>
							<tr>
								<td colspan="2">'.$submission->form_data_formatted['submission_hash'].' '.date_format($newdate,"M d, Y h:i:s A").'</td>
							</tr>
						</table>
					</td>
				</tr>
				<!---->
				<tr><td><hr></td></tr>
				<tr>
					<td>
						<table width="80%">
							<tr>
								<td><h3 style="margin: 10px 0;">Amount Paid</h3></td>
								<td style=" font-size: 16px;font-weight: bold;" align="right">$'.number_format($total, 2).'</td>
							</tr>
						</table>
				</td>     
				</tr>
				<!---->
				<tr><td><hr></td></tr>
				<tr>
					<td>';
					 
						$my_id = 325;
						$post_id_5369 = get_post($my_id);
						$content = $post_id_5369->post_content;
						$content = apply_filters('the_content', $content);
						$content = str_replace(']]>', ']]>', $content);
						$body .= $content;
						$body .= '
					</td>
				</tr>
				<!-- -->
				<tr><td><hr></td></tr>
				<tr>
					<td align="center"><p style="margin-top: 10px;">Have additional questions? Give us a call at <a style="color: blue; font-weight: bold;" href="tel:9529290026">952-929-0026</a> <br> or send us a note to  <a style="color: blue; font-weight: bold;" href="mailto:info@houseofnote.com">info@houseofnote.com</a></p></td>
				</tr>
			</table>';
			$headers = array('Content-Type: text/html; charset=UTF-8');
			
			// echo $body;

			// die;
			wp_mail( $to, $subject, $body, $headers );
			
		}
	
endif; 
	
	if($submission->payment_status == 'paid'):
		echo '<div id="thanksyou">
				<h3>Your Instrument Has Been Reserved!</h3>
				<span class="mark"></span>
				<p>Thank you for placing your order with House of Note. A receipt of your order is on its way to your inbox and the instrument will be available at the designated school on the first day of the selected session. </p>
				<p>If your player is part of the Minnetonka or Edina school districts, please call House of Note at (952)-929-0026 for instrument pick-up time one week before the start of the selected session.</p>
		</div>';



	endif;
}
add_shortcode('thankyou','get_thankyou');


add_filter( 'manage_edit-orders_columns', 'my_edit_movie_columns' ) ;

function my_edit_movie_columns( $columns ) {

	$columns = array(
		'cb' => '&lt;input type="checkbox" />',
		'title' => __( 'Order' ),
		'order_instrument' => __( 'Instruments' ),
		'order_size' => __( 'Size' ),
		'order_district' => __( 'District' ),
		'payment_status' => __( 'Payment' ),
		'payment_total' => __( 'Amount' ),
	);

	return $columns;
}

add_action( 'manage_orders_posts_custom_column', 'my_manage_movie_columns', 10, 2 );

function my_manage_movie_columns( $column, $post_id ) {
	global $post;
	if($column == 'order_instrument') :
		echo  get_post_meta( $post_id, 'instrument_reuest_information_instrument_type', true );	
	endif;
	if($column == 'order_size') :
		echo  get_post_meta( $post_id, 'instrument_reuest_information_size', true );	
	endif;
	if($column == 'order_district') :
		 echo get_post_meta( $post_id, 'sudent_information_student_district', true );	
	endif;
	if($column == 'order_owner') :
		echo get_post_meta( $post_id, 'order_owner', true );	
	endif;
	if($column == 'payment_status') :
		echo get_post_meta( $post_id, 'payment_information_payment_status', true );	
	endif;
	if($column == 'payment_total') :
		echo '$'.get_post_meta( $post_id, 'payment_information_amount', true );	
	endif;
}

////////////////
add_action('restrict_manage_posts', 'filter_post_type_by_agent');
function filter_post_type_by_agent(){
    global $pagenow;
    $type = 'orders';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
	if ('orders' == $type && is_admin() && $pagenow=='edit.php') {
		echo '<select name="filter_by_district">
			<option value="">Search By Districts</option>';
			$args = array(
				'post_type' => 'districts',
				'posts_per_page' => -1                      
			);
			$posts = new WP_Query($args);
			if( $posts->have_posts() ): while( $posts->have_posts() ) : $posts->the_post();
					echo '<option value="'.get_the_ID().'">'.get_the_title().'</option>';
			endwhile; 
		endif; 
		echo '</select>';
		echo '<select name="filter_by_instrument">
				<option value="">Search By Instrument</option>
					<option value="violin">violin</option><option value="viola">viola</option><option value="cello">cello</option><
				</select>';
		 }
}

add_action( 'pre_get_posts', 'agents_posts_filter' );
function agents_posts_filter( $query ){
    global $pagenow;
    $type = 'orders';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
    if ( 'orders' == $type && is_admin() && $pagenow=='edit.php' && $query->is_main_query()) {
		if($_GET['filter_by_district'] != '' ):
			$query->set('meta_key', 'order_district');
        	$query->set('meta_value', $_GET['filter_by_district']);
		endif;
		if($_GET['filter_by_instrument'] != '' ):
			$query->set('meta_key', 'order_instrument');
        	$query->set('meta_value', $_GET['filter_by_instrument']);
		endif;
	}
}