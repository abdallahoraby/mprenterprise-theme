<div class="top-info-section">

    <div class="row d-flex justify-content-between">

        <div class="col-md-6">
            <?php get_template_part('template-parts/template-breadcrumb'); ?>
        </div>

        <div class="col-md-6 profile-section">
            <div class="col-md-9 profile-info">
                <?php
                $user_obj = get_user_by('id', get_current_user_id());
                $first_name = get_user_meta(get_current_user_id(), 'first_name', true);
                $first_name = !empty($first_name) ? $first_name : 'N/A';
                $last_name = get_user_meta(get_current_user_id(), 'last_name', true);
                $last_name = !empty($last_name) ? $last_name : 'N/A';
                $user_bio = get_user_meta(get_current_user_id(), 'description', true);
                $user_bio = !empty($user_bio) ? $user_bio : 'N/A';
                ?>

                <h3 class="heading-font"> <?= " $first_name $last_name " ?> </h3>
                <p>
                    <?= $user_bio ?>
                </p>
                <strong> <a href="#" class="orange edit-profile"> Edit Your Profile </a> </strong>
            </div>

            <div class="col-md-3 d-flex justify-content-center p-0">
                <div class="rounded-corners-gradient-borders">
                    <img class="profile-picture" src="<?= get_stylesheet_directory_uri() ?>/assets/img/user-pic.png"
                         alt="">
                </div>
            </div>
        </div>


    </div>


    <div class="col-md-12 notification-bar">
        <div class="right-section">
            <img class="notification-icon" src="<?= get_stylesheet_directory_uri() ?>/assets/img/notif-icon.png" alt="">
            <strong class="mid-gray heading-font"> Notifications </strong>
        </div>
        <?php
        $notifications = get_posts(
            array(
                'posts_per_page' => 10,
                'post_type' => 'notifications',
                'post_status' => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC'
            )
        );

        if (!empty($notifications)):
        ?>
        <div class="center-section">

            <div class="newsticker js-newsticker">
                <ul class="js-frame">
                    <?php foreach ($notifications as $notification):  ?>
                        <li class="js-item"> <?= $notification->post_title ?> <span class="notification-date"> <?=  date('D d M Y', strtotime($notification->post_date)) ?> </span> </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>


    <?php else: ?>
        <span> no new notifications available. </span>
    <?php
    endif;
    ?>

        <strong> <a href="#" class="orange heading-font see-all-notifications"> See All </a> </strong>
    </div>
</div>



<style>
    img.notification-icon {
        margin: 0 1rem;
    }

    .center-section {
        width: 70%;
    }

    /* clearfix */
    .clearfix {
        zoom: 1;
    }

    ul.js-frame {
        width: 100%;
        margin: 0;
    }

    .clearfix:after {
        content: '.';
        display: block;
        clear: both;
        visibility: hidden;
        height: 0;
        font-size: 0;
    }

    /* newsticker */
    .newsticker {
        color: #402726;
        cursor: default;
        font-family: verdana;
        font-weight: bold;
        overflow: hidden;
        padding: 0 10px 0 10px;
        width: 100%;
        height: 30px;
        position: relative;
    }


    .newsticker ul {
        position: absolute;
    }

    .newsticker ul li {
        width: 100%;
        height: 30px;
        overflow: hidden;
        white-space: nowrap;
        position: relative;
        text-align: initial;
        transition: all 0.5s ease-in-out;
    }

    span.notification-date {
        position: absolute;
        right: 1rem;
    }

</style>


<script>
    (function($) {
        $.fn.newsticker = function(opts) {
            // default configuration
            var config = $.extend({}, {
                height: 30,
                speed: 1000,
                start: 0
            }, opts);
            // main function
            function init(obj) {
                var dNewsticker = obj;
                var dFrame = dNewsticker.find('.js-frame');
                var dItem = dFrame.find('.js-item');
                var dNext;
                var stop = false;

                dItem.eq(0).addClass('current');

                var moveUp = setInterval(function(){
                    if(!stop){
                        var dCurrent = dFrame.find('.current');

                        dFrame.animate({top: '-=' + config.height + 'px'}, config.speed, function(){
                            dNext = dFrame.find('.current').next();
                            dNext.addClass('current');
                            dCurrent.removeClass('current');
                            dCurrent.clone().appendTo(dFrame);
                            dCurrent.remove();
                            dFrame.css('top', config.start + 'px');
                        });
                    }
                },5000);

                dNewsticker.on('mouseover mouseout', function(e){
                    var dThisWrapper = $(this);
                    if(e.type == 'mouseover') {
                        stop = true;
                    }
                    else{// mouseout
                        stop = false;
                    }
                });
            }
            // initialize every element
            this.each(function() {
                init($(this));
            });
            return this;
        };
        // start
        $(function() {
            $('.js-newsticker').newsticker();
        });
    })(jQuery);



    jQuery("body").delegate(".see-all-notifications", "click", function(e){
        e.preventDefault();
        $('.ajax-loader').show();

        // load template
        jQuery.post(ajaxurl, {
            action: 'get_all_notifications',
        }, function (response){ // response callback function
            $('.ajax-loader').hide();
            jQuery('.post_type_exist').html(response);
        })
        .done(function(response) {
            //alert( "second success" );
        });

    });

</script>