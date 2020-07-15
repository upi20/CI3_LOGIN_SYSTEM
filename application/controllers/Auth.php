<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!empty($this->session->userdata('email')) && $this->session->userdata('role_id') == 1) {
			$this->Flasher_model->flashdata('You login with <a href="' . base_url('administrator') . '">Administrator</a> Or <a href="' . base_url('auth/logout') . '">Logout</a>', 'Warning', 'warning');
		} elseif (!empty($this->session->userdata('email')) && $this->session->userdata('role_id') == 2) {
			$this->Flasher_model->flashdata('You login with <a href="' . base_url('user') . '">User</a> Or <a href="' . base_url('auth/logout') . '">Logout</a>', 'Warning', 'warning');
		}
	}

	public function index()
	{
		$email = $this->input->post('inputEmail');
		$password = $this->input->post('inputPassword');
		$this->form_validation->set_rules('inputEmail', 'Email', 'required|trim|valid_email');
		$this->form_validation->set_rules('inputPassword', 'Password', 'required|trim|min_length[3]');
		if ($this->form_validation->run() == false) {
			$data['title_page'] = 'Login';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/index');
			$this->load->view('templates/auth_footer');
		} else {
			$user = $this->db->get_where('user', ['email' => $email])->row_array();

			// Mengecek email user dari database
			if (is_null($user)) {
				$this->Flasher_model->flashdata('Email not exist', 'Failed', 'danger');
				redirect('auth');
			} else {
				// mengecek apakah usernya aktif atau tidak
				if ($user['is_active'] == 1) {
					if (password_verify($password, $user['password'])) {
						$data = [
							'email' => $user['email'],
							'role_id' => $user['role_id']
						];
						$this->session->set_userdata($data);
						if ($data['role_id'] == 1) {
							redirect('administrator');
						} elseif ($data['role_id'] == 2) {
							redirect('user');
						}
					} else {
						$this->Flasher_model->flashdata('wrong password', 'Failed', 'danger');
						redirect('auth');
					}
				} elseif ($user['is_active'] == 0) {
					$this->Flasher_model->flashdata('User account is not active', 'Failed', 'danger');
					redirect('auth');
				} else {
					$this->Flasher_model->flashdata('User account crashed call develovment', 'Failed', 'danger');
					redirect('auth');
				}
			}
		}
	}

	public function registrasion()
	{
		$this->form_validation->set_rules('inputName', 'Full Name', 'required|trim');
		$this->form_validation->set_rules('inputEmail', 'Email', 'required|trim|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('inputPassword', 'Password', 'required|trim|min_length[3]', [
			'min_length' => 'Password too short!'
		]);
		$this->form_validation->set_rules('repeatPassword', 'Password Confirmation', 'required|trim|matches[inputPassword]', [
			'matches' => 'Password dont match!'
		]);
		if ($this->form_validation->run() == false) {
			$data['title_page'] = 'Registration';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/registrasion');
			$this->load->view('templates/auth_footer');
		} else {
			$email = $this->input->post('inputEmail', true);
			$data = [
				'name' 			=> htmlspecialchars($this->input->post('inputName', true)),
				'email' 		=> htmlspecialchars($email),
				'image' 		=> 'default.png',
				'password' 		=> password_hash($this->input->post('inputPassword', true), PASSWORD_DEFAULT),
				'role_id'		=> 2,
				'is_active'		=> 0,
				'date_create'	=> time()
			];

			// siapkan token
			$token = base64_encode(random_bytes(32));
			$user_token = [
				'email' => $email,
				'token' => $token,
				'date_created' => time()
			];


			$this->_sendEmail($token, 'verify');
			$this->db->insert('user', $data);
			$this->db->insert('user_token', $user_token);
			// send email

			$this->Flasher_model->flashdata('Congratulation! your account has been created. Please active your account', 'Success', 'success');
			redirect('auth');
		}
	}

	public function forgot_password()
	{
		$this->form_validation->set_rules('inputEmail', 'Email', 'trim|required|valid_email');
		if ($this->form_validation->run() == false) {
			$data['title_page'] = 'Forgot Password';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/forgot_password');
			$this->load->view('templates/auth_footer');
		} else {
			$email = $this->input->post('inputEmail');
			$user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();
			if ($user) {
				$token = base64_encode(random_bytes(32));
				$user_token = [
					'email' => $email,
					'token' => $token,
					'date_created' => time()
				];
				$this->_sendEmail($token, 'forgot');
				$this->db->insert('user_token', $user_token);
				$this->Flasher_model->flashdata('Please open your email to reset your password', 'Success', 'success');
				redirect('auth');
			} else {
				$this->Flasher_model->flashdata('Email is not registered or activated', 'Failed', 'danger');
				redirect('auth/forgot_password');
			}
		}
	}

	private function _sendEmail($token, $type)
	{
		$email = $this->input->post('inputEmail');
		$confing = [
			'protocol'  => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_user' => 'iseplutpi.web@gmail.com',
			'smtp_pass' => 'Suksesamin123',
			'smtp_port' => 465,
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'newline'   => "\r\n"

		];

		$this->load->library('email', $confing);
		$this->email->initialize($confing);

		$this->email->from('iseplutpi.web@gmail.com', 'Isep Lutpi Nur');
		$this->email->to($email);

		if ($type == 'verify') {
			$this->email->subject('Account verification');
			$this->email->message('Click this link to verify you account: <a href="' . base_url() . 'auth/verify?email=' . $email . '&token=' . urlencode($token) . '">Active</a>');
		} else if ($type == 'forgot') {
			$this->email->subject('Reset Password');
			$this->email->message('Click this link to reset your password: <a href="' . base_url() . 'auth/resetpassword?email=' . $email . '&token=' . urlencode($token) . '">Reset Password</a>');
		}

		if ($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}

	public function resetpassword()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('user_token', ['email' => $email])->row_array();
		if ($user) {
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
			if ($user_token) {
				if ((time() - $user_token['date_created']) < (60 * 60)) {
					$this->session->set_userdata('reset_email', $email);
					$this->changePassword();
				} else {
					$this->db->delete()('user', ['email' => $email]);
					$this->db->delete()('user_token', ['email' => $email]);
					$this->Flasher_model->flashdata('Reset password failed! token expired', 'Failed', 'danger');
					redirect('auth');
				}
			} else {
				$this->Flasher_model->flashdata('Reset password failed! wrong token', 'Failed', 'danger');
				redirect('auth');
			}
		} else {
			$this->Flasher_model->flashdata('Reset password failed! wrong email', 'Failed', 'danger');
			redirect('auth');
		}
	}

	public function verify()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('user_token', ['email' => $email])->row_array();
		if ($user) {
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
			if ($user_token) {
				if ((time() - $user_token['date_created']) < (60 * 60)) {
					$this->db->set('is_active', 1);
					$this->db->where('email', $email);
					$this->db->update('user');

					$this->db->delete('user_token', ['email' => $email]);
					$this->Flasher_model->flashdata($email . ' has been activated!. Please login', 'Success', 'success');
					redirect('auth');
				} else {
					$this->db->delete()('user', ['email' => $email]);
					$this->db->delete()('user_token', ['email' => $email]);
					$this->Flasher_model->flashdata('Account activation failed! token expired', 'Failed', 'danger');
					redirect('auth');
				}
			} else {
				$this->Flasher_model->flashdata('Account activation failed! wrong token', 'Failed', 'danger');
				redirect('auth');
			}
		} else {
			$this->Flasher_model->flashdata('Account activation failed! wrong email', 'Failed', 'danger');
			redirect('auth');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');
		$this->Flasher_model->flashdata('You have been logout', 'Success', 'success');
		redirect('auth');
	}

	public function blocked()
	{
		$this->load->view('user/page/notfound');
	}

	public function changePassword()
	{
		if (!$this->session->userdata('reset_email')) {
			redirect('auth');
		}
		$this->form_validation->set_rules('password1', 'New Password', 'trim|required');
		$this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|matches[password1]');
		if ($this->form_validation->run() == false) {
			$data['title_page'] = 'Change Password';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/change_password');
			$this->load->view('templates/auth_footer');
		} else {
			$password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
			$email = $this->session->userdata('reset_email');
			$this->db->set('password', $password);
			$this->db->where('email', $email);
			$this->db->update('user');
			$this->session->unset_userdata('reset_email');
			$this->db->delete('user_token', ['email' => $email]);
			$this->Flasher_model->flashdata('Password has been changed!. Please login', 'Success', 'success');
			redirect('auth');
		}
	}
}
