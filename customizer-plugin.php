<?php
/**
 * Plugin Name: Theme Options
 * Plugin URI: https://pakistansouq.com/
 * Description: Website options.
 * Version: 1.0
 * Author: Haroon Rasheed
 * Author URI: https://esouqmart.com/
 */


function ajax_login_init(){
    wp_enqueue_script('ajax-login-script', esc_url( plugins_url( 'js/ajax-login-script.js', __FILE__ ) ), array('jquery'), true );
    // wp_enqueue_script('ajax-login-script');
    
    /*wp_localize_script( 'ajax-login-script','ajax_login_object', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'redirecturl' => $_SERVER['REQUEST_URI'],
        'loadingmessage' => __('Sending user info, please wait...')
    ));*/
    
    // Enable the user with no privileges to run ajax_login() in AJAX
    // add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}
add_action( 'wp_enqueue_scripts','ajax_login_init' );


/**
* login check
*/
add_action( 'wp_ajax_nopriv_login_check', 'loginCheck' );
add_action( 'wp_ajax_login_check', 'loginCheck' );
function loginCheck() {

    if ( is_user_logged_in() ) {
        echo json_encode( array( 'success' => true, 'message' => 'You are already logged in' ) );
        die;
    }

    // check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // get the POSTed credentials
    $creds = array();
    // $creds['user_login']    = !empty( $_POST['username'] ) ? $_POST['username'] : null;
    // $creds['user_password'] = !empty( $_POST['password'] ) ? $_POST['password'] : null;
    // $creds['remember']      = !empty( $_POST['rememberme'] ) ? $_POST['rememberme'] : null;
    
    $creds['user_login'] = !empty( $_POST['username'] ) ? sanitize_text_field( $_POST['username'] ) : null;
    $creds['user_password'] = !empty( $_POST['password'] ) ? sanitize_text_field( $_POST['password'] ) : null;
    $creds['remember'] = !empty( $_POST['rememberme'] ) ? sanitize_text_field( $_POST['rememberme'] ) : null;

    // check for empty fields
    if( empty( $creds['user_login'] ) || empty( $creds['user_password'] ) ) {
        echo json_encode( array( 'success' => true, 'message' => 'The username or password is cannot be empty' ) );
        die;
    }

    // check login
    $user = wp_signon( $creds, false );

    if ( is_wp_error( $user ) ) {

        if ( $user->get_error_code() == "invalid_username" || $user->get_error_code() == "incorrect_password" ) {
            echo json_encode( array( 'success' => false, 'message' => 'The username or password is incorrect' ) );
            die;
        } else {
            echo json_encode( array( 'success' => false, 'message' => 'There was an error logging you in' ) );
            die;
        }
        echo json_encode( array( 'success' => true, 'message' => 'Login successful' ) );
        die;
    }
    echo json_encode( $return );
    die;
}
  



// Add script and style files
function callback_my_admin_scripts() {
    // Including Script files.
    // wp_enqueue_script( 'jquery-library-js', 'https://code.jquery.com/jquery-1.11.0.min.js', array( 'jquery' ), true );
    // wp_enqueue_script( 'admin-script-js', esc_url( plugins_url( 'js/admin_script.js', __FILE__ ) ), array( 'jquery' ), true );

    // Regestring Stylesheets.
    wp_enqueue_style( 'admin-styles', esc_url( plugins_url( 'css/admin_style.css', __FILE__ ) ) );
    // wp_enqueue_style('admin-styles');
}
add_action('admin_enqueue_scripts', 'callback_my_admin_scripts');

// Add script and style files
function callback_my_scripts() {
    // Regestring Stylesheets.
    wp_enqueue_style( 'my-styles', esc_url( plugins_url( 'css/style.css', __FILE__ ) ) );
    // wp_enqueue_style('admin-styles');

	wp_enqueue_script('validate-script', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js', array('jquery'), false );
	wp_enqueue_script('ajax-auth-script', esc_url( plugins_url( 'js/script.js', __FILE__ ) ), array('jquery'), true  );
	
// 	wp_enqueue_script('validate-script');
// 	wp_enqueue_script('ajax-auth-script');
}
add_action('wp_enqueue_scripts', 'callback_my_scripts');

remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'index_rel_link' ); // index link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version

require 'inc/user-fields.php';
require 'inc/user-process.php';

function editProfileFunction( $atts = array() ) {
    // set up default parameters
    extract(shortcode_atts(array(
    //  'rating' => '5'
    ), $atts));

    if(!is_user_logged_in()) {
        ?>
        <div class="register-message" style="display:none"></div>
        <form id="register" action="#" method="post" autocomplete="off" class="registration-form"> <!-- action="<?php echo $_SERVER['REQUEST_URI']; ?>"-->
            <?php wp_nonce_field('ajax-register-nonce', 'signonsecurity'); ?>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" placeholder="Please enter your firstname" class="required alpha">
                </div>
                <div class="input-group col-md-50 mb-10">
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" placeholder="Please enter your lastname" class="required alpha">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="nationality">Nationality:</label><br>
                    <select name="nationality" id="nationality" class="required">
                        <option value="pakistan">Pakistan</option>
                        <option value="qatar">Qatar</option>
                    </select>
                </div>
                <div class="input-group col-md-50 mb-10">
                    <label for="passport_number">Passport Number:</label>
                    <input type="text" id="passport_number" name="passport_number" minlength="9" maxlength="11" placeholder="Please enter your passport number" class="required">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="other_nationality">Do you have Dual Nationality?</label>
                    <select name="other_nationality" id="other_nationality" class="required">
                        <option value="">-- select one --</option>
                        <option value="afghan">Afghan</option>
                        <option value="albanian">Albanian</option>
                        <option value="algerian">Algerian</option>
                        <option value="american">American</option>
                        <option value="andorran">Andorran</option>
                        <option value="angolan">Angolan</option>
                        <option value="antiguans">Antiguans</option>
                        <option value="argentinean">Argentinean</option>
                        <option value="armenian">Armenian</option>
                        <option value="australian">Australian</option>
                        <option value="austrian">Austrian</option>
                        <option value="azerbaijani">Azerbaijani</option>
                        <option value="bahamian">Bahamian</option>
                        <option value="bahraini">Bahraini</option>
                        <option value="bangladeshi">Bangladeshi</option>
                        <option value="barbadian">Barbadian</option>
                        <option value="barbudans">Barbudans</option>
                        <option value="batswana">Batswana</option>
                        <option value="belarusian">Belarusian</option>
                        <option value="belgian">Belgian</option>
                        <option value="belizean">Belizean</option>
                        <option value="beninese">Beninese</option>
                        <option value="bhutanese">Bhutanese</option>
                        <option value="bolivian">Bolivian</option>
                        <option value="bosnian">Bosnian</option>
                        <option value="brazilian">Brazilian</option>
                        <option value="british">British</option>
                        <option value="bruneian">Bruneian</option>
                        <option value="bulgarian">Bulgarian</option>
                        <option value="burkinabe">Burkinabe</option>
                        <option value="burmese">Burmese</option>
                        <option value="burundian">Burundian</option>
                        <option value="cambodian">Cambodian</option>
                        <option value="cameroonian">Cameroonian</option>
                        <option value="canadian">Canadian</option>
                        <option value="cape verdean">Cape Verdean</option>
                        <option value="central african">Central African</option>
                        <option value="chadian">Chadian</option>
                        <option value="chilean">Chilean</option>
                        <option value="chinese">Chinese</option>
                        <option value="colombian">Colombian</option>
                        <option value="comoran">Comoran</option>
                        <option value="congolese">Congolese</option>
                        <option value="costa rican">Costa Rican</option>
                        <option value="croatian">Croatian</option>
                        <option value="cuban">Cuban</option>
                        <option value="cypriot">Cypriot</option>
                        <option value="czech">Czech</option>
                        <option value="danish">Danish</option>
                        <option value="djibouti">Djibouti</option>
                        <option value="dominican">Dominican</option>
                        <option value="dutch">Dutch</option>
                        <option value="east timorese">East Timorese</option>
                        <option value="ecuadorean">Ecuadorean</option>
                        <option value="egyptian">Egyptian</option>
                        <option value="emirian">Emirian</option>
                        <option value="equatorial guinean">Equatorial Guinean</option>
                        <option value="eritrean">Eritrean</option>
                        <option value="estonian">Estonian</option>
                        <option value="ethiopian">Ethiopian</option>
                        <option value="fijian">Fijian</option>
                        <option value="filipino">Filipino</option>
                        <option value="finnish">Finnish</option>
                        <option value="french">French</option>
                        <option value="gabonese">Gabonese</option>
                        <option value="gambian">Gambian</option>
                        <option value="georgian">Georgian</option>
                        <option value="german">German</option>
                        <option value="ghanaian">Ghanaian</option>
                        <option value="greek">Greek</option>
                        <option value="grenadian">Grenadian</option>
                        <option value="guatemalan">Guatemalan</option>
                        <option value="guinea-bissauan">Guinea-Bissauan</option>
                        <option value="guinean">Guinean</option>
                        <option value="guyanese">Guyanese</option>
                        <option value="haitian">Haitian</option>
                        <option value="herzegovinian">Herzegovinian</option>
                        <option value="honduran">Honduran</option>
                        <option value="hungarian">Hungarian</option>
                        <option value="icelander">Icelander</option>
                        <option value="indian">Indian</option>
                        <option value="indonesian">Indonesian</option>
                        <option value="iranian">Iranian</option>
                        <option value="iraqi">Iraqi</option>
                        <option value="irish">Irish</option>
                        <option value="israeli">Israeli</option>
                        <option value="italian">Italian</option>
                        <option value="ivorian">Ivorian</option>
                        <option value="jamaican">Jamaican</option>
                        <option value="japanese">Japanese</option>
                        <option value="jordanian">Jordanian</option>
                        <option value="kazakhstani">Kazakhstani</option>
                        <option value="kenyan">Kenyan</option>
                        <option value="kittian and nevisian">Kittian and Nevisian</option>
                        <option value="kuwaiti">Kuwaiti</option>
                        <option value="kyrgyz">Kyrgyz</option>
                        <option value="laotian">Laotian</option>
                        <option value="latvian">Latvian</option>
                        <option value="lebanese">Lebanese</option>
                        <option value="liberian">Liberian</option>
                        <option value="libyan">Libyan</option>
                        <option value="liechtensteiner">Liechtensteiner</option>
                        <option value="lithuanian">Lithuanian</option>
                        <option value="luxembourger">Luxembourger</option>
                        <option value="macedonian">Macedonian</option>
                        <option value="malagasy">Malagasy</option>
                        <option value="malawian">Malawian</option>
                        <option value="malaysian">Malaysian</option>
                        <option value="maldivan">Maldivan</option>
                        <option value="malian">Malian</option>
                        <option value="maltese">Maltese</option>
                        <option value="marshallese">Marshallese</option>
                        <option value="mauritanian">Mauritanian</option>
                        <option value="mauritian">Mauritian</option>
                        <option value="mexican">Mexican</option>
                        <option value="micronesian">Micronesian</option>
                        <option value="moldovan">Moldovan</option>
                        <option value="monacan">Monacan</option>
                        <option value="mongolian">Mongolian</option>
                        <option value="moroccan">Moroccan</option>
                        <option value="mosotho">Mosotho</option>
                        <option value="motswana">Motswana</option>
                        <option value="mozambican">Mozambican</option>
                        <option value="namibian">Namibian</option>
                        <option value="nauruan">Nauruan</option>
                        <option value="nepalese">Nepalese</option>
                        <option value="new zealander">New Zealander</option>
                        <option value="ni-vanuatu">Ni-Vanuatu</option>
                        <option value="nicaraguan">Nicaraguan</option>
                        <option value="nigerien">Nigerien</option>
                        <option value="north korean">North Korean</option>
                        <option value="northern irish">Northern Irish</option>
                        <option value="norwegian">Norwegian</option>
                        <option value="omani">Omani</option>
                        <option value="pakistani">Pakistani</option>
                        <option value="palauan">Palauan</option>
                        <option value="panamanian">Panamanian</option>
                        <option value="papua new guinean">Papua New Guinean</option>
                        <option value="paraguayan">Paraguayan</option>
                        <option value="peruvian">Peruvian</option>
                        <option value="polish">Polish</option>
                        <option value="portuguese">Portuguese</option>
                        <option value="qatari">Qatari</option>
                        <option value="romanian">Romanian</option>
                        <option value="russian">Russian</option>
                        <option value="rwandan">Rwandan</option>
                        <option value="saint lucian">Saint Lucian</option>
                        <option value="salvadoran">Salvadoran</option>
                        <option value="samoan">Samoan</option>
                        <option value="san marinese">San Marinese</option>
                        <option value="sao tomean">Sao Tomean</option>
                        <option value="saudi">Saudi</option>
                        <option value="scottish">Scottish</option>
                        <option value="senegalese">Senegalese</option>
                        <option value="serbian">Serbian</option>
                        <option value="seychellois">Seychellois</option>
                        <option value="sierra leonean">Sierra Leonean</option>
                        <option value="singaporean">Singaporean</option>
                        <option value="slovakian">Slovakian</option>
                        <option value="slovenian">Slovenian</option>
                        <option value="solomon islander">Solomon Islander</option>
                        <option value="somali">Somali</option>
                        <option value="south african">South African</option>
                        <option value="south korean">South Korean</option>
                        <option value="spanish">Spanish</option>
                        <option value="sri lankan">Sri Lankan</option>
                        <option value="sudanese">Sudanese</option>
                        <option value="surinamer">Surinamer</option>
                        <option value="swazi">Swazi</option>
                        <option value="swedish">Swedish</option>
                        <option value="swiss">Swiss</option>
                        <option value="syrian">Syrian</option>
                        <option value="taiwanese">Taiwanese</option>
                        <option value="tajik">Tajik</option>
                        <option value="tanzanian">Tanzanian</option>
                        <option value="thai">Thai</option>
                        <option value="togolese">Togolese</option>
                        <option value="tongan">Tongan</option>
                        <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
                        <option value="tunisian">Tunisian</option>
                        <option value="turkish">Turkish</option>
                        <option value="tuvaluan">Tuvaluan</option>
                        <option value="ugandan">Ugandan</option>
                        <option value="ukrainian">Ukrainian</option>
                        <option value="uruguayan">Uruguayan</option>
                        <option value="uzbekistani">Uzbekistani</option>
                        <option value="venezuelan">Venezuelan</option>
                        <option value="vietnamese">Vietnamese</option>
                        <option value="welsh">Welsh</option>
                        <option value="yemenite">Yemenite</option>
                        <option value="zambian">Zambian</option>
                        <option value="zimbabwean">Zimbabwean</option>
                    </select>
                </div>
                <div class="input-group col-md-50 mb-10">
                    <label for="living_status">Living with Family:</label>
                    <select name="living_status" id="living_status" class="required">
                        <option value="">-- Select --</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div>
            <div class="with_family_details">
                <div class="row">
                    <div class="family-details spouse col-md-100">
                        <div class="row spouse_details" id="spouse-1">
                            <div class="input-group col-md-80 mb-10">
                                <div class="row">
                                    <div class="input-group col-md-50 mb-10">
                                        <label for="spouse_name[]">Spouse Name</label>
                                        <input type="text" name="spouse_name[]" placeholder="Please enter your spouse name" class="spouse-name">
                                    </div>
                                    <div class="input-group col-md-50 mb-10">
                                        <label for="spouse_qid[]">Spouse QID:</label>
                                        <input type="text" name="spouse_qid[]" minlength="11" maxlength="11" placeholder="Please enter your spouse QID number" class="spouse-qid numeric">
                                    </div>
                                </div>
                            </div>
                            <div class="input-group col-md-20 mb-10 right-align">
                                <a href="#" class="add_new_spouse button htb-btn-success mr-10" title="Add More"><i class="fa fa-plus"></i></a>
                                <a href="#" class="remove_spouse_row button htb-btn-danger" data-id="2" title="Remove"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="family-details child col-md-100">
                        <div class="row child_details" id="child-1">
                            <div class="input-group col-md-80 mb-10">
                                <div class="row">
                                    <div class="input-group col-md-50 mb-10">
                                        <label for="child_name[]">Child Name</label>
                                        <input type="text" name="child_name[]" placeholder="Please enter your child name" class="child-name">
                                    </div>
                                    <div class="input-group col-md-50 mb-10">
                                        <label for="child_qid[]">Child QID:</label>
                                        <input type="text" name="child_qid[]" minlength="11" maxlength="11" placeholder="Please enter your child QID number" class="child-name numeric">
                                    </div>
                                </div>
                            </div>
                            <div class="input-group col-md-20 mb-10 right-align">
                                <a href="#" class="add_new_child button htb-btn-success mr-10" title="Add More"><i class="fa fa-plus"></i></a>
                                <a href="#" class="remove_child_row button htb-btn-danger" data-id="2" title="Remove"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="date_of_birth">Date of Birth:</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" class="required">
                </div>
                <div class="input-group col-md-50 mb-10 w-50 pl-5">
                    <label for="father_name">Father's Name:</label>
                    <input type="text" id="father_name" name="father_name" placeholder="Please enter your father name" class="required alpha">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="gender">Gender:</label>
                    <select name="gender" id="gender" class="required">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="input-group col-md-50 mb-10 w-50 pl-5">
                    <label for="marital_status">Marital Status:</label>
                    <select name="marital_status" id="marital_status" class="required">
                        <option value="married">Married</option>
                        <option value="unmarried">Unmarried</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10 w-50 pl-5">
                    <label for="job_title">Job Title/Job Place:</label>
                    <input type="text" id="job_title" name="job_title" placeholder="Please enter your Job title" class="required alpha">
                </div>
                <div class="input-group col-md-50 mb-10 w-50 pl-5">
                    <label for="job_place">Job Place:</label>
                    <input type="text" id="job_place" name="job_place" placeholder="Please enter your Job place" class="required alpha">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="visa_qid">Visa or QID:</label>
                    <input type="text" id="visa_qid" name="visa_qid" minlength="11" maxlength="13" placeholder="Please enter your visa or qid" class="required numeric">
                </div>
                <div class="input-group col-md-50 mb-10 w-50 pl-5">
                    <label for="cnic_nicop_poc">CNIC/NICOP/POC No.:</label>
                    <input type="text" id="cnic_nicop_poc" name="cnic_nicop_poc" minlength="13" maxlength="13" placeholder="Please enter your cnic/nicop/poc number" class="required numeric">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="mobile_number">Mobile No.:</label>
                    <input type="text" id="mobile_number" minlength="8" maxlength="8" name="mobile_number" placeholder="Please enter your mobile number" class="required numeric">
                </div>
                <div class="input-group col-md-50 mb-10">
                    <label for="qatar_address">Address in Qatar:</label>
                    <input type="text" id="qatar_address" name="qatar_address" placeholder="Please enter your address" class="required">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10 w-50 pl-5">
                    <label for="arrival_date">Date of permanent arrival in Qatar:</label>
                    <input type="date" id="arrival_date" name="arrival_date" class="required">
                </div>
                <div class="input-group col-md-50 mb-10">
                    <label for="embassy_registration_number">Embassy registration No.:</label>
                    <input type="text" id="embassy_registration_number" minlength="6" maxlength="15" name="embassy_registration_number" placeholder="Please enter your embassy registration date" class="required">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="occupation_designation">Occupation/Designation:</label>
                    <input type="text" id="occupation_designation" name="occupation_designation" placeholder="Please enter your occupation/designation" class="required alpha">
                </div>
                <div class="input-group col-md-50 mb-10 w-50 pl-5">
                    <label for="employer">Employer:</label>
                    <input type="text" id="employer" name="employer" placeholder="Please enter your employer" class="required alpha">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="expertise">Field of Expertise:</label>
                    <input type="text" id="expertise" name="expertise" placeholder="Please enter your expertise" class="required alpha">
                </div>
                <div class="input-group col-md-50 mb-10">
                    <label for="district">Home District/District of Domicile:</label>
                    <input type="text" id="district" name="district" placeholder="Please enter your home district/district of domicile" class="required alpha">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" maxlength="25" placeholder="Please enter your username" class="required alpha">
                </div>
                <div class="input-group col-md-50 mb-10">
                    <label for="mail_id">Email:</label>
                    <input type="text" id="mail_id" name="mail_id" placeholder="Please enter your email address" class="required">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="user_password">Password:</label>
                    <input type="password" id="user_password" name="user_password" placeholder="Choose password" class="required">
                    <div class="checkbox">
                        <input type="checkbox" id="show_password" value="show">
                        <label for="show_password">Show Password</label>
                    </div>
                </div>
                <div class="input-group col-md-50 mb-10">
                    <label for="contact_pakistan">Contact in Pakistan:</label>
                    <input type="text" id="contact_pakistan" minlength="11" maxlength="11" name="contact_pakistan" placeholder="Please enter your contact in pakistan" class="required numeric">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <input type="submit" value="Submit" id="create_user">
                </div>
                <div class="input-group col-md-50 mb-10 right-align">
                    <p>Already have an account? <a id="pop_login"  href="#">Login</a></p>
                </div>
            </div>
        </form>
        <script type="text/javascript">
            jQuery(document).ready(function($){
                jQuery('#create_user').on('click',function(e){
                    e.preventDefault();
                    if (!jQuery('#register').valid()) return false;
        
                    var username                    = jQuery("#username").val();
                    var mail_id                     = jQuery("#mail_id").val();
                    var first_name                  = jQuery("#first_name").val();
                    var last_name                   = jQuery("#last_name").val();
                    var nationality                 = jQuery("#nationality").val();
                    var passport_number             = jQuery("#passport_number").val();
                    var other_nationality           = jQuery("#other_nationality").val();
                    var living_status               = jQuery("#living_status").val();
                    /*var spouse_name                 = jQuery("#spouse_name").val();
                    var spouse_qid                  = jQuery("#spouse_qid").val();
                    var child_name                  = jQuery("#child_name").val();
                    var child_qid                   = jQuery("#child_qid").val();*/
                    var date_of_birth               = jQuery("#date_of_birth").val();
                    var father_name                 = jQuery("#father_name").val();
                    var gender                      = jQuery("#gender").val();
                    var marital_status              = jQuery("#marital_status").val();
                    var job_title                   = jQuery("#job_title").val();
                    var job_place                   = jQuery("#job_place").val();
                    var visa_qid                    = jQuery("#visa_qid").val();
                    var cnic_nicop_poc              = jQuery("#cnic_nicop_poc").val();
                    var mobile_number               = jQuery("#mobile_number").val();
                    var qatar_address               = jQuery("#qatar_address").val();
                    var arrival_date                = jQuery("#arrival_date").val();
                    var embassy_registration_number = jQuery("#embassy_registration_number").val();
                    var occupation_designation      = jQuery("#occupation_designation").val();
                    var employer                    = jQuery("#employer").val();
                    var expertise                   = jQuery("#expertise").val();
                    var district                    = jQuery("#district").val();
                    var contact_pakistan            = jQuery("#contact_pakistan").val();
                    var user_password               = jQuery("#user_password").val();
                    var security                    = jQuery("#signonsecurity").val();
                    
                    var spouse_name = [];
                    var spouse_qid = [];
                    var child_name = [];
                    var child_qid = [];
        
                    // Initializing array with Checkbox checked values
                    jQuery("input[name='spouse_name[]']").each(function(){
                        spouse_name.push(this.value);
                    });
                    jQuery("input[name='spouse_qid[]']").each(function(){
                        spouse_qid.push(this.value);
                    });
                    $("input[name='child_name[]']").each(function(){
                        child_name.push(this.value);
                    });
                    $("input[name='child_qid[]']").each(function(){
                        child_qid.push(this.value);
                    });
            
                    jQuery.ajax({
                        type:"POST",
                        url:"<?php echo admin_url('admin-ajax.php'); ?>",
                        data: {
                            action: "register_user_front_end",
                            username : username,
                            mail_id : mail_id,
                            first_name : first_name,
                            last_name : last_name,
                            nationality : nationality,
                            passport_number : passport_number,
                            other_nationality : other_nationality,
                            living_status : living_status,
                            spouse_name : spouse_name,
                            spouse_qid : spouse_qid,
                            child_name : child_name,
                            child_qid : child_qid,
                            date_of_birth : date_of_birth,
                            father_name : father_name,
                            gender : gender,
                            marital_status : marital_status,
                            job_title : job_title,
                            job_place : job_place,
                            visa_qid : visa_qid,
                            cnic_nicop_poc : cnic_nicop_poc,
                            mobile_number : mobile_number,
                            qatar_address : qatar_address,
                            arrival_date : arrival_date,
                            embassy_registration_number : embassy_registration_number,
                            occupation_designation : occupation_designation,
                            employer : employer,
                            expertise : expertise,
                            district : district,
                            contact_pakistan : contact_pakistan,
                            user_password : user_password
                        },
                        success: function(results){
                            // console.log(results);
                            jQuery('.register-message').text(results).show();
                            jQuery('#register').hide();
                            /*setTimeout(function(){
                                document.location.href = <?php echo $_SERVER['REQUEST_URI']; ?>;
                            }, 3000);*/
                        },
                        error: function(results) {
                            // console.log(results);
                            jQuery('.register-message').text(results).show();
                        }
                    });
                });
            });
        </script>

        <form id="loginForm" action="login" method="post" class="login-form">
            <a class="close" href="#"><span></span></a>
            <div class="row">
                <div class="input-group col-md-100 mb-10">
                    <div class="register-message login-status" style="display:none"></div>
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-100 mb-10">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" maxlength="25" placeholder="Please enter your username" class="required alpha">
                </div>
                <div class="input-group col-md-100 mb-10">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Choose password" class="required">
                    <div class="checkbox">
                        <input name="rememberme" type="checkbox" id="rememberme" value="forever">
                        <label for="rememberme">Remember Me</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-100 mb-10">
                    <input type="submit" value="Login" id="login_user">
                </div>
            </div>
            <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
        </form>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                // Perform AJAX login on form submit
                $('#loginForm').on('submit', login);

                function login(e) {
                    e.preventDefault();
                    
                    var $form = $(this);
                    var data = {
                        'action': 'login_check',
                        'username': $form.find('#username').val(),
                        'password': $form.find('#password').val(),
                        'rememberme': $form.find('#rememberme').is(':checked') ? true : false,
                        'security': $form.find('#security').val()
                    };
                    
                    $.ajax({
                        url: '<?php echo admin_url("admin-ajax.php")?>',
                        type: 'POST',
                        dataType: 'json',
                        data: data,
                        // beforeSend: function (jqXHR, settings) { $('.register-message').html(”); },
                        success: function (data, textStatus, xhr) { onAjaxSuccess(data); },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $('.register-message').html('There was an unexpected error');
                            $('.register-message').addClass('error');
                            
                        }
                    });
                }
                function onAjaxSuccess(data) {
                
                if (typeof data.message !== 'undefined')
                    $('.register-message').html(data.message);
                    // reload on success
                    if (typeof data.success !== 'undefined' && data.success === true) {
                        // location.reload();
                        $('.register-message').html(data.message);
                    }
                }
            
            });
        </script>
        <?php
    } else {
        global $current_user;
        $user_id = $current_user->ID;
        ?>
        <div class="register-message" style="display:none"></div>
        <form id="edit_profile" action="#" method="post" autocomplete="off" class="registration-form"> <!-- action="<?php echo $_SERVER['REQUEST_URI']; ?>"-->
            <?php wp_nonce_field('ajax-profile-nonce', 'signonsecurity'); ?>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo esc_attr( get_the_author_meta( 'passport_number', $user_id ) ); ?>" class="required alpha">
                </div>
                <div class="input-group col-md-50 mb-10">
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo esc_attr( get_the_author_meta( 'passport_number', $user_id ) ); ?>" class="required alpha">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="nationality">Nationality:</label><br>
                    <?php $nationality = get_the_author_meta( 'nationality', $user_id ); //echo $nationality ?>
    			    <select name="nationality" id="nationality">
                        <option value="pakistan" <?php if( $nationality == 'pakistan' ) { ?> selected="selected"<?php } ?>>Pakistan</option>
                        <option value="qatar" <?php if( $nationality == 'qatar' ) { ?> selected="selected"<?php } ?>>Qatar</option>
                    </select>
                </div>
                <div class="input-group col-md-50 mb-10">
                    <label for="passport_number">Passport Number:</label>
                    <input type="text" id="passport_number" name="passport_number" minlength="9" maxlength="11" value="<?php echo esc_attr( get_the_author_meta( 'passport_number', $user_id ) ); ?>" class="required">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="other_nationality">Do you have Dual Nationality?</label>
                    <?php $otherNationality = get_the_author_meta( 'other_nationality', $user_id ); //echo $nationality ?>
    				<select name="other_nationality" id="other_nationality">
                        <option value="">-- select one --</option>
                        <option <?php if( $otherNationality == 'afghan' ) { ?> selected="selected"<?php } ?> value="afghan">Afghan</option>
                        <option <?php if( $otherNationality == 'albanian' ) { ?> selected="selected"<?php } ?> value="albanian">Albanian</option>
                        <option <?php if( $otherNationality == 'algerian' ) { ?> selected="selected"<?php } ?> value="algerian">Algerian</option>
                        <option <?php if( $otherNationality == 'american' ) { ?> selected="selected"<?php } ?> value="american">American</option>
                        <option <?php if( $otherNationality == 'andorran' ) { ?> selected="selected"<?php } ?> value="andorran">Andorran</option>
                        <option <?php if( $otherNationality == 'angolan' ) { ?> selected="selected"<?php } ?> value="angolan">Angolan</option>
                        <option <?php if( $otherNationality == 'antiguans' ) { ?> selected="selected"<?php } ?> value="antiguans">Antiguans</option>
                        <option <?php if( $otherNationality == 'argentinean' ) { ?> selected="selected"<?php } ?> value="argentinean">Argentinean</option>
                        <option <?php if( $otherNationality == 'armenian' ) { ?> selected="selected"<?php } ?> value="armenian">Armenian</option>
                        <option <?php if( $otherNationality == 'australian' ) { ?> selected="selected"<?php } ?> value="australian">Australian</option>
                        <option <?php if( $otherNationality == 'austrian' ) { ?> selected="selected"<?php } ?> value="austrian">Austrian</option>
                        <option <?php if( $otherNationality == 'azerbaijani' ) { ?> selected="selected"<?php } ?> value="azerbaijani">Azerbaijani</option>
                        <option <?php if( $otherNationality == 'bahamian' ) { ?> selected="selected"<?php } ?> value="bahamian">Bahamian</option>
                        <option <?php if( $otherNationality == 'bahraini' ) { ?> selected="selected"<?php } ?> value="bahraini">Bahraini</option>
                        <option <?php if( $otherNationality == 'bangladeshi' ) { ?> selected="selected"<?php } ?> value="bangladeshi">Bangladeshi</option>
                        <option <?php if( $otherNationality == 'barbadian' ) { ?> selected="selected"<?php } ?> value="barbadian">Barbadian</option>
                        <option <?php if( $otherNationality == 'barbudans' ) { ?> selected="selected"<?php } ?> value="barbudans">Barbudans</option>
                        <option <?php if( $otherNationality == 'batswana' ) { ?> selected="selected"<?php } ?> value="batswana">Batswana</option>
                        <option <?php if( $otherNationality == 'belarusian' ) { ?> selected="selected"<?php } ?> value="belarusian">Belarusian</option>
                        <option <?php if( $otherNationality == 'belgian' ) { ?> selected="selected"<?php } ?> value="belgian">Belgian</option>
                        <option <?php if( $otherNationality == 'belizean' ) { ?> selected="selected"<?php } ?> value="belizean">Belizean</option>
                        <option <?php if( $otherNationality == 'beninese' ) { ?> selected="selected"<?php } ?> value="beninese">Beninese</option>
                        <option <?php if( $otherNationality == 'bhutanese' ) { ?> selected="selected"<?php } ?> value="bhutanese">Bhutanese</option>
                        <option <?php if( $otherNationality == 'bolivian' ) { ?> selected="selected"<?php } ?> value="bolivian">Bolivian</option>
                        <option <?php if( $otherNationality == 'bosnian' ) { ?> selected="selected"<?php } ?> value="bosnian">Bosnian</option>
                        <option <?php if( $otherNationality == 'brazilian' ) { ?> selected="selected"<?php } ?> value="brazilian">Brazilian</option>
                        <option <?php if( $otherNationality == 'british' ) { ?> selected="selected"<?php } ?> value="british">British</option>
                        <option <?php if( $otherNationality == 'bruneian' ) { ?> selected="selected"<?php } ?> value="bruneian">Bruneian</option>
                        <option <?php if( $otherNationality == 'bulgarian' ) { ?> selected="selected"<?php } ?> value="bulgarian">Bulgarian</option>
                        <option <?php if( $otherNationality == 'burkinabe' ) { ?> selected="selected"<?php } ?> value="burkinabe">Burkinabe</option>
                        <option <?php if( $otherNationality == 'burmese' ) { ?> selected="selected"<?php } ?> value="burmese">Burmese</option>
                        <option <?php if( $otherNationality == 'burundian' ) { ?> selected="selected"<?php } ?> value="burundian">Burundian</option>
                        <option <?php if( $otherNationality == 'cambodian' ) { ?> selected="selected"<?php } ?> value="cambodian">Cambodian</option>
                        <option <?php if( $otherNationality == 'cameroonian' ) { ?> selected="selected"<?php } ?> value="cameroonian">Cameroonian</option>
                        <option <?php if( $otherNationality == 'canadian' ) { ?> selected="selected"<?php } ?> value="canadian">Canadian</option>
                        <option <?php if( $otherNationality == 'cape verdean' ) { ?> selected="selected"<?php } ?> value="cape verdean">Cape Verdean</option>
                        <option <?php if( $otherNationality == 'central african' ) { ?> selected="selected"<?php } ?> value="central african">Central African</option>
                        <option <?php if( $otherNationality == 'chadian' ) { ?> selected="selected"<?php } ?> value="chadian">Chadian</option>
                        <option <?php if( $otherNationality == 'chilean' ) { ?> selected="selected"<?php } ?> value="chilean">Chilean</option>
                        <option <?php if( $otherNationality == 'chinese' ) { ?> selected="selected"<?php } ?> value="chinese">Chinese</option>
                        <option <?php if( $otherNationality == 'colombian' ) { ?> selected="selected"<?php } ?> value="colombian">Colombian</option>
                        <option <?php if( $otherNationality == 'comoran' ) { ?> selected="selected"<?php } ?> value="comoran">Comoran</option>
                        <option <?php if( $otherNationality == 'congolese' ) { ?> selected="selected"<?php } ?> value="congolese">Congolese</option>
                        <option <?php if( $otherNationality == 'costa rican' ) { ?> selected="selected"<?php } ?> value="costa rican">Costa Rican</option>
                        <option <?php if( $otherNationality == 'croatian' ) { ?> selected="selected"<?php } ?> value="croatian">Croatian</option>
                        <option <?php if( $otherNationality == 'cuban' ) { ?> selected="selected"<?php } ?> value="cuban">Cuban</option>
                        <option <?php if( $otherNationality == 'cypriot' ) { ?> selected="selected"<?php } ?> value="cypriot">Cypriot</option>
                        <option <?php if( $otherNationality == 'czech' ) { ?> selected="selected"<?php } ?> value="czech">Czech</option>
                        <option <?php if( $otherNationality == 'danish' ) { ?> selected="selected"<?php } ?> value="danish">Danish</option>
                        <option <?php if( $otherNationality == 'djibouti' ) { ?> selected="selected"<?php } ?> value="djibouti">Djibouti</option>
                        <option <?php if( $otherNationality == 'dominican' ) { ?> selected="selected"<?php } ?> value="dominican">Dominican</option>
                        <option <?php if( $otherNationality == 'dutch' ) { ?> selected="selected"<?php } ?> value="dutch">Dutch</option>
                        <option <?php if( $otherNationality == 'east timorese' ) { ?> selected="selected"<?php } ?> value="east timorese">East Timorese</option>
                        <option <?php if( $otherNationality == 'ecuadorean' ) { ?> selected="selected"<?php } ?> value="ecuadorean">Ecuadorean</option>
                        <option <?php if( $otherNationality == 'egyptian' ) { ?> selected="selected"<?php } ?> value="egyptian">Egyptian</option>
                        <option <?php if( $otherNationality == 'emirian' ) { ?> selected="selected"<?php } ?> value="emirian">Emirian</option>
                        <option <?php if( $otherNationality == 'equatorial guinean' ) { ?> selected="selected"<?php } ?> value="equatorial guinean">Equatorial Guinean</option>
                        <option <?php if( $otherNationality == 'eritrean' ) { ?> selected="selected"<?php } ?> value="eritrean">Eritrean</option>
                        <option <?php if( $otherNationality == 'estonian' ) { ?> selected="selected"<?php } ?> value="estonian">Estonian</option>
                        <option <?php if( $otherNationality == 'ethiopian' ) { ?> selected="selected"<?php } ?> value="ethiopian">Ethiopian</option>
                        <option <?php if( $otherNationality == 'fijian' ) { ?> selected="selected"<?php } ?> value="fijian">Fijian</option>
                        <option <?php if( $otherNationality == 'filipino' ) { ?> selected="selected"<?php } ?> value="filipino">Filipino</option>
                        <option <?php if( $otherNationality == 'finnish' ) { ?> selected="selected"<?php } ?> value="finnish">Finnish</option>
                        <option <?php if( $otherNationality == 'french' ) { ?> selected="selected"<?php } ?> value="french">French</option>
                        <option <?php if( $otherNationality == 'gabonese' ) { ?> selected="selected"<?php } ?> value="gabonese">Gabonese</option>
                        <option <?php if( $otherNationality == 'gambian' ) { ?> selected="selected"<?php } ?> value="gambian">Gambian</option>
                        <option <?php if( $otherNationality == 'georgian' ) { ?> selected="selected"<?php } ?> value="georgian">Georgian</option>
                        <option <?php if( $otherNationality == 'german' ) { ?> selected="selected"<?php } ?> value="german">German</option>
                        <option <?php if( $otherNationality == 'ghanaian' ) { ?> selected="selected"<?php } ?> value="ghanaian">Ghanaian</option>
                        <option <?php if( $otherNationality == 'greek' ) { ?> selected="selected"<?php } ?> value="greek">Greek</option>
                        <option <?php if( $otherNationality == 'grenadian' ) { ?> selected="selected"<?php } ?> value="grenadian">Grenadian</option>
                        <option <?php if( $otherNationality == 'guatemalan' ) { ?> selected="selected"<?php } ?> value="guatemalan">Guatemalan</option>
                        <option <?php if( $otherNationality == 'guinea-bissauan' ) { ?> selected="selected"<?php } ?> value="guinea-bissauan">Guinea-Bissauan</option>
                        <option <?php if( $otherNationality == 'guinean' ) { ?> selected="selected"<?php } ?> value="guinean">Guinean</option>
                        <option <?php if( $otherNationality == 'guyanese' ) { ?> selected="selected"<?php } ?> value="guyanese">Guyanese</option>
                        <option <?php if( $otherNationality == 'haitian' ) { ?> selected="selected"<?php } ?> value="haitian">Haitian</option>
                        <option <?php if( $otherNationality == 'herzegovinian' ) { ?> selected="selected"<?php } ?> value="herzegovinian">Herzegovinian</option>
                        <option <?php if( $otherNationality == 'honduran' ) { ?> selected="selected"<?php } ?> value="honduran">Honduran</option>
                        <option <?php if( $otherNationality == 'hungarian' ) { ?> selected="selected"<?php } ?> value="hungarian">Hungarian</option>
                        <option <?php if( $otherNationality == 'icelander' ) { ?> selected="selected"<?php } ?> value="icelander">Icelander</option>
                        <option <?php if( $otherNationality == 'indian' ) { ?> selected="selected"<?php } ?> value="indian">Indian</option>
                        <option <?php if( $otherNationality == 'indonesian' ) { ?> selected="selected"<?php } ?> value="indonesian">Indonesian</option>
                        <option <?php if( $otherNationality == 'iranian' ) { ?> selected="selected"<?php } ?> value="iranian">Iranian</option>
                        <option <?php if( $otherNationality == 'iraqi' ) { ?> selected="selected"<?php } ?> value="iraqi">Iraqi</option>
                        <option <?php if( $otherNationality == 'irish' ) { ?> selected="selected"<?php } ?> value="irish">Irish</option>
                        <option <?php if( $otherNationality == 'israeli' ) { ?> selected="selected"<?php } ?> value="israeli">Israeli</option>
                        <option <?php if( $otherNationality == 'italian' ) { ?> selected="selected"<?php } ?> value="italian">Italian</option>
                        <option <?php if( $otherNationality == 'ivorian' ) { ?> selected="selected"<?php } ?> value="ivorian">Ivorian</option>
                        <option <?php if( $otherNationality == 'jamaican' ) { ?> selected="selected"<?php } ?> value="jamaican">Jamaican</option>
                        <option <?php if( $otherNationality == 'japanese' ) { ?> selected="selected"<?php } ?> value="japanese">Japanese</option>
                        <option <?php if( $otherNationality == 'jordanian' ) { ?> selected="selected"<?php } ?> value="jordanian">Jordanian</option>
                        <option <?php if( $otherNationality == 'kazakhstani' ) { ?> selected="selected"<?php } ?> value="kazakhstani">Kazakhstani</option>
                        <option <?php if( $otherNationality == 'kenyan' ) { ?> selected="selected"<?php } ?> value="kenyan">Kenyan</option>
                        <option <?php if( $otherNationality == 'kittian and nevisian' ) { ?> selected="selected"<?php } ?> value="kittian and nevisian">Kittian and Nevisian</option>
                        <option <?php if( $otherNationality == 'kuwaiti' ) { ?> selected="selected"<?php } ?> value="kuwaiti">Kuwaiti</option>
                        <option <?php if( $otherNationality == 'kyrgyz' ) { ?> selected="selected"<?php } ?> value="kyrgyz">Kyrgyz</option>
                        <option <?php if( $otherNationality == 'laotian' ) { ?> selected="selected"<?php } ?> value="laotian">Laotian</option>
                        <option <?php if( $otherNationality == 'latvian' ) { ?> selected="selected"<?php } ?> value="latvian">Latvian</option>
                        <option <?php if( $otherNationality == 'lebanese' ) { ?> selected="selected"<?php } ?> value="lebanese">Lebanese</option>
                        <option <?php if( $otherNationality == 'liberian' ) { ?> selected="selected"<?php } ?> value="liberian">Liberian</option>
                        <option <?php if( $otherNationality == 'libyan' ) { ?> selected="selected"<?php } ?> value="libyan">Libyan</option>
                        <option <?php if( $otherNationality == 'liechtensteiner' ) { ?> selected="selected"<?php } ?> value="liechtensteiner">Liechtensteiner</option>
                        <option <?php if( $otherNationality == 'lithuanian' ) { ?> selected="selected"<?php } ?> value="lithuanian">Lithuanian</option>
                        <option <?php if( $otherNationality == 'luxembourger' ) { ?> selected="selected"<?php } ?> value="luxembourger">Luxembourger</option>
                        <option <?php if( $otherNationality == 'macedonian' ) { ?> selected="selected"<?php } ?> value="macedonian">Macedonian</option>
                        <option <?php if( $otherNationality == 'malagasy' ) { ?> selected="selected"<?php } ?> value="malagasy">Malagasy</option>
                        <option <?php if( $otherNationality == 'malawian' ) { ?> selected="selected"<?php } ?> value="malawian">Malawian</option>
                        <option <?php if( $otherNationality == 'malaysian' ) { ?> selected="selected"<?php } ?> value="malaysian">Malaysian</option>
                        <option <?php if( $otherNationality == 'maldivan' ) { ?> selected="selected"<?php } ?> value="maldivan">Maldivan</option>
                        <option <?php if( $otherNationality == 'malian' ) { ?> selected="selected"<?php } ?> value="malian">Malian</option>
                        <option <?php if( $otherNationality == 'maltese' ) { ?> selected="selected"<?php } ?> value="maltese">Maltese</option>
                        <option <?php if( $otherNationality == 'marshallese' ) { ?> selected="selected"<?php } ?> value="marshallese">Marshallese</option>
                        <option <?php if( $otherNationality == 'mauritanian' ) { ?> selected="selected"<?php } ?> value="mauritanian">Mauritanian</option>
                        <option <?php if( $otherNationality == 'mauritian' ) { ?> selected="selected"<?php } ?> value="mauritian">Mauritian</option>
                        <option <?php if( $otherNationality == 'mexican' ) { ?> selected="selected"<?php } ?> value="mexican">Mexican</option>
                        <option <?php if( $otherNationality == 'micronesian' ) { ?> selected="selected"<?php } ?> value="micronesian">Micronesian</option>
                        <option <?php if( $otherNationality == 'moldovan' ) { ?> selected="selected"<?php } ?> value="moldovan">Moldovan</option>
                        <option <?php if( $otherNationality == 'monacan' ) { ?> selected="selected"<?php } ?> value="monacan">Monacan</option>
                        <option <?php if( $otherNationality == 'mongolian' ) { ?> selected="selected"<?php } ?> value="mongolian">Mongolian</option>
                        <option <?php if( $otherNationality == 'moroccan' ) { ?> selected="selected"<?php } ?> value="moroccan">Moroccan</option>
                        <option <?php if( $otherNationality == 'mosotho' ) { ?> selected="selected"<?php } ?> value="mosotho">Mosotho</option>
                        <option <?php if( $otherNationality == 'motswana' ) { ?> selected="selected"<?php } ?> value="motswana">Motswana</option>
                        <option <?php if( $otherNationality == 'mozambican' ) { ?> selected="selected"<?php } ?> value="mozambican">Mozambican</option>
                        <option <?php if( $otherNationality == 'namibian' ) { ?> selected="selected"<?php } ?> value="namibian">Namibian</option>
                        <option <?php if( $otherNationality == 'nauruan' ) { ?> selected="selected"<?php } ?> value="nauruan">Nauruan</option>
                        <option <?php if( $otherNationality == 'nepalese' ) { ?> selected="selected"<?php } ?> value="nepalese">Nepalese</option>
                        <option <?php if( $otherNationality == 'new zealander' ) { ?> selected="selected"<?php } ?> value="new zealander">New Zealander</option>
                        <option <?php if( $otherNationality == 'ni-vanuatu' ) { ?> selected="selected"<?php } ?> value="ni-vanuatu">Ni-Vanuatu</option>
                        <option <?php if( $otherNationality == 'nicaraguan' ) { ?> selected="selected"<?php } ?> value="nicaraguan">Nicaraguan</option>
                        <option <?php if( $otherNationality == 'nigerien' ) { ?> selected="selected"<?php } ?> value="nigerien">Nigerien</option>
                        <option <?php if( $otherNationality == 'north korean' ) { ?> selected="selected"<?php } ?> value="north korean">North Korean</option>
                        <option <?php if( $otherNationality == 'northern irish' ) { ?> selected="selected"<?php } ?> value="northern irish">Northern Irish</option>
                        <option <?php if( $otherNationality == 'norwegian' ) { ?> selected="selected"<?php } ?> value="norwegian">Norwegian</option>
                        <option <?php if( $otherNationality == 'omani' ) { ?> selected="selected"<?php } ?> value="omani">Omani</option>
                        <option <?php if( $otherNationality == 'pakistani' ) { ?> selected="selected"<?php } ?> value="pakistani">Pakistani</option>
                        <option <?php if( $otherNationality == 'palauan' ) { ?> selected="selected"<?php } ?> value="palauan">Palauan</option>
                        <option <?php if( $otherNationality == 'panamanian' ) { ?> selected="selected"<?php } ?> value="panamanian">Panamanian</option>
                        <option <?php if( $otherNationality == 'papua new guinean' ) { ?> selected="selected"<?php } ?> value="papua new guinean">Papua New Guinean</option>
                        <option <?php if( $otherNationality == 'paraguayan' ) { ?> selected="selected"<?php } ?> value="paraguayan">Paraguayan</option>
                        <option <?php if( $otherNationality == 'peruvian' ) { ?> selected="selected"<?php } ?> value="peruvian">Peruvian</option>
                        <option <?php if( $otherNationality == 'polish' ) { ?> selected="selected"<?php } ?> value="polish">Polish</option>
                        <option <?php if( $otherNationality == 'portuguese' ) { ?> selected="selected"<?php } ?> value="portuguese">Portuguese</option>
                        <option <?php if( $otherNationality == 'qatari' ) { ?> selected="selected"<?php } ?> value="qatari">Qatari</option>
                        <option <?php if( $otherNationality == 'romanian' ) { ?> selected="selected"<?php } ?> value="romanian">Romanian</option>
                        <option <?php if( $otherNationality == 'russian' ) { ?> selected="selected"<?php } ?> value="russian">Russian</option>
                        <option <?php if( $otherNationality == 'rwandan' ) { ?> selected="selected"<?php } ?> value="rwandan">Rwandan</option>
                        <option <?php if( $otherNationality == 'saint lucian' ) { ?> selected="selected"<?php } ?> value="saint lucian">Saint Lucian</option>
                        <option <?php if( $otherNationality == 'salvadoran' ) { ?> selected="selected"<?php } ?> value="salvadoran">Salvadoran</option>
                        <option <?php if( $otherNationality == 'samoan' ) { ?> selected="selected"<?php } ?> value="samoan">Samoan</option>
                        <option <?php if( $otherNationality == 'san marinese' ) { ?> selected="selected"<?php } ?> value="san marinese">San Marinese</option>
                        <option <?php if( $otherNationality == 'sao tomean' ) { ?> selected="selected"<?php } ?> value="sao tomean">Sao Tomean</option>
                        <option <?php if( $otherNationality == 'saudi' ) { ?> selected="selected"<?php } ?> value="saudi">Saudi</option>
                        <option <?php if( $otherNationality == 'scottish' ) { ?> selected="selected"<?php } ?> value="scottish">Scottish</option>
                        <option <?php if( $otherNationality == 'senegalese' ) { ?> selected="selected"<?php } ?> value="senegalese">Senegalese</option>
                        <option <?php if( $otherNationality == 'serbian' ) { ?> selected="selected"<?php } ?> value="serbian">Serbian</option>
                        <option <?php if( $otherNationality == 'seychellois' ) { ?> selected="selected"<?php } ?> value="seychellois">Seychellois</option>
                        <option <?php if( $otherNationality == 'sierra leonean' ) { ?> selected="selected"<?php } ?> value="sierra leonean">Sierra Leonean</option>
                        <option <?php if( $otherNationality == 'singaporean' ) { ?> selected="selected"<?php } ?> value="singaporean">Singaporean</option>
                        <option <?php if( $otherNationality == 'slovakian' ) { ?> selected="selected"<?php } ?> value="slovakian">Slovakian</option>
                        <option <?php if( $otherNationality == 'slovenian' ) { ?> selected="selected"<?php } ?> value="slovenian">Slovenian</option>
                        <option <?php if( $otherNationality == 'solomon islander' ) { ?> selected="selected"<?php } ?> value="solomon islander">Solomon Islander</option>
                        <option <?php if( $otherNationality == 'somali' ) { ?> selected="selected"<?php } ?> value="somali">Somali</option>
                        <option <?php if( $otherNationality == 'south african' ) { ?> selected="selected"<?php } ?> value="south african">South African</option>
                        <option <?php if( $otherNationality == 'south korean' ) { ?> selected="selected"<?php } ?> value="south korean">South Korean</option>
                        <option <?php if( $otherNationality == 'spanish' ) { ?> selected="selected"<?php } ?> value="spanish">Spanish</option>
                        <option <?php if( $otherNationality == 'sri lankan' ) { ?> selected="selected"<?php } ?> value="sri lankan">Sri Lankan</option>
                        <option <?php if( $otherNationality == 'sudanese' ) { ?> selected="selected"<?php } ?> value="sudanese">Sudanese</option>
                        <option <?php if( $otherNationality == 'surinamer' ) { ?> selected="selected"<?php } ?> value="surinamer">Surinamer</option>
                        <option <?php if( $otherNationality == 'swazi' ) { ?> selected="selected"<?php } ?> value="swazi">Swazi</option>
                        <option <?php if( $otherNationality == 'swedish' ) { ?> selected="selected"<?php } ?> value="swedish">Swedish</option>
                        <option <?php if( $otherNationality == 'swiss' ) { ?> selected="selected"<?php } ?> value="swiss">Swiss</option>
                        <option <?php if( $otherNationality == 'syrian' ) { ?> selected="selected"<?php } ?> value="syrian">Syrian</option>
                        <option <?php if( $otherNationality == 'taiwanese' ) { ?> selected="selected"<?php } ?> value="taiwanese">Taiwanese</option>
                        <option <?php if( $otherNationality == 'tajik' ) { ?> selected="selected"<?php } ?> value="tajik">Tajik</option>
                        <option <?php if( $otherNationality == 'tanzanian' ) { ?> selected="selected"<?php } ?> value="tanzanian">Tanzanian</option>
                        <option <?php if( $otherNationality == 'thai' ) { ?> selected="selected"<?php } ?> value="thai">Thai</option>
                        <option <?php if( $otherNationality == 'togolese' ) { ?> selected="selected"<?php } ?> value="togolese">Togolese</option>
                        <option <?php if( $otherNationality == 'tongan' ) { ?> selected="selected"<?php } ?> value="tongan">Tongan</option>
                        <option <?php if( $otherNationality == 'trinidadian or tobagonian' ) { ?> selected="selected"<?php } ?> value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
                        <option <?php if( $otherNationality == 'tunisian' ) { ?> selected="selected"<?php } ?> value="tunisian">Tunisian</option>
                        <option <?php if( $otherNationality == 'turkish' ) { ?> selected="selected"<?php } ?> value="turkish">Turkish</option>
                        <option <?php if( $otherNationality == 'tuvaluan' ) { ?> selected="selected"<?php } ?> value="tuvaluan">Tuvaluan</option>
                        <option <?php if( $otherNationality == 'ugandan' ) { ?> selected="selected"<?php } ?> value="ugandan">Ugandan</option>
                        <option <?php if( $otherNationality == 'ukrainian' ) { ?> selected="selected"<?php } ?> value="ukrainian">Ukrainian</option>
                        <option <?php if( $otherNationality == 'uruguayan' ) { ?> selected="selected"<?php } ?> value="uruguayan">Uruguayan</option>
                        <option <?php if( $otherNationality == 'uzbekistani' ) { ?> selected="selected"<?php } ?> value="uzbekistani">Uzbekistani</option>
                        <option <?php if( $otherNationality == 'venezuelan' ) { ?> selected="selected"<?php } ?> value="venezuelan">Venezuelan</option>
                        <option <?php if( $otherNationality == 'vietnamese' ) { ?> selected="selected"<?php } ?> value="vietnamese">Vietnamese</option>
                        <option <?php if( $otherNationality == 'welsh' ) { ?> selected="selected"<?php } ?> value="welsh">Welsh</option>
                        <option <?php if( $otherNationality == 'yemenite' ) { ?> selected="selected"<?php } ?> value="yemenite">Yemenite</option>
                        <option <?php if( $otherNationality == 'zambian' ) { ?> selected="selected"<?php } ?> value="zambian">Zambian</option>
                        <option <?php if( $otherNationality == 'zimbabwean' ) { ?> selected="selected"<?php } ?> value="zimbabwean">Zimbabwean</option>
                    </select>
                </div>
                <div class="input-group col-md-50 mb-10">
                    <label for="living_status">Living with Family:</label>
                    <?php $livingStatus = get_the_author_meta( 'living_status', $user_id ); //echo $nationality ?>
                    <select name="living_status" id="living_status" class="required">
                        <option value="">-- Select --</option>
                        <option value="yes" <?php if( $livingStatus == 'yes' ) { ?> selected="selected"<?php } ?>>Yes</option>
                        <option value="no" <?php if( $livingStatus == 'no' ) { ?> selected="selected"<?php } ?>>No</option>
                    </select>
                </div>
            </div>
            <?php
            $spousesname = get_the_author_meta( 'spouse_name', $user_id );
            $spousesqid = get_the_author_meta( 'spouse_qid', $user_id );
            if( !empty( $spousesname ) ) { ?>
                <div class="row family">
                    <div class="input-group col-md-50 mb-10">
                        <label for="spouse_name">Spouse Name:</label>
                        <?php
                        if( !empty( $spousesname ) ) {
            			    foreach($spousesname as $spousename){
            			        ?>
            				    <input type="text" name="spouse_name[]" value="<?php echo esc_attr( $spousename ); ?>" class="required alpha" /><br />
            			        <?php
            			    }
        			    }
        			    ?>
                    </div>
                    <div class="input-group col-md-50 mb-10 w-50 pl-5">
                        <label for="spouse_qid">Spouse QID:</label>
                        <?php
                        if( !empty( $spousesqid ) ) {
            			    foreach($spousesqid as $spouseqid){
            			        ?>
            			        <input type="text" name="spouse_qid[]" minlength="11" maxlength="11" value="<?php echo esc_attr( $spouseqid ); ?>" class="required numeric" /><br />
            			        <?php
            			    }
        			    }
        			    ?>
                    </div>
                </div>
                <?php
            }
            $childsname = get_the_author_meta( 'child_name', $user_id );
            $childsqid = get_the_author_meta( 'child_qid', $user_id );
            if( !empty( $childsname ) ) { ?>
                <div class="row family">
                    <div class="input-group col-md-50 mb-10">
                        <label for="child_name">Child Name:</label>
                        <?php
                        if( !empty( $childsname ) ) {
            			    foreach($childsname as $childname){
            			        ?>
            				    <input type="text" name="child_name[]" value="<?php echo esc_attr( $childname ); ?>" class="required alpha" /><br />
            			        <?php
            			    }
        			    }
        			    ?>
                    </div>
                    <div class="input-group col-md-50 mb-10 w-50 pl-5">
                        <label for="child_qid">Child QID:</label>
                        <?php
                        if( !empty( $childsqid ) ) {
            			    foreach($childsqid as $childqid){
            			        ?>
            			        <input type="text" name="child_qid[]" minlength="11" maxlength="11" value="<?php echo esc_attr( $childqid ); ?>" class="required numeric" /><br />
            			        <?php
            			    }
        			    }
        			    ?>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="input-group col-md-100 mb-10">
                    <a href="#" class="add_new_family_option button htb-btn-success" title="Add More"><i class="fa fa-plus"></i>Add more family details</a>
                </div>
            </div>
            <div class="edit_family_details_option">
                <div class="row">
                    <div class="family-details spouse col-md-100">
                        <div class="row spouse_details" id="spouse-1">
                            <div class="input-group col-md-80 mb-10">
                                <div class="row">
                                    <div class="input-group col-md-50 mb-10">
                                        <label for="spouse_name[]">Spouse Name</label>
                                        <input type="text" name="spouse_name[]" placeholder="Please enter your spouse name" class="spouse-name">
                                    </div>
                                    <div class="input-group col-md-50 mb-10">
                                        <label for="spouse_qid[]">Spouse QID:</label>
                                        <input type="text" name="spouse_qid[]" minlength="11" maxlength="11" placeholder="Please enter your spouse QID number" class="spouse-qid numeric">
                                    </div>
                                </div>
                            </div>
                            <div class="input-group col-md-20 mb-10 right-align">
                                <a href="#" class="add_new_spouse button htb-btn-success mr-10" title="Add More"><i class="fa fa-plus"></i></a>
                                <a href="#" class="remove_spouse_row button htb-btn-danger" data-id="2" title="Remove"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="family-details child col-md-100">
                        <div class="row child_details" id="child-1">
                            <div class="input-group col-md-80 mb-10">
                                <div class="row">
                                    <div class="input-group col-md-50 mb-10">
                                        <label for="child_name[]">Child Name</label>
                                        <input type="text" name="child_name[]" placeholder="Please enter your child name" class="child-name">
                                    </div>
                                    <div class="input-group col-md-50 mb-10">
                                        <label for="child_qid[]">Child QID:</label>
                                        <input type="text" name="child_qid[]" minlength="11" maxlength="11" placeholder="Please enter your child QID number" class="child-name numeric">
                                    </div>
                                </div>
                            </div>
                            <div class="input-group col-md-20 mb-10 right-align">
                                <a href="#" class="add_new_child button htb-btn-success mr-10" title="Add More"><i class="fa fa-plus"></i></a>
                                <a href="#" class="remove_child_row button htb-btn-danger" data-id="2" title="Remove"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="date_of_birth">Date of Birth:</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo esc_attr( get_the_author_meta( 'date_of_birth', $user_id ) ); ?>" class="required">
                </div>
                <div class="input-group col-md-50 mb-10 w-50 pl-5">
                    <label for="father_name">Father's Name:</label>
                    <input type="text" id="father_name" name="father_name" value="<?php echo esc_attr( get_the_author_meta( 'father_name', $user_id ) ); ?>" class="required alpha">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="gender">Gender:</label>
                    <?php $gender = get_the_author_meta( 'gender', $user_id ); ?>
    				<select name="gender" id="gender" class="required">
                        <option value="male" <?php if( $gender == 'male' ) { ?> selected="selected"<?php } ?>>Male</option>
                        <option value="female" <?php if( $gender == 'female' ) { ?> selected="selected"<?php } ?>>Female</option>
                    </select>
                </div>
                <div class="input-group col-md-50 mb-10 w-50 pl-5">
                    <label for="marital_status">Marital Status:</label>
                    <?php $maritalStatus = get_the_author_meta( 'marital_status', $user_id ); ?>
    				<select name="marital_status" id="marital_status" class="required">
                        <option value="married" <?php if( $maritalStatus == 'married' ) { ?> selected="selected"<?php } ?>>Married</option>
                        <option value="unmarried" <?php if( $maritalStatus == 'unmarried' ) { ?> selected="selected"<?php } ?>>Unmarried</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10 w-50 pl-5">
                    <label for="job_title">Job Title/Job Place:</label>
                    <input type="text" id="job_title" name="job_title" value="<?php echo esc_attr( get_the_author_meta( 'job_title', $user_id ) ); ?>" class="required alpha">
                </div>
                <div class="input-group col-md-50 mb-10 w-50 pl-5">
                    <label for="job_place">Job Place:</label>
                    <input type="text" id="job_place" name="job_place" value="<?php echo esc_attr( get_the_author_meta( 'job_place', $user_id ) ); ?>" class="required alpha">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="visa_qid">Visa or QID:</label>
                    <input type="text" id="visa_qid" name="visa_qid" minlength="11" maxlength="13" value="<?php echo esc_attr( get_the_author_meta( 'visa_qid', $user_id ) ); ?>" class="required numeric">
                </div>
                <div class="input-group col-md-50 mb-10 w-50 pl-5">
                    <label for="cnic_nicop_poc">CNIC/NICOP/POC No.:</label>
                    <input type="text" id="cnic_nicop_poc" name="cnic_nicop_poc" minlength="13" maxlength="13" value="<?php echo esc_attr( get_the_author_meta( 'cnic_nicop_poc', $user_id ) ); ?>" class="required numeric">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="mobile_number">Mobile No.:</label>
                    <input type="text" id="mobile_number" minlength="8" maxlength="8" name="mobile_number" value="<?php echo esc_attr( get_the_author_meta( 'mobile_number', $user_id ) ); ?>" class="required numeric">
                </div>
                <div class="input-group col-md-50 mb-10">
                    <label for="qatar_address">Address in Qatar:</label>
                    <input type="text" id="qatar_address" name="qatar_address" value="<?php echo esc_attr( get_the_author_meta( 'qatar_address', $user_id ) ); ?>" class="required">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10 w-50 pl-5">
                    <label for="arrival_date">Date of permanent arrival in Qatar:</label>
                    <input type="date" id="arrival_date" name="arrival_date" value="<?php echo esc_attr( get_the_author_meta( 'arrival_date', $user_id ) ); ?>" class="required">
                </div>
                <div class="input-group col-md-50 mb-10">
                    <label for="embassy_registration_number">Embassy registration No.:</label>
                    <input type="text" id="embassy_registration_number" minlength="6" maxlength="15" name="embassy_registration_number" value="<?php echo esc_attr( get_the_author_meta( 'embassy_registration_number', $user_id ) ); ?>" class="required">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="occupation_designation">Occupation/Designation:</label>
                    <input type="text" id="occupation_designation" name="occupation_designation" value="<?php echo esc_attr( get_the_author_meta( 'occupation_designation', $user_id ) ); ?>" class="required alpha">
                </div>
                <div class="input-group col-md-50 mb-10 w-50 pl-5">
                    <label for="employer">Employer:</label>
                    <input type="text" id="employer" name="employer" value="<?php echo esc_attr( get_the_author_meta( 'employer', $user_id ) ); ?>" class="required alpha">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="expertise">Field of Expertise:</label>
                    <input type="text" id="expertise" name="expertise" value="<?php echo esc_attr( get_the_author_meta( 'expertise', $user_id ) ); ?>" class="required alpha">
                </div>
                <div class="input-group col-md-50 mb-10">
                    <label for="district">Home District/District of Domicile:</label>
                    <input type="text" id="district" name="district" value="<?php echo esc_attr( get_the_author_meta( 'district', $user_id ) ); ?>" class="required alpha">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" maxlength="25" value="<?php echo esc_attr( get_the_author_meta( 'user_login', $user_id ) ); ?>" disabled="disabled">
                </div>
                <div class="input-group col-md-50 mb-10">
                    <label for="mail_id">Email:</label>
                    <input type="text" id="mail_id" name="mail_id" value="<?php echo esc_attr( get_the_author_meta( 'email', $user_id ) ); ?>" disabled="disabled">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <label for="user_password">Change Password:</label>
                    <input type="password" id="user_password" name="user_password" value="<?php echo esc_attr( get_the_author_meta( 'pass1', $user_id ) ); ?>">
                    <div class="checkbox">
                        <input type="checkbox" id="show_password" value="show">
                        <label for="show_password">Show Password</label>
                    </div>
                </div>
                <div class="input-group col-md-50 mb-10">
                    <label for="contact_pakistan">Contact in Pakistan:</label>
                    <input type="text" id="contact_pakistan" minlength="11" maxlength="11" name="contact_pakistan" value="<?php echo esc_attr( get_the_author_meta( 'contact_pakistan', $user_id ) ); ?>" class="required numeric">
                </div>
            </div>
            <div class="row">
                <div class="input-group col-md-50 mb-10">
                    <input type="submit" value="Update Information" id="update_user">
                </div>
            </div>
        </form>
        <script type="text/javascript">
            jQuery(document).ready(function($){
                jQuery('#update_user').on('click',function(e){
                    e.preventDefault();
                    if (!jQuery('#edit_profile').valid()) return false;
        
                    var username                    = jQuery("#username").val();
                    var mail_id                     = jQuery("#mail_id").val();
                    var first_name                  = jQuery("#first_name").val();
                    var last_name                   = jQuery("#last_name").val();
                    var nationality                 = jQuery("#nationality").val();
                    var passport_number             = jQuery("#passport_number").val();
                    var other_nationality           = jQuery("#other_nationality").val();
                    var living_status               = jQuery("#living_status").val();
                    var date_of_birth               = jQuery("#date_of_birth").val();
                    var father_name                 = jQuery("#father_name").val();
                    var gender                      = jQuery("#gender").val();
                    var marital_status              = jQuery("#marital_status").val();
                    var job_title                   = jQuery("#job_title").val();
                    var job_place                   = jQuery("#job_place").val();
                    var visa_qid                    = jQuery("#visa_qid").val();
                    var cnic_nicop_poc              = jQuery("#cnic_nicop_poc").val();
                    var mobile_number               = jQuery("#mobile_number").val();
                    var qatar_address               = jQuery("#qatar_address").val();
                    var arrival_date                = jQuery("#arrival_date").val();
                    var embassy_registration_number = jQuery("#embassy_registration_number").val();
                    var occupation_designation      = jQuery("#occupation_designation").val();
                    var employer                    = jQuery("#employer").val();
                    var expertise                   = jQuery("#expertise").val();
                    var district                    = jQuery("#district").val();
                    var contact_pakistan            = jQuery("#contact_pakistan").val();
                    var user_password               = jQuery("#user_password").val();
                    var security                    = jQuery("#signonsecurity").val();

                    var spouse_name = [];
                    var spouse_qid = [];
                    var child_name = [];
                    var child_qid = [];

                    // Initializing array with Checkbox checked values
                    jQuery("input[name='spouse_name[]']").each(function(){
                        spouse_name.push(this.value);
                    });
                    jQuery("input[name='spouse_qid[]']").each(function(){
                        spouse_qid.push(this.value);
                    });
                    $("input[name='child_name[]']").each(function(){
                        child_name.push(this.value);
                    });
                    $("input[name='child_qid[]']").each(function(){
                        child_qid.push(this.value);
                    });

                    jQuery.ajax({
                        type:"POST",
                        url:"<?php echo admin_url('admin-ajax.php'); ?>",
                        data: {
                            action: "edit_user_front_end",
                            username : username,
                            mail_id : mail_id,
                            first_name : first_name,
                            last_name : last_name,
                            nationality : nationality,
                            passport_number : passport_number,
                            other_nationality : other_nationality,
                            living_status : living_status,
                            spouse_name : spouse_name,
                            spouse_qid : spouse_qid,
                            child_name : child_name,
                            child_qid : child_qid,
                            date_of_birth : date_of_birth,
                            father_name : father_name,
                            gender : gender,
                            marital_status : marital_status,
                            job_title : job_title,
                            job_place : job_place,
                            visa_qid : visa_qid,
                            cnic_nicop_poc : cnic_nicop_poc,
                            mobile_number : mobile_number,
                            qatar_address : qatar_address,
                            arrival_date : arrival_date,
                            embassy_registration_number : embassy_registration_number,
                            occupation_designation : occupation_designation,
                            employer : employer,
                            expertise : expertise,
                            district : district,
                            contact_pakistan : contact_pakistan,
                            user_password : user_password
                        },
                        success: function(results){
                            // console.log(results);
                            jQuery('.register-message').text(results).show();
                            jQuery('.register-message').addClass('edited mb-20');
                            jQuery('#register').hide();
                            /*setTimeout(function(){
                                document.location.href = <?php echo $_SERVER['REQUEST_URI']; ?>;
                            }, 3000);*/
                        },
                        error: function(results) {
                            // console.log(results);
                            jQuery('.register-message').text(results).show();
                        }
                    });
                });
            });
        </script>
        <?php
    }
}
add_shortcode('register_shortcode', 'editProfileFunction');