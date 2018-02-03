<?php
if(@$_GET['do']=='rate') {
	// do rate
	$x = explode(".", $_GET['rating']);
	$no = $x[1];
	$val = $x[0];

	$sql_cek = $this->model1->selectQuery2("SELECT * FROM vote_star WHERE id_produk = '$no' AND value = '$val'");

	if ($sql_cek->num_rows() == 0) {
		$ins = array(
			"id_votestar" => null,
			"id_produk" => $x[1],
			"counter" => 1,
			"value" => $x[0]
			);
		$this->model1->insertData("vote_star", $ins);
	}else{
		$this->model1->selectQuery2("UPDATE vote_star SET counter = counter+1 WHERE id_produk = '$no' AND value = '$val'");
	}
}else if(@$_GET['do']=='getrate' && isset($_GET['id'])) {
	$sql = $this->model1->selectQuery2("SELECT SUM(value) as val FROM vote_star WHERE id_produk = '$_GET[id]'");
	$val = $sql->result()[0]->val;
	$sql2 = $this->model1->selectQuery2("SELECT SUM(counter) as count FROM vote_star WHERE id_produk = '$_GET[id]'");
	$count = $sql2->result()[0]->count;
	/*$_5 = $this->model1->selectWhereSpec("vote_star", array("id_produk" => $_GET['id'], "value", 5));
	$_4 = $this->model1->selectWhereSpec("vote_star", array("id_produk" => $_GET['id'], "value", 4));
	$_3 = $this->model1->selectWhereSpec("vote_star", array("id_produk" => $_GET['id'], "value", 3));
	$_2 = $this->model1->selectWhereSpec("vote_star", array("id_produk" => $_GET['id'], "value", 2));
	$_1 = $this->model1->selectWhereSpec("vote_star", array("id_produk" => $_GET['id'], "value", 1));*/

	// set width of star
	$rating = (ceil($count / $val)) * 20;
	if ($sql->num_rows() < 1) {
		echo "0";
	}else{
		echo ($rating > 100) ? 100 : $rating;
	}
}else{
	redirect('/');
}
?>