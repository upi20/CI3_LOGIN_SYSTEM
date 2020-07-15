<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		is_logged_in();
	}

	public function index()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title_page'] = "My Profile";
		$this->load->view('templates/sitemain/header', $data);
		$this->load->view('templates/sitemain/sidebar', $data);
		$this->load->view('templates/sitemain/topbar', $data);
		$this->load->view('user/page/profile', $data);
		$this->load->view('templates/sitemain/footer');
	}

	public function changepassword()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title_page'] = "Change password";

		$this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|trim');
		$this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|matches[new_password]');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/sitemain/header', $data);
			$this->load->view('templates/sitemain/sidebar', $data);
			$this->load->view('templates/sitemain/topbar', $data);
			$this->load->view('user/page/changepassword', $data);
			$this->load->view('templates/sitemain/footer');
		} else {
			$current_password = $this->input->post('current_password');
			$new_password = $this->input->post('new_password2');
			if (!password_verify($current_password, $data['user']['password'])) {
				$this->Flasher_model->flashdata('Wrong Current Password', 'Failed', 'danger');
				redirect('user/changepassword');
			} else {
				if ($current_password == $new_password) {
					$this->Flasher_model->flashdata('New password cannot be the same as current password', 'Failed', 'danger');
					redirect('user/changepassword');
				} else {
					$password = password_hash($new_password, PASSWORD_DEFAULT);
					$this->db->set('password', $password);
					$this->db->where('email', $this->session->userdata('email'));
					$this->db->update('user');
					$this->Flasher_model->flashdata('Password changed', 'Success', 'success');
					redirect('user');
				}
			}
		}
	}

	public function edit()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title_page'] = "Edit Profile";
		$this->form_validation->set_rules('name', 'Full Name', 'required|trim');
		if ($this->form_validation->run() == false) {
			$this->load->view('templates/sitemain/header', $data);
			$this->load->view('templates/sitemain/sidebar', $data);
			$this->load->view('templates/sitemain/topbar', $data);
			$this->load->view('user/page/edit', $data);
			$this->load->view('templates/sitemain/footer');
		} else {
			$id = $this->input->post('id');
			$name = $this->input->post('name');

			$file_upload = $_FILES['image'];
			if ($file_upload['name'] != '') {
				$config['upload_path'] = './assets/img/profile/';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['max_size'] = '2000';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('image')) {
					$old_image = $data['user']['image'];
					if ($old_image != 'default.png') {
						unlink(FCPATH . 'assets/img/profile/' . $old_image);
					}
					$new_image = $this->upload->data('file_name');
					$this->db->set('image', $new_image);
				} else {
					$this->Flasher_model->flashdata($this->upload->display_errors(), 'Failed', 'danger');
					redirect('user/edit');
				}
			}
			$this->db->set('name', $name);
			$this->db->where('id', $id);
			$this->db->update('user');
			$this->Flasher_model->flashdata('Your profile has been updated', 'Success', 'success');
			redirect('user');
		}
	}
	public function percobaan()
	{
		$data['title_page'] = 'Login';
		$this->load->view('templates/auth_header', $data);
		$this->load->view('percobaan/index');
		$this->load->view('templates/auth_footer');
	}
}
