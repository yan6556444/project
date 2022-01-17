<iframe id="josm_call_iframe" src="#" style="visibility:hidden;"></iframe>
<div id="topmenu2" style="position:absolute; top:10px; left:60px;">
    <ul class="dropdown">
       
        <li>
            <a>
                <img alt="search" src="./resources/action/find.png" width="22" height="22" border="0"  onClick="nominatim(document.getElementById('searchinputbox').value)">
                <input id="searchinputbox" name="searchtext" type="text"
                    size="10" maxlength="40"
                    style="height: 18px; border: 1px solid Black"
                    onKeyPress="if (event.keyCode==13 || event.which==13) {nominatim(this.value);}"
                >
            </a>
        </li>
       
        <li>
            <a><img alt="view" src="./resources/action/view.png" width="22" height="22" border="0">&nbsp;<?=$t->tr("view")?></a>
            <ul class="sub_menu">
               
              
               
               
                <li onClick="showGridWGS()"><a><input type="checkbox" id="checkLayerGridWGS">&nbsp;<?=$t->tr("coordinateGrid")?></a></li>
            
                <li onClick="showECA()"><a><input type="checkbox" id="checkLayerECA">&nbsp;<?=$t->tr("showECA")?></a></li>
                
               
            </ul>
        </li>
        <li>
            <a><img alt="tools" src="./resources/action/tools.png" width="22" height="22" border="0">&nbsp;<?=$t->tr("tools")?></a>
            <ul class="sub_menu">
				        <li data-tools="permalink">
                    <a><input type="checkbox" id="checkPermalink">&nbsp;<img alt="permalink" src="./resources/action/permalink-32x.png" width="22" height="22" border="0">&nbsp;<?=$t->tr("permalinks")?></a>
                </li>
                <li data-tools="nautical_route">
                    <a><input type="checkbox" id="checkNauticalRoute">&nbsp;<img alt="route" src="./resources/action/route-32px.png" width="22" height="22" border="0">&nbsp;<?=$t->tr("tripPlanner")?></a>
                    
                </li>
                 <li>
              
                    <a><input type="checkbox" id="checkNauticalRouteList">&nbsp;<img alt="route" src="./resources/action/bluelist.png" width="22" height="22" border="0">&nbsp;<?=$t->tr("nauticalRouteList")?></a>
                    <ul id="routeList_sub" >
                    </ul>                   
                </li>               
            </ul>
        </li>
        <li onClick="Locate()">
            <a><img alt="help" src="./resources/icons/follow.svg" width="22" height="22" border="0">&nbsp;<?=$t->tr("help")?></a> 
        </li>
    </ul>
</div>
 <!--data-tools="nauticalRoute_list"-->