<div class="row new-assignment-section">
    <div class="col-md-12">
        <?php get_template_part('template-parts/template-dashboard-head', null, array(
            'icon' => 'assignment'
        )); ?>

        <div class="row tabs-section">
            <a href="#" class="col-md-6 new-assignment tab active"> New Assignment </a>
            <a href="#" class="col-md-6 all-assignments tab"> All Assignments </a>
        </div>

        <div class="courses-bottom mid-gray d-flex flex-column">

            <?php get_template_part('template-parts/template-new-assignment-section'); ?>

        </div>

    </div>
</div>



<style>
    .new-assignment-form input.assignment-title{
        background: #fff;
        border-radius: 150px;
        padding: 1.5rem !important;
    }

    .new-assignment-form .assignment-description{
        background: #fff;
        border-radius: 20px;
        padding: 1rem;
    }

    .new-assignment-form span.select2-selection.select2-selection--single,
    .course-select{
        border-radius: 150px;
    }

    .new-assignment-form span.select2.select2-container.select2-container--default,
    .course-select{
        width: 100% !important;
        margin-bottom: 1rem;
    }


    .new-assignment-form input.assignment-title{
        width: 100%;
    }

    h3.upload-video-title {
        margin: 3rem 0 0 0;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 3rem;
        background: var(--mid-gray);
        color: #fff;
        padding: 1rem;
        border-radius: 50px;
        font-size: 1.1rem;
    }

    h3.upload-video-title i {
        color: #fff;
    }

    input#assignment-file {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        background: #fff;
        padding: 1rem;
        border-radius: 50px;
    }



    a#submit-new-assignment i {
        position: absolute;
        right: 2rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.5rem;
    }

    a#submit-new-assignment {
        position: relative;
        margin: 5rem 0 1rem 0;
    }


    .row.tabs-section {
        height: 5rem;
        background: var(--mid-gray);
        border-top-left-radius: 30px;
        border-top-right-radius: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        width: inherit;
        margin: 0 auto;
        margin-top: -10rem;
    }

    .tab.active {
        background: #f6f8fa;
        color: var(--mid-gray) !important;
        font-weight: bold;
        height: 100%;
        border: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: inherit;
    }

    .courses-bottom {
        margin-top: 0;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    .tab{
        color: #fff;
        font-family: var(--heading-font);
    }



</style>


<script>




    // on click list all assignment for instructor
    jQuery(".all-assignments").on("click", function(e){
        e.preventDefault();
        $('.ajax-loader').show();
        // load template
        $(this).addClass('active');
        $('.tab').not(this).removeClass('active');
        jQuery.post(ajaxurl, {
            action: 'get_all_instructor_assignments',
        }, function (response){ // response callback function
            $('.ajax-loader').hide();
            jQuery('.courses-bottom').html(response);
        })
            .done(function(response) {
                //alert( "second success" );
            });

    });


    // on click new assignment link
    jQuery(".new-assignment").on("click", function(e){
        e.preventDefault();
        $('.ajax-loader').show();
        // load template
        $(this).addClass('active');
        $('.tab').not(this).removeClass('active');
        jQuery.post(ajaxurl, {
            action: 'get_new_assignment_template',
        }, function (response){ // response callback function
            $('.ajax-loader').hide();
            jQuery('.courses-bottom').html(response);
        })
            .done(function(response) {
                //alert( "second success" );
            });

    });



</script>