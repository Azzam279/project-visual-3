<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chatting_admin extends CI_Controller {

	public function index()
	{
		$this->db->order_by("id_pesan", "ASC");
		$chat = $this->model1->selectData("chatting_pesan");
		foreach ($chat->result() as $data) {
			$photo = ($data->status=="Admin") ? "image/foto/admin/$data->foto" : "image/foto/customer/$data->foto";
			$nama = ($data->status=="Admin") ? "(Admin) $data->nama" : "$data->nama";
			if ($data->nama == $_SESSION['nama'] && $data->status == "Admin" && $data->foto == $_SESSION['foto_admin']) {
				echo '
				<!-- Message to the right -->
                <div class="direct-chat-msg right">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-right">'.$nama.'</span>
                    <span class="direct-chat-timestamp pull-left">'.$this->time_since($data->waktu).'</span>
                  </div><!-- /.direct-chat-info -->
                  <img class="direct-chat-img" src="'.base_url($photo).'" alt="message user image"><!-- /.direct-chat-img -->
                  <div class="direct-chat-text">
                    '.$data->pesan.'
                  </div><!-- /.direct-chat-text -->
                </div><!-- /.direct-chat-msg -->
				';
			}else{
				echo '
				<!-- Message. Default to the left -->
                <div class="direct-chat-msg">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-left">'.$nama.'</span>
                    <span class="direct-chat-timestamp pull-right">'.$this->time_since($data->waktu).'</span>
                  </div><!-- /.direct-chat-info -->
                  <img class="direct-chat-img" src="'.base_url($photo).'" alt="message user image"><!-- /.direct-chat-img -->
                  <div class="direct-chat-text">
                    '.$data->pesan.'
                  </div><!-- /.direct-chat-text -->
                </div><!-- /.direct-chat-msg -->
				';
			}
		}
		?>
		<script>
			//mengambil total pesan chat lalu menampilkannya
			var total_chats = "<?php echo $chat->num_rows(); ?>";
			$("#total-chats").text(total_chats);
		</script>
		<?php
		$chat->free_result();
	}

	public function kirim()
	{
		if (isset($_GET['kirim'])) {
			//cek apakah admin sdh terdaftar di tbl chatting_online atau blm
			$where = array(
					"nama" => $_SESSION['nama'],
					"status" => "Admin",
					"foto" => $_SESSION['foto_admin']
					);
			$cek = $this->model1->selectWhereSpec("chatting_online", $where);
			//jika blm trdaftar maka lakukan insert data ke tbl chatting_online terlebih dulu
			if ($cek->num_rows() == 0 || $cek->num_rows() < 1) {
				$photo = (!empty($_SESSION['foto_admin'])) ? $_SESSION['foto_admin'] : "no-avatar.jpg";
				$data = array(
						"id_online" => null,
						"nama" => $_SESSION['nama'],
						"email" => "-kosong-",
						"no_hp" => "-kosong-",
						"tgl" => time(),
						"status" => "Admin",
						"foto" => $photo,
						"banned" => "N"
						);
				$insert = $this->model1->insertData("chatting_online", $data);
				//jika proses insert data ke tbl chatting_online berhasil
				if ($insert == 1) {
					//proses insert pesan chat
					$data = array(
						"id_pesan" => null,
						"nama" => $_SESSION['nama'],
						"pesan" => trim(htmlentities($_POST['pesan'])),
						"waktu" => time(),
						"status" => "Admin",
						"foto" => $_SESSION['foto_admin']
						);
					$insert = $this->model1->insertData("chatting_pesan", $data);
					if ($insert == 1) {
						echo "Sukses";
					}else{
						echo "Gagal";
					}
				}
			}else{ //jika sdh terdaftar
				//proses insert pesan chat
				$data = array(
					"id_pesan" => null,
					"nama" => $_SESSION['nama'],
					"pesan" => trim(htmlentities($_POST['pesan'])),
					"waktu" => time(),
					"status" => "Admin",
					"foto" => $_SESSION['foto_admin']
					);
				$insert = $this->model1->insertData("chatting_pesan", $data);
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

/* End of file chatting_admin.php */
/* Location: ./application/controllers/chatting_admin.php */