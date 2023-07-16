<div class="row new-assignment-section">
    <div class="col-md-12">
        <?php get_template_part('template-parts/template-dashboard-head', null, array(
            'icon' => 'certificate'
        )); ?>

        <div class="courses-bottom mid-gray d-flex flex-column">


            <?php

            /**
             * @var $current_user
             */

            stm_lms_register_style( 'user-quizzes' );
            stm_lms_register_style( 'user-certificates' );
            $completed = stm_lms_get_user_completed_courses( get_current_user_id(), array( 'user_course_id', 'course_id' ), -1 );
            stm_lms_register_script( 'affiliate_points' );
            stm_lms_register_style( 'affiliate_points' );


            if ( ! empty( $completed ) ) { ?>

                <?php
                    if ( class_exists( 'STM_LMS_Certificate_Builder' ) ) {
                        wp_register_script( 'jspdf', STM_LMS_URL . '/assets/vendors/jspdf.umd.js', array(), stm_lms_custom_styles_v() );
                        wp_enqueue_script( 'stm_generate_certificate', STM_LMS_URL . '/assets/js/certificate_builder/generate_certificate.js', array( 'jspdf', 'stm_certificate_fonts' ), stm_lms_custom_styles_v() );
                    }
                ?>

                <div class="stm-lms-user-quizzes stm-lms-user-certificates">

                    <p class="text-center"> Here you will find the Certificates for the course you subscribed to </p>

                    <?php
                    foreach ( $completed as $course ) :
                        $code = STM_LMS_Certificates::stm_lms_certificate_code( $course['user_course_id'], $course['course_id'] );

                        $course_title = get_the_title($course['course_id']);

                        $meta = STM_LMS_Helpers::parse_meta_field($course['course_id']);
                        $level = !empty( $meta['level'] ) ? $meta['level'] : 'N/A';
                        $duration = !empty( $meta['duration_info'] ) ? $meta['duration_info'] : 'N/A';
                        $completed_status = 'Completed';
                        $completed_percentage = 100;

                        $certificate_link = STM_LMS_Course::certificates_page_url( $course['course_id'] );

                        ?>

                        <div class="grid-content d-flex justify-content-start align-content-center gap-3 flex-wrap">

                            <!-- Courses loop goes here -->

                            <div class="course-card certificate-card completed">
                                <div class="course-image"> </div>
                                <div class="col-md-12 d-flex justify-content-between align-content-center">
                                    <div class="col-md-6 course-level"> <?= ucfirst($level) ?> </div>
                                    <div class="col-md-6 course-duration"> <?= $duration ?> Minutes </div>
                                </div>
                                <h3 class="p-3 course-title almarai"> <?= $course_title ?> </h3>

                                <?php if ( class_exists( 'STM_LMS_Certificate_Builder' ) ) : ?>
                                    <a href="<?= $certificate_link ?>"
                                       data-course-id="<?php echo esc_attr( $course['course_id'] ); ?>"
                                       class="stm-lms-user-quiz__name stm_preview_certificate">
                                        <?php esc_html_e( 'Download Certificate', 'masterstudy-lms-learning-management-system' ); ?>
                                        <i class="fa-solid fa-arrow-down"></i>
                                    </a>
                                <?php else : ?>
                                    <a href="<?php echo esc_url( STM_LMS_Course::certificates_page_url( $course['course_id'] ) ); ?>"
                                       target="_blank"
                                       class="stm-lms-user-quiz__name">
                                        <?php esc_html_e( 'Download Certificate', 'masterstudy-lms-learning-management-system' ); ?>
                                        <i class="fa-solid fa-arrow-down"></i>
                                    </a>
                                <?php endif; ?>

                                <div class="progress single-course-progress">
                                    <div class="progress-bar w-<?= $completed_percentage ?>" role="progressbar" aria-label="Basic example" aria-valuenow="<?= $completed_percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="course-status"> <?= $completed_status ?> </div>
                            </div>



                        </div>


                        <div class="stm-lms-user-quiz hidden">
                            <div class="stm-lms-user-quiz__title">
                                <a href="<?php echo esc_url( get_the_permalink( $course['course_id'] ) ); ?>">
                                    <?php echo wp_kses_post( get_the_title( $course['course_id'] ) ); ?>
                                </a>
                            </div>
                            <?php if ( class_exists( 'STM_LMS_Certificate_Builder' ) ) : ?>
                                <a href="<?php echo esc_url( STM_LMS_Course::certificates_page_url( $course['course_id'] ) ); ?>"
                                   data-course-id="<?php echo esc_attr( $course['course_id'] ); ?>"
                                   class="stm-lms-user-quiz__name stm_preview_certificate">
                                    <?php esc_html_e( 'Download', 'masterstudy-lms-learning-management-system' ); ?>
                                </a>
                            <?php else : ?>
                                <a href="<?php echo esc_url( STM_LMS_Course::certificates_page_url( $course['course_id'] ) ); ?>"
                                   target="_blank"
                                   class="stm-lms-user-quiz__name">
                                    <?php esc_html_e( 'Download', 'masterstudy-lms-learning-management-system' ); ?>
                                </a>
                            <?php endif; ?>


                            <div class="affiliate_points heading_font" data-copy="<?php echo esc_attr( $code ); ?>">
                                <span class="hidden" id="<?php echo esc_attr( $code ); ?>"><?php echo esc_html( $code ); ?></span>
                                <span class="affiliate_points__btn">
                                <i class="fa fa-link"></i>
                                <span class="text"><?php esc_html_e( 'Copy code', 'masterstudy-lms-learning-management-system' ); ?></span>
                            </span>
                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php } else { ?>

<!--                <h2 class="stm-lms-account-title">-->
<!--                    --><?php //esc_html_e( 'My Certificates', 'masterstudy-lms-learning-management-system' ); ?>
<!--                </h2>-->
<!---->
<!--                <div class="multiseparator"></div>-->

                <h4 class="no-certificates-notice text-center"><?php esc_html_e( 'You do not have a certificate yet.', 'masterstudy-lms-learning-management-system' ); ?></h4>
                <h4 class="no-certificates-notice text-center"><?php esc_html_e( 'Get started easy, select a course here, pass it and get your first certificate', 'masterstudy-lms-learning-management-system' ); ?></h4>

            <?php } ?>


        </div>

    </div>
</div>





<style>



    .progress {
        width: 100%;
        height: 10px;
    }

    .progress-bar {
        background: var(--bg-gradient);
        border-radius: inherit;
    }

    .course-status {
        margin-bottom: 1rem;
    }


    .courses-filter {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-flow: row;
        gap: 1rem;
    }

    select#filter-courses-grid {
        width: 50%;
    }

    span.select2 {
        width: 50% !important;
    }

    span.select2-selection.select2-selection--single {
        border-radius: 150px !important;
    }

    .certificate-card {
        background: #fff;
        padding: 0 1rem;
    }

    .course-image{
        background: url("<?= get_stylesheet_directory_uri() ?>/assets/img/non-completed-certificate.png");
        min-height: 200px;
        background-position: center;
        background-size: auto;
        background-repeat: no-repeat;
        width: 100%;
        border-radius: inherit;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
        margin-bottom: 2rem;
        position: relative;
    }

    .completed .course-image{
        background: url("<?= get_stylesheet_directory_uri() ?>/assets/img/completed-certificate.png");
        background-position: center;
        background-size: auto;
        background-repeat: no-repeat;
    }

    .course-image i {
        color: #fff;
        position: absolute;
        right: 1rem;
        font-size: 2rem;
        top: 1rem;
    }

    .courses-grid .text-center {
        width: 100%;
        display: block;
    }

    .course-card {
        width: 30%;
        height: 100%;
        min-height: auto;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-flow: column;
        border-radius: 30px;
        border: 1px solid #E8EDF0;
        box-shadow: 0 0 7px 3px #e2e5e940;
    }

    .course-short-desc {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        height: auto;
        text-align: center;
        min-height: 3rem;
    }

    .course-short-desc {
        margin-bottom: 1rem;
        width: 100%;
    }


    a.view-course {
        background: var(--pink);
        color: #fff;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0.7rem;
        margin: 1rem 0 2rem 0;
        border-radius: 50px;
        width: 90%;
        position: relative;
        border: 2px solid var(--pink);
        font-size: 0.9rem;
    }

    a.view-course i {
        color: #fff;
        position: absolute;
        right: 2rem;
    }

    a.view-course:hover {
        background: transparent;
        color: var(--pink);
        box-shadow: -1px 1px 10px 4px #ae00ff0f;
    }

    a.view-course:hover i {
        color: var(--pink);
    }

    .single-course-progress {
        width: 70%;
        margin-bottom: 1rem;
        height: 7px;
    }

    h3.p-3.course-title {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        line-clamp: 1;
        -webkit-box-orient: vertical;
        height: 3rem;
        text-align: center;
        font-size: 1.1rem;
    }

    .course-duration, .course-level {
        width: fit-content;
        margin: 0;
        padding: 0;
    }

    a.stm-lms-user-quiz__name.stm_preview_certificate {
        background: var(--bg-gradient);
        width: 90%;
        text-align: center;
        margin: 1rem 0;
        color: #fff;
        padding: 0.5rem;
        border-radius: 50px;
        position: relative;
    }

    i.fa-solid.fa-arrow-down {
        position: absolute;
        color: #fff;
        right: 2rem;
        top: 50%;
        transform: translateY(-50%);
    }

    a.stm-lms-user-quiz__name.stm_preview_certificate:hover {
        background: transparent;
        border: 2px solid;
    }




</style>



