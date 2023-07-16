<?php

/******
 * Ajax action to create new instructor user
 ******/


function register_new_instructor(){
    $data['register_nonce'] = $_POST['register_nonce'];
    $data['first_name'] = $_POST['first_name'];
    $data['last_name'] = $_POST['last_name'];
    $data['user_email_register'] = $_POST['user_email_register'];
    $data['user_password_register'] = $_POST['user_password_register'];
    $data['user_password_register_retype'] = $_POST['user_password_register_retype'];
    $data['phone_input'] = $_POST['phone_input'];
    $data['course_category_register'] = $_POST['course_category_register'];
    $data['user_bio'] = $_POST['user_bio'];
    $data['has_ready_courses'] = $_POST['has_ready_courses'];


    echo MPR_Core::mpr_instructor_register($data);

    wp_die();


}
add_action('wp_ajax_register_new_instructor', 'register_new_instructor');
add_action( 'wp_ajax_nopriv_register_new_instructor', 'register_new_instructor' );



/******
 * Ajax action to get user courses
 ******/


function get_user_courses(){
    $term_id = $_POST['term_id'];

    get_template_part('template-parts/template-courses', null, array(
        'term_id' => $term_id
    ));

    wp_die();


}
add_action('wp_ajax_get_user_courses', 'get_user_courses');
add_action( 'wp_ajax_nopriv_get_user_courses', 'get_user_courses' );



/******
 * Ajax action to get ajax loader template
 ******/


function get_ajax_loader(){

    // load ajax loader in each page
    get_template_part('template-parts/template-ajax-loader');

    wp_die();


}
add_action('wp_ajax_get_ajax_loader', 'get_ajax_loader');
add_action( 'wp_ajax_nopriv_get_ajax_loader', 'get_ajax_loader' );


/******
 * Ajax action to get Register Success template
 ******/


function get_register_success(){

    // load ajax loader in each page
    get_template_part('template-parts/template-register-success');

    wp_die();


}
add_action('wp_ajax_get_register_success', 'get_register_success');
add_action( 'wp_ajax_nopriv_get_register_success', 'get_register_success' );



/******
 * Ajax action to create new course
 ******/


function create_new_course(){


    $data['add_new_course_nonce'] = $_POST['add_new_course_nonce'];
    $data['course_title'] = $_POST['course-title'];
    $data['course_level'] = $_POST['course-level'];
    $data['course_category'] = $_POST['course-category'];
    $data['video_duration'] = $_POST['video-duration'];
    $data['video_description'] = $_POST['video-description'];
//    $data['course_video_file'] = $_FILES['course-video-file'];

    MPR_Core::create_new_course($data);

//    if( MPR_Core::create_new_course($data) == true ):
//        $r['message'] =  esc_html__( 'success', 'masterstudy-lms-learning-management-system' );
//        wp_send_json( $r );
//    else:
//        $r['message'] =  esc_html__( 'fail', 'masterstudy-lms-learning-management-system' );
//        wp_send_json( $r );
//    endif;

    wp_die();


}
add_action('wp_ajax_create_new_course', 'create_new_course');
add_action( 'wp_ajax_nopriv_create_new_course', 'create_new_course' );



/******
 * Ajax action to create new assignment
 ******/


function add_new_assignment(){


    $data['add_new_assignment_nonce'] = $_POST['add_new_assignment_nonce'];
    $data['course-select'] = $_POST['course-select'];
    $data['assignment-title'] = $_POST['assignment-title'];
    $data['assignment-description'] = $_POST['assignment-description'];
    $data['assignment-file'] = $_FILES['assignment-file'];


    MPR_Core::create_new_assignment($data);



    wp_die();


}
add_action('wp_ajax_add_new_assignment', 'add_new_assignment');
add_action( 'wp_ajax_nopriv_add_new_assignment', 'add_new_assignment' );



/******
 * Ajax action to get new course template
 ******/


function get_new_course_template(){

    get_template_part('template-parts/template-new-course');

    wp_die();


}
add_action('wp_ajax_get_new_course_template', 'get_new_course_template');
add_action( 'wp_ajax_nopriv_get_new_course_template', 'get_new_course_template' );


/******
 * Ajax action to get assignments template
 ******/


function get_instructor_assignments(){

    get_template_part('template-parts/template-new-assignment');

    wp_die();


}
add_action('wp_ajax_get_instructor_assignments', 'get_instructor_assignments');
add_action( 'wp_ajax_nopriv_get_instructor_assignments', 'get_instructor_assignments' );


/******
 * Ajax action to get add live sessions template
 ******/


function get_instructor_live_sessions(){

    get_template_part('template-parts/template-new-live-session');

    wp_die();


}
add_action('wp_ajax_get_instructor_live_sessions', 'get_instructor_live_sessions');
add_action( 'wp_ajax_nopriv_get_instructor_live_sessions', 'get_instructor_live_sessions' );


/******
 * Ajax action to get learner assignments template
 ******/


function get_learner_assignments(){

    $term_id = $_POST['term_id'];
    get_template_part('template-parts/template-learner-assignments', null, array(
        'term_id' => $term_id
    ));

    wp_die();


}
add_action('wp_ajax_get_learner_assignments', 'get_learner_assignments');
add_action( 'wp_ajax_nopriv_get_learner_assignments', 'get_learner_assignments' );


/******
 * Ajax action to get learner certificates template
 ******/


function get_learner_certificates(){


    get_template_part('template-parts/template-learner-certificates');

    wp_die();


}
add_action('wp_ajax_get_learner_certificates', 'get_learner_certificates');
add_action( 'wp_ajax_nopriv_get_learner_certificates', 'get_learner_certificates' );


/******
 * Ajax action to get learner Q&A template
 ******/


function get_learner_qa(){


    get_template_part('template-parts/template-learner-qa');

    wp_die();


}
add_action('wp_ajax_get_learner_qa', 'get_learner_qa');
add_action( 'wp_ajax_nopriv_get_learner_qa', 'get_learner_qa' );


/******
 * Ajax action to get learner live sessions template
 ******/


function get_learner_live_sessions_template(){


    get_template_part('template-parts/template-list-live-sessions');

    wp_die();


}
add_action('wp_ajax_get_learner_live_sessions_template', 'get_learner_live_sessions_template');
add_action( 'wp_ajax_nopriv_get_learner_live_sessions_template', 'get_learner_live_sessions_template' );



/******
 * Ajax action to get single assignment template
 ******/


function get_single_assignment(){

    $assignment_id = $_POST['assignment_id'];
    $course_id = $_POST['course_id'];
    get_template_part('template-parts/template-single-assignment', null, array(
        'assignment_id' => $assignment_id,
        'course_id' => $course_id
    ));

    wp_die();


}
add_action('wp_ajax_get_single_assignment', 'get_single_assignment');
add_action( 'wp_ajax_nopriv_get_single_assignment', 'get_single_assignment' );




/******
 * Ajax action to submit new learner assignment
 ******/


function submit_new_learner_assignment(){


    $data['add_new_assignment_nonce'] = $_POST['add_new_assignment_nonce'];
    $data['submitted_assignment_content'] = $_POST['submitted_assignment_content'];
    $data['course_id'] = $_POST['course_id'];
    $data['assignment_id'] = $_POST['assignment_id'];
    $data['submitted_assignment_file'] = $_FILES['submitted_assignment_file'];


    MPR_Core::submit_new_learner_assignment($data);



    wp_die();


}
add_action('wp_ajax_submit_new_learner_assignment', 'submit_new_learner_assignment');
add_action( 'wp_ajax_nopriv_submit_new_learner_assignment', 'submit_new_learner_assignment' );


/******
 * Ajax action to submit new zoom meeting
 ******/


function add_new_meeting(){


    $data['add_meeting_nonce'] = $_POST['add_meeting_nonce'];
    $data['course-select'] = $_POST['course-select'];
    $data['meeting_date_utc'] = $_POST['meeting_date_utc'];
    $data['timezone'] = $_POST['timezone'];
    $data['meeting_duration'] = $_POST['meeting_duration'];
    $data['meeting-title'] = $_POST['meeting-title'];
    $data['meeting-description'] = $_POST['meeting-description'];


    MPR_Core::add_new_meeting_session($data);


    wp_die();


}
add_action('wp_ajax_add_new_meeting', 'add_new_meeting');
add_action( 'wp_ajax_nopriv_add_new_meeting', 'add_new_meeting' );



/******
 * Ajax action to get learner live sessions
 ******/


function get_learner_live_sessions(){

    $user = wp_get_current_user();
    if ( in_array( 'stm_lms_instructor', (array) $user->roles ) ):
        //The user has the "Instructor" role
        $action_text = 'Start Session';
    else:
        $action_text = 'View';
    endif;

    // get all learner courses
    $user_courses = STM_LMS_User::_get_user_courses(0, 'date_low');

    // extract post author id
    if( !empty($user_courses['posts']) ):
        $courses_ids = array_column($user_courses['posts'], 'id');
    else:
        // learner has no courses, then he can not see live sessions
        wp_die();
    endif;


    $all_live_sessions = get_posts(
        array(
            'posts_per_page' => -1,
            'post_type' => 'stm-zoom',
            'post_status' => 'publish',
        )
    );
    $calendar_data = [];
    if( !empty( $all_live_sessions ) ):
        global $wpdb;
        $table_name = $wpdb->prefix . 'postmeta';
        foreach ( $all_live_sessions as $key=>$live_session ):
            $session_id = $live_session->ID;

            $session_course_result = $wpdb->get_results(
                "SELECT * FROM $table_name  WHERE meta_key LIKE 'live_session_id' AND meta_value = {$session_id} "
            );
            $wpdb->flush();

            if( !empty($session_course_result) ):
                $course_id = $session_course_result[0]->post_id;
                if( in_array($course_id, $courses_ids) ):

                    // get zoom data start time
                    $zoom_data = get_post_meta($session_id, 'stm_zoom_data', true);
                    if( !empty($zoom_data) ):
                        $featured_image_url = !empty(get_the_post_thumbnail_url($course_id, 'post-thumbnail')) ? get_the_post_thumbnail_url($course_id, 'post-thumbnail') : get_stylesheet_directory_uri() . '/assets/img/single-course.png' ;
                        $featured_image_url = get_stylesheet_directory_uri() . '/assets/img/single-course.png';
                        $live_icon = get_stylesheet_directory_uri() . '/assets/img/live_icon.png';
                        $duration = $zoom_data['duration'];
                        $description = $zoom_data['agenda'];
                        $host_id = $zoom_data['host_id'];
                        $user_data = MPR_Core::get_user_by_meta_data('stm_lms_zoom_host', $host_id);


                        $tooltip = " 
                                 <img class='featured' src='$featured_image_url' alt=''>
                                <div class='tooltip-data'>
                                    <div class='row'>
                                        <div class='col-md-6'> <img src='$live_icon' alt=''> Live </div>
                                        <div class='col-md-6'> Streaming for $duration mins </div>
                                    </div>
                                    <p class='event-desc'> $description </p>
                                    <p class='event-host'> Hosted by <strong> ". $user_data->data->display_name ." </strong> (Instructor) </p>
                                 </div>
                        ";

                        $single_session_details = "
                            <div class='single-session'>
                                <div class='session-day'> ". date('d', strtotime($zoom_data['start_time'])) ." </div>
                                <div class='session-details'>
                                    <p> ". date('l, d F, Y (h:i A UTC)', strtotime($zoom_data['start_time'])) ." </p>
                                    <h3> ". $zoom_data['agenda'] . " </h3>
                                </div>
                                <div class='session-link'>
                                    <p> Instructor ". $user_data->data->display_name ." </p>
                                    <a href='#' class='view-single-session' data-session-id='". $session_id ."' target='_blank'> ". __($action_text, 'mpr') ." <i class='fa-solid fa-arrow-right'></i> </a>
                                </div>
                            </div>
                        ";

                        $calendar_data[$key]['title'] =  substr($zoom_data['topic'], 0, 15) ."... <i class='fa-solid fa-arrow-right'></i> <span class='toolttext hidden'> ". $zoom_data['topic'] ." </span>";
                        $calendar_data[$key]['eventColor'] = 'var(--orange)';
                        $calendar_data[$key]['backgroundColor'] = 'var(--orange)';
                        $calendar_data[$key]['textColor'] = '#fff';
                        $calendar_data[$key]['start'] = date('Y-m-d H:i:s', strtotime($zoom_data['start_time']));
                        $calendar_data[$key]['end'] = date('Y-m-d H:i:s', strtotime($zoom_data['start_time']. ' +'.$zoom_data['duration'].' minutes'));
                        $calendar_data[$key]['extendedProps']['id'] = $session_id;
                        $calendar_data[$key]['extendedProps']['description'] = $tooltip;
                        $calendar_data[$key]['extendedProps']['single_session_details'] = $single_session_details;

                    endif;
                endif;
            endif;

        endforeach;

        wp_send_json(array_values($calendar_data));

    endif;


    wp_die();


}
add_action('wp_ajax_get_learner_live_sessions', 'get_learner_live_sessions');
add_action( 'wp_ajax_nopriv_get_learner_live_sessions', 'get_learner_live_sessions' );


/******
 * Ajax action to get single live sessions
 ******/


function get_single_live_session(){
    $session_id = $_POST['session_id'];
    $zoom_data = get_post_meta($session_id, 'stm_zoom_data', true);
    if( empty($zoom_data) ):
        echo 'No live session found';
    else:
        get_template_part('template-parts/template-single-live-session', null, array(
            'zoom_data' => $zoom_data
        ));
    endif;

    wp_die();
}
add_action('wp_ajax_get_single_live_session', 'get_single_live_session');
add_action( 'wp_ajax_nopriv_get_single_live_session', 'get_single_live_session' );


/******
 * Ajax action to submit new learner Q&A
 ******/


function create_new_qa(){

    global $wpdb;
    $table_name = $wpdb->prefix . "qa";

    $add_new_qa_nonce = $_POST['add_new_qa_nonce'];
    $qa_title = $_POST['qa-title'];
    $qa_description = $_POST['qa-description'];
    $sender_id = get_current_user_id();

    $data = array(
        array(
            'sender_id' => $sender_id,
            'title' => $qa_title,
            'description' => $qa_description,
        )
    );
    // insert data
    $insert_qa = MPR_Core::wpdb_bulk_insert($table_name, $data);
    if( $insert_qa == 1 ):
        // success get all previous qa
        $learner_qa = MPR_Core::get_learner_qa();
        if( !empty($learner_qa) ):
            $qa_item_html = '';
            $learner_obj = get_user_by('id', get_current_user_id());
            $default_image = get_stylesheet_directory_uri() . '/assets/img/user-pic.png';

            foreach ( $learner_qa as $qa_item ):
                $posted_on = date('l, d F, Y', strtotime( $qa_item->created_at ));
                $qa_item_html .= '
                    <div class="row single-qa qa-'. $qa_item->id .'">
                        <div class="col-md-6 d-flex justify-content-start align-content-center flex-wrap gap-3">
                            <img src="'. $default_image .'" alt="">
                            <div class="learner-name">
                                <h3> '. $learner_obj->data->display_name .' </h3>
                                <p> Forex Student </p>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end align-content-center flex-column gap-3">
                            <p class="text-right opacity-75"> Posted on Wednesday, 23 February, 2022 </p>
                            <span class="text-right d-flex justify-content-end gap-3">
                                <a href="#" class="edit-qa pink"> Edit Question </a>
                                <a href="#" data-qa-id="'. $qa_item->id .'" class="close-qa orange"> Close Question </a>
                            </span>
                        </div>
                        <div class="col-md-12 qa-details mt-4">
                            <h3> '. $qa_item->title .'  </h3>
                            <p class="mt-3"> '. $qa_item->description .' </p>
                        </div>
                </div>
                ';
            endforeach;
            wp_send_json_success( $qa_item_html );
        endif;
    else:
        echo "Error: $insert_qa";
    endif;

    wp_die();


}
add_action('wp_ajax_create_new_qa', 'create_new_qa');
add_action( 'wp_ajax_nopriv_create_new_qa', 'create_new_qa' );



/******
 * Ajax action to delete record
 ******/


function delete_record(){

    global $wpdb;
    $table_name = $wpdb->prefix . "qa";
    MPR_Core::deleteRecord($table_name, $_POST['id']);
    echo 'success';
    wp_die();


}
add_action('wp_ajax_delete_record', 'delete_record');
add_action( 'wp_ajax_nopriv_delete_record', 'delete_record' );


/******
 * Ajax action to get instructor qa template
 ******/


function get_instructor_qa(){

    get_template_part('template-parts/template-instructor-qa');
    wp_die();


}
add_action('wp_ajax_get_instructor_qa', 'get_instructor_qa');
add_action( 'wp_ajax_nopriv_get_instructor_qa', 'get_instructor_qa' );


/******
 * Ajax action to post respond to qa
 ******/


function respond_to_qa(){
    global $wpdb;
    $table_name = $wpdb->prefix . "qa";
    $receiver_id = get_current_user_id();
    $description = $_POST['qa-respond-description'];
    $qa_id = $_POST['qa-id'];

    // insert in qa table
    $data = array(
        array(
            'receiver_id' => $receiver_id,
            'description' => $description,
            'parent_qa' => $qa_id,
        )
    );
    $insert_qa_respond = MPR_Core::wpdb_bulk_insert($table_name, $data);
    if( $insert_qa_respond == 1 ):
        // get all qa responds to refresh  and stay in same page
        $qa_responds = MPR_Core::get_qa_responds($qa_id);
        $qa_responds_html = '';
        if( !empty($qa_responds) ):
            $qa_responds_html .= '
                <p class="decorated mt-5 mb-5"><span> '. count($qa_responds) .' Responses </span></p>
                <div class="qa-replies instructor">
                ';

            foreach ( $qa_responds as $qa_respond ):
                $user_obj = get_user_by('id', $qa_respond->receiver_id);
                $posted_on = date('l, d F, Y', strtotime( $qa_respond->created_at ));
                $qa_responds_html .= '
                
                    <div class="single-reply row">
                            <div class="col-md-6 d-flex justify-content-start align-content-center flex-wrap gap-3">
                                <img src="'. get_stylesheet_directory_uri() .'/assets/img/user-pic.png" alt="">
                                <div class="learner-name">
                                    <h3> '. $user_obj->data->display_name .' </h3>
                                    <p> Forex Instructor </p>
                                </div>
                            </div>
    
                            <div class="col-md-6 d-flex justify-content-end align-content-center flex-column gap-3">
                                <p class="text-right opacity-75"> Posted on '. $posted_on .' </p>
                            </div>
    
                            <div class="col-md-12 qa-details mt-4">
                                <p class="mt-3"> '. $qa_respond->description .' </p>
                            </div>
    
                    </div>
                
                ';
            endforeach;
            $qa_responds_html .= '</div>';
        endif;
        wp_send_json_success($qa_responds_html);
    else:
        wp_send_json_error($insert_qa_respond);
    endif;
    wp_die();


}
add_action('wp_ajax_respond_to_qa', 'respond_to_qa');
add_action( 'wp_ajax_nopriv_respond_to_qa', 'respond_to_qa' );



/******
 * Ajax action to get single course
 ******/


function get_single_course(){

    $course_id = $_POST['course_id'];
    get_template_part('template-parts/template-single-course', null, array(
        'course_id' => $course_id
    ));
    wp_die();


}
add_action('wp_ajax_get_single_course', 'get_single_course');
add_action( 'wp_ajax_nopriv_get_single_course', 'get_single_course' );

/******
 * Ajax action to get single course edit page
 ******/


function edit_course(){

    $course_id = $_POST['course_id'];
    get_template_part('template-parts/template-edit-course', null, array(
        'course_id' => $course_id
    ));
    wp_die();


}
add_action('wp_ajax_edit_course', 'edit_course');
add_action( 'wp_ajax_nopriv_edit_course', 'edit_course' );


/******
 * Ajax action to sync old courses videos
 ******/


function sync_old_courses(){
    $synced_courses = MPR_Core::sync_old_courses_videos();
    if( $synced_courses !== false ):
        echo "$synced_courses courses has been synced successfully.";
    endif;
    wp_die();


}
add_action('wp_ajax_sync_old_courses', 'sync_old_courses');
add_action( 'wp_ajax_nopriv_sync_old_courses', 'sync_old_courses' );


/******
 * Ajax action to approve/deny instructor
 ******/


function inctructor_admin_action(){
    $status = $_POST['status'];
    $instructor_id = $_POST['instructor_id'];
    if( $status == 'approved' ):
        update_user_meta($instructor_id, 'admin_approval', 1);
        // send email to inform instructor his account is approved
        $user_obj = get_user_by('id', $instructor_id);

        $to = $user_obj->data->user_email;
        $subject = 'Your Account Is Approved';
        $body = 'Kindly be informed that your instructor account has been approved from admin. <br> Thanks';
        $headers = array('Content-Type: text/html; charset=UTF-8');

        wp_mail( $to, $subject, $body, $headers );

    elseif ( $status == 'disapproved' ):
        update_user_meta($instructor_id, 'admin_approval', 0);
    endif;
    wp_die();


}
add_action('wp_ajax_inctructor_admin_action', 'inctructor_admin_action');
add_action( 'wp_ajax_nopriv_inctructor_admin_action', 'inctructor_admin_action' );



/******
 * Ajax action to get instructor details
 ******/


function get_instructor_info(){
    $instructor_id = $_POST['instructor_id'];
    $user_obj = get_user_by('id', $instructor_id);
    $user_bio = get_user_meta( $instructor_id, 'description', true );
    $user_phone = get_post_meta( $instructor_id, 'user_phone', true );
    $categories = get_user_meta( $instructor_id, 'course_category_register', true);

    if( !empty($categories) ):
        foreach ( $categories as $category ):
            $term = get_term_by('id', $category, 'stm_lms_course_taxonomy');
            $terms .= " <span class='badge text-bg-secondary'> $term->name </span> ";
        endforeach;
    else:
        $terms = 'N/A';
    endif;

    ?>

    <table class="table table-borderless">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col"> Bio </th>
            <th> Categories </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td> <?= $user_obj->data->display_name ?> </td>
            <td> <?= $user_obj->data->user_email ?> </td>
            <td> <?= $user_phone ?> </td>
            <td> <?= $user_bio ?> </td>
            <td> <?= $terms ?> </td>
        </tr>
        </tbody>

    </table>

<?php
    wp_die();

}
add_action('wp_ajax_get_instructor_info', 'get_instructor_info');
add_action( 'wp_ajax_nopriv_get_instructor_info', 'get_instructor_info' );



/******
 * Ajax action to get admin tools template
 ******/


function show_admin_tools(){
    get_template_part('template-parts/template-admin-tools');
    wp_die();

}
add_action('wp_ajax_show_admin_tools', 'show_admin_tools');
add_action( 'wp_ajax_nopriv_show_admin_tools', 'show_admin_tools' );



/******
 * Ajax action to get instructor assignments template
 ******/


function get_all_instructor_assignments(){
    get_template_part('template-parts/template-instructor-assignments');
    wp_die();

}
add_action('wp_ajax_get_all_instructor_assignments', 'get_all_instructor_assignments');
add_action( 'wp_ajax_nopriv_get_all_instructor_assignments', 'get_all_instructor_assignments' );


/******
 * Ajax action to get new assignment template
 ******/


function get_new_assignment_template(){
    get_template_part('template-parts/template-new-assignment-section');
    wp_die();

}
add_action('wp_ajax_get_new_assignment_template', 'get_new_assignment_template');
add_action( 'wp_ajax_nopriv_get_new_assignment_template', 'get_new_assignment_template' );


/******
 * Ajax action to delete course video
 ******/


function delete_video(){
    $attach_id = $_POST['attach_id'];
    $course_id = $_POST['course_id'];
    // delete attachment from media
    // $delete_attach = wp_delete_attachment($attach_id, true);

    // unlink video by deleting its post meta
//    if( !empty($delete_attach) ):
        delete_post_meta($course_id, 'course_video_id', $attach_id);
        echo 'success';
//    else:
//        echo 'Error in deleting video, please contact support.';
//    endif;


    wp_die();

}
add_action('wp_ajax_delete_video', 'delete_video');
add_action( 'wp_ajax_nopriv_delete_video', 'delete_video' );



/******
 * Ajax action to edit course data
 ******/


function edit_course_data(){
    $data['edit_course_nonce'] = $_POST['edit_course_nonce'];
    $data['course_id'] = $_POST['course_id'];
    $data['course_title'] = $_POST['course-title'];
    $data['course_duration'] = $_POST['course-duration'];
    $data['course_description'] = $_POST['course-description'];
    //$data['course_video_files'] = $_FILES['course-video-files'];
    $data['attachment_ids'] = $_POST['attachment-ids'];

    $edit_course = MPR_Core::edit_course($data);

    if( $edit_course == 'success' ):
        echo 'success';
    else:
        echo $edit_course;
    endif;


    wp_die();

}
add_action('wp_ajax_edit_course_data', 'edit_course_data');
add_action( 'wp_ajax_nopriv_edit_course_data', 'edit_course_data' );


/******
 * Ajax action to get all notifications template
 ******/


function get_all_notifications(){
    get_template_part('template-parts/template-all-notifications');
    wp_die();

}
add_action('wp_ajax_get_all_notifications', 'get_all_notifications');
add_action( 'wp_ajax_nopriv_get_all_notifications', 'get_all_notifications' );


/******
 * Ajax action to chunk upload
 ******/


function chunk_upload(){
    pre_dump($_FILES);
    pre_dump($_POST);
    wp_die();

}
add_action('wp_ajax_chunk_upload', 'chunk_upload');
add_action( 'wp_ajax_nopriv_chunk_upload', 'chunk_upload' );



/******
 * Ajax action to get edit course template
 ******/


function get_edit_single_course(){
    $course_id = $_POST['course_id'];
    get_template_part('template-parts/template-edit-course', null, array(
        'course_id' => $course_id
    ));
    wp_die();

}
add_action('wp_ajax_get_edit_single_course', 'get_edit_single_course');
add_action( 'wp_ajax_nopriv_get_edit_single_course', 'get_edit_single_course' );


/******
 * Ajax action to get custom template with name
 ******/


function get_template_with_name(){
    $template_name = $_POST['template_name'];
    $term_id = $_POST['term_id'];

    if( $template_name == 'courses' ):
        get_template_part('template-parts/template-courses', null, array(
            'term_id' => $term_id
        ));
        wp_die();
    endif;

    get_template_part('template-parts/'.$template_name);
    wp_die();

}
add_action('wp_ajax_get_template_with_name', 'get_template_with_name');
add_action( 'wp_ajax_nopriv_get_template_with_name', 'get_template_with_name' );


/******
 * Ajax action to mark video as completed
 ******/


function mark_completed(){
    $attachment_id = (int) $_POST['attachment_id'];
    $course_id = $_POST['course_id'];
    // update user meta with list of completed courses
    $mark_meta = get_user_meta(get_current_user_id(), 'mark_status', true);
    if( !empty($mark_meta) ):
        // update old meta
        $old_meta = json_decode($mark_meta);
        if( !in_array($attachment_id,$old_meta) ):
            $old_meta[] = $attachment_id;
        endif;
        $new_meta = json_encode($old_meta);
    else:
        //insert new meta
        $new_meta = json_encode(array($attachment_id));
    endif;
    update_user_meta(get_current_user_id(), 'mark_status', $new_meta);

//    update_post_meta($attachment_id, 'mark_status', 'completed');
    // update course progress
    $progress = MPR_Core::count_completed($course_id);
    MPR_Core::update_user_course_progress( get_current_user_id(), $course_id, $progress );
    wp_send_json_success('success');
    wp_die();
}
add_action('wp_ajax_mark_completed', 'mark_completed');
add_action( 'wp_ajax_nopriv_mark_completed', 'mark_completed' );



/******
 * Ajax action to get attachment data
 ******/


function get_attachment_data(){
    $attachment_id = $_POST['attach_id'];
    $attachment = get_post( $attachment_id );
    $video_title = $attachment->post_title;
    $video_description = $attachment->post_content;
    wp_send_json_success(array(
        'attachment_id' => $attachment_id,
        'title' => $video_title,
        'description' => $video_description
    ));
    wp_die();
}
add_action('wp_ajax_get_attachment_data', 'get_attachment_data');
add_action( 'wp_ajax_nopriv_get_attachment_data', 'get_attachment_data' );


/******
 * Ajax action to update attachment data
 ******/


function update_attachment_data(){
    $attachment_id = $_POST['attachment_id'];
    $edit_video_title = $_POST['edit_video_title'];
    $edit_video_desc = $_POST['edit_video_desc'];

    $data = array(
        'ID' => $attachment_id,
        'post_title' => $edit_video_title,
        'post_content' => $edit_video_desc,
    );

    if( is_int(wp_update_post( $data ))):
        wp_send_json_success('Data updated successfully');
    else:
        wp_send_json_error('Error data not updated successfully, please refresh page and try again.');
    endif;

    wp_die();
}
add_action('wp_ajax_update_attachment_data', 'update_attachment_data');
add_action( 'wp_ajax_nopriv_update_attachment_data', 'update_attachment_data' );