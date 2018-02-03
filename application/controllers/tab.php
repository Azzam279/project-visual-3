<?php
				if ( ! defined('BASEPATH')) exit('No direct script access allowed');

				class Tab extends CI_Controller {
					public function __construct()
					{
						parent::__construct();
					}

					public function index()
					{
						$where = array("nama_kategori" => "tab");
						$data_kat['kategory'] = $this->model1->selectWhere("kategori", $where);
						$this->load->view("produk1", $data_kat);
					}
					
					public function apple_tab()
					{
						$where2 = array("nama_subkategori" => "apple_tab");
						$data_subkat['subkat'] = $this->model1->selectWhere("subkategori", $where2);
						$this->load->view("produk2", $data_subkat);
					}
					
					public function android_tab()
					{
						$where2 = array("nama_subkategori" => "android_tab");
						$data_subkat['subkat'] = $this->model1->selectWhere("subkategori", $where2);
						$this->load->view("produk2", $data_subkat);
					}
				}
				?>