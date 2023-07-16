<link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/assets/css/bootstrap-icons.css">
<link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/assets/css/main.min.css"> <!-- main calendar style -->

<?php

    // check user role and load right template for him
    $user = wp_get_current_user();
    if ( in_array( 'stm_lms_instructor', (array) $user->roles ) ):
        //The user has the "Instructor" role
        $is_instructor = true;
    else:
        $is_instructor = false;
    endif;


    // get all learner courses
    $user_courses = STM_LMS_User::_get_user_courses(0, 'date_low');

    // extract post author id
    if( !empty($user_courses['posts']) ):

        foreach ( $user_courses['posts'] as $user_course ):

            // get assignments in this term only
            $term_list = wp_get_post_terms( $user_course['id'], 'stm_lms_course_taxonomy', array( 'fields' => 'all' ) );
            $course_term_id = (int) $term_list[0]->term_id;

//            if( $term_id == $course_term_id ):
                $instructor_ids[] = get_post_field( 'post_author', $user_course['id'] );
//            endif;

        endforeach;


    endif;


?>


<?php
    if( $is_instructor == false ):
        get_template_part('template-parts/template-learner-details');
    endif;
    ?>

<div class="row new-course-section">
    <div class="col-md-12">
        <?php get_template_part('template-parts/template-dashboard-head', null, array(
            'icon' => 'live-sessions'
        )); ?>

        <div class="courses-bottom mid-gray d-flex flex-column">


            <div class="courses-filter d-flex justify-content-center align-content-center gap-5">
                <div class="filter-title">
                    <i class="fa-solid fa-arrow-down-wide-short mid-gray"></i>
                    <strong class="mid-gray">  Filter Live By Instructor: </strong>
                </div>
                <select id="instructor-id" aria-label="">
                    <option value="show-all" selected> Show All </option>
                    <?php if( !empty($instructor_ids) ):
                        $instructor_ids = array_unique($instructor_ids);
                        foreach ( $instructor_ids as $instructor_id ):
                            $user_obj = get_user_by('id', $instructor_id);
                            ?>
                            <option value="<?= $instructor_id ?>"> <?= $user_obj->data->display_name ?> </option>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </select>
            </div>
            <span class="mt-5 mb-5 text-center"> Showing <strong> <?= 20 ?> Results </strong> </span>


            <div class="sessions-calendar-view">
    <!--            <label for="datepicker"> select date: </label>-->
    <!--            <input type="date" id="datepicker" name="datepicker">-->

                <div class="calendar-datepicker">
                    <select name="month" class="month" id="month">
                        <option value="01" selected>Jan</option>
                        <option value="02">Feb</option>
                        <option value="03">Mar</option>
                        <option value="04">Apr</option>
                        <option value="05">May</option>
                        <option value="06">Jun</option>
                        <option value="07">Jul</option>
                        <option value="08">Aug</option>
                        <option value="09">Sep</option>
                        <option value="10">Oct</option>
                        <option value="11">Nov</option>
                        <option value="12">Dec</option>
                    </select>

                    <select id="year" name="year" class="year">
                        <option value="2022" selected>2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                        <option value="2031">2031</option>
                        <option value="2032">2032</option>
                        <option value="2033">2033</option>
                        <option value="2034">2034</option>
                        <option value="2035">2035</option>
                        <option value="2036">2036</option>
                        <option value="2037">2037</option>
                        <option value="2038">2038</option>
                        <option value="2039">2039</option>
                        <option value="2040">2040</option>
                        <option value="2041">2041</option>
                        <option value="2042">2042</option>
                        <option value="2043">2043</option>
                        <option value="2044">2044</option>
                        <option value="2045">2045</option>
                        <option value="2046">2046</option>
                        <option value="2047">2047</option>
                        <option value="2048">2048</option>
                        <option value="2049">2049</option>
                        <option value="2050">2050</option>
                    </select>
                </div>

                <div id='calendar'></div>
                <div id="loading" style="display:none;">
                    <img id="loading-image" src="<?= get_stylesheet_directory_uri() ?>/assets/img/logo-animated.svg" alt="Loading..." />
                </div>

            </div>


            <span class="mt-5 mb-3 text-center"> Upcoming Live Sessions </span>
            <div class="upcoming-sessions"> </div>

        </div>

    </div>
</div>


<!--<a href="#" class="btn btn-info get_sessions"> get sessions </a>-->

<style>
    table.fc-scrollgrid-sync-table {
        width: 97% !important;
    }


    .single-session {
        background: #fff;
        margin: 1rem 0;
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        border-radius: 30px;
        border: 1px solid #E8EDF0;
    }

    .session-details {
        width: 75%;
    }


    .session-day {
        background: var(--pink);
        color: #fff;
        font-size: 1.5rem;
        padding: 1rem;
        border-radius: 100%;
        width: 3.5rem;
        height: 3.5rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .session-details * {
        margin: 0;
    }

    .session-details h3 {
        font-size: 1rem;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        line-clamp: 1;
        -webkit-box-orient: vertical;
    }

    .session-link {
        display: flex;
        flex-flow: column;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        width: 20%;
        line-height: 1.5rem;
    }

    .session-link * {
        margin: 0;
    }

    .session-link a {
        background: var(--pink);
        width: 100%;
        color: #fff;
        text-align: center;
        position: relative;
        padding: 0.3rem;
        border-radius: 100px;
    }

    .session-link a i {
        position: absolute;
        color: #fff;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
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



    #loading {
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        position: fixed;
        display: block;
        opacity: 0.7;
        background-color: #fff;
        z-index: 99;
        text-align: center;
    }

    #loading-image {
        position: absolute;
        top: 50%;
        left: 50%;
        z-index: 100;
        width: 5rem;
        transform: translate(-50%, -50%);
    }

    .event-tooltip {
        position: absolute;
        background: #fff;
        padding: 1rem;
        top: 100%;
        left: 0;
        display: none;
        width: 350px;
    }

    div#calendar {
        background: #fff;
        padding: 2rem;
        border-radius: 30px;
        border: 1px solid #E8EDF0;
    }

    .fc-day-today .fc-daygrid-day-number {
        background: var(--pink);
        color: #fff !important;
        font-weight: bold;
        width: 2rem !important;
        height: 2rem;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 100%;
    }


    .event-title:hover .event-tooltip {
        display: block !important;
    }

    .event-title {
        background: var(--orange);
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.3rem 0.5rem;
        border-radius: 30px;
        cursor: pointer;
    }

    a.fc-daygrid-event.fc-daygrid-dot-event.fc-event:hover {
        background: transparent;
    }

    .event-tooltip {
        position: absolute;
        background: #fff;
        padding: 0;
        top: 100%;
        left: -50%;
        display: none;
        border-radius: 30px !important;
        border: 1px solid #E8EDF0 !important;

    }

    .event-title i {
        color: #fff;
    }

    .tooltip-data {
        padding: 1rem;
        display: flex;
        flex-flow: column;
    }

    .calendar-datepicker {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1rem;
        margin: 1rem auto;
        width: 35%;
    }

    span#select2-year-container {
        background: #f6f8fa;
        text-align: center;
    }

    span.select2-selection.select2-selection--single {
        border: 0;
    }


    span#select2-month-7x-container {
        background: #E8EDF0;
        border-radius: inherit;
        text-align: center;
    }

    .fc .fc-daygrid-day.fc-day-today {
        background: transparent;
    }

    div#calendar table tr {
        border: 0 !important;
    }

    .fc-toolbar-title {
        font-size: 1rem !important;
    }

    button.fc-today-button.btn.btn-primary {
        padding: 0.5rem;
        font-size: 0.8rem;
        background: var(--bg-gradient);
        border: 0;
    }

    button.fc-next-button.btn.btn-primary, button.fc-prev-button.btn.btn-primary {
        padding: 0.4rem 0.5rem;
        border: 1px solid;
    }

    button.fc-next-button.btn.btn-primary:hover, button.fc-prev-button.btn.btn-primary:hover {
        background: var(--bg-gradient);
    }

    button.fc-next-button.btn.btn-primary:hover *, button.fc-prev-button.btn.btn-primary:hover *{
        color: #fff;
    }

    .fc, .fc *, .fc :after, .fc :before {
        border: 0;
    }

    img.featured {
        border-radius: inherit;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        z-index: 9999;
        min-height: 180px;
        min-width: 280px;
    }

    .tooltip-data .row .col-md-6 {
        display: flex;
        justify-content: initial;
        align-items: center;
        gap: 0.5rem;
    }

    .tooltip-data .row .col-md-6:first-child {
        color: var(--orange);
        font-weight: bold;
    }

    p.event-host {
        margin-bottom: 0.5rem;
    }

    .fc-daygrid-day-frame {
        z-index: inherit;
    }

    .fc-daygrid-day-events {
        z-index: 5 !important;
    }




</style>

<script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js"></script>

<!--full calendar script-->
<script src="<?= get_stylesheet_directory_uri() ?>/assets/js/main.min.js"></script>

<script>

    jQuery(document).ready(function() {



        jQuery('#instructor-id').select2();

        // jQuery('.event-title').on('click', function(){
        //
        //     let event_id = jQuery(this).data('event-id');
        //     jQuery('.event_' + event_id).show();
        //
        // })


        jQuery(".get_sessions").on("click", function(e){
            e.preventDefault();

            jQuery.post(ajaxurl, {
                action: 'get_learner_live_sessions',
            }, function (response){ // response callback function

            })
            .done(function(response) {

            });

        });


        jQuery('#month').on('select2:select', function (e) {
            var month = e.params.data.id;
            let year = jQuery('#year').val();
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, settings);
            calendar.render();
            calendar.gotoDate(year + '-' + month + '-01');
        });

        jQuery('#year').on('select2:select', function (e) {
            var year = e.params.data.id;
            let month = jQuery('#month').val();
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, settings);
            calendar.render();
            calendar.gotoDate(year + '-' + month + '-01');
        });

        // on click single live session get it
        jQuery("body").delegate(".view-single-session", "click", function(e){
            e.preventDefault();
            $('.ajax-loader').show();
            let session_id = $(this).data('session-id');
            // load template courses
            jQuery.post(ajaxurl, {
                action: 'get_single_live_session',
                session_id: session_id
            }, function (response){ // response callback function
                $('.ajax-loader').hide();
                jQuery('.new-course-section').html(response);
            })
                .done(function(response) {
                    //alert( "second success" );
                });

        });




    }); // END OF DOCUMENT READY



    let settings = {

        initialView: 'dayGridMonth',
        themeSystem: 'bootstrap',
        view: 'dayGridMonth',
        nowIndicator: true,
        flexibleSlotTimeLimits: true,
        eventStartEditable: false,
        eventSources: [{
            url: ajaxurl,
            method: 'POST',
            extraParams: function () {
                return {
                    action: 'get_learner_live_sessions',
                };
            }
        }],
        eventSourceSuccess: function(content, xhr) {
            // append live events to bottom list section
            $.each(content, function(i, item) {
                let session_details = content[i].extendedProps.single_session_details;
                $('.upcoming-sessions').append(session_details);
            });
        },
        eventBackgroundColor: '#ccc',
        loading: function (isLoading) {
            if (isLoading) {
                $('#loading').show();
            }
            else {
                $('#loading').hide();
            }
        },
        eventContent: function (arg) {

            let event = arg.event;
            let props = event.extendedProps;
            let event_id = props.id;
            let desc = props.description;

            let nodes = [];

            let event_tooltip = $('<div class="event-tooltip event_'+ event_id +'" >' + desc + '</div>');

            let event_title = $('<div class="tooltip-top event-title" data-event-id="'+ event_id +'">' + event.title + '<div class="event-tooltip">' + desc + ' </div> </div>');

            nodes.push(event_title.get(0))
            //nodes.push(event_tooltip.get(0))
            return {domNodes: nodes};
        },
        contentHeight: 600,
        aspectRatio: 1.8,
        header: {
            left: "prev,next",
            center: "",
            right: "today, myCustomButton"
        },
        navLinks: false,
        eventLimit: true,
        customButtons: {
            myCustomButton: {
                text: 'Jump to date',
                click: function() {
                    $("#calendar").fullCalendar('gotoDate','2022-01-01');
                }
            }
        },
        dayClick: function(seldate,jsEvent,view) {
            //window.location.href=entryScreen+"?dt="+seldate.format();
            return false;
        }

    }; // end of calendar settings

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, settings);
        calendar.render();
    });

    // jQuery('#datepicker').on('change', function (){
    //     let date = jQuery(this).val();
    //     var calendarEl = document.getElementById('calendar');
    //     var calendar = new FullCalendar.Calendar(calendarEl, settings);
    //     calendar.render();
    //     calendar.gotoDate(date);
    // });








</script>