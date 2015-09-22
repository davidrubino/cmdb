/* ------------------------------------------------------------------
 TREE
 ---------------------------------------------------------------------
 */

var application_id = -1;

$(function() {
	$("#tree").jstree({

		"core" : {
			"data" : {
				"type" : "POST",
				"url" : function(node) {
					return node.id === '#' ? 'app_db_treeLoaderRoot.php' : 'app_db_treeLoader.php';
				},
				"data" : function(node) {
					return {
						'id' : node.id
					};
				}
			},
			"multiple" : false
		},

		"types" : {
			"file" : {
				"icon" : "img/file-icon.png",
				"valid_children" : []
			},
			"folder" : {

			}
		},

		"plugins" : ["json_data", "massload", "sort", "state", "themes", "types", "ui", "unique", "wholerow"]

	}).on('select_node.jstree', function(e, data) {
		application_id = data.node.id;

		if (data.node.type == "file") {
			$("#mynetwork").show();
			$('#control-panel').show();
			$.ajax({
				type : "POST",
				url : "app_db_createGraph.php",
				data : "application_id=" + application_id,
				success : function(data) {
					setContainer();
					setOptions();
					setGraph(data);
					setupNetwork();
				}
			});

		} else {
			$("#mynetwork").hide();
			$('#control-panel').hide();
		}
	});
});

/* ------------------------------------------------------------------
 GRAPH
 ---------------------------------------------------------------------
 */

var container,
    options,
    g,
    network;

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

function setupNetwork() {
	network = new vis.Network(container, g, options);
	network.fit();
}
