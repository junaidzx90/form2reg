<?php
function form2reg_display_view($atts){
    ob_start();
    global $current_user;
    wp_enqueue_style('fontawesome');
    wp_enqueue_style(FORM2REG_NAME);
    wp_enqueue_script('jquery.min');
    wp_enqueue_script('easing.min');
    wp_enqueue_script(FORM2REG_NAME);
    
    if(is_user_logged_in(  )){
        wp_safe_redirect( home_url( '/' ) );
        exit;
    }

    // Colors Include
    require_once FORM2REG_PATH.'admin/form2reg-css.php';
    ?>
    <!-- multistep form -->
    <form id="form2reg_reg__form">
        <!-- progressbar -->
        <ul id="progressbar">
            <li class="active">Introducer</li>
            <li>Contact Details</li>
        </ul>
        <!-- fieldsets -->
        <fieldset data="1">
            <h2 class="fs-title"><?php echo __(get_post()->post_title, 'form2reg') ?></h2>
            <h3 class="fs-subtitle"></h3>
            
            <div class="finput-group">
                <label for="isa-nombor">eCustomer Introducer ISA NO</label>
                <input id="isa-nombor" name="isa-nombor" placeholder="ISA NO" type="text" autofocus value="" autocomplete="off">
            </div>

            <div class="finput-group profileshows">
                <div class="introducer_profile">
                    <div class="introducer__img">
                        <img src="https://www.studyinternational.com/wp-content/uploads/2016/12/news_business_manager_1.jpg" alt="">
                    </div>
                    <div class="introducer__details">
                        <table cellspacing="0" cellpadding="0">
                                <tr class="first-tr">
                                    <th>Introducer ID</th>
                                    <td class="isaShow">N/A</td>
                                </tr>
                                <tr>
                                    <th>Introducer Name</th>
                                    <td class="nameShow">N/A</td>
                                </tr>
                        </table>
                        <button id="select-introducer">Select Introducer</button>
                    </div>
                </div>

                <div class="introducerName">
                    <label for="introducer-fullname">Introducer Full Name(autofill)</label>
                    <input id="introducer-fullname" name="introducer-fullname" placeholder="Introducer Full Name" type="text" autocomplete="off" readonly>
                </div>
            </div>
            <input type="button" name="next" class="next action-button" value="Next" disabled/>
        </fieldset>

        <fieldset data="2">
            <h5 class="personaldetails fs-title">Personal Details</h5>
        
            <div class="selected_user">
                <input disabled class="selected_user" placeholder="Introducer Full Name" type="text" autocomplete="off" readonly>
            </div>

            <div class="finput-group">
                <label for="email_addr">Email address</label>
                <input id="email_addr" name="email_addr" placeholder="Email address" type="email" autofocus>
            </div>

            <div class="passfield">
                <label for="password">Password</label>
                <span class="showpass">👁</span>
                <input id="password" name="password" placeholder="Password" type="password" autocomplete="off">
            </div>

            <div class="finput-group">
                <label for="gender">Gender</label>
                <select name="gender" id="gender">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="finput-group">
                <label for="gov_id_type">ID Type</label>
                <select name="gov_id_type" id="gov_id_type"> 
                    <option value="">Select</option> 
                    <option value="nid">NID</option> 
                    <option value="passp">Passport</option>
                    <option value="dlicense">Driving License</option>
                </select>
            </div>

            <div class="finput-group">
                <label for="gov_docs_number">NID / Driving Licence / Passport Number </label>
                <input id="gov_docs_number" name="gov_docs_number" placeholder="Number" type="text">
            </div>
        
            <h5 class="personaldetails fs-title">Contact Details</h5>

            <div class="finput-group">
                <label for="firstname">First Name</label>
                <input id="firstname" name="firstname" placeholder="Enter your first name" type="text">
            </div>

            <div class="finput-group">
                <label for="phone">Phone</label>
                <input id="phone" name="phone" placeholder="Your phone number" type="tel" oninput="this.value=this.value.replace(/[^0-9]/g,'');">
            </div>

            <div class="finput-group">
                <label for="billing_state">District</label>
                <select class="input-text ncselect" name="billing_state" id="billing_state"> 
                    <option value="Colombo">Colombo</option>
                    <option value="Gampaha">Gampaha</option>
                    <option value="Kalutara">Kalutara</option>
                    <option value="Kandy">Kandy</option>
                    <option value="Matale">Matale</option>
                    <option value="Nuwara-Eliya">Nuwara-Eliya</option>
                    <option value="Batticaloa">Batticaloa</option>
                    <option value="Trincomalee">Trincomalee</option>
                    <option value="Ampara">Ampara</option>
                    <option value="Jaffna">Jaffna</option>
                    <option value="Mannar">Mannar</option>
                    <option value="Mullaitivu">Mullaitivu</option>
                    <option value="Vavuniya">Vavuniya</option>
                    <option value="Anuradhapura">Anuradhapura</option>
                    <option value="Polonnaruwa">Polonnaruwa</option>
                    <option value="Kurunegala">Kurunegala</option>
                    <option value="Puttalam">Puttalam</option>
                    <option value="Ratnapura">Ratnapura</option>
                    <option value="Kegalle">Kegalle</option>
                    <option value="Galle">Galle</option>
                    <option value="Galle">Galle</option>
                    <option value="Matara">Matara</option>
                    <option value="Hambantota">Hambantota</option>
                    <option value="Badulla">Badulla</option>
                    <option value="Monaragala">Monaragala</option>
                    <option value="Kilinochchi">Kilinochchi</option>
                </select>
            </div>

            <div class="finput-group">
                <label for="billing_city">City</label>
                <input id="billing_city" name="billing_city" placeholder="City name" type="text">
            </div>

            <div class="finput-group">
                <label for="billing_zipcode">Postal Code</label>
                <input id="billing_zipcode" name="billing_zipcode" placeholder="Postal Code" type="text">
            </div>

            <div class="finput-group">
                <label for="billing_addr_1">Address Line 1</label>
                <input id="billing_addr_1" name="billing_addr_1" placeholder="State, City, Twon, House" type="text">
            </div>

            <div class="finput-group">
                <label for="billing_addr_2">Address Line 2</label>
                <input id="billing_addr_2" name="billing_addr_2" placeholder="State, City, Twon, House" type="text">
            </div>
            <input type="button" name="previous" class="previous action-button" value="Previous" />
            <input type="submit" name="submit" class="submit action-button" value="Submit" disabled/>
        </fieldset>
    </form>
<?php
}