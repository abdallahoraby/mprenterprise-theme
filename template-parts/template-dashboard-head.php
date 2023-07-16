<?php

    if ( !empty($args) && $args['icon'] ):
        $icon = $args['icon'];
    else:
        $icon = 'default';
    endif;

    if ( !empty($args) && $args['back_template'] ):
        $back_template = $args['back_template'];
    else:
        $back_template = 'dashboard';
    endif;

    if ( !empty($args) && $args['term_id'] ):
        $term_id = $args['term_id'];
    else:
        $term_id = 'all';
    endif;


?>

<div class="courses-header p-5">
    <a href="<?= site_url() . '/dashboard'?>" class="back-to-dashboard" data-template-name="<?= $back_template ?>" data-term-id="<?= $term_id ?>">
        <i class="fa-solid fa-arrow-left"></i>
        <?= _e('Go Back To ' . ucfirst($back_template), 'masterstudy-child') ?>
    </a>

    <div class="courses-icon">
        <img src="<?= get_stylesheet_directory_uri() ?>/assets/img/<?= $icon ?>-icon.png" alt="">
    </div>

</div>


<style>
    .courses-header{
        background: url("<?= get_stylesheet_directory_uri() ?>/assets/img/<?= $icon ?>-header.png");
        min-height: 450px;
        background-repeat: no-repeat;
        margin: 3rem 0;
        border-radius: 30px;
        display: flex;
        justify-content: space-between;
        align-items: baseline;
    }

    a.back-to-dashboard {
        background: #3D5766;
        border-radius: 100px;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1rem;
        width: fit-content;
        padding: 0 2rem 0 0;
    }

    a.back-to-dashboard i {
        background: #fff;
        color: #3D5766;
        padding: 1rem;
        border-radius: 150px;
    }

    .courses-icon img{
        width: 3rem;
        height: 3rem;
        object-fit: contain;
    }

    .courses-icon {
        background: #3d5766;
        width: fit-content;
        padding: 1rem;
        border-radius: 100%;
    }


</style>


<script>
    jQuery(".back-to-dashboard").on("click", function(e){
        e.preventDefault();
        $('.ajax-loader').show();
        let template_name = jQuery(this).data('template-name');
        let term_id = jQuery(this).data('term-id');
        if( template_name == 'dashboard' ){
            var site_url = '<?= site_url(); ?>';
            window.location.href = site_url + '/dashboard';
        } else {
            // load this template
            jQuery.post(ajaxurl, {
                action: 'get_template_with_name',
                template_name: template_name,
                term_id: term_id
            }, function (response){ // response callback function
                $('.ajax-loader').hide();
                jQuery('.dashboard-content').html(response);
            })
            .done(function(response) {
                //alert( "second success" );
            });
        }
    });


</script>