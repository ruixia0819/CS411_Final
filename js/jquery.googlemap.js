function initMap() {
			  
			    var map = new google.maps.Map(document.getElementById('map'), {
			      zoom: 14,
			     // center: {lat: -33, lng: 151},
			      mapTypeId: google.maps.MapTypeId.ROADMAP
			    });

			    //var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/coffee.png';
			    //var image='http://maps.google.com/mapfiles/ms/micons/restaurant.png';
			    var image="images/coffee.png";
			    var image2="images/user-red.png";
			    var image3="images/me.png";
			    //var image = 'https://media.licdn.com/mpr/mpr/shrinknp_200_200/AAEAAQAAAAAAAAj5AAAAJDIyN2NlYzlmLTdhMDctNDE2Yi04N2RmLTE4ZDc0YjIxYTc1OA.jpg';
			    //var address = 'University of Illinois at Urbana-Champaign, 1301 W Springfield Ave, Urbana, IL 61801';
			    var x=<?php echo json_encode($len)?>;
			    //var address="";
			    var address= <?php echo json_encode($addrs);?>;
			    var res = <?php echo json_encode($restaurants)?>;
			    var pos=[];
			    var roadColors = ["#426289","#ec7063","#52be80","#884ea0","#f4d03f"];
			    //var marker=new Array();
			 //   var marker_lat= new Array(5);
			 //   var marker_lng = new Array(5);
			  //document.getElementById("demo").innerHTML =marker.length;
			    //get self position
			    var selfinfoWindow = new google.maps.InfoWindow;
			 //   if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                selfinfoWindow.setPosition(pos);
                selfinfoWindow.setContent('You are here.');
                selfinfoWindow.open(map);
                map.setCenter(pos);
                var latlng = selfinfoWindow.getPosition();
                
                //insert php database code
                
                $.post("savePosition.php", {lat: position.coords.latitude, lng: position.coords.longitude});
                }, function() {
                    handleLocationError(true, selfinfoWindow, map.getCenter());
                });
                // } else {
                // // Browser doesn't support Geolocation
                //     handleLocationError(false, infoWindow, map.getCenter());
                // }
                //var latlng = inforWindow.getPosition();
                //document.getElementById("demo").innerHTML = latlng.lat();
			   //console.log(infoWindow.getPosition());
			   /*
			    * Set restaurant position
			    */
			    var j;
			    for(j=0;j<x;++j){
			        var geocoder=new google.maps.Geocoder();
		            setMarker(map,geocoder,image,address[j],res[j]);
			    }
			    
			   /*
			    * Set inviters 
                */
                //document.getElementById("demo").innerHTML =marker_lat;
                var p =<?php echo json_encode($sizeofPeople)?>;
                
                var pp=p/4;
                
                var people=<?php echo json_encode($peoples);?>;
                var i;
                for(i=0;i<pp;i++){
                    var myLat=parseFloat(people[i*4+1]);
			        var myLng=parseFloat(people[i*4+2]);
			        
			        var myLatLng= {lat:myLat, lng:myLng};
			        var secret=people[i*4+0];
			        var target=people[i*4+3];
			        //var test=marker[3].getPosition().lat();
			        
			     //   var geocoder=new google.maps.Geocoder();
			     //   var polyPath=null;
			     //   geocoder.geocode( { 'address': address[marker_no]}, function(results, status) {
	       //             polyPath=[
			     //       {lat:results[0].geometry.location.lat(),lng:results[0].geometry.location.lng()},
			     //       {lat:myLat, lng:myLng}
			     //       ];
			     //       document.getElementById("demo").innerHTML =polyPath[1].lat;
			            
			            
		      //      });
			     //document.getElementById("demo").innerHTML =polyPath[0].lat;
			     var color = roadColors[i%5];
			     if(secret=="<?php echo $_SESSION['user_name'];?>"){
			            setPeople(map,myLatLng,image3,"You are Here",target,color);
			        }else{
			            setPeople(map,myLatLng,image2,secret,target,color);
			        }
			        //setPeople(map,myLatLng,image2,secret,target,color);
			        //drawPoly(map,polyPath);
			       
                }
			   
      }
      function drawPoly(map,addr1,addr2,color){
        //   var rendererOptions = {
        //         map: map,
                
        //     }
            //directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
          var directionsService = new google.maps.DirectionsService();
          var directionsDisplay = new google.maps.DirectionsRenderer({
                 preserveViewport: true,
                suppressMarkers : true,
                // directions: result,
                // routeIndex: 1,
                map: map,
                polylineOptions:{
                    strokeColor:color,
                    strokeWeight: 5,
                    strokeOpacity: 0.8
                }
            });
          directionsDisplay.setMap(map);
          var request = {
           origin: addr1, 
           destination: addr2,
           travelMode: google.maps.DirectionsTravelMode.DRIVING
         };
    
         directionsService.route(request, function(response, status) {
           if (status == google.maps.DirectionsStatus.OK) {
             directionsDisplay.setDirections(response);
           }
         });
        // var Path = new google.maps.Polyline({
        //   path: polyPath,
        //   geodesic: true,
        //   strokeColor: '#FF0000',
        //   strokeOpacity: 1.0,
        //   strokeWeight: 2
        // });

        // Path.setMap(map);
      }
      function setPeople(map,myLatLng,image,secret,target,color){
          var people = new google.maps.Marker({
            position: myLatLng,
            map: map,
            icon: image
            });
            attachSecretMessage(people, secret);
            // var geocoder=new google.maps.Geocoder();
            
            // geocoder.geocode( { 'address': target}, function(results, status) {
            // //     if(secret=="You are Here"){
			         ////   document.getElementById("demo").innerHTML =results[0].geometry.location.lat();}
            //     if(status == 'OK'){
	           //         var polyPath=[
			         //   results[0].geometry.location,
			         //   myLatLng
			         //   ];
			            
			//alert(polyPath[1]);
			            
			            drawPoly(map,target,myLatLng,color);
			           // document.getElementById("demo").innerHTML =secret;
                // }
        // });
          
      }
      function setMarker(map,geocoder,image,address,res){
        geocoder.geocode( { 'address': address}, function(results, status) {
	        if (status == 'OK') {
	            //map.setCenter(results[0].geometry.location);
			    var marker = new google.maps.Marker({
			        map: map,
			        position: results[0].geometry.location,
			        icon: image
			    });
			    var secret = res;
			    attachSecretMessage(marker, secret);
			    //pos[address] = results[0].geometry.location;
		    } else {
			    alert('Geocode was not successful for the following reason: ' + status);
		    }
		});
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
          
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }
			  function attachSecretMessage(marker, secretMessage) {
		  		var infowindow = new google.maps.InfoWindow({
		   		content: secretMessage
		  		});

		  		marker.addListener('mousemove', function() {
		    	infowindow.open(marker.get('map'), marker);
		  		});
			}