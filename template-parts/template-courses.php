<?php MPR_Core::check_login(); ?>

<?php
    if ( !empty($args) && $args['term_id'] ):
        $term_id = $args['term_id'];
    else:
        $term_id = 'all';
    endif;


    $term_posts = get_posts(array(
        'post_type' => 'stm-courses',
        'numberposts' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'stm_lms_course_taxonomy',
                'field' => 'term_id',
                'terms' => $term_id
            )
        )
    ));

    if( !empty($term_posts) ):
        $instructors_option = '';
        foreach ( array_column($term_posts, 'ID') as $term_post_id ):
            $author_ids[] = get_post_field( 'post_author', $term_post_id );
        endforeach;

        if( !empty($author_ids) ):
            $author_ids = array_unique($author_ids);
            foreach ( $author_ids as $author_id ):
                $author_obj = get_user_by('id', $author_id);
                $instructors_option .= '<option value="'. $author_id .'"> '. $author_obj->data->display_name .' </option>';
            endforeach;
        endif;

    endif;


?>

<section class="user-courses">

    <div class="top-info-section">

        <div class="row d-flex justify-content-between">

            <div class="col-md-6">
                <?php get_template_part('template-parts/template-breadcrumb'); ?>
            </div>

            <div class="col-md-6 profile-section">
                <div class="col-md-9 profile-info">
                    <?php
                        $user_obj = get_user_by('id', get_current_user_id());
                        $first_name = get_user_meta(get_current_user_id(), 'first_name', true) ;
                        $first_name = !empty($first_name) ? $first_name : 'N/A';
                        $last_name = get_user_meta(get_current_user_id(), 'last_name', true);
                        $last_name = !empty($last_name) ? $last_name : 'N/A';
                    ?>
                    <h3> <?= " $first_name $last_name " ?> </h3>
                    <p> Username: <span> <?=  $user_obj->data->user_login ?> </span> </p>
                    <div class="progress">
                        <div class="progress-bar w-75" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p> Courses progress: <strong class="progress-text"> 14/50 Hrs. Watched </strong> </p>
                </div>

                <div class="col-md-3 d-flex justify-content-center p-0">
                    <div class="rounded-corners-gradient-borders">
                        <img class="profile-picture" src="<?= get_stylesheet_directory_uri() ?>/assets/img/user-pic.png" alt="">
                    </div>
                </div>
            </div>


        </div>

    </div>

    <div class="courses-grid-data">

        <?php get_template_part('template-parts/template-dashboard-head', null, array(
            'icon' => 'course'
        )); ?>

        <div class="courses-bottom mid-gray">
            <div class="courses-filter">
                <i class="fa-solid fa-arrow-down-wide-short mid-gray"></i> <strong class="mid-gray heading-font filter-title"> Filter Courses By Instructor: </strong>
                <select id="filter-courses-grid" class="heading-font" aria-label="">
                    <option value="all" selected> Show All </option>
                    <?= $instructors_option ?>
                </select>
            </div>


            <div class="courses-grid">

                <?php
                    // check user role and load right template for him
                    $user = wp_get_current_user();
                    if ( in_array( 'stm_lms_instructor', (array) $user->roles ) ):
                        //The user has the "Instructor" role
                        get_template_part('template-parts/template-instructor-courses', null, array(
                            'term_id' => $term_id
                        ));
                    else:
                        get_template_part('template-parts/template-learner-courses', null, array(
                            'term_id' => $term_id
                        ));
                    endif;
                ?>




<!--                -->
<!--                <div class="hidden grid-content d-flex justify-content-start align-content-center gap-3 flex-wrap">-->
<!---->
<!--                    <div class="course-card">-->
<!--                        <div class="course-image"> <i class="fa-solid fa-circle-play"></i> </div>-->
<!--                        <div class="col-md-12 d-flex justify-content-between align-content-center">-->
<!--                            <div class="col-md-6 course-level"> Intermediate </div>-->
<!--                            <div class="col-md-6 course-duration"> 20 Minutes </div>-->
<!--                        </div>-->
<!--                        <strong class="col-md-12 course-short-desc"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur dignissimos  </strong>-->
<!--                        <a href="#" class="view-course"> Select <i class="fa-solid fa-arrow-right"></i> </a>-->
<!--                        <div class="progress single-course-progress">-->
<!--                            <div class="progress-bar w-75" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>-->
<!--                        </div>-->
<!--                        <div class="course-status"> Progress: <span> 05:20 watched </span> </div>-->
<!--                    </div>-->
<!---->
<!---->
<!--                    --><?php //for( $i=0; $i<=6; $i++): ?>
<!--                        <div class="course-card">-->
<!--                            <div class="course-image"> <i class="fa-solid fa-circle-play"></i> </div>-->
<!--                            <div class="col-md-12 d-flex justify-content-between align-content-center">-->
<!--                                <div class="col-md-6 course-level"> Intermediate </div>-->
<!--                                <div class="col-md-6 course-duration"> 20 Minutes </div>-->
<!--                            </div>-->
<!--                            <strong class="col-md-12 course-short-desc"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur dignissimos  </strong>-->
<!--                            <a href="#" class="view-course"> Select <i class="fa-solid fa-arrow-right"></i> </a>-->
<!--                            <div class="progress single-course-progress">-->
<!--                                <div class="progress-bar w-100" role="progressbar" aria-label="Basic example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>-->
<!--                            </div>-->
<!--                            <div class="course-status"> <span> Completed </span> </div>-->
<!--                        </div>-->
<!---->
<!--                    --><?php //endfor; ?>
<!---->
<!---->
<!---->
<!---->
<!--                </div>-->


            </div>

        </div>

    </div>

</section>


<style>




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
        width: 60%;
        background: #fff;
        padding: 1rem;
        border-radius: 50px;
        border: 1px solid #E8EDF0;
        font-size: 0.9rem;
    }

    span.select2 {
        width: 50% !important;
    }

    span.select2-selection.select2-selection--single {
        border-radius: 150px !important;
    }

    .course-image{
        background: url("<?= get_stylesheet_directory_uri() ?>/assets/img/single-course.png");
        min-height: 230px;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        width: 100%;
        border-radius: inherit;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
        margin-bottom: 2rem;
        position: relative;
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


    a.view-course,
    .edit-course{
        background: var(--pink);
        color: #fff;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0.7rem;
        margin: 1rem 0;
        border-radius: 50px;
        width: 90%;
        position: relative;
        border: 2px solid var(--pink);
        font-size: 0.9rem;
    }

    .edit-course {
        margin-top: 0;
        background: var(--orange);
        border-color: var(--orange);
    }

    .edit-course i {
        color: #fff;
        position: absolute;
        right: 2rem;
    }

    a.add_new_course_btn:hover {
        color: var(--pink) !important;
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

    .filter-title{
        font-size: 0.9rem;
    }





</style>