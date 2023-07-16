<?php

    if ( !empty($args) && $args['course_id'] ):
        $course_id = (int) $args['course_id'];
    else:
        // no course selected, redirect to home
        $dashboard_url = site_url() . '/dashboard';
        wp_safe_redirect($dashboard_url);
    endif;

    $course_video_ids = get_post_meta($course_id, 'course_video_id', false);
    if( !empty($course_video_ids) ):
        $video_url = wp_get_attachment_url($course_video_ids[0]);
    endif;

    $marked_completed_user_meta = get_user_meta( get_current_user_id(), 'mark_status', true );
    if( empty($marked_completed_user_meta) ):
        $marked_completed_user_meta = [];
    else:
        $marked_completed_user_meta = json_decode($marked_completed_user_meta);
    endif;


?>

<div class="vid-main-wrapper clearfix">

    <!-- THE YOUTUBE PLAYER -->
    <div class="vid-container">
        <?php if( !empty($course_video_ids) ): ?>
            <video width="100%" height="" controls controlsList="nodownload" oncontextmenu="return false;" class="main-video">
                <source src="<?= $video_url ?>" type="video/mp4" />
            </video>
        <?php else: ?>
            <div class="col-md-12 text-center p-5 mt-5 mb-5 d-flex justify-content-center align-content-center gap-3 flex-column">

                <i class="fa-solid fa-triangle-exclamation"></i>

                <strong class="text-center"> <?php _e('No video assigned.', 'masterstudy-child'); ?> </strong>

            </div>
        <?php endif; ?>
    </div>

    <?php if(!empty($course_video_ids)): ?>
    <!-- THE PLAYLIST -->
    <div class="vid-list-container">

        <div class="search-section">
            <input type="text" id="search-video" onkeyup="searchInVideos()" placeholder="Type here to start search.." title="Type here to start search"> <i class="fa-solid fa-magnifying-glass"></i>
        </div>

        <ol id="vid-list">

            <?php
                foreach ( $course_video_ids as $key=>$course_video_id ):
                    $playlist_video_url = wp_get_attachment_url($course_video_id);

                    if( $key == 0 ):
                        $selected = 'selected';
                    else:
                        $selected = '';
                    endif;

                    $attachment_metadata = wp_get_attachment_metadata($course_video_id);
                    if( !empty($attachment_metadata) ):
                        $video_duration = $attachment_metadata['length_formatted'];
                    else:
                        $video_duration = 'N/A';
                    endif;

                    $video_title = get_the_title($course_video_id);
                    $mark_status = in_array($course_video_id,$marked_completed_user_meta) ? 'completed' : null ;
//                    $mark_status = get_post_meta($course_video_id, 'mark_status', true);

                    $attachment_data = get_post( $course_video_id );
                    $video_description = $attachment_data->post_content;

            ?>

                <li class="<?= $selected ?>" data-attach-id="<?= $course_video_id ?>">
                    <a href="#" class="hidden video-text"> <?= $video_title ?> <?= $video_description ?> </a>
                    <video width="" height="" controlsList="nodownload" oncontextmenu="return false;" data-vid-url="<?= $playlist_video_url ?>">
                        <source src="<?= $playlist_video_url ?>" type="video/mp4" />
                    </video>
                    <span class="video-title"> <?= ( strlen($video_title) < 35 ) ? $video_title : substr($video_title, 0, 35) . '...' ?> </span>
                    <span class="video-duration"> <?= $video_duration ?> </span>
                    <?php if(empty($mark_status)): ?>
                        <a href="#" data-attach-id="<?= $course_video_id ?>" data-course-id="<?= $course_id ?>" class="mark-completed"> <i class="fa-regular fa-circle-check"></i> <strong> <?= _e('Mark Completed', 'masterstudy-child') ?> </strong> </a>
                    <?php elseif( $mark_status == 'completed' ): ?>
                        <a href="#" class="marked-completed"> <i class="fa-solid fa-check-double"></i> <strong> <?= _e('Completed', 'masterstudy-child') ?> </strong> </a>
                    <?php endif; ?>
                </li>

            <?php endforeach; ?>

        </ol>
    </div>
    <?php endif; ?>


</div>


<style>

    .title {
        width: 100%;
        max-width: 854px;
        margin: 0 auto;
    }

    .caption {
        width: 100%;
        max-width: 854px;
        margin: 0 auto;
        padding: 20px 0;
    }

    .vid-main-wrapper {
        width: 100%;
        max-width: 1100px;
        min-width: 440px;
        background: #fff;
        margin: 0 auto;
        height: 395px;
    }


    /*  VIDEO PLAYER CONTAINER
   ############################### */
    .vid-container {
        position: relative;
        padding-bottom: 0;
        padding-top: 0;
        height: 100%;
        width: 70%;
        float: left;
    }

    .vid-container video{
        height: 100%;
    }

    .vid-container iframe,
    .vid-container object,
    .vid-container embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        min-height: 360px;
    }


    /*  VIDEOS PLAYLIST
     ############################### */
    .vid-list-container {
        width: 30%;
        height:100%;
        overflow: hidden;
        float:right;
    }

    .vid-list-container:hover, .vid-list-container:focus {
        overflow-y: auto;
    }

    #vid-list {
        margin:0;
        padding:0;
        background: #222;
        height: 100%;
        overflow-y: scroll;
    }

    #vid-list li {
        list-style: none;
    }

    /*#vid-list li a {*/
    /*    text-decoration: none;*/
    /*    background-color: #222;*/
    /*    height:55px;*/
    /*    display:block;*/
    /*    padding:10px;*/
    /*}*/

    /*#vid-list li a:hover,*/
    #vid-list li.selected {
        background-color:#666666
    }

    .vid-thumb {
        float:left;
        margin-right: 8px;
    }

    .active-vid {
        background:#3A3A3A;
    }

    #vid-list .desc {
        color: #CACACA;
        font-size: 13px;
        margin-top:5px;
    }

    #vid-list li video {
        width: 40%;
        height: 80px;
        padding: 0.5rem 0;
        object-fit: cover;
    }

    #vid-list li {
        list-style: none;
        position: relative;
        display: flex;
        justify-content: initial;
        align-items: initial;
        gap: 1rem;
        padding: 0rem 1rem;
        margin: 0;
        transition: all 0.3s ease-in-out;
        cursor: pointer;
    }

    #vid-list li:hover {
        background: #555;
    }

    span.video-title {
        color: #fff;
        margin: 1rem 0;
    }



    #vid-list span.video-duration {
        position: absolute;
        left: 1rem;
        bottom: 0.5rem;
        background: #000000b5;
        color: #fff;
        padding: 0 0.5rem;
    }


    a.mark-completed,
    a.marked-completed {
        position: absolute;
        right: 0;
        bottom: 0;
        background: #50955080;
        border-radius: 5px;
        padding: 0px 5px;
        z-index: 999999999;
        transition: all 0.3s ease-in-out;
    }

    a.mark-completed:hover,
    a.marked-completed{
        background: #509550;
    }

    a.mark-completed *,
    a.marked-completed * {
        color: #fff;
    }

    .search-section {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1rem;
        border: 1px solid #ddd;
    }

    i.fa-solid.fa-magnifying-glass {
        width: 10%;
    }

    input#search-video {
        width: 85%;
    }






    @media (max-width: 624px) {
        .caption {
            margin-top: 40px;
        }
        .vid-list-container {
            padding-bottom: 20px;
        }

    }
</style>


<script>

    /*JS FOR SCROLLING THE ROW OF THUMBNAILS*/
    // jQuery(document).ready(function () {
    //     jQuery('.vid-item').each(function(index){
    //         jQuery(this).on('click', function(){
    //             var current_index = index+1;
    //             jQuery('.vid-list li').removeClass('active');
    //             jQuery('.vid-list li:nth-child('+current_index+') .thumb').addClass('active');
    //         });
    //     });
    //     var $list = jQuery('#vid-list li');
    //     $list.click(function(){
    //         $list.removeClass('selected');
    //         jQuery(this).addClass('selected');
    //     });
    // });


    jQuery('#vid-list li').on('click', function(){
        let this_video = jQuery(this).find('video');
        let vid_url = this_video.data('vid-url');
        jQuery('video.main-video').html('<source src="'+ vid_url +'" type="video/mp4">');
        jQuery('video.main-video')[0].load();

    });


    jQuery('.mark-completed').on('click', function (e){
        e.preventDefault();
        $('.ajax-loader').show();
        let attachment_id = jQuery(this).data('attach-id');
        let course_id = jQuery(this).data('course-id');
        jQuery.post(ajaxurl, {
            action: 'mark_completed',
            attachment_id: attachment_id,
            course_id: course_id
        }, function (response){ // response callback function
            $('.ajax-loader').hide();
            showSuccess('Lesson Completed Successfully');
            setTimeout(() => {
                $('.ajax-loader').show();
                //location.reload()
                // load same course in edit page
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
            }, 3000);
        })
        .done(function(response) {
            //alert( "second success" );
        });

    });


    jQuery('#vid-list li').on('click', function(){
        let attach_id = jQuery(this).data('attach-id');
        jQuery.post(ajaxurl, {
            action: 'get_attachment_data',
            attach_id: attach_id,
        }, function (response){ // response callback function
            jQuery('.course-title').text(response.data.title);
            jQuery('.course-description').text(response.data.description);
        })
        .done(function(response) {
            //alert( "second success" );
        });

    });


    function searchInVideos() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("search-video");
        filter = input.value.toUpperCase();
        ul = document.getElementById("vid-list");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }


</script>