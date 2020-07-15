<!-- DataTales Example -->
<div class="container mt-3">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?= $title_page; ?></h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    <img src="<?= base_url('assets/img/profile/' . $user['image']); ?>" alt="<?= $user['name']; ?>" class="img-thumbnail">
                </div>
                <div class="col-sm-9 p-2">
                    <h5 class="card-title"><?= $user['name']; ?></h5>
                    <p class="card-text"><?= $user['email']; ?></p>
                    <p class="card-text">Member since <?= date('D, d M Y', $user['date_create']); ?></p>
                    <a href="<?= base_url('user/edit'); ?>" class="btn btn-primary">Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>