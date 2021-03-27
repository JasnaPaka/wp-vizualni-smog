<?php 
    get_header(); 
    
    $KV_SETTINGS = kv_settings();
?>

<div id="mappage">

<style type="text/css">
#footer,
#header-top,
#header_project
{
	display:none;
}

#header-content {
  min-height: 0;
	height: 50px;
}

#mappage {
	height: 100%;
	position: relative;
}

</style>

<div id="map-canvas"></div>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php print ($KV_SETTINGS["gm_key"]) ?>&amp;sensor=false"></script>

<script type="text/javascript">
	var map;
	var infowindow;
	
	var mapOptions = {
		center: new google.maps.LatLng(<?php print ($KV_SETTINGS["gm_lat"]) ?>, <?php print ($KV_SETTINGS["gm_lng"]) ?>),
		mapTypeId: google.maps.MapTypeId.SATELLITE,
		zoom: <?php print ($KV_SETTINGS["gm_zoom"]) ?>
	};
	
    var bodyVMape = [
    	<?php echo kv_MapaData() ?>
    ];
    
    var markers = [];	
    
    function getMarkers() {
    	jQuery('#mappage #filters').css({opacity: 1});
    }
    
    function selectAllCategories(checkAll) {
    
		var zoom = map.getZoom();
		
		for (i=0; i<markers.length; i++) {
			categoryId = "category" + markers[i].category;
			if (checkAll) {
	    		document.getElementById(categoryId).className = document.getElementById(categoryId).className + " active";
	    		document.getElementById(categoryId).setAttribute("data-checked", "active");
			} else {
				document.getElementById(categoryId).className = document.getElementById(categoryId).className.replace(/\bactive\b/,'');
				document.getElementById(categoryId).setAttribute("data-checked", "");
	    	}
		
			if (checkAll) {
				markers[i].setMap(map);
			} else {
				markers[i].setMap(null);
			}
		}
		
		visibilityChangeNeexistujici(false);
		visibilityChangeBezFotografie(false);
    }
	
	function getURLParameter(name) {
	  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	  var regexS = "[\\?&]"+name+"=([^&#]*)";
	  var regex = new RegExp( regexS );
	  var results = regex.exec( window.location.href );
	  if( results == null )
	    return null;
	  else
	    return results[1];
	}
	
	function changeZoom() {
		var zoom = map.getZoom();
		
  		for (i=0; i<markers.length; i++) {
  			var checked = categoryIsChecked(markers[i].category);
			if (checked && !bodyVMape[i][9]) {
				markers[i].setMap(map);
			} else {
				markers[i].setMap(null);
			}
			
			// U trvalého odkazu zobrazíme objekt i tehdy, je-li kategorie skryta.
			visibleObject = getURLParameter("objekt");
	        if (visibleObject != null && visibleObject == bodyVMape[i][7]) {
	        	markers[i].setMap(map);
	        }
		}
		
		visibilityChangeNeexistujici(false);
  	}
	
	function kvMapInit() {
		map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
		var styles = [ { featureType: "poi", stylers: [ { visibility: "off" } ] } ];
		map.setOptions({styles: styles});
		map.setTilt(0);
		
 		for (i = 0; i < bodyVMape.length; i++) {

			var marker = new google.maps.Marker({
			    position: new google.maps.LatLng(bodyVMape[i][1], bodyVMape[i][2]),
			    map: map,
			    icon: bodyVMape[i][4],
			    title: bodyVMape[i][5]
			});
			marker.category = bodyVMape[i][3];
			
			google.maps.event.addListener(marker, 'click', (function(marker, i) {
	            return function() {
	            	if (infowindow) {
	            		infowindow.close();
	            	}
	            
		            infowindow = new google.maps.InfoWindow({
		      			content: bodyVMape[i][0]
		  			});
	              	infowindow.open(map, marker);
	              	
	            }
	        })(marker, i));
	        
	        // Pokud nemá být objekt vidět, skryjeme jej.
	        if (bodyVMape[i][6] == 0) {
	        	marker.setMap(null);
	        }
	        
	        // Pokud má být objekt zobrazen i s infem (trvalý odkaz), zobrazíme
	        visibleObject = getURLParameter("objekt");
	        if (visibleObject != null && visibleObject == bodyVMape[i][7]) {
	        	google.maps.event.trigger(marker, 'click');
	        	map.setZoom(16);
				map.panTo(marker.position);
	        }
	        
	        markers.push(marker);
	  	}
	  	
		google.maps.event.addDomListener(map,'zoom_changed', function() { 
		  	changeZoom();
		  	visibilityChangeNeexistujici(false);
		  	visibilityChangeBezFotografie(false);
		});
		changeZoom();
	}
	
	function categoryIsChecked(id) {
		return document.getElementById("category" + id).getAttribute("data-checked") == "active";
	}
	
	function changeCategoryVisiblity(id) {
		if (categoryIsChecked(id)) {
			document.getElementById("category" + id).setAttribute("data-checked", "");
		} else {
			document.getElementById("category" + id).setAttribute("data-checked", "active");
		}
	}
	
	function visibilityChange(id) {
		changeCategoryVisiblity(id)
	
		var checked = categoryIsChecked(id);
		var zoom = map.getZoom();
		
		for (i=0; i<markers.length; i++) {
			if (markers[i].category == id) {
				if (checked) {
					markers[i].setMap(map);
				} else {
					markers[i].setMap(null);
				}
			}
		}
		
		visibilityChangeNeexistujici(false);
		visibilityChangeBezFotografie(false);
	}
	
	function visibilityChangeNeexistujici(changeValue) {
		if (changeValue) {
			changeCategoryVisiblity("Neexistujici");
			changeZoom();
		}
	
		var checkedBezFotografie = categoryIsChecked("BezFotografie");
		var checkedNeexistujici = categoryIsChecked("Neexistujici");
		
		if (checkedNeexistujici) {
			for (i=0; i<markers.length; i++) {
				var categoryChecked = categoryIsChecked(markers[i].category);
			
				if (categoryChecked && bodyVMape[i][9] == 1 && (!checkedBezFotografie || (checkedBezFotografie && bodyVMape[i][10] == "NENI"))) {
					markers[i].setMap(map);
				} else {
					markers[i].setMap(null);
				}
			}
		}
	}
	
	function visibilityChangeBezFotografie(changeValue) {
		if (changeValue) {
			changeCategoryVisiblity("BezFotografie");
			changeZoom();
		}
		
		var checkedBezFotografie = categoryIsChecked("BezFotografie");
		var checkedNeexistujici = categoryIsChecked("Neexistujici");
		
		if (checkedBezFotografie) {
			for (i=0; i<markers.length; i++) {  
				var checkedCategory = categoryIsChecked(markers[i].category);
			
				if (checkedCategory && bodyVMape[i][10] == "NENI" && (bodyVMape[i][9] == 0 || (bodyVMape[i][9] == 1 && checkedNeexistujici))) {
					markers[i].setMap(map);
				} else {
					markers[i].setMap(null);
				}
			}
		}
	}
	
	google.maps.event.addDomListener(window, 'load', kvMapInit); 
</script>

<div id="filters">
	<div class="buttons">
		<span href="#" class="minimize"></span>
	</div>
	<div class="panel">
		
		<div class="blocks">
			<div class="block active">
				<h2><?php print ($KV["projekt_nazev"]) ?></h2>
				
				<div class="scroll">
					<div class="tags">
						<h3>Dle kategorie 
						(<a href="#" onclick="selectAllCategories(true)" title="Označí všechny kategorie">vše</a>/<a href="#" onclick="selectAllCategories(false)" title="Zruší označení všech kategorií">nic</a>)</h3>
						<?php
							foreach (kv_MapCategories() as $category) {
						?>
							<div class="category-circle-out" style="background-color: black">
								<div class="category-circle-in" style="background-color: <?php echo $category->barva ?>"></div>
							</div>
							
							<label id="category<?php echo $category->id ?>" name="category<?php echo $category->id ?>" 
								class="tag filter allfilter<?php if (strlen($category->zaskrtnuto) > 0) echo ' '.$category->zaskrtnuto ?>"
								data-checked="<?php echo $category->zaskrtnuto ?>" 
								title="Počet děl: <?php echo $category->pocet ?>" onclick="visibilityChange(<?php echo $category->id ?>)">
							<?php echo $category->nazev ?><span class="checkbox"></span></label>
						<?php
							}
						?>
					</div>
					
					<hr />
					
					<div class="tags">
						<h3>Dle atributů</h3>
						
						<label id="categoryNeexistujici" name="categoryNeexistujici" class="tag filter allfilter" 
							title="Počet děl: " onclick="visibilityChangeNeexistujici(true)">
						Již neexistující<span class="checkbox"></span></label>
						
						<label id="categoryBezFotografie" name="categoryBezFotografie" class="tag filter allfilter" 
							title="Počet děl: " onclick="visibilityChangeBezFotografie(true)">
						Bez fotografie<span class="checkbox"></span></label>					
					</div>
					
					<hr />
					
				</div>
				
				<p id="dilaPocet"><strong>Celkový počet objektů</strong>: <?php echo kv_ObjektPocet() ?> </p>
			</div>
		</div>
		
	</div>
</div>

</div>





<?php get_footer(); ?>
