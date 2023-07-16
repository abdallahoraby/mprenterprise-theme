<div class="row new-course-section">
    <div class="col-md-12">
        <?php get_template_part('template-parts/template-dashboard-head', null, array(
            'icon' => 'course'
        )); ?>

        <div class="courses-bottom mid-gray d-flex flex-column">

            <h2 class="text-center mt-3 mb-3 heading-font"> create your course </h2>
            <p class="text-center mt-5 mb-3"> Fill in the necessary fields below </p>


            <form action="" method="post" class="new-course-form d-flex flex-column" id="course-form">

                <input type="text" class="course-title mb-3 p-3" name="course-title" placeholder="Video Title">



                <div class="d-flex justify-content-between align-content-center gap-3">
                    <select class="course-category mb-3 p-3" name="course-category">
                        <option value="" selected disabled> Course Category </option>
                        <?php
                        // get categories instructors register
                        $categories = get_user_meta( get_current_user_id(), 'course_category_register', true );
                        if( !empty($categories) ):
                            foreach ( $categories as $category_id ):
                                $category_id = (int) $category_id;
                                $term = get_term_by('id', $category_id, 'stm_lms_course_taxonomy');
                                if( !empty($term) ):
                                    ?>
                                    <option value="<?= $term->term_id ?>"> <?= $term->name ?> </option>
                                <?php       endif; ?>
                            <?php   endforeach; ?>
                        <?php endif; ?>

                    </select>

                    <select class="course-level mb-3 p-3" name="course-level">
                        <option value="" selected disabled> Course Level </option>
                        <option value="beginner"> Beginner </option>
                        <option value="intermediate"> Intermediate </option>
                        <option value="advanced"> Advanced </option>
                    </select>

                    <input type="number" min="1" class="mb-3 p-3 video-duration" name="video-duration" placeholder="Video Duration (minutes)">
                </div>


                <textarea class="mb-3 video-description" name="video-description" rows="5" placeholder="Video Description"></textarea>


<!--                <form action="" method="post">-->
<!--                    <h3 class="upload-video-title"> <i class="fa-regular fa-folder-open"></i> Upload Your Video </h3>-->
<!--                    <input type="file" id="course-video-file" name="course-video-file" accept="video/*">-->
<!--                </form>-->



<!--                <small class="text-center mt-5 mb-3"> preview </small>-->

<!--                <div class="video-preview d-flex justify-content-center align-content-center">-->
<!--                    <i class="fa-solid fa-circle-play"></i>-->
<!--                    <img src="--><?//= get_stylesheet_directory_uri() ?><!--/assets/img/single-course.png" alt="">-->

<!--                    <video width="100%" controls>-->
<!--                        <source src="" id="video_here">-->
<!--                        Your browser does not support HTML5 video.-->
<!--                    </video>-->
<!---->
<!--                </div>-->

                <input type="hidden" name="add_course_nonce" value="<?= wp_create_nonce( 'add_new_course' ) ?>" id="add_course_nonce">
                <a href="#" id="submit-new-course" class="submit-btn p-4 d-flex justify-content-center align-content-center"> SUBMIT FOR REVIEW <i class="fa-solid fa-arrow-right"></i> </a>


            </form>

        </div>

    </div>
</div>


<style>
    .new-course-form input.course-title,
    .new-course-form .course-level,
    .new-course-form .video-duration,
    .new-course-form .course-category{
        background: #fff;
        border-radius: 150px;
        padding: 1.5rem ;
    }

    select.course-level,
    select.course-category {
        width: 50%;
        padding: 0.5rem !important;
        border: 2px solid #f0f2f5;
    }

    .new-course-form .video-description{
        background: #fff;
        border-radius: 20px;
        padding: 1rem;
    }

    .new-course-form span.select2-selection.select2-selection--single {
        border-radius: 150px;
    }

    .new-course-form span.select2.select2-container.select2-container--default {
        width: 48% !important;
    }

    .video-duration {
        width: 48% !important;
    }

    .new-course-form input.course-title{
        width: 100%;
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

    .video-preview{
        position: relative;
    }

    .video-preview img,
    .video-preview video {
        width: 100%;
        margin: 0 auto;
        border-radius: 30px;
        box-shadow: 0 0 10px #b5b5b5;
    }

    .video-preview i {
        color: #fff;
        position: absolute;
        top: 3rem;
        right: 3rem;
        font-size: 2rem;
    }

    a#submit-new-course i {
        position: absolute;
        right: 2rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.5rem;
    }

    a#submit-new-course {
        position: relative;
        margin: 5rem 0 1rem 0;
    }

    video{
        height: 50vh;
    }




</style>


<script>

    jQuery(document).on("change", "#course-video-file", function(evt) {
        var $source = jQuery('#video_here');
        $source[0].src = URL.createObjectURL(this.files[0]);
        $source.parent()[0].load();
    });

   
    jQuery(document).on("click","#submit-new-course", function(e) {
        e.preventDefault();
        $('.ajax-loader').fadeIn();
        var formData = new FormData(document.getElementById('course-form'));
        let add_new_course_nonce = $('#add_course_nonce').val();

        formData.append("action", "create_new_course");
        formData.append("add_new_course_nonce", add_new_course_nonce);

        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function(response) {
                $('.ajax-loader').fadeOut();
                if( response.message == 'success' ){
                    let course_id = response.course_id;
                    showSuccess('Cousre Added Successfully');
                    // load edit course template with course id
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
                    //location.reload();
                } else {
                    showError(response.message);
                }
            }
        });

    });




    // jQuery("body").delegate("#submit-new-course", "click", function(e){
    //     e.preventDefault();
    //
    //     let add_new_course_nonce = jQuery('#add_course_nonce').val();
    //     let course_title = jQuery('.course-title').val();
    //     let course_level = jQuery('.course-level').val();
    //     let video_duration = jQuery('.video-duration').val();
    //     let video_description = jQuery('.video-description').val();
    //     let course_video_file = jQuery('#course-video-file').val();
    //
    //     if( course_title == '' ){
    //         showError('please enter course title');
    //         return;
    //     }
    //
    //     if( course_level == null ){
    //         showError('please select course level');
    //         return;
    //     }
    //
    //     if( video_duration == '' ){
    //         showError('please enter course duration');
    //         return;
    //     }
    //
    //     if( course_video_file == '' ){
    //         showError('please upload video file');
    //         return;
    //     }
    //
    //     $('.ajax-loader').fadeIn();
    //     jQuery.post(ajaxurl, {
    //         action: 'create_new_course',
    //         add_new_course_nonce: add_new_course_nonce,
    //         course_title: course_title,
    //         course_level: course_level,
    //         video_duration: video_duration,
    //         video_description: video_description,
    //         course_video_file: course_video_file
    //
    //     }, function (response){ // response callback function
    //
    //         if( response.message == 'success' ){
    //             showSuccess('Course added successfully.');
    //             location.reload();
    //         } else {
    //             showError('Error in adding course, please refresh the page and try again.');
    //         }
    //
    //     })
    //     .done(function() {
    //         //alert( "second success" );
    //         //location.reload();
    //     });
    //
    //
    //
    // });
</script>