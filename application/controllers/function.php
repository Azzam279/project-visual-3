<?php
function upload_gambar_resize($new_name,$file,$no) {
//direktori upload
$folder = $_SERVER['DOCUMENT_ROOT']."/Project-Visual-3/image/";
$docs = $_SERVER['DOCUMENT_ROOT']."/Project-Visual-3/image";
$dir  = "$docs/" . $_FILES[''.$file.'']['name'][''.$no.''];
$dir1 = "$docs/produk-sm/" . $new_name;
$dir2 = "$docs/produk-md/" . $new_name;
$dir3 =	"$docs/produk-lg/" . $new_name;

//simpan gambar dalam ukuran sebenarnya
move_uploaded_file($_FILES[''.$file.'']['tmp_name'][''.$no.''], $folder . $_FILES[''.$file.'']['name'][''.$no.'']);
ini_set("gd.jpeg_ignore_warning", 1);

//jika ukuran gambar lebih dari 400kb maka hentikan proses
//if ($_FILES[''.$file.'']['size'][''.$no.''] > 400000) {
//	$_SESSION['warning'] = 'Ukuran gambar terlalu besar! Max 400kb';
//	redirect('admin/produk');
//	exit();
//}

//identitas file asli
if ($_FILES[''.$file.'']['type'][''.$no.''] == "image/jpeg" || $_FILES[''.$file.'']['type'][''.$no.''] == "image/jpg" ) {
	//jika gagal mendapatkan identitas file asli
	if (!imagecreatefromjpeg($dir)) {
		$_SESSION['warning'] = 'Image error!';
		unlink($dir);
		redirect('admin/produk');
		exit();
	}else{
		$img_src = imagecreatefromjpeg($dir);
	}
	
}else if ($_FILES[''.$file.'']['type'][''.$no.''] == "image/png") {
	//jika gagal mendapatkan identitas file asli
	if (!imagecreatefrompng($dir)) {
		$_SESSION['warning'] = 'Image error!';
		unlink($dir);
		redirect('admin/produk');
		exit();
	}else{
		$img_src = imagecreatefrompng($dir);
	}
}
$src_width = imageSX($img_src);
$src_height = imageSY($img_src);

//Set ukuran gambar hasil perubahan
$dst_width1 = 196;
$dst_height1 = ($dst_width1/$src_width)*$src_height;
$dst_width2 = 376;
$dst_height2 = ($dst_width2/$src_width)*$src_height;
$dst_width3 = 800;
$dst_height3 = ($dst_width3/$src_width)*$src_height;

//proses perubahan ukuran
$img1 = imagecreatetruecolor($dst_width1, $dst_height1);
$img2 = imagecreatetruecolor($dst_width2, $dst_height2);
$img3 = imagecreatetruecolor($dst_width3, $dst_height3);
imagecopyresampled($img1, $img_src, 0, 0, 0, 0, $dst_width1, $dst_height1, $src_width, $src_height);
imagecopyresampled($img2, $img_src, 0, 0, 0, 0, $dst_width2, $dst_height2, $src_width, $src_height);
imagecopyresampled($img3, $img_src, 0, 0, 0, 0, $dst_width3, $dst_height3, $src_width, $src_height);

//simpan gambar
imagejpeg($img1, $dir1, 100);
imagejpeg($img2, $dir2, 100);
imagejpeg($img3, $dir3, 100);

//hapus gambar di memory komputer
imagedestroy($img_src);
imagedestroy($img1);
imagedestroy($img2);
imagedestroy($img3);
$remove_small = unlink("$dir");

$images = "";
$images .= $new_name.",";
return $new_name;

}
?>