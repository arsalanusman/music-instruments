<!-- Step #01 -->
<style>
.wpf_form_group.wpf_form_submissions button {
    display: none !important; 
}
</style>
<section class="step mt-5" data-stpep="step-one">
	<!-- step title -->
	<div class="row">
		<div class="col-12 mb-5">
			<h3>Select Your District, School and Session</h3>
		</div>
	</div>
	<!-- end step title -->
	<!-- step data -->
	<div class="row">
		<!-- box 01 -->
		<div class="col-md-6">
			<div class="form-group">
				<label>School District <span>*</span></label>
				<?php 
					$args = array(
						'post_type'			=> 'districts',
						'orderby' => 'title',
    					'order'   => 'ASC',
						'posts_per_page'	=> -1
					); 
					$the_query = new WP_Query( $args );
					echo '<select class="selectpicker form-control require" id="district">
							<option value="">Select a School</option>';
					if($the_query->have_posts() ) : 
						while ( $the_query->have_posts() ) : $the_query->the_post(); 
								echo '<option data-ttile="'.get_the_title().'"  value="'.get_the_ID().'">'.get_the_title().'</option>';				
						endwhile;
					else: endif;
					echo '</select>';	 
				?>
				<i class="ins">If you don't see your school district, please call us at <a href="tel:9529290026">(952) 929-0026</a>.</i>
			</div>
		</div>
			<!-- end box 01 -->
			<!-- box 02 -->
			<div class="col-md-6">
				<div class="form-group">
					<label>School of Attendance <span>*</span></label>
					<input class="form-control require" name="SchoolofAttendance" id="SchoolofAttendance" type="text" placeholder="">
				</div>
			</div>
			<!-- end box 02 -->
			<!-- box 03 -->
			<div class="col-md-12">
				<label>Session <span>*</span></label>
				<select class="selectpicker form-control require" name="sessions" id="sessions">
					<option value="">Select a Session</option>
				</select>
			</div>
		<!-- end box 03 -->
	</div>
</section>
<!-- end step #01 -->
<hr>
<!-- Step #02 -->
<section class="step" data-stpep="step-two">
	<!-- step title -->
	<div class="row">
		<div class="col-12 mb-5">
			<h3>Choose Your Instrument and Accessories</h3>
		</div>
		<div class="col-12">
			<p>If you are unsure of the instrument size, select ???Not Sure??? from the size drop menu and give us a call at 952-929-0026 to schedule a fitting.</p>
		</div>
	</div>
	<!-- end step title -->
	<!-- step data -->
	<div class="row mb-3">
		<!-- box 01 -->
		<div class="col-md-6">
		<div class="dropdown" id="instrument" data-post="<?php the_ID(); ?>">
			<label>Instrument  <span>*</span></label>
			<select class="selectpicker form-control require" id="instruments">
				<option value="0">Select Instrument</option>
			</select>
			</div>
		</div>
			<!-- end box 01 -->
			<!-- box 02 -->
			<div class="col-md-6"> 
				<div class="form-group">
					<label>Size  <span>*</span></label>
					<select class="selectpicker form-control require" name="size" id="size">
						<option value="0">Select Size</option>
					</select>
				</div>
			</div>
			<!-- end box 02 -->
			<!-- box 03 -->
			<div class="col-md-12">
				<div class="form-group" id="box-rental">
					<label>Rental Term <span></span></label>
					<!-- <select class="selectpicker form-control require" id="terms">
						<option>Rent Terms</option>
					</select> -->
					<div id="termlist"></div>
					<!-- <div class="term_ins"></div> -->
				</div>
			</div>
		<!-- end box 03 -->
	</div>
	<!-- optional -->
	<div class="row" id="box-optional">
		
		<div class="col-12" id="require_book">
			<h4 class="mb-3 mt-3">Required Books:</h3>
			<div class="items">
			
			</div>
		</div> 
		
		<div class="col-12" id="optionsl_list">
			<h4 class="mb-3 mt-3">Accessories:</h3>
			<div id="optionals">
			
			</div>
			<div id="size_options">
			</div>

		</div> 
	</div>
</section>
<!-- end step #02 -->
<hr>
<!-- step 03 -->
<section class="step" data-stpep="step-three">
	<!-- step title -->
	<div class="row">
		<div class="col-12 mb-5">
			<h3>Place Your Order</h3>
		</div>
	</div>
	<!-- end step title -->
	<!-- step data -->
	<div class="row">
		<div class="col-md-12">
			<h4 class="mb-3 mt-3">Contact Information</h4>
		</div>
	</div>	
	<div class="row">
		<!-- -->
		<div class="col-md-6">	
			<div class="form-group">
				<label>Parent/Guardian First Name <span>*</span></label>
				<input class="form-control require" name="pg_first_name" value="" id="pg_first_name" type="text" placeholder="">
			</div>
		</div>	
		<!-- -->
		<!-- -->
		<div class="col-md-6">	
			<div class="form-group">
				<label>Parent/Guardian Last Name <span>*</span></label>
				<input class="form-control require" name="pg_last_name" value="" id="pg_last_name" type="text" placeholder="">
			</div>
		</div>	
		<!-- -->
		<!-- -->
		<div class="col-md-6">	
			<div class="form-group">
				<label>Student First Name <span>*</span></label>
				<input class="form-control require" value="" name="student_name" id="student_name" type="text" placeholder="">
			</div>
		</div>	
		<!-- -->
		<!-- -->
		<div class="col-md-6">	
			<div class="form-group">
				<label>Student Last Name <span>*</span></label>
				<input class="form-control require" value="" name="student_last_name" id="student_last_name" type="text" placeholder="">
			</div>
		</div>	
		<!-- -->
		<div class="col-md-12">
			<!-- -->
			<div class="row">
				<!-- -->
				<div class="col-md-4">
					<div class="form-group">
						<label>Address <span>*</span></label>
						<input class="form-control require" value="" name="address" id="address" type="text" placeholder="">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>City <span>*</span></label>
						<input class="form-control require" value="" name="city" id="city" type="text" placeholder="">
					</div>
				</div>
				<!-- -->
				<!-- -->
				<div class="col-md-2">
					<div class="form-group">
						<label>State <span>*</span></label>
						<input class="form-control require" value="" name="stat" id="state" type="text" placeholder="">
					</div>
				</div>
				<!-- -->
				<!-- -->
				<div class="col-md-2">
					<div class="form-group">
						<label>Zip  <span>*</span></label>
						<input class="form-control require" value="" name="zip" id="zip" type="text" placeholder="">
					</div>
				</div>
				<!-- -->
			</div>
			<!-- -->
			<!-- -->
			<div class="row">
				<!-- -->
				<div class="col-md-4">
					<div class="form-group">
						<label>Phone Number <span>*</span></label>
						<input class="form-control require" name="phone" id="phone_number" value="" type="text" placeholder="">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Alt Phone Number <span>*</span> </label>
						<input class="form-control require" name="altphone" value="" id="alt_phone" type="text" placeholder="">
					</div>
				</div>
				<!-- -->
				<!-- -->
				<div class="col-md-4">
					<div class="form-group">
						<label>Email <span>*</span></label>
						<input class="form-control require" id="wpf_customer_email" name="wpf_customer_email" type="email" value="" placeholder="">
					</div>
				</div>
				<!-- -->
			</div>
			<!-- -->
		</div>
		<!-- -->
	</div>		
</section>
<!-- end of step 3 -->
<section id="payment">
	<div class="row">
		<div class="col-md-12">
			<h4 class="mb-3 mt-3">Billing Information</h4>
		</div>
		<!-- -->
		<div class="col-md-12">
			<div class="form-group">
				<label>Name on Card <span>*</span></label>
				<input class="form-control require" name="nane_on_card" type="text" placeholder="" value="">
			</div>
		</div>
		<!-- <div class="col-md-6">
			<div class="form-group">
				<label>Type of Card <span>*</span></label>
				<select class="selectpicker form-control require" id="">
					<option value="visa">VISA</option>
					<option value="master">Master</option>
					<option value="amrican">American Express</option>
				</select>
			</div>
		</div> -->
		<!-- -->
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php echo do_shortcode('[wppayform id="288"]');?>	
		</div>
		<div class="col-12">
			<p>*Auto charge will continue per duration of instrument rental.</p>
		</div>
	</div>
	<div class="row " id="order-detail">
		<div class="col-12">
			<h4 class="mb-3 mt-3">Order Details</h4>
		</div>
		<div class="col-12">
			<table class="table">
				<thead>
					<th id="itemtitle"></th>
					<th>Accessories</th>
					<th>Insurance</th>
					<th style="text-align:right">Tax</th>
				</thead>
				<tbody>
					<td id="itemamount">$0</td>
					<td id="ess_amount" width="400">$0</td>
					<td id="insamount" >$0</td>
					<td id="taxamount" align="right">$0</td>
				</tbody>
				<tfoot>
					<td colspan="2">Total Cost</td>
					<td colspan="3" id="total" align="right">$0</td>
				</tfoot>
			</table>
		</div>
	</div>
</section>
<!-- -->
<section id="Qand!">
	<div class="row">
		<div class="col-12">
			<h4 class="mb-3 mt-3">QUESTIONS & COMMENTS</h4>
		</div>
		<div class="col-12">
			<div class="form-group">
				<textarea class="form-control" name="comments" id="comments" rows="7"></textarea>
			</div>
		</div>
		<div class="col-12">
			<h4 class="mb-3 mt-3">Digital Signature</h4>
			<p>I, the undersigned, understand and agree to the below terms and conditions and hereby give permission to House of Note to charge my credit card all rental fees, accessories, insurance and sales tax.</p>
			<p>By selecting the "I Agree" checkbox below and printing my name, and date, I agree that the name represents me the signer, and will be the electronic representation of my signature for this HOUSE OF NOTE RENTAL CONTRACT, and legally binding me, the signer, to all terms and conditions of the rental contract.</p>
		</div>
		<div class="col-12">
			<div class="form-check" id="agreecheck">
				<input class="form-check-input" type="checkbox" name="agree" value="" id="agree"/>
				<label class="" for="agree">
					<strong>I Agree <span>*</span></strong> 
				</label>
			</div>
			<div class="policy">
				<div class="content">
					<?php 
						$my_id = 325;
						$post_id_5369 = get_post($my_id);
						$content = $post_id_5369->post_content;
						$content = apply_filters('the_content', $content);
						$content = str_replace(']]>', ']]>', $content);
						echo $content;
					?>
				</div>
			</div>
		</div>
		</div>
		<div class="row mt-3">
			<!-- -->
			<div class="col-md-4">
				<div class="form-group">
					<label>Digital Signature <span>*</span></label>
					<input class="form-control require" name="dsignature" type="text" placeholder="" value="">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Date (MM/DD/YYYY)<span>*</span></label>
					<input class="form-control require" name="date" id="date" type="date" max="" placeholder="" value="">
				</div>
			</div>
			<!-- -->
			<!-- -->
			<div class="col-md-4">
				<div class="form-group">
					<label></label>
					<input type="button"  id="submitbooking" name="submit" value="RESERVE"/>
				</div>
			</div>
			<!-- -->
		</div>
</section>
<div class="loader"></div>
