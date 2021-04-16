<?php

function scale_image($p,$mw='',$mh='',$c='',$s='') { // path max_width max_height
    if(list($w,$h) = @getimagesize($p)) {
    foreach(array('w','h') as $v) { $m = "m{$v}";
        if(${$v} > ${$m} && ${$m}) { $o = ($v == 'w') ? 'h' : 'w';
        $r = ${$m} / ${$v}; ${$v} = ${$m}; ${$o} = ceil(${$o} * $r); } }
    return("<img src='{$p}' width='{$w}' height='{$h}' border=0 class='$c', style='$s'/>"); }
}
?>