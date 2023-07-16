<?php

    $user = wp_get_current_user();
    if ( !in_array( 'administrator', (array) $user->roles ) ):
        echo "<strong class='text-center'> You are not allowed to access this page. </strong>";
        return;
    endif;

?>

<h3 class="text-center"> Admin Tools </h3>

<ul class="tabs clearfix" data-tabgroup="first-tab-group">
    <li><a href="#tab1" class="active"> Instructors </a></li>
    <li><a href="#tab2">Sync Old Courses Meida</a></li>
</ul>
<section id="first-tab-group" class="tabgroup">
    <div id="tab1">

        <?php
            $args = array(
                'role'    => 'stm_lms_instructor',
            );
            $instructors = get_users( $args );
        ?>

        <table id="instructors_table" class="table table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th class="actions-td"> Action </th>
                </tr>
            </thead>

            <tbody>

                <?php
                    if( !empty($instructors) ):
                        foreach ($instructors as $index=>$instructor):
                            $status = get_user_meta($instructor->data->ID, 'admin_approval', true);
                            if( $status == true ):
                                $status_badge = '<span class="badge text-bg-success">Approved</span>';
                            else:
                                $status_badge = '<span class="badge text-bg-danger">Disapproved</span>';
                            endif;

                ?>
                    <tr>
                        <td><?= $index+1 ?></td>
                        <td> <?= $instructor->data->display_name ?> </td>
                        <td> <?= $instructor->data->user_email ?> </td>
                        <td> <?= $status_badge ?> </td>
                        <td class="action-btns">
                            <a href="#" class="btn btn-success btn-sm approve-instructor" data-btn-action="approved" data-instructor-id="<?= $instructor->data->ID ?>"> Approve <i class="fa-solid fa-user-check"></i> </a>
                            <a href="#" class="btn btn-danger btn-sm deny-instructor" data-btn-action="disapproved" data-instructor-id="<?= $instructor->data->ID ?>"> Disapprove <i class="fa-solid fa-user-xmark"></i> </a>
                            <a href="#" class="btn btn-info view-record panel-toggle" data-btn-action="view" data-instructor-id="<?= $instructor->data->ID ?>"> View <i class="fa-solid fa-id-card"></i> </a>
                        </td>
                    </tr>

                <?php
                        endforeach;
                    endif;
                ?>

            </tbody>

        </table>



    </div>
    <div id="tab2">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-start align-content-center gap-3">

                    <a href="#" class="btn btn-primary sync-old-courses"> Sync Old Courses Videos </a>

                </div>
            </div>

            <div class="col-md-12 mt-5 mb-5">
                <div class="sync-results"> </div>
            </div>
        </div>
    </div>


</section>


<div class="side-panel">

    <div class="hidden-panel animate__animated animate__slideInRight ">

        <div class="panel-header">
            <span class="hidden-panel-close"><i class="bb-icon-times bb-icon-l"></i> Close </span>
        </div>

        <div id="loading">
            <img id="loading-image" src="<?= get_stylesheet_directory_uri() ?>/assets/img/logo-animated.svg" alt="Loading..." />
        </div>

        <div class="hidden-panel-content panel-content">

        </div>
    </div>
</div>



<style>
    table a.btn * {
        color: #fff;
    }

    span.hidden-panel-close {
        color: #000;
        border-radius: 5px;
        width: fit-content;
        padding: 0.2rem 1rem;
    }

    div#loading img {
        width: 5rem;
    }

    div#loading {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    ul.tabs {
        margin: 0 !important;
        padding: 0;
    }

    h1 + p {
        text-align: center;
        margin: 20px 0;
        font-size: 16px;
    }
    .tabs li {
        float: left;
        width: 20%;
    }
    .tabs a {
        display: block;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        color: #888;
        padding: 20px 0;
        border-bottom: 2px solid #888;
        background: #f7f7f7;
        font-size: 0.9rem;
    }

    .tabs a:hover, .tabs a.active {
        background: var(--bg-gradient);
        color: #fff;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        font-weight: bold;
    }

    .clearfix:after {
        content: "";
        display: table;
        clear: both;
    }

    span.badge {
        min-width: 50%;
    }

    ul.tabs li {
        list-style: none;
    }

    .dataTables_length {
        width: 50%;
    }

    .dataTables_filter {
        width: 50%;
    }

    div#instructors_table_wrapper {
        display: flex;
        flex-flow: wrap;
        justify-content: center;
        align-items: center;
    }

    table tr {
        border: 0 !important;
    }

    .table>:not(caption)>*>* {
        border-color: #ddd;
    }

    table a.btn {
        background: unset;
        margin: 0 !important;
        line-height: 0 !important;
        text-transform: unset;
        padding: 0.7rem 1rem;
    }

    a.btn.btn-success.btn-sm.approve-instructor {
        background: #56b556;
    }

    a.btn.btn-danger.btn-sm.deny-instructor {
        background: #e5acac;
    }

    .view-record {
        background: #9595eb !important;
    }

    td.action-btns a {
        font-size: 0.8rem;
        padding: 0.5rem;
        margin-right: 0.5rem !important;
    }

    .actions-td, .action-btns{
        width: 30%;
    }





</style>




<script>




    jQuery('.tabgroup > div').hide();
    jQuery('.tabgroup > div:first-of-type').show();
    jQuery('.tabs a').click(function(e){
        e.preventDefault();
        var $this = jQuery(this),
            tabgroup = '#'+$this.parents('.tabs').data('tabgroup'),
            others = $this.closest('li').siblings().children('a'),
            target = $this.attr('href');
        others.removeClass('active');
        $this.addClass('active');
        jQuery(tabgroup).children('div').hide();
        jQuery(target).show();

    });

    // on click sync old courses
    jQuery(".sync-old-courses").on("click", function(e){
        e.preventDefault();
        jQuery('.sync-results').html('');
        jQuery('.ajax-loader').show();
        // load template qa
        jQuery.post(ajaxurl, {
            action: 'sync_old_courses',
        }, function (response){ // response callback function
            jQuery('.ajax-loader').hide();
            jQuery('.sync-results').html(response);
        })
            .done(function(response) {
                //alert( "second success" );
            });

    });

    jQuery(document).ready( function () {
        jQuery('#instructors_table').DataTable({
            "pageLength": 50
        });

    } );


    // on click approve
    jQuery(".action-btns a").on("click", function(){

        let instructor_id = $(this).data('instructor-id');
        let status = $(this).data('btn-action');

        if( status != 'view' ) {
            jQuery('.ajax-loader').show();
            jQuery.post(ajaxurl, {
                action: 'inctructor_admin_action',
                status: status,
                instructor_id: instructor_id
            }, function (response) { // response callback function
                jQuery('.ajax-loader').hide();
                showSuccess('Instructor ' + status + ' successfully');
                location.reload();
            })
                .done(function (response) {
                    //alert( "second success" );
                });
        } else {
            jQuery('#loading').show();
            jQuery('.panel-content').html('');
            jQuery.post(ajaxurl, {
                action: 'get_instructor_info',
                instructor_id: instructor_id
            }, function (response){ // response callback function
                jQuery('.ajax-loader').hide();
                jQuery('#loading').hide();
                jQuery('.panel-content').html(response);
            })
                .done(function(response) {
                    //alert( "second success" );
                });
        }

    });


    /**** side panel *****/
    var $menuToggle = jQuery('.panel-toggle'), $body = jQuery('.hidden-panel'), $panel_container =jQuery('.side-panel');

    function menuToggleClickHandler() {
        $body.toggleClass('panel-open');
        $panel_container.toggleClass('side-open');
        $menuToggle.toggleClass('open');
    }

    $("body").delegate( '.panel-toggle' , "click", function(e) {
        menuToggleClickHandler();
    });

    $("body").delegate( '.hidden-panel-close' , "click", function(e) {
        $body.removeClass('panel-open');
        $panel_container.removeClass('side-open');
        $menuToggle.removeClass('open');
    });


</script>