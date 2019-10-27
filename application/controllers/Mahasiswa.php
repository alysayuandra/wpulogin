<?php 

class Mahasiswa extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Mahasiswa_model');
		$this->load->library('form_validation');
		
	}
	
	public function index()
	{
		// $this->load->model('Mahasiswa_model');
		
		$data['judul'] = 'Daftar Mahasiswa';
		$data['mahasiswa'] = $this->Mahasiswa_model->getAllMahasiswa();
		if($this->input->post('keyword')){
			$data['mahasiswa'] = $this->Mahasiswa_model->cariDataMahasiswa();
		}
		$this->load->view('templates/header', $data);
		$this->load->view('mahasiswa/index', $data);
		$this->load->view('templates/footer');
	}

	public function tambah(){
		$data['judul'] = 'Form Tambah Data Mahasiswa';
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('nrp', 'Nrp', 'required|numeric');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		if($this->form_validation->run() == FALSE){
			$this->load->view('templates/header', $data);
			$this->load->view('mahasiswa/tambah');
			$this->load->view('templates/footer');
		} else{
			$this->Mahasiswa_model->tambahDataMahasiswa();
			$this->session->set_flashdata('flash', 'Ditambahkan');
			redirect('mahasiswa');
		}
	}

	public function hapus($id){
		$this->Mahasiswa_model->hapusDataMahasiswa($id);
		$this->session->set_flashdata('flash', 'Dihapus');
		redirect('mahasiswa');
	}

	public function detail($id){
		$data['judul'] = 'Detail Data Mahasiswa';
		$data['mahasiswa'] = $this->Mahasiswa_model->getMahasiswaById($id);
		$this->load->view('templates/header', $data);
		$this->load->view('mahasiswa/detail', $data);
		$this->load->view('templates/footer');
	}

	public function ubah($id){
		$data['judul'] = 'Form Ubah Data Mahasiswa';
		$data['mahasiswa'] = $this->Mahasiswa_model->getMahasiswaById($id);
		$data['jurusan'] = ['Teknik Informatika', 'Teknik Mesin', 'Teknik Planologi', 'Teknik Pangan', 'Teknik Industri'];
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('nrp', 'Nrp', 'required|numeric');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');

		if($this->form_validation->run() == FALSE){
			$this->load->view('templates/header', $data);
			$this->load->view('mahasiswa/ubah', $data);
			$this->load->view('templates/footer');
		} else{
			$this->Mahasiswa_model->ubahDataMahasiswa();
			$this->session->set_flashdata('flash', 'Diubah');
			redirect('mahasiswa');
		}
	}

	// public function tampil(){
	// 	$data['dat'] = $this->Mahasiswa_model->tampil_mahasiswa();
	// 	$this->load->view('vtambah_data');
	// }

	// public function tambah_data_action(){
	// 	$insert = array(
	// 		'nrp' => $this->input->post("nrp"),
	// 		'nama' => $this->input->post("nama"),
	// 		'email' => $this->input->post("email"),
	// 		'jurusan' => $this->jurusan->post("jurusan"),

	// 	);
	// 	$this->Mahasiswa_model->tambah_data($insert);
	// 	redirect('Mahasiswa/tampil');
	// }

	public function delete_data($nrp){
		$this->Mahasiswa_model->delete_data($nrp);
		redirect('Mahasiswa/tampil');
	}

	
}