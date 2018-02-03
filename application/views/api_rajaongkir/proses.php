<?php
include_once("rajaongkir.php");

$raja = new rajaongkir();
if (isset($_GET['act'])) {
	switch ($_GET['act']) {
		case 'show_provinsi':
			$provinsi = $raja->showprovince();
			echo $provinsi;
			break;
		case 'show_kota':
			$idkota = $_GET['province'];
			$kota = $raja->showcity($idkota);
			echo $kota;
			break;
		case 'show_cost':
			$origin = $_GET['origin'];
			$destination = $_GET['destination'];
			$weight = $_GET['weight'];
			//parse json
			$cost = $raja->ongkir($origin,$destination,$weight);
			$data = json_decode($cost, true);
			for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
				echo "
				<div class='panel panel-default'>
					<div class='panel-heading' id='head$i'>
						<h4 class='panel-title'>
							<a role='button' data-toggle='collapse' data-parent='#accordion' href='#collapse$i'  aria-expanded='true'>".$data['rajaongkir']['results'][$i]['name']."</a>
						</h4>
					</div>
					<div id='collapse$i' class='panel-collapse collapse' role='tabpanel'>
						<div class='panel-body'>
							<table class='table table-hover'>
								<thead>
									<tr>
										<th></th>
										<th>Jenis Layanan</th>
										<th>ETD (hari)</th>
										<th>Ongkir</th>
									</tr>
								</thead>
								<tbody>
				";
				for ($j=0; $j < count($data['rajaongkir']['results'][$i]['costs']); $j++) {
					echo "
					<tr>
						<td><input type='radio' name='ongkir' value='".$data['rajaongkir']['results'][$i]['name'].", ".$data['rajaongkir']['results'][$i]['costs'][$j]['description']."|".$data['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['etd']."|".$data['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['value']."' id='$i$j'></td>
						<td><label for='$i$j' style='color:black;'>".$data['rajaongkir']['results'][$i]['costs'][$j]['description']."</label></td>
						<td>".$data['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['etd']."</td>
						<td>Rp ".number_format($data['rajaongkir']['results'][$i]['costs'][$j]['cost'][0]['value'])."</td>
					</tr>
					";
				}
				echo "
								</tbody>
							</table>
						</div>
					</div>
				</div>";
			}
			//end of parse json
			break;
	}
}
?>