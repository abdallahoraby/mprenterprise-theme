$(document).ready(function() {

    // notification all options

    // $.notify({
    //
    //     // title
    //     title: 'Notification Title',
    //
    //     // message
    //     message: 'Your message...',
    //
    //     // custom icon
    //     icon: 'fa fa-bell',
    //
    //     // add a link to the notification
    //     url: "https://www.jqueryscript.net",
    //
    //     // target attribute
    //     target: "_blank",
    //
    // }, {
    //
    //     // where to append the notification
    //     element: 'body',
    //
    //     // static | fixed | relative | absolute
    //     position: null,
    //
    //     // notification type
    //     // danger, info, warning, error
    //     type: "danger",
    //
    //     // is dismissable?
    //     allow_dismiss: true,
    //
    //     // put the newest notification on the top
    //     newest_on_top: false,
    //
    //     // shows a progress bar
    //     showProgressbar: false,
    //
    //     // placement options
    //     placement: {
    //         from: "top",
    //         align: "right"
    //     },
    //
    //     // offset in pixels
    //     offset: 10,
    //
    //     // space between notifications
    //     spacing: 10,
    //
    //     // z-index property
    //     z_index: 1500,
    //
    //     // delay in milliseconds
    //     delay: 5000,
    //
    //     // timer in millisconeds
    //     timer: 1000,
    //
    //     // URL target property
    //     url_target: '_blank',
    //
    //     // pause the timer on hover
    //     mouse_over: null,
    //
    //     // animation options
    //     animate: {
    //         enter: 'animate__animated animate__bounceInDown',
    //         exit: 'animate__animated animate__bounceOutUp'
    //     },
    //
    //     // or 'image'
    //     icon_type: 'class',
    //
    //     // custom template
    //     template: `<div  data-notify="container" class="shadow-sm col-11 col-md-6 col-lg-5 col-xl-4 alert alert-{0} alert-dismissible fade show" role="alert">
    //         <h5 data-notify="title" class="alert-heading">{1}</h5>
    //         <div class="d-flex align-items-center">
    //           <div class="me-2" data-notify="icon"></div>
    //           <span data-notify="message" class="animate__animated animate__fadeIn animate__faster animate__delay-1s">{2}</span>
    //         </div>
    //         <div class="progress mt-1" style="height: 2px;" data-notify="progressbar">
    //           <div class="progress-bar bg-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
    //         </div>
    //           <a href="{3}" target="{4}" data-notify="url"></a>
    //         <button type="button" class="btn-close"  data-notify="dismiss" aria-label="Close"></button>
    //         </div>`,
    //
    //             // callbacks
    //             onShow: null,
    //             onShown: null,
    //             onClose: null,
    //             onClosed: null,
    //
    // });


    $('.flip-me').click(function () {
        $(this).parent().parent().toggleClass('flipped');
    });

    $("#phone-input").intlTelInput({
        // options here
        autoPlaceholder:"polite",
        initialCountry:"ae",
        formatOnDisplay:true,
        autoHideDialCode:true
    });

    $('.course-category input').on('change', function (){

        if ($(this).is(":checked")) {
            //checked
            $(this).parent('.course-category').addClass("selected");
        } else {
            //unchecked
            $(this).parent('.course-category').removeClass("selected");
        }


    });

    $('.login-username input').prop('placeholder', 'Email Address');
    $('.login-password input').prop('placeholder', 'Password');
    $('.lost-password-url').appendTo('.login-remember');

    // dashboard on click courses
    jQuery("body").delegate(".get-courses", "click", function(e){
        e.preventDefault();
        $('.ajax-loader').show();
        let term_id = $(this).data('term-id');
        // load template courses
        jQuery.post(ajaxurl, {
            action: 'get_user_courses',
            term_id: term_id
        }, function (response){ // response callback function
            $('.ajax-loader').hide();
            jQuery('.dashboard-content').html(response);
        })
            .done(function(response) {
                //alert( "second success" );
            });

    });




    // get ajax loader template
    $.get(ajaxurl, { action : 'get_ajax_loader' }, function (response) { // response callback function
        $('body').prepend(response);
    });


    // on click single course ( select ) btn
    jQuery("body").delegate(".view-course", "click", function(e){
        e.preventDefault();
        $('.ajax-loader').show();
        let course_id = $(this).data('course-id');
        // load template courses
        jQuery.post(ajaxurl, {
            action: 'get_single_course',
            course_id: course_id
        }, function (response){ // response callback function
            $('.ajax-loader').hide();
            jQuery('.dashboard-content').html(response);
        })
            .done(function(response) {
                //alert( "second success" );
            });

    });







}); //////// end of document ready ////////


function showError( message ){
    $.notify({
        title: 'Message',
        message: message,
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

function showSuccess(message){

    $.notify({
        title: 'Success',
        message: message,
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

}