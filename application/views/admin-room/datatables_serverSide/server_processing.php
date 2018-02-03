<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'produk';

// Table's primary key
$primaryKey = 'no_produk';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => 'no_produk', 'dt' => 0 ),
	array( 'db' => 'nama_produk', 'dt' => 1 ),
	array( 'db' => 'no_kategori', 'dt' => 2 ),
	array( 'db' => 'no_subkategori', 'dt' => 3 ),
	array( 'db' => 'harga_produk', 'dt' => 4 ),
	array( 'db' => 'diskon_produk', 'dt' => 5 ),
	array( 'db' => 'berat_produk', 'dt' => 6 ),
	array( 'db' => 'stok_produk', 'dt' => 7 ),
	array(
        'db'        => null,
        'dt'        => null,
        'formatter' => function( $d, $row ) {
            return '<a>test</a>';
    }
);

// SQL server connection information
$sql_details = array(
	'user' => 'root',
	'pass' => '',
	'db'   => 'toko_komputer',
	'host' => 'localhost'
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( 'ssp.class.php' );

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);


