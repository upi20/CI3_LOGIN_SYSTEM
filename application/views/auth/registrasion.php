<?php
// if (isset($_POST['btnRegister'])) {
//     var_dump($_POST);
// }
?>
<div class="container">
  <!-- Outer Row -->
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body md">
          <div class="container-fluid p-1">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
            </div>
            <form class="user" action="" method="post">
              <div class="form-group">
                <input minlength="4" type="text" class="form-control form-control-user" id="inputName" name="inputName" placeholder="Full Name" value="<?= set_value('inputName'); ?>">
                <?= form_error('inputName', '<div class="small text-danger ml-3">', '</div>'); ?>
              </div>
              <div class="form-group">
                <input type="email" class="form-control form-control-user" id="inputEmail" name="inputEmail" placeholder="Email Address" value="<?= set_value('inputEmail'); ?>">
                <?= form_error('inputEmail', '<div class="small text-danger ml-3">', '</div>'); ?>
              </div>
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <input minlength="4" type="password" class="form-control form-control-user" id="inputPassword" name="inputPassword" placeholder="Password" value="<?= set_value('inputPassword'); ?>">
                  <?= form_error('inputPassword', '<div class="small text-danger ml-3">', '</div>'); ?>
                </div>
                <div class="col-sm-6">
                  <input minlength="4" type="password" class="form-control form-control-user" id="repeatPassword" name="repeatPassword" placeholder="Password Confirmation" value="<?= set_value('repeatPassword'); ?>">
                  <?= form_error('repeatPassword', '<div class="small text-danger ml-3">', '</div>'); ?>
                </div>
              </div>
              <div class="form-group">
                <div class="custom-control custom-checkbox small">
                  <input type="checkbox" class="custom-control-input" id="showPassword">
                  <label class="custom-control-label" for="showPassword">Show Password</label>
                </div>
              </div>
              <button type="submit" name="btnRegister" id="btnRegister" class="btn btn-primary btn-user btn-block">Register Account</button>
            </form>
            <hr>
            <div class="text-center">
              <a class="small" href="<?= base_url('auth/forgot_password'); ?>">Forgot Password?</a>
            </div>
            <div class="text-center">
              <a class="small" href="<?= base_url('auth'); ?>">Already have an account? Login!</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    no = 1;
    $('#showPassword').on('click', function() {
      if (no % 2 == 0) {
        // console.log('off');
        $('#inputPassword').attr('type', 'password');
        $('#repeatPassword').attr('type', 'password');
      } else {
        // console.log('on');
        $('#inputPassword').attr('type', 'text');
        $('#repeatPassword').attr('type', 'text');
      }
      no++;
      buttonDisabled();
    });

    $('#inputPassword').on('keyup', function() {
      buttonDisabled();
    });

    $('#repeatPassword').on('keyup', function() {
      buttonDisabled();
    });


    function buttonDisabled() {
      if ($('#inputPassword').val().length < 4 || $('#repeatPassword').val().length < 4 || $('#repeatPassword').val() != $('#inputPassword').val()) {
        $('button[type=submit]').attr('disabled', '');
      } else {
        $('button[type=submit]').removeAttr('disabled', '');
      }
    }
  });
</script>