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
				url : "db_deleteApplication.php",
				data : "id=" + data.node.id
			});
		} else {
			$.ajax({
				type : "POST",
				url : "db_deleteFolder.php",
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
		if (data.node.type == "file") {
			$("#mynetwork").show();
		}
		else {
			$("#mynetwork").hide();
		}
	});
});
