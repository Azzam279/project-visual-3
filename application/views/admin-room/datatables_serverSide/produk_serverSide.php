<?php
	/**
		* Script:    DataTables server-side script for PHP 5.2+ and MySQL 4.1+
		* Notes:     Based on a script by Allan Jardine that used the old PHP mysql_* functions.
		*            Rewritten to use the newer object oriented mysqli extension.
		* Copyright: 2010 - Allan Jardine (original script)
		*            2012 - Kari Söderholm, aka Haprog (updates)
		* License:   GPL v2 or BSD (3-point)
	*/
	mb_internal_encoding('UTF-8');
	
	/**
		* Array of database columns which should be read and sent back to DataTables. Use a space where
		* you want to insert a non-database field (for example a counter or static image)
	*/
	$aColumns = array( 'no_produk', 'nama_produk', 'no_kategori', 'no_subkategori', 'harga_produk', 'diskon_produk', 'berat_produk', 'stok_produk', 'no_brand','dilihat', 'terjual', 'tgl' ); //Kolom Pada Tabel
	
	// Indexed column (used for fast and accurate table cardinality)
	$sIndexColumn = 'no_produk';
	
	// DB table to use
	$sTable = 'produk'; // Nama Tabel
	
	include_once("connection.php");
	
	// Input method (use $_GET, $_POST or $_REQUEST)
	$input =& $_POST;

	$gaSql['charset']  = 'utf8';
	
	/**
		* MySQL connection
	*/
	$db = new mysqli($gaSql['server'], $gaSql['user'], $gaSql['password'], $gaSql['db'], $gaSql['port']);
	if (mysqli_connect_error()) {
		die( 'Error connecting to MySQL server (' . mysqli_connect_errno() .') '. mysqli_connect_error() );
	}
	
	if (!$db->set_charset($gaSql['charset'])) {
		die( 'Error loading character set "'.$gaSql['charset'].'": '.$db->error );
	}
	
	
	/**
		* Paging
	*/
	$sLimit = "";
	if ( isset( $input['iDisplayStart'] ) && $input['iDisplayLength'] != '-1' ) {
		$sLimit = " LIMIT ".intval( $input['iDisplayStart'] ).", ".intval( $input['iDisplayLength'] );
	}
	
	
	/**
		* Ordering
	*/
	$aOrderingRules = array();
	if ( isset( $input['iSortCol_0'] ) ) {
		$iSortingCols = intval( $input['iSortingCols'] );
		for ( $i=0 ; $i<$iSortingCols ; $i++ ) {
			if ( $input[ 'bSortable_'.intval($input['iSortCol_'.$i]) ] == 'true' ) {
				$aOrderingRules[] =
                "`".$aColumns[ intval( $input['iSortCol_'.$i] ) ]."` "
                .($input['sSortDir_'.$i]==='asc' ? 'asc' : 'desc');
			}
		}
	}
	
	if (!empty($aOrderingRules)) {
		$sOrder = " ORDER BY ".implode(", ", $aOrderingRules);
		} else {
		$sOrder = "";
	}
	
	
	/**
		* Filtering
		* NOTE this does not match the built-in DataTables filtering which does it
		* word by word on any field. It's possible to do here, but concerned about efficiency
		* on very large tables, and MySQL's regex functionality is very limited
	*/
	$iColumnCount = count($aColumns);
	
	if ( isset($input['sSearch']) && $input['sSearch'] != "" ) {
		$aFilteringRules = array();
		for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
			if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' ) {
				$aFilteringRules[] = "`".$aColumns[$i]."` LIKE '%".$db->real_escape_string( $input['sSearch'] )."%'";
			}
		}
		if (!empty($aFilteringRules)) {
			$aFilteringRules = array('('.implode(" OR ", $aFilteringRules).')');
		}
	}
	
	// Individual column filtering
	for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
		if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' && $input['sSearch_'.$i] != '' ) {
			$aFilteringRules[] = "`".$aColumns[$i]."` LIKE '%".$db->real_escape_string($input['sSearch_'.$i])."%'";
		}
	}
	
	if (!empty($aFilteringRules)) {
		$sWhere = " WHERE ".implode(" AND ", $aFilteringRules);
		} else {
		$sWhere = "";
	}
	
	
	/**
		* SQL queries
		* Get data to display
	*/
	$aQueryColumns = array();
	foreach ($aColumns as $col) {
		if ($col != ' ') {
			$aQueryColumns[] = $col;
		}
	}
	
	$sQuery = "
    SELECT SQL_CALC_FOUND_ROWS `".implode("`, `", $aQueryColumns)."`
    FROM `".$sTable."`".$sWhere.$sOrder.$sLimit;
	
	$rResult = $db->query( $sQuery ) or die($db->error);
	
	// Data set length after filtering
	$sQuery = "SELECT FOUND_ROWS()";
	$rResultFilterTotal = $db->query( $sQuery ) or die($db->error);
	list($iFilteredTotal) = $rResultFilterTotal->fetch_row();
	
	// Total data set length
	$sQuery = "SELECT COUNT(`".$sIndexColumn."`) FROM `".$sTable."`";
	$rResultTotal = $db->query( $sQuery ) or die($db->error);
	list($iTotal) = $rResultTotal->fetch_row();
	
	
	/**
		* Output
	*/
	$output = array(
    "sEcho"                => intval($input['sEcho']),
    "iTotalRecords"        => $iTotal,
    "iTotalDisplayRecords" => $iFilteredTotal,
    "aaData"               => array(),
	);
	
	// Looping Data
    date_default_timezone_set("Asia/Singapore");
	while ( $aRow = $rResult->fetch_assoc() ) {
		$row = array();
		for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
			$row[] = $aRow[ $aColumns[$i] ];
		}

		//mengambil no_kategori dari table kategori
        $data1 = array("no_kategori" => $aRow['no_kategori']);
        $get_kat = $this->model1->selectWhere("kategori", $data1);
        $kategori2 = $get_kat->result()[0]->nama_kategori;
        //mengambil no_subkategori dari table subkategori
        if ($aRow['no_subkategori'] == 999) {
        	$subkategori2 = "Tidak ada Subkategori";
        }else{
        	$data2 = array("no_subkategori" => $aRow['no_subkategori']);
	        $get_sub = $this->model1->selectWhere("subkategori", $data2);
	        $subkategori2 = $get_sub->result()[0]->nama_subkategori;
        }
        //mengambil no_brand dari table brand
        if ($aRow['no_brand'] == 0) {
        	$brand2 = "Tidak ada Brand";
        }else{
	        $data3 = array("no_brand" => $aRow['no_brand']);
	        $get_brn = $this->model1->selectWhere("brand", $data3);
	        $brand2 = $get_brn->result()[0]->nama_brand;
        }

        $tgl = date("d-m-Y H:i:s", $aRow['tgl']);
        $harga = "Rp ".number_format($aRow['harga_produk'],0,",",".");
		$namaProduk = "$aRow[nama_produk]<br><p></p>
					<p><small>
					Brand: <b>$brand2</b><br>
					Terjual: $aRow[terjual]<br>
					Dilihat: $aRow[dilihat]<br>
					Date: $tgl
					</small></p>";

		$btn = "<a class='btn btn-xs btn-warning' data-toggle='tooltip' data-placement='bottom' title='Edit' href='".base_url("admin/produk/$aRow[no_produk]")."'><i class='glyphicon glyphicon-edit'></i></a>
                <button class='btn btn-xs btn-danger' data-toggle='tooltip' data-placement='bottom' title='Delete' onclick='hapus($aRow[no_produk],\"$aRow[nama_produk]\")'><i class='glyphicon glyphicon-remove'></i></button>";

		$row = array( $aRow['no_produk'], $namaProduk, $kategori2, $subkategori2, $harga, $aRow['diskon_produk']."%", $aRow['berat_produk']." gram", $aRow['stok_produk'], $btn );
		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
	
?>