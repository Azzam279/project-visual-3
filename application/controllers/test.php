<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index()
	{
		if (isset($_POST['proses'])) {
			if (preg_match("/[\w\. ,:%?()&\"\'\-\+_]/i", $_POST['test'])) {
				echo "Cocok!";
			}else{
				echo "Tidak Cocok!";
			}
		}
		if (isset($_POST['cek'])) {
			$pass = md5(sha1("q3fg4".md5($_POST['test'])."93jwe"));
			echo $pass;
		}
		?>
		<form action="" method="post">
			<label>Test :</label>
			<input type="text" name="test" required>
			<input type="submit" name="proses" value="Proses">
		</form>
		<br>
		<form action="" method="post" accept-charset="utf-8">
			<input type="text" name="test" value="" placeholder="">
			<input type="submit" name="cek" value="cek">			
		</form>	
		<?php
	}

}

/* End of file test.php */
/* Location: ./application/controllers/test.php */