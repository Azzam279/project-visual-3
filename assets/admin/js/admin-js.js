var root = document.getElementById("root_name").value;

$(document).ready(function() {

    //Close alert
    $('.page-alert .close').click(function(e) {
        e.preventDefault();
        $(this).closest('.page-alert').slideUp();
    });

});

//Hanya boleh Diisi dengan huruf
function isNumberKeyHuruf(evt)
  {
     var charCode = (evt.which) ? evt.which : event.keyCode
     if ((charCode < 65) && (charCode != 32))
        return false;        
     return true;
  }

//Hanya boleh Diisi dengan angka
function isNumberKeyAngka(evt)
  {
     var charCode = (evt.which) ? evt.which : event.keyCode
     if ((charCode >= 48) && (charCode <= 57))
        return true;        
     return false;
  }

//clear notif
function clearNotif(id,link) {
  $.ajax({
    url: link,
    type: 'GET',
    data: 'id_prd='+id+'&url='+link
  });
}
