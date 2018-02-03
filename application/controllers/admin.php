<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (empty($_SESSION['admin'])) {
			redirect('/');
			exit();
		}
	}

	public function index($offset = 1)
	{
		$data['judul'] = "";
		$this->load->view("admin-room/index",$data);
	}

	public function order($offset = 1, $id = 0)
	{
		if ($_SESSION['level'] == "teknisi") {
			redirect('/');
		}
		$data['judul'] = "order";

		//membuat paging dgn codeigniter
		$this->load->library('pagination');
		$jml = $this->db->get('order_produk');
		$config['base_url'] = base_url('admin/order');
		$config['total_rows'] = $jml->num_rows();
		$config['per_page'] = 10; /*Jumlah data yang dipanggil perhalaman*/
		$config['uri_segment'] = 3; /*data selanjutnya di parse diurisegmen 3*/
		$config['num_links'] = 2;
		$config['use_page_numbers'] = TRUE;
		/*Class bootstrap pagination yang digunakan*/
		$config['full_tag_open'] = "<ul class='pagination pagination-sm pull-right' style='position:relative; top:-25px;'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tag_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tag_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tag_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tag_close'] = "</li>";
		$this->pagination->initialize($config);
		$data['halaman'] = $this->pagination->create_links();
		/*membuat variable halaman untuk dipanggil di view nantinya*/
		$data['offset'] = $offset;
		$offset2 = $offset-1;
		$this->db->order_by("id_order", "DESC");
		$data['order'] = $this->db->get("order_produk",$config['per_page'], $offset2);

		$this->load->view("admin-room/order",$data);
	}

	public function produk($id = 0)
	{
		if ($_SESSION['level'] == "teknisi") {
			redirect('/');
		}
		$data['judul'] = "produk";
		$data['id'] = $id;
		$data['kat'] = $this->model1->selectData("kategori");
		$data['subkat'] = $this->model1->selectData("subkategori");
		$data['brand'] = $this->model1->selectData("brand");
		$data['produk'] = $this->model1->selectData("produk");
		$where = array("no_produk" => $id);
		$data['produk_select'] = $this->model1->selectWhere("produk", $where);

		$this->load->view("admin-room/produk",$data);
	}

	public function servis($id = 0)
	{
		if ($_SESSION['level'] == "teknisi") {
			redirect('/');
		}
		if (!empty($id)) {
            $where = array("id_servis" => $id);
            $data['edit'] = $this->model1->selectWhere("servis", $where);
		}
		$data['judul'] = "Servis";
		$data['id'] = $id;

		$this->load->view("admin-room/servis",$data);
	}

	public function template($id = 0)
	{
		if ($_SESSION['level'] == "teknisi" || $_SESSION['level'] == "kasir") {
			redirect('/');
		}
		$data['judul'] = "template";
		$data['id'] = $id;
		$this->load->view("admin-room/template",$data);
	}

	public function kategori($id="")
	{
		if ($_SESSION['level'] == "teknisi" || $_SESSION['level'] == "kasir") {
			redirect('/');
		}
		$data['judul'] = "kategori";
		$data['isi_kategori'] = $this->model1->selectData("kategori");
		$where = array("no_kategori" => $id);
		$data['edit_kategori'] = $this->model1->selectWhere("kategori",$where);
		$where2 = array("tipe" => "parent");
		$data['kat_promo'] = $this->model1->selectWhere("kategori", $where2);
		$this->load->view("admin-room/kategori",$data);
	}

	public function subkategori($id_kat="",$id_subkat="")
	{
		if ($_SESSION['level'] == "teknisi" || $_SESSION['level'] == "kasir") {
			redirect('/');
		}
		$data['judul'] = "subkategori";
		$data['no_kategori'] = $id_kat;
		$where = array("tipe" => "parent");
		$data['isi_kategori'] = $this->model1->selectWhere("kategori", $where);
		$where2 = array("no_subkategori" => $id_subkat);
		$data['edit_subkategori'] = $this->model1->selectWhere("subkategori", $where2);
		$this->db->order_by('nama_kategori','ASC');
		$data['isi_subkategori'] = $this->model1->selectData("subkategori");
		$this->load->view("admin-room/subkategori",$data);
	}

	public function brand($id = 0)
	{
		if ($_SESSION['level'] == "teknisi") {
			redirect('/');
		}
		$data['judul'] = "brand";
		$data['id'] = $id;
		$data['brand'] = $this->model1->selectData("brand");
		$this->load->view("admin-room/brand",$data);
	}

	public function promo($id = 0)
	{
		if ($_SESSION['level'] == "teknisi") {
			redirect('/');
		}
		$data['judul'] = "promo";
		$data['id'] = $id;
		$data['edit'] = $this->model1->selectWhere("promo", array("id_promo" => $id));
		$data['brand'] = $this->model1->selectData("promo");
		$this->load->view("admin-room/promo",$data);
	}

	public function ajax()
	{
		$this->load->view("admin-room/ajax");
	}

	public function register()
	{
		if ($_SESSION['level'] != "owner") {
			redirect('admin/');
		}else{
			$data['judul'] = "Register";
			$data['daftar'] = $this->model1->selectWhereSpec("admin", array("level !=" => "boss"));
			$this->load->view("admin-room/register",$data);
		}
	}

	public function ubah_profil()
	{
		$data['judul'] = "Profil";
		$data['profil'] = $this->model1->selectWhere("admin", array("id_admin" => $_SESSION['admin']));
		$this->load->view("admin-room/ubah-profil",$data);
	}

	public function pesan($offset = 1)
	{
		if ($_SESSION['level'] == "teknisi") {
			redirect('/');
		}
		$data['judul'] = "pesan";

		//membuat paging dgn codeigniter
		$this->load->library('pagination');
		$jml = $this->db->get('kontak');
		$config['base_url'] = base_url('admin/pesan');
		$config['total_rows'] = $jml->num_rows();
		$config['per_page'] = 10; /*Jumlah data yang dipanggil perhalaman*/
		$config['uri_segment'] = 3; /*data selanjutnya di parse diurisegmen 3*/
		$config['num_links'] = 2;
		$config['use_page_numbers'] = TRUE;
		/*Class bootstrap pagination yang digunakan*/
		$config['full_tag_open'] = "<ul class='pagination pagination-sm pull-right' style='position:relative; top:-25px;'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tag_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tag_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tag_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tag_close'] = "</li>";
		$this->pagination->initialize($config);
		$data['halaman'] = $this->pagination->create_links();
		/*membuat variable halaman untuk dipanggil di view nantinya*/
		$data['offset'] = $offset;
		$offset2 = $offset-1;
		$this->db->order_by("id_kontak", "DESC");
		$data['pesan'] = $this->db->get("kontak",$config['per_page'], $offset2);

		$this->load->view("admin-room/pesan",$data);
	}

	public function laporan()
	{
		$data['judul'] = "laporan";
		$this->load->view("admin-room/laporan", $data);
	}

	public function cetak_laporan($thn, $bln="")
	{
		$data['thn'] = $thn;
		$data['bln'] = $bln;
		$this->load->view("admin-room/cetak_laporan", $data);
	}

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
?>