<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Story extends MY_Controller {

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
		$stories = $this->db->select('name,slug')->from('story')->order_by('created_at', 'desc')->get()->result();
		$data = [
			'temp' => 'story/index',
			'title' => 'Danh sách truyện',
			'stories' => $stories,
			'success' => $this->session->flashdata('success'),
			'script_story' => true
		];
		return $this->load->view('admin/layout', $data);
	}

	public function create()
	{
		if($this->input->method() == 'post'){
			$this->form_validation->set_rules('name', 'Tên truyện', 'required|min_length[10]|is_unique[story.name]');
			if(!$this->form_validation->run()){
				$data = [
					'temp' => 'story/create',
					'title' => 'Thêm mới truyện',
					'script_story' => true
				];
				return $this->load->view('admin/layout', $data);
			} else {
				$data = [
					'name' => trim($this->input->post('name')),
					'slug' => to_slug(trim($this->input->post('name'))),
					'created_at' => time(),
					'updated_at' => time()
				];
				if(!empty($this->input->post('author'))){
					$data['author'] = trim($this->input->post('author'));
					$data['author_slug'] = to_slug(trim($this->input->post('author')));
				}
				if(!empty($this->input->post('description'))){
					$data['description'] = $this->input->post('description');
				}
				$config['upload_path']          = './assets/img/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 1024;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;
                $config['file_name']            = to_slug($this->input->post('name'));

                $this->load->library('upload', $config);
                if($this->upload->do_upload('img')){
                	$data['img'] = $this->upload->data('file_name');
                }
                $this->db->insert('story', $data);
                $story_id = $this->db->insert_id();
                if(!empty($this->input->post('tags'))){
                	$tags = explode(',', $this->input->post('tags'));
                	$tagsObj = $this->db->select('id')->from('tag')->where_in('name', $tags)->get()->result();
                	$story_tag = [];
                	foreach ($tagsObj as $t) {
                		$story_tag[] = [
                			'story_id' => $story_id,
                			'tag_id' => (int) $t->id
                		];
                	}
                	$this->db->insert_batch('story_tag', $story_tag);
                }
                $this->session->set_flashdata('success', 'Thêm mới truyện thành công.');
                return redirect(base_url('admin/truyen'));
			}
		} else {
			$data = [
				'temp' => 'story/create',
				'title' => 'Thêm mới truyện',
				'script_story' => true
			];
			return $this->load->view('admin/layout', $data);
		}
	}

	public function edit($slug)
	{
		$story = $this->db->select('id,name,author,description,img')->from('story')->where('slug', $slug)->get()->row();
		if(empty($story)){
			return show_404();
		}
		$tags = $this->db->query("SELECT id,name FROM tag WHERE id IN (SELECT tag_id FROM story_tag WHERE story_id = ?)", [$story->id])->result_array();
		$string_tags = '';
		foreach ($tags as $t) {
			$string_tags .= $t['name'].',';
		}
		$string_tags = trim($string_tags, ',');
		$string_tags = trim($string_tags);

		if($this->input->method() == 'post'){
			$this->form_validation->set_rules('name', 'Tên truyện', 'required|min_length[10]|callback_check_name['.$story->id.']');
			if(!$this->form_validation->run()){
				$data = [
					'temp' => 'story/edit',
					'title' => 'Chỉnh sửa truyện '.$story->name,
					'script_story' => true,
					'tags' => $string_tags,
					'story' => $story
				];
				return $this->load->view('admin/layout', $data);
			} else {
				$data = [
					'name' => trim($this->input->post('name')),
					'slug' => to_slug(trim($this->input->post('name')))
				];

				if(!empty($this->input->post('author')) && $this->input->post('author') !== $story->author){
					$data['author'] = trim($this->input->post('author'));
					$data['author_slug'] = to_slug(trim($this->input->post('author')));
				}

				if(!empty($this->input->post('description')) && $this->input->post('description') !== $story->description){
					$data['description'] = $this->input->post('description');
				}
				$config['upload_path']          = './assets/img/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 1024;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;
                $config['file_name']            = to_slug($this->input->post('name'));

                $this->load->library('upload', $config);
                if($this->upload->do_upload('img')){
                	$data['img'] = $this->upload->data('file_name');
                }
                $this->db->where('id', $story->id);
                $this->db->update('story', $data);
                if(!empty($this->input->post('tags')) && $this->input->post('tags') !== $string_tags){
                	if(!empty($tags)){
                		$tagsArr = [];
	                	foreach ($tags as $t) {
	                		array_push($tagsArr, $t['id']);
	                	}
	                	$this->db->where_in('tag_id',$tagsArr);
	                	$this->db->delete('story_tag');
                	}
                	$tags = explode(',', $this->input->post('tags'));
                	$tagsObj = $this->db->select('id')->from('tag')->where_in('name', $tags)->get()->result();
                	$story_tag = [];
                	foreach ($tagsObj as $t) {
                		$story_tag[] = [
                			'story_id' => $story->id,
                			'tag_id' => (int) $t->id
                		];
                	}
                	$this->db->insert_batch('story_tag', $story_tag);
                }
                $this->session->set_flashdata('success', 'Chỉnh sửa thông tin truyện thành công.');
                return redirect(base_url('admin/truyen'));
			}
		} else {
			$data = [
				'temp' => 'story/edit',
				'title' => 'Chỉnh sửa truyện '.$story->name,
				'script_story' => true,
				'tags' => $string_tags,
				'story' => $story
			];
			return $this->load->view('admin/layout', $data);
		}

	}

	public function del($slug)
	{
		$story = $this->db->select('id')->from('story')->where('slug', $slug)->get()->row();
		if(empty($story)){
			return show_404();
		}
		$this->db->where('story_id', $story->id)->delete('story_tag');
		$this->db->delete('story', ['id' => $story->id]);
		$this->session->set_flashdata('success', 'Xóa truyện thành công.');
		return redirect(base_url('admin/truyen'));
	}

	public function check_name($name, $id)
	{
		$this->db->select('name');
		$this->db->from('story');
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
}
