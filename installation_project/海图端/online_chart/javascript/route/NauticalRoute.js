/*航线*/
var IP = "localhost";//IP
var PORT = "9092";//端口号
var geoserverPort = "8087";//geoserver端口号
var indexFont = "font-size:100%;font-family:verdana";//航线评估弹出框字体大小样式
var SpeedFont = "font-size:100%;font-family:verdana";//航速优化弹出框字体大小样式
var shipFont = "font-size:100%;font-family:verdana";//船舶弹出框字体

var defaultStyle = {
  strokeColor: "blue",
  strokeOpacity: "0.8",
  strokeWidth: 3,
  fillColor: "blue",
  pointRadius: 3,
  cursor: "pointer"
};

var style = OpenLayers.Util.applyDefaults(defaultStyle, OpenLayers.Feature.Vector.style["default"]);
var routeStyle = new OpenLayers.StyleMap({
  'default': style,
  'select': {
    strokeColor: "red",
    fillColor: "red"
  }
});
var editPanel;
var routeDraw;
var routeEdit;
var routeList_editPanel;
var routeList_edit;
var pointList_edit;
var pointList_editPanel;
var routePoint_lat = new Array();
var routePoint_lon = new Array();
var course_distance = new Array(); //需要传给后台
var course_angle = new Array();
var point_array = new Array();
var routeTrack;
var routeObject;
var routeOptDraw;
var pointList_object;
var routeList_object;
var style_edit = {
  strokeColor: "#CD3333",
  strokeWidth: 3,
  pointRadius: 4
};
var ship_location = new OpenLayers.LonLat();
// var ship_head;
function NauticalRoute_initControls () {
  editPanel = new OpenLayers.Control.Panel();
  routeDraw = new OpenLayers.Control.DrawFeature(layer_nautical_route, OpenLayers.Handler.Path, {
    title: 'Draw line'
  });
  routeEdit = new OpenLayers.Control.ModifyFeature(layer_nautical_route, {
    title: 'Edit feature'
  });
  editPanel.addControls([routeDraw, routeEdit]);
  editPanel.defaultControl = routeDraw;
  map.addControl(editPanel);
  routeEdit.standalone = true;
}
function NauticalRoute_startEditMode () {
  NauticalRoute_initControls();
}

function NauticalRoute_clearRoute () {
  if (!routeDraw) {
    return;
  }
  routeDraw.deactivate();
  routeEdit.deactivate();
  layer_nautical_route.removeAllFeatures();
}
function NauticalRoute_stopEditMode () {
  if (!routeDraw) {
    return;
  }
  routeDraw.deactivate();
  routeEdit.deactivate();
}
function NauticalRoute_addMode () {
  routeDraw.activate();
  routeEdit.deactivate();
}
function NauticalRoute_editMode () {
  routeDraw.deactivate();
  routeEdit.activate();
  layer_nautical_route.style = style_blue;
}
function NauticalRoute_startEditLine () {
  routeDraw.activate();
  routeEdit.activate();
}
function NauticalRoute_DownloadTrack () {
  var format = document.getElementById("routeFormat").value;
  var mimetype, filename;
  switch (format) {
    case 'CSV':
      mimetype = 'text/csv';
      filename = 'route.csv';
      content = NauticalRoute_getRouteCsv(routeTrack);
      break;
    case 'KML':
      mimetype = 'application/vnd.google-earth.kml+xml';
      filename = 'route.kml';
      content = NauticalRoute_getRouteKml(routeTrack);
      break;
    case 'GPX':
      mimetype = 'application/gpx+xml';
      filename = 'route.gpx';
      content = NauticalRoute_getRouteGpx(routeObject);
      break;
    case 'GML':
      mimetype = 'application/gml+xml';
      filename = 'route.gml';
      content = NauticalRoute_getRouteGml(routeObject);
      break;
  }
  // Remove previous added forms
  $('#actionDialog > form').remove();
  form = document.createElement('form');
  form.id = this.id + '_export_form';
  form.method = 'post';
  form.action = './api/export.php';
  document.getElementById('actionDialog').appendChild(form);
  div = document.createElement('div');
  div.className = this.displayClass + "Control";
  form.appendChild(div);
  input = document.createElement('input');
  input.id = this.id + '_export_input_mimetype';
  input.name = 'mimetype';
  input.type = 'hidden';
  input.value = mimetype;
  div.appendChild(input);
  input = document.createElement('input');
  input.id = this.id + '_export_input_filename';
  input.name = 'filename';
  input.type = 'hidden';
  input.value = filename;
  div.appendChild(input);
  input = document.createElement('input');
  input.id = this.id + '_export_input_content';
  input.name = 'content';
  input.type = 'hidden';
  input.value = content;
  div.appendChild(input);
  $('#actionDialog > form').get(0).submit();
}
function NauticalRoute_routeAdded (event) {
  routeObject = event.object.features[0];
  routeTrack = routeObject.geometry.getVertices();
  routeDraw.deactivate();
  NauticalRoute_getPoints(routeTrack);
  // Select element for editing
  routeEdit.selectFeature(routeObject);
  document.getElementById('buttonRouteDownloadTrack').disabled = false;
  document.getElementById('buttonNauticalRouteOptimization').disabled = false;
  document.getElementById('buttonNauticalRouteActive').disabled = false;
}
function NauticalRoute_routeModified (event) {
  var routeObject = event.object.features[0];
  routeTrack = routeObject.geometry.getVertices();
  NauticalRoute_getPoints(routeTrack);
}
function Locate () {
  var shipFeatures = [];
  shipFeatures.push(
    new OpenLayers.Feature.Vector(
      //需传入平面坐标
      new OpenLayers.Geometry.Point(getCookie("shipLon"), getCookie("shipLat")), { angle: getCookie("shipHead"), opacity: 1 }

    )
  );
  // map.addLayer(layer_ship);
  layer_ship.setVisibility(true);
  layer_ship.addFeatures(shipFeatures);

  jumpTo(x2lon(getCookie("shipLon")), y2lat(getCookie("shipLat")), zoom);
}
function NauticalRouteList_routeAdded (route_id) {
  cost = webSocData_route[route_id]["cost"];
  petroleum = webSocData_route[route_id]["petroleum"];
  timeConsume = webSocData_route[route_id]["timeConsume"];
  len_ = webSocData_route[route_id]["len"];
  layer_RouteOpt.addFeatures([courseFeature[route_id]]);
  layer_RouteOpt.addFeatures(rptPoint_vector[route_id]);
  // jumpTo(rptLon[0], rptLat[0], zoom);
  courseFeature[route_id].style.display = "inline";
  layer_RouteOpt.setVisibility(true);
}
function RouteSpeed_routeAdded (route_id) {
  //转向点数组
  var leg_array = new Array(); //航段数组
  var leg_info = webSocData_speed[route_id]["legs"];
  var leg_num = webSocData_speed[route_id]["leg_num"];
  var speedOpt_array = new Array();
  var point_vector = new Array();
  var Lat = new Array();
  var Lon = new Array();
  var preLat = 0;
  var preLon = 0;
  var courseFeature = new Array();
  var legStyle = new Array();
  var leg_color = ["#B7DDE8", "#00B3F4", "#002060", "#00B050", "#FFFF00", "#FFC000", "#FF0000"];
  var speedSeparate = [0, 10, 12, 14, 16, 18, 20];
  for (var i = 0; i < 7; ++i) {
    legStyle[i] = {
      strokeWidth: 3,
      pointRadius: 6,
      pointerEvents: "visiblePainted"
    };
    legStyle[i].strokeColor = leg_color[i];
  }
  var rptPointStyle = {
    pointRadius: 6,
    fillColor: "#3f48cc",
    strokeWidth: 0
  };
  for (var i = 0; i < leg_num; i++) {
    Lon[i] = leg_info[i]["start_longitude"];
    Lat[i] = leg_info[i]["start_latitude"];
  }
  Lon[leg_num] = leg_info[leg_num - 1]["end_longitude"];
  Lat[leg_num] = leg_info[leg_num - 1]["end_latitude"];
  for (var i = 0; i < leg_num + 1; ++i) {
    // 处理跨越子午线绘制问题
    if (i === 0) {
      preLon = Lon[i];
    } else {
      preLon = CriticalDeal(preLon, Lon[i]);
    }
    point_array[i] = new OpenLayers.Geometry.Point(lon2x(preLon), lat2y(Lat[i]));
    point_vector[i] = new OpenLayers.Feature.Vector(point_array[i], null, rptPointStyle);
    rptPointStyle.display = "inline";
  }
  for (var i = 0; i < leg_num; i++) {
    leg_array[i] = new Array();
    speedOpt_array[i] = leg_info[i]["V"];
    leg_array[i].push(point_array[i]);
    leg_array[i].push(point_array[i + 1]);
    for (var j = 0; j < leg_color.length - 1; j++) {
      var speed_val = speedOpt_array[i];
      if ((speed_val > speedSeparate[j]) && (speed_val <= speedSeparate[j + 1])) {
        courseFeature[i] = new OpenLayers.Feature.Vector(new OpenLayers.Geometry.LineString(leg_array[i]), null, legStyle[j]);
        break;
      }
    }
    if (speedOpt_array[i] > speedSeparate[6]) {
      courseFeature[i] = new OpenLayers.Feature.Vector(new OpenLayers.Geometry.LineString(leg_array[i]), null, legStyle[6]);
    }
    if (speedOpt_array[i] <= speedSeparate[0]) {
      continue;
    }
    layer_speedOptimization.addFeatures([courseFeature[i]]);
  }
  layer_speedOptimization.addFeatures(point_vector);
  map.addLayer(layer_speedOptimization);
  //   jumpTo(Lon[0], Lat[0], zoom);
  layer_speedOptimization.setVisibility(true);
}
function routeList_edit (event) {
  routeList_object = event.object.features[0];
  routeList_edit.activate();
  routeList_edit.selectFeature(routeList_object);
}
function routeList_table (route_id) {
  //解析JSON 获取Point数组，id，航段距离并写入表格
  var point_array = new Array();
  var latA, latB, lonA, lonB, distance, bearing;
  var latLon_array = webSocData_route[route_id]["waypoints"];
  var latLon = {};
  var Lat = new Array();
  var Lon = new Array();
  for (var i = 0; i < latLon_array.length; i++) {
    Lon[i] = latLon_array[i]["longitude"];
    Lat[i] = latLon_array[i]["latitude"];
  }
  for (var i = 0; i < Lon.length; ++i) {
    point_array[i] = new OpenLayers.Geometry.Point(lon2x(Lon[i]), lat2y(Lat[i]));
  }
  var totalDistance = 0;
  var htmlText;
  htmlText = "<br/><table>";
  htmlText += "<tr bgcolor=\"#CCCCCC\"><td width=\"20\" align=\"center\"></td><td width=\"60\" align=\"center\">" + tableTextNauticalRouteCourse + "</td><td width=\"70\" align=\"center\">" + tableTextNauticalRouteDistance + "</td><td width=\"200\" align=\"center\">" + tableTextNauticalRouteCoordinate + "</td></tr>"
  document.getElementById("routeStart").innerHTML = lat2DegreeMinute(y2lat(point_array[0].y)) + " - " + lon2DegreeMinute(x2lon(point_array[0].x));
  for (i = 0; i < point_array.length - 1; i++) {
    latA = y2lat(point_array[i].y);
    lonA = x2lon(point_array[i].x);
    latB = y2lat(point_array[i + 1].y);
    lonB = x2lon(point_array[i + 1].x);
    distance = getDistance(latA, latB, lonA, lonB).toFixed(2);
    bearing = getBearing(latA, latB, lonA, lonB).toFixed(2);
    totalDistance += parseFloat(distance);
    htmlText += "<tr><td width=\"20\" align=\"right\">" + parseInt(i + 1) + ". </td>";
    htmlText += "<td width=\"60\" align=\"right\">" + bearing + "°</td>";
    htmlText += "<td width=\"70\" align=\"right\">" + distance + "nm</td>"; //lat2DegreeMinute(latB)
    htmlText += "<td width=\"200\" align=\"right\">" + lat2DegreeMinute(latB) + " - " + lon2DegreeMinute(lonB) + "</td></tr>";
  }
  htmlText += "</table>"
  document.getElementById("routeEnd").innerHTML = lat2DegreeMinute(latB) + " - " + lon2DegreeMinute(lonB);
  document.getElementById("routeDistance").innerHTML = totalDistance.toFixed(2) + "nm";
  document.getElementById("routePoints").innerHTML = htmlText;
}
function SpeedOpt_receive () {
  //var ws_connection = new WebSocket("ws://zzzzzsh.dynv6.net:8080/websocket"); //与服务器建立连接
  var ws_connection = new WebSocket("ws://localhost:9998/echo");
  // var ws_connection = new WebSocket(" ws://"+IP+":"+geoserverPort+"/NavigationDataService/websocket");
  ws_connection.onopen = function () {
    ws_connection.send(json_3);

    // Web Socket 已连接上，使用 send() 方法发送数据
    console.log("数据已连接...");
  };
  ws_connection.onmessage = function (event) {
    ws_data = JSON.parse(event.data); // data是要解析的接收到的JSON字符串,解析为json对象
    if (ws_data.type === "speedOpt") {
      if (webSocData_speed.length > 0) {
        webSocData_speed.splice(0, webSocData_speed.length);
      }
      webSocData_speed.push(ws_data);
    }
    else if (ws_data.type === "shipPos") {
      shipData_resolve(ws_data);

    }
    for (var i in webSocData_speed)
      RouteSpeed_routeAdded(i);
  }
  ws_connection.onerror = function (event) {
    console.log("Error" + event.data);
  }
}
//处理跨180°经线
function CriticalDeal (pre_lon, loc_lon) {
  if (pre_lon > 0 && loc_lon < 0) {
    loc_lon += 360;
  }
  else if (pre_lon < 0 && loc_lon > 0) {
    loc_lon -= 360;
  }
  return loc_lon;
}
var shipLocation = new OpenLayers.LonLat();

function shipData_resolve (data) {
  shipLocation = data;
  setCookie("shipLon", lon2x(data.shipLongitude));
  setCookie("shipLat", lat2y(data.shipLatitude));
  setCookie("shipHead", data.head);
  setCookie("shipNMS", data.NMS);
  setCookie("shipSOG", data.SOG);
  setCookie("shipWindSpeed", data.wind_speed);
  setCookie("shipWaveHeight", data.wave_height);
  setCookie("shipWindDirection", data.wind_direction);
  setCookie("shipWaveDirection", data.wave_direction);
  //return data;
}
function NauticalRoute_Receive () {
  // 航线评估
  //  var ws_connection = new WebSocket("ws://"+IP+":"+geoserverPort+"/NavigationDataService/RoutOpt"); //与服务器建立连接
  //var ws_connection = new WebSocket("ws://zzzzzsh.dynv6.net:8080/RoutOpt"); 
  var ws_connection = new WebSocket("ws://localhost:9998/echo");
  ws_connection.onopen = function () {
    console.log("数据已连接...");

    // ws_connection.send(json_8);
    ws_connection.send(json_5);

  };
  ws_connection.onmessage = function (event) {
    ws_data = JSON.parse(event.data); // data是要解析的接收到的JSON字符串,解析为json对象
    if (ws_data.type === "routeOpt") {
      webSocData_route.push(ws_data);
      NauticalRoute_resolve(webSocData_route);
      if (webSocData_route.length > 0) {
        for (i in webSocData_route) {
          NauticalRouteList_routeAdded(i);
        }
      }
    }
    else if (ws_data.type === "shipPos") {
      shipData_resolve(ws_data);
    }
    else if (ws_data.type === "active") {
      webSocData_route.splice(0, webSocData_route.length);
    }
  }
  ws_connection.onerror = function (event) {
    console.log("Error" + event.data);
  }
}
function addSub_routeList () {
  //添加二级checkbox
  var First_chex = document.getElementById("routeList_sub");
  for (var i = 0; i < webSocData_route.length; ++i) {
    First_chex.innerHTML += "<li data-na=" + rot_name[i] + "><a><input type=\"checkbox\"/ checked=\"checked\"/  id=" + rot_name[i] + ">&nbsp;" + rot_name[i] + "</a></li>";
  }
}
function addSpeed_routeList () {
  //添加二级checkbox
  var First_chex = document.getElementById("routeList_sub");
  for (var i = 0; i < webSocData_speed.length; ++i) {
    First_chex.innerHTML += "<li data-na=" + rot_name[i] + "><a><input type=\"checkbox\"/ id=" + rot_name[i] + ">&nbsp;" + rot_name[i] + "</a></li>";
  }
}
//创建trip planner表格
function NauticalRoute_getPoints (points) {
  var htmlText = "<br/><table>";
  var latA, latB, lonA, lonB, distance, bearing;
  var totalDistance = 0;
  htmlText += "<tr bgcolor=\"#CCCCCC\"><td width=\"20\" align=\"center\"></td><td width=\"60\" align=\"center\">" + tableTextNauticalRouteCourse + "</td><td width=\"70\" align=\"center\">" + tableTextNauticalRouteDistance + "</td><td width=\"200\" align=\"center\">" + tableTextNauticalRouteCoordinate + "</td></tr>"
  document.getElementById("routeStart").innerHTML = lat2DegreeMinute(y2lat(points[0].y)) + " - " + lon2DegreeMinute(x2lon(points[0].x));
  for (i = 0; i < points.length - 1; i++) {
    latA = y2lat(points[i].y);
    lonA = x2lon(points[i].x);
    latB = y2lat(points[i + 1].y);
    lonB = x2lon(points[i + 1].x);
    routePoint_lat[i] = latA;
    routePoint_lon[i] = lonA;
    console.log(routePoint_lon[i]);
    distance = getDistance(latA, latB, lonA, lonB).toFixed(2);
    bearing = getBearing(latA, latB, lonA, lonB).toFixed(2);
    course_distance.push(parseFloat(distance) + "nm");
    course_angle.push(bearing + "°;");
    totalDistance += parseFloat(distance);
    htmlText += "<tr><td width=\"20\" align=\"right\">" + parseInt(i + 1) + ". </td>";
    htmlText += "<td width=\"60\" align=\"right\">" + bearing + "°</td>";
    htmlText += "<td width=\"70\" align=\"right\">" + distance + "nm</td>"; //lat2DegreeMinute(latB)
    htmlText += "<td width=\"200\" align=\"right\">" + lat2DegreeMinute(latB) + " - " + lon2DegreeMinute(lonB) + "</td></tr>";
  }
  routePoint_lat[points.length - 1] = latB;
  routePoint_lon[points.length - 1] = lonB;
  htmlText += "</table>"
  document.getElementById("routeEnd").innerHTML = lat2DegreeMinute(latB) + " - " + lon2DegreeMinute(lonB);
  document.getElementById("routeDistance").innerHTML = totalDistance.toFixed(2) + "nm";
  document.getElementById("routePoints").innerHTML = htmlText;
}

function NauticalRoute_Optimization () {
  var jsonstr = "[]";
  var json_array = eval('(' + jsonstr + ')');
  for (var i = 0; i < routePoint_lat.length; i++) {
    var formdata1 = {
      "longitude": routePoint_lon[i],
      "latitude": routePoint_lat[i]
    };
    var point_coordinate = {};
    point_coordinate[i] = formdata1;
    json_array.push(point_coordinate);
  }
  var route_res = {
    "type": "CourseActive",
    "course_coordinate": json_array
  };
  console.log(JSON.stringify(route_res));
  $.ajax({
    url: "http://192.168.1.140:8080/NavigationalDataServlet", //访问路径
    type: "POST", //访问方式
    data: JSON.stringify(route_res), //传入服务端的数据
    contentType: "application/x-www-form-urlencoded;charset=UTF-8",
    dataType: "json",
    success: function (data) {
      alert(data[0].x);
    }
  });
  document.getElementById('buttonNauticalCancelOptimization').disabled = false;
}
function data_post () {
  var jsonstr = "[]";
  var json_array = eval('(' + jsonstr + ')');
  for (var i = 0; i < routePoint_lat.length; i++) {
    var formdata1 = {
      "longitude": routePoint_lon[i],
      "latitude": routePoint_lat[i]
    };
    var point_coordinate = {};
    point_coordinate[i] = formdata1;
    json_array.push(point_coordinate);
  }
  var route_res = {
    "type": "CourseActive",
    "course_coordinate": json_array
  };
  var ws_connection = new WebSocket("ws://192.168.1.140:8080/NavigationalDataServlet"); //与服务器建立连接
  ws_connection.send(JSON.stringify(route_res));
}
function NauticalRoute_getRouteCsv (points) {
  var buffText = ";" + tableTextNauticalRouteCourse + ";" + tableTextNauticalRouteDistance + ";" + tableTextNauticalRouteCoordinate + "\n";
  var latA, latB, lonA, lonB, distance, bearing;
  var totalDistance = 0;
  for (i = 0; i < points.length - 1; i++) {
    latA = y2lat(points[i].y);
    lonA = x2lon(points[i].x);
    latB = y2lat(points[i + 1].y);
    lonB = x2lon(points[i + 1].x);
    distance = getDistance(latA, latB, lonA, lonB).toFixed(2);
    bearing = getBearing(latA, latB, lonA, lonB).toFixed(2);
    totalDistance += parseFloat(distance);
    buffText += parseInt(i + 1) + ";" + bearing + "°;" + distance + "nm;\"" + lat2DegreeMinute(latB) + " - " + lon2DegreeMinute(lonB) + "\"\n";
  }
  return convert2Text(buffText);
}
function NauticalRoute_getRouteKml (points) {
  var latA, lonA;
  var buffText = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<kml xmlns=\"http://earth.google.com/kml/2.0\">\n";
  buffText += "<Folder>\n<name>OpenSeaMap Route</name>\n<description>test</description>";
  buffText += "<Placemark>\n<name>OpenSeaMap</name>\n<description>No description available</description>";
  buffText += "<LineString>\n<coordinates>\n";
  for (i = 0; i < points.length; i++) {
    latA = y2lat(points[i].y);
    lonA = x2lon(points[i].x);
    buffText += lonA + "," + latA + " ";
  }
  buffText += "\n</coordinates>\n</LineString>\n</Placemark>\n</Folder>\n</kml>";
  return buffText;
}
function NauticalRoute_getRouteGpx (feature) {
  var parser = new OpenLayers.Format.GPX({
    internalProjection: map.projection,
    externalProjection: proj4326
  });
  return parser.write(feature);
}
function NauticalRoute_getRouteGml (feature) {
  var parser = new OpenLayers.Format.GML.v2({
    internalProjection: map.projection,
    externalProjection: proj4326
  });
  return parser.write(feature);
}