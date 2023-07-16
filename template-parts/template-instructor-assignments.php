<?php

    $all_courses = get_posts(
        array(
            'posts_per_page' => -1,
            'post_type' => 'stm-courses',
            'post_status' => 'publish',
            'author' => get_current_user_id()
        )
    );



    $all_assignments = get_posts(
        array(
            'posts_per_page' => -1,
            'post_type' => 'stm-assignments',
            'post_status' => 'publish',
            'author' => get_current_user_id()
        )
    );



?>


    <div class="courses-filter d-flex justify-content-center align-content-center gap-5">
        <div class="filter-title">
            <i class="fa-solid fa-arrow-down-wide-short mid-gray"></i>
            <strong class="mid-gray">  Filter Assignment By Course: </strong>
        </div>
        <select class="course-select" aria-label="">
            <option value="all" selected> Show All </option>
            <?php if( !empty($all_courses) ):
                foreach ( $all_courses as &$course ):
                    ?>
                    <option value="<?= $course->ID ?>"> <?= $course->post_title ?> </option>
                <?php endforeach; ?>
            <?php endif; ?>

        </select>
    </div>

    <?php if(empty($all_assignments)): ?>

        <div class="row">
            <div class="col-md-12 text-center mt-5 mb-5">
                <strong> No assignments found. </strong>
            </div>
        </div>

    <?php else: ?>


    <div class="assignments-list">

        <?php
            foreach ( $all_assignments as $assignment ):
                $publish_date = get_the_date('l, d F, Y', $assignment->ID);

                // get assignment attachment data
                $assignment_attach_id = get_post_meta($assignment->ID, 'assignment_attachment', true);

            ?>

            <div class="assignment-card">
                <div class="row px-5">
                    <div class="col-md-6 pink assignment-label"> Forex Course Assignment </div>
                    <div class="col-md-6 d-flex justify-content-end align-content-center gap-3 flex-wrap">
                        <?= $publish_date ?>
                        <a href="#" class="edit-assignment orange"> Edit Assignment </a>
                    </div>

                    <div class="row assignment-content mt-4 mb-4">
                        <div class="col-md-12">
                            <h3> <?= $assignment->post_title ?> </h3>
                            <p> <?= $assignment->post_content ?> </p>
                            <?php if(!empty( $assignment_attach_id )):
                                $attachment_metadata = wp_get_attachment_metadata($assignment_attach_id);
                                $attach_size = round($attachment_metadata['filesize'] / 1048576, 2);
                            ?>
                                <span> Attached <i class="fa-regular fa-file mx-2"></i> <strong> <?= basename ( get_attached_file( $assignment_attach_id ) ) ?> <span class="attachment-size"> <?= $attach_size ?> MB </span> </strong> </span>
                            <?php else: ?>
                                no attachments found.
                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

        <div class="assignment-card">
            <div class="row px-5">
                <div class="col-md-6 pink assignment-label"> Forex Course Assignment </div>
                <div class="col-md-6 d-flex justify-content-end align-content-center gap-3 flex-wrap">
                    Wednesday, 23 February, 2022
                    <a href="#" class="edit-assignment orange"> Edit Assignment </a>
                </div>

                <div class="row assignment-content mt-4 mb-4">
                    <div class="col-md-12">
                        <h3> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut. </h3>
                        <p> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                            Excepteur sint occaecat cupidatat non... </p>
                        <span> Attached <i class="fa-regular fa-file mx-2"></i> <strong> DocumentFileName.docx </strong> </span>
                    </div>

                </div>

            </div>

            <div class="submitted-assignments px-5">

                <div class="row inner-section">
                    <div class="col-md-4">
                        <img src="<?= get_stylesheet_directory_uri() ?>/assets/img/user-pic-light.png" alt="">
                        <strong> Abdallah Ahmed </strong>
                    </div>

                    <div class="col-md-8 d-flex justify-content-end align-content-center gap-3">
                        <span class="submitted-on"> Submitted on Wednesday, 23 February, 2022 </span>
                        <a href="#" class="view-assignment"> View Assignment <i class="fa-solid fa-arrow-right"></i> </a>
                    </div>
                </div>

                <div class="row inner-section">
                    <div class="col-md-4">
                        <img src="<?= get_stylesheet_directory_uri() ?>/assets/img/user-pic-light.png" alt="">
                        <strong> Abdallah Ahmed </strong>
                    </div>

                    <div class="col-md-8 d-flex justify-content-end align-content-center gap-3">
                        <span class="submitted-on"> Submitted on Wednesday, 23 February, 2022 </span>
                        <a href="#" class="view-assignment"> View Assignment <i class="fa-solid fa-arrow-right"></i> </a>
                    </div>
                </div>

                <div class="row inner-section">
                    <div class="col-md-4">
                        <img src="<?= get_stylesheet_directory_uri() ?>/assets/img/user-pic-light.png" alt="">
                        <strong> Abdallah Ahmed </strong>
                    </div>

                    <div class="col-md-8 d-flex justify-content-end align-content-center gap-3">
                        <span class="submitted-on"> Submitted on Wednesday, 23 February, 2022 </span>
                        <a href="#" class="view-assignment"> View Assignment <i class="fa-solid fa-arrow-right"></i> </a>
                    </div>
                </div>





            </div>

        </div>




    </div>

    <?php endif; ?>


<style>


    .row.tabs-section {
        height: 5rem;
        background: var(--mid-gray);
        border-top-left-radius: 30px;
        border-top-right-radius: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        width: inherit;
        margin: 0 auto;
        margin-top: -10rem;
    }

    .tab.active {
        background: #f6f8fa;
        color: var(--mid-gray) !important;
        font-weight: bold;
        height: 100%;
        border: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: inherit;
    }

    .courses-bottom {
        margin-top: 0;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    .tab{
        color: #fff;
        font-family: var(--heading-font);
    }

    .filter-title{
        display: flex;
        justify-content: center;
        align-content: center;
        gap: 1rem;
    }

    span.select2.select2-container.select2-container--default,
    .course-select{
        width: 50% !important;
    }

    span.select2-selection.select2-selection--single,
    .course-select{
        border-radius: 150px;
    }

    .assignment-card {
        margin: 3rem 1rem;
        border: 1px solid #E8EDF0;
        border-radius: 30px;
        background: #fff;
        padding-top: 2rem;
    }

    .assignment-label {
        font-size: 1rem;
        font-weight: bold;
        font-family: var(--heading-font);
    }

    .assignment-content h3 {
        font-size: 1.1rem;
    }

    a.edit-assignment:hover {
        font-weight: bold;
        color: var(--orange) !important;
    }

    a.edit-assignment {
        transition: all 0.3s ease-in-out;
    }

    .submitted-assignments {
        background: var(--mid-gray);
        width: 100%;
        margin: 0;
        padding: 1rem;
        border-bottom-left-radius: inherit;
        border-bottom-right-radius: inherit;
    }

    .inner-section {
        background: #ffffff30;
        border-radius: 100px;
        padding: 0.8rem;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 1rem 0;
    }

    .inner-section img {
        width: 2.5rem;
        margin-right: 1rem;
    }

    .rtl .inner-section img {
        margin-right: 0;
        margin-left: 1rem;
    }

    .inner-section strong {
        color: #fff;
    }

    a.view-assignment {
        background: var(--pink);
        color: #fff;
        padding: 0.5rem 2rem;
        border-radius: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }

    .row.inner-section .col-md-4, .row.inner-section .col-md-8 {
        margin: 0 !important;
        padding: 0 !important;
    }

    a.view-assignment * {
        color: #fff;
    }

    span.submitted-on {
        display: flex;
        align-items: center;
        color: #ffffffb8;
    }







</style>

<script>
    jQuery('.course-select').select2();
</script>