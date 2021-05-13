jQuery(function ($) {

    var pass_access = true;
    var eml_access = true;
    var introducer_validity = true;
    var gov_docs_number_access = true;
    var banknumber_access = true;

    // {FORM ONE / (STEP 1 FORM)}
    // =========================
    
    // {GETTING INTRODUCER NAME THROUGH ISA NUMBER}
    // ===========================================

    function myintroducer() {
        if ($('#isa-nombor').val() !== "") {
            if ($('.introducerName').children('input').val() !== "") {
                $('#isa-nombor').css('border', '1px solid #ddd');
                $('.next').removeAttr('disabled');
                introducer_validity = true;
            } else {
                $('.next').prop('disabled', true);
                $('#isa-nombor').css('border', '1px solid red');
                introducer_validity = false;
            }
        } else {
            $('.next').prop('disabled', true);
            $('#isa-nombor').css('border', '1px solid #ddd');
            introducer_validity = false;
        }
    }

    $('#isa-nombor').on('keyup', function () {
        myintroducer();
        $('#isa-nombor').css('border', '1px solid #ddd');
        if ($(this).val() !== "") {
            $.ajax({
                type: "post",
                url: public_ajax_action.ajaxurl,
                data: {
                    action: 'get_introducer_name',
                    isanumber: $('#isa-nombor').val(),
                    nonces: public_ajax_action.nonce
                },
                cache: false,
                beforeSend: () => {
                    $('.next').prop('disabled', true);
                    $('.noisanum').show();
                    $('.loading').remove();
                    $('.profileshows').append('<span class="loading">Processing...</span>');
                },
                dataType: 'json',
                success: function (response) {
                    if (response.name && response.isanumber) {
                        $('.loading').remove();
                        $('.noisanum').hide();
                        $('#isa-nombor').css('border', '1px solid #ddd');
                        $('.introducer_profile').slideUp().css('display','none');
                        $('.isaShow').text(response.isanumber);
                        $('.nameShow').text(response.name);
                        $('.introducer__img').children('img').attr('src', response.avatar);
                        $('.introducer_profile').css('display','flex').slideDown();
                    } else {
                        $('.noisanum').show();
                        $('.introducerName').hide().children('input').val('');
                        $('#isa-nombor').css('border', '1px solid red');
                        $('.introducer_profile').slideUp().css('display','none');
                        $('.loading').text("No Introducer Found");
                        setTimeout(() => {
                            $('.loading').remove();
                        }, 2000);
                    }
                    
                    return false;
                }
            });
        } else {
            $('.introducer_profile').slideUp().css('display','none');
            $(this).css('border', '1px solid red');
            $('.loading').remove();
        }
    });

    // Get default isa
    function get_default_isa_num() {
        $.ajax({
            type: "post",
            url: public_ajax_action.ajaxurl,
            data: {
                action: 'get_default_introducer_isa',
                nonces: public_ajax_action.nonce
            },
            cache: false,
            beforeSend: () => {
                $('.next').prop('disabled', true);
                $('.loading').remove();
                $('.profileshows').append('<span class="loading">Processing...</span>');
            },
            dataType: 'json',
            success: function (response) {
                $('.loading').remove();
                $('.next').removeAttr('disabled');
                $('#isa-nombor').val(response.number).prop('disabled', true);
                $('.introducerName').children('input').val(response.name);
                $('.selected_user').val(response.name);
            }
        });
    }

    $('#noisanum').on('click', function () {
        if ($(this).val() == 0) {
            $(this).val(1);
            introducer_validity = true;
            get_default_isa_num();
            myintroducer();
        } else {
            $(this).val(0);
            $('#isa-nombor').val('').removeAttr('disabled');
            $('.introducerName').children('input').val('');
            introducer_validity = false;
            myintroducer();
            $('.next').prop('disabled', true);
        }
    });
    
    $('#select-introducer').on('click', function (e) {
        e.preventDefault();
        $('.noisanum').hide();
        $('.introducer_profile').slideUp().css('display','none');
        $('.introducerName').show().children('input').val($('.nameShow').text());
        $('.selected_user').val($('.nameShow').text());
        $('.next').removeAttr('disabled');
        introducer_validity = true;
    });

    // {FORM TWO / (STEP 2 FORM)}
    // =========================

    // Show / Hide password
    $('span.showpass').on('click', function () {
        let data = $(this).next('#password').attr('type');
        if (data == 'password') {
            $(this).next('#password').attr('type', 'text');
        } else {
            $(this).next('#password').attr('type', 'password');
        }
    });
	function isEmail(email) {
  		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  		return regex.test(email);
	}
    // Email addr
    $('#email_addr').on('keyup', function () {
        if ($(this).val() !== "" && isEmail($(this).val())) {
			
            $(this).css('border', '1px solid #ddd');
			eml_access = true;
            myintroducer();
            step3allval();
        } else {
            $(this).css('border', '1px solid red');
			eml_access = false;
            step3allval();
        }
    });

    $('#email_addr').on('blur', function () {
        let email = $(this).val();
        $.ajax({
            type: "post",
            url: public_ajax_action.ajaxurl,
            data: {
                action: 'check_user_exists',
                nonces: public_ajax_action.nonce,
                email: email
            },
            dataType: "json",
            success: function (response) {
                if (response.exist) {
                    eml_access = false;
                    myintroducer();
                    step3allval();
                    $('#email_addr').css('border', '1px solid red');
                    return false;
                }
                if(response.granted){
                    eml_access = true;
                    step3allval();
                    $('#email_addr').css('border', '1px solid #ddd');
                }
            }
        });
    })

    // Password
    $('#password').on('keyup', function () {
        if ($(this).val() !== "") {
            if ($(this).val().length < 6) {
                $(this).css('border', '1px solid red');
                step3allval();
                pass_access = false;
                return false;
            } else {
                pass_access = true;
                $(this).css('border', '1px solid #ddd');
                step3allval();
                myintroducer();
            }
            
        } else {
            $(this).css('border', '1px solid red');
            step3allval();
			pass_access = false;
        }
    });

    // Gender
    $('#gender').on('change', function () {
        if ($(this).val() !== "") {
            $(this).css('border', '1px solid #ddd');
            step3allval();
            myintroducer();
        } else {
            $(this).css('border', '1px solid red');
            step3allval();
        }
    });

    // Goverment ID type
    $('#gov_id_type').on('change', function () {
        if ($(this).val() !== "") {
            $(this).css('border', '1px solid #ddd');
            step3allval();
            myintroducer();
        } else {
            $(this).css('border', '1px solid red');
            step3allval();
        }
    });

    // Goverment ID number
    $('#gov_docs_number').on('keyup', function () {
        if ($(this).val() !== "") {
            $(this).css('border', '1px solid #ddd');
            step3allval();
            myintroducer();
        } else {
            $(this).css('border', '1px solid red');
            step3allval();
        }
    });

    // // {FORM THREE / (STEP 3 FORM)}
    // // ===========================

    // firstname
    $('#firstname').on('keyup', function () {
        if ($(this).val() !== "") {
            $(this).css('border', '1px solid #ddd');
            step3allval();
        } else {
            $(this).css('border', '1px solid red');
            step3allval();
        }
    });

    // iitialsname
    $('#iitialsname').on('keyup', function () {
        if ($(this).val() !== "") {
            $(this).css('border', '1px solid #ddd');
            step3allval();
        } else {
            $(this).css('border', '1px solid red');
            step3allval();
        }
    });

    // Check user exist
    $('#gov_docs_number').on('blur', function () {
        let gov_docs_number = $(this).val();
        $.ajax({
            type: "post",
            url: public_ajax_action.ajaxurl,
            data: {
                action: 'check_gov_docs_number_exists',
                nonces: public_ajax_action.nonce,
                gov_docs_number: gov_docs_number
            },
            dataType: "json",
            success: function (response) {
                if (response.exist) {
                    gov_docs_number_access = false;
                    
                    myintroducer();
                    step3allval();
                    $('#gov_docs_number').css('border', '1px solid red');
                    return false;
                }
                if(response.granted){
                    gov_docs_number_access = true;
                    step3allval();
                    $('#gov_docs_number').css('border', '1px solid #ddd');
                }
            }
        });
    })

    // phone
    $('#phone').on('keyup', function () {
        if ($(this).val() !== "") {
            $(this).css('border', '1px solid #ddd');
            step3allval();
        } else {
            $('#formSubmit').prop('disabled', true);
            $(this).css('border', '1px solid red');
            step3allval();
        }
    });

    // billing_state
    $('#billing_state').on('change', function () {
        if ($(this).val() !== "") {
            $(this).css('border', '1px solid #ddd');
            step3allval();
        } else {
            $(this).css('border', '1px solid red');
            step3allval();
        }
    });

    // billing_city
    $('#billing_city').on('keyup', function () {
        if ($(this).val() !== "") {
            $(this).css('border', '1px solid #ddd');
            step3allval();
        } else {
            $(this).css('border', '1px solid red');
            step3allval();
        }
    });

    // billing_zipcode
    $('#billing_zipcode').on('keyup', function () {
        if ($(this).val() !== "") {
            $(this).css('border', '1px solid #ddd');
            step3allval();
        } else {
            $(this).css('border', '1px solid red');
            step3allval();
        }
    });

    // billing_addr_1
    $('#billing_addr_1').on('keyup', function () {
        if ($(this).val() !== "") {
            $(this).css('border', '1px solid #ddd');
            step3allval();
        } else {
            $(this).css('border', '1px solid red');
            step3allval();
        }
    });

    /**
     * Bank Informations
     */
    // bank_names
    $('#bank_names').on('change', function () {
        if ($(this).val() !== "") {
            $(this).css('border', '1px solid #ddd');
            step3allval();
        } else {
            $(this).css('border', '1px solid red');
            step3allval();
        }
    });

    // bank_names
    $('#bank_account_number').on('blur', function () {
        if ($(this).val() !== "") {
            let banknumber = $(this).val();
            $(this).css('border', '1px solid #ddd');
            $.ajax({
                type: "post",
                url: public_ajax_action.ajaxurl,
                data: {
                    action: 'banknumber_checkingpoint',
                    banknumber: banknumber,
                    nonces: public_ajax_action.nonce,
                },
                dataType: "json",
                success: function (response) {
                    if (response.exist) {
                        banknumber_access = false;
                        myintroducer();
                        step3allval();
                        $('#bank_account_number').css('border', '1px solid red');
                        return false;
                    }
                    if (response.granted) {
                        banknumber_access = true;
                        step3allval();
                        $('#bank_account_number').css('border', '1px solid #ddd');
                    }
                }
            });
        } else {
            $(this).css('border', '1px solid red');
            step3allval();
        }
    });

    // account holder name
    $('#account_holder_name').on('keyup', function () {
        if ($(this).val() !== "") {
            $(this).css('border', '1px solid #ddd');
            step3allval();
        } else {
            $(this).css('border', '1px solid red');
            step3allval();
        }
    });

    // account branch name
    $('#branch_name').on('keyup', function () {
        if ($(this).val() !== "") {
            $(this).css('border', '1px solid #ddd');
            step3allval();
        } else {
            $(this).css('border', '1px solid red');
            step3allval();
        }
    });

    // account branch name
    $('#branch_code').on('keyup', function () {
        if ($(this).val() !== "") {
            $(this).css('border', '1px solid #ddd');
            step3allval();
        } else {
            $(this).css('border', '1px solid red');
            step3allval();
        }
    });

    
    // Step 3 check ability
    function step3allval() {

        let email_addr = $('#email_addr').val();
        let password = $('#password').val();
        let gender = $('#gender').val();
        let gov_id_type = $('#gov_id_type').val();
        let gov_docs_number = $('#gov_docs_number').val();

        let firstname = $('#firstname').val();
        let iitialsname = $('#iitialsname').val();
        let phone = $('#phone').val();
        let billing_state = $('#billing_state').val();
        let billing_city = $('#billing_city').val();
        let billing_zipcode = $('#billing_zipcode').val();
        let billing_addr_1 = $('#billing_addr_1').val();
        let billing_addr_2 = $('#billing_addr_2').val();

        let bank_names = $('#bank_names').val();
        let bank_account_number = $('#bank_account_number').val();
        let account_holder_name = $('#account_holder_name').val();
        let branch_name = $('#branch_name').val();
        let branch_code = $('#branch_code').val();

        if (firstname !== "" && iitialsname !== "" && phone !== "" && billing_state !== "" && billing_city !== "" && billing_zipcode !== "" && billing_addr_1 !== ""  && pass_access == true && eml_access == true && introducer_validity == true && email_addr !== "" && password !== "" && gender !== "" && gov_id_type !== "" && gov_docs_number !== "" && bank_names !== "" && bank_account_number !== ""  && account_holder_name !== "" && branch_name !== "" && branch_code !== "" && gov_docs_number_access == true && banknumber_access == true) {
            $('.submit').removeAttr('disabled');
            return true;
        } else {
            $('.submit').prop('disabled', true);
            return false;
        }
    }

    var current_fs, next_fs, previous_fs; //fieldsets
    var left, opacity, scale; //fieldset properties which we will animate
    var animating; //flag to prevent quick multi-click glitches
    
    $(".next").click(function () {
        if ($(this).parent().attr('data') == 1) {
            let isaNumber = $('#isa-nombor').val();
            let introducerName = $('#introducer-fullname').val();
    
            if (isaNumber == "" || introducerName == "") {
                $('.next').prop('disabled', true);
                return false;
            } else {
                $('.next').removeAttr('disabled');
            }
        }

        if ($(this).parent().attr('data') == 2) {

            step3allval();

            $('.submit').prop('disabled', true);
            return false;
        }

        if (animating) return false;
        animating = true;
    
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
    
        //activate next step on progressbar using the index of next_fs
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        $(".next").prop('disabled', true);
        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate(
            { opacity: 0 },
            {
                step: function (now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale current_fs down to 80%
                    scale = 1 - (1 - now) * 0.2;
                    //2. bring next_fs from the right(50%)
                    left = now * 50 + "%";
                    //3. increase opacity of next_fs to 1 as it moves in
                    opacity = 1 - now;
                    current_fs.css({ transform: "scale(" + scale + ")" });
                    next_fs.css({ left: left, opacity: opacity });
                },
                duration: 100,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                //this comes from the custom easing plugin
                easing: "easeOutQuint"
            }
        );
    });
    
    $(".previous").click(function () {
        if (animating) return false;
        animating = true;
    
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();
    
        //de-activate current step on progressbar
        $("#progressbar li")
            .eq($("fieldset").index(current_fs))
            .removeClass("active");
    
        //show the previous fieldset
        previous_fs.show();
		$('.next').removeAttr('disabled');
        //hide the current fieldset with style
        current_fs.animate(
            { opacity: 0 },
            {
                step: function (now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale previous_fs from 80% to 100%
                    scale = 0.8 + (1 - now) * 0.2;
                    //2. take current_fs to the right(50%) - from 0%
                    left = (1 - now) * 50 + "%";
                    //3. increase opacity of previous_fs to 1 as it moves in
                    opacity = 1 - now;
                    current_fs.css({ left: left });
                    previous_fs.css({
                        transform: "scale(" + scale + ")",
                        opacity: opacity
                    });
                },
                duration: 500,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                //this comes from the custom easing plugin
                easing: "easeOutQuint"
            }
        );
    });
	
    
    $(".submit").click(function (e) {
        if (step3allval() == true && pass_access == true && eml_access == true && introducer_validity == true && gov_docs_number_access == true && banknumber_access == true) {
            e.preventDefault();
            let isa_num = $('#isa-nombor').val();
            let introducer = $('#introducer-fullname').val();
            let email = $('#email_addr').val();
            let pass = $('#password').val();
            let gender_ = $('#gender').val();
            let id_type = $('#gov_id_type').val();
            let id_number = $('#gov_docs_number').val();
            
            let iitialsname = $('#iitialsname').val();
            let fname = $('#firstname').val();
            let phone_ = $('#phone').val();
            let _state = $('#billing_state').val();
            let _city = $('#billing_city').val();
            let _zipcode = $('#billing_zipcode').val();
            let _addr_1 = $('#billing_addr_1').val();
            let _addr_2 = $('#billing_addr_2').val();

            let bank_names = $('#bank_names').val();
            let bank_account_number = $('#bank_account_number').val();
            let account_holder_name = $('#account_holder_name').val();
            let branch_name = $('#branch_name').val();
            let branch_code = $('#branch_code').val();

            let data = {
                isa_num,introducer,email,pass,gender_,id_type,id_number,fname,iitialsname,phone_,_state,_city,_zipcode,_addr_1,_addr_2,bank_names,bank_account_number,account_holder_name,branch_name,branch_code
            }

            $.ajax({
                type: "post",
                url: public_ajax_action.ajaxurl,
                data: {
                    action: 'form2reg_register_user',
                    nonces: public_ajax_action.nonce,
                    data: data
                },
                beforeSend: () => {
                    $(".submit").val("Processing...");
                },
                success: function (response) {
                    location.reload();
                }
            });
        } else {
            return false;
        }
    });
});