<?php
function add_custom_user_profile_fields( $user ) {
    $first_name         = trim( $_POST['first_name'] );
    $last_name          = trim( $_POST['last_name'] );
    $username           = trim( $_POST['username'] );
    $password           = trim( $_POST['user_password'] );
    $mail_id            = trim( $_POST['mail_id'] );
    $nationality        = trim( $_POST['nationality'] );
    $passportNo         = trim( $_POST['passport_number'] );
    
    $otherNationality   = trim( $_POST['other_nationality'] );
    $livingStatus       = trim( $_POST['living_status'] );
    $spouseName         = trim( $_POST['spouse_name'] );
    $spouseQID          = trim( $_POST['spouse_qid'] );
    $childName          = trim( $_POST['child_name'] );
    $childQID           = trim( $_POST['child_qid'] );
    $dateOfBirth        = trim( $_POST['date_of_birth'] );
    $fatherName         = trim( $_POST['father_name'] );
    $gender             = trim( $_POST['gender'] );
    $maritalStatus      = trim( $_POST['marital_status'] );
    $jobTitle           = trim( $_POST['job_title'] );
    $jobPlace           = trim( $_POST['job_place'] );
    
    $visaQid            = trim( $_POST['visa_qid'] );
    $cnicNicopPoc       = trim( $_POST['cnic_nicop_poc'] );
    $mobileNumber       = trim( $_POST['mobile_number'] );
    $qatarAddr          = trim( $_POST['qatar_address'] );
    $arrivalDate        = trim( $_POST['arrival_date'] );
    $embassyRegNumber   = trim( $_POST['embassy_registration_number'] );
    $occupationDesig    = trim( $_POST['occupation_designation'] );
    $employer           = trim( $_POST['employer'] );
    $expertise          = trim( $_POST['expertise'] );
    $district           = trim( $_POST['district'] );
    $contact_pakistan   = trim( $_POST['contact_pakistan'] );
    ?>
	<h3>Embassy Users Information</h3>
	<table class="form-table">
		<tr>
			<th>
				<label for="nationality">Nationality</label></th>
			<td>
			    <?php $nationality = get_the_author_meta( 'nationality', $user->ID ); //echo $nationality ?>
			    <select name="nationality" id="nationality">
                    <option value="pakistan" <?php if( $nationality == 'pakistan' ) { ?> selected="selected"<?php } ?>>Pakistan</option>
                    <option value="qatar" <?php if( $nationality == 'qatar' ) { ?> selected="selected"<?php } ?>>Qatar</option>
                </select>
				<span class="description">Please select your nationality.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="passport_number">Passport Number</label></th>
			<td>
				<input type="text" name="passport_number" id="passport_number" minlength="9" maxlength="11" value="<?php echo esc_attr( get_the_author_meta( 'passport_number', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your passport number.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="other_nationality">Other Nationality</label></th>
			<td>
			    <?php $otherNationality = get_the_author_meta( 'other_nationality', $user->ID ); //echo $nationality ?>
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
				<span class="description">Please select other nationality.</span>
			</td>
		</tr>
		<tr>
			<th><label for="living_status">Living with Family:</label></th>
			<td>
			    <?php $livingStatus = get_the_author_meta( 'living_status', $user->ID ); //echo $nationality ?>
                <select name="living_status" id="living_status" class="required">
                    <option value="">-- Select --</option>
                    <option value="yes" <?php if( $livingStatus == 'yes' ) { ?> selected="selected"<?php } ?>>Yes</option>
                    <option value="no" <?php if( $livingStatus == 'no' ) { ?> selected="selected"<?php } ?>>No</option>
                </select>
				<span class="description">Please select your living status.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="spouse_name">Spouse Name</label></th>
			<td>
			    <?php $spousesname = get_the_author_meta( 'spouse_name', $user->ID );
			    foreach($spousesname as $spousename) {
			        ?>
				    <input type="text" name="spouse_name[]" id="spouse_name" value="<?php echo esc_attr( $spousename ); ?>" class="regular-text" /><br />
			        <?php
			    }
			    ?>
				<span class="description">Please enter your spouse name.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="spouse_qid">Spouse QID</label></th>
			<td>
			    <?php $spousesqid = get_the_author_meta( 'spouse_qid', $user->ID );
			    foreach($spousesqid as $spouseqid) {
			        ?>
			        <input type="text" name="spouse_qid[]" id="spouse_qid" minlength="11" maxlength="11" value="<?php echo esc_attr( $spouseqid ); ?>" class="regular-text" /><br />
			        <?php
			    }
			    ?>
				<span class="description">Please enter your spouse QID.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="child_name">Child Name</label></th>
			<td>
			    <?php $childsname = get_the_author_meta( 'child_name', $user->ID );
			    foreach($childsname as $childname){
			        ?>
				    <input type="text" name="child_name[]" id="child_name" value="<?php echo esc_attr( $childname ); ?>" class="regular-text" /><br />
			        <?php
			    }
			    ?>
				<span class="description">Please enter your child name.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="child_qid">Child QID</label></th>
			<td>
			    <?php $childsqid = get_the_author_meta( 'child_qid', $user->ID );
			    foreach($childsqid as $childqid){
			        ?>
				    <input type="text" name="child_qid[]" id="child_qid" minlength="11" maxlength="11" value="<?php echo esc_attr( $childqid ); ?>" class="regular-text" /><br />
			        <?php
			    }
			    ?>
				<span class="description">Please enter your child QID.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="date_of_birth">Date of Birth</label></th>
			<td>
				<input type="date" name="date_of_birth" id="date_of_birth" value="<?php echo esc_attr( get_the_author_meta( 'date_of_birth', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your date of birth.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="father_name">Father Name</label></th>
			<td>
				<input type="text" name="father_name" id="father_name" value="<?php echo esc_attr( get_the_author_meta( 'father_name', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your father name.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="gender">Gender</label></th>
			<td>
			    <?php $gender = get_the_author_meta( 'gender', $user->ID ); ?>
				<select name="gender" id="gender" class="required">
                    <option value="male" <?php if( $gender == 'male' ) { ?> selected="selected"<?php } ?>>Male</option>
                    <option value="female" <?php if( $gender == 'female' ) { ?> selected="selected"<?php } ?>>Female</option>
                </select>
				<span class="description">Please select your gender.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="marital_status">Marital Status</label></th>
			<td>
			    <?php $maritalStatus = get_the_author_meta( 'marital_status', $user->ID ); ?>
				<select name="marital_status" id="marital_status" class="required">
                    <option value="married" <?php if( $maritalStatus == 'married' ) { ?> selected="selected"<?php } ?>>Married</option>
                    <option value="unmarried" <?php if( $maritalStatus == 'unmarried' ) { ?> selected="selected"<?php } ?>>Unmarried</option>
                </select>
				<span class="description">Please enter your marital status.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="job_title">Job Title</label></th>
			<td>
				<input type="text" name="job_title" id="job_title" value="<?php echo esc_attr( get_the_author_meta( 'job_title', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your job title.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="job_place">Job Place</label></th>
			<td>
				<input type="text" name="job_place" id="job_place" value="<?php echo esc_attr( get_the_author_meta( 'job_place', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your job place.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="visa_qid">Qatar ID No</label></th>
			<td>
				<input type="text" name="visa_qid" id="visa_qid" minlength="11" maxlength="13" value="<?php echo esc_attr( get_the_author_meta( 'visa_qid', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Qatar ID number.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="cnic_nicop_poc">NICOP Number</label></th>
			<td>
				<input type="text" name="cnic_nicop_poc" id="cnic_nicop_poc" minlength="13" maxlength="13" value="<?php echo esc_attr( get_the_author_meta( 'cnic_nicop_poc', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your address.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="mobile_number">Mobile No</label></th>
			<td>
				<input type="text" name="mobile_number" id="mobile_number" minlength="8" maxlength="8" value="<?php echo esc_attr( get_the_author_meta( 'mobile_number', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your mobile number.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="qatar_address">Address in Qatar</label></th>
			<td>
				<input type="text" name="qatar_address" id="qatar_address" value="<?php echo esc_attr( get_the_author_meta( 'qatar_address', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your address in Qatar.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="arrival_date">Arrival Date</label></th>
			<td>
				<input type="date" name="arrival_date" id="arrival_date" value="<?php echo esc_attr( get_the_author_meta( 'arrival_date', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your arrival date.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="embassy_registration_number">Embassy Registration Number</label></th>
			<td>
				<input type="text" name="embassy_registration_number" id="embassy_registration_number" minlength="6" maxlength="15" value="<?php echo esc_attr( get_the_author_meta( 'embassy_registration_number', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your embassy registration number.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="occupation_designation">Occupation/Designation</label></th>
			<td>
				<input type="text" name="occupation_designation" id="occupation_designation" value="<?php echo esc_attr( get_the_author_meta( 'occupation_designation', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Occupation/Designation.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="employer">Employer Name</label></th>
			<td>
				<input type="text" name="employer" id="employer" value="<?php echo esc_attr( get_the_author_meta( 'employer', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your employer name.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="expertise">Expertise</label></th>
			<td>
				<input type="text" name="expertise" id="expertise" value="<?php echo esc_attr( get_the_author_meta( 'expertise', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your expertise.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="district">District</label></th>
			<td>
				<input type="text" name="district" id="district" value="<?php echo esc_attr( get_the_author_meta( 'district', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your district.</span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="contact_pakistan">Contact Pakistan</label></th>
			<td>
				<input type="text" name="contact_pakistan" id="contact_pakistan" minlength="11" maxlength="11" value="<?php echo esc_attr( get_the_author_meta( 'contact_pakistan', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Contact Pakistan.</span>
			</td>
		</tr>
	</table>
<?php }

function save_custom_user_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return FALSE;

	update_usermeta( $user_id, 'first_name', $_POST['first_name'] );
	update_usermeta( $user_id, 'last_name', $_POST['last_name'] );
	update_usermeta( $user_id, 'user_login', $_POST['username'] );
	update_usermeta( $user_id, 'email', $_POST['mail_id'] );
	update_usermeta( $user_id, 'pass1', $_POST['user_password'] );
	update_usermeta( $user_id, 'nationality', $_POST['nationality'] );
	update_usermeta( $user_id, 'passport_number', $_POST['passport_number'] );
	update_usermeta( $user_id, 'other_nationality', $_POST['other_nationality'] );
	update_usermeta( $user_id, 'living_status', $_POST['living_status'] );
	update_usermeta( $user_id, 'spouse_name', $_POST['spouse_name'] );
	update_usermeta( $user_id, 'spouse_qid', $_POST['spouse_qid'] );
	update_usermeta( $user_id, 'child_name', $_POST['child_name'] );
	update_usermeta( $user_id, 'child_qid', $_POST['child_qid'] );
	update_usermeta( $user_id, 'date_of_birth', $_POST['date_of_birth'] );
	update_usermeta( $user_id, 'father_name', $_POST['father_name'] );
	update_usermeta( $user_id, 'gender', $_POST['gender'] );
	update_usermeta( $user_id, 'marital_status', $_POST['marital_status'] );
	update_usermeta( $user_id, 'job_title', $_POST['job_title'] );
	update_usermeta( $user_id, 'job_place', $_POST['job_place'] );
	update_usermeta( $user_id, 'visa_qid', $_POST['visa_qid'] );
	update_usermeta( $user_id, 'cnic_nicop_poc', $_POST['cnic_nicop_poc'] );
	update_usermeta( $user_id, 'mobile_number', $_POST['mobile_number'] );
	update_usermeta( $user_id, 'qatar_address', $_POST['qatar_address'] );
	update_usermeta( $user_id, 'arrival_date', $_POST['arrival_date'] );
	update_usermeta( $user_id, 'embassy_registration_number', $_POST['embassy_registration_number'] );
	update_usermeta( $user_id, 'occupation_designation', $_POST['occupation_designation'] );
	update_usermeta( $user_id, 'employer', $_POST['employer'] );
	update_usermeta( $user_id, 'expertise', $_POST['expertise'] );
	update_usermeta( $user_id, 'district', $_POST['district'] );
	update_usermeta( $user_id, 'contact_pakistan', $_POST['contact_pakistan'] );
}

add_action( 'show_user_profile', 'add_custom_user_profile_fields' );
add_action( 'edit_user_profile', 'add_custom_user_profile_fields' );

add_action( 'personal_options_update', 'save_custom_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_custom_user_profile_fields' );