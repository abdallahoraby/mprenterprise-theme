<div class="row new-course-section">
    <div class="col-md-12">
        <?php get_template_part('template-parts/template-dashboard-head', null, array(
            'icon' => 'qa'
        )); ?>

        <div class="courses-bottom mid-gray d-flex flex-column">

            <p class="text-center mt-5 mb-3"> You can post a question and have your instructors answer them </p>


            <form action="" method="post" class="new-qa-form d-flex flex-column" id="new-qa-form">

                <input type="text" class="qa-title mb-3 p-3" name="qa-title" placeholder="Type your question title">

                <textarea class="mb-3 qa-description" name="qa-description" rows="5" placeholder="Start writing your question..."></textarea>

                <input type="hidden" name="add_new_qa_nonce" value="<?= wp_create_nonce( 'add_new_qa_nonce' ) ?>" id="add_new_qa_nonce">
                <a href="#" id="submit-new-qa" class="submit-btn d-flex justify-content-center align-content-center"> Post Question <i class="fa-solid fa-arrow-right"></i> </a>


            </form>

            <p class="text-center mt-5 mb-3"> Your Previous Questions </p>

            <section class="qa-list learner_qa mt-3">


                <?php

                    $learner_qa = MPR_Core::get_learner_qa();
                    if( !empty($learner_qa) ):
                        $learner_obj = get_user_by('id', get_current_user_id());

                        foreach ( $learner_qa as $qa_item ):
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
                                <span class="text-right d-flex justify-content-end gap-3">
                                    <a href="#" class="edit-qa pink"> Edit Question </a>
                                    <a href="#" data-qa-id="<?= $qa_item->id ?>" class="close-qa orange"> Close Question </a>
                                </span>
                            </div>
                            <div class="col-md-12 qa-details mt-4">
                                <h3> <?= $qa_item->title ?>  </h3>
                                <p class="mt-3"> <?= $qa_item->description ?> </p>
                            </div>

                            <!-- get qa replies if found-->
                            <?php
                            $qa_responds = MPR_Core::get_qa_responds($qa_item->id);
                            if( !empty($qa_responds) ): ?>

                                <p class="decorated mt-5 mb-5"><span class="pink"> <?= count($qa_responds) ?> Responses </span></p>

                                <div class="qa-replies">

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

                                <form action="" method="post" class="reply-qa-form d-flex flex-column mt-5" id="reply-qa-form-<?= $qa_item->id ?>">

                                    <textarea class="mb-3 qa-reply-description" name="qa-reply-description" rows="5" placeholder="Start typing your reply..."></textarea>

                                    <input type="hidden" name="add_new_reply_qa_nonce" value="<?= wp_create_nonce( 'add_new_reply_qa_nonce' ) ?>">
                                    <a href="#" id="submit-new-qa-reply" class="submit-btn d-flex justify-content-center align-content-center"> Reply <i class="fa-solid fa-arrow-right"></i> </a>


                                </form>

                            <?php endif; ?>

                        </div>

                    <?php
                        endforeach;
                    endif;
                ?>

<!--                <div class="row single-qa">-->
<!---->
<!--                    <div class="col-md-6 d-flex justify-content-start align-content-center flex-wrap gap-3">-->
<!--                        <img src="--><?//= get_stylesheet_directory_uri() ?><!--/assets/img/user-pic.png" alt="">-->
<!--                        <div class="learner-name">-->
<!--                            <h3> John Doe </h3>-->
<!--                            <p> Forex Student </p>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                    <div class="col-md-6 d-flex justify-content-end align-content-center flex-column gap-3">-->
<!--                        <p class="text-right opacity-75"> Posted on Wednesday, 23 February, 2022 </p>-->
<!--                        <span class="text-right d-flex justify-content-end gap-3">-->
<!--                            <a href="#" class="edit-qa pink"> Edit Question </a>-->
<!--                            <a href="#" class="close-qa orange"> Close Question </a>-->
<!--                        </span>-->
<!--                    </div>-->
<!---->
<!--                    <div class="col-md-12 qa-details mt-4">-->
<!--                        <h3> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto aut consequatur, debitis deleniti  </h3>-->
<!--                        <p class="mt-3"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.-->
<!--                            Ut pharetra sit amet aliquam id diam maecenas ultricies. Tellus cras adipiscing enim eu turpis egestas pretium. Velit sed ullamcorper-->
<!--                            morbi tincidunt ornare. Morbi tristique senectus et netus et malesuada. Dictum sit amet justo donec enim. Pretium aenean pharetra magna ac.-->
<!--                            Et magnis dis parturient montes. Sit amet consectetur adipiscing elit pellentesque habitant morbi. Tempor id eu nisl nunc. Quisque egestas-->
<!--                            Auctor augue mauris augue neque gravida in fermentum. </p>-->
<!--                    </div>-->
<!---->
<!--                </div>-->


<!--                <div class="row single-qa">-->
<!---->
<!--                    <div class="col-md-6 d-flex justify-content-start align-content-center flex-wrap gap-3">-->
<!--                        <img src="--><?//= get_stylesheet_directory_uri() ?><!--/assets/img/user-pic.png" alt="">-->
<!--                        <div class="learner-name">-->
<!--                            <h3> John Doe </h3>-->
<!--                            <p> Forex Student </p>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                    <div class="col-md-6 d-flex justify-content-end align-content-center flex-column gap-3">-->
<!--                        <p class="text-right opacity-75"> Posted on Wednesday, 23 February, 2022 </p>-->
<!--                        <span class="text-right d-flex justify-content-end gap-3">-->
<!--                            <a href="#" class="edit-qa pink"> Edit Question </a>-->
<!--                            <a href="#" class="close-qa orange"> Close Question </a>-->
<!--                        </span>-->
<!--                    </div>-->
<!---->
<!--                    <div class="col-md-12 qa-details mt-4">-->
<!--                        <h3> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto aut consequatur, debitis deleniti  </h3>-->
<!--                        <p class="mt-3"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.-->
<!--                            Ut pharetra sit amet aliquam id diam maecenas ultricies. Tellus cras adipiscing enim eu turpis egestas pretium. Velit sed ullamcorper-->
<!--                            morbi tincidunt ornare. Morbi tristique senectus et netus et malesuada. Dictum sit amet justo donec enim. Pretium aenean pharetra magna ac.-->
<!--                            Et magnis dis parturient montes. Sit amet consectetur adipiscing elit pellentesque habitant morbi. Tempor id eu nisl nunc. Quisque egestas-->
<!--                            Auctor augue mauris augue neque gravida in fermentum.-->
<!--                        </p>-->
<!--                    </div>-->
<!---->
<!--                    <p class="decorated mt-3 mb-3"><span class="pink"> 2 Responses </span></p>-->
<!---->
<!--                    <div class="qa-replies">-->
<!---->
<!--                        <div class="single-reply row">-->
<!--                            <div class="col-md-6 d-flex justify-content-start align-content-center flex-wrap gap-3">-->
<!--                                <img src="--><?//= get_stylesheet_directory_uri() ?><!--/assets/img/user-pic.png" alt="">-->
<!--                                <div class="learner-name">-->
<!--                                    <h3> John Doe </h3>-->
<!--                                    <p> Forex Instructor </p>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="col-md-6 d-flex justify-content-end align-content-center flex-column gap-3">-->
<!--                                <p class="text-right opacity-75"> Posted on Wednesday, 23 February, 2022 </p>-->
<!--                            </div>-->
<!---->
<!--                            <div class="col-md-12 qa-details mt-4">-->
<!--                                <p class="mt-3"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.-->
<!--                                    Ut pharetra sit amet aliquam id diam maecenas ultricies. Tellus cras adipiscing enim eu turpis egestas pretium. Velit sed ullamcorper-->
<!--                                    morbi tincidunt ornare. Morbi tristique senectus et netus et malesuada. Dictum sit amet justo donec enim. Pretium aenean pharetra magna ac.-->
<!--                                    Et magnis dis parturient montes. Sit amet consectetur adipiscing elit pellentesque habitant morbi. Tempor id eu nisl nunc. Quisque egestas-->
<!--                                    Auctor augue mauris augue neque gravida in fermentum.-->
<!--                                </p>-->
<!--                            </div>-->
<!---->
<!--                        </div>-->
<!---->
<!--                        <div class="single-reply row">-->
<!--                            <div class="col-md-6 d-flex justify-content-start align-content-center flex-wrap gap-3">-->
<!--                                <img src="--><?//= get_stylesheet_directory_uri() ?><!--/assets/img/user-pic.png" alt="">-->
<!--                                <div class="learner-name">-->
<!--                                    <h3> John Doe </h3>-->
<!--                                    <p> Forex Instructor </p>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="col-md-6 d-flex justify-content-end align-content-center flex-column gap-3">-->
<!--                                <p class="text-right opacity-75"> Posted on Wednesday, 23 February, 2022 </p>-->
<!--                            </div>-->
<!---->
<!--                            <div class="col-md-12 qa-details mt-4">-->
<!--                                <p class="mt-3"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.-->
<!--                                    Ut pharetra sit amet aliquam id diam maecenas ultricies. Tellus cras adipiscing enim eu turpis egestas pretium. Velit sed ullamcorper-->
<!--                                    morbi tincidunt ornare. Morbi tristique senectus et netus et malesuada. Dictum sit amet justo donec enim. Pretium aenean pharetra magna ac.-->
<!--                                    Et magnis dis parturient montes. Sit amet consectetur adipiscing elit pellentesque habitant morbi. Tempor id eu nisl nunc. Quisque egestas-->
<!--                                    Auctor augue mauris augue neque gravida in fermentum.-->
<!--                                </p>-->
<!--                            </div>-->
<!---->
<!--                        </div>-->
<!---->
<!--                        <div class="single-reply row">-->
<!--                            <div class="col-md-6 d-flex justify-content-start align-content-center flex-wrap gap-3">-->
<!--                                <img src="--><?//= get_stylesheet_directory_uri() ?><!--/assets/img/user-pic.png" alt="">-->
<!--                                <div class="learner-name">-->
<!--                                    <h3> John Doe </h3>-->
<!--                                    <p> Forex Instructor </p>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="col-md-6 d-flex justify-content-end align-content-center flex-column gap-3">-->
<!--                                <p class="text-right opacity-75"> Posted on Wednesday, 23 February, 2022 </p>-->
<!--                            </div>-->
<!---->
<!--                            <div class="col-md-12 qa-details mt-4">-->
<!--                                <p class="mt-3"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.-->
<!--                                    Ut pharetra sit amet aliquam id diam maecenas ultricies. Tellus cras adipiscing enim eu turpis egestas pretium. Velit sed ullamcorper-->
<!--                                    morbi tincidunt ornare. Morbi tristique senectus et netus et malesuada. Dictum sit amet justo donec enim. Pretium aenean pharetra magna ac.-->
<!--                                    Et magnis dis parturient montes. Sit amet consectetur adipiscing elit pellentesque habitant morbi. Tempor id eu nisl nunc. Quisque egestas-->
<!--                                    Auctor augue mauris augue neque gravida in fermentum.-->
<!--                                </p>-->
<!--                            </div>-->
<!---->
<!--                        </div>-->
<!---->
<!--                        <div class="single-reply row">-->
<!--                            <div class="col-md-6 d-flex justify-content-start align-content-center flex-wrap gap-3">-->
<!--                                <img src="--><?//= get_stylesheet_directory_uri() ?><!--/assets/img/user-pic.png" alt="">-->
<!--                                <div class="learner-name">-->
<!--                                    <h3> John Doe </h3>-->
<!--                                    <p> Forex Instructor </p>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="col-md-6 d-flex justify-content-end align-content-center flex-column gap-3">-->
<!--                                <p class="text-right opacity-75"> Posted on Wednesday, 23 February, 2022 </p>-->
<!--                            </div>-->
<!---->
<!--                            <div class="col-md-12 qa-details mt-4">-->
<!--                                <p class="mt-3"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.-->
<!--                                    Ut pharetra sit amet aliquam id diam maecenas ultricies. Tellus cras adipiscing enim eu turpis egestas pretium. Velit sed ullamcorper-->
<!--                                    morbi tincidunt ornare. Morbi tristique senectus et netus et malesuada. Dictum sit amet justo donec enim. Pretium aenean pharetra magna ac.-->
<!--                                    Et magnis dis parturient montes. Sit amet consectetur adipiscing elit pellentesque habitant morbi. Tempor id eu nisl nunc. Quisque egestas-->
<!--                                    Auctor augue mauris augue neque gravida in fermentum.-->
<!--                                </p>-->
<!--                            </div>-->
<!---->
<!--                        </div>-->
<!---->
<!--                        <div class="single-reply row">-->
<!--                            <div class="col-md-6 d-flex justify-content-start align-content-center flex-wrap gap-3">-->
<!--                                <img src="--><?//= get_stylesheet_directory_uri() ?><!--/assets/img/user-pic.png" alt="">-->
<!--                                <div class="learner-name">-->
<!--                                    <h3> John Doe </h3>-->
<!--                                    <p> Forex Instructor </p>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="col-md-6 d-flex justify-content-end align-content-center flex-column gap-3">-->
<!--                                <p class="text-right opacity-75"> Posted on Wednesday, 23 February, 2022 </p>-->
<!--                            </div>-->
<!---->
<!--                            <div class="col-md-12 qa-details mt-4">-->
<!--                                <p class="mt-3"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.-->
<!--                                    Ut pharetra sit amet aliquam id diam maecenas ultricies. Tellus cras adipiscing enim eu turpis egestas pretium. Velit sed ullamcorper-->
<!--                                    morbi tincidunt ornare. Morbi tristique senectus et netus et malesuada. Dictum sit amet justo donec enim. Pretium aenean pharetra magna ac.-->
<!--                                    Et magnis dis parturient montes. Sit amet consectetur adipiscing elit pellentesque habitant morbi. Tempor id eu nisl nunc. Quisque egestas-->
<!--                                    Auctor augue mauris augue neque gravida in fermentum.-->
<!--                                </p>-->
<!--                            </div>-->
<!---->
<!--                        </div>-->
<!---->
<!--                    </div>-->
<!---->
<!--                    <form action="" method="post" class="reply-qa-form d-flex flex-column mt-5" id="reply-qa-form">-->
<!---->
<!--                        <textarea class="mb-3 qa-reply-description" name="qa-reply-description" rows="5" placeholder="Start typing your reply..."></textarea>-->
<!---->
<!--                        <input type="hidden" name="add_new_reply_qa_nonce" value="--><?//= wp_create_nonce( 'add_new_reply_qa_nonce' ) ?><!--" id="add_new_reply_qa_nonce">-->
<!--                        <a href="#" id="submit-new-qa-reply" class="submit-btn d-flex justify-content-center align-content-center"> Reply <i class="fa-solid fa-arrow-right"></i> </a>-->
<!---->
<!---->
<!--                    </form>-->
<!---->
<!---->
<!--                </div>-->





            </section>


            <!--   Other Students Replies Section start -->

            <p class="text-center mt-5 mb-3"> Other students also asked... </p>

            <section class="qa-list other-students-qa mt-3">

                <div class="row single-qa">

                    <div class="col-md-6 d-flex justify-content-start align-content-center flex-wrap gap-3">
                        <img src="<?= get_stylesheet_directory_uri() ?>/assets/img/user-pic.png" alt="">
                        <div class="learner-name">
                            <h3> John Doe </h3>
                            <p> Forex Student </p>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex justify-content-end align-content-center flex-column gap-3">
                        <p class="text-right opacity-75"> Posted on Wednesday, 23 February, 2022 </p>
                    </div>

                    <div class="col-md-12 qa-details mt-4">
                        <h3> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto aut consequatur, debitis deleniti  </h3>
                        <p class="mt-3"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            Ut pharetra sit amet aliquam id diam maecenas ultricies. Tellus cras adipiscing enim eu turpis egestas pretium. Velit sed ullamcorper
                            morbi tincidunt ornare. Morbi tristique senectus et netus et malesuada. Dictum sit amet justo donec enim. Pretium aenean pharetra magna ac.
                            Et magnis dis parturient montes. Sit amet consectetur adipiscing elit pellentesque habitant morbi. Tempor id eu nisl nunc. Quisque egestas
                            Auctor augue mauris augue neque gravida in fermentum. </p>
                    </div>

                </div>


                <div class="row single-qa">

                    <div class="col-md-6 d-flex justify-content-start align-content-center flex-wrap gap-3">
                        <img src="<?= get_stylesheet_directory_uri() ?>/assets/img/user-pic.png" alt="">
                        <div class="learner-name">
                            <h3> John Doe </h3>
                            <p> Forex Student </p>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex justify-content-end align-content-center flex-column gap-3">
                        <p class="text-right opacity-75"> Posted on Wednesday, 23 February, 2022 </p>
                        <span class="text-right d-flex justify-content-end gap-3">
                            <a href="#" class="resolved-qa"> Resolved <i class="fa-solid fa-check"></i> </a>
                        </span>
                    </div>

                    <div class="col-md-12 qa-details mt-4">
                        <h3> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto aut consequatur, debitis deleniti  </h3>
                        <p class="mt-3"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            Ut pharetra sit amet aliquam id diam maecenas ultricies. Tellus cras adipiscing enim eu turpis egestas pretium. Velit sed ullamcorper
                            morbi tincidunt ornare. Morbi tristique senectus et netus et malesuada. Dictum sit amet justo donec enim. Pretium aenean pharetra magna ac.
                            Et magnis dis parturient montes. Sit amet consectetur adipiscing elit pellentesque habitant morbi. Tempor id eu nisl nunc. Quisque egestas
                            Auctor augue mauris augue neque gravida in fermentum.
                        </p>
                    </div>

                    <p class="decorated mt-3 mb-3"><span> 2 Responses </span></p>

                    <div class="qa-replies">

                        <div class="single-reply row">
                            <div class="col-md-6 d-flex justify-content-start align-content-center flex-wrap gap-3">
                                <img src="<?= get_stylesheet_directory_uri() ?>/assets/img/user-pic.png" alt="">
                                <div class="learner-name">
                                    <h3> John Doe </h3>
                                    <p> Forex Instructor </p>
                                </div>
                            </div>

                            <div class="col-md-6 d-flex justify-content-end align-content-center flex-column gap-3">
                                <p class="text-right opacity-75"> Posted on Wednesday, 23 February, 2022 </p>
                            </div>

                            <div class="col-md-12 qa-details mt-4">
                                <p class="mt-3"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    Ut pharetra sit amet aliquam id diam maecenas ultricies. Tellus cras adipiscing enim eu turpis egestas pretium. Velit sed ullamcorper
                                    morbi tincidunt ornare. Morbi tristique senectus et netus et malesuada. Dictum sit amet justo donec enim. Pretium aenean pharetra magna ac.
                                    Et magnis dis parturient montes. Sit amet consectetur adipiscing elit pellentesque habitant morbi. Tempor id eu nisl nunc. Quisque egestas
                                    Auctor augue mauris augue neque gravida in fermentum.
                                </p>
                            </div>

                        </div>


                        <div class="single-reply row">
                            <div class="col-md-6 d-flex justify-content-start align-content-center flex-wrap gap-3">
                                <img src="<?= get_stylesheet_directory_uri() ?>/assets/img/user-pic.png" alt="">
                                <div class="learner-name">
                                    <h3> John Doe </h3>
                                    <p> Forex Instructor </p>
                                </div>
                            </div>

                            <div class="col-md-6 d-flex justify-content-end align-content-center flex-column gap-3">
                                <p class="text-right opacity-75"> Posted on Wednesday, 23 February, 2022 </p>
                            </div>

                            <div class="col-md-12 qa-details mt-4">
                                <p class="mt-3"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    Ut pharetra sit amet aliquam id diam maecenas ultricies. Tellus cras adipiscing enim eu turpis egestas pretium. Velit sed ullamcorper
                                    morbi tincidunt ornare. Morbi tristique senectus et netus et malesuada. Dictum sit amet justo donec enim. Pretium aenean pharetra magna ac.
                                    Et magnis dis parturient montes. Sit amet consectetur adipiscing elit pellentesque habitant morbi. Tempor id eu nisl nunc. Quisque egestas
                                    Auctor augue mauris augue neque gravida in fermentum.
                                </p>
                            </div>

                        </div>


                    </div>


                </div>





            </section>

        </div>

    </div>
</div>


<style>

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
        color: var(--pink);
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
        border-bottom: 1px solid var(--pink);
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





</style>


<script>

    jQuery(document).on("click","#submit-new-qa", function(e) {
        e.preventDefault();
        $('.ajax-loader').fadeIn();

        if( $('#new-qa-form .qa-title').val() == '' || $('#new-qa-form .qa-description').val() == '' ){
            $('.ajax-loader').fadeOut();
            showError('please fill all fields');
            return;
        }

        var formData = new FormData(document.getElementById('new-qa-form'));

        formData.append("action", "create_new_qa");

        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function(response) {
                $('.ajax-loader').fadeOut();
                $('#new-qa-form .qa-title').val('');
                $('#new-qa-form .qa-description').val('');
                if( response.success == true ){
                    showSuccess('Q & A Added Successfully');
                    $('.qa-list.learner_qa').html('<span class="text-center loading-section"> loading... </span>');
                    // refresh qa results
                    let content = response.data;
                    setTimeout(function(){
                        $('.qa-list.learner_qa').html(content);
                    }, 3000);


                } else {
                    showError(response.data);
                }
            }
        });

    });


    // click close question
    jQuery("body").delegate(".close-qa", "click", function(e){
        e.preventDefault();
        $('.ajax-loader').fadeIn();
        let id = $(this).data('qa-id');
        // load template courses
        jQuery.post(ajaxurl, {
            action: 'delete_record',
            id: id
        }, function (response){ // response callback function
            $('.ajax-loader').fadeOut();
            if( response == 'success' ){
                showSuccess('Question deleted successfully');
                $('.qa-' + id).remove();
            } else {
                showError(response);
            }

        })
            .done(function(response) {
                //alert( "second success" );
            });

    });

</script>