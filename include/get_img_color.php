<?php

$color = color_index($img);
$color=implode(';',$color);
function color_index($source_src,$index_colors=1)
{ 
$size = getimagesize($source_src); 
$image_type=file_ext($source_src);
switch ($image_type)
{
case 'gif': $source = @imagecreatefromgif($source_src); break;
default:case 'jpg': $source = @imagecreatefromjpeg($source_src); break;
case 'png': $source = @imagecreatefrompng($source_src); break;
} 
$INDEX=array();
$I=array();
$b = 1;
$size1 = $size[1]*2;
$size2 = $size1+50;
$size0 = $size[0]*2; 
for($y=0;$y<=$size[1]-1;$y++)
{ 
for($x=0;$x<=$size[0]-1;$x++)
{
$color=ImageColorAt($source, $x, $y);
$rgb_arr_0=imagecolorsforindex($source, $color);
$rgb_arr[0]=$rgb_arr_0['red'];
$rgb_arr[1]=$rgb_arr_0['green'];
$rgb_arr[2]=$rgb_arr_0['blue'];
$I[$color]++;
$INDEX[$color]=rgb2hex2rgb(implode('.',$rgb_arr));
$b++; 
}
$ngb = 0; 
}
$out_0=array();
$out=array();
$outer = array(); 
foreach($INDEX as $key=>$color_hex){
$out_0[$I[$key]][]=$color_hex;
} 
foreach($out_0 as $incolor){
    $out[]=implode(',',$incolor);
} 
$out=implode(',',$out);
$out=explode(',',$out);
$out_0=array();
$maskcolor = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F");
$maskcolor2 = array("0", "4", "8",  "C");
foreach ($out as $key => $out_mask){
    $out_mask =  substr($out_mask, 1);
    $outearr = str_split($out_mask, 1); 
$keyw = array_search($outearr[0], $maskcolor)+1;
$outkey[0] = ceil($keyw/4)-1;
$outval[0] =  $maskcolor2[$outkey[0]];
$outval[1] =  $outval[0]; 
$keyw = array_search($outearr[2], $maskcolor)+1;
$outkey[2] = ceil($keyw/4)-1;
$outval[2] =  $maskcolor2[$outkey[2]];
$outval[3] =  $outval[2]; 
$keyw = array_search($outearr[4], $maskcolor)+1;
$outkey[4] = ceil($keyw/4)-1;
$outval[4] =  $maskcolor2[$outkey[4]];
$outval[5] =  $outval[4];
$outvalue[$key] = '#'.$outval[0].$outval[1].$outval[2].$outval[3].$outval[4].$outval[5];
}
$out = $outvalue;
$outcount = array_count_values($out);
arsort($outcount);
reset($outcount);
while (list($key, $val) = each($outcount)) {
   $outers[] = $key;
   $outersval[] = $val;
} 
for($i=sizeof($outers);$i>sizeof($outers)-$index_colors;$i--)
{
    $out_0[]=$outer[$i];
}
$outs = array_chunk($outers, $index_colors);
$outsval = array_chunk($outersval, $index_colors);

foreach ($outs[0] as $key=>$outer) {
//$hex = $outer;
//list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");

//echo "<style>.new_color_layer{
//    opacity: 1;
//    background: $hex url($img2);
//background-blend-mode: hard-light;
 
//}
//    </style>";
echo $outer;

}
return $outs[0];
}
function newColorMask($out_mask){
$maskcolor = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F");
$maskcolor2 = array("0", "4", "8", "C");
$out_mask =  substr($out_mask, 1);
$outearr = str_split($out_mask, 1);
$keyw = array_search($outearr[0], $maskcolor)+1;
$outkey[0] = ceil($keyw/4)-1;
$outval[0] =  $maskcolor2[$outkey[0]];
$outval[1] =  $outval[0];
$keyw = array_search($outearr[2], $maskcolor)+1;
$outkey[2] = ceil($keyw/4)-1;
$outval[2] =  $maskcolor2[$outkey[2]];
$outval[3] =  $outval[2];
$keyw = array_search($outearr[4], $maskcolor)+1;
$outkey[4] = ceil($keyw/4)-1;
$outval[4] =  $maskcolor2[$outkey[4]];
$outval[5] =  $outval[4];
$outvalue = '#'.$outval[0].$outval[1].$outval[2].$outval[3].$outval[4].$outval[5];
return $outvalue;
}
function file_ext($file)
{
$image_type_arr=explode("/",$file);
$image_type_arr=explode(".",$image_type_arr[sizeof($image_type_arr)-1]);
return strtolower((strlen($image_type_arr[1])>3)?'jpg':$image_type_arr[1]);
}
function rgb2hex2rgb($c)
{
if(!$c) return false;
$c = trim($c);
$out = false;
if(preg_match("/^[0-9ABCDEFabcdef\#]+$/i", $c)){
$c = str_replace('#','', $c);
$l = strlen($c) == 3 ? 1 : (strlen($c) == 6 ? 2 : false);
if($l){
unset($out);
$out[0] = $out['r'] = $out['red'] = hexdec(substr($c, 0,1*$l));
$out[1] = $out['g'] = $out['green'] = hexdec(substr($c, 1*$l,1*$l));
$out[2] = $out['b'] = $out['blue'] = hexdec(substr($c, 2*$l,1*$l));
}else $out = false;
}elseif (preg_match("/^[0-9]+(,| |.)+[0-9]+(,| |.)+[0-9]+$/i", $c)){
$spr = str_replace(array(',',' ','.'), ':', $c);
$e = explode(":", $spr);
if(count($e) != 3) return false;
$out = '#';
for($i = 0; $i<3; $i++)
$e[$i] = dechex(($e[$i] <= 0)?0:(($e[$i] >= 255)?255:$e[$i]));
for($i = 0; $i<3; $i++)
$out .= ((strlen($e[$i]) < 2)?'0':'').$e[$i];
$out = strtoupper($out);
}else $out = false;
return $out;
}
?>