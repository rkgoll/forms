function ready(player_id) {
		var player = $f(player_id)
		player.addEvent('play', function(data) {
					//add google tracking here
					_gaq.push(["_trackEvent", "Video", "Play", '', , false]);
					});
		player.addEvent('finish', function(data) {
					//add google tracking here
					_gaq.push(["_trackEvent", "Video", "Finish", '', , false]);
					});
		player.addEvent('pause', function(data) {
					//add google tracking here
					_gaq.push(["_trackEvent", "Video", "Pause", '', , false]);
					});
	}

window.addEventListener('load', function() {
	//Attach the ready event to the iframe
	$f(document.getElementById('player_1')).addEvent('ready', ready);
});