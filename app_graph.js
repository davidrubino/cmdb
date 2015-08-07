var container,
    options,
    g,
    node_id,
    size;

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

function getGroup(id) {
	for ( i = 0; i < g.nodes.length; i++) {
		if (g.nodes[i].id == id) {
			return g.nodes[i].group;
		}
	}
}

function addFolder() {
	if (node_id != -1) {
		if (getGroup(node_id) != "config_item") {
			$.ajax({
				type : "POST",
				url : "app_db_createFolder.php",
				data : "parent_id=" + node_id,
				success : function() {
					location.reload();
				}
			});
		} else {
			alert("A configuration item cannot be a parent node!");
		}
	} else {
		alert("Please select a parent node!");
	}
}

function loadConfigItem() {
	if (node_id != -1) {
		if (getGroup(node_id) != "config_item") {
			$.ajax({
				type : "POST",
				url : "app_db_loadConfigItems.php",
				success : function(data) {
					var items = new Array();
					for (var i = 0; i < data.length; i++) {
						items.push('<input class="btn btn-large btn-info i-graph" type="button" onclick="addConfigItem(value)" value="' + data[i].name + '">');
					}
					$(".span-cfg").html(items);
				}
			});
		} else {
			alert("A configuration item cannot be a parent node!");
		}
	} else {
		alert("Please select a parent node!");
	}
}

function addConfigItem(value) {
	$.ajax({
		type : "POST",
		url : "app_db_addConfigItems.php",
		data : "value=" + value + "&parent_id=" + node_id,
		success : function() {
			location.reload();
		}
	});
}

function renameFolder() {
	if (node_id != -1) {
		if (getGroup(node_id) == "folder") {
			alert("rename item");
		} else {
			alert("Only folders can be renamed!");
		}
	} else {
		alert("Please select an item to rename!");
	}
}

function removeItem() {
	if (node_id != -1) {
		if (size < 2) {
			if (confirm("Are you sure you want to delete this node?")) {
				$.ajax({
					type : "POST",
					url : "app_db_removeItem.php",
					data : "id=" + node_id,
					success : function() {
						location.reload();
					}
				});
			}
		} else {
			alert("Folder not empty! Please delete all children first!");
		}
	} else {
		alert("Please select an item to remove!");
	}
}

var json = $.getJSON("app_db_createGraph.php").done(function(data) {
	setContainer();
	setOptions();
	setGraph(data);
	node_id = -1;

	var network = new vis.Network(container, g, options);
	network.fit();

	network.on("selectNode", function(params) {
		node_id = params.nodes[0];
		size = params.edges.length;
	});

	network.on("deselectNode", function(params) {
		node_id = -1;
	});
});
