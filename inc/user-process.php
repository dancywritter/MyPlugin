<?php
// Register User Ajax
add_action('wp_ajax_register_user_front_end', 'register_user_front_end', 0);
add_action('wp_ajax_nopriv_register_user_front_end', 'register_user_front_end');
function register_user_front_end() {
	global $current_user;

    $first_name         = $_POST['first_name'];
    $last_name          = $_POST['last_name'];
    $nationality        = $_POST['nationality'];
    $passportNo         = $_POST['passport_number'];
    $otherNationality   = $_POST['other_nationality'];
    $livingStatus       = $_POST['living_status'];
    $spouseName         = $_POST['spouse_name'];
    $spouseQID          = $_POST['spouse_qid'];
    $childName          = $_POST['child_name'];
    $childQID           = $_POST['child_qid'];
    $dateOfBirth        = $_POST['date_of_birth'];
    $fatherName         = $_POST['father_name'];
    $gender             = $_POST['gender'];
    $maritalStatus      = $_POST['marital_status'];
    $jobTitle           = $_POST['job_title'];
    $jobPlace           = $_POST['job_place'];
    $visaQid            = $_POST['visa_qid'];
    $cnicNicopPoc       = $_POST['cnic_nicop_poc'];
    $mobileNumber       = $_POST['mobile_number'];
    $qatarAddr          = $_POST['qatar_address'];
    $arrivalDate        = $_POST['arrival_date'];
    $embassyRegNumber   = $_POST['embassy_registration_number'];
    $occupationDesig    = $_POST['occupation_designation'];
    $employer           = $_POST['employer'];
    $expertise          = $_POST['expertise'];
    $district           = $_POST['district'];
    $contact_pakistan   = $_POST['contact_pakistan'];
    $user_login         = $_POST['username'];
    $user_pass          = stripcslashes( $_POST['user_password'] );
    $user_email         = stripcslashes( $_POST['mail_id'] );
    $user_nice_name     = $_POST['first_name'];

    $user_data = array(
        'first_name'                    => $first_name,
        'last_name'                     => $last_name,
        'nationality'                   => $nationality,
        'passport_number'               => $passportNo,
        'other_nationality'             => $otherNationality,
        'living_status'                 => $livingStatus,
        'spouse_name'                   => $spouseName,
        'spouse_qid'                    => $spouseQID,
        'child_name'                    => $childName,
        'child_qid'                     => $childQID,
        'date_of_birth'                 => $dateOfBirth,
        'father_name'                   => $fatherName,
        'gender'                        => $gender,
        'marital_status'                => $maritalStatus,
        'job_title'                     => $jobTitle,
        'job_place'                     => $jobPlace,
        'visa_qid'                      => $visaQid,
        'cnic_nicop_poc'                => $cnicNicopPoc,
        'mobile_number'                 => $mobileNumber,
        'qatar_address'                 => $qatarAddr,
        'arrival_date'                  => $arrivalDate,
        'embassy_registration_number'   => $embassyRegNumber,
        'occupation_designation'        => $occupationDesig,
        'employer'                      => $employer,
        'expertise'                     => $expertise,
        'district'                      => $district,
        'contact_pakistan'              => $contact_pakistan,
        'user_login'                    => $user_login,
        'user_email'                    => $user_email,
        'user_pass'                     => $user_pass,
        'user_nicename'                 => $user_nice_name,
        'display_name'                  => $first_name,
    );
    $user_id = username_exists( $user_login );
    if ( ! $user_id && false == email_exists( $user_email ) ) {
        $user_info = wp_insert_user($user_data);
    }

    $user_id = $user_info;
    if (!is_wp_error($user_info)) {
        echo 'Congratulations! Your account has been created successfully.';

    } else {
        if (isset($user_info->errors['empty_user_login'])) {
            $notice_key = 'Username and Email are mandatory.';
            echo $notice_key;
        } elseif (isset($user_info->errors['existing_user_login'])) {
            echo'This username is already registered.';
        } else {
            echo'Error Occured please fill up the sign up form carefully.';
        }
    }
	die;
}
add_action( 'user_register', 'save_user_fields' );
function save_user_fields( $user_id ) {

    if ( !empty( $_POST['first_name'] ) ) {
        update_user_meta( $user_id, 'first_name', $_POST['first_name'] );

    }
    if ( !empty( $_POST['last_name'] ) ) {
        update_user_meta( $user_id, 'last_name', $_POST['last_name'] );

    }
    if ( !empty( $_POST['nationality'] ) ) {
        update_user_meta( $user_id, 'nationality', $_POST['nationality'] );

    }
    if ( !empty( $_POST['passport_number'] ) ) {
        update_user_meta( $user_id, 'passport_number', $_POST['passport_number'] );

    }
    if ( !empty( $_POST['other_nationality'] ) ) {
        update_user_meta( $user_id, 'other_nationality', $_POST['other_nationality'] );

    }
    if ( !empty( $_POST['living_status'] ) ) {
        update_user_meta( $user_id, 'living_status', $_POST['living_status'] );

    }
    if ( !empty( $_POST['spouse_name'] ) ) {
        update_user_meta( $user_id, 'spouse_name', $_POST['spouse_name'] );

    }
    if ( !empty( $_POST['spouse_qid'] ) ) {
        update_user_meta( $user_id, 'spouse_qid', $_POST['spouse_qid'] );

    }
    if ( !empty( $_POST['child_name'] ) ) {
        update_user_meta( $user_id, 'child_name', $_POST['child_name'] );

    }
    if ( !empty( $_POST['child_qid'] ) ) {
        update_user_meta( $user_id, 'child_qid', $_POST['child_qid'] );

    }
    if ( !empty( $_POST['date_of_birth'] ) ) {
        update_user_meta( $user_id, 'date_of_birth', $_POST['date_of_birth'] );

    }
    if ( !empty( $_POST['father_name'] ) ) {
        update_user_meta( $user_id, 'father_name', $_POST['father_name'] );

    }
    if ( !empty( $_POST['gender'] ) ) {
        update_user_meta( $user_id, 'gender', $_POST['gender'] );

    }
    if ( !empty( $_POST['marital_status'] ) ) {
        update_user_meta( $user_id, 'marital_status', $_POST['marital_status'] );

    }
    if ( !empty( $_POST['job_title'] ) ) {
        update_user_meta( $user_id, 'job_title', $_POST['job_title'] );

    }
    if ( !empty( $_POST['job_place'] ) ) {
        update_user_meta( $user_id, 'job_place', $_POST['job_place'] );

    }
    if ( !empty( $_POST['visa_qid'] ) ) {
        update_user_meta( $user_id, 'visa_qid', $_POST['visa_qid'] );

    }
    if ( !empty( $_POST['cnic_nicop_poc'] ) ) {
        update_user_meta( $user_id, 'cnic_nicop_poc', $_POST['cnic_nicop_poc'] );

    }
    if ( !empty( $_POST['mobile_number'] ) ) {
        update_user_meta( $user_id, 'mobile_number', $_POST['mobile_number'] );

    }
    if ( !empty( $_POST['qatar_address'] ) ) {
        update_user_meta( $user_id, 'qatar_address', $_POST['qatar_address'] );

    }
    if ( !empty( $_POST['arrival_date'] ) ) {
        update_user_meta( $user_id, 'arrival_date', $_POST['arrival_date'] );

    }
    if ( !empty( $_POST['embassy_registration_number'] ) ) {
        update_user_meta( $user_id, 'embassy_registration_number', $_POST['embassy_registration_number'] );

    }
    if ( !empty( $_POST['occupation_designation'] ) ) {
        update_user_meta( $user_id, 'occupation_designation', $_POST['occupation_designation'] );

    }
    if ( !empty( $_POST['employer'] ) ) {
        update_user_meta( $user_id, 'employer', $_POST['employer'] );

    }
    if ( !empty( $_POST['expertise'] ) ) {
        update_user_meta( $user_id, 'expertise', $_POST['expertise'] );

    }
    if ( !empty( $_POST['district'] ) ) {
        update_user_meta( $user_id, 'district', $_POST['district'] );

    }
    if ( !empty( $_POST['contact_pakistan'] ) ) {
        update_user_meta( $user_id, 'contact_pakistan', $_POST['contact_pakistan'] );

    }
}


// Edit Profile Ajax

add_action('wp_ajax_edit_user_front_end', 'edit_user_front_end', 0);
add_action('wp_ajax_nopriv_edit_user_front_end', 'edit_user_front_end');
function edit_user_front_end() {
	global $current_user;
    
    $user_id = $current_user->ID;

    $first_name         = $_POST['first_name'];
    $last_name          = $_POST['last_name'];
    $nationality        = $_POST['nationality'];
    $passportNo         = $_POST['passport_number'];
    $otherNationality   = $_POST['other_nationality'];
    $livingStatus       = $_POST['living_status'];
    $spouseName         = $_POST['spouse_name'];
    $spouseQID          = $_POST['spouse_qid'];
    $childName          = $_POST['child_name'];
    $childQID           = $_POST['child_qid'];
    $dateOfBirth        = $_POST['date_of_birth'];
    $fatherName         = $_POST['father_name'];
    $gender             = $_POST['gender'];
    $maritalStatus      = $_POST['marital_status'];
    $jobTitle           = $_POST['job_title'];
    $jobPlace           = $_POST['job_place'];
    $visaQid            = $_POST['visa_qid'];
    $cnicNicopPoc       = $_POST['cnic_nicop_poc'];
    $mobileNumber       = $_POST['mobile_number'];
    $qatarAddr          = $_POST['qatar_address'];
    $arrivalDate        = $_POST['arrival_date'];
    $embassyRegNumber   = $_POST['embassy_registration_number'];
    $occupationDesig    = $_POST['occupation_designation'];
    $employer           = $_POST['employer'];
    $expertise          = $_POST['expertise'];
    $district           = $_POST['district'];
    $contact_pakistan   = $_POST['contact_pakistan'];
    $user_login         = $_POST['username'];
    $user_pass          = stripcslashes( $_POST['user_password'] );

    if ( !empty( $_POST['user_password'] ) ) {
        update_user_meta( $user_id, 'user_pass', $_POST['user_password'] );

    }
    if ( !empty( $_POST['first_name'] ) ) {
        update_user_meta( $user_id, 'first_name', $_POST['first_name'] );

    }
    if ( !empty( $_POST['last_name'] ) ) {
        update_user_meta( $user_id, 'last_name', $_POST['last_name'] );

    }
    if ( !empty( $_POST['nationality'] ) ) {
        update_user_meta( $user_id, 'nationality', $_POST['nationality'] );

    }
    if ( !empty( $_POST['passport_number'] ) ) {
        update_user_meta( $user_id, 'passport_number', $_POST['passport_number'] );

    }
    if ( !empty( $_POST['other_nationality'] ) ) {
        update_user_meta( $user_id, 'other_nationality', $_POST['other_nationality'] );

    }
    if ( !empty( $_POST['living_status'] ) ) {
        update_user_meta( $user_id, 'living_status', $_POST['living_status'] );

    }
    if ( !empty( $_POST['spouse_name'] ) ) {
        update_user_meta( $user_id, 'spouse_name', $_POST['spouse_name'] );

    }
    if ( !empty( $_POST['spouse_qid'] ) ) {
        update_user_meta( $user_id, 'spouse_qid', $_POST['spouse_qid'] );

    }
    if ( !empty( $_POST['child_name'] ) ) {
        update_user_meta( $user_id, 'child_name', $_POST['child_name'] );

    }
    if ( !empty( $_POST['child_qid'] ) ) {
        update_user_meta( $user_id, 'child_qid', $_POST['child_qid'] );

    }
    if ( !empty( $_POST['date_of_birth'] ) ) {
        update_user_meta( $user_id, 'date_of_birth', $_POST['date_of_birth'] );

    }
    if ( !empty( $_POST['father_name'] ) ) {
        update_user_meta( $user_id, 'father_name', $_POST['father_name'] );

    }
    if ( !empty( $_POST['gender'] ) ) {
        update_user_meta( $user_id, 'gender', $_POST['gender'] );

    }
    if ( !empty( $_POST['marital_status'] ) ) {
        update_user_meta( $user_id, 'marital_status', $_POST['marital_status'] );

    }
    if ( !empty( $_POST['job_title'] ) ) {
        update_user_meta( $user_id, 'job_title', $_POST['job_title'] );

    }
    if ( !empty( $_POST['job_place'] ) ) {
        update_user_meta( $user_id, 'job_place', $_POST['job_place'] );

    }
    if ( !empty( $_POST['visa_qid'] ) ) {
        update_user_meta( $user_id, 'visa_qid', $_POST['visa_qid'] );

    }
    if ( !empty( $_POST['cnic_nicop_poc'] ) ) {
        update_user_meta( $user_id, 'cnic_nicop_poc', $_POST['cnic_nicop_poc'] );

    }
    if ( !empty( $_POST['mobile_number'] ) ) {
        update_user_meta( $user_id, 'mobile_number', $_POST['mobile_number'] );

    }
    if ( !empty( $_POST['qatar_address'] ) ) {
        update_user_meta( $user_id, 'qatar_address', $_POST['qatar_address'] );

    }
    if ( !empty( $_POST['arrival_date'] ) ) {
        update_user_meta( $user_id, 'arrival_date', $_POST['arrival_date'] );

    }
    if ( !empty( $_POST['embassy_registration_number'] ) ) {
        update_user_meta( $user_id, 'embassy_registration_number', $_POST['embassy_registration_number'] );

    }
    if ( !empty( $_POST['occupation_designation'] ) ) {
        update_user_meta( $user_id, 'occupation_designation', $_POST['occupation_designation'] );

    }
    if ( !empty( $_POST['employer'] ) ) {
        update_user_meta( $user_id, 'employer', $_POST['employer'] );

    }
    if ( !empty( $_POST['expertise'] ) ) {
        update_user_meta( $user_id, 'expertise', $_POST['expertise'] );

    }
    if ( !empty( $_POST['district'] ) ) {
        update_user_meta( $user_id, 'district', $_POST['district'] );

    }
    if ( !empty( $_POST['contact_pakistan'] ) ) {
        update_user_meta( $user_id, 'contact_pakistan', $_POST['contact_pakistan'] );

    }

    $user_id = $user_info;
    if (!is_wp_error($user_info)) {
        echo 'Your information has been saved successfully.';

    } else {
        echo'Error Occured please fill up the sign up form carefully.';
    }
	die;
}

