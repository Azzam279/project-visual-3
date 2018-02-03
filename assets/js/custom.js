//hostname
var host = document.getElementById("host").value;

$(document).ready(function() {

    //Close alert
    $('.page-alert .close').click(function(e) {
        e.preventDefault();
        $(this).closest('.page-alert').fadeOut();
    });
    //close alert dalam 4.5 detik
    $('.page-alert').delay(4500).fadeOut();

    // Menu menjadi fixed ketika di scroll down
    var stickyNavTop = $('.nav-fixed').offset().top; 
    var stickyNav = function(){
        var scrollTop = $(window).scrollTop();  
        // Kondisi jika discroll maka menu akan selalu diatas, dan sebaliknya        
        if (scrollTop > 30) {
            $('.nav-fixed').addClass("hide-menu1");
            $('.hamburger').css({"top":"20px"});
            $('#dropdown-pesanan').css("position","relative");
        } else if (scrollTop < 2) {
            $('.nav-fixed').removeClass("hide-menu1");
            $('.hamburger').css({"top":"47px", "transition":"top .5s ease-in-out"});
            $('#dropdown-pesanan').css("position","fixed");
        }
    };
    // Jalankan fungsi
    stickyNav();
    $(window).scroll(function() {
        stickyNav();
    });

    //Tooltip
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })

    //max karakter pd contact
    $('#characterLeft').text('400 karakter tersisa');
    $('#message').keydown(function () {
        var max = 400;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft').html('<font color="red">Anda telah mencapai batas maksimal!</font>');
            $('#characterLeft').addClass('red');
            $('#btnContactUs').attr('disabled','disabled');            
        }else{
            var ch = max - len;
            $('#characterLeft').text(ch + ' karakter tersisa');
            $('#btnContactUs').removeAttr('disabled');
            $('#characterLeft').removeClass('red');            
        }
    });  
});

// Menu Kategori
$(document).ready(function () {
    var trigger = $('.hamburger'),
      overlay = $('.overlay'),
     isClosed = false;

    trigger.click(function () {
      hamburger_cross();      
    });

    overlay.click(function () {
        overlay.hide();
        trigger.removeClass('is-open');
        trigger.addClass('is-closed');
        isClosed = false;
        $('#wrapper2').toggleClass('toggled');
    });

    function hamburger_cross() {
      if (isClosed == true) {          
        overlay.hide();
        trigger.removeClass('is-open');
        trigger.addClass('is-closed');
        isClosed = false;
      } else {
        overlay.show();
        trigger.removeClass('is-closed');
        trigger.addClass('is-open');
        isClosed = true;
      }
    }

    $('[data-toggle="offcanvas"]').click(function () {
        $('#wrapper2').toggleClass('toggled');
    });

    //zoom image detail-produk ketika di hover
    //initiate the plugin and pass the id of the div containing gallery images 
    $("#zoom_01").elevateZoom({
        constrainType:"height", 
        constrainSize:400, 
        lensFadeIn: 500, 
        lensFadeOut: 500,
        containLensZoom: true, 
        gallery:'gallery_01', 
        cursor: 'crosshair',
        zoomWindowFadeIn: 500,
        zoomWindowFadeOut: 750, 
        galleryActiveClass: "active"});
    //pass the images to Fancybox 
    $("#zoom_01").bind("click", function(e) { var ez = $('#zoom_01').data('elevateZoom');  $.fancybox(ez.getGalleryList()); return false; });

    //Tab bootstrap
    $('#myTabs a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    })

    // Show/Hide Sticky "Go to top" button
    $(window).scroll(function(){
        if($(this).scrollTop()>200){
            $(".gotop").fadeIn(1000);
        }
        else{
            $(".gotop").fadeOut(1000);
        }
    });
    // Scroll Page to Top when clicked on "go to top" button
    $(".gotop").click(function(event){
        event.preventDefault();

        $.scrollTo('#gototop', 1500, {
            easing: 'easeOutCubic'
        });
    });

    $("#contactForm").submit(function() {
        if ( !$("#name").val() || !$("#email").val() || !$("#subject").val() || !$("#message").val() ) {
            $("#pesan-validasi").html("<div class='alert alert-warning'>Semua Kolom Input Harus di-Isi!</div>");
        }else{
            $.ajax({
                url: $(this).attr('action') + "?ajax=true",
                type: 'POST',
                data: $(this).serialize(),
                beforeSend: function() {
                    $("#btn-contact").addClass("m-progress");
                },
                success: function(hasil) {
                    $("#btn-contact").removeClass("m-progress");
                    $("#pesan-validasi").html(hasil);
                    $("#name").val("");
                    $("#email").val("");
                    $("#subject").val("");
                    $("#message").val("");
                    $("#alert-slideUp").delay(3000).slideUp();
                },
                error: function() {
                    alert("Error!");
                }
            });
        }
        return false;
    });

    //proses input form chatting
    $("#chatting_form").submit(function() {
        var nama = $("#chatNama").val();
        var email = $("#chatNama").val();
        var telp = $("#chatTelp").val();

        if (nama=="" || email=="" || telp=="") { //jika kolom input ada yg kosong maka tampilkan validasi
            $("#validasi_chatting").html('<div class="alert alert-warning page-alert"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><i class="fa fa-exclamation-triangle"></i> Semua kolom input harus di isi!</div>');
        }else{ //jika semua kolom input di isi maka jalankan script dibawah ini
            $.ajax({
                url: $(this).attr('action') + "?chatting=true",
                type: 'POST',
                data: $(this).serialize(),
                beforeSend: function() {
                    $("#btn-chat-lanjut").attr("disabled","disabled");
                    $("#btn-chat-lanjut i.fa").removeClass("fa-arrow-right");
                    $("#btn-chat-lanjut i.fa").addClass("fa-refresh fa-spin");
                },
                success: function(hasil) {
                    if (hasil=="Sukses") { //jika proses sukses
                        function tampilChat() {
                            $("#chatting_form").hide();
                            $("#tampil_temp_box_chat").show();
                        }
                        setTimeout(tampilChat, 3000);
                    }else{ //jika gagal
                        $("#validasi_chatting").html('<div class="alert alert-danger page-alert"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><i class="fa fa-exclamation-triangle"></i> Terjadi kesalahan! silakan coba lagi.</div>');
                        $("#btn-chat-lanjut").removeAttr("disabled");
                        $("#btn-chat-lanjut i.fa").removeClass("fa-refresh fa-spin");
                        $("#btn-chat-lanjut i.fa").addClass("fa-arrow-right");
                        //Close alert
                        $('.page-alert .close').click(function(e) {
                            e.preventDefault();
                            $(this).closest('.page-alert').slideUp();
                        });
                    }
                },
                error: function() {
                    alert("Error: Terjadi kesalahan!");
                }
            });
        }
        //Close alert
        $('.page-alert .close').click(function(e) {
            e.preventDefault();
            $(this).closest('.page-alert').slideUp();
        });

        return false;
    });
    
    //proses input pesan chat
    $("#inputChatForm").submit(function() {
        var pesan = $("#input_chat").val();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: 'pesan=' + pesan,
            beforeSend: function() {
                $("#btn-chat").addClass("m-progress");
            },
            success: function(hasil) {
                $("#btn-chat").removeClass("m-progress");
                //html5 audio play
                var suara = document.getElementById("suara_chat");
                suara.play();
                if (hasil == "Sukses") {
                    //kosongkan kolom input chat
                    $("#input_chat").val("");
                    function posisiBawah() {
                        //membuat posisi scroll berada di bawah
                        var box = document.getElementById("msg_container_base");
                        box.scrollTop = box.scrollHeight;
                    }
                    setTimeout(posisiBawah, 1000);  
                }else if (hasil == "Kosong") {
                    window.location = host;
                }else if (hasil == "Banned") {
                    //kosongkan kolom input chat
                    $("#input_chat").val("");
                    //disable kolom input chat n tombol kirim
                    $("#input_chat").attr("disabled","disabled");
                    $("#btn-chat").attr("disabled","disabled");
                    //tampilkan validasi banned
                    $("#validasi_banned").html('<center><div class="label label-danger">Anda di Banned oleh admin!</div></center>');
                }else{
                    return false;
                }
            },
            error: function() {
                alert("Terjadi kesalahan!");
            }
        });

        return false;
    });

});

$(document).on('click', '.panel-heading span.icon_minim', function (e) {
    var $this = $(this);
    if (!$this.hasClass('panel-collapsed')) {
        $this.parents('.panel').find('.panel-body').slideUp();
        $this.parents('.panel').find('.panel-footer').slideUp();
        $this.addClass('panel-collapsed');
        $this.removeClass('glyphicon-minus').addClass('glyphicon-plus');
    } else {
        $this.parents('.panel').find('.panel-body').slideDown();
        $this.parents('.panel').find('.panel-footer').slideDown();
        $this.removeClass('panel-collapsed');
        $this.removeClass('glyphicon-plus').addClass('glyphicon-minus');
        //membuat posisi scroll berada di bawah
        var box = document.getElementById("msg_container_base");
        box.scrollTop = box.scrollHeight;
    }
});
$(document).on('focus', '.panel-footer input.chat_input', function (e) {
    /*var $this = $(this);
    if ($('#minim_chat_window').hasClass('panel-collapsed')) {
        $this.parents('.panel').find('.panel-body').slideDown();
        $('#minim_chat_window').removeClass('panel-collapsed');
        $('#minim_chat_window').removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }*/
    //membuat posisi scroll berada di bawah
    var box = document.getElementById("msg_container_base");
    box.scrollTop = box.scrollHeight;
});
$(document).on('click', '#new_chat', function (e) {
    var size = $( ".chat-window:last-child" ).css("margin-left");
     size_total = parseInt(size) + 400;
    alert(size_total);
    var clone = $( "#chat_window_1" ).clone().appendTo( ".container" );
    clone.css("margin-left", size_total);
});
$(document).on('click', '.icon_close', function (e) {
    //$(this).parent().parent().parent().parent().remove();
    $( "#chat_window_1" ).remove();
});

//proses mulai chatting, jika admin tdk online maka tdk bisa chatting
function mulaiChatting() {
    $("#btn-mulaiChat").hide();
    $("#chatting-loader").show();
    $.ajax({
        url: host + 'chatting/mulai_chat',
        type: 'GET',
        data: 'start_chat=true',
        success: function(hasil) {
            function AnimasiWaiting() {
                $("#temp-chatting").html(hasil);
            }
            setTimeout(AnimasiWaiting, 3000);
        },
        error: function() {
            alert("Terjadi kesalahan!");
        }
    });
}

//tampilkan pesan chatting
function pesan_chatting() {
    $("#msg_container_base").load(host+"chatting/pesan");
    //var box = document.getElementById("msg_container_base");
    //box.scrollTop = box.scrollHeight;
}
var cek_nick = document.getElementById("cek_nick");
if (cek_nick.value != "") { //jika session nama/nick tidak kosong
    setInterval(pesan_chatting, 1000);
}

//direct ke halaman cek pesanan
function cek_pesanan(url) {
    var nmr = $("#nmr_trans").val();
    if (nmr == "") {
        alert("Nomor Transaksi harus di isi!");
    }else{
        window.location = url+"/"+nmr;
    }
}

//update notif pd table order_produk
function updateInfo(jml) {
    if (jml != 0) {
        $.ajax({
            url: host+'ajax/index/ajax/update-info-orderproduk',
            type: 'GET',
            data: 'jumlah='+jml,
            error: function() {
                alert("error!");
            }
        });
    }
}

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