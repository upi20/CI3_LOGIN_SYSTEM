<div class="container">
  <!-- Outer Row -->
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body md">
          <div class="container-fluid">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-3"><?= $title_page; ?></h1>
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
              <form class="user" action="<?= base_url('auth/forgot_password'); ?>" method="post">
                <div class="form-group">
                  <input type="email" class="form-control form-control-user" id="inputEmail" name="inputEmail" placeholder="Enter Email Address..." value="<?= set_value('inputEmail'); ?>" required>
                  <?= form_error('inputEmail', '<div class="small text-danger ml-3">', '</div>'); ?>
                </div>
                <button type="submit" id="btnLogin" name="btnLogin" class="btn btn-primary btn-user btn-block">Resset Password</button>
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="<?= base_url('auth/'); ?>">Back to login</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>