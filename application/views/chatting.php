<?php
//cek apakah ada session nick atau tidak
if (isset($_SESSION['nick'])) {
    $nick_chat = $_SESSION['nick'];
}else{
    $nick_chat = "";
}
echo "<input type='hidden' value='$nick_chat' id='cek_nick'>";
?>

<div id="chatting-wrapper">
    <div class="row chat-window col-xs-5 col-md-3" id="chat_window_1" style="margin-left:10px;">
        <div class="col-xs-12 col-md-12">
        	<div class="panel panel-info">
                <div class="panel-heading top-bar">
                    <div class="col-md-8 col-xs-8">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Chatting Room</h3>
                    </div>
                    <div class="col-md-4 col-xs-4" style="text-align: right;">
                        <a href="javascript:void(0)"><span id="minim_chat_window" class="glyphicon panel-collapsed glyphicon-plus icon_minim"></span></a>
                        <a href="javascript:void(0)"><span class="glyphicon glyphicon-remove icon_close" data-id="chat_window_1"></span></a>
                    </div>
                </div>
                <?php
                if (empty($_SESSION['nick'])) {
                ?>
                <div id="temp-chatting">
                    <div class="panel-body" id="msg_container_base">
                        <div style="margin:auto;text-align:center;line-height:250px;">
                            <button type="button" class="btn btn-info" id="btn-mulaiChat" onclick="mulaiChatting()">Mulai Chatting</button>
                            <i class="fa fa-spinner fa-spin fa-3x" id="chatting-loader"></i>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <!-- Panel Footer -->
                    </div>
                </div>
                <?php
                }else{
                ?>
                <div id="validasi_banned"></div>
                <div class="panel-body" id="msg_container_base">
                    <!-- Konten Chatting tampil disini -->
                </div>
                <div class="panel-footer">
                    <form action="<?php echo htmlspecialchars(base_url("chatting/kirim")); ?>" method="post" id="inputChatForm">
                    <div class="input-group">
                        <input id="input_chat" name="chat_pesan" type="text" maxlength="250" class="form-control input-sm chat_input" placeholder="Ketik pesan anda disini..." required />
                        <span class="input-group-btn">
                        <button class="btn btn-primary btn-sm" type="submit" id="btn-chat">Kirim</button>
                        </span>
                    </div>
                    </form>
                    <audio controls id="suara_chat">
                        <source src="<?php echo base_url("audio/chat.mp3"); ?>" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
                <?php
                }
                ?>
    		</div>
        </div>
    </div>
</div>