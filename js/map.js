var map;
var position = new google.maps.LatLng(56.171654, 10.1901015);
function initialize() {
    var mapProp = {
        center: position,
        zoom:17,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
    var marker = new google.maps.Marker({
        position: position,
        map: map
    });
}
google.maps.event.addDomListener(window, 'load', initialize);
google.maps.event.addDomListener(window, "resize", function() {
    //var center = map.getCenter();
    google.maps.event.trigger(map, "resize");
    map.setCenter(position);
    map.setZoom(17);
});/**
 * Created by Lunding on 27/05/15.
 */
