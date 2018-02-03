<div class="overlay"></div>

<!-- Sidebar -->
<nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper2" role="navigation">
    <ul class="nav sidebar-nav2">
        <li class="sidebar-brand2">
            <a href="<?php echo base_url(); ?>">
               KATEGORI
            </a>
        </li>
        <?php
        $kategori = $this->model1->selectData("kategori");
        foreach ($kategori->result() as $val_kat) {
        $nama_kat = ucwords(str_replace("_"," ",$val_kat->nama_kategori));
        $link_kat = $val_kat->nama_kategori;

        if ($val_kat->tipe == "single") {
        ?>
        <li>
            <a href="<?php echo base_url("$val_kat->nama_kategori"); ?>"><?php echo $nama_kat; ?></a>
        </li>
        <?php    
        }else{
        ?>
        <li class="dropdown">
          <a href="<?php echo base_url("$val_kat->nama_kategori"); ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $nama_kat; ?> <span class="caret"></span></a>
            <?php
            $data = array("no_kategori" => $val_kat->no_kategori);
            $subkat = $this->model1->selectWhere("subkategori", $data);
            ?>
          <ul class="dropdown-menu" role="menu">
            <?php
            echo "<li class='dropdown-header'>".ucwords($val_kat->nama_kategori)."</li>";
            foreach ($subkat->result() as $val_subkat) {
                $nama_sub = ucwords(str_replace("_"," ",$val_subkat->nama_subkategori));
                $link_sub = $val_subkat->nama_subkategori;
                echo "<li><a href='".base_url($link_kat."/".$link_sub)."'>$nama_sub</a></li>";
            }
            $subkat->free_result();
            ?>
          </ul>
        </li>
        <?php
        }
        }
        ?>
    </ul>
</nav>
<!-- /#sidebar-wrapper -->