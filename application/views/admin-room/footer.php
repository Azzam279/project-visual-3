<input type="hidden" id="root_name" value="<?php echo base_url(); ?>">

<footer class="main-footer">
	<div class="pull-right hidden-xs">
	  
	</div>
	<strong>Copyright &copy; 2015 <a href="http://almsaeedstudio.com">Azzam</a>.</strong> All rights reserved.
</footer>

<!-- Modal Upload Foto -->
<div class="modal fade" id="uploadFotoModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top:110px;">
      <form action="<?php echo htmlspecialchars(base_url("crud/upload_foto")); ?>" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-picture-o"></i> Upload Foto</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
        	<label class="col-md-offset-1 col-md-2">Upload : </label>
        	<div class="col-md-7">
        		<input type="file" name="upload_foto" class="form-control" accept="image/jpg,image/jpeg,image/png" required>
        	</div>
        	<div class="clearfix"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" name="btn_upload_foto" value="btn_upload_foto" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php
//validasi
if ($this->session->flashdata('success')) {
    echo "<div id='info' class='alert alert-success page-alert'>
    <i class='glyphicon glyphicon-ok'></i> <b style='color:black;'>".$this->session->flashdata('success')."</b></div>";
}
if ($this->session->flashdata('error')) {
    echo "<div id='info' class='alert alert-danger page-alert'>
    <i class='glyphicon glyphicon-remove'></i> <b style='color:black;'>".$this->session->flashdata('error')."</b></div>";
}
if ($this->session->flashdata('warning')) {
    echo "<div id='info' class='alert alert-warning page-alert'>
    <i class='glyphicon glyphicon-warning-sign'></i> <b style='color:black;'>".$this->session->flashdata('warning')."</b></div>";
}
?>