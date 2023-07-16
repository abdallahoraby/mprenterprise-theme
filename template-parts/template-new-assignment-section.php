<?php


    // get all courses that has author as current user
    $all_courses = get_posts(
        array(
            'posts_per_page' => -1,
            'post_type' => 'stm-courses',
            'post_status' => 'publish',
            'author' => get_current_user_id()
        )
    );


?>

<p class="text-center mt-5 mb-3"> Enter your assignment details below </p>

<form action="" method="post" class="new-assignment-form d-flex flex-column" id="new-assignment-form">

    <div class="d-flex justify-content-between align-content-center">
        <select class="course-select mb-3 p-3" name="course-select">
            <option value="" selected disabled> Select Course </option>
            <?php if( !empty($all_courses) ): ?>
                <?php foreach ( $all_courses as $course ): ?>
                    <option value="<?= $course->ID ?>"> <?= $course->post_title ?> </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>

    <input type="text" class="assignment-title mb-3 p-3" name="assignment-title" placeholder="Assignment Title">


    <textarea class="mb-3 assignment-description" name="assignment-description" rows="5" placeholder="Assignment Description"></textarea>

    <form action="" method="post">
        <h3 class="upload-video-title"> <i class="fa-solid fa-paperclip"></i> Attach a Document </h3>
        <input type="file" id="assignment-file" name="assignment-file">
    </form>


    <input type="hidden" name="add_new_assignment_nonce" value="<?= wp_create_nonce( 'add_new_assignment_nonce' ) ?>" id="add_new_assignment_nonce">
    <a href="#" id="submit-new-assignment" class="submit-btn p-4 d-flex justify-content-center align-content-center"> PUBLISH ASSIGNMENT <i class="fa-solid fa-arrow-right"></i> </a>


</form>


<script>

    jQuery(document).on("click","#submit-new-assignment", function(e) {
        e.preventDefault();
        $('.ajax-loader').fadeIn();
        var formData = new FormData(document.getElementById('new-assignment-form'));
        let add_new_assignment_nonce = $('#add_new_assignment_nonce').val();

        formData.append("action", "add_new_assignment");
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
                    showSuccess('Assignment Added Successfully');
                    //location.reload();
                } else {
                    showError(response.message);
                }
            }
        });

    });

    jQuery('.course-select').select2();

</script>