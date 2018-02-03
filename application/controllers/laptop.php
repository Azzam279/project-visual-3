<?php
				if ( ! defined('BASEPATH')) exit('No direct script access allowed');

				class Laptop extends CI_Controller {
					public function __construct()
					{
						parent::__construct();
					}

					public function index()
					{
						$where = array("nama_kategori" => "laptop");
						$data_kat['kategory'] = $this->model1->selectWhere("kategori", $where);
						$this->load->view("produk1", $data_kat);
					}
					
						public function notebook()
						{
							$where2 = array("nama_subkategori" => "notebook");
							$data_subkat['subkat'] = $this->model1->selectWhere("subkategori", $where2);
							$this->load->view("produk2", $data_subkat);
						}
						
						public function ultrabook()
						{
							$where2 = array("nama_subkategori" => "ultrabook");
							$data_subkat['subkat'] = $this->model1->selectWhere("subkategori", $where2);
							$this->load->view("produk2", $data_subkat);
						}
						
				}
				?>