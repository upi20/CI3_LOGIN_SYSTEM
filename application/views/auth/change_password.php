<div class="container">
  <!-- Outer Row -->
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body md">
          <div class="container-fluid">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-3"><?= $title_page; ?></h1>
              <hr>
              <h1 class="h6 text-gray-900 mb-3">Change your password for <a href="mailto:<?= $this->session->userdata('reset_email'); ?>"><?= $this->session->userdata('reset_email'); ?></a></h1>

            </div>
            <?php if ($this->session->flashdata('titleFlash')) : ?>
              <div class="alert alert-<?= $this->session->flashdata('colorFlash'); ?> alert-dismissible fade show m-3" role="alert">
                <strong><?= $this->session->flashdata('titleFlash'); ?>!</strong> <?= $this->session->flashdata('captionFlash'); ?>.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <?php endif ?>
            <div class="p-3">
              <form class="user" action="<?= base_url('auth/changepassword'); ?>" method="post">
                <div class="form-group">
                  <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Enter New Password..." required>
                  <?= form_error('password1', '<div class="small text-danger ml-3">', '</div>'); ?>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Repeat New Password..." required>
                  <?= form_error('password2', '<div class="small text-danger ml-3">', '</div>'); ?>
                </div>
                <button type="submit" id="btnLogin" name="btnLogin" class="btn btn-primary btn-user btn-block"><?= $title_page; ?></button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>