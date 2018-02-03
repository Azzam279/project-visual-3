<section class="content-wrapper">
	<section class="content-header">
		<h1>Dashboard
        <small>Control panel</small>
        </h1>
	</section>
	<section class="content">
		<div class="box box-primary box-solid">
			<div class="box-header">
				<h3 class="box-title">Halaman Utama Admin</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<?php
				if ($_SESSION['level'] != "teknisi") {
					if ($_SESSION['level'] == "owner") { //jika level boss
				?>
				<!-- Small boxes (Stat box) -->
		          <div class="row">
		            <div class="col-lg-3 col-xs-6">
		              <?php $total_order = $this->model1->selectData("order_produk"); ?>
		              <!-- small box -->
		              <div class="small-box bg-aqua">
		                <div class="inner">
		                  <h3><?php echo $total_order->num_rows(); ?></h3>
		                  <p>Total Order</p>
		                </div>
		                <div class="icon">
		                  <i class="ion ion-bag"></i>
		                </div>
		                <a href="<?php echo base_url("admin/order"); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		              </div>
		            </div><!-- ./col -->
		            <div class="col-lg-3 col-xs-6">
		              <?php
		              $total_beli = $this->model1->selectWhereSpec("order_produk", array("status_barang !=" => "N"));
		              $total_tdk_beli = $this->model1->selectWhere("order_produk", array("status_barang" => "N"));
		              ?>
		              <!-- small box -->
		              <div class="small-box bg-green">
		                <div class="inner">
		                  <h3><?php echo $total_beli->num_rows()." & ".$total_tdk_beli->num_rows(); ?></h3>
		                  <p>Beli & Tidak Beli</p>
		                </div>
		                <div class="icon">
		                  <i class="ion ion-pie-graph"></i>
		                </div>
		                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		              </div>
		            </div><!-- ./col -->
		            <div class="col-lg-3 col-xs-6">
		              <?php $user_reg = $this->model1->selectData("customer"); ?>
		              <!-- small box -->
		              <div class="small-box bg-yellow">
		                <div class="inner">
		                  <h3><?php echo $user_reg->num_rows(); ?></h3>
		                  <p>Customer Mendaftar</p>
		                </div>
		                <div class="icon">
		                  <i class="ion ion-person-add"></i>
		                </div>
		                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		              </div>
		            </div><!-- ./col -->
		            <div class="col-lg-3 col-xs-6">
		              <?php $visitors = $this->model1->selectData("counting_visitor"); ?>
		              <!-- small box -->
		              <div class="small-box bg-red">
		                <div class="inner">
		                  <h3><?php echo $visitors->num_rows(); ?></h3>
		                  <p>Total Pengunjung</p>
		                </div>
		                <div class="icon">
		                  <i class="ion ion-man"></i>
		                </div>
		                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		              </div>
		            </div><!-- ./col -->
		          </div><!-- /.row -->

          		<div class="row">
          			<div class="col-md-12 connectedSortable">
          				<!-- Custom tabs (Charts with tabs)-->
			              <div class="nav-tabs-custom">
			                <!-- Tabs within a box -->
			                <ul class="nav nav-tabs pull-right" id="tab-chart-penjualan">
			                  <li class="active"><a href="#tampilChart" id="tipe_column" data-toggle="tab" onclick="grafik_terjual('column')">Column</a></li>
			                  <li><a href="#tampilChart" id="tipe_spline" data-toggle="tab" onclick="grafik_terjual('spline')">Spline</a></li>
			                  <li><a href="#tampilChart" id="tipe_doughnut" data-toggle="tab" onclick="grafik_terjual('doughnut')">Doughnut</a></li>
			                  <li class="pull-left header"><i class="fa fa-inbox"></i> Penjualan pada Toko Komputer</li>
			                </ul>
			                <div class="tab-content no-padding">
			                	<div style="margin-top:9px;">
			                		<label style="display:inline-block;">Pilih Tahun : </label>
			                		<select class="form-control" id="thn-trjual" onchange="grafik_terjual('kosong')" style="display:inline-block; width:100px;">
			                			<?php
			                			//mengambil nilai terendah dari time_terjual di tbl produk_terjual
					                	$start_th = $this->model1->selectQuery2("SELECT MIN(time_terjual) as min FROM produk_terjual");
					                	//mengambil nilai tertinggi dari time_terjual di tbl produk_terjual
					                	$finish_th = $this->model1->selectQuery2("SELECT MAX(time_terjual) as max FROM produk_terjual");
					                	//convert time_terjual ke tahun
					                	$mulai = date("Y",$start_th->result()[0]->min);
					                	$slesai = date("Y",$finish_th->result()[0]->max);
					                	//tahun akhir - tahun awal
					                	$hitung = $slesai - $mulai;
					                	//tampilkan tahun awal sampai tahun akhir dgn cara decrement looping
					                	for ($i=$hitung; $i >= 0; $i--) {
					                		echo '<option value="'.$slesai.'">'.$slesai.'</option>';
					                		$slesai -= $i;
					                	}
			                			?>
			                		</select>
			                		&nbsp;&nbsp;
			                		<label style="display:inline-block;">Pilih Kategori : </label>
			                		<select class="form-control" id="kat-trjual" style="display:inline-block; width:200px;" onchange="subkat_trjual()">
			                			<option value="">-Semua Kategori-</option>
			                			<?php
			                			$kat_trjual = $this->model1->selectData("kategori");
			                			foreach ($kat_trjual->result() as $kat) {
			                				echo "
											<option value='$kat->no_kategori-$kat->tipe'>".ucfirst($kat->nama_kategori)."</option>
			                				";
			                			}
			                			$kat_trjual->free_result();
			                			?>
			                		</select>
			                		&nbsp;&nbsp;
			                		<label style="display:inline-block;">Pilih Subkategori : </label>
			                		<select class="form-control" id="sub-trjual" style="display:inline-block; width:200px;" onchange="grafik_terjual('kosong')">
			                			<option value="">-Semua Subkategori-</option>
			                		</select>
			                	</div>
			                	<div class="clearfix"></div><br>
			                	<!-- Canvas chart - Sales -->
								<div id="tampilChart" class="tab-pane active" style="position: relative;"></div>
			                </div>
			              </div><!-- /.nav-tabs-custom -->
          			</div>
          		</div>
          		<?php
          		}
          		?>
				
				<?php
				//mengambil data chatting_pesan utk diambil total record nya
				$total_pesan = $this->model1->selectData("chatting_pesan");
				?>
				<div class="row">
                <div class="col-md-6">
                  <!-- DIRECT CHAT -->
                  <div class="box box-warning direct-chat direct-chat-warning">
                    <div class="box-header with-border">
                      <h3 class="box-title">Admin Chat</h3>
                      <div class="box-tools pull-right">
                        <span class="badge bg-yellow" id="total-chats"><?php echo $total_pesan->num_rows(); ?></span>
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                      </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <!-- Conversations are loaded here -->
                      <div class="direct-chat-messages" id="direct-chat-messages">
                        <!-- Konten pesan chat -->
                      </div><!--/.direct-chat-messages-->

                    </div><!-- /.box-body -->
                    <div class="box-footer">
                      <form action="<?php echo htmlspecialchars(base_url('chatting_admin/kirim')); ?>" method="post" id="chatting-form">
                        <div class="input-group">
                          <input type="text" name="pesan" maxlength="250" placeholder="Ketik pesan ..." class="form-control" id="input-chat" required>
                          <span class="input-group-btn">
                            <button type="submit" id="btn-chat-admin" class="btn btn-warning btn-flat">Kirim</button>
                          </span>
                        </div>
                      </form>
			            <audio controls id="suara_chat" style="display:none;">
			                <source src="<?php echo base_url("audio/chat.mp3"); ?>" type="audio/mpeg">
			                Your browser does not support the audio element.
			            </audio>
                    </div><!-- /.box-footer-->
                  </div><!--/.direct-chat -->
                </div><!-- /.col -->

				<?php
				$chat_user = $this->model1->selectWhere("chatting_online", array("status !=" => "Admin"));
				?>
                <div class="col-md-6">
                	<div class="box box-danger">
		                <div class="box-header with-border">
		                  <h3 class="box-title">Customer Chat Online</h3>
		                  <div class="box-tools pull-right">
		                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		                  </div>
		                </div><!-- /.box-header -->
		                <div class="box-body">
		                  <ul class="products-list product-list-in-box">
		                  	<?php
		                  	foreach ($chat_user->result() as $users) {
		                  		$bisu = ($users->banned=="N") ? "Bisu" : "Bicara";
		                  	?>
		                  	<li class="item">
		                      <div class="product-img">
		                        <img src="<?php echo base_url("image/foto/customer/$users->foto"); ?>" alt="customer image" class="img-responsive">
		                      </div>
		                      <div class="product-info">
		                        <a href="javascript::;" class="product-title"><?php echo $users->nama; ?> <span class="pull-right"><button class="btn btn-warning btn-sm" onclick="bisu(<?php echo $users->id_online; ?>)" id="<?php echo "btn-bisu-$users->id_online"; ?>" style="font-weight:bold;"><?php echo $bisu; ?></button></span></a>
		                        <span class="product-description">
		                          <?php echo ($users->status=="Non-member") ? "Non-member" : "Member ($users->status)"; ?>
		                        </span>
		                      </div>
		                    </li><!-- /.item -->
		                  	<?php	
		                  	}
		                  	$chat_user->free_result();
		                  	?>
		                    
		                  </ul>
		                </div><!-- /.box-body -->
		                <div class="box-footer text-center">
		                  <a href="javascript::;" class="uppercase">Tampilkan lebih banyak</a>
		                </div><!-- /.box-footer -->
		              </div><!-- /.box -->
                </div>
                </div>
				<?php
				}else{
				?>
				<div class="table-responsive">
					<table id="servis" class="table table-hover table-condensed table-striped table-bordered">
                        <thead>
                            <tr>
                                <th width="40">ID</th>
                                <th width="200">Nama Pelanggan</th>
                                <th width="300">Barang Servis</th>
                                <th>Status</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Selesai</th>
                                <th><center>Detail</center></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <th width="40">ID</th>
                            <th width="200">Nama Pelanggan</th>
                            <th width="300">Barang Servis</th>
                            <th>Status</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Selesai</th>
                            <th><center>Detail</center></th>
                        </tfoot>
                    </table>
				</div>
				<?php	
				}
				?>
			</div>
			<div class="box-footer">
				<p>Anda Login Sebagai <b><?php echo strtoupper($_SESSION['level']); ?></b></p>
			</div>
		</div>
	</section>
</section>
