

// -----------------------------------------------------------------------------
// Description
// -----------------------------------------------------------------------------
// The base OpenLayers.Control.Permalink can not handle dynamic layers. The
// solution was to introduce a 'layerId' for each layer. Now it is possible
// to change layer order without side effects.
//
// The 'layerId' is used to determine the position in the param string. So
// in the pattern 'BFFTFF', layers with id 1 and 4 are visible.
// -----------------------------------------------------------------------------


OpenSeaMap = OpenLayers.Class(Object, {});
OpenSeaMap.Control = OpenLayers.Class(Object, {});


OpenSeaMap.Control.ArgParser = OpenLayers.Class(OpenLayers.Control.ArgParser, {
    CLASS_NAME: 'OpenSeaMap.Control.ArgParser',
    ignoredLayers: 0,
    configureLayers: function () {
        if (this.layers.length === (this.map.layers.length + this.ignoredLayers)) {
            this.map.events.unregister('addlayer', this, this.configureLayers);

            for (var i = 0, len = this.map.layers.length; i < len; i++) {
                var layer = this.map.layers[i];
                var id = layer.layerId || 0;
                if (id < 1) {
                    // No layerId set -> ignore the layer
                    continue;
                }
                if (this.layers.length < id) {
                    // Setting for layer not in arguments
                    continue;
                }
                var c = this.layers.charAt(id - 1);
                if (c == 'B') {
                    this.map.setBaseLayer(layer);
                } else if ((c == 'T') || (c == 'F')) {
                    layer.setVisibility(c == 'T');
                }
            }
        }
    }
});


OpenSeaMap.Control.Permalink = OpenLayers.Class(OpenLayers.Control.Permalink, {
    ignoredLayers: 0,
    argParserClass: OpenSeaMap.Control.ArgParser,
    setMap: function (map) {
        OpenLayers.Control.Permalink.prototype.setMap.apply(this, arguments);

        for (var i = 0, len = this.map.controls.length; i < len; i++) {
            var control = this.map.controls[i];
            if (control.CLASS_NAME === 'OpenSeaMap.Control.ArgParser') {
                control.ignoredLayers = this.ignoredLayers;
                break;
            }
        }
    },
    createParams: function (center, zoom, layers) {
        center = center || this.map.getCenter();

        var params = OpenLayers.Util.getParameters(this.base);

        if (center) {
            // Call parent method
            params = OpenLayers.Control.Permalink.prototype.createParams.apply(this, [center, zoom, layers]);

            // Override layers param
            params.layers = this.getLayerString(layers);
        }

        return params;
    },
    getLayerString: function (layers) {
        var layers = layers || this.map.layers;
        var result = '';
        for (var i = 0, len = layers.length; i < len; i++) {
            var layer = layers[i];
            var id = layer.layerId || 0;
            var flag;
            if (id < 1) {
                // No layerId set -> ignore the layer
                continue;
            }
            if (layer.isBaseLayer) {
                flag = (layer == this.map.baseLayer) ? 'B' : '0';
            } else {
                flag = (layer.getVisibility()) ? 'T' : 'F';
            }
            result = this.setFlag(result, flag, id);
        }
        return result;
    },
    setFlag: function (config, flagValue, id) {
        // The layers can be in different order
        while (config.length < id) {
            // Fill with defaults
            config = config + 'F';
        }
        return config.substr(0, id - 1) + flagValue + config.substr(id);
    }
});
