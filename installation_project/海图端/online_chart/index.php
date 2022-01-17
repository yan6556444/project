<?php
    include("classes/Translation.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
    <link rel="stylesheet" type="text/css" href="weather.css">
    <link rel="stylesheet" href="./javascript/assets/style.css">
    <script src="./javascript/assets/script.js"></script>
    <script type="text/javascript" src="./javascript/lib/jquery.js"></script>
    <script type="text/javascript" src="./javascript/openlayers/OpenLayers.js"></script>
    <script type="text/javascript" src="./javascript/translation-<?=$t->getCurrentLanguageSafe()?>.js"></script>
    <script type="text/javascript" src="./javascript/permalink.js"></script>
    <script type="text/javascript" src="./javascript/utilities.js"></script>
    <script type="text/javascript" src="./javascript/countries.js"></script>
    <script type="text/javascript" src="./javascript/map_utils.js"></script>
    <script type="text/javascript" src="./javascript/nominatim.js"></script>
    <script type="text/javascript" src="./javascript/route/NauticalRoute.js"></script>
    <script type="text/javascript" src="./javascript/weather.js"></script>
    <script type="text/javascript" src="./javascript/mouseposition_dm.js"></script>
    <script type="text/javascript" src="./javascript/grid_wgs.js"></script>
    <script type="text/javascript" src="./javascript/ais.js"></script>
    <script type="text/javascript" src="./javascript/satpro.js"></script>
    <script type="text/javascript" src="./javascript/lib/he.js"></script>
    <script type="text/javascript">
		
        var map;
        // Position and zoomlevel of the map (will be overriden with permalink parameters or cookies)
        var lon =103.543403;
        var lat = 29.268126;
        
        var zoom = 19;
        var route_name;
        // marker position
        var mLat = -1;
        var mLon = -1;
        //last zoomlevel of the map
        var oldZoom = 0;
        var downloadName;
        var downloadLink;
        //弹出框内容
        var rptPoint_array = new Array();
        var rptPoint_vector = new Array();
        var rptPoint = new Array();
        var cost;//费用
        var petroleum;//燃油
        var timeConsume;//航行时间
        var len_;//总航程
        var rptPointStyle = {
            pointRadius: 6,
            fillColor: "#3f48cc",
            strokeWidth: 0
        };
        var courseFeature = new Array();
        var json_1 = '{"type":"routeOpt","uuid":"c5b581e68e3743a9af80dd32c46b8d03","cost":3601.75,"petroleum":1960.2,"timeConsume":79.5,"len":1200.0,"waypoints":[{"longitude":-157.161,"latitude":71.438},{"longitude":-158.045,"latitude":71.2568},{"longitude":-159.0198,"latitude":71.1838},{"longitude":-160.5159,"latitude":70.9373},{"longitude":-162.4541,"latitude":70.4654},{"longitude":-164.0183,"latitude":69.8655},{"longitude":-164.7663,"latitude":69.5153},{"longitude":-166.3418,"latitude":69.3361},{"longitude":-166.9425,"latitude":69.0705},{"longitude":-168.5407,"latitude":69.7049},{"longitude":-170.3995,"latitude":69.4438},{"longitude":-170.5129,"latitude":68.4755},{"longitude":-169.2094,"latitude":67.8943},{"longitude":-168.0306,"latitude":67.0608},{"longitude":-165.3557,"latitude":66.9855},{"longitude":-163.5649,"latitude":66.8166},{"longitude":-162.6128,"latitude":66.0692},{"longitude":-163.3382,"latitude":66.4841},{"longitude":-163.8143,"latitude":66.6644},{"longitude":-165.7071,"latitude":66.5519},{"longitude":-166.8292,"latitude":66.3617},{"longitude":-168.4954,"latitude":65.8243},{"longitude":-168.1213,"latitude":65.109},{"longitude":-166.9312,"latitude":64.7875},{"longitude":-166.3305,"latitude":64.3396},{"longitude":-165.197,"latitude":64.2905},{"longitude":-163.8143,"latitude":64.3151},{"longitude":-162.2841,"latitude":64.2659},{"longitude":-161.1847,"latitude":64.0485},{"longitude":-162.0234,"latitude":63.7694},{"longitude":-163.2135,"latitude":63.2588},{"longitude":-164.245,"latitude":63.4317},{"longitude":-166.1378,"latitude":63.2894},{"longitude":-166.6932,"latitude":62.7574},{"longitude":-166.8065,"latitude":61.9607},{"longitude":-168.2007,"latitude":61.211},{"longitude":-169.2321,"latitude":60.0437},{"longitude":-168.4954,"latitude":59.3518},{"longitude":-164.857,"latitude":59.3286},{"longitude":-164.0069,"latitude":58.4443}]}';
        var json_2 = '{"type":"routeOpt","uuid":"c5b581e68e3743a9af80dd32c46b8d07","cost":3601.75,"petroleum":1960.2,"timeConsume":79.5,"len":1200.0,"waypoints":[{"longitude":-157.161,"latitude":71.438},{"longitude":-158.045,"latitude":71.2568},{"longitude":-159.0198,"latitude":71.1838},{"longitude":-160.5159,"latitude":70.9373},{"longitude":-162.4541,"latitude":70.4654},{"longitude":-164.0183,"latitude":69.8655},{"longitude":-164.7663,"latitude":69.5153},{"longitude":-166.3418,"latitude":69.3361},{"longitude":-166.9425,"latitude":69.0705},{"longitude":-168.5407,"latitude":69.7049},{"longitude":-170.3995,"latitude":69.4438},{"longitude":-170.5129,"latitude":68.4755},{"longitude":-169.2094,"latitude":67.8943},{"longitude":-168.0306,"latitude":67.0608},{"longitude":-165.3557,"latitude":66.9855},{"longitude":-163.5649,"latitude":66.8166},{"longitude":-162.6128,"latitude":66.0692},{"longitude":-163.3382,"latitude":66.4841},{"longitude":-163.8143,"latitude":66.6644},{"longitude":-165.7071,"latitude":66.5519},{"longitude":-166.8292,"latitude":66.3617},{"longitude":-168.4954,"latitude":65.8243},{"longitude":-168.1213,"latitude":65.109},{"longitude":-166.9312,"latitude":64.7875},{"longitude":-166.3305,"latitude":64.3396},{"longitude":-165.197,"latitude":64.2905},{"longitude":-163.8143,"latitude":64.3151},{"longitude":-162.2841,"latitude":64.2659},{"longitude":-161.1847,"latitude":64.0485},{"longitude":-162.0234,"latitude":63.7694},{"longitude":-163.2135,"latitude":63.2588},{"longitude":-164.245,"latitude":63.4317},{"longitude":-166.1378,"latitude":63.2894},{"longitude":-166.6932,"latitude":62.7574},{"longitude":-166.8065,"latitude":61.9607},{"longitude":-168.2007,"latitude":61.211},{"longitude":-169.2321,"latitude":60.0437},{"longitude":-168.4954,"latitude":59.3518},{"longitude":-164.857,"latitude":59.3286},{"longitude":-164.0069,"latitude":58.4443}]}';
        var json_3 = '{"type":"routeOpt","uuid":"c5b581e68e3743a9af80dd32c46b8d08","cost":3601.75,"petroleum":1960.2,"timeConsume":79.5,"len":1200.0,"waypoints":[{"longitude":-123.161,"latitude":71.438},{"longitude":-158.045,"latitude":71.2568},{"longitude":-159.0198,"latitude":71.1838},{"longitude":-160.5159,"latitude":70.9373},{"longitude":-162.4541,"latitude":70.4654},{"longitude":-164.0183,"latitude":69.8655},{"longitude":-164.7663,"latitude":69.5153},{"longitude":-166.3418,"latitude":69.3361},{"longitude":-166.9425,"latitude":69.0705},{"longitude":-168.5407,"latitude":69.7049},{"longitude":-170.3995,"latitude":69.4438},{"longitude":-170.5129,"latitude":68.4755},{"longitude":-169.2094,"latitude":67.8943},{"longitude":-168.0306,"latitude":67.0608},{"longitude":-165.3557,"latitude":66.9855},{"longitude":-163.5649,"latitude":66.8166},{"longitude":-162.6128,"latitude":66.0692},{"longitude":-163.3382,"latitude":66.4841},{"longitude":-163.8143,"latitude":66.6644},{"longitude":-165.7071,"latitude":66.5519},{"longitude":-166.8292,"latitude":66.3617},{"longitude":-168.4954,"latitude":65.8243},{"longitude":-168.1213,"latitude":65.109},{"longitude":-166.9312,"latitude":64.7875},{"longitude":-166.3305,"latitude":64.3396},{"longitude":-165.197,"latitude":64.2905},{"longitude":-163.8143,"latitude":64.3151},{"longitude":-162.2841,"latitude":64.2659},{"longitude":-161.1847,"latitude":64.0485},{"longitude":-162.0234,"latitude":63.7694},{"longitude":-163.2135,"latitude":63.2588},{"longitude":-164.245,"latitude":63.4317},{"longitude":-166.1378,"latitude":63.2894},{"longitude":-166.6932,"latitude":62.7574},{"longitude":-166.8065,"latitude":61.9607},{"longitude":-168.2007,"latitude":61.211},{"longitude":-169.2321,"latitude":60.0437},{"longitude":-168.4954,"latitude":59.3518},{"longitude":-164.857,"latitude":59.3286},{"longitude":-164.0069,"latitude":58.4443}]}';
        var json_4 = '{"type":"active"}';
        var json_6 = '{"type":"routeOpt","uuid":"c5b581e68e3743a9af80dd32c46b8d03","cost":3601.75,"petroleum":1960.2,"timeConsume":79.5,"len":1200.0,"waypoints":[{"longitude":-122.22108,"latitude":37.48151,"id":0},{"longitude":-128.40889,"latitude":37.39641,"id":1},{"longitude":-134.46446,"latitude":37.31411,"id":2},{"longitude":-141.45268,"latitude":37.23001,"id":3},{"longitude":-147.20836,"latitude":37.14551,"id":4},{"longitude":-153.36897,"latitude":37.60791,"id":5},{"longitude":-159.52177,"latitude":36.57521,"id":6},{"longitude":-166.68799,"latitude":36.49151,"id":7},{"longitude":-172.20964,"latitude":36.40731,"id":8},{"longitude":-178.34306,"latitude":36.32291,"id":9},{"longitude":175.50336,"latitude":36.24571,"id":10},{"longitude":169.3823,"latitude":36.16201,"id":11},{"longitude":163.2678,"latitude":36.76941,"id":12},{"longitude":157.15787,"latitude":35.59231,"id":13},{"longitude":151.5863,"latitude":35.50751,"id":14},{"longitude":144.55775,"latitude":35.42291,"id":15},{"longitude":139.5012,"latitude":35.16441,"id":16},{"longitude":139.47238,"latitude":35.35361,"id":17}]}';
        var json_7 = '{"type":"routeOpt","uuid":"c5b581e68e3743a9af80dd32c46b8d03","cost":3601.75,"petroleum":1960.2,"timeConsume":79.5,"len":1200.0,"waypoints":[{"longitude":-122.22108,"latitude":37.48151,"id":0},{"longitude":-128.40889,"latitude":37.39641,"id":1},{"longitude":-134.46446,"latitude":37.31411,"id":2},{"longitude":-141.45268,"latitude":37.23001,"id":3},{"longitude":-147.20836,"latitude":37.14551,"id":4},{"longitude":-153.36897,"latitude":37.60791,"id":5},{"longitude":-159.52177,"latitude":36.57521,"id":6},{"longitude":-166.68799,"latitude":36.49151,"id":7},{"longitude":-172.20964,"latitude":36.40731,"id":8},{"longitude":-178.34306,"latitude":36.32291,"id":9}]}';
        var json_5 = '{"type":"routeOpt","point_num":6,"len":1200.0,"waypoints":[{"longitude":-125.22108111,"latitude":37.48151111,"wind_speed":1,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"current_speed":0.0,"current_direction":0.0,"id":0},{"longitude":-128.40889,"latitude":37.39641,"wind_speed":0.0,"wind_direction":2,"wave_height":0.0,"wave_direction":0.0,"current_speed":0.0,"current_direction":0.0,"id":1},{"longitude":-134.46446,"latitude":37.31411,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"current_speed":0.0,"current_direction":0.0,"id":2},{"longitude":-141.45268,"latitude":37.23001,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"current_speed":0.0,"current_direction":0.0,"id":3},{"longitude":-147.20836,"latitude":37.14551,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"current_speed":0.0,"current_direction":0.0,"id":4},{"longitude":-153.36897,"latitude":37.60791,"wind_speed":0.0,"wind_direction":0.0,"wave_height":0.0,"wave_direction":0.0,"current_speed":0.0,"current_direction":0.0,"id":5}]}';
        
       // var json_8='{"shipLongitude": 157.11111,"shipLatitude":71.438111,"type":"shipPos","head":68.0,"waypoints":[{"longitude":176.789001,"latitude":27.452999,"id":0},{"longitude":31.0,"latitude":121.0,"id":1},{"longitude":176.789001,"latitude":27.452999,"id":2},{"longitude":31.0,"latitude":121.0,"id":3},{"longitude":176.789001,"latitude":27.452999,"id":4},{"longitude":31.0,"latitude":121.0,"id":5},{"longitude":176.789001,"latitude":27.452999,"id":6},{"longitude":31.0,"latitude":121.0,"id":7},{"longitude":176.789001,"latitude":27.452999,"id":8},{"longitude":31.0,"latitude":121.0,"id":9},{"longitude":176.789001,"latitude":27.452999,"id":10},{"longitude":31.0,"latitude":121.0,"id":11},{"longitude":176.789001,"latitude":27.452999,"id":12},{"longitude":31.0,"latitude":121.0,"id":13},{"longitude":176.789001,"latitude":27.452999,"id":14},{"longitude":31.0,"latitude":121.0,"id":15},{"longitude":176.789001,"latitude":27.452999,"id":16},{"longitude":31.0,"latitude":121.0,"id":17},{"longitude":176.789001,"latitude":27.452999,"id":18},{"longitude":31.0,"latitude":121.0,"id":19},{"longitude":176.789001,"latitude":27.452999,"id":20},{"longitude":31.0,"latitude":121.0,"id":21},{"longitude":176.789001,"latitude":27.452999,"id":22},{"longitude":31.0,"latitude":121.0,"id":23},{"longitude":176.789001,"latitude":27.452999,"id":24},{"longitude":31.0,"latitude":121.0,"id":25},{"longitude":176.789001,"latitude":27.452999,"id":26},{"longitude":31.0,"latitude":121.0,"id":27},{"longitude":176.789001,"latitude":27.452999,"id":28},{"longitude":31.0,"latitude":121.0,"id":29},{"longitude":176.789001,"latitude":27.452999,"id":30},{"longitude":31.0,"latitude":121.0,"id":31},{"longitude":176.789001,"latitude":27.452999,"id":32},{"longitude":31.0,"latitude":121.0,"id":33},{"longitude":176.789001,"latitude":27.452999,"id":34},{"longitude":31.0,"latitude":121.0,"id":35},{"longitude":176.789001,"latitude":27.452999,"id":36},{"longitude":31.0,"latitude":121.0,"id":37},{"longitude":176.789001,"latitude":27.452999,"id":38},{"longitude":31.0,"latitude":121.0,"id":39},{"longitude":176.789001,"latitude":27.452999,"id":40},{"longitude":31.0,"latitude":121.0,"id":41},{"longitude":176.789001,"latitude":27.452999,"id":42},{"longitude":31.0,"latitude":121.0,"id":43},{"longitude":176.789001,"latitude":27.452999,"id":44}]}';
       
       var json_8='{"shipLongitude":172.789001,"shipLatitude":71.43811,"NMS":100,"SOG":1,"wind_speed":0,"wind_direction":1,"wave_direction":1,"wave_height":2,"type":"shipPos","head":68.0,"waypoints":[{"longitude":176.789001,"latitude":27.452999,"id":0},{"longitude":31.0,"latitude":121.0,"id":1},{"longitude":176.789001,"latitude":27.452999,"id":2},{"longitude":31.0,"latitude":121.0,"id":3},{"longitude":176.789001,"latitude":27.452999,"id":4},{"longitude":31.0,"latitude":121.0,"id":5}]}';
        var webSocData_route = new Array();
        //解析
        var rot_name = new Array();
        var rptLat = new Array();
        var rptLon = new Array();
      
      
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
        var layer_mapnik;                      // 1
        var layer_marker;                      // 2
        var layer_ECA;             // 6
        var layer_pois;                        // 7
        var layer_nautical_route;
        var layer_nauticalRoute_list;              // 9
        var layer_grid;                        // 10

        var layer_ais;                         // 13
        var layer_satpro;                      // 14
      
        var layer_permalink;                   // 17
        var layer_RouteOpt;
        var layer_weather_wind;
        var layer_weather_waves;
        var layer_weather_swell;
        var layer_weather_current;
        var layer_ship;
        var layer_dam;
        
        var layer_style = OpenLayers.Util.extend({}, OpenLayers.Feature.Vector.style['default']);
        layer_style.fillOpacity = 0.2;//0.2
        layer_style.graphicOpacity = 1;//1

        // To not change the permalink layer order, every removed
        // layer keeps its number. The ArgParser compares the
        // count of layers with the layers argument length. So we
        // have to let him know, how many layers are removed.
        var ignoredLayers = 2;
        // Select controls
        var selectControl;
        // Controls
        var ZoomBar = new OpenLayers.Control.PanZoomBar();
        var permalinkControl = new OpenSeaMap.Control.Permalink(null, null, {
            ignoredLayers: ignoredLayers
        });
        // Marker that is pinned at the last location the user searched for and selected.
        var searchedLocationMarker = null;
        // Load map for the first time
        var ws_data;
        //航线评估数据解析绘制
        function NauticalRoute_resolve(data_received) {
            var style_blue = {
                strokeColor: "#1E90FF",
                strokeWidth: 3,
                pointRadius: 6,
                pointerEvents: "visiblePainted",
                display: "inline"
            };
            for (var i = 0; i < data_received.length; i++) {
                rptPoint_array[i] = new Array();
                rptPoint_vector[i] = new Array();
                rptPoint = data_received[i]["waypoints"];
                for (var j = 0; j < rptPoint.length; j++) {
                    rptLon[j] = rptPoint[j]["longitude"];
                }
                var preLat = 0;
                var preLon = 0;
                for (var j = 0; j < rptPoint.length; j++) {
                    rptLat[j] = rptPoint[j]["latitude"];
                    // 处理跨越子午线绘制问题
                    if (j === 0) {
                        preLon = rptLon[j];
                    } else {
                        preLon = CriticalDeal(preLon, rptLon[j]);
                    }
                    rptPoint_array[i][j] = new OpenLayers.Geometry.Point(lon2x(preLon), lat2y(rptLat[j]));
                    rptPoint_vector[i][j] = new OpenLayers.Feature.Vector(rptPoint_array[i][j], null, rptPointStyle);
                }
                if (data_received[i]["type"] == 'routeOpt') {
                    rot_name[i] = data_received[i]["uuid"];
                    courseFeature[i] = new OpenLayers.Feature.Vector(new OpenLayers.Geometry.LineString(rptPoint_array[i]), null, style_blue);
                }
            }
        }
        function init() {
            //重复航线过滤
            var wayPoint = new Array();
            for (var i = 0; i < webSocData_route.length; ++i) {
                wayPoint[i] = webSocData_route[i]["waypoints"];
            }
            if (webSocData_route.length >= 2) {
                for (var i = webSocData_route.length - 2; i >= 0; i--) {
                    for (var j = webSocData_route.length - 1; j >= i + 1; j--) {
                        if (wayPoint[i].length === wayPoint[j].length) {
                            var num = 0;
                            var Lat = new Array();
                            var Lon = new Array();
                            var Lat1 = new Array();
                            var Lon1 = new Array();
                            for (var k = 0; k < wayPoint[i].length; k++) {
                                Lon[k] = wayPoint[i][k]["longitude"];
                                Lat[k] = wayPoint[i][k]["latitude"];
                                Lon1[k] = wayPoint[j][k]["longitude"];
                                Lat1[k] = wayPoint[j][k]["latitude"];
                                if ((Lon[k] === Lon1[k]) && (Lat[k] === Lat1[k]))
                                    num++;
                            }
                            if (num === wayPoint[i].length) {
                                webSocData_route.splice(i, 1);
                                wayPoint.splice(i, 1);
                            }
                        }
                    }
                }
            }
            layer_RouteOpt = new OpenLayers.Layer.Vector("Simple Geometry", {
                layerId:18,
                style: layer_style,
                visibility: true
            });
            addSub_routeList();//要加上
            var buffZoom = parseInt(getCookie("zoom"));
            var buffLat = parseFloat(getCookie("lat"));
            var buffLon = parseFloat(getCookie("lon"));
            mLat = getArgument("mlat");
            mLon = getArgument("mlon");
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
            //var sceneLon= parent.document.getElementById("sceneLon");   
            //var sceneLat= parent.document.getElementById("sceneLat"); 
            //var sceneZoom= parent.document.getElementById("sceneZoom"); 
            //还需要页面刷新
            var lonlat = new OpenLayers.LonLat(103.478702, 29.302671);
            lonlat.transform(proj4326, projMerc);
            map.setCenter(lonlat, 19);
            layer_marker = new OpenLayers.Layer.Markers("Marker", {
                layerId: -2 // invalid layerId -> will be ignored by layer visibility setup
            });
            map.addLayer(layer_marker);
            try {
                // Create Marker, if arguments are given
                if (mLat != -1 && mLon != -1) {
                    var mtext = he.encode(decodeURIComponent(getArgument("mtext")))
                        .replace(/\n/g, '<br/>');
                    mtext = mtext.replace('&#x3C;b&#x3E;', '<b>')
                        .replace('&#x3C;%2Fb&#x3E;', '</b>')
                        .replace('&#x3C;/b&#x3E;', '</b>');
                    addMarker(layer_marker, mLon, mLat, mtext);
                }
            } catch (err) {
                console.log(err)
            }
            readLayerCookies();
            resetLayerCheckboxes();
            initMenuTools();
            // Set current language for internationalization
            OpenLayers.Lang.setCode(language);
			
			var search = location.search;
			//alert(search);
			var a = search.slice(1,search.indexOf("&"))
			a=a.slice(a.indexOf("=")+1);
			// alert(a);
			var b = search.slice(search.indexOf("&")+1);
			b=b.slice(b.indexOf("=")+1);
			// alert(b);
			// jumpTo(a, b, 19);
			jumpToSearchedLocation(a,b);
			
			
			
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
            if (getCookie("GridWGSLayerVisible") === "-1")
                gridVisible = true; // default to visible
            layer_grid.setVisibility(gridVisible);
            var ECAVisible = getCookie("ECALayerVisible") === "true"
            layer_ECA.setVisibility(ECAVisible);
            
            if (getCookie("AisLayerVisible") == "true") {
                showAis();
            }
        }
        function resetLayerCheckboxes() {
            // This method is separated from readLayerCookies because
            // the permalink control also will set the visibility of
            // layers.
            document.getElementById("checkLayerGridWGS").checked = (layer_grid.getVisibility() === true);
            document.getElementById("checkLayerWeatherWind").checked = (layer_weather_wind.getVisibility() === true);
            document.getElementById("checkLayerWeatherWaves").checked = (layer_weather_waves.getVisibility() === true);
            document.getElementById("checkLayerWeatherSwell").checked = (layer_weather_swell.getVisibility() === true);
            document.getElementById("checkLayerWeatherCurrent").checked = (layer_weather_current.getVisibility() === true);
            document.getElementById("checkLayerECA").checked = (layer_ECA.getVisibility() === true);
            document.getElementById("checkNauticalRoute").checked = (layer_nautical_route.getVisibility() === true);
            document.getElementById("checkPermalink").checked = (layer_permalink.getVisibility() === true);
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
        function toggleSubList(show, i) {
            if (show) {
                document.getElementById(rot_name[i]).checked = true;
                addNauticalRouteList(i);
                routeList_table(i);
                NauticalRouteList_routeAdded(i);
            }
            else {
                document.getElementById(rot_name[i]).checked = false;
                // courseFeature[i].style.display="none";
                closeNauticalRouteList(i);
                //  closeAct(i);
            }
        }
        function toggleNauticalRouteList(show) {
            if (show) {
                document.getElementById("checkNauticalRouteList").checked = true;
                if (document.getElementById("checkNauticalRouteList").checked === false)
                    for (var i = 0; i < webSocData_route.length; ++i)
                        document.getElementById(rot_name[i]).checked = false;
            }
            else
                document.getElementById("checkNauticalRouteList").checked = false;
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
        /// update visual elements based onlayer visibility
        // Show dialog window
        function showActionDialog(htmlText) {
            document.getElementById("actionDialog").style.visibility = 'visible';
            document.getElementById("actionDialog").innerHTML = "" + htmlText + "";
        }
        // Hide dialog window
        function closeActionDialog() {
            document.getElementById("actionDialog").style.visibility = 'hidden';
        }
        function selectedMap(event) {
            var feature = event.feature;
            downloadName = feature.attributes.name;
            downloadLink = feature.attributes.link;
            var mapName = downloadName;
            document.getElementById('info_dialog').innerHTML = "" + mapName + "";
            document.getElementById('buttonMapDownload').disabled = false;
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
            htmlText += "<tr><td><input type=\"button\" id=\"buttonNauticalRouteOptimization\" value=\"Optimization\" onClick=\"NauticalRoute_Optimization();\" disabled=\"true\">&nbsp</td></tr>"
            htmlText += "<tr><td><input type=\"button\" id=\"buttonNauticalCancelOptimization\" value=\"CancelOptimization\" onClick=\"NauticalRoute_CancelOptimization();\" disabled=\"true\">&nbsp</td></tr>"
            htmlText += "<tr><td><input type=\"button\" id=\"buttonNauticalRouteActive\" value=\"Active\" onClick=\"NauticalRoute_active();\" disabled=\"true\">&nbsp</td></tr>"
            htmlText += "<tr><td><input type=\"button\" id=\"buttonNauticalCancelActive\" value=\"CancelActive\" onClick=\"NauticalRoute_CancelActive();\" disabled=\"true\">&nbsp</td></tr>"
            showActionDialog(htmlText);
            NauticalRoute_startEditMode();
        }
        function addNauticalRouteList() {
            layer_nauticalRoute_list.setVisibility(true);
        }
        function addNauticalRouteList(route_id) {//添加航线信息表格
            //    courseFeature[i].style.display="inline";
            var htmlText = "<div style=\"position:absolute; top:5px; right:5px; cursor:pointer;\">";
            htmlText += "<img src=\"./resources/action/close.gif\" onClick=\"closeActionDialog();\"/></div>";
            htmlText += "<h3>" + rot_name[route_id] + ":</h3>";
            htmlText += "<table border=\"0\" width=\"370px\">";
            htmlText += "<tr><td><?=$t->tr("start")?></td><td id=\"routeStart\">- - -</td></tr>";
            htmlText += "<tr><td><?=$t->tr("finish")?></td><td id=\"routeEnd\">- - -</td></tr>";
            htmlText += "<tr><td><?=$t->tr("distance")?></td><td id=\"routeDistance\">- - -</td></tr>";
            htmlText += "<tr><td id=\"routePoints\" colspan = 2> </td></tr>";
            htmlText += "<tr><td><br/><input type=\"button\" id=\"buttonActionDialogClose\" value=\"<?=$t->tr("close")?>\" onclick=\"closeNauticalRouteList(" + route_id + ")\";\"closeActionDialog()\";></td></tr></table>";
            showActionDialog(htmlText);
        }
        function closeNauticalRoute() {
            layer_nautical_route.setVisibility(true);
            closeActionDialog();
            NauticalRoute_stopEditMode();
        }
        function clearNauticalRoute() {
            layer_nautical_route.setVisibility(true);
            closeActionDialog();
            NauticalRoute_clearRoute();
        }
        function closeNauticalRouteList(route_id) {
            layer_RouteOpt.removeFeatures(courseFeature[route_id]);
            layer_RouteOpt.removeFeatures(rptPoint_vector[route_id]);
        }
        function closeAllRouteList() {
            for (var i = 0; i < webSocData_route; i++)
                courseFeature[i].style.display = "none";
            closeActionDialog();
        }
        function onAddMarker(e) {
            // Marker Init
            var size = new OpenLayers.Size(32, 32); // size of the marker
            var offset = new OpenLayers.Pixel(-(size.w / 2), -size.h); // offset to get the pinpoint of the needle to mouse pos
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
            var lon_m = Math.abs(lonlat.lon * 60).toFixed(3);
            var lat_m = Math.abs(lonlat.lat * 60).toFixed(3);
            var lon_d = Math.floor(lon_m / 60);
            var lat_d = Math.floor(lat_m / 60);
            lon_m -= lon_d * 60;
            lat_m -= lat_d * 60;
            // Write the specified content inside
            OpenLayers.Util.getElement("markerpos").innerHTML = ns + lat_d + "°" + format2FixedLength(lat_m, 6, 3) + "'" + " " + we + lon_d + "°" + format2FixedLength(lon_m, 6, 3) + "'";
            $("#markerpos").data("lat", lonlat.lat.toFixed(5))
            $("#markerpos").data("lon", lonlat.lon.toFixed(5))
            createPermaLink();
        }
        function createPermaLink() {
            if (!layer_permalink.visibility)
                return;
            if (!OpenLayers.Util.getElement("permalinkDialog"))
                return;
            // Create Permalink for Layers
            var layersPermalink = permalinkControl.getLayerString();
            layersPermalink = permalinkControl.setFlag(layersPermalink, 'F', layer_permalink.layerId);
            // Generate Permalink for copy and paste
            var url = window.location.href;
            var userURL = url.substr(0, url.lastIndexOf('/') + 1)
            userURL += "?zoom=" + map.getZoom(); // add map zoom to string
            userURL += "&lat=" + y2lat(map.getCenter().lat).toFixed(5); // add map zoom to string
            userURL += "&lon=" + x2lon(map.getCenter().lon).toFixed(5); // add map zoom to string
            var lat = $("#markerpos").data("lat")
            if (lat)
                userURL += "&mlat=" + lat; // add latitude
            var lon = $("#markerpos").data("lon")
            if (lon)
                userURL += "&mlon=" + $("#markerpos").data("lon"); // add longitude
            var mText = encodeURIComponent(document.getElementById("markerText").value)
            if (mText != "")
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
            $('#markerText').on('keyup', function (evt) {
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
            for (i = 0; i < items.length; i++) {
                buff = xmlHttp.responseXML.getElementsByTagName('place')[i].getAttribute('display_name');
                placeLat = xmlHttp.responseXML.getElementsByTagName('place')[i].getAttribute('lat');
                placeLon = xmlHttp.responseXML.getElementsByTagName('place')[i].getAttribute('lon');
                // console.log(placeLat+","+placeLon)
				pos = buff.indexOf(",");
                placeName = buff.substring(0, pos);
                description = buff.substring(pos + 1).trim();
                htmlText += "<tr style=\"cursor:pointer;\" onmouseover=\"this.style.backgroundColor = '#ADD8E6';\"onmouseout=\"this.style.backgroundColor = '#FFF';\" onclick=\"jumpToSearchedLocation(" + placeLon + ", " + placeLat + ");\"><td  valign=\"top\"><b>" + placeName + "</b></td><td>" + description + "</td></tr>";
            }
            htmlText += "<tr><td>&nbsp;</td><td align=\"right\"><br/><input type=\"button\" id=\"buttonMapClose\" value=\"<?=$t->tr("close")?>\" onclick=\"closeActionDialog();\"></td></tr></table>";
            showActionDialog(htmlText);
        }
        function drawmap() {
             map = new OpenLayers.Map('map', {
                numZoomLevels: 20,
                projection: projMerc,
                displayProjection: proj4326,
                eventListeners: {
                    moveend: mapEventMove,
                    zoomend: mapEventZoom,
                    click: mapEventClick,
                    changelayer: mapChangeLayer
                },
                controls: [
                    permalinkControl,
                    new OpenLayers.Control.Navigation(),
                    new OpenLayers.Control.ScaleLine({ topOutUnits: "nmi", bottomOutUnits: "km", topInUnits: 'nmi', bottomInUnits: 'km', maxWidth: '40' }),
                    new OpenLayers.Control.MousePositionDM(),
                    new OpenLayers.Control.OverviewMap(),
                    ZoomBar
                ]
            }
            );
            var bboxStrategyWikipedia = new OpenLayers.Strategy.BBOX({
                ratio: 1.1,
                resFactor: 1
            });
            var poiLayerWikipediaHttp = new OpenLayers.Protocol.HTTP({
                url: 'api/proxy-wikipedia.php?',
                params: {
                    'LANG': language,
                    'thumbs': 'no'
                },
                format: new OpenLayers.Format.KML({
                    extractStyles: true,
                    extractAttributes: true
                })
            });
            // Select feature ---------------------------------------------------------------------------------------------------------
            // (only one SelectFeature per map is allowed)
            selectControl = new OpenLayers.Control.SelectFeature([], {
                onSelect: function (feature) {
                },
                hover: true,
                popup: null,
                addLayer: function (layer) {
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
                removePopup: function () {
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
              //离线
               // 'http://'+IP+':'+PORT+'/online_chart/osm_tiles1/${z}/${x}/${y}.png'
               //在线海图
               'https://a.tile.openstreetmap.org/${z}/${x}/${y}.png'
            ], {
                    layerId: 1,
                    wrapDateLine: true
                });
                layer_ship = new OpenLayers.Layer.Vector(
                    "Simple Geometry",
                    {
                        layerId:19,
                        visibility: true,
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
                var renderer = OpenLayers.Util.getParameters(window.location.href).renderer;
            renderer = (renderer) ? [renderer] : OpenLayers.Layer.Vector.prototype.renderers;
                layer_dam = new OpenLayers.Layer.Vector(
                    "Simple Geometry",{
                   // style: layer_style,
                   // renderers: renderer
                        layerId:1,
                        visibility: true,
                        styleMap: new OpenLayers.StyleMap({
                            "default": {
                              graphic:true,
                              backgroundGraphic: "./resources/icons/dam1.svg",
                                graphicHeight: 1816.2,//4843.2,
                                graphicWidth:1503.075,//4008.2,
                                //  graphicHeight: 1300,
                                // graphicWidth:1000,
                                // rotation: "${angle}",
                                fillOpacity: "${opacity}"
                            },
                        })
                     }
                );
                var damFeatures = [];
                damFeatures.push(
                  new OpenLayers.Feature.Vector(
                    //需传入平面坐标
            new OpenLayers.Geometry.Point(lon2x(103),lat2y(29)), { angle: getCookie("shipHead"), opacity: 1 }
            )
          );
   // map.addLayer(layer_ship);
   //绘制的龚嘴大坝图层可见
    //layer_dam.setVisibility(true);
    //layer_dam.addFeatures(damFeatures);
  
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
                   // time: currentTime,
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
                displayOutsideMaxExtent: true
            });
          
            // Trip planner
            layer_nautical_route = new OpenLayers.Layer.Vector("Trip Planner", {
                layerId: 9,
                styleMap: routeStyle,
                visibility: false,
                eventListeners: {
                    "featuresadded": NauticalRoute_routeAdded,
                    "featuremodified": NauticalRoute_routeModified
                }
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
            // Disaster (15)
            // POI-Layer for tidal scales
            // Permalink
            layer_permalink = new OpenLayers.Layer.Markers("Permalink", {
                layerId: 17,
                visibility: false,
                projection: proj4326
            });

            map.addLayers([
              layer_mapnik,
              layer_dam,
                layer_weather_wind,
                layer_weather_swell,
                layer_weather_current,
                layer_weather_waves,
                layer_ECA,
                layer_grid,
                layer_pois,
                layer_nautical_route,
                layer_satpro,
                layer_ship,
                layer_permalink,
                layer_RouteOpt
            ]);
            if (!map.getCenter()) {
                jumpTo(lon, lat, zoom);
            }
            // Register featureselect for poi layers
            selectControl.addLayer(layer_nautical_route);
            layer_nautical_route.events.register("featureselected", layer_nautical_route, onFeatureSelectPoiLayers);
            selectControl.addLayer(layer_pois);
            selectControl.addLayer(layer_RouteOpt);
            layer_RouteOpt.events.register("featureselected", layer_RouteOpt, onFeatureSelectPoiLayers);
            rptPoint = new Array();
            layer_pois.events.register("featureselected", layer_pois, onFeatureSelectPoiLayers);
          
            // Activate select control
            map.addControl(selectControl);
            selectControl.activate();
        }
        function clearPoiLayer() {
            harbours = [];
            layer_pois.removeAllFeatures();
        }
        function onFeatureSelectPoiLayers(event) {
            feature = event.feature;
            if (feature.layer == layer_nautical_route) {
                feature.style = style_edit;
            } else {
                selectControl.removePopup();
                if (feature.data.popupContentHTML) {
                    var buff = feature.data.popupContentHTML;
                } else {
                    for (i in webSocData_route)
                        for (j in rptPoint_array[i])
                            if (feature.geometry.id === rptPoint_array[i][j].id) {
                                var buff='<p style=indexFont>longitude:' + lon2DegreeMinute(rptLon[j])+'<br>';
                                buff+='latitude:' + lat2DegreeMinute(rptLat[j])+'<br>';
                                buff+='windspeed:' + rptPoint[j].wind_speed+'m/s<br>';
                                buff+='winddirection:' + rptPoint[j].wind_direction+ '°<br>';
                                buff+='currentspeed:' + rptPoint[j].current_speed+ 'm/s<br>';
                                buff+='currentdirection:' + rptPoint[j].current_direction+ '°<br>';
                                buff+='waveheight:' + rptPoint[j].wave_height+ 'm<br>';
                                buff+='wavedirection:' + rptPoint[j].wave_direction+ '°<br></p>';
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
        }
        // Map event listener moved
        function mapEventMove(event) {
            // Set cookie for remembering lat lon values
            setCookie("lat", y2lat(map.getCenter().lat).toFixed(5));
            setCookie("lon", x2lon(map.getCenter().lon).toFixed(5));
            // Update harbour layer
            // if (layer_pois.getVisibility() === true) {
            //     refreshHarbours();
           // }
        }
        // Map event listener Zoomed
        function mapEventZoom(event) {
            zoom = map.getZoom();
            // Set cookie for remembering zoomlevel
            setCookie("zoom", zoom);
            // Clear POI layer
            clearPoiLayer();
            if (oldZoom != zoom) {
                oldZoom = zoom;
            }
        }
        function mapEventClick(event) {
            selectControl.removePopup();
        }
        // Map event listener changelayer
        function mapChangeLayer(event) {
            resetLayerCheckboxes();
        }
        function switchMenuTools(toolName, activate) {
            switch (toolName) {
                case 'nautical_route': {
                    togglePermalink(false);
                    toggleNauticalRouteList(false);
                    toggleNauticalRoute(activate);
                    for (var i in webSocData_route)
                        (document.getElementById(rot_name[i])).checked = false;
                }
                    break;
                case 'permalink':
                    {
                        toggleNauticalRoute(false);
                        toggleNauticalRouteList(false);
                        togglePermalink(activate);
                        for (var i in webSocData_route)
                            (document.getElementById(rot_name[i])).checked = false;
                    }
                    break;
                default:
                    break;
            }
            for (var i = 0; i < rot_name.length; i++)
                if (toolName === rot_name[i]) {
                    togglePermalink(false);
                    toggleNauticalRoute(false);
                    toggleNauticalRouteList(activate);
                    toggleSubList(activate, i);
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
            $('#topmenu2').find('[data-tools]').click(function (evt) {
                var layerName = $(evt.currentTarget).data('tools');
                var checked = $(evt.currentTarget).find('input').is(':checked');
                var checkboxClicked = $(evt.target).is('input');
                if (checkboxClicked) {
                    switchMenuTools(layerName, checked);
                } else {
                    switchMenuTools(layerName, !checked);
                }
            });
            $('#topmenu2').find('[data-na]').click(function (evt) {
                var layerName = $(evt.currentTarget).data('na');
                var checked = $(evt.currentTarget).find('input').is(':checked');
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

<body onload="init(); NauticalRoute_Receive();">
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

    <div id="wave_legend" style="position:absolute; bottom:60px; right:12px;  visibility:hidden;">
        <p>Wave Height</p>
        <img src="./resources/map/wave_height.png" height="20" width="300" />
        <p>Wave Period</p>
        <img src="./resources/map/wave_period.png" height="20" width="300" />
    </div>
    <?php include('classes/topmenu.inc'); ?>
    <?php include('classes/rightMenu.inc');?>
</body>

</html>