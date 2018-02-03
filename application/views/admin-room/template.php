<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Administrator</title>
	<?php $this->load->view("admin-room/source-css"); ?>
    <link rel="stylesheet" href="<?php echo base_url("assets/admin/css/jquery-ui.min.css"); ?>">
</head>
<body class="hold-transition skin-blue sidebar-mini">
	
<div class="wrapper">

<?php
$this->load->view("admin-room/header");
$this->load->view("admin-room/sidebar");

$title = (!empty($id)) ? "Setting Template" : "Daftar Template";
?>

<section class="content-wrapper">
    <section class="content-header">
        <h1>Template
            <small>Control panel</small>
        </h1>
    </section>
    <section class="content">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $title; ?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <?php
            if (!empty($id)) {
                $this->load->view("admin-room/setting-template");
            }else{
            ?>
            <div class="box-body">
                <table class="table table-striped table-hover table-condensed">
                    <thead>
                        <tr>
                            <th>Nama Template</th>
                            <th>Setting Template</th>
                            <th>Aktif</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Template 1</td>
                            <td><a href="<?php echo base_url("admin/template/1"); ?>">Setting</a></td>
                            <td><input type="checkbox" name="aktif"></td>
                            <td><button class="btn btn-default">Save</button></td>
                        </tr>
                        <tr>
                            <td>Template 2</td>
                            <td><a href="#">Setting</a></td>
                            <td><input type="checkbox" name="aktif"></td>
                            <td><button class="btn btn-default">Save</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <form action="" method="post" class="form-inline">
                    <div class="form-group">
                        <label class="control-label">
                            Buat Template Baru : 
                        </label>
                        <input type="text" name="nama_template" class="form-control" placeholder="Masukkan Nama Template" size="40">
                        <button type="submit" name="tambah" value="tambah" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
                    </div>
                </form>
            </div>
            <?php
            }
            ?>
        </div>
    </section>
</section>

<?php
$this->load->view("admin-room/footer");
$this->load->view("admin-room/control-sidebar");
?>

</div><!-- ./wrapper -->

<?php $this->load->view("admin-room/source-js"); ?>
<script src="<?php echo base_url("assets/admin/js/angular.min.js"); ?>"></script>
<script>
    var app = angular.module('set_template', []);
    app.controller('TempCtrl', function($scope) {
        $scope.wm1_1 = true;
        $scope.wm1_2 = false;
        $scope.klik_menu1 = function(val) {
            if (val == "normal") {
                $scope.wm1_1 = true;
                $scope.wm1_2 = false;
            }else{
                $scope.wm1_1 = false;
                $scope.wm1_2 = true;
            }
        }

        $scope.wm2_1 = true;
        $scope.wm2_2 = false;
        $scope.klik_menu2 = function(val) {
            if (val == "normal") {
                $scope.wm2_1 = true;
                $scope.wm2_2 = false;
            }else{
                $scope.wm2_1 = false;
                $scope.wm2_2 = true;
            }
        }

        $scope.wk1 = true;
        $scope.wk2 = false;
        $scope.klik_menu3 = function(val) {
            if (val == "normal") {
                $scope.wk1 = true;
                $scope.wk2 = false;
            }else{
                $scope.wk1 = false;
                $scope.wk2 = true;
            }
        }

        $scope.wf1 = true;
        $scope.wf2 = false;
        $scope.klik_menu4 = function(val) {
            if (val == "normal") {
                $scope.wf1 = true;
                $scope.wf2 = false;
            }else{
                $scope.wf1 = false;
                $scope.wf2 = true;
            }
        }
    });
</script>
</body>
</html>