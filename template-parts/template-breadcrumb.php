<?php
    // check if user instructor
    // check user role and load right template for him
    $user = wp_get_current_user();
    if ( in_array( 'stm_lms_instructor', (array) $user->roles ) ):
        $user_role = 'INSTRUCTOR';
    else:
        $user_role = 'STUDENT';
    endif;
?>

<div class="header-title mb-5 text-center d-flex gap-3 align-content-baseline justify-content-start">
    <img src="<?= get_stylesheet_directory_uri() ?>/assets/img/logo-main.png" alt="">
    <span class="heading-font"> Metapreneurz </span>
    <span class="role heading-font mid-gray"> / <?= $user_role ?> </span>
</div>