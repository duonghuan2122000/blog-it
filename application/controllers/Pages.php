<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

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
		$hotStories = $this->db->select('name,slug')->from('story')->order_by('view', 'desc')->get()->result();
		$tagsAll = $this->db->select('name,slug')->from('tag')->get()->result_array();
		$this->load->vars(['hotStories' => $hotStories, 'tagsAll' => $tagsAll]);
		$this->load->helper('time_helper');
	}
	public function home()
	{
		$stories = $this->db->select('name,slug,updated_at')->from('story')->order_by('created_at', 'desc')->get()->result();
		$data = [
			'title' => 'BlogTruyen đọc truyện và share truyện miễn phí',
			'temp' => 'home',
			'stories' => $stories
		];
		return $this->load->view('pages/layout', $data);
	}

	public function story($slug)
	{
		$story = $this->db->select('id,name,author,description,status,img,slug,author_slug,view')->from('story')->where('slug', $slug)->get()->row();
		if(empty($story)){
			return show_404();
		}
		$tags = $this->db->query("SELECT id,name FROM tag WHERE id IN (SELECT tag_id FROM story_tag WHERE story_id = ?)", [$story->id])->result_array();
		$this->load->library('pagination');
		$config = [];
		$config['base_url'] = base_url('truyen-'.$slug);
		$config['total_rows'] = $this->db->from('chapter')->where('story_id',$story->id)->count_all_results();
		$config['per_page'] = 20;
		$config['uri_segment'] = 2;
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
		$current_page = $this->uri->segment(2) ? $this->uri->segment(2) : 1;

		$this->pagination->initialize($config);
		$chapters = $this->db->select('num,name,view')->from('chapter')->where('story_id',$story->id)->limit($config['per_page'], (int) ($current_page - 1) * $config['per_page'] )->get()->result();
		$chapter_first = $this->db->select_min('num')->from('chapter')->where('story_id',$story->id)->get()->row();
		$chapter_last = $this->db->select_max('num')->from('chapter')->where('story_id',$story->id)->get()->row();
		$data = [
			'title' => 'Truyện '.$story->name,
			'temp' => 'story',
			'story' => $story,
			'tags' => $tags,
			'chapters' => $chapters,
			'chapter_first' => $chapter_first,
			'chapter_last' => $chapter_last,
			'breadcrumb_story' => true
		];
		$this->db->where('id',$story->id)->update('story', ['view' => (int) $story->view+1]);
		return $this->load->view('pages/layout', $data);
	}

	public function chapter($slug, $num)
	{
		$story = $this->db->select('id,name,slug')->from('story')->where('slug', $slug)->get()->row();
		if(empty($story)){
			return show_404();
		}
		$chapter = $this->db->select('id,num,name,content,view')->from('chapter')->where('num', $num)->where('story_id', $story->id)->order_by('num', 'asc')->get()->row();
		if(empty($chapter)){
			return show_404();
		}
		$this->load->helper('control');
		$chapters = $this->db->select('num')->from('chapter')->where('story_id', $story->id)->get()->result_array();
		$data = [
			'title' => 'Truyện '.$story->name.' Chương '.$num,
			'temp' => 'chapter',
			'chapter' => $chapter,
			'story' => $story,
			'chapters' => $chapters,
			'breadcrumb_chapter' => true
		];
		$this->db->where('id',$chapter->id)->update('chapter', ['view' => $chapter->view+1]);
		return $this->load->view('pages/layout', $data);
	}

	public function tag($slug)
	{
		$tag = $this->db->select('id,name')->from('tag')->where('slug',$slug)->get()->row();
		if(empty($slug)){
			return show_404();
		}

		$this->load->library('pagination');
		$config = [];
		$config['base_url'] = base_url('the-loai-'.$slug);
		$config['total_rows'] = $this->db->query('SELECT id FROM story WHERE id IN (SELECT story_id FROM story_tag WHERE tag_id = ?)', [$tag->id])->num_rows();
		$config['per_page'] = 10;
		$config['uri_segment'] = 2;
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
		$current_page = $this->uri->segment(2) ? $this->uri->segment(2) : 1;

		$this->pagination->initialize($config);
		$stories = $this->db->query('SELECT name,slug,updated_at FROM story WHERE id IN (SELECT story_id FROM story_tag WHERE tag_id = ?) ORDER BY updated_at DESC LIMIT ?, ?', [$tag->id, ($current_page - 1) * $config['per_page'], $config['per_page']])->result();

		$data = [
			'title' => 'Thể loại '.$tag->name,
			'temp' => 'tag',
			'stories' => $stories,
			'tag' => $tag
		];
		return $this->load->view('pages/layout', $data);
	}

	public function author($slug)
	{
		$total = $this->db->select('id')->from('story')->where('author_slug', $slug)->count_all_results();
		if(empty($total)){
			return show_404();
		}
		$this->load->library('pagination');
		$config = [];
		$config['base_url'] = base_url('tac-gia-'.$slug);
		$config['total_rows'] = $total;
		$config['per_page'] = 10;
		$config['uri_segment'] = 2;
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
		$current_page = $this->uri->segment(2) ? $this->uri->segment(2) : 1;

		$this->pagination->initialize($config);
		$stories = $this->db->select('name,slug,updated_at,author')->from('story')->where('author_slug',$slug)->limit($config['per_page'], (int) ($current_page - 1) * $config['per_page'])->order_by('updated_at', 'desc')->get()->result_array();
		$data = [
			'title' => 'Tác giả '.$stories[0]['author'],
			'temp' => 'author',
			'stories' => $stories
		];	
		return $this->load->view('pages/layout', $data);
	}

	public function search()
	{
		$stories = $this->db->query('SELECT name,slug,updated_at FROM story WHERE MATCH(name,description) AGAINST (?)',[$this->input->get('q')])->result();
		$data = [
			'title' => 'Tìm kiếm ',
			'temp' => 'search',
			'search' => $this->input->get('q'),
			'stories' => $stories
		];
		return $this->load->view('pages/layout', $data);
	}
}
