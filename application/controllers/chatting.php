<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chatting extends CI_Controller {

	public function index()
	{
		if (isset($_GET['chatting'])) {
			$data = array(
				"id_online" => null,
				"nama" => $_POST['chat_name'],
				"email" => $_POST['chat_email'],
				"no_hp" => $_POST['chat_telp'],
				"tgl" => time(),
				"status" => "Non-member",
				"foto" => "no-avatar.jpg",
				"banned" => "N"
				);
			$insert = $this->model1->insertData("chatting_online", $data);
			if ($insert == 1) {
				$_SESSION['nick'] = $_POST['chat_name'];
				$_SESSION['foto'] = "no-avatar.jpg";
				echo "Sukses";
			}else{
				echo "Gagal";
			}
		}else{
			redirect('/');
		}
	}

	public function mulai_chat()
	{
		$_SESSION['cek_admin'] = true;
		$_SESSION['tampil_box_chat'] = true;
		if (isset($_GET['start_chat'])) {
			//mengecek admin yg sedang online
			$cek = $this->model1->selectWhere("admin", array("online" => "Y"));
			if ($cek->num_rows() > 0) { //jika admin online eksekusi script ini
				if (empty($_SESSION['id_customer'])) { //jika session id_customer kosong
        		?>
		        <form action="<?php echo htmlspecialchars(base_url("chatting")); ?>" method="post" id="chatting_form">
		            <div class="panel-body" id="form-chatting-ajax">
		                <p><div id="validasi_chatting"></div></p>
		                <label>Nama</label><br>
		                <input type="text" name="chat_name" class="form-control" maxlength="20" placeholder="Nama" id="chatNama" required>
		                <label>Email</label><br>
		                <input type="email" name="chat_email" placeholder="Email" class="form-control" maxlength="150" id="chatEmail" required>
		                <label>Telp/Hp</label><br>
		                <input type="number" name="chat_telp" class="form-control" placeholder="Nomor Telepon / Hp" id="chatTelp" required>
		            </div>
		            <div class="panel-footer">
		                <button class="btn btn-success btn-sm pull-right" type="submit" id="btn-chat-lanjut">Lanjut &nbsp;<i class="fa fa-arrow-right"></i></button>
		                <div class="clearfix"></div>
		            </div>
		        </form>

		        <div id="tampil_temp_box_chat">
		            <div class="panel-body" id="msg_container_base">
		                <!-- Konten Chatting tampil disini -->
		            </div>
		            <div class="panel-footer">
		                <form action="<?php echo htmlspecialchars(base_url("chatting/kirim")); ?>" method="post" id="inputChatForm">
			            <div class="input-group">
			                <input id="input_chat" name="chat_pesan" type="text" class="form-control input-sm chat_input" placeholder="Ketik pesan anda disini..." required />
			                <span class="input-group-btn">
			                <button class="btn btn-primary btn-sm" type="submit" id="btn-chat">Kirim</button>
			                </span>
			            </div>
			            </form>
			            <audio controls id="suara_chat">
			                <source src="<?php echo base_url("audio/chat.mp3"); ?>" type="audio/mpeg">
			                Your browser does not support the audio element.
			            </audio>
		            </div>
		        </div>
		        <?php
		        }else{ //jika session id_customer tdk kosong

		        	//cek apakah customer sdh terdaftar di chatting online atau blum
		        	$cek_status = $this->model1->selectWhere("chatting_online", array("status" => $_SESSION['id_customer']));
		        	if ($cek_status->num_rows() > 0) { // jika sdh terdaftar
		        		$insert = 1;
		        	}else{ //jika blm maka insert data baru
		        		//proses insert customer ke tbl chatting_online
		        		$photo = (!empty($_SESSION['foto'])) ? $_SESSION['foto'] : "no-avatar.jpg";
						$data = array(
							"id_online" => null,
							"nama" => $_SESSION['nm_customer'],
							"email" => "-kosong-",
							"no_hp" => "-kosong-",
							"tgl" => time(),
							"status" => $_SESSION['id_customer'],
							"foto" => $photo,
							"banned" => "N"
							);
						$insert = $this->model1->insertData("chatting_online", $data);
		        	}
			        
					if ($insert == 1) { //jika proses insert berhasil maka eksekusi script ini
						$_SESSION['nick'] =  $_SESSION['nm_customer'];
			        ?>
			        <div id="chatting_box_ajax">
			        	<div id="validasi_banned"></div>
				        <div class="panel-body" id="msg_container_base">
				            <!-- Konten Chatting tampil disini -->
				        </div>
				        <div class="panel-footer">
				            <form action="<?php echo htmlspecialchars(base_url("chatting/kirim")); ?>" method="post" id="inputChatForm">
				            <div class="input-group">
				                <input id="input_chat" name="chat_pesan" type="text" class="form-control input-sm chat_input" maxlength="250" placeholder="Ketik pesan anda disini..." required />
				                <span class="input-group-btn">
				                <button class="btn btn-primary btn-sm" type="submit" id="btn-chat">Kirim</button>
				                </span>
				            </div>
				            </form>
				            <audio controls id="suara_chat">
				                <source src="<?php echo base_url("audio/chat.mp3"); ?>" type="audio/mpeg">
				                Your browser does not support the audio element.
				            </audio>
				        </div>
					</div>
			        <?php
					}else{ //jika insert gagal maka eksekusi script ini
						echo "<div><center><h4><font color='red'>Terjadi kesalahan! silakan coba lagi.</font></h4></center></div>";
					}
		        }
		    	?>
				<script>
				//menampilkan panel body n panel footer pada form chatting
				$("#chatting_form .panel-body").css("display","block");
				$("#chatting_form .panel-footer").css("display","block");
				//menampilkan panel body n panel footer pada chatting box ajax
				$("#chatting_box_ajax .panel-body").show();
				$("#chatting_box_ajax .panel-footer").show();

				//proses input form chatting
			    $("#chatting_form").submit(function() {
			        var nama = $("#chatNama").val();
			        var email = $("#chatNama").val();
			        var telp = $("#chatTelp").val();

			        if (nama=="" || email=="" || telp=="") { //jika kolom input ada yg kosong maka tampilkan validasi
			            $("#validasi_chatting").html('<div class="alert alert-warning page-alert"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><i class="fa fa-exclamation-triangle"></i> Semua kolom input harus di isi!</div>');
			        }else{ //jika semua kolom input di isi maka jalankan script dibawah ini
			            $.ajax({
			                url: $(this).attr('action') + "?chatting=true",
			                type: 'POST',
			                data: $(this).serialize(),
			                beforeSend: function() {
			                    $("#btn-chat-lanjut").attr("disabled","disabled");
			                    $("#btn-chat-lanjut i.fa").removeClass("fa-arrow-right");
			                    $("#btn-chat-lanjut i.fa").addClass("fa-refresh fa-spin");
			                },
			                success: function(hasil) {
			                    if (hasil=="Sukses") { //jika proses sukses
			                        function tampilChat() {
			                        	//sembunyikan form chatting
			                            $("#chatting_form").hide();
			                            //tampilkan panel body n panel footer
			                            $("#tampil_temp_box_chat").show();
			                            $("#tampil_temp_box_chat .panel-body").show();
			                            $("#tampil_temp_box_chat .panel-footer").show();
			                        }
			                        setTimeout(tampilChat, 3000);
			                    }else{ //jika gagal
			                        $("#validasi_chatting").html('<div class="alert alert-danger page-alert"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><i class="fa fa-exclamation-triangle"></i> Terjadi kesalahan! silakan coba lagi.</div>');
			                        $("#btn-chat-lanjut").removeAttr("disabled");
			                        $("#btn-chat-lanjut i.fa").removeClass("fa-refresh fa-spin");
			                        $("#btn-chat-lanjut i.fa").addClass("fa-arrow-right");
			                        //Close alert
			                        $('.page-alert .close').click(function(e) {
			                            e.preventDefault();
			                            $(this).closest('.page-alert').slideUp();
			                        });
			                    }
			                },
			                error: function() {
			                    alert("Error: Terjadi kesalahan!");
			                }
			            });
			        }
			        //Close alert
			        $('.page-alert .close').click(function(e) {
			            e.preventDefault();
			            $(this).closest('.page-alert').slideUp();
			        });

			        return false;
			    });

				//tampilkan pesan chatting
				function pesan_chatting() {
				    $("#msg_container_base").load(host+"chatting/pesan");
				    var box = document.getElementById("msg_container_base");
				    box.scrollTop = box.scrollHeight;
				}
				setInterval(pesan_chatting, 1000);

				//proses input pesan chat
				$("#inputChatForm").submit(function() {
			        var pesan = $("#input_chat").val();
			        $.ajax({
			            url: $(this).attr('action'),
			            type: 'POST',
			            data: 'pesan=' + pesan,
			            beforeSend: function() {
			                $("#btn-chat").addClass("m-progress");
			            },
			            success: function(hasil) {
			                $("#btn-chat").removeClass("m-progress");
			                //html5 audio play
			                var suara = document.getElementById("suara_chat");
			                suara.play();
			                if (hasil == "Sukses") {
			                	//kosongkan kolom input chat
			                    $("#input_chat").val("");
			                    function posisiBawah() {
			                        //membuat posisi scroll berada di bawah
			                        var box = document.getElementById("msg_container_base");
			                        box.scrollTop = box.scrollHeight;
			                    }
			                    setTimeout(posisiBawah, 1000);
				            }else if (hasil == "Kosong") {
			                    window.location = host;
			                }else if (hasil == "Banned") {
			                    //kosongkan kolom input chat
			                    $("#input_chat").val("");
			                    //disable kolom input chat n tombol kirim
			                    $("#input_chat").attr("disabled","disabled");
			                    $("#btn-chat").attr("disabled","disabled");
			                    //tampilkan validasi banned
			                    $("#validasi_banned").html('<center><div class="label label-danger">Anda di Banned oleh admin!</div></center>');
			                }else{
			                    return false;
			                }
			            },
			            error: function() {
			                alert("Terjadi kesalahan!");
			            }
			        });

			        return false;
			    });
				</script>
		    <?php    
			}else{ //jika admin tdk online maka eksekusi script ini
				echo "<div><center><h4>Tidak dapat melakukan chatting, Admin sedang <font color='red'>Offline</font>.</h4></center></div>";
			}
		}else{
			redirect('/');
		}
	}

	public function pesan()
	{
		//mengambil data chatting_pesan dan diurutkan berdasarkan id_pesan secara ascending(kecil ke besar)
		$this->db->order_by("id_pesan", "ASC");
		$select = $this->model1->selectData("chatting_pesan");
		$nick = $_SESSION['nick'];
		$foto = (!empty($_SESSION['foto'])) ? $_SESSION['foto'] : "no-avatar.jpg";
		foreach ($select->result() as $data) {
			$pathFoto = ($data->status == "Admin") ?  "image/foto/admin/$data->foto" : "image/foto/customer/$data->foto";
			$name = ($data->status=="Admin") ? "(ADMIN) $data->nama" : "$data->nama";
			if ($data->nama == $nick && $data->foto == $foto) {
				echo '
				<div class="row msg_container base_sent">
	                <div class="col-md-10 col-xs-10">
	                    <div class="messages msg_sent">
	                        <p>'.$data->pesan.'</p>
	                        <time>'.$name.' • '.$this->time_since($data->waktu).'</time>
	                    </div>
	                </div>
	                <div class="col-md-2 col-xs-2 avatar">
	                    <img src="'.base_url($pathFoto).'" class=" img-responsive ">
	                </div>
	            </div>
				';
			}else{
				echo '
	            <div class="row msg_container base_receive">
	                <div class="col-md-2 col-xs-2 avatar">
	                    <img src="'.base_url($pathFoto).'" class=" img-responsive ">
	                </div>
	                <div class="col-md-10 col-xs-10">
	                    <div class="messages msg_receive">
	                        <p>'.$data->pesan.'</p>
	                        <time>'.$name.' • '.$this->time_since($data->waktu).'</time>
	                    </div>
	                </div>
	            </div>';	
			}
		}
		$select->free_result();
	}

	public function kirim()
	{
		if (isset($_POST['pesan'])) {
			$cek_tableOnline = $this->model1->selectData("chatting_online");
			$cek_banned = $this->model1->selectWhereSpec("chatting_online", array("nama" => $_SESSION['nick'], "foto" => $_SESSION['foto'], "banned" => "Y"));
			//cek tbl chatting_online apakah kosong atau tidak
			if ($cek_tableOnline->num_rows() == 0 || $cek_tableOnline->num_rows() < 1) {
				echo "Kosong";
				unset($_SESSION['nick']); //hapus session nick
			}else if ($cek_banned->num_rows() > 0) { //jika dibanned oleh admin maka tdk bisa chatting
				echo "Banned";
			}else{
				//proses insert pesan chat
				$nama = $_SESSION['nick'];
				$foto = (!empty($_SESSION['foto'])) ? $_SESSION['foto'] : "no-avatar.jpg";
				$data = array(
					"id_pesan" => null,
					"nama" => trim($nama),
					"pesan" => trim(htmlentities($_POST['pesan'])),
					"waktu" => time(),
					"status" => "Customer",
					"foto" => $foto
					);
				$insert = $this->model1->insertData("chatting_pesan", $data);
				//cek apakah proses insert sukses atau gagal
				if ($insert == 1) {
					echo "Sukses";
				}else{
					echo "Gagal";
				}
			}
		}else{
			redirect('/');
		}
	}

	function time_since($original)
	{
	    date_default_timezone_set('Asia/Singapore');
	    $chunks = array(
	        array(60 * 60 * 24 * 365, 'tahun'),
	        array(60 * 60 * 24 * 30, 'bulan'),
	        array(60 * 60 * 24 * 7, 'minggu'),
	        array(60 * 60 * 24, 'hari'),
	        array(60 * 60, 'jam'),
	        array(60, 'menit'),
	        );

	    $today = time();
	    $since = $today - $original;

	    if ($since > 604800) {
	        $print = date("M jS", $original);
	        if ($since > 31536000) {
	            $print .= ", " . date("Y", $original);
	        }
	        return $print;
	    }

	    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
	        $seconds = $chunks[$i][0];
	        $name = $chunks[$i][1];

	        if (($count = floor($since / $seconds)) != 0) {
	            break;
	        }
	    }

	    $print = ($count == 1) ? '1 ' . $name : "$count $name";
	    return $print . ' yang lalu';
	}

}

/* End of file chatting.php */
/* Location: ./application/controllers/chatting.php */
?>
