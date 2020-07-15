<?php
function is_logged_in()
{
	$ci = get_instance();
	if (empty($ci->session->userdata('email'))) {
		$ci->Flasher_model->flashdata('You not login', 'Warning', 'danger');
		redirect('auth');
	} else {
		$role_id = $ci->session->userdata('role_id');
		$menu = $ci->uri->segment(1);

		// cek hak akses
		$queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
		$menu_id = $queryMenu['id'];

		// // cek sub menu aktive atau tidak
		// $subMenu = $menu; 
		// if (!is_null($ci->uri->segment(2))) {
		// 	$subMenu .= '/' . $ci->uri->segment(2);
		// }

		// $result = $ci->db->get_where('user_sub_menu', ['url' => $subMenu])->row_array();
		// if (is_null($result['is_active'])) {
		// 	$result['is_active'] = 1;
		// }

		$queryAcces = $ci->db->get_where('user_access_menu', [
			'role_id' => $role_id,
			'menu_id' => $menu_id
		]);
		if ($queryAcces->num_rows() < 1) {
			redirect('auth/blocked');
		} 
		// elseif ($result['is_active'] == 0) {
		// 	redirect('auth/blocked');
		// }
	}
}

function check_acces($role_id, $menu_id)
{
	$ci = get_instance();
	$role = $ci->db->get_where(
		'user_access_menu',
		[
			'role_id' => $role_id,
			'menu_id' => $menu_id
		]
	)->num_rows();
	if ($role > 0) {
		return "checked='checked'";
	}
}


// function is_logged_in($menu_id = -1)
// {
// 	$ci = get_instance();
// 	if (empty($ci->session->userdata('email')) || empty($ci->session->userdata('role_id'))) {
// 		$ci->Flasher_model->flashdata('You not login','Warning','danger');
// 		redirect('auth');
// 	}else{
// 		$role = $ci->db->get_where('user_access_menu', 
// 		[
// 			'role_id' => $ci->session->userdata('role_id'),
// 			'menu_id' => $menu_id
// 		])->num_rows();

// 		if ($role < 1) {
// 			redirect('auth/blocked');
// 		}
// 	}
// }
