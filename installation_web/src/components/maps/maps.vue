<template>
  <div id="map" class="map" ref="map"></div>
</template>

<script>
  import Map from 'ol/Map.js'

  import '../../assets/css/ol.css'

  import OSM from 'ol/source/OSM.js'

  import TileLayer from 'ol/layer/Tile';

  import {getLayers} from 'ol/Map.js'

  import View from 'ol/View.js'

  import Feature from 'ol/Feature.js'

  import Point from 'ol/geom.js'

  import Vector from 'ol/layer/Vector'

  import Source from 'ol/source'

  import Style from 'ol/style'

  import {
    fromLonLat,
    toLonLat,
    transform
  } from 'ol/proj.js'

  export default {

    name: "index",

    data() {

      return {

        map: null

      }

    },


    mounted() {

      this.mapint()

    },

    methods: {

      mapint() {

        var map = this.$refs.map

        var layer = new TileLayer({

          source: new OSM(),

          wrapX: false
        })

        this.map = new Map({

          target: 'map',

          layers: [layer],

          view: new View({

            center: transform([ 119.22, 39.222 ], 'EPSG:4326','EPSG:3857'),
            projection : 'EPSG:3857',
            zoom : 5,
            minZoom : 2,
            maxZoom : 15,
          })
        })

       this.showShip(this.getshipjson(),this.map);
      },

      getshipjson() {
      	    var gesonboject = []
      	    var coordinaete = transform([ 119,39 ], 'EPSG:4326', 'EPSG:3857');
      	    var course = 300 / 180 * 3.14;
      	    var speed = 10;
      	    shipjson = new Feature({
            geometry : new Point(coordinaete),
            'type' : 'ship',
            'mmsi' : "412123456",
            'name' : "天康河",
            "course" : course,
            "id" : 1
      		});

      	 gesonboject.push(shipjson);
      	 return gesonboject
      },
      showShip(geojsonObject,map) {
      	map.removeLayer(vectorLayer);//vectorlayer 是全局变量，其实就是图标所在的图层，每次加载之前应该清除之前的图层
      	vectorLayer = new Vector({ // 初始化矢量图层
      		source : new Source.Vector({
      			features : geojsonObject  // geojosnobject就是上面返回的featrue json 数组
      		}),
      		style : new Style.Style({
      					image : new Style.Icon({
      					rotation : feature.get('course'),//图标旋转的角度及图标存储位置
      					src : feature.get('speed') > 3 ? 'images/ship.png':'images/anchor1.png'
      					})
      				})
        });
        map.addLayer(vectorLayer); //map是之前的map地图容器
      }




    },
 }
</script>

<style lang="less" scoped>
  .map {
    width: 100%;
    height: 100%;
  }
</style>
