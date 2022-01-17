function showWind() {
    if (layer_weather_wind.visibility) {
        layer_weather_wind.setVisibility(false);
         document.getElementById("windSpeed_legend").style.visibility = "hidden";
    } else {
        layer_weather_wind.setVisibility(true);
        document.getElementById("windSpeed_legend").style.visibility = "visible";
    }
    document.getElementById("checkNone").checked = false;
    if (!isAllchecked()) {
        document.getElementById("checkLayerWeatherAll").checked = false;
        //  document.getElementById("wave_legend_2").style.visibility = "hidden";
    }
    if (isAllUnchecked())
        clearAll();
}
function showWaves() {
    if (layer_weather_waves.visibility) {
        layer_weather_waves.setVisibility(false);
        document.getElementById("wave_legend").style.visibility = "hidden";
    } else {
        layer_weather_waves.setVisibility(true);
        document.getElementById("wave_legend").style.visibility = "visible";
    }
    document.getElementById("checkNone").checked = false;
    if (!isAllchecked()) {
        document.getElementById("checkLayerWeatherAll").checked = false;
        // document.getElementById("wave_legend_2").style.visibility = "hidden";
    }
    if (isAllUnchecked())
        clearAll();
}
function showSwell() {
    if (layer_weather_swell.visibility) {
        layer_weather_swell.setVisibility(false);
        document.getElementById("wave_legend").style.visibility = "hidden";
        // setCookie("GridWGSLayerVisible", "false");
    } else {
        layer_weather_swell.setVisibility(true);
        document.getElementById("wave_legend").style.visibility = "visible";
        // setCookie("GridWGSLayerVisible", "true");
    }
    document.getElementById("checkNone").checked = false;
    if (!isAllchecked()) {
        document.getElementById("checkLayerWeatherAll").checked = false;
        //document.getElementById("wave_legend_2").style.visibility = "hidden";
    }
    if (isAllUnchecked())
        clearAll();
}
function showCurrent() {
    if (layer_weather_current.visibility) {
        layer_weather_current.setVisibility(false);
        document.getElementById("currentSpeed_legend").style.visibility = "hidden";
    } else {
        layer_weather_current.setVisibility(true);
        document.getElementById("currentSpeed_legend").style.visibility = "visible";
    }
    document.getElementById("checkNone").checked = false;
    if (!isAllchecked()) {
        document.getElementById("checkLayerWeatherAll").checked = false;
        // document.getElementById("wave_legend_2").style.visibility = "hidden";
    } if (isAllUnchecked())
        clearAll();
}
function clearAll() {
    layer_weather_wind.setVisibility(false);
    document.getElementById("windSpeed_legend").style.visibility = "hidden";
    layer_weather_waves.setVisibility(false);
    document.getElementById("wave_legend").style.visibility = "hidden";
    document.getElementById("currentSpeed_legend").style.visibility = "hidden";
    layer_weather_swell.setVisibility(false);
    layer_weather_current.setVisibility(false);
    document.getElementById("checkLayerWeatherAll").checked = false;
}
function showAll() {
    layer_weather_wind.setVisibility(true);
    document.getElementById("windSpeed_legend").style.visibility = "visible";
    layer_weather_waves.setVisibility(true);
    document.getElementById("wave_legend").style.visibility = "visible";
    layer_weather_swell.setVisibility(true);
    layer_weather_current.setVisibility(true);
    document.getElementById("currentSpeed_legend").style.visibility = "visible";
    document.getElementById("checkNone").checked = false;
}
function isAllchecked() {
    if (document.getElementById("checkLayerWeatherWind").checked === false || document.getElementById("checkLayerWeatherWaves").checked === false || document.getElementById("checkLayerWeatherSwell").checked === false || document.getElementById("checkLayerWeatherCurrent").checked === false)
        return false;
    else
        return true;
}
function isAllUnchecked() {
    if (document.getElementById("checkLayerWeatherWind").checked === false && document.getElementById("checkLayerWeatherWaves").checked === false && document.getElementById("checkLayerWeatherSwell").checked === false && document.getElementById("checkLayerWeatherCurrent").checked === false)
        return true;
    else
        return false;
}