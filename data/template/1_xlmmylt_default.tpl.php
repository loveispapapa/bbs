<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?><?php
$return = <<<EOF


<style>
.tl th,.tl .icn, .tl .by, .tl .o, .tl .num {vertical-align: top;}
.tl th .tps {display:none;}
    
EOF;
 if($xlmmstyle) { 
$return .= <<<EOF

.tl .by {line-height: 14px;}
body .tl th .xst {font-size:  {$xlmmstylefs}px;color: {$xlmmstylec};font-family: {$xlmmstylef};line-height: 22px;}
.tl .by cite {display: block;color: #999;}
.tl .by em {display: block;margin: 5px 0 0 0;font-size: 12px;font-family: Arial,Helvetica,sans-serif;}
.tl .num {padding-top: 15px;}
.tl .icn img{padding-top: 2px;}
.tl th, .tl td {padding: 10px 0;border-bottom: 1px dashed #C2D5E3;}
  
EOF;
 } 
$return .= <<<EOF

.thsum {margin-right: 20px;padding-top:{$thsumt}px;text-overflow: ellipsis;color: #666;line-height: 18px;}
.xlmm_pic {margin: {$xlmm_pict}px 0 0 0;white-space: nowrap;position: relative;}
.xlmm_pic .nums {position: absolute;left: 0;top: 0;color: #fff;background: #000;background: rgba(0,0,0,0.5);height: 26px;line-height: 26px;padding: 0 5px;padding-left: 25px;}
.numicn.icon-27 {width: 16px;height: 13px;background-position: -84px -987px;}
.numicn {background-image: url("source/plugin/xlmmylt/num.png");background-repeat: no-repeat;display: inline-block;*display: inline;*zoom: 1;}
.xlmm_pic .nums .icon-27 {position: absolute;left: 6px;top: 7px;}
.xlmm_pic a {margin-right: 10px;overflow:hidden;display:inline-block;*display:inline;*zoom:1;бн}
</style>

    
EOF;
 if($xlmmyc) { 
$return .= <<<EOF

<script src="source/plugin/xlmmylt/jquery-1.8.3.min.js" type="text/javascript"  type="text/javascript"></script>
 <script type="text/javascript"> var jQ = jQuery.noConflict();</script>
  
EOF;
 } 
$return .= <<<EOF

<script src="source/plugin/xlmmylt/lazyload.js" type="text/javascript"  type="text/javascript"></script>
  <script type="text/javascript">
        jQuery(function () {jQuery("img.lazy").lazyload({effect : "fadeIn"
        });});</script>




EOF;
?>