// create a network
var container = document.getElementById('mynetwork');

var options = {
	layout : {
		hierarchical : {
			direction : 'UD'
		}
	}
};

var json = $.getJSON("data.json").done(function(data) {
	var g = {
		nodes : data.nodes,
		edges : data.edges
	};
	var network = new vis.Network(container, g, options);
	network.fit();
});
