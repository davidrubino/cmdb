// create an array with nodes
var nodes = new vis.DataSet([
	{id : 1, label : 'ADP', level : 1},
	{id : 2, label : 'App Servers', level : 2},
	{id : 3, label : 'CI', level : 3},
	{id : 4, label : 'CI', level : 3},
	{id : 5, label : 'CI', level : 3}
]);

// create an array with edges
var edges = new vis.DataSet([
	{from : 1, to : 2},
	{from : 2, to : 3},
	{from : 2, to : 4},
	{from : 2, to : 5}
]);

// create a network
var container = document.getElementById('mynetwork');

// provide the data in the vis format
var data = {
	nodes : nodes,
	edges : edges
};
var options = {
	layout : {
		hierarchical : {
			direction : 'UD'
		}
	}
};

// initialize your network!
var network = new vis.Network(container, data, options);
