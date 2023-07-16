<?php

    if ( !empty($args) && $args['zoom_data'] ):
        $zoom_data = $args['zoom_data'];
    endif;

    $host_id = $zoom_data['host_id'];
    $user_data = MPR_Core::get_user_by_meta_data('stm_lms_zoom_host', $host_id);

    pre_dump('https://us04web.zoom.us/wc/'.$zoom_data['id'].'/join');

?>


<div class="row new-course-section">
    <div class="col-md-12">
        <?php get_template_part('template-parts/template-dashboard-head', null, array(
            'icon' => 'live-sessions'
        )); ?>

        <div class="courses-bottom mid-gray d-flex flex-column">

            <div class="course-details-section">

                <?php if( empty($zoom_data) ): ?>
                    <p class='text-center p-5'> No Meeting ID found. </p>
                <?php else: ?>

                    <iframe src="https://us04web.zoom.us/wc/<?= $zoom_data['id'] ?>/join" width="100%" height="850px" title="live session"></iframe>

                    <div class="row d-flex justify-content-between align-content-center flex-wrap px-5 mt-5 mb-5 course-header-details">

                        <div class="hosted-by"> Hosted by <strong> <?= $user_data->data->display_name ?> </strong> </div>

                    </div>


                    <h3 class="course-title px-5"> <?= $zoom_data['topic'] ?> </h3>
                    <p class="course-description px-5"> <?= $zoom_data['agenda'] ?> </p>

                    <div class="row rate-this-course px-5">
                        <div class="col-md-6">
                            Rate This Live Session
                        </div>

                        <div class="col-md-6">
                            <div class="rate-stars">
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star checked"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>

            </div>





        </div>

    </div>
</div>


<style>

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


    [feature-type="participants"] {
        display: none !important;
    }




</style>