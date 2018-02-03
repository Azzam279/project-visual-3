<?php

function label($label,$class="") {
	echo "<label class='control-label $class'>$label</label>";
}

function input_text($name,$value="",$placeholder="",$size,$extra="") {
	echo "<input type='text' name='$name' value='$value' class='form-control' placeholder='$placeholder' style='width:$size' $extra>";
}

function input_number($name,$value="",$placeholder="",$min="",$max="",$size) {
	echo "<input type='number' name='$name' value='$value' class='form-control' max='$max' min='$min' placeholder='$placeholder' style='width:$size'>";
}

function input_color($name,$value="",$size="",$extra="") {
	echo "<input type='color' name='$name' value='$value' class='form-control' style='width:$size' $extra>";
}


function button($type,$name,$value,$class="") {
	echo "<button type='$type' name='$name' value='$name' class='$class'>$value</button>";
}

function button_icon($type,$name,$value,$class="",$icon) {
	echo "<button type='$type' name='$name' value='$name' class='$class'><i class='$icon'></i> $value</button>";
}

?>