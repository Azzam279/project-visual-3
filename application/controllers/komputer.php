<?php
				if ( ! defined('BASEPATH')) exit('No direct script access allowed');

				class Komputer extends CI_Controller {
					public function __construct()
					{
						parent::__construct();
					}

					public function index()
					{
						$where = array("nama_kategori" => "komputer");
						$data_kat['kategory'] = $this->model1->selectWhere("kategori", $where);
						$this->load->view("produk1", $data_kat);
					}
					
						public function komputer_butut()
						{
							$where2 = array("nama_subkategori" => "komputer_butut");
							$data_subkat['subkat'] = $this->model1->selectWhere("subkategori", $where2);
							$this->load->view("produk2", $data_subkat);
						}
						
						public function komputer_gaming()
						{
							$where2 = array("nama_subkategori" => "komputer_gaming");
							$data_subkat['subkat'] = $this->model1->selectWhere("subkategori", $where2);
							$this->load->view("produk2", $data_subkat);
						}
						
						public function komputer_kerja()
						{
							$where2 = array("nama_subkategori" => "komputer_kerja");
							$data_subkat['subkat'] = $this->model1->selectWhere("subkategori", $where2);
							$this->load->view("produk2", $data_subkat);
						}
						
				}
				?>