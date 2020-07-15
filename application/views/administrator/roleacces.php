<!-- DataTales Example -->
<div class="container mt-3">
	<div class="card shadow mb-4">
		<div class="card-header py-3 d-flex justify-content-between">
		  	<h6 class="m-0 font-weight-bold text-primary">Role: <?= $role['role']; ?></h6>
		  	<a href="<?= base_url('administrator/role'); ?>" class="btn-sm btn-secondary">&larr; Back</a>
		</div>
		<div class="card-body">
			<div class="table-responsive">
			    <table class="table table-bordered table-striped table-hover" id="postsList" width="100%" cellspacing="0">
			      <thead>
			        <tr>
						<th style="max-width: 5%;">No</th>
						<th style="width: 85%; min-width: 200px;">Menu</th>
						<th style="width: 10%; min-width: 70px;">Access</th>
			        </tr>
			      </thead>
			      <tbody>
			      	<?php 
			      	$number = 0;
			      	foreach($menu as $m): ?>
			      	<tr>
			      		<td><?= ++$number; ?></td>
			      		<td><?= $m['menu']; ?></td>
			      		<td>
			      			<div class="form-check">
			      				<input type="checkbox" class="form-check-input" <?= check_acces($role['id'], $m['id']); ?> data-role="<?= $role['id']; ?>" data-menu="<?= $m['id']; ?>" data-url="<?= base_url(); ?>">
			      			</div>
			      		</td>
			      	</tr>
				    <?php endforeach; ?>
			      </tbody>
			    </table>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('.form-check-input').on('click', function(){
			const menuId = $(this).data('menu');
			const roleId = $(this).data('role');
			const url = $(this).data('url');
			$.ajax({
				url: url + 'administrator/changeaccess',
				type: 'post',
				data: {
					menuId: menuId,
					roleId: roleId
				},
				success: function(){
					document.location.href = url + 'administrator/roleacces/' + roleId;
				}
			});
		});
	});
</script>
