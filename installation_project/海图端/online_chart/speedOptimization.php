<?php
    include("classes/Translation.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>OpenSeaMap - <?php echo $t->tr("dieFreieSeekarte")?></title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <meta http-equiv="content-language" content="<?= $t->getCurrentLanguage()?>">
        <meta http-equiv="X-UA-Compatible" content="IE=9">
        <meta name="date" content="2012-06-02">
        <link rel="SHORTCUT ICON" href="resources/icons/OpenSeaMapLogo_16.png">
        <link rel="stylesheet" type="text/css" href="map-full.css">
        <link rel="stylesheet" type="text/css" href="topmenu.css"> 
        <link rel="stylesheet" href="./javascript/assets/style.css">
        <script src="./javascript/assets/script.js"></script>
        <script type="text/javascript" src="./javascript/lib/jquery.js"></script>
        <script type="text/javascript" src="./javascript/openlayers/OpenLayers.js"></script>
        <script type="text/javascript" src="./javascript/translation-<?=$t->getCurrentLanguageSafe()?>.js"></script>
        <script type="text/javascript" src="./javascript/permalink.js"></script>
        <script type="text/javascript" src="./javascript/utilities.js"></script>
        <script type="text/javascript" src="./javascript/countries.js"></script>
        <script type="text/javascript" src="./javascript/map_utils.js"></script>
        <script type="text/javascript" src="./javascript/weather.js"></script>
        <script type="text/javascript" src="./javascript/nominatim.js"></script>
        <script type="text/javascript" src="./javascript/route/NauticalRoute.js"></script>
        <script type="text/javascript" src="./javascript/mouseposition_dm.js"></script>
        <script type="text/javascript" src="./javascript/grid_wgs.js"></script>
        <script type="text/javascript" src="./javascript/ais.js"></script>
        <script type="text/javascript" src="./javascript/satpro.js"></script>
        <script type="text/javascript" src="./javascript/lib/he.js"></script>
        <script type="text/javascript">
            var map;
            // Position and zoomlevel of the map (will be overriden with permalink parameters or cookies)
            var lon = 11.6540;
            var lat = 54.1530;
            var zoom = 10;
            // marker position
            var mLat = -1;
            var mLon = -1;
            //last zoomlevel of the map
            var oldZoom = 0;
            var downloadName;
            var downloadLink;
            var json_1='{"leg_num":3,"legs":[{"id":1,"start_longitude":-160.777965,"start_latitude":35.461880,"end_longitude":160.389957,"end_latitude":35.564441,"wind_speed":1,"wind_direction":1,"wave_height":1,"wave_direction":1,"wave_period":1,"length":1,"opt_speed":12},{"id":2,"start_longitude":121.389957,"start_latitude":35.564441,"end_longitude":121.929950,"end_latitude":35.447218,"wind_speed":12,"wind_direction":1,"wave_height":1,"wave_direction":1,"wave_period":1,"length":1,"opt_speed":14},{"id":3,"start_longitude":121.929950,"start_latitude":35.447218,"end_longitude":122.649941,"end_latitude":35.439886,"wind_speed":14,"wind_direction":1,"wave_height":1,"wave_direction":1,"wave_period":1,"length":1,"opt_speed":16}]}';
            var json_2='{"leg_num":19,"legs":[{"id":1,"start_longitude":-157.161,"start_latitude":71.438,"end_longitude":-158.045,"end_latitude":71.2568,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":2,"ship_speed":1},{"id":2,"start_longitude":-158.045,"start_latitude":71.2568,"end_longitude":-159.0198,"end_latitude":70.9373,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":2,"ship_speed":1},{"id":3,"start_longitude":-159.0198,"start_latitude":70.9373,"end_longitude":-161.5159,"end_latitude":70.4654,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":12,"ship_speed":0.0},{"id":4,"start_longitude":-161.5159,"start_latitude":70.4654,"end_longitude":-163.4541,"end_latitude":69.8655,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":20,"ship_speed":0.0},{"id":5,"start_longitude":-163.4541,"start_latitude":69.8655,"end_longitude":-164.0183,"end_latitude":69.5153,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":15,"ship_speed":0.0},{"id":6,"start_longitude":-164.0183,"start_latitude":69.5153,"end_longitude":-164.7663,"end_latitude":69.3361,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":16,"ship_speed":0.0},{"id":7,"start_longitude":-164.7663,"start_latitude":69.3361,"end_longitude":-166.3418,"end_latitude":69.0705,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":7,"ship_speed":0.0},{"id":8,"start_longitude":-166.3418,"start_latitude":69.0705,"end_longitude":-166.9425,"end_latitude":69.7049,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":11,"ship_speed":0.0},{"id":9,"start_longitude":-166.9425,"start_latitude":69.7049,"end_longitude":-168.5407,"end_latitude":69.4438,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":20,"ship_speed":0.0},{"id":10,"start_longitude":-168.5407,"start_latitude":69.4438,"end_longitude":-170.3995,"end_latitude":68.4755,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":17,"ship_speed":0.0},{"id":11,"start_longitude":-170.3995,"start_latitude":68.4755,"end_longitude":-170.5129,"end_latitude":67.8943,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":18,"ship_speed":0.0},{"id":12,"start_longitude":-170.5129,"start_latitude":67.8943,"end_longitude":-169.2094,"end_latitude":67.0608,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":16,"ship_speed":0.0},{"id":13,"start_longitude":-169.2094,"start_latitude":67.0608,"end_longitude":-168.0306,"end_latitude":67.00449883,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":11,"ship_speed":0.0},{"id":14,"start_longitude":-168.0306,"start_latitude":67.00449883,"end_longitude":-166.0306,"end_latitude":66.9855,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":14,"ship_speed":0.0},{"id":15,"start_longitude":-166.0306,"start_latitude":66.9855,"end_longitude":-165.3557,"end_latitude":66.89118461,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":11,"ship_speed":0.0},{"id":16,"start_longitude":-165.3557,"start_latitude":66.89118461,"end_longitude":-164.3557,"end_latitude":66.8166,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":2,"ship_speed":0.0},{"id":18,"start_longitude":-164.3557,"start_latitude":66.8166,"end_longitude":-162.6128,"end_latitude":66.4841,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":11,"ship_speed":0.0},{"id":19,"start_longitude":-162.6128,"start_latitude":66.4841,"end_longitude":-163.3382,"end_latitude":66.6644,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":12,"ship_speed":0.0}],"type":"speedOpt"}';
            var json_3='{"leg_num":3,"legs":[{"id":1,"start_longitude":157.11111,"start_latitude":71.438111,"end_longitude":-158.045,"end_latitude":71.2568,"ETA":0,"NMS":0,"FoConsumption":1,"V":2,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"length":0.0,"opt_speed":2},{"id":2,"start_longitude":-158.045,"start_latitude":71.2568,"end_longitude":-159.0198,"end_latitude":70.9373,"ETA":0,"NMS":0,"FoConsumption":1,"V":2,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":2},{"id":3,"start_longitude":-159.0198,"start_latitude":70.9373,"end_longitude":-161.5159,"end_latitude":70.4654,"ETA":0,"NMS":0,"FoConsumption":1,"V":2,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"wave_period":0.0,"length":0.0,"opt_speed":12}],"type":"speedOpt"}';
           var json_8='{"shipLongitude":170.789001,"shipLatitude":27.452999,"NMS":100,"SOG":1,"wind_speed":0,"wind_direction":1,"wave_direction":1,"wave_height":2,"type":"shipPos","head":68.0,"waypoints":[{"longitude":176.789001,"latitude":27.452999,"id":0},{"longitude":31.0,"latitude":121.0,"id":1},{"longitude":176.789001,"latitude":27.452999,"id":2},{"longitude":31.0,"latitude":121.0,"id":3},{"longitude":176.789001,"latitude":27.452999,"id":4},{"longitude":31.0,"latitude":121.0,"id":5}]}';

            var webSocData_speed=new Array();
            var rot_name=new Array();
            // FIXME: Work around for accessing translations from harbour.js
            var linkTextSkipperGuide = "<?=$t->tr('descrSkipperGuide')?>";
            var linkTextWeatherHarbour = "<?=$t->tr('descrOpenPortGuide')?>";
            // FIXME: Work around for accessing translations from tidal_scale.js
            var linkTextHydrographCurve = "<?=$t->tr('hydrographCurve')?>";
            var linkTextMeasuringValue = "<?=$t->tr('measuringValue')?>";
            var linkTextTendency = "<?=$t->tr('tendency')?>";
            // FIXME: Work around for accessing translations from NauticalRoute.js
            var tableTextNauticalRouteCoordinate = "<?=$t->tr('coordinate')?>";
            var tableTextNauticalRouteCourse = "<?=$t->tr('course')?>";
            var tableTextNauticalRouteDistance = "<?=$t->tr('distance')?>";
            // Set language
            var language = "<?=$t->getCurrentLanguage()?>";
            // Layers
            var layer_mapnik;       
            var layer_ship;               // 1
            var layer_marker;                      // 2
            var layer_ECA;             // 6
            var layer_pois;                        // 7
            var layer_download;                    // 8
            var layer_nautical_route;
            var layer_nauticalRoute_list;              // 9
            var layer_grid;                        // 10
            var layer_wikipedia;                   // 11
            var layer_ais;                         // 13
            var layer_satpro;                      // 14
            var layer_permalink;                   // 17
            var layer_speedOptimization;
            var layer_weather_wind;
            var layer_weather_waves;
            var layer_weather_swell;
            var layer_weather_current;
            var layer_style = OpenLayers.Util.extend({pointRadius: 10}, OpenLayers.Feature.Vector.style['default']);
            //  layer_style.fillOpacity = 0.2;
               layer_style.graphicOpacity = 1;
            // To not change the permalink layer order, every removed
            // layer keeps its number. The ArgParser compares the
            // count of layers with the layers argument length. So we
            // have to let him know, how many layers are removed.
            var ignoredLayers = 2;
            // Select controls
            var selectControl;
            // Controls
            var ZoomBar          = new OpenLayers.Control.PanZoomBar();
            var permalinkControl = new OpenSeaMap.Control.Permalink(null, null, {
                ignoredLayers : ignoredLayers
            });
            // Marker that is pinned at the last location the user searched for and selected.
            var searchedLocationMarker = null;
            // Load map for the first time
            var ws_data;
           
            function init() {
                //重复航线过滤
               var latLon_array=new Array();
                for(var i=0;i<webSocData_speed.length;++i){
                    rot_name[i]=webSocData_speed[i]["legs"][i]["id"];
                }
                layer_speedOptimization=new OpenLayers.Layer.Vector("Simple Geometry", {
                         style: layer_style,
                         visibility: false,
                         wrapDateLine: true
                });
                addSpeed_routeList();//要加上
                var buffZoom = parseInt(getCookie("zoom"));
                var buffLat = parseFloat(getCookie("lat"));
                var buffLon = parseFloat(getCookie("lon"));
                mLat  = getArgument("mlat");
                mLon  = getArgument("mlon");
                mZoom = getArgument("zoom");
                if (buffZoom != -1) {
                    zoom = buffZoom;
                }
                if (mZoom != -1) {
                    zoom = mZoom;
                }
                if (buffLat != -1 && buffLon != -1) {
                    lat = buffLat;
                    lon = buffLon;
                }
                if (mLat != -1 && mLon != -1) {
                    lat = mLat;
                    lon = mLon;
                }
                drawmap();
                layer_marker = new OpenLayers.Layer.Markers("Marker",{
                    layerId: -2 // invalid layerId -> will be ignored by layer visibility setup
                });
                map.addLayer(layer_marker);
                try{
                  // Create Marker, if arguments are given
                  if (mLat != -1 && mLon != -1) {
                      var mtext = he.encode(decodeURIComponent(getArgument("mtext")))
                                    .replace(/\n/g, '<br/>');
                      mtext = mtext.replace('&#x3C;b&#x3E;', '<b>')
                                    .replace('&#x3C;%2Fb&#x3E;', '</b>')
                                    .replace('&#x3C;/b&#x3E;', '</b>');
                      addMarker(layer_marker, mLon, mLat, mtext);
                  }
                }catch(err) {
                    console.log(err);
                }
                readLayerCookies();
                resetLayerCheckboxes();
                initMenuTools();
                // Set current language for internationalization
                OpenLayers.Lang.setCode(language);
            }
            function readLayerCookies() {
                if (getArgument('layers') != -1) {
                    // There is a 'layers' url param -> ignore cookies
                    // activate checkbox for deth points if one sublayer is selected
                    return;
                }
                // Set Layer visibility from cookie
                var poisVisible = getCookie("HarbourLayerVisible") === "true"
                layer_pois.setVisibility(poisVisible);
                var gridVisible = getCookie("GridWGSLayerVisible") === "true"
                if(getCookie("GridWGSLayerVisible") === "-1")
                  gridVisible = true; // default to visible
                layer_grid.setVisibility(gridVisible);
                var ECAVisible = getCookie("ECALayerVisible") === "true"
                layer_ECA.setVisibility(ECAVisible);
              
                if (getCookie("AisLayerVisible") == "true") {
                    showAis();
                }
            }
            function resetLayerCheckboxes()
            {
                // This method is separated from readLayerCookies because
                // the permalink control also will set the visibility of
                // layers.
                document.getElementById("checkLayerGridWGS").checked                = (layer_grid.getVisibility() === true);
                document.getElementById("checkLayerWeatherWind").checked            = (layer_weather_wind.getVisibility() === true);
                document.getElementById("checkLayerWeatherWaves").checked           = (layer_weather_waves.getVisibility() === true);
                document.getElementById("checkLayerWeatherSwell").checked           = (layer_weather_swell.getVisibility() === true);
                document.getElementById("checkLayerWeatherCurrent").checked         = (layer_weather_current.getVisibility() === true);
                document.getElementById("checkLayerECA").checked             = (layer_ECA.getVisibility() === true);
                document.getElementById("checkNauticalRoute").checked               = (layer_nautical_route.getVisibility() === true);
                document.getElementById("checkPermalink").checked                   = (layer_permalink.getVisibility() === true);
                createPermaLink();
            }
            // Show popup window for help
            function showMapKey(item) {
                legendWindow = window.open("legend.php?lang=" + language + "&page=" + item, "MapKey", "width=760, height=680, status=no, scrollbars=yes, resizable=yes");
                legendWindow.focus();
            }
            function showHarbours() {
                if (layer_pois.visibility) {
                    clearPoiLayer();
                    layer_pois.setVisibility(false);
                    setCookie("HarbourLayerVisible", "false");
                } else {
                    layer_pois.setVisibility(true);
                    setCookie("HarbourLayerVisible", "true");
                    refreshHarbours();
                }
            }
            function toggleNauticalRoute(show) {
                if (show) {
                    addNauticalRoute();
                } else {
                    layer_nautical_route.setVisibility(false);
                     closeActionDialog();
                     NauticalRoute_stopEditMode(); 
                }
            }
            function toggleSubList(show,i)
            {
                if(show){
                   document.getElementById(rot_name[i]).checked=true;
                    RouteSpeed_routeAdded(0); 
                }
                else{
                    document.getElementById(rot_name[i]).checked=false;
                    closeNauticalRouteList(i);
                  //  closeAct(i);
                }
            }
            function toggleNauticalRouteList(show) {
                if (show) {
                   document.getElementById("checkNauticalRouteList").checked=true;
                    if(document.getElementById("checkNauticalRouteList").checked===false)
                    for(var i=0;i<webSocData_speed.length;++i)
                    document.getElementById(rot_name[i]).checked=false;  
                } 
                else 
                    document.getElementById("checkNauticalRouteList").checked=false;
            }
            function togglePermalink(show) {
                if (show) {
                    addPermalink();
                } else {
                    closePermalink();
                }
            }
            function showGridWGS() {
                if (layer_grid.visibility) {
                    layer_grid.setVisibility(false);
                    setCookie("GridWGSLayerVisible", "false");
                } else {
                    layer_grid.setVisibility(true);
                    setCookie("GridWGSLayerVisible", "true");
                }
            }
            function showECA() {
                if (layer_ECA.visibility) {
                    layer_ECA.setVisibility(false);
                    setCookie("ECALayerVisible", "false");
                } else {
                    layer_ECA.setVisibility(true);
                    setCookie("ECALayerVisible", "true");
                }
            }
            function showAis() {
                if (layer_ais.visibility) {
                    layer_ais.setVisibility(false);
                    document.getElementById("license_marine_traffic").style.display = 'none';
                    setCookie("AisLayerVisible", "false");
                } else {
                    layer_ais.setVisibility(true);
                    document.getElementById("license_marine_traffic").style.display = 'inline';
                    setCookie("AisLayerVisible", "true");
                }
            }
            function showSatPro() {
                if (layer_satpro.visibility) {
                    layer_satpro.setVisibility(false);
                    setCookie("SatProLayerVisible", "false");
                } else {
                    layer_satpro.setVisibility(true);
                    setCookie("SatProLayerVisible", "true");
                }
            }
           
            // Show dialog window
            function showActionDialog(htmlText) {
                document.getElementById("actionDialog").style.visibility = 'visible';
                document.getElementById("actionDialog").innerHTML=""+ htmlText +"";
            }
            // Hide dialog window
            function closeActionDialog() {
                document.getElementById("actionDialog").style.visibility = 'hidden';
            }
            function addMapDownload() {
                selectControl.hover = false;
                addDownloadlayer();
                layer_download.setVisibility(true);
                var htmlText = "<div style=\"position:absolute; top:5px; right:5px; cursor:pointer;\"><img src=\"./resources/action/close.gif\" onClick=\"closeMapDownload();\"/></div>";
                htmlText += "<h3><?=$t->tr("downloadChart")?>:</h3><br/>";
                htmlText += "<table border=\"0\" width=\"240px\">";
                htmlText += "<tr><td>Name:</td><td><div id=\"info_dialog\">&nbsp;<?=$t->tr("pleaseSelect")?><br/></div></td></tr>";
                htmlText += "<tr><td><?=$t->tr("format")?>:</td><td><select id=\"mapFormat\"><option value=\"unknown\"/><?=$t->tr("unknown")?><option value=\"png\"/>png<option value=\"cal\"/>cal<option value=\"kap\"/>kap<option value=\"WCI\"/>WCI<option value=\"kmz\"/>kmz<option value=\"jpr\"/>jpr</select></td></tr>";
                htmlText += "<tr><td><br/><input type=\"button\" id=\"buttonMapDownload\" value=\"<?=$t->tr("download")?>\" onclick=\"downloadMap()\" disabled=\"true\"></td><td align=\"right\"><br/><input type=\"button\" id=\"buttonMapClose\" value=\"<?=$t->tr("close")?>\" onclick=\"closeMapDownload()\"></td></tr>";
                htmlText += "</table>";
                showActionDialog(htmlText);
            }
            function closeMapDownload() {
                selectControl.hover = true;
                layer_download.setVisibility(false);
                layer_download.removeAllFeatures();
                closeActionDialog();
            }
            function selectedMap (event) {
                var feature = event.feature;
                downloadName = feature.attributes.name;
                downloadLink = feature.attributes.link;
                var mapName = downloadName;
                document.getElementById('info_dialog').innerHTML=""+ mapName +"";
                document.getElementById('buttonMapDownload').disabled=false;
            }
            function addNauticalRoute() {
                layer_nautical_route.setVisibility(true);
                 var htmlText = "<div style=\"position:absolute; top:5px; right:5px; cursor:pointer;\">";
                htmlText += "<img src=\"./resources/action/close.gif\" onClick=\"closeNauticalRoute();\"/></div>";
                htmlText += "<h3><?=$t->tr("tripPlanner")?>:</h3><br/>";
                htmlText += "<table border=\"0\" width=\"370px\">";
                htmlText += "<tr><td><?=$t->tr("start")?></td><td id=\"routeStart\">- - -</td></tr>";
                htmlText += "<tr><td><?=$t->tr("finish")?></td><td id=\"routeEnd\">- - -</td></tr>";
                htmlText += "<tr><td><?=$t->tr("distance")?></td><td id=\"routeDistance\">- - -</td></tr>";
                htmlText += "<tr><td><?=$t->tr("format")?></td><td><select id=\"routeFormat\"><option value=\"CSV\"/>CSV<option value=\"GML\"/>GML<option value=\"KML\"/>KML</select></td></tr>";
                htmlText += "<tr><td id=\"routePoints\" colspan = 2> </td></tr>";
                htmlText += "<tr><td><br/><input type=\"button\" id=\"buttonRouteDownloadTrack\" value=\"<?=$t->tr("download")?>\" onclick=\"NauticalRoute_DownloadTrack();\" disabled=\"true\"></td><td align=\"right\"><br/><input type=\"button\" id=\"buttonNauticalRouteClear\" value=\"Clear\" onclick=\"clearNauticalRoute();addNauticalRoute();\">&nbsp;<input type=\"button\" id=\"buttonActionDialogClose\" value=\"<?=$t->tr("close")?>\" onclick=\"closeNauticalRoute();\"></td></tr></table>";
                htmlText+="<tr><td><input type=\"button\" id=\"buttonNauticalRouteOptimization\" value=\"Optimization\" onClick=\"NauticalRoute_Optimization();\" disabled=\"true\">&nbsp</td></tr>"
                htmlText+="<tr><td><input type=\"button\" id=\"buttonNauticalCancelOptimization\" value=\"CancelOptimization\" onClick=\"NauticalRoute_CancelOptimization();\" disabled=\"true\">&nbsp</td></tr>"
                htmlText+="<tr><td><input type=\"button\" id=\"buttonNauticalRouteActive\" value=\"Active\" onClick=\"NauticalRoute_active();\" disabled=\"true\">&nbsp</td></tr>"
                htmlText+="<tr><td><input type=\"button\" id=\"buttonNauticalCancelActive\" value=\"CancelActive\" onClick=\"NauticalRoute_CancelActive();\" disabled=\"true\">&nbsp</td></tr>"
                showActionDialog(htmlText);
                 NauticalRoute_startEditMode();
            }
            function addNauticalRouteList(){
                layer_nauticalRoute_list.setVisibility(true);
            }
            function addNauticalRouteList(route_id){//添加航线信息表格
              layer_speedOptimization.setVisibility(true);
              var htmlText= "<div style=\"position:absolute; top:5px; right:5px; cursor:pointer;\">";
                htmlText += "<img src=\"./resources/action/close.gif\" onClick=\"closeActionDialog();\"/></div>";
                htmlText+="<h3>"+rot_name[route_id]+":</h3>";
                htmlText += "<table border=\"0\" width=\"370px\">";
                htmlText += "<tr><td><?=$t->tr("start")?></td><td id=\"routeStart\">- - -</td></tr>";
                htmlText += "<tr><td><?=$t->tr("finish")?></td><td id=\"routeEnd\">- - -</td></tr>";
                htmlText += "<tr><td><?=$t->tr("distance")?></td><td id=\"routeDistance\">- - -</td></tr>";
               // htmlText += "<tr><td><?=$t->tr("format")?></td><td><select id=\"routeFormat\"><option value=\"CSV\"/>CSV<option value=\"GML\"/>GML<option value=\"KML\"/>KML</select></td></tr>";
                htmlText += "<tr><td id=\"routePoints\" colspan = 2> </td></tr>";
                htmlText += "<tr><td><br/><input type=\"button\" id=\"buttonActionDialogClose\" value=\"<?=$t->tr("close")?>\" onclick=\"closeNauticalRouteList("+route_id+")\";\"closeActionDialog()\";></td></tr></table>";
                showActionDialog(htmlText);
            }
            function closeNauticalRoute() {
                layer_nautical_route.setVisibility(true);
                closeActionDialog();
               NauticalRoute_stopEditMode();
            }
           function clearNauticalRoute(){
            layer_nautical_route.setVisibility(true);
                closeActionDialog();
                NauticalRoute_clearRoute();
           }
           function closeNauticalRouteList(route_id) {
            layer_speedOptimization.setVisibility(false);
            layer_speedOptimization.removeAllFeatures();
            }
            function closeAllRouteList() {
              for(var i=0;i<webSocData_speed;i++)
              {
                layer_speedOptimization.setVisibility(false);
                layer_speedOptimization.removeAllFeatures();
              }
               closeActionDialog();
            }
            function onAddMarker(e) {
                // Marker Init
                var size = new OpenLayers.Size(32, 32); // size of the marker
                var offset = new OpenLayers.Pixel(-(size.w/2), -size.h); // offset to get the pinpoint of the needle to mouse pos
                var icon = new OpenLayers.Icon('./resources/icons/Needle_Red_32.png', size, offset); // Init of icon
                // Adding of Marker
                layer_permalink.clearMarkers(); // clear all markers to only keep one marker at a time on the map
                var position = this.events.getMousePosition(e); // get position of mouse click
                var lonlat = map.getLonLatFromLayerPx(position); // get Lon/Lat from position
                layer_permalink.addMarker(new OpenLayers.Marker(lonlat, icon)); // add maker
                // Display Marker Position
                lonlat.transform(projMerc, proj4326);
                // Code from mousepostion_dm.js - redundant, try to reuse
                var ns = lonlat.lat >= 0 ? 'N' : 'S';
                var we = lonlat.lon >= 0 ? 'E' : 'W';
                var lon_m = Math.abs(lonlat.lon*60).toFixed(3);
                var lat_m = Math.abs(lonlat.lat*60).toFixed(3);
                var lon_d = Math.floor(lon_m/60);
                var lat_d = Math.floor(lat_m/60);
                lon_m -= lon_d*60;
                lat_m -= lat_d*60;
                // Write the specified content inside
                OpenLayers.Util.getElement("markerpos").innerHTML = ns + lat_d + "°" + format2FixedLength(lat_m,6,3) + "'" + " " + we + lon_d + "°" + format2FixedLength(lon_m,6,3) + "'";
                $("#markerpos").data("lat", lonlat.lat.toFixed(5))
                $("#markerpos").data("lon", lonlat.lon.toFixed(5))
                createPermaLink();
              }
              function createPermaLink(){
                if(!layer_permalink.visibility)
                  return;
                if(!OpenLayers.Util.getElement("permalinkDialog"))
                  return;
                // Create Permalink for Layers
                var layersPermalink = permalinkControl.getLayerString();
                layersPermalink = permalinkControl.setFlag(layersPermalink, 'F', layer_permalink.layerId);
                // Generate Permalink for copy and paste
                var url = window.location.href;
                var userURL = url.substr(0, url.lastIndexOf('/')+1)
                userURL += "?zoom=" + map.getZoom(); // add map zoom to string
                userURL += "&lat=" + y2lat(map.getCenter().lat).toFixed(5); // add map zoom to string
                userURL += "&lon=" + x2lon(map.getCenter().lon).toFixed(5); // add map zoom to string
                var lat = $("#markerpos").data("lat")
                if(lat)
                  userURL += "&mlat=" + lat; // add latitude
                var lon = $("#markerpos").data("lon")
                if(lon)
                  userURL += "&mlon=" + $("#markerpos").data("lon"); // add longitude
                var mText = encodeURIComponent(document.getElementById("markerText").value)
                if(mText != "")
                  userURL += "&mtext=" + mText; // add marker text; if empty OSM-permalink JS will ignore the '&mtext'
                userURL += "&layers=" + layersPermalink; // add encoded layers
                OpenLayers.Util.getElement("userURL").innerHTML = userURL; // write contents of userURL to textarea
            }
            function addPermalink() {
                layer_permalink.setVisibility(true);
                var htmlText = "<div id='permalinkDialog' style=\"position:absolute; top:5px; right:5px; cursor:pointer;\">";
                htmlText += "<img src=\"./resources/action/close.gif\" onClick=\"closePermalink();\"/></div>";
                htmlText += "<h3><?=$t->tr("permalinks")?>:</h3><br/>"; // reference to translation.php
                htmlText += "<p><?=$t->tr("markset")?></p>"
                htmlText += "<br /><hr /><br />"
                // Übersetzungen in die PHP-Files reinschreiben; kein Text sollte ohne die Möglichkeit der Bearbeitung hier drin stehen
                htmlText += "<table border=\"0\" width=\"370px\">";
                htmlText += "<tr><td><?=$t->tr("position")?>:</td><td id=\"markerpos\">- - -</td></tr>"; // Lat/Lon of the user's click
                htmlText += "<tr><td><?=$t->tr("description")?>:</td><td><textarea cols=\"25\" rows=\"5\" id=\"markerText\"></textarea></td></tr>"; // userInput
                htmlText += "</td></tr></table>";
                htmlText += "<br /><hr /><br />"
                htmlText += "<?=$t->tr("copynpaste")?>:<br /><textarea onclick=\"this.select();\" cols=\"50\" rows=\"3\" id=\"userURL\"></textarea>"; // secure & convient onlick-solution for copy and paste
                showActionDialog(htmlText);
                $('#markerText').on('keyup', function(evt) {
                  createPermaLink()
                });
                map.events.register("click", layer_permalink, onAddMarker);
                createPermaLink();
            }
            function closePermalink() {
                map.events.unregister("click", layer_permalink, onAddMarker);
                layer_permalink.setVisibility(false);
                closeActionDialog();
            }
            function addSearchResults(xmlHttp) {
                var items = xmlHttp.responseXML.getElementsByTagName("place");
                var placeName, description, placeLat, placeLon;
                var buff, pos;
                var htmlText = "<div style=\"position:absolute; top:5px; right:5px; cursor:pointer;\"><img src=\"./resources/action/close.gif\" onClick=\"closeActionDialog();\"/></div>";
                htmlText += "<h3><?=$t->tr("searchResults")?>:</h3><br/>"
                htmlText += "<table border=\"0\" width=\"370px\">"
                for(i = 0; i < items.length; i++) {
                    buff = xmlHttp.responseXML.getElementsByTagName('place')[i].getAttribute('display_name');
                    placeLat = xmlHttp.responseXML.getElementsByTagName('place')[i].getAttribute('lat');
                    placeLon = xmlHttp.responseXML.getElementsByTagName('place')[i].getAttribute('lon');
                    pos = buff.indexOf(",");
                    placeName = buff.substring(0, pos);
                    description = buff.substring(pos +1).trim();
                    htmlText += "<tr style=\"cursor:pointer;\" onmouseover=\"this.style.backgroundColor = '#ADD8E6';\"onmouseout=\"this.style.backgroundColor = '#FFF';\" onclick=\"jumpToSearchedLocation(" + placeLon + ", " + placeLat + ");\"><td  valign=\"top\"><b>" + placeName + "</b></td><td>" + description + "</td></tr>";
                }
                htmlText += "<tr><td>&nbsp;</td><td align=\"right\"><br/><input type=\"button\" id=\"buttonMapClose\" value=\"<?=$t->tr("close")?>\" onclick=\"closeActionDialog();\"></td></tr></table>";
                showActionDialog(htmlText);
            }
            function drawmap() {
                map = new OpenLayers.Map('map', {
                    numZoomLevels     : 11,
                    projection        : projMerc,
                    displayProjection : proj4326,
                    layers: [layer_speedOptimization],
                    eventListeners: {
                        moveend     : mapEventMove,
                        zoomend     : mapEventZoom,
                        click       : mapEventClick,
                        changelayer : mapChangeLayer
                    },
                    controls: [
                        permalinkControl,
                        new OpenLayers.Control.Navigation(),
                        //new OpenLayers.Control.LayerSwitcher(), //only for debugging
                        new OpenLayers.Control.ScaleLine({topOutUnits : "nmi", bottomOutUnits: "km", topInUnits: 'nmi', bottomInUnits: 'km', maxWidth: '40'}),
                        new OpenLayers.Control.MousePositionDM(),
                        new OpenLayers.Control.OverviewMap(),
                        ZoomBar
                    ]
                });
                var bboxStrategyWikipedia = new OpenLayers.Strategy.BBOX( {
                    ratio : 1.1,
                    resFactor: 1
                });
                var poiLayerWikipediaHttp = new OpenLayers.Protocol.HTTP({
                    url: 'api/proxy-wikipedia.php?',
                    params: {
                        'LANG' : language,
                        'thumbs' : 'no'
                    },
                    format: new OpenLayers.Format.KML({
                        extractStyles: true,
                        extractAttributes: true
                    })
                });
                // Select feature ---------------------------------------------------------------------------------------------------------
               // (only one SelectFeature per map is allowed)
                selectControl = new OpenLayers.Control.SelectFeature([],{
                    onSelect: function (feature) {
                },
                    hover:true,
                    popup:null,
                    addLayer:function(layer){
                        var layers = this.layers;
                        if (layers) {
                            layers.push(layer);
                        } else {
                            layers = [
                                layer
                            ];
                        }
                        this.setLayer(layers);
                    },
                    removePopup:function(){
                        if (this.popup) {
                            this.map.removePopup(this.popup);
                            this.popup.destroy();
                            this.popup = null;
                        }
                    }
                });
                var myDate = new Date();
                var currentYear=myDate.getFullYear();    //获取完整的年份(4位,1970-????)
                var currentMonth=myDate.getMonth()+1;       //获取当前月份(0-11,0代表1月)
                var currentDay=myDate.getDate();        //获取当前日(1-31)//
                var currentMinutes=myDate.getMinutes();//获取当前分钟 
                var currentHour=myDate.getHours();       //获取当前小时数(0-23)
                var currentSeconds=myDate.getSeconds();
                var currentTime=currentYear+"-"+currentMonth+"-"+currentDay+"T"+currentHour+":"+currentMinutes+":"+currentSeconds+".000Z";
                // Add Layers to map-------------------------------------------------------------------------------------------------------
                // Mapnik (Base map)
                layer_mapnik = new OpenLayers.Layer.XYZ('Mapnik', [
                    'http://'+IP+':'+PORT+'/online_chart/osm_tiles/${z}/${x}/${y}.png'
                ],{
                    layerId      : 1,
                    wrapDateLine : true
                });
                layer_ship = new OpenLayers.Layer.Vector(
                    "Simple Geometry",
                    {
                        visibility: false,
                        styleMap: new OpenLayers.StyleMap({
                            "default": {
                               externalGraphic: "./resources/icons/ship.svg",
                                graphicHeight: 100,
                                graphicWidth:120,
                                rotation: "${angle}",
                                fillOpacity: "${opacity}"
                            },
                        })
                    }
                );
                // Seamark
                //ECA
                layer_ECA = new OpenLayers.Layer.WMS("ECA:ECA_line - Tiled",
                "http://"+IP+":"+geoserverPort+"/geoserver/ECA/wms",
                {
                    "LAYERS": 'ECA:ECA_line_1',
                    transparent: "true",
                    "exceptions": 'application/vnd.ogc.se_inimage',
                    format: 'image/png',
                    tilesOrigin: map.maxExtent.left + ',' + map.maxExtent.bottom,
                    tiled: false
                },
                {
                   // style: layer_style,
                   displayOutsideMaxExtent: true,
                    visibility: false,
                    yx: { 'EPSG:4326': false }
                }
            );
                // POI-Layer for harbours
                layer_pois = new OpenLayers.Layer.Vector("pois", {
                    layerId: 7,
                    visibility: true,
                    projection: proj4326,
                    displayOutsideMaxExtent:true
                });
                // Map download
                layer_download = new OpenLayers.Layer.Vector("Map Download", {
                    layerId: 8,
                    visibility: false
                });
                // Trip planner
                layer_nautical_route = new OpenLayers.Layer.Vector("Trip Planner",{ 
                    layerId: 9, 
                    styleMap: routeStyle, 
                    visibility: false, 
                    eventListeners: {
                        "featuresadded": NauticalRoute_routeAdded, 
                        "featuremodified": NauticalRoute_routeModified
                    }
                }
                );
                  //气象图层
            layer_weather_wind = new OpenLayers.Layer.WMS("Geoserver layers - Tiled",
            "http://"+IP+":"+geoserverPort+"/geoserver/acme/wms",
                {
                    "LAYERS": 'acme:wind_direction_magnitude',
                    transparent: "true",
                    "exceptions": 'application/vnd.ogc.se_inimage',
                    format: 'image/png',
                    //time: currentTime,
                    tilesOrigin: map.maxExtent.left + ',' + map.maxExtent.bottom,
                    tiled: true
                },
                {
                    style: layer_style,
                    visibility: false,
                    yx: { 'EPSG:900913': false }
                }
            );
            layer_weather_waves = new OpenLayers.Layer.WMS("Geoserver layers - Tiled",
            "http://"+IP+":"+geoserverPort+"/geoserver/acme/wms",
                {
                    "LAYERS": 'acme:weather_waves',
                    transparent: "true",
                    "exceptions": 'application/vnd.ogc.se_inimage',
                    format: 'image/png',
                    //time: currentTime,
                    tilesOrigin: map.maxExtent.left + ',' + map.maxExtent.bottom,
                    tiled: true
                },
                {
                    style: layer_style,
                    visibility: false,
                    yx: { 'EPSG:900913': false }
                }
            );
            layer_weather_swell = new OpenLayers.Layer.WMS("Geoserver layers - Tiled",
            "http://"+IP+":"+geoserverPort+"/geoserver/acme/wms",
                {
                    "LAYERS": 'acme:weather_swell',
                    transparent: "true",
                    "exceptions": 'application/vnd.ogc.se_inimage',
                    format: 'image/png',
                    tilesOrigin: map.maxExtent.left + ',' + map.maxExtent.bottom,
                    //time: currentTime,
                    tiled: true
                },
                {
                    style: layer_style,
                    visibility: false,
                    yx: { 'EPSG:900913': false }
                }
            );
            layer_weather_current = new OpenLayers.Layer.WMS("Geoserver layers - Tiled",
            "http://"+IP+":"+geoserverPort+"/geoserver/acme/wms",
                {
                    "LAYERS": 'acme:current_direction_magnitude',
                    transparent: "true",
                    "exceptions": 'application/vnd.ogc.se_inimage',
                    format: 'image/png',
                    tilesOrigin: map.maxExtent.left + ',' + map.maxExtent.bottom,
                    //time: currentTime,
                    tiled: true
                },
                {
                    style: layer_style,
                    visibility: false,
                    yx: { 'EPSG:900913': false }
                }
            );
                // Grid WGS
                layer_grid = new OpenLayers.Layer.GridWGS("coordinateGrid", {
                    layerId: 10,
                    visibility: true,
                    zoomUnits: zoomUnits
                });
                // SatPro
                satPro = new SatPro(map, selectControl, {
                    layerId: 14
                });
                layer_satpro = satPro.getLayer();
                // Permalink
                layer_permalink = new OpenLayers.Layer.Markers("Permalink", {
                    layerId: 17,
                    visibility: false,
                    projection: proj4326
                });

                map.addLayers([
                    layer_mapnik,
                    layer_weather_wind,
                    layer_weather_swell,
                    layer_weather_current,
                    layer_weather_waves,
                    layer_ECA,
                    layer_grid,
                    layer_pois,
                    layer_ship,
                    layer_nautical_route,
                   // layer_ais,
                   // layer_satpro,
                    layer_download,
                    layer_permalink
                ]);
                if (!map.getCenter()) {
                    jumpTo(lon, lat, zoom);
                }
                // Register featureselect for poi layers
                 selectControl.addLayer(layer_nautical_route);
                  layer_nautical_route.events.register("featureselected", layer_nautical_route, onFeatureSelectPoiLayers);
                selectControl.addLayer(layer_pois);
                selectControl.addLayer(layer_speedOptimization);
                selectControl.addLayer(layer_ship);
               layer_speedOptimization.events.register("featureselected", layer_speedOptimization, onSelectLeg);
              layer_ship.events.register("featureselected", layer_speedOptimization, onSelectShip);
                // Activate select control
                map.addControl(selectControl);
                selectControl.activate();
            }
            function clearPoiLayer() {
                harbours = [];
                layer_pois.removeAllFeatures();
            }
          function onSelectLeg(event){
            selectControl.removePopup();
            var leg_num=webSocData_speed[0]["leg_num"];
                var leg_info = webSocData_speed[0]["legs"];
                var speedOpt_list=new Array();
                var windSpeed_list=new Array();
                var windDirection_list=new Array();
                var waveHeight_list=new Array();
                var waveDirection_list=new Array();
                var wavePeriod_list=new Array();
                var leg_length=new Array();
                var legLat=new Array();
                var legLon=new Array();
                var ship_speed=new Array();
                for(var i=0;i<leg_num;i++){
                    speedOpt_list[i]=leg_info[i]["opt_speed"];
                    legLon[i] = leg_info[i]["start_longitude"];
                    legLat[i] = leg_info[i]["start_latitude"];
                leg_length[i]=leg_info[i]["length"];
                ship_speed[i]=leg_info[i]["ship_speed"];
                }
                legLon[leg_num] = leg_info[leg_num-1]["end_longitude"];
                legLat[leg_num] = leg_info[leg_num-1]["end_latitude"];
                feature = event.feature;
                var featureLon=x2lon(feature.geometry.getBounds().getCenterLonLat().lon);
                var featureLat=y2lat(feature.geometry.getBounds().getCenterLonLat().lat);
               for(var i=0;i<leg_num;i++){
                   if( feature.geometry.id===point_array[i].id){
                    var buff='<p style=SpeedFont>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;longitude:'+lon2DegreeMinute(legLon[i])+'<br>';
                    buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;latitude:'+lat2DegreeMinute(legLat[i])+'<br>';
                    buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ETA:'+leg_info[i].ETA+'<br>';
                    buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NMS:'+leg_info[i].NMS+'<br>';
                    buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;V:'+leg_info[i].V+'<br>';
                    buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FoConsumption:'+leg_info[i].FoConsumption+'<br>';
                        buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;winddirection:'+ leg_info[i].wind_direction+'°<br>';
                        buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;windspeed:'+ leg_info[i].wind_speed+'m/s<br>';
                        buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;waveheight:'+ leg_info[i].wave_height+'m<br>';
                        buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;wavedirection:'+ leg_info[i].wave_direction+'°<br></p>';
                        popup = new OpenLayers.Popup.FramedCloud("chicken",
                        feature.geometry.getBounds().getCenterLonLat(),
                        null,
                        buff,
                        null,
                        true
                        );
                   selectControl.popup = popup;
                   map.addPopup(popup);
                   }
               }
          }
          function onSelectShip(event){
            selectControl.removePopup();
                feature = event.feature;
            var shipLon=x2lon(getCookie("shipLon")).toFixed(6);
            var shipLat=y2lat(getCookie("shipLat")).toFixed(6);

                    var buff='<p style=shipFont>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;longitude:'+lon2DegreeMinute(shipLon)+'<br>';
                     buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;latitude:'+lat2DegreeMinute(shipLat)+'<br>';
                     buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HeadingDgree:'+getCookie("shipHead")+'°<br>';
                     buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NMS:'+getCookie("shipNMS")+'<br>';
                     buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SOG:'+getCookie("shipSOG")+'<br>';
                     buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;winddirection:'+getCookie("shipWindDirection")+'°<br>';
                     buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;windspeed:'+ getCookie("shipWindSpeed")+'m/s<br>';
                     buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;waveheight:'+getCookie("shipWaveHeight")+'m<br>';
                     buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;wavedirection:'+getCookie("shipWaveDirection")+'°<br></p>';
                        popup = new OpenLayers.Popup.FramedCloud("chicken",
                        feature.geometry.getBounds().getCenterLonLat(),
                        null,
                        buff,
                        null,
                        true
                        );
                   selectControl.popup = popup;
                   map.addPopup(popup);
               
          }
            function onFeatureSelectPoiLayers(event) {
                feature = event.feature;
                if (feature.layer == layer_nautical_route) {
                    feature.style = style_edit;
                }
                else {
                    selectControl.removePopup();
                    if (feature.data.popupContentHTML) {
                        var buff = feature.data.popupContentHTML;  
                    }
                    else {
                       var buff='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;经度:<br>'+feature;
                       buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;纬度:<br>';
                        buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;纬度:<br>';
                        buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;风向:60°<br>';
                        buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;风速:10m/s<br>';
                        buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;浪高:4m<br>';
                        buff+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;浪向:60°<br>';
                        buff+='&nbsp;&nbsp;&nbsp;浪周期:10s<br>';   
                        buff += '最优航速:'+0+'kn <br>';
                        buff+='分段航程:'+0+'nm<br>';
                        buff+='当前航速:16kn<br>'; 
                    }
                    popup = new OpenLayers.Popup.FramedCloud("chicken",
                        feature.geometry.getBounds().getCenterLonLat(),
                        null,
                        buff,
                        null,
                        true
                    );
                   selectControl.popup = popup;
                   map.addPopup(popup);
                }
            }
            // Map event listener moved
            function mapEventMove(event) {
                // Set cookie for remembering lat lon values
                setCookie("lat", y2lat(map.getCenter().lat).toFixed(5));
                setCookie("lon", x2lon(map.getCenter().lon).toFixed(5));
            }
            // Map event listener Zoomed
            function mapEventZoom(event) {
                zoom = map.getZoom();
                // Set cookie for remembering zoomlevel
                setCookie("zoom",zoom);
                // Clear POI layer
                clearPoiLayer();
                if(oldZoom!=zoom) {
                    oldZoom=zoom;
                }
                if (layer_download.getVisibility() === true) {
                    closeMapDownload();
                   // addMapDownload();
                }
            }
            function mapEventClick(event) {
                selectControl.removePopup();
            }
            // Map event listener changelayer
            function mapChangeLayer(event) {
                resetLayerCheckboxes();
            }
            function addDownloadlayer(xmlMaps) {
                var xmlDoc=loadXMLDoc("./gml/map_download.xml");
                try {
                    var root = xmlDoc.getElementsByTagName("maps")[0];
                    var items = root.getElementsByTagName("map");
                } catch(e) {
                    alert("Error (root): "+ e);
                    return -1;
                }
                for (var i=0; i < items.length; ++i) {
                    var item = items[i];
                    var load = false;
                    var category =item.getElementsByTagName("category")[0].childNodes[0].nodeValue;
                    if (zoom <= 7 && category >= 2) {
                        load = true;
                    } else if (zoom <= 10 && category >= 4) {
                        load = true;
                    } else if (zoom <= 13 && category >= 6) {
                        load = true;
                    } else if (zoom <= 18 && category >= 7) {
                        load = true;
                    }
                    if (load) {
                        try {
                            var n = item.getElementsByTagName("north")[0].childNodes[0].nodeValue;
                            var s = item.getElementsByTagName("south")[0].childNodes[0].nodeValue;
                            var e = item.getElementsByTagName("east")[0].childNodes[0].nodeValue;
                            var w = item.getElementsByTagName("west")[0].childNodes[0].nodeValue;
                        } catch(e) {
                            alert("Error (load): " + e);
                            return -1;
                        }
                        var bounds = new OpenLayers.Bounds(w, s, e, n);
                        bounds.transform(new OpenLayers.Projection("EPSG:4326"), new
                        OpenLayers.Projection("EPSG:900913"));
                        var name = item.getElementsByTagName("name")[0].childNodes[0].nodeValue.trim();
                        var link = item.getElementsByTagName("link")[0].childNodes[0].nodeValue.trim();
                        var box  = new OpenLayers.Feature.Vector(bounds.toGeometry(), {
                            name: name,
                            link: link
                        });
                        layer_download.addFeatures(box);
                    }
                }
            }
            function switchMenuTools(toolName, activate) {
                switch (toolName) {
                    case 'nautical_route':{
                        togglePermalink(false);
                        toggleNauticalRouteList(false);
                        toggleNauticalRoute(activate);
                       for(var i in webSocData_speed)
                          (document.getElementById(rot_name[i])).checked=false;
                    }
                        break;
                    case 'permalink':
                    {
                        toggleNauticalRoute(false);
                        toggleNauticalRouteList(false);
                        togglePermalink(activate);
                        for(var i in webSocData_speed)
                           (document.getElementById(rot_name[i])).checked=false;
                    }                    
                        break;
                    default:
                        break;
                }
                for(var i=0;i<rot_name.length;i++)
                    if(toolName===rot_name[i])
                       {
                          togglePermalink(false);
                       toggleNauticalRoute(false);
                         toggleNauticalRouteList(activate);
                       toggleSubList(activate,i);
                       }
            }
            function initMenuTools() {
                // The layers will be displayed based on permalink
                // settings. Unfortunately the action dialog will not
                // be generated. This workaround guarantees, that the
                // corresponding action dialog will be generated.
                if (layer_nautical_route.getVisibility() === true) {
                    switchMenuTools('nautical_route', true);
                }
                if (layer_permalink.getVisibility() === true) {
                    switchMenuTools('permalink', true);
                }
                $('#topmenu2').find('[data-tools]').click(function(evt) {
                    var layerName       = $(evt.currentTarget).data('tools');
                    var checked         = $(evt.currentTarget).find('input').is(':checked');
                    var checkboxClicked = $(evt.target).is('input');
                    if (checkboxClicked) {
                        switchMenuTools(layerName, checked);
                    } else {
                        switchMenuTools(layerName, !checked);
                    }
                });
                $('#topmenu2').find('[data-na]').click(function(evt) {
                    var layerName       = $(evt.currentTarget).data('na');
                    var checked         = $(evt.currentTarget).find('input').is(':checked');
                    var checkboxClicked = $(evt.target).is('input');
                    if (checkboxClicked) {
                        switchMenuTools(layerName, checked);
                    } else {
                        switchMenuTools(layerName, !checked);
                    }
                });
            }
        </script>
    </head>
    <body onload="init(); SpeedOpt_receive();">
        <div id="map" style="position:absolute; bottom:0px; left:0px;"></div>
        <div style="position:absolute; bottom:48px; left:12px; cursor:pointer;">
        <a id="license_marine_traffic" onClick="showMapKey('license')" style="display:none"></a>
        </div>
        <div id="actionDialog">
            <br>&nbsp;not found&nbsp;<br>&nbsp;
        </div>
        <div id="windSpeed_legend" style="position:absolute; bottom:25px; right:12px;  visibility:hidden;">
        <p>Wind Speed</p>
        <img src="./resources/map/wind_legend.png" height="20" width="300" />
    </div>
    <div id="currentSpeed_legend" style="position:absolute; bottom:140px; right:12px;  visibility:hidden;">
        <p>Current Speed</p>
        <img src="./resources/map/current_legend.png" height="30" width="300" />
    </div>

    <div id="wave_legend" style="position:absolute; bottom:60px; right:12px; visibility:hidden;">
        <p>Wave Height</p>
        <img src="./resources/map/wave_height.png" height="20" width="300" />
        <p>Wave Period</p>
        <img src="./resources/map/wave_period.png" height="20" width="300" />
    </div>
        <?php include('classes/topmenu.inc'); ?>
         <?php include('classes/rightMenu.inc');?>
    </body>
</html>
