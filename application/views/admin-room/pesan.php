<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Administrator</title>
	<?php $this->load->view("admin-room/source-css"); ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	
	<div class="wrapper">

    <?php
    $this->load->view("admin-room/header");
    $this->load->view("admin-room/sidebar");
    ?>
<section class="content-wrapper">
    <section class="content-header">
        <h1>Pesan
            <small>Control panel</small>
        </h1>
    </section>
    <section class="content">
        <div class="col-md-10 col-lg-10">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Pesan</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <ul class="chat">
                        <?php
                        foreach ($pesan->result() as $contact) {
                        ?>
                        <li class="left clearfix"><span class="chat-img pull-left">
                            <img src="<?php echo base_url("image/admin/avatar_2x.png"); ?>" alt="User Avatar" class="img-circle" style="width:60px;" />
                        </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font"><?php echo ucfirst($contact->nama); ?></strong> <small class="pull-right text-muted">
                                        <span class="glyphicon glyphicon-time"></span> <?php echo time_since($contact->tgl); ?></small>
                                </div>
                                <p>
                                    <p>Subjek : <?php echo $contact->subjek; ?></p><br>
                                    <p><?php echo $contact->pesan; ?></p>
                                    <p>
                                    <br>
                                        <i>Email : <a href="mailto:#"><?php echo $contact->email; ?></a></i>
                                    </p>
                                </p>
                            </div>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                    <div class="clearfix"></div>
                    <div style="height:40px;">
                    <?php echo $halaman ?> <!--Memanggil variable pagination-->
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
    <?php
    $this->load->view("admin-room/footer");
    $this->load->view("admin-room/control-sidebar");
    ?>

  </div><!-- ./wrapper -->

<?php
function time_since($original) {
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
?>

<?php $this->load->view("admin-room/source-js"); ?>
</body>
</html>