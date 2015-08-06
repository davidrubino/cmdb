var container,
    options,
    g;

function setContainer() {
	container = document.getElementById('mynetwork');
}

function setOptions() {
	options = {
		groups : {
			app : {
				shape : 'icon',
				icon : {
					face : 'FontAwesome',
					code : '\uf10a',
					size : 50,
					color : '#2B7CE9'
				}
			},
			folder : {
				shape : 'icon',
				icon : {
					face : 'FontAwesome',
					code : '\uf07b',
					size : 50,
					color : '#2B7CE9'
				}
			},
			config_item : {
				shape : 'icon',
				icon : {
					face : 'FontAwesome',
					code : '\uf15b',
					size : 50,
					color : '#2B7CE9'
				}
			}
		},
		layout : {
			hierarchical : {
				direction : 'UD'
			}
		}
	};
}

function setGraph(data) {
	g = {
		nodes : data.nodes,
		edges : data.edges
	};
}

function resetAllNodes() {
	g.length=0;
}

var json = $.getJSON("app_db_createGraph.php").done(function(data) {
	setContainer();
	setOptions();
	setGraph(data);
	
	var node_id = -1;

	var network = new vis.Network(container, g, options);
	network.fit();

	network.on("selectNode", function(params) {
		node_id = params.nodes[0];
	});

	network.on("deselectNode", function(params) {
		node_id = -1;
	});

	$("#add-folder").click(function(e) {
		e.preventDefault();
		if (node_id != -1) {
			$.ajax({
				type : "POST",
				url : "app_db_createFolder.php",
				data : "parent_id=" + node_id,
				success : function() {
					location.reload();
				}
			});
		}
	});

	$("#add-config-item").click(function(e) {
		e.preventDefault();
		alert("add config item");
	});

	$("#remove-item").click(function(e) {
		e.preventDefault();
		alert("remove item");
	});
});
