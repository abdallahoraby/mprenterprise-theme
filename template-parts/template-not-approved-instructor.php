<div class="row">

    <div class="col-md-12 text-center p-5 mt-5 mb-5 d-flex justify-content-center align-content-center gap-3 flex-column">

        <i class="fa-solid fa-triangle-exclamation"></i>

        <strong class="text-center"> <?php _e('Your account is not approved yet. Please contact administrator', 'masterstudy-child'); ?> </strong>

        <a href="<?= site_url() ?>" class="btn btn-success"> Back to Home </a>

    </div>

</div>


<style>

    i{
        color: var(--orange);
        font-size: 3rem;
    }

    a.btn.btn-success {
        width: fit-content;
        margin: 1rem auto;
    }
</style>