<?php
// -----------------------------------------------------------------------------
// You should have received a copy of the CC0 Public Domain Dedication along
// -----------------------------------------------------------------------------
// You must specify SW and NE bounds of the area you wish to download. Zoom
// level is used to 'cluster' (i.e. grouping together) data in smaller zoom
// levels, in order to avoid having too many overlapping markers drawn.
// In the XML data returned you will notice the following fields:
//
// LAT, LON
// N= ship's name
// T= ship's type
// H= Heading in degrees
// S= Speed in knots multiplied by 10
// F= Ship's Flag
// M= MMSI number
// L= ship's length
// E= time elapsed since received, in minutes
// -----------------------------------------------------------------------------


// -----------------------------------------------------------------------------
// Write XML header
// -----------------------------------------------------------------------------

header('Content-Type: text/xml; charset=utf-8');


// -----------------------------------------------------------------------------
// Parse parameters
// -----------------------------------------------------------------------------

$bbox = explode(',', $_REQUEST['bbox']);

if (count($bbox) !== 4) {
    print '<POSITIONS></POSITIONS>';
    return;
}

$swX = round($bbox[0] * 10000) / 10000;
$swY = round($bbox[1] * 10000) / 10000;
$neX = round($bbox[2] * 10000) / 10000;
$neY = round($bbox[3] * 10000) / 10000;


// -----------------------------------------------------------------------------
// Fetch data
// -----------------------------------------------------------------------------

$host = 'mob0.marinetraffic.com';
$url  = '/ais/de/getxml_i.aspx';
$url .= '?sw_x=' . $swX;
$url .= '&sw_y=' . $swY;
$url .= '&ne_x=' . $neX;
$url .= '&ne_y=' . $neY;
$url .= '&zoom=18';

$fp = fsockopen($host, 80, $errno, $errstr, 10);

if (!$fp) {
    print '<POSITIONS></POSITIONS>';
    return;
}

$contents = '';

$out  = 'GET ' . $url . ' HTTP/1.1' . "\r\n";
$out .= 'Host: ' . $host . "\r\n";
$out .= 'Connection: Close' . "\r\n";
$out .= 'User-Agent: OpenSeaMap' . "\r\n";
$out .= "\r\n";
fwrite($fp, $out);
while (!feof($fp)) {
    $contents .= fgets($fp, 128);
}
fclose($fp);

list($header, $contents) = preg_split( '/([\r\n][\r\n])\\1/', $contents, 2);


// -----------------------------------------------------------------------------
// Output data
// -----------------------------------------------------------------------------

print strip_tags($contents, '<POSITIONS><V_POS>');
