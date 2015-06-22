function customMenu($node) {
	var tree = $("#tree").jstree(true);
	var items = {
		"createfolder" : {
			"separator_before" : false,
			"separator_after" : false,
			"label" : "New folder",
			"action" : function(obj) {
				$node = tree.create_node($node);
				tree.edit($node);
			}
		},
		"createitem" : {
			"separator_before" : false,
			"separator_after" : false,
			"label" : "New configuration item",
			"action" : function(obj) {
				$node = tree.create_node($node, {
					type : "file"
				});
				tree.edit($node);
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

	if ($node.type === 'file') {
		delete items.createfolder;
		delete items.createitem;
	}

	return items;
}

$(function() {
	$("#tree").jstree({

		"core" : {
			"check_callback" : true,
			"data" : {
				"type" : "POST",
				"url" : "db_loadValue.php",
			}
		},

		"types" : {
			"file" : {
				"icon" : "img/file-icon.png",
				"valid_children" : []
			}
		},

		"contextmenu" : {
			"items" : customMenu
		},

		"plugins" : ["contextmenu", "dnd", "massload", "search", "sort", "state", "types", "unique", "wholerow", "themes", "json_data", "ui"]

	}).on('select_node.jstree', function(e, data) {

		console.log(data);
		var path = $("#tree").jstree(true).get_path(data.node, ":");
		var grandparent_name = $("#tree").jstree(true).get_path(data.node)[1];
		var parent_name = $("#tree").jstree(true).get_path(data.node)[2];
		$('#name').html(path);
		$('#class-title').html(grandparent_name);
		$('#subclass-title').html(grandparent_name + ':' + parent_name);

		var id = data.node.id;
		var parent_id = data.node.parent;
		var grandparent_id = data.node.parents[1];

		$.ajax({
			type : "POST",
			url : "db_loadClassProperties.php",
			data : "id=" + id + "&grandparent_id=" + grandparent_id,
			success : function(data) {
				var htmlResult = new Array();
				for (var i = 0; i < data.length; i++) {
					htmlResult.push("<tr><td>" + data[i].name + "</td><td>" + data[i].str_value + "</td></tr>");
				}
				$("#class-panel").html(htmlResult);
			}
		});

		$.ajax({
			type : "POST",
			url : "db_loadConfigItemProperties.php",
			data : "id=" + id + "&parent_id=" + parent_id,
			success : function(data) {
				var htmlResult = new Array();
				for (var i = 0; i < data.length; i++) {
					htmlResult.push("<tr><td>" + data[i].name + "</td><td>" + data[i].str_value + "</td></tr>");
				}
				$("#subclass-panel").html(htmlResult);
			}
		});

	}).bind('delete_node.jstree', function(e, data) {
		// Check medatada, assuming that root's parent_id is NULL:
		if (data.node.parent == '#') {
			core.check_callback(false);
		}
	});
});
