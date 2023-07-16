<section class="login-register-page p-5">
    <div class="header-title mb-5 text-center d-flex gap-3 align-content-center justify-content-center">
        <img src="<?= get_stylesheet_directory_uri() ?>/assets/img/logo-main.png" alt="">
        <span class="heading-font"> Metapreneurz </span>
        <span class="role heading-font mid-gray"> / INSTRUCTORS </span>
    </div>

    <div class="row cardWrapper">

        <div class="col-md-6 mx-auto cardContainer">

            <div class="card-section">

                <div class="front login-section d-flex justify-content-center align-content-center flex-column">

                    <h4 class="text-gradient text-center heading-font mb-5"> LOGIN </h4>
                    <span class="mid-gray text-center mt-3 mb-3"> Enter your login credentials </span>

                    <?php
                        $dashboard_url = site_url() . '/dashboard';
                        $args = array(
                            'echo' => true, // Whether to display the login form or return the form HTML code. Default true (echo).
                            'redirect' => $dashboard_url, // URL to redirect to. Must be absolute, as in "<a href="https://example.com/mypage/">https://example.com/mypage/</a>". Default is to redirect back to the request URI.
                            'form_id' => 'login-form', // ID attribute value for the form. Default 'loginform'.
                            'label_username' => '',
                            'label_password' => '',
                            'label_remember' => 'Remember Me',
                            'label_log_in' => 'LOGIN',
                            'id_username' => '', // ID attribute value for the username field. Default 'user_login'
                            'id_password' => '', // ID attribute value for the password field. Default 'user_pass'.
                            'id_remember' => '', // ID attribute value for the remember field. Default 'rememberme'.
                            'id_submit' => 'wp-submit', // ID attribute value for the submit button. Default 'wp-submit'.
                            'remember' => true, // Whether to display the "rememberme" checkbox in the form.
                        );
                        wp_login_form($args);

                    ?>

                    <a href="<?= wp_lostpassword_url() ?>" class="lost-password-url"> <span class="fw-bold mid-gray"> Lost Password? </span> </a>


                    <!--<form id="login-form" class="hidden" action="" method="post">


                        <div class="mb-4">
                            <input type="email" class="form-control p-3" id="user_email" placeholder="Email Address">
                        </div>

                        <div class="mb-4">
                            <input type="password" class="form-control p-3" id="user_password" placeholder="Password">
                        </div>


                        <div class="d-flex justify-content-between align-content-center mt-4 mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="remember_me">
                                <label class="form-check-label" for="remember_me">
                                    Remember me
                                </label>
                            </div>
                            <span class="fw-bold mid-gray"> Lost Password? </span>
                        </div>

                        <button type="submit" class="submit-btn p-4 mb-5 mt-3"> LOGIN <i class="fa-solid fa-arrow-right"></i> </button>

                    </form>-->

                    <a href="#" class="flip-me"> Don't have an account? <span class="text-gradient"> Register Now </span> </a>
                </div>

                <div class="back register-section d-flex justify-content-center align-content-center flex-column">
                    <form action="" method="post" id="register-form">
                        <h4 class="text-gradient text-center heading-font mb-5"> REGISTER AN ACCOUNT </h4>

                        <span class="mid-gray text-center mt-3 mb-3"> You can start by entering your details </span>

                        <div class="mb-4">
                            <input type="text" class="form-control p-3" id="first_name" placeholder="First Name">
                        </div>

                        <div class="mb-4">
                            <input type="text" class="form-control p-3" id="last_name" placeholder="Last Name">
                        </div>

                        <div class="mb-4">
                            <input type="email" class="form-control p-3" id="user_email_register" placeholder="Email Address" required>
                        </div>

                        <div class="mb-4">
                            <input type="password" class="form-control p-3 password-input" id="user_password_register" placeholder="Password" required>
                        </div>

                        <div class="mb-4">
                            <input type="password" class="form-control p-3 password-input" id="user_password_register_retype" placeholder="Retype Password" required>
                            <label for="show_password_btn">
                                <input type="checkbox" id="show_password_btn" onclick="showPassword()" class="hidden"> <small> <i class="fa-regular fa-eye"></i> Show Password </small>
                            </label>
                        </div>

                        <div class="input-group mb-4">
                            <input type="tel" class="form-control p-3" id="phone-input">
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-content-center mb-3">
                                <strong class="mid-gray"> Select Course Subjects </strong>
                                <small> multiple selection </small>
                            </div>

                            <?php
                                $course_categories = get_terms( array(
                                    'taxonomy' => 'stm_lms_course_taxonomy',
                                    'hide_empty' => false,
                                ) );

                                if( !empty($course_categories) ):
                                    foreach ( $course_categories as $course_category ):
                            ?>

                            <label class="form-check-label form-check course-category p-3 d-flex justify-content-start gap-3 mb-3" for="term-<?= $course_category->term_id ?>">
                                <input class="form-check-input course_category_register" type="checkbox" value="<?= $course_category->term_id ?>" id="term-<?= $course_category->term_id ?>">
                                <?= strtoupper($course_category->name) ?> Courses
                            </label>

                            <?php
                                    endforeach;
                                endif;
                                    ?>


                        </div>

                        <div class="mb-4">
                            <strong class="mid-gray mb-3"> Enter Your Bio  </strong>
                            <div class="form-floating mt-3">
                                <textarea class="form-control" placeholder="Start typing..." id="user_bio"></textarea>
                            </div>
                        </div>

                        <div class="mb-5">
                            <strong class="mid-gray mb-3"> Do you have any courses ready?  </strong>

                            <div class="has_courses_section d-flex justify-content-between align-content-center gap-3 mb-3 mt-3">
                                <label class="form-check-label has_courses" for="yes_has_courses">
                                    <div class="form-check p-3">
                                        <input class="form-check-input" type="radio" value="yes_has_courses" name="has_ready_courses" id="yes_has_courses" checked>
                                        Yes, I do
                                    </div>
                                </label>

                                <label class="form-check-label has_courses" for="no_has_courses">
                                    <div class="form-check p-3">
                                        <input class="form-check-input" type="radio" value="no_has_courses" name="has_ready_courses" id="no_has_courses">
                                        No, I don't
                                    </div>
                                </label>
                            </div>

                        </div>


                        <div class="mb-3 mt-3">
                            <p class="text-center" style="margin: 0"> By submitting your <strong> Registration Request </strong>, you confirm that you have read and agreed to our <strong class="orange"> Privacy </strong> and <strong class="orange"> Terms </strong>. </p>
                        </div>

                        <a href="#" id="register-instructor" class="submit-btn p-4 mb-5 mt-3 d-flex justify-content-center align-content-center heading-font"> SUBMIT YOUR REGISTRATION <i class="fa-solid fa-arrow-right"></i> </a>
                        <input type="hidden" name="_nonce" value="<?= wp_create_nonce( 'mpr_instructor_register' ) ?>" id="register_nonce">

                    </form>
                    <a href="#" class="flip-me"> Already have an account? <span class="text-gradient"> Login Now </span> </a>
                </div>

            </div>

        </div>

    </div><!--cardWrapper Ends-->
</section>


<style>
    .card-section.flipped .front,
    .card-section .back{
        display: none;
        visibility: hidden;
    }

    .card-section.flipped .back{
        display: unset;
        visibility: visible;
    }

    a#register-instructor i {
        position: absolute;
        right: 2rem;
        font-size: 1.5rem;
    }

    .has_courses:hover {
        background: #ae00ff5c;
        background-blend-mode: color-burn;
        background-color: #f6f8fa8f;
    }

    .has_courses{
        cursor: pointer;
    }

    form#login-form input[type="text"], form#login-form input[type="password"] {
        padding: 1.5rem !important;
        border-radius: 150px;
        background: #F6F8FA;
        border: 1px solid #E8EDF0;
    }

    p.login-remember label {
        display: flex;
        justify-content: center;
        align-items: center;
        padding-left: 2.5rem;
    }

    /*******/

    /* Hide the browser's default checkbox */
    p.login-remember label input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;

        border-radius: 15px;
    }

    /* On mouse-over, add a grey background color */
    p.login-remember label:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    p.login-remember label input:checked ~ .checkmark {
        background-color: var(--pink);
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    p.login-remember label input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    p.login-remember label .checkmark:after {
        left: 10px;
        top: 6px;
        width: 6px;
        height: 11px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    a.flip-me:hover {
        color: var(--mid-gray) !important;
    }

    input#first_name, input#last_name, input#user_email_register, input#user_password_register, input#user_password_register_retype, input#phone-input {
        border-radius: 50px;
        background: #F6F8FA;
        border: 1px solid #E8EDF0;
        padding: 1.5rem 3rem !important;
    }


    label.form-check-label.form-check.course-category {
        color: var(--mid-gray);
        font-weight: 600;
    }

    textarea#user_bio::placeholder {
        color: var(---mid-gray);
        opacity: 0.7;
    }

    textarea#user_bio {
        padding: 1.5rem !important;
    }



</style>


<script>

    jQuery('p.login-remember label').append('<span class="checkmark"></span>')

    jQuery("body").delegate("#register-instructor", "click", function(e){
        e.preventDefault();

        let register_nonce = jQuery('#register_nonce').val();
        let first_name = jQuery('#first_name').val();
        let last_name = jQuery('#last_name').val();
        let user_email_register = jQuery('#user_email_register').val();
        let user_password_register = jQuery('#user_password_register').val();
        let user_password_register_retype = jQuery('#user_password_register_retype').val();
        let phone_input = jQuery('#phone-input').val();
        let user_bio = jQuery('#user_bio').val();
        let has_ready_courses = $('[name="has_ready_courses"]:checked').val();

        //let course_category_register = '';
        var course_category_register = $('.course_category_register:checkbox:checked').map(function() {
            return this.value;
        }).get();
        //course_category_register = course_categories.join(",");


        if( user_email_register == '' || user_password_register == '' || user_password_register_retype == '' ){
            $.notify({
                title: 'Warning',
                message: 'please fill all fields',
                icon: 'fa-solid fa-triangle-exclamation',
            },{
                element: 'body',
                position: 'fixed',
                type: "warning",
                allow_dismiss: true,
                newest_on_top: false,
                placement: {
                    from: "top",
                    align: "right"
                },
                spacing: 10,
                offset: 10,
                timer: 5000,
            });
        } else {
            $('.ajax-loader').fadeIn();
            jQuery.post(ajaxurl, {
                action: 'register_new_instructor',
                register_nonce: register_nonce,
                first_name: first_name,
                last_name: last_name,
                user_email_register: user_email_register,
                user_password_register: user_password_register,
                user_password_register_retype: user_password_register_retype,
                phone_input: phone_input,
                course_category_register: course_category_register,
                user_bio: user_bio,
                has_ready_courses: has_ready_courses
            }, function (response){ // response callback function
                $('.ajax-loader').fadeOut();
                if( response.message == 'success' ){
                    $.notify({
                        title: 'Success',
                        message: 'User Registered Successfully.',
                        icon: 'fa-solid fa-circle-check',
                    },{
                        element: 'body',
                        position: 'fixed',
                        type: "info",
                        allow_dismiss: true,
                        newest_on_top: false,
                        placement: {
                            from: "top",
                            align: "right"
                        },
                        spacing: 10,
                        offset: 10,
                        timer: 5000,
                    });

                    $('.ajax-loader').fadeIn();
                    // show success template
                    $.get(ajaxurl, { action : 'get_register_success' }, function (template_response) { // response callback function
                        $('.ajax-loader').fadeOut();
                        $('#main').html(template_response);
                    });

                } else {
                    $.notify({
                        title: 'Message',
                        message: response.message,
                        icon: 'fa-solid fa-triangle-exclamation',
                    },{
                        element: 'body',
                        position: 'fixed',
                        type: "danger",
                        allow_dismiss: true,
                        newest_on_top: false,
                        placement: {
                            from: "top",
                            align: "right"
                        },
                        spacing: 10,
                        offset: 10,
                        timer: 5000,
                    });
                }

            })
            .done(function() {
                //alert( "second success" );
                //location.reload();
            });
        }



    });

    function showPassword() {
        let pass_input = $('.password-input');

        if( pass_input.attr('type') == 'password' ){
            pass_input.prop('type', 'text')
        } else {
            pass_input.prop('type', 'password')
        }

    }

    jQuery("#wp-submit").on("click", function(){
        $('.ajax-loader').show();
    });

</script>