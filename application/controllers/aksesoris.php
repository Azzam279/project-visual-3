<?php
					if ( ! defined('BASEPATH')) exit('No direct script access allowed');

					class Aksesoris extends CI_Controller {
						public function __construct()
						{
							parent::__construct();
						}

						public function index()
						{
							$where = array("nama_kategori" => "aksesoris");
							$data_kat['kategory'] = $this->model1->selectWhere("kategori", $where);
							$this->load->view("produk1", $data_kat);
						}
					}
					?>