<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chapter extends MY_Controller {

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
	public function index($slug)
	{
		$story = $this->db->select('id,name,slug')->from('story')->where('slug', $slug)->get()->row();
		if(empty($story)){
			return show_404();
		}
		$this->load->library('pagination');
		$config = [];
		$config['base_url'] = base_url('admin/truyen-'.$story->slug.'/danh-sach-chuong');
		$config['total_rows'] = $this->db->from('chapter')->where('story_id',$story->id)->count_all_results();
		$config['per_page'] = 10;
		$config['uri_segment'] = 4;
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$config['last_link'] = 'Trang cuối';
		$config['first_link'] = 'Trang đầu';
		$config['use_page_numbers'] = true;
		$current_page = $this->uri->segment(4) ? $this->uri->segment(4) : 1;

		$this->pagination->initialize($config);
		$chapters = $this->db->select('num,name')->from('chapter')->order_by('created_at','desc')->where('story_id',$story->id)->limit($config['per_page'], (int) ($current_page - 1) * $config['per_page'] )->get()->result();

		$data = [
			'temp' => 'chapter/index',
			'title' => 'Danh sách chương truyện '.$story->name,
			'chapters' => $chapters,
			'story' => $story,
			'success' => $this->session->flashdata('success'),
			'script_chapter' => true
		];
		return $this->load->view('admin/layout', $data);
	}

	public function create(){
		$stories = $this->db->select('id,name')->from('story')->order_by('created_at', 'desc')->get()->result();
		if($this->input->method() == 'post'){
			$this->form_validation->set_rules('num', 'Số chương', 'required|numeric|callback_check_num_create');
			$this->form_validation->set_rules('content', 'Nội dung chương', 'required|min_length[50]');
			$this->form_validation->set_rules('story', 'Tên truyện', 'required|callback_check_story');
			if(!$this->form_validation->run()){
				$data = [
					'temp' => 'chapter/create',
					'title' => 'Thêm chương mới',
					'script_chapter' => true,
					'stories' => $stories
				];
				return $this->load->view('admin/layout', $data);
			} else {
				$data = [
					'num' => $this->input->post('num'),
					'content' => $this->input->post('content'),
					'story_id' => $this->input->post('story'),
					'created_at' => time()
				];
				if(!empty($this->input->post('name'))){
					$data['name'] = $this->input->post('name');
				}
				$this->db->insert('chapter', $data);
				$this->db->where('id', $this->input->post('story'))->insert('story', ['updated_at' => time()]);
				$story = $this->db->select('slug')->from('story')->where('id',$this->input->post('story'))->get()->row();
				$this->session->set_flashdata('success', 'Thêm chương mới thành công.');
				return redirect(base_url('admin/truyen-'.$story->slug.'/danh-sach-chuong'));
			}
		} else {
			$data = [
				'temp' => 'chapter/create',
				'title' => 'Thêm chương mới',
				'script_chapter' => true,
				'stories' => $stories
			];
			return $this->load->view('admin/layout', $data);
		}
	}

	public function check_story($id)
	{
		$story = $this->db->select('id')->from('story')->where('id', $this->input->post('story'))->get()->row();
		if(empty($story)){
			$this->form_validation->set_message('check_story', '{field} không tồn tại.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function check_num_create($name)
	{
		$chapter = $this->db->select('id')->from('chapter')->where('num',$name)->where('story_id',$this->input->post('story'))->get()->row();
		if(!empty($chapter)){
			$this->form_validation->set_message('check_num_create', 'Chương đã tồn tại.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function edit($slug, $num)
	{
		$story = $this->db->select('id,name')->from('story')->where('slug', $slug)->get()->row();
		if(empty($story)){
			return show_404();
		}

		$chapter = $this->db->select('id,num,name,content')->from('chapter')->where('story_id',$story->id)->where('num',$num)->get()->row();
		if(empty($chapter)){
			return show_404();
		}

		$stories = $this->db->select('id,name')->from('story')->order_by('created_at', 'desc')->get()->result();

		if($this->input->method() == 'post'){
			$this->form_validation->set_rules('num', 'Số chương', 'required|numeric|callback_check_num_edit['.$chapter->id.']');
			$this->form_validation->set_rules('content', 'Nội dung chương', 'required|min_length[50]');
			$this->form_validation->set_rules('story', 'Tên truyện', 'required');
			if(!$this->form_validation->run()){
				$data = [
					'temp' => 'chapter/edit',
					'title' => 'Chỉnh sửa chương '.$chapter->num.' Truyện '.$story->name,
					'script_chapter' => true,
					'stories' => $stories,
					'story' => $story,
					'chapter' => $chapter
				];
				return $this->load->view('admin/layout', $data);
			} else {
				$data = [
					'num' => $this->input->post('num')
				];
				if($this->input->post('story') !== $story->id){
					$data['story_id'] = $this->input->post('story');
				}
				if($this->input->post('content') !== $chapter->content){
					$data['content'] = $this->input->post('content');
				}
				if(!empty($this->input->post('name'))){
					$data['name'] = $this->input->post('name');
				}
				$this->db->where('id', $chapter->id)->update('chapter', $data);
				$this->session->set_flashdata('success', 'Chỉnh sửa chương thành công.');
				return redirect(current_url());
			}
		} else {
			$data = [
				'temp' => 'chapter/edit',
				'title' => 'Chỉnh sửa chương '.$chapter->num.' Truyện '.$story->name,
				'script_chapter' => true,
				'stories' => $stories,
				'story' => $story,
				'chapter' => $chapter,
				'success' => $this->session->flashdata('success')
			];
			return $this->load->view('admin/layout', $data);
		}
	}

	public function check_num_edit($name, $id)
	{
		$chapter = $this->db->select('id')->from('chapter')->where('num', $name)->where('story_id', $this->input->post('story'))->where('id !=', $id)->get()->row();
		if(empty($chapter)){
			return TRUE;
		} else {
			$this->form_validation->set_message('check_num_edit', 'Chương đã tồn tại.');
			return FALSE;
		}
	}

	public function del($slug, $num)
	{
		$story = $this->db->select('id')->from('story')->where('slug', $slug)->get()->row();
		if(empty($story)){
			return show_404();
		}

		$chapter = $this->db->select('id')->from('chapter')->where('story_id',$story->id)->where('num',$num)->get()->row();
		if(empty($chapter)){
			return show_404();
		}

		$this->db->where('id', $chapter->id)->delete('chapter');
		$this->session->set_flashdata('success', 'Xóa chương thành công.');
		return redirect(base_url('admin/truyen-'.$slug.'/danh-sach-chuong'));
	}
}
