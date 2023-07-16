<?php

    if ( !empty($args) && $args['assignment_id'] ):
        $assignment_id = (int) $args['assignment_id'];
    else:
        return;
    endif;


    if ( !empty($args) && $args['course_id'] ):
        $course_id = (int) $args['course_id'];
    endif;


?>


<div class="row new-assignment-section">
    <div class="col-md-12">
        <?php get_template_part('template-parts/template-dashboard-head', null, array(
            'icon' => 'assignment'
        )); ?>

        <div class="courses-bottom mid-gray d-flex flex-column">

            <?php if(!empty($assignment_id)):
                $course_title = get_the_title($course_id);
                $assignment_title = get_the_title($assignment_id);
                $assignment_content = get_post_field('post_content', $assignment_id);

                $author_id = get_post_field( 'post_author', $assignment_id );
                $instructor_obj = get_user_by('id', $author_id);

                $publish_date = get_the_date('l, d F, Y', $assignment_id);

                // get assignment attachment data
                $assignment_attach_id = get_post_meta($assignment_id, 'assignment_attachment', true);


                ?>
                <div class="assignment-card instructor_<?= $author_id ?>">
                    <div class="row d-flex justify-content-center align-content-center mt-3 mb-3 p-5">
                        <div class="col-md-6">

                            <div class="profile-section">

                                <div class="col-md-3 d-flex justify-content-center p-0">
                                    <div class="rounded-corners-gradient-borders">
                                        <img class="profile-picture" src="<?= get_stylesheet_directory_uri() ?>/assets/img/user-pic.png" alt="">
                                    </div>
                                </div>

                                <div class="col-md-9">
                                    <h3> <?= $instructor_obj->data->display_name ?> </h3>
                                    <p> Submitted on <?= $publish_date ?> </p>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6 d-flex justify-content-center align-content-center">
                            <span class="assigned-course"> <?= $course_title ?> </span>
                        </div>
                    </div>


                    <div class="row assignment-content">
                        <div class="col-md-12">
                            <h3> <?= $assignment_title ?> </h3>
                            <p> <?= $assignment_content ?> </p>
                        </div>
                    </div>

                    <form action="" method="post" class="new-learner-assignment-form d-flex flex-column" id="new-learner-assignment-form">

                        <div class="submit-assignment-section d-flex justify-content-center align-content-center gap-5 mb-5 flex-column p-5">

                            <textarea name="submitted_assignment_content" id="submitted_assignment_content" cols="30" rows="10" placeholder="Write your assignment..."></textarea>

                            <form action="" method="post">
                                <h3 class="upload-video-title"> <i class="fa-solid fa-paperclip"></i> Attach a Document </h3>
                                <input type="file" id="submitted_assignment_file" name="submitted_assignment_file">
                            </form>

                            <input type="hidden" name="course_id" value="<?= $course_id ?>">
                            <input type="hidden" name="assignment_id" value="<?= $assignment_id ?>">
                            <input type="hidden" name="add_new_assignment_nonce" value="<?= wp_create_nonce( 'add_new_assignment_nonce' ) ?>" id="add_new_assignment_nonce">
                            <a href="#" id="submit-new-learner-assignment" class="submit-btn p-4 d-flex justify-content-center align-content-center"> PUBLISH ASSIGNMENT <i class="fa-solid fa-arrow-right"></i> </a>

                        </div>

                    </form>


                </div> <!-- end of assignment card -->

            <?php else: ?>
                <p class="text-center"> No data available </p>
            <?php endif; ?>

        </div>

    </div>
</div>





<style>

    a#submit-new-learner-assignment i {
        position: absolute;
        right: 2rem;
        top: 50%;
        transform: translateY(-50%);
    }

    textarea#submitted_assignment_content {
        min-height: 30vh;
        border-radius: 30px;
        padding: 2rem !important;
    }

    span.select2.select2-container.select2-container--default,
    #instructor-id{
        width: 50% !important;
    }

    span.select2-selection.select2-selection--single,
    #instructor-id{
        border-radius: 150px;
    }

    .filter-title{
        display: flex;
        justify-content: center;
        align-content: center;
        gap: 1rem;
    }

    span.assigned-course {
        width: 100%;
        max-width: 100%;
        display: block;
        text-align: end;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--pink);
        height: 100%;
        align-content: center;
    }

    .assignment-card {
        background: #fff;
        margin: 3rem 3rem 0 3rem;
        border-radius: 30px;
        box-shadow: 0 0 10px #eef1f3;
    }

    .assignment-card:last-child{
        margin-bottom: 3rem;
    }

    .courses-bottom{
        padding: 3rem 0 0 0;
    }

    .assignment-card-footer {
        background: var(--mid-gray);
        width: 100%;
        margin: 0;
        min-height: 10vh;
        border-radius: 30px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        padding: 1rem;
    }

    .assignment-card-footer * {
        color: #fff;
    }

    .assignment-card-footer i{
        margin: 0 1rem;
    }

    a.download-attachment,
    a.complete-assignment {
        padding: 0.5rem 1rem;
        border-radius: 100px;
        color: #fff;
        border: 2px solid var(--mid-gray);
    }

    a.download-attachment:hover,
    a.complete-assignment:hover {
        color: #fff !important;
        background: transparent;
        border-color: #fff;
    }

    a.download-attachment{
        background: var(--pink);
    }

    a.complete-assignment{
        background: var(--orange);
    }

    a.download-attachment i,
    a.complete-assignment i{
        margin: 0;
    }


    span.attachment-size {
        margin: 0 1rem;
    }

    .assignment-content {
        padding: 2rem;
    }

    h3.upload-video-title {
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

    h3.upload-video-title i {
        color: #fff;
    }

    input#assignment-file {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        background: #fff;
        padding: 1rem;
        border-radius: 50px;
    }



    a#submit-new-assignment i {
        position: absolute;
        right: 2rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.5rem;
    }

    a#submit-new-assignment {
        position: relative;
        margin: 5rem 0 1rem 0;
    }




</style>




<script>

    jQuery(document).on("click","#submit-new-learner-assignment", function(e) {
        e.preventDefault();
        $('.ajax-loader').fadeIn();
        var formData = new FormData(document.getElementById('new-learner-assignment-form'));
        let add_new_assignment_nonce = $('#add_new_assignment_nonce').val();

        formData.append("action", "submit_new_learner_assignment");
        formData.append("add_new_assignment_nonce", add_new_assignment_nonce);

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
                    showSuccess('Assignment Submitted Successfully');
                    location.reload();
                } else {
                    showError(response.message);
                }
            }
        });

    });

    jQuery('.course-select').select2();

</script>