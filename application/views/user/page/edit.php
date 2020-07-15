<!-- DataTales Example -->
<div class="container mt-3">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary"><?= $title_page; ?></h6>
      <a href="<?= base_url('user'); ?>" class="btn-sm btn-secondary">Back</a>
    </div>
    <div class="card-body">
      <?php echo form_open_multipart('user/edit'); ?>
      <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label" id="email">Email</label>
        <div class="col-sm-10">
          <input type="text" value="<?= $user['id']; ?>" name="id" hidden="hidden">
          <input type="text" class="form-control" value="<?= $user['email']; ?>" readonly="" name="email">
        </div>
      </div>
      <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label" id="name">Full Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="name" value="<?= $user['name']; ?>" required="">
          <!-- error -->
          <small class="text-danger pl-3" hidden="" id="p1">The Name field must be at least 4 characters in length.</small>
          <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-2">Picture</div>
        <div class="col-sm-10">
          <div class="row">
            <div class="col-sm-3">
              <img src="<?= base_url('assets/img/profile/' . $user['image']); ?>" alt="<?= $user['name']; ?>" class="img-thumbnail">
            </div>
            <div class="col-9">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="fileInput" accept="image/*" name="image">
                <label class="custom-file-label" for="fileInput">Select Image: .jpg, .png or .jpeg max size 2000 kb</label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary " disabled>Edit</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#fileInput').on('change', function() {
      let fileName = $(this).val().split('\\').pop();
      $(this).next('.custom-file-label').addClass("selected").html(fileName);
      $('.form-group button[type=submit]').removeAttr('disabled', '');
      valName();
    });

    $('input[name=name]').on('keyup', function() {
      valName();
    });

    function valName() {
      if ($('input[name=name]').val().length < 4) {
        $('.form-group button[type=submit]').attr('disabled', '');
        $('#p1').removeAttr('hidden', '');
        $('input[name=name]').attr('class', 'form-control border border-danger');
      } else {
        $('.form-group button[type=submit]').removeAttr('disabled', '');
        $('#p1').attr('hidden', '');
        $('input[name=name]').attr('class', 'form-control border border-success');
      }
    }
  });
</script>