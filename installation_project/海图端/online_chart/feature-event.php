<?php
  
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>OpenLayers 2 Feature Events Example</title>
    <link rel="stylesheet" href="./javascript/openlayers/theme/default/style.css" type="text/css">
    <link rel="stylesheet" href="style.css" type="text/css">
    <style type="text/css">
    #result {
        height: 60px;
        width: 514px;
        font-size: smaller;
        overflow: auto;
        margin-top: 5px;
    }
    </style>
  </head>
  <body>
    <h1 id="title">Feature Events Example</h1>

    <div id="tags">
        feature, select, hover
    </div>

    <div id="shortdesc">Feature hover and click events</div>

    <div id="map" class="smallmap"></div>
    <div id="docs">
        <p id="result">Hover over or click features on the map.</p>

        <p>This example shows how to use the 'featureclick', 'nofeatureclick',
            'featureover' and 'featureout' events to make features interactive.
            Look at the <a href="feature-events.js">feature-events.js</a> source
            code to see how this is done.</p>
        
        <p>Note that these events can be registered both on the map and on
            individual layers. If many layers need to be observed, it is
            recommended to register listeners once on the map for performance
            reasons.</p>
    </div>
    <script type="text/javascript" src="./javascript/openlayers/OpenLayers.js"></script>
    <script type="text/javascript" src="./javascript/openlayers/OpenLayers.js"></script>
    <script src="./javascript/feature-events.js"></script>
  </body>
</html>
