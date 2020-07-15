<!-- DataTales Example -->
<div class="container mt-3">
	<div class="card shadow mb-4">
		<div class="card-header py-3 d-flex justify-content-between">
		  	<h6 class="m-0 font-weight-bold text-primary"><?= $title_page; ?></h6>
		  	<a href="#" class="btn-sm btn-primary" data-toggle="modal" data-target="#formModal" id="addNewSubMenu" data-url="<?= base_url(); ?>">Add New Sub Menu</a>
		</div>
		<div class="card-body">
			<div class="table-responsive">
			    <table class="table table-bordered table-striped table-hover" id="postsList" width="100%" cellspacing="0">
			      <thead>
			        <tr>
						<th>No</th>
						<th>Title</th>
						<th>Menu</th>
						<th>Url</th>
						<th>Icon</th>
						<th>Active</th>
						<th>Action</th>
			        </tr>
			      </thead>
			      <tbody>

			      	<?php 
			      	$number = 0;
			      	foreach($subMenu as $sm): ?>
			      	<tr>
			      		<td><?= ++$number; ?></td>
			      		<td><?= $sm['title']; ?></td>
			      		<td><?= $sm['menu']; ?></td>
			      		<td><?= $sm['url']; ?></td>
			      		<td><?= $sm['icon']; ?></td>
			      		<td>
							<?php if($sm['is_active'] == 1): ?>
			      				Active
			      			<?php elseif($sm['is_active'] == 0): ?>
								Nonactive
			      			<?php else: ?>
								Error
			      			<?php endif ?>
			      		</td>
			      		<td style="min-width: 125px;">
			      			<a href="#" class="btn-sm btn-warning p-2 tampilModalUbah" data-id="<?= $sm['id']; ?>" data-url="<?= base_url(); ?>" data-toggle="modal" data-target="#formModal">Edit</a>		
							<a href="#" class="btn-sm btn-danger p-2 tampilModalAlert" data-id="<?= $sm['id']; ?>" data-url="<?= base_url(); ?>" data-toggle="modal" data-target="#alertModal">Delete</a>
			      		</td>
			      	</tr>
				    <?php endforeach; ?>
			      </tbody>
			    </table>
			</div>
		</div>
	</div>
</div>

<!-- form Modal -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="formModalLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="formModalAction" action="" method="post">
					<div class="form-group">
						<input type="text" name="id" hidden="hidden">
						<input type="text" name="title" id="titleSubMenu" class="form-control" required="" placeholder="Sub Menu Name">
					</div>
					<div class="form-group">
						<select name="menu" id="menuSubMenu" class="form-control">
							<option value="">Select Menu</option>
							<?php foreach($menu as $m): ?>
							<option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group">
						<input type="text" name="url" id="urlSubMenu" class="form-control" required="" placeholder="Sub Menu Url">
					</div>
					<div class="form-group">
						<input type="text" name="icon" id="iconSubMenu" class="form-control" required="" placeholder="Sub Menu Icon">
					</div>
					<div class="form-group">
						<div class="form-check">
	                        <input type="checkbox" class="form-check-input" id="is_activeSubMenu" name="is_active" value="1" checked="">
	                        <label class="form-check-label" for="is_activeSubMenu">Active?</label>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal" required="">Close</button>
				<button hidden="hidden" type="submit" class="btn btn-primary" id="formModalBtn"></button>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Alert Modal -->
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="alertModalLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			<p id="paragrafBodyModal"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<a href="" id="anchorAlertModal"></a>
			</div>
		</div>
	</div>
</div>

<script>
	// Scrip hidden and unhidden button
	$(document).ready(function(){
		$('#is_activeSubMenu').on('click', function(){
			if ($('#titleSubMenu').val().length == 0 || $('#urlSubMenu').val().length == 0 || $('#iconSubMenu').val().length == 0 || $('#menuSubMenu').val().length == 0) {
				$('.modal-footer button[type=submit]').attr('hidden', 'hidden');
			}else{
				$('.modal-footer button[type=submit]').removeAttr('hidden', 'hidden');
			}
		});
		$('#formModalAction input').on('keyup',function(){
			if ($('#titleSubMenu').val().length == 0 || $('#urlSubMenu').val().length == 0 || $('#iconSubMenu').val().length == 0 || $('#menuSubMenu').val().length == 0) {
				$('.modal-footer button[type=submit]').attr('hidden', 'hidden');
			}else{
				$('.modal-footer button[type=submit]').removeAttr('hidden', 'hidden');
			}
		});
		$('#formModalAction select').on('click',function(){
			if ($('#titleSubMenu').val().length == 0 || $('#urlSubMenu').val().length == 0 || $('#iconSubMenu').val().length == 0 || $('#menuSubMenu').val().length == 0) {
				$('.modal-footer button[type=submit]').attr('hidden', 'hidden');
			}else{
				$('.modal-footer button[type=submit]').removeAttr('hidden', 'hidden');
			}
		});

		// menampilkan alert konfirmasi hapus data
		$('.tampilModalAlert').on('click', function(){
			const id = $(this).data('id');
			const url = $(this).data('url');
			$('#anchorAlertModal').attr('href', url + 'menu/submenudelete/' + id);
			$('#alertModalLabel').html('Delete Sub Menu');
			$('#anchorAlertModal').attr('class', 'btn btn-danger');
			$('#anchorAlertModal').html('Delete');
			$('#paragrafBodyModal').html('Are You Sure..?');
		});

		// modal tambah data
		$('#addNewSubMenu').on('click', function(){
			const url = $(this).data('url') + 'menu/submenu';
			$('.modal-footer button[type=submit]').attr('hidden', 'hidden');
			$('#formModalAction').attr('action', url);
			$('#is_activeSubMenu').attr('checked', '');
			$('#formModalLabel').html('Add New Sub Menu');
			$('#formModalBtn').html('Add');
			$('input[name=id]').val('');
			$('input[name=url]').val('');
			$('input[name=title]').val('');
			$('input[name=icon]').val('');
			$('input[name=menu]').val('');
			$('option').removeAttr('selected','');
		});

		// modal edit data
		$('.tampilModalUbah').on('click', function(){
			$('.modal-footer button[type=submit]').attr('hidden', 'hidden');
			$('#formModalLabel').html('Edit Menu');
			$('#formModalBtn').html('Edit');
			const id = $(this).data('id');
			const url = $(this).data('url');
			$('#formModalAction').attr('action', url + 'menu/subMenuEdit');
			$.ajax({
				url: url + 'menu/subMenuDetail',
				data: {id: id},
				method: 'post',
				dataType: 'json',
				success: function(data){
					$('input[name=id]').val(data.id);
					$('input[name=url]').val(data.url);
					$('input[name=title]').val(data.title);
					$('input[name=icon]').val(data.icon);
					$('option[value='+ data.menu_id +']').attr('selected','');
					if (data.is_active == 1) {
						$('#is_activeSubMenu').attr('checked', '');
						console.log('active');
					}else{
						$('#is_activeSubMenu').removeAttr('checked', '');
						console.log('nonactive');
					}
				}
			});
		});
	});
</script>
