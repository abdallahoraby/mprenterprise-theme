<?php

// shortcode for courses grid
function user_courses(){
    get_template_part('template-parts/template-courses');
}
add_shortcode('user_courses', 'user_courses');




function test(){


    get_template_part('template-parts/template-courses', null, array(
        'term_id' => 82
    ));



}
add_shortcode('test', 'test');



