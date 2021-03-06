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

		"contextmenu" : {
			"items" : customMenu
		},

		"plugins" : ["contextmenu", "json_data", "massload", "search", "sort", "state", "themes", "types", "ui", "unique", "wholerow"]

	}).on('rename_node.jstree', function(e, data) {
		var name = data.text;
		if (data.node.type == 'file') {
			$.ajax({
				type : "POST",
				url : "app_db_renameApplication.php",
				data : "name=" + name + "&id=" + data.node.id,
				success : function() {
					$("#tree").jstree("refresh");
				}
			});
		} else {
			$.ajax({
				type : "POST",
				url : "app_db_renameFolder.php",
				data : "name=" + name + "&parent_id=" + data.node.id,
				success : function() {
					$("#tree").jstree("refresh");
				}
			});
		}

	}).on('delete_node.jstree', function(e, data) {
		if (data.node.type == 'file') {
			$.ajax({
				type : "POST",
				url : "app_db_deleteApplication.php",
				data : "id=" + data.node.id,
				success : function() {
					$("#mynetwork").hide();
					$('#control-panel').hide();
					$("#tree").jstree("refresh");
				}
			});
		} else {
			$.ajax({
				type : "POST",
				url : "app_db_deleteFolder.php",
				data : "id=" + data.node.id,
				success : function() {
					$("#tree").jstree("refresh");
				}
			});
		}

	}).on('create_node.jstree', function(e, data) {
		if (data.node.type == 'file') {
			$.ajax({
				type : "POST",
				url : "app_db_createApplication.php",
				data : "folder_id=" + data.node.parent,
				success : function() {
					$("#tree").jstree("refresh");
				}
			});
		} else {
			$.ajax({
				type : "POST",
				url : "app_db_createFolder.php",
				data : "id=" + data.node.parent,
				success : function() {
					$("#tree").jstree("refresh");
				}
			});
		}

	}).on('select_node.jstree', function(e, data) {
		setApplicationId(data.node.id);
		$('.cat1').hide();
		resetSelect();

		if (data.node.type == "file") {
			$("#mynetwork").show();
			$('#control-panel').show();
			$.ajax({
				type : "POST",
				url : "app_db_createGraph.php",
				data : "application_id=" + getApplicationId(),
				success : function(data) {
					setContainer();
					setOptions();
					setGraph(data);
					setNodeId(-1);
					setupNetwork();
				}
			});

		} else {
			$("#mynetwork").hide();
			$('#control-panel').hide();
		}
	});

	$(".btn-cancel").click(function(e) {
		e.preventDefault();
		$('.cat1').hide();
	});

	$('#addFolder').click(function(e) {
		e.preventDefault();
		addFolder();
	});

	$('#loadConfigItems').click(function(e) {
		e.preventDefault();
		if (getNodeId() != -1) {
			if (getGroup(getNodeId()) != "config_item") {
				$.ajax({
					type : "POST",
					url : "app_db_loadConfigItems.php",
					success : function(data) {
						if (data.length != 0) {
							for (var i = 0; i < data.length; i++) {
								$("#select-ci").append($('<option>', {
									value : data[i].id,
									text : data[i].name
								}));
							}
							$(".form-group").show();
						} else {
							alert("There is no configuration item to add!");
						}
						$(".cat1").hide();
					}
				});
			} else {
				alert("A configuration item cannot be a parent node!");
			}
		} else {
			alert("Please select a parent node!");
		}
	});

	$("#form1").on('submit', function(event) {
		event.preventDefault();
		var form_data = $(this).serialize();
		var x = document.getElementById("select-ci");
		var strUser = x.options[x.selectedIndex].text;
		if (form_data.indexOf("selectionField") != -1) {
			$.ajax({
				type : "POST",
				url : "app_db_addConfigItems.php",
				data : form_data + "&value=" + strUser + "&parent_id=" + getNodeId() + "&application_id=" + getApplicationId(),
				success : function() {
					location.reload();
				}
			});
		} else {
			alert("Please select a server!");
		}
	});

	$("#cancel-select-ci").click(function(e) {
		e.preventDefault();
		resetSelect();
	});

	$('#renameFolder').click(function(e) {
		e.preventDefault();
		renameFolder();
	});

	$('#removeItem').click(function(e) {
		e.preventDefault();
		removeItem();
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

/**
 * adds a folder in the graph after the selected node
 */
function addFolder() {
	if (getNodeId() != -1) {
		if (getGroup(getNodeId()) != "config_item") {
			$.ajax({
				type : "POST",
				url : "app_db_createNode.php",
				data : "parent_id=" + getNodeId() + "&application_id=" + getApplicationId(),
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

/**
 * returns the id of the selected application in the tree
 */
function getApplicationId() {
	return application_id;
}

/**
 * returns the group of the selected node. There are 3 possible groups: app, folder, config_item
 * @param {Int} id: the id of the node
 */
function getGroup(id) {
	for ( i = 0; i < g.nodes.length; i++) {
		if (g.nodes[i].id == id) {
			return g.nodes[i].group;
		}
	}
}

/**
 * returns the id of the selected node in the graph
 */
function getNodeId() {
	return node_id;
}

/**
 * removes the selected node from the graph
 */
function removeItem() {
	if (getNodeId() != -1) {
		if (size < 2) {
			if (confirm("Are you sure you want to delete this node?")) {
				$.ajax({
					type : "POST",
					url : "app_db_deleteItem.php",
					data : "id=" + getNodeId(),
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

/**
 * renames the selected folder in the graph
 */
function renameFolder() {
	if (getNodeId() != -1) {
		if (getGroup(getNodeId()) == "folder") {
			resetSelect();
			$('.cat1').show();
			$(".form-horizontal").on('submit', function(event) {
				event.preventDefault();
				data = $(this).serialize();

				if (data != "txt-name=") {
					$.ajax({
						type : "POST",
						url : "app_db_renameNode.php",
						data : data + "&id=" + getNodeId(),
						success : function() {
							location.reload();
							$('.cat1').hide();
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

/**
 * reset the different selections when the node is no longer on focus
 * It hides the menu allowing the user to choose a config item to add in the graph.
 * It resets the html of the menu field where the configuration items are displayed.
 */
function resetSelect() {
	$("#select-ci").html("");
	$(".form-group").hide();
}

/**
 * sets the id of the application currently selected in the tree
 * @param {Int} id: the id of the application
 */
function setApplicationId(id) {
	application_id = id;
}

/**
 * sets the HTML element containing the graph
 */
function setContainer() {
	container = document.getElementById('mynetwork');
}

/**
 * creates the graph according to the JSON data returned from the server
 * @param {Object} data: the data from the server
 */
function setGraph(data) {
	g = {
		nodes : data.nodes,
		edges : data.edges
	};
}

/**
 * sets the id of the selected node in the graph
 * @aparam {Int} id: the id of the node
 */
function setNodeId(id) {
	node_id = id;
}

/**
 * set the different options for the graph including groups, icons, and layout
 */
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

/**
 * creates the graph network using the JQuery plugin
 */
function setupNetwork() {
	network = new vis.Network(container, g, options);
	network.fit();

	network.on("selectNode", function(params) {
		setNodeId(params.nodes[0]);
		size = params.edges.length;
		$('.cat1').hide();
		resetSelect();
	});

	network.on("deselectNode", function(params) {
		setNodeId(-1);
		$('.cat1').hide();
		resetSelect();
	});
}
