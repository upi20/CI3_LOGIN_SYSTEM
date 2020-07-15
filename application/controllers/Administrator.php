<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Administrator extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
	}

	public function index()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title_page'] = "Dashboard";
		$this->load->view('templates/sitemain/header', $data);
		$this->load->view('templates/sitemain/sidebar', $data);
		$this->load->view('templates/sitemain/topbar', $data);
		$this->load->view('administrator/index', $data);
		$this->load->view('templates/sitemain/footer');
	}

	public function role()
	{
		if (!is_null($this->input->post('name'))) {
			$menu = $this->input->post('name');

			// cek apakah role sudah ada atau belum
			$check = $this->db->get_where('user_role', ['role' => $menu])->num_rows();
			if ($check < 1) {
				$this->db->insert('user_role', ['role' => $menu]);
				$this->Flasher_model->flashdata('New role added', 'Success ', 'success');
			} else {
				$this->Flasher_model->flashdata('Role already exist', 'Failed ', 'danger');
			}
		}
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title_page'] = "Role";
		$data['role'] = $this->db->get('user_role')->result_array();
		$this->load->view('templates/sitemain/header', $data);
		$this->load->view('templates/sitemain/sidebar', $data);
		$this->load->view('templates/sitemain/topbar', $data);
		$this->load->view('administrator/role', $data);
		$this->load->view('templates/sitemain/footer');
	}

	public function roleacces($id = -1)
	{
		if ($this->db->get_where('user_role', ['id' => $id])->num_rows() < 1) {
			$this->Flasher_model->flashdata('Role not exist', 'Failed', 'danger');
			redirect('administrator/role');
		}
		$data['title_page'] = "Role";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['role'] = $this->db->get_where('user_role', ['id' => $id])->row_array();

		$this->db->where('id !=', 1);
		$data['menu'] = $this->db->get('user_menu')->result_array();

		$this->load->view('templates/sitemain/header', $data);
		$this->load->view('templates/sitemain/sidebar', $data);
		$this->load->view('templates/sitemain/topbar', $data);
		$this->load->view('administrator/roleacces', $data);
		$this->load->view('templates/sitemain/footer');
	}

	public function roleedit()
	{
		$id = htmlspecialchars($this->input->post('id'));
		// cek apakah ada data yang dikirimkan atau tidak
		if (is_null($this->input->post('id'))) {
			redirect('administrator/role');
		}
		if ($id == 1 || $id == 2) {
			$this->Flasher_model->flashdata('Role not be edited', 'Failed', 'danger');
			redirect('administrator/role');
		}
		$name = htmlspecialchars($this->input->post('name'));
		$menu = $this->db->get_where('user_role', ['role' => $name])->row_array();
		// di cek apakah nama sudah digunakan atau belum
		if (is_null($menu)) {
			$this->db->set('role', $name);
			$this->db->where('id', $id);
			$this->db->update('user_role');
			$this->Flasher_model->flashdata('Role Renamed', 'Succes', 'success');
			redirect('administrator/role');
		} else {
			$this->Flasher_model->flashdata('Role already exist', 'Failed', 'danger');
			redirect('administrator/role');
		}
	}

	public function roledelete($id = -1)
	{
		if ($id == 1 || $id == 2) {
			$this->Flasher_model->flashdata('Role not be deleted', 'Failed', 'danger');
			redirect('administrator/role');
		}
		if ($this->db->get_where('user_role', ['id' => $id])->num_rows() < 1) {
			$this->Flasher_model->flashdata('Role not exist', 'Failed', 'danger');
			redirect('administrator/role');
		}
		$this->db->delete('user_role', ['id' => $id]);
		$this->Flasher_model->flashdata('Role deleted', 'Success ', 'warning');
		redirect('administrator/role');
	}

	public function changeaccess()
	{
		$data = [
			'role_id' => $this->input->post('roleId'),
			'menu_id' => $this->input->post('menuId')
		];

		$result = $this->db->get_where('user_access_menu', $data)->num_rows();
		if ($result < 1) {
			$this->Flasher_model->flashdata('Access Change', 'Success ', 'success');
			$this->db->insert('user_access_menu', $data);
		} else {
			$this->db->delete('user_access_menu', $data);
			$this->Flasher_model->flashdata('Access Change', 'Success ', 'success');
		}
	}

	public function detail()
	{
		echo json_encode($this->db->get_where('user_role', ['id' => $this->input->post('id')])->row_array());
	}
}
