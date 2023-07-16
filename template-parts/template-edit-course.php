<?php


    if ( !empty($args) && $args['course_id'] ):
        $course_id = (int) $args['course_id'];
    else:
        // no course selected, redirect to home
        $dashboard_url = site_url() . '/dashboard';
        wp_safe_redirect($dashboard_url);
    endif;


    $course_obj = get_post($course_id);
    $course_title = $course_obj->post_title;
    $course_description = $course_obj->post_content;
    $course_description = wp_strip_all_tags( $course_description );
    $course_video_ids = get_post_meta($course_id, 'course_video_id', false);
    if( !empty($course_video_ids) ):
        $video_url = wp_get_attachment_url($course_video_ids[0]);
    endif;
    $level = get_post_meta($course_id, 'level', true);
    $duration = (int) get_post_meta($course_id, 'duration_info', true);
    $author_obj = get_user_by('id', $course_obj->post_author);
    $author_name = $author_obj->data->display_name;

    $current_progress = (int) MPR_Core::get_user_course_progress(get_current_user_id(), $course_id);

    $length_formatted = wp_get_attachment_metadata($course_video_ids[0])['length_formatted'];

?>



<div class="row new-course-section">
    <div class="col-md-12">
        <?php get_template_part('template-parts/template-dashboard-head', null, array(
            'icon' => 'course',
            'back_template' => 'courses'
        )); ?>

        <div class="courses-bottom mid-gray d-flex flex-column">

            <div class="course-details-section">


                <?php if( !empty($course_video_ids) ): ?>
                    <video width="100%" height="700px" controls controlsList="nodownload" oncontextmenu="return false;" class="main-video">
                        <source src="<?= $video_url ?>" type="video/mp4" />
                    </video>
                <?php else: ?>
                    <div class="col-md-12 text-center p-5 mt-5 mb-5 d-flex justify-content-center align-content-center gap-3 flex-column">

                        <i class="fa-solid fa-triangle-exclamation"></i>

                        <strong class="text-center"> <?php _e('No video assigned.', 'masterstudy-child'); ?> </strong>

                    </div>
                <?php endif; ?>
<!--                <a href="#" class="complete-lesson"> <i class="fa-regular fa-circle-check"></i> Complete This Lesson </a>-->

                <?php if(!empty($course_video_ids)): ?>

                    <div class="playlist">
                        <?php
                            foreach ( $course_video_ids as $course_video_id ):
                                $playlist_video_url = wp_get_attachment_url($course_video_id);
                                $video_title = get_the_title($course_video_id);
                                $attachment_metadata = wp_get_attachment_metadata($course_video_id);
                                if( !empty($attachment_metadata) ):
                                    $video_duration = $attachment_metadata['length_formatted'];
                                else:
                                    $video_duration = 'N/A';
                                endif;
                            ?>
                            <span>
                                <span class="video-duration"> <?= $video_duration ?> </span>
                                <video width="100%" height="120px" controlsList="nodownload" oncontextmenu="return false;" data-vid-url="<?= $playlist_video_url ?>">
                                    <source src="<?= $playlist_video_url ?>" type="video/mp4" />
                                </video>
                                <span class="video-title"> <?= $video_title ?> </span>
                                <span class="action-btns">
                                    <a href="#" data-attach-id="<?= $course_video_id ?>" class="delete-video"> <i class="fa-solid fa-link-slash"></i> <strong> <?= _e('Unlink Video', 'masterstudy-child') ?> </strong> </a>
                                    <a href="#" data-attach-id="<?= $course_video_id ?>" class="edit-video-data" > <i class="fa-solid fa-edit"></i> <strong> <?= _e('Edit Title', 'masterstudy-child') ?> </strong> </a>
                                </span>
                            </span>
                        <?php endforeach; ?>
                    </div>

                <?php endif; ?>


                <div class="edit-video-section">
                    <label for="edit_video_title">
                        Edit Video Title <input type="text" id="edit_video_title">
                    </label>

                    <label for="edit_video_desc">
                        Edit Video Description <textarea id="edit_video_desc" cols="30" rows="10"></textarea>
                    </label>
                    <input type="hidden" id="attachment_id">
                    <a href="#" class="btn btn-primary update_video_data"> Update </a>
                </div>


                <form action="" method="post" id="edit-course-form" enctype="multipart/form-data">

                    <input type="hidden" id="course_id" name="course_id" value="<?= $course_id ?>">

                    <div class="row d-flex justify-content-between align-content-center flex-wrap px-5 mt-5 mb-5 course-header-details">
                        <div class="col-md-6">

                            <div class="level"> <?= _e('Level', 'masterstudy-child') ?>  <?= ucfirst($level) ?> </div>
                            <div class="hosted-by"> <?= _e('Hosted by', 'masterstudy-child') ?>  <strong> <?= $author_name ?> </strong> </div>

                        </div>

                        <div class="col-md-6">
<!---->
<!--                            <div class="row duration-info">-->
<!---->
<!--                                <div class="col-md-6">-->
<!--                                    <div class="duration">-->
<!--                                        --><?//= _e('Duration:', 'masterstudy-child') ?><!-- <input type="number" min="1" name="course-duration" value="--><?//= $duration ?><!--"> --><?//= _e('Minutes', 'masterstudy-child') ?>
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!---->
                        </div>

                    </div>



                    <input type="text" value="<?= $course_title ?>" name="course-title">

                    <textarea class="mb-3 course-description" name="course-description" rows="10" > <?= $course_description ?> </textarea>

                    <?php
//                        $content   = $course_description;
//                        $editor_id = 'course-description';
//                        $settings  = array(
//                                'media_buttons' => false,
//                                'tinymce' => true,
//                            );
//
//                        wp_editor( $content, $editor_id, $settings );
                    ?>

                    <?php echo do_shortcode('[frontend-button]'); ?>
                    <input class="attachment-ids" name="attachment-ids" type="hidden" value="" />
                    <div class="video-previews">  </div>


<!--                    <form action="" method="post">-->
<!--                        <h3 class="upload-video-title"> <i class="fa-regular fa-folder-open"></i> Upload Your Video(s) </h3>-->
<!--                        <input type="file" id="course-video-file" name="course-video-files[]" accept="video/*" multiple>-->
<!--                    </form>-->

                    <input type="hidden" name="edit_course_nonce" value="<?= wp_create_nonce( 'edit_course' ) ?>" id="edit_course_nonce">
                    <a href="#" id="submit-edit-course" class="submit-btn p-4 d-flex justify-content-center align-content-center"> <?= _e('Update Course', 'masterstudy-child') ?> <i class="fa-regular fa-floppy-disk"></i> </a>
                </form>


            </div>


        </div>

    </div>
</div>


<style>

    .course-description {
        border-radius: 20px;
        padding: 1.5rem !important;
    }

    input#course-video-file {
        margin-bottom: 3rem;
    }

    a#submit-edit-course {
        width: 90%;
        margin: 0 auto;
    }

    a.complete-lesson {
        background: var(--mint-green);
        color: #fff;
        width: fit-content;
        padding: 0.5rem 1rem;
        border-radius: 5px;
    }

    .course-details-section {
        background: #fff;
        border-radius: 30px;
        border-bottom: 1px solid #E8EDF0;
        display: flex;
        flex-flow: column;
        padding-bottom: 4rem;
    }

    .course-details-section video{
        border-radius: inherit;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    .upload-video-title {
        margin: 3rem 0 0 0;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 3rem;
        background: var(--mid-gray);
        color: #fff;
        padding: 1rem;
        border-radius: 50px;
        font-size: 1.1rem;
    }

    .upload-video-title i {
        color: #fff;
    }

    input#course-video-file {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        background: #fff;
        padding: 1rem;
        border-radius: 50px;
    }

    .checked {
        color: var(--pink);
    }

    .progress {
        margin: 0.5rem 0 0 0;
    }

    .course-header-details * {
        font-size: 1rem;
    }

    .duration-info{
        display: flex;
        justify-content: space-between;
        align-content: end;
    }

    .duration {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1rem;
    }

    [name="course-duration"] {
        border-radius: 100px !important;
        width: 5rem;
    }

    .course-status {
        position: absolute;
        bottom: 0;
    }


    h3.course-title {
        font-size: 1.5rem;
        margin-bottom: 3rem;
    }

    p.course-description {
        margin-bottom: 5rem;
    }

    .rate-this-course {
        background: #F6F8FA;
        border: 1px solid #E8EDF0;
        border-radius: 100px;
        padding: 1.2rem;
        width: 90%;
        margin: 0 auto;
    }

    .rate-stars {
        display: flex;
        justify-content: flex-end;
    }

    .rate-stars span:hover{
        cursor: pointer;

    }

    .playlist {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 2rem auto;
        flex-flow: wrap;
        gap: 1rem;
    }

    .playlist video {
        border: 3px solid #e1e1e1ba;
        border-radius: 15px;
        object-fit: cover;
        height: 180px;
        cursor: pointer;
        box-shadow: 0 0 10px #dddddda6;
        transition: all 0.3s ease-in-out;
    }

    .playlist video:hover {
        background: var(--bg-gradient);
    }

    .playlist span{
        flex: 22%;
        position: relative;
    }

    a.delete-video,
    a.edit-video-data{
        bottom: 1rem;
        right: 1rem;
        background: #db6262;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 100px;
        transition: all 0.5s ease-in-out;
    }

    span.action-btns {
        background: #dddddd94;
        width: 100%;
        z-index: 99999;
        height: auto;
        border-radius: 50px;
        padding: 5px;
        display: flex;
        justify-content: end;
        gap: 0.5rem;
    }

    a.edit-video-data {
        background: #269be0;
    }

    span.video-duration {
        position: absolute;
        top: 0;
        left: 0;
        background: #000000ab;
        padding: 2px 15px;
        border-radius: 5px;
        color: #fff;
        font-size: 1rem;
    }

    span.video-title {
        width: 100%;
        display: block;
        padding: 5px;
    }

    .delete-video *,
    .edit-video-data *{
        color: #fff;
    }

    a.delete-video strong,
    a.edit-video-data strong {
        display: none;
    }

    a.delete-video:hover strong,
    a.edit-video-data:hover strong {
        display: flex;
    }

    a.delete-video:hover,
    a.edit-video-data:hover {
        width: fit-content;
        padding: 0 1rem;
        gap: 0.5rem;
    }

    form#edit-course-form {
        width: 100%;
        display: flex;
        flex-flow: column;
        gap: 2rem;
        padding: 0 3rem;
    }

    input[name="course-title"] {
        padding: 1.5rem 2rem !important;
        border-radius: 100px;
    }

    a#submit-edit-course i {
        position: absolute;
        right: 2rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.3rem;
    }

    .video-previews {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        flex-flow: wrap;
    }

    .single-preview {
        flex: 30%;
        display: flex;
        flex-flow: column;
        gap: 1rem;
        justify-content: center;
        align-items: center;
    }

    .edit-video-section {
        display: none;
        flex-flow: column;
        background: white;
        border: 2px solid #ddd;
        border-radius: 30px;
        padding: 2rem;
        width: 80%;
        margin: 0 auto;
        gap: 1rem;
        transition: all 0.3s ease-in-out;
    }

    .edit-video-section label {
        width: 100%;
        margin: 1rem 0 0 0;
    }

    input#edit_video_title {
        width: 100%;
        border-radius: 30px;
    }

    textarea#edit_video_desc {
        border-radius: 30px;
        padding: 1rem !important;
    }

    a.btn.btn-primary.update_video_data {
        width: fit-content;
    }






</style>


<script>

    jQuery('.playlist video').on('click', function(){

        let vid_url = jQuery(this).data('vid-url');
        jQuery('video.main-video').html('<source src="'+ vid_url +'" type="video/mp4">');
        jQuery('video.main-video')[0].load();


    });


    jQuery("body").delegate(".delete-video", "click", function(e){
        e.preventDefault();
        let attach_id = jQuery(this).data('attach-id');
        let course_id = jQuery('#course_id').val();
        let this_video = jQuery(this).parent();

        $.confirm({
            title: 'Confirm Unlinking',
            content: 'Are you sure you want to unlink this video?',
            buttons: {

                confirm: {
                    text: 'Unlink',
                    btnClass: 'btn-danger',
                    action: function () {
                        $('.ajax-loader').show();
                        jQuery.post(ajaxurl, {
                            action: 'delete_video',
                            attach_id: attach_id,
                            course_id: course_id
                        }, function (response){ // response callback function
                            $('.ajax-loader').hide();
                            if( response == 'success' ){
                                // showSuccess('Video Unlinked Successfully');
                                // this_video.hide();

                                showSuccess('Video Unlinked Successfully');
                                this_video.hide();
                                this_video.hide();
                                setTimeout(() => {
                                    $('.ajax-loader').show();
                                    //location.reload()
                                    // load same course in edit page
                                    jQuery.post(ajaxurl, {
                                        action: 'get_edit_single_course',
                                        course_id: course_id
                                    }, function (response){ // response callback function
                                        $('.ajax-loader').hide();
                                        jQuery('.dashboard-content').html(response);
                                    })
                                        .done(function(response) {
                                            //alert( "second success" );
                                        });
                                }, 3000);
                            } else {
                                showError(response);
                            }
                        })
                            .done(function(response) {
                                //alert( "second success" );
                            });
                    }
                },

                cancel: function () {
                    //close modal
                }


            }
        });



    });



    jQuery(document).on("click","#submit-edit-course", function(e) {
        e.preventDefault();
        $('.ajax-loader').fadeIn();
        let edit_course_nonce = $('#edit_course_nonce').val();
        let course_id = $('#course_id').val();
        var formData = new FormData(document.getElementById('edit-course-form'));
        formData.append("action", "edit_course_data");
        formData.append("edit_course_nonce", edit_course_nonce);
        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function(response) {
                $('.ajax-loader').fadeOut();
                if( response == 'success' ){
                    showSuccess('Course has been updated successfully');
                    setTimeout(() => {
                        $('.ajax-loader').show();
                        //location.reload()
                        // load same course in edit page
                        jQuery.post(ajaxurl, {
                            action: 'get_edit_single_course',
                            course_id: course_id
                        }, function (response){ // response callback function
                            $('.ajax-loader').hide();
                            jQuery('.dashboard-content').html(response);
                        })
                        .done(function(response) {
                            //alert( "second success" );
                        });
                    }, 3000);
                } else {
                    showError(response);
                }
            }
        });

    });


    jQuery('.edit-video-data').on('click', function(e){
        e.preventDefault();
        $('.ajax-loader').show();
        let attach_id = jQuery(this).data('attach-id');
        jQuery.post(ajaxurl, {
            action: 'get_attachment_data',
            attach_id: attach_id,
        }, function (response){ // response callback function
            $('.ajax-loader').hide();
            jQuery('.edit-video-section').show();
            jQuery('.edit-video-section #edit_video_title').val(response.data.title);
            jQuery('.edit-video-section #edit_video_desc').val(response.data.description);
            jQuery('.edit-video-section #attachment_id').val(response.data.attachment_id);
        })
        .done(function(response) {
            //alert( "second success" );
        });


    });


    jQuery('.update_video_data').on('click', function(e){
        e.preventDefault();
        $('.ajax-loader').show();
        let edit_video_title = jQuery('.edit-video-section #edit_video_title').val();
        let edit_video_desc = jQuery('.edit-video-section #edit_video_desc').val();
        let attachment_id = jQuery('.edit-video-section #attachment_id').val();
        let course_id = $('#course_id').val();
        jQuery.post(ajaxurl, {
            action: 'update_attachment_data',
            attachment_id: attachment_id,
            edit_video_title: edit_video_title,
            edit_video_desc: edit_video_desc,
        }, function (response){ // response callback function
            $('.ajax-loader').hide();
            if( response.success == true ){
                showSuccess(response.data);
            } else {
                showError(response.data)
            }

            setTimeout(() => {
                $('.ajax-loader').show();
                //location.reload()
                // load same course in edit page
                jQuery.post(ajaxurl, {
                    action: 'get_edit_single_course',
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

</script>