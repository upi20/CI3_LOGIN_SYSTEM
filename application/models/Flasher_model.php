<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Flasher_model extends CI_Model{
	public function flashdata($caption, $title, $color){
		$this->session->set_flashdata('captionFlash', $caption);
		$this->session->set_flashdata('titleFlash', $title);
		$this->session->set_flashdata('colorFlash',$color);	
	}
}
