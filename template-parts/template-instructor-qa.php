<div class="row new-course-section">
    <div class="col-md-12">
        <?php get_template_part('template-parts/template-dashboard-head', null, array(
            'icon' => 'qa'
        )); ?>

        <div class="courses-bottom mid-gray d-flex flex-column">

            <section class="qa-list all_qa mt-3">

                <?php
                    $all_qa = MPR_Core::get_instructor_qa();
                    if( !empty($all_qa) ):

                        foreach ( $all_qa as $qa_item ):
                            $learner_obj = get_user_by('id', $qa_item->sender_id);
                            $posted_on = date('l, d F, Y', strtotime( $qa_item->created_at ));
                ?>

                        <div class="row single-qa qa-<?= $qa_item->id ?>">
                            <div class="col-md-6 d-flex justify-content-start align-content-center flex-wrap gap-3">
                                <img src="<?= get_stylesheet_directory_uri() ?>/assets/img/user-pic.png" alt="">
                                <div class="learner-name">
                                    <h3> <?= $learner_obj->data->display_name; ?> </h3>
                                    <p> Forex Student </p>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end align-content-center flex-column gap-3">
                                <p class="text-right opacity-75"> Posted on <?= $posted_on ?>  </p>
                            </div>
                            <div class="col-md-12 qa-details mt-4">
                                <h3> <?= $qa_item->title ?>  </h3>
                                <p class="mt-3"> <?= $qa_item->description ?> </p>

                                <div class="respond-form">
                                    <form action="" method="post" class="respond-qa-form d-flex flex-column" id="respond-qa-form-<?= $qa_item->id ?>">
                                        <input type="hidden" name="qa-id" value="<?= $qa_item->id ?>">
                                        <textarea class="mb-3 qa-respond-description" name="qa-respond-description" rows="5" placeholder="Start writing your response..."></textarea>

                                        <input type="hidden" name="add_respond_qa_nonce" value="<?= wp_create_nonce( 'add_respond_qa_nonce' ) ?>">

                                        <div class="col-md-12 qa-respond-action-btns d-flex justify-content-between align-content-center flex-wrap mt-5">
                                            <a href="" class="submit-respond-qa submit-btn d-flex justify-content-center align-content-center" data-qa-id="<?= $qa_item->id ?>"> Post Response <i class="fa-solid fa-arrow-right"></i> </a>
                                            <a href="" class="respond-and-resolve-qa" data-qa-id="<?= $qa_item->id ?>"> Post Response and Mark This Question Resolved <i class="fa-solid fa-check"></i> </a>
                                        </div>

                                    </form>
                                </div>


                            </div>

                            <div class="col-md-12 qa-action-btns mt-5">
                                <a href="" class="respond-qa" data-qa-id="<?= $qa_item->id ?>"> Respond  <i class="fa-regular fa-message"></i> </a>
                                <?php if( $qa_item->status == 'resolved' ): ?>
                                    <a href="#" class="resolved-qa"> Resolved <i class="fa-solid fa-check"></i> </a>
                                <?php else: ?>
                                    <a href="" class="resolve-qa" data-qa-id="<?= $qa_item->id ?>"> Mark Resolved <i class="fa-solid fa-check"></i> </a>
                                <?php endif; ?>
                            </div>


                            <div class="qa_responds_data">

                                <!-- get qa replies if found-->
                                <?php
                                    $qa_responds = MPR_Core::get_qa_responds($qa_item->id);
                                    if( !empty($qa_responds) ): ?>

                                        <p class="decorated mt-5 mb-5"><span> <?= count($qa_responds) ?> Responses </span></p>

                                        <div class="qa-replies instructor">

                                            <?php foreach( $qa_responds as $qa_respond ):
                                                    $user_obj = get_user_by('id', $qa_respond->receiver_id);
                                                    $posted_on = date('l, d F, Y', strtotime( $qa_item->created_at ));
                                                ?>

                                                <div class="single-reply row">
                                                    <div class="col-md-6 d-flex justify-content-start align-content-center flex-wrap gap-3">
                                                        <img src="<?= get_stylesheet_directory_uri() ?>/assets/img/user-pic.png" alt="">
                                                        <div class="learner-name">
                                                            <h3> <?= $user_obj->data->display_name ?> </h3>
                                                            <p> Forex Instructor </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 d-flex justify-content-end align-content-center flex-column gap-3">
                                                        <p class="text-right opacity-75"> Posted on <?= $posted_on ?> </p>
                                                    </div>

                                                    <div class="col-md-12 qa-details mt-4">
                                                        <p class="mt-3"> <?= $qa_respond->description ?> </p>
                                                    </div>

                                            </div>

                                            <?php endforeach; ?>

                                        </div>

                                    <?php endif; ?>

                            </div>

                        </div>

                <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center"> No Data Availaible </p>
                <?php endif; ?>
            </section>


        </div>

    </div>
</div>


<style>
    .qa-action-btns{
        display: flex;
        justify-content: space-between;
        align-content: center;
        flex-flow: wrap;
    }


    .qa-respond-description {
        margin-top: 3rem !important;
        background: #f6f8fa;
        border-radius: 30px;
        padding: 2rem !important;
        min-height: 260px;
        border: 1px solid var(--pink);
    }

    .qa-respond-description:focus {
        background: #f6f8fa;
    }


    .respond-form{
        display: none;
        transition: all 0.5s ease-in-out;
    }

    .col-md-12.qa-action-btns {
        margin: 2rem 0 0 0;
    }

    a.respond-qa, .submit-respond-qa {
        background: var(--pink);
        color: #fff;
        padding: 0.5rem;
        width: 35%;
        text-align: center;
        border-radius: 50px;
        font-weight: bold;
        position: relative;
    }

    a.resolve-qa {
        color: #8E9FA9;
        padding: 0.5rem;
        border: 1px solid #8E9FA9;
        width: 25%;
        text-align: center;
        border-radius: 50px;
        position: relative;
        transition: all 0.3s ease-in-out;
    }

    a.resolve-qa i {
        position: absolute;
        right: 2rem;
        top: 50%;
        transform: translateY(-50%);
    }

    a.respond-qa i, .submit-respond-qa i {
        position: absolute;
        color: #fff;
        right: 2rem;
        top: 50%;
        transform: translateY(-50%);
    }

    a.resolve-qa:hover {
        background: var(--mint-green);
        color: #fff;
        border-color: var(--mint-green);
    }

    a.resolve-qa:hover i{
        color: #fff;
    }

    .all_qa .single-qa {
        border: 1px solid #ddd !important;
    }


    .new-qa-form input.qa-title {
        background: #fff;
        border-radius: 150px;
        padding: 1.5rem !important;
        border: 1px solid var(--pink);
    }


    .new-qa-form .qa-description,
    .reply-qa-form .qa-reply-description{
        background: #fff;
        border-radius: 20px;
        padding: 1.5rem !important;
        min-height: 260px;
        border: 1px solid var(--pink);
    }



    .new-qa-form input.qa-title{
        width: 100%;
    }



    a#submit-new-qa i,
    a#submit-new-qa-reply i {
        position: absolute;
        right: 2rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.5rem;
    }

    a#submit-new-qa,
    a#submit-new-qa-reply {
        position: relative;
        margin: 3rem 2rem;
        background: var(--pink);
        width: 35%;
        padding: 0.5rem;
    }

    section.qa-list {
        display: flex;
        flex-flow: column;
        gap: 2rem;
    }

    .row.single-qa {
        background: #fff;
        border: 1px solid var(--pink);
        border-radius: 30px;
        padding: 2rem 3rem;
    }

    .row.single-qa img {
        width: 60px;
        height: 60px;
        object-fit: cover;
    }


    .learner-name * {
        font-size: 1rem;
        line-height: unset;
        margin: 0;
    }

    .learner-name {
        display: flex;
        flex-flow: column;
        justify-content: center;
        align-items: initial;
    }

    .learner-name h3 {
        color: var(--mid-gray);
    }

    .row.single-qa * {
        margin: 0;
    }

    .edit-qa:hover,
    .close-qa:hover{
        color: inherit !important;
    }

    .decorated > span:after {
        width: 0;
    }

    .decorated > span:before {
        left: 100%;
        right: unset;
        border-bottom: 1px solid #ddd;
    }

    .decorated {
        overflow: hidden;
        text-align: left;
        color: var(--pink) !important;
    }

    .single-reply.row:after {
        border: 1px solid var(--pink);
        width: 50px;
        height: 130px;
        position: absolute;
        border-top: 0;
        border-right: 0;
        border-bottom-left-radius: 30px;
        left: 7rem;
    }

    .single-reply.row:before {
        border-left: 1px solid var(--pink);
        width: 40px;
        height: 20rem;
        position: absolute;
        left: 7rem;
    }

    .single-reply {
        margin-left: 4rem !important;
        margin-bottom: 1rem !important;
        margin-top: 1rem !important;
    }

    .single-reply.row:last-child:before {
        height: 0 !important;
    }

    .qa-reply-description {
        min-height: 135px !important;
        background: #f6f8fa !important;
        margin-bottom: 0 !important;
    }

    a#submit-new-qa-reply {
        margin: 2rem 0;
    }


    .other-students-qa .single-qa {
        border-color: #E8EDF0;
    }

    section.qa-list.other-students-qa.mt-3 h3 {
        color: inherit;
    }

    .other-students-qa .decorated > span:before {
        left: 100%;
        right: unset;
        border-bottom: 1px solid #ddd;
    }

    a.resolved-qa {
        background: var(--mint-green);
        border-radius: 30px;
        padding: 0.5rem 4rem;
        color: #fff;
        font-weight: 600;
        letter-spacing: 1px;
        text-align: center;
        position: relative;
    }

    a.resolved-qa i {
        position: absolute;
        color: #fff;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
    }

    .other-students-qa .single-reply:before, .other-students-qa .single-reply:after {
        display: none;
    }

    .other-students-qa .single-reply {
        margin-left: 0 !important;
        border-bottom: 1px solid #ddd;
        padding-bottom: 2rem;
    }

    .other-students-qa .single-reply:last-child {
        border: 0;
    }

    a.respond-and-resolve-qa {
        background: var(--mint-green);
        margin: 0;
        padding: 0.5rem;
        color: #fff;
        width: 60%;
        text-align: center;
        border-radius: 50px;
        font-weight: bold;
        position: relative;
    }

    a.respond-and-resolve-qa i {
        position: absolute;
        right: 2rem;
        color: #fff;
        top: 50%;
        transform: translateY(-50%);
    }

    .instructor .single-reply:after, .instructor .single-reply:before {
        display: none;
    }

    .instructor .single-reply {
        margin: 1rem 0 !important;
        border-bottom: 1px solid #ddd;
        padding: 1rem 0;
    }

    .instructor .single-reply:last-child {
        border: 0 !important;
    }




</style>


<script>

    jQuery(document).on("click",".respond-qa", function(e) {
        e.preventDefault();

        let qa_id = $(this).data('qa-id');
        $(this).parent().hide();
        $('.respond-qa').not(this).parent().show();
        $('.all_qa .respond-form').hide();
        $('.qa-' + qa_id).find('.respond-form').show();

    });


    // on submit respond
    jQuery(document).on("click",".submit-respond-qa", function(e) {
        e.preventDefault();
        $('.ajax-loader').fadeIn();

        let qa_id = $(this).data('qa-id');

        if( $('.qa-' + qa_id).find('.qa-respond-description').val() == '' ){
            $('.ajax-loader').fadeOut();
            showError('please fill all fields');
            return;
        }

        let form_id = 'respond-qa-form-' + qa_id;

        var formData = new FormData(document.getElementById(form_id));

        formData.append("action", "respond_to_qa");

        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function(response) {
                $('.ajax-loader').fadeOut();
                if( response.success == true ){
                    showSuccess('Respond Sent Successfully');
                    // refresh responds to section
                    $('.qa-' + qa_id).find('.qa_responds_data').html('<span class="text-center loading-section"> loading... </span>');
                    // refresh qa results
                    let content = response.data;
                    setTimeout(function(){
                        $('.qa-' + qa_id).find('.qa_responds_data').html(content);
                    }, 3000);

                    //location.reload()
                } else {
                    showError(response.data);
                }
            }
        });

    });


</script>