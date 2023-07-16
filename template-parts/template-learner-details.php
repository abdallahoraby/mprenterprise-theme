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