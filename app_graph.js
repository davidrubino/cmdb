// create a network
var container = document.getElementById('mynetwork');

var options = {
	layout : {
		hierarchical : {
			direction : 'UD'
		}
	},
	nodes : {
		icon : {
			face : 'FontAwesome',
			code : '\uf10a',
			size : 50,
			color : '#2B7CE9'
		},
		shape : 'icon'
	}
};

var json = $.getJSON("db_createGraph.php").done(function(data) {
	var g = {
		nodes : data.nodes,
		edges : data.edges
	};
	var network = new vis.Network(container, g, options);
	network.fit();
});
