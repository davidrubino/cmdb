/* ------------------------------------------------------------------
 TREE
 ---------------------------------------------------------------------
 */

var application_id = -1;

function customMenu($node) {
	var tree = $("#tree").jstree(true);
	var items = {
		"createfolder" : {
			"separator_before" : false,
			"separator_after" : false,
			"label" : "New folder",
			"action" : function(obj) {
				$node = tree.create_node($node, {
					type : "folder"
				});
			}
		},
		"createfile" : {
			"separator_before" : false,
			"separator_after" : false,
			"label" : "New application",
			"action" : function(obj) {
				$node = tree.create_node($node, {
					type : "file"
				});
			}
		},
		"rename" : {
			"separator_before" : false,
			"separator_after" : false,
			"label" : "Rename",
			"action" : function(obj) {
				tree.edit($node);
			}
		},
		"remove" : {
			"separator_before" : false,
			"separator_after" : false,
			"label" : "Remove",
			"action" : function(obj) {
				tree.delete_node($node);
			}
		}
	};

	if ($node.type === 'default') {
		delete items.createfile;
		delete items.remove;
		delete items.rename;
	}

	if ($node.type === 'file') {
		delete items.createfolder;
		delete items.createfile;
	}

	return items;
}

$(function() {
	$("#tree").jstree({

		"core" : {
			"check_callback" : function(operation, node) {
				if (operation === 'delete_node') {
					if (node.children.length == 0) {
						return confirm("Are you sure you want to delete this node?");
					} else {
						alert("Folder not empty! Please delete all of its children first!");
						return false;
					}
				}
			},
			"data" : {
				"type" : "POST",
				"url" : function(node) {
					return node.id === '#' ? 'db_appTreeLoaderRoot.php' : 'db_appTreeLoader.php';
				},
				"data" : function(node) {
					return {
						'id' : node.id
					};
				}
			}
		},

		"types" : {
			"file" : {
				"icon" : "img/file-icon.png",
				"valid_children" : []
			},
			"folder" : {

			}
		},

		"contextmenu" : {
			"items" : customMenu
		},

		"plugins" : ["contextmenu", "json_data", "massload", "search", "sort", "themes", "types", "ui", "unique", "wholerow"]

	}).on('rename_node.jstree', function(e, data) {
		var name = data.text;

		if (data.node.type == 'file') {
			$.ajax({
				type : "POST",
				url : "db_renameApplication.php",
				data : "name=" + name + "&id=" + data.node.id,
			});
		} else {
			$.ajax({
				type : "POST",
				url : "db_renameFolder.php",
				data : "name=" + name + "&parent_id=" + data.node.id,
			});
		}
		$("#tree").jstree("refresh");

	}).on('delete_node.jstree', function(e, data) {
		if (data.node.type == 'file') {
			$.ajax({
				type : "POST",
				url : "app_db_deleteApplication.php",
				data : "id=" + data.node.id,
				success : function() {
					$("#mynetwork").hide();
					$('#control-panel').hide();
				}
			});
		} else {
			$.ajax({
				type : "POST",
				url : "app_db_deleteFolder.php",
				data : "id=" + data.node.id
			});
		}
		$("#tree").jstree("refresh");

	}).on('create_node.jstree', function(e, data) {
		if (data.node.type == 'file') {
			$.ajax({
				type : "POST",
				url : "db_createApplication.php",
				data : "folder_id=" + data.node.parent
			});
		} else {
			$.ajax({
				type : "POST",
				url : "db_createFolder.php",
				data : "id=" + data.node.parent
			});
		}
		$("#tree").jstree("refresh");

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
					resetNodeId();
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
    node_id,
    size,
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

function getGroup(id) {
	for ( i = 0; i < g.nodes.length; i++) {
		if (g.nodes[i].id == id) {
			return g.nodes[i].group;
		}
	}
}

function resetNodeId() {
	node_id = -1;
}

function addFolder() {
	if (node_id != -1) {
		if (getGroup(node_id) != "config_item") {
			$.ajax({
				type : "POST",
				url : "app_db_createFolder.php",
				data : "parent_id=" + node_id + "&application_id=" + application_id,
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
		data : "value=" + value + "&parent_id=" + node_id + "&application_id=" + application_id,
		success : function() {
			location.reload();
		}
	});
}

function renameFolder() {
	if (node_id != -1) {
		if (getGroup(node_id) == "folder") {
			$('.cat1').toggle();
			$(".form-horizontal").on('submit', function(event) {
				event.preventDefault();
				data = $(this).serialize();

				if (data != "txt-name=") {
					$.ajax({
						type : "POST",
						url : "app_db_renameFolder.php",
						data : data + "&id=" + node_id,
						success : function() {
							location.reload();
						}
					});
				} else {
					alert("Please enter a valid name!");
				}
			});
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
					url : "app_db_deleteItem.php",
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

function setupNetwork() {
	network = new vis.Network(container, g, options);
	network.fit();

	network.on("selectNode", function(params) {
		node_id = params.nodes[0];
		size = params.edges.length;
	});

	network.on("deselectNode", function(params) {
		resetNodeId();
		$('.cat1').hide();
	});
}
