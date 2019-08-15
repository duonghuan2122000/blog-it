<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(['slug_helper', 'form']);
		$this->load->library('form_validation');
	}
	public function index()
	{
		$tags = $this->db->select('name,slug')->from('tag')->order_by('created_at', 'desc')->get()->result();

		$data = [
			'temp' => 'tag/index',
			'title' => 'Danh sách thể loại',
			'tags' => $tags,
			'success' => $this->session->flashdata('success'),
			'js_tag' => true
		];
		$this->load->view('admin/layout', $data);
	}

	public function create()
	{
		if($this->input->method() == 'post'){
			$this->form_validation->set_rules('name', 'Tên thể loại', 'required|min_length[3]|is_unique[tag.name]');
			if(!$this->form_validation->run()){
				$data = [
					'temp' => 'tag/create',
					'title' => 'Thêm mới thể loại'
				];
				return $this->load->view('admin/layout', $data);
			} else {
				$data = [
					'name' => trim($this->input->post('name')),
					'slug' => to_slug(trim($this->input->post('name'))),
					'created_at' => time()
				];
				$this->db->insert('tag', $data);
				$this->session->set_flashdata('success', 'Thêm thể loại mới thành công.');
				return redirect(base_url('admin/the-loai'));
			}
		} else {
			$data = [
				'temp' => 'tag/create',
				'title' => 'Thêm mới thể loại'
			];
			return $this->load->view('admin/layout', $data);
		}
	}

	public function edit($slug)
	{
		$this->db->select('id,name');
		$this->db->from('tag');
		$this->db->where('slug', $slug);
		$tag = $this->db->get()->row();
		if(empty($tag)){
			return show_404();
		}

		if($this->input->method() == 'post'){
			$this->form_validation->set_rules('name', 'Tên thể loại', 'required|min_length[3]|callback_check_name['.$tag->id.']');
			if(!$this->form_validation->run()){
				$data = [
					'temp' => 'tag/edit',
					'title' => 'Chỉnh sửa thể loại '.$tag->name,
					'tag' => $tag
				];
				return $this->load->view('admin/layout', $data);
			} else {
				$data = [
					'name' => trim($this->input->post('name')),
					'slug' => to_slug(trim($this->input->post('name')))
				];
				$this->db->where('id', $tag->id);
				$this->db->where('tag', $data);
				$this->session->set_flashdata('success', 'Chỉnh sửa thể loại mới thành công.');
				return redirect(base_url('admin/the-loai'));
			}
		} else {
			$data = [
				'temp' => 'tag/edit',
				'title' => 'Chỉnh sửa thể loại '.$tag->name,
				'tag' => $tag
			];
			return $this->load->view('admin/layout', $data);
		}
	}

	public function del($slug)
	{
		$this->db->select('id');
		$this->db->from('tag');
		$this->db->where('slug', $slug);
		$tag = $this->db->get()->row();
		if(empty($tag)){
			return show_404();
		}
		$this->db->where('tag_id', $tag->id)->delete('story_tag');
		$this->db->delete('tag', ['id' => $tag->id]);
		$this->session->set_flashdata('success', 'Xóa thể loại thành công.');
		return redirect(base_url('admin/the-loai'));
	}

	public function check_name($name, $id)
	{
		$this->db->select('name');
		$this->db->from('tag');
		$this->db->where('id !=', $id);
		$this->db->where('name', $this->input->post('name'));
		$tag = $this->db->get()->row();
		if(!empty($tag)){
			$this->form_validation->set_message('check_name', '{field} đã tồn tại');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function getjson()
	{
		$this->db->select('name');
		$this->db->from('tag');
		$tags = $this->db->get()->result();
		$tagsjson = [];
		foreach ($tags as $t) {
			array_push($tagsjson, $t->name);
		}
		print_r(json_encode($tagsjson));
	}
}
