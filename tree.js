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

	});
	/*
	.on('changed.jstree', function(e, data) {

		node = data.node;
		$.post("db_loadMap.php", {
			'id' : node.id
		}, function(data) {
			data = JSON.parse(data);
			$("#properties").html();

			if (data.success == 'yes') {
				$("#properties").html(data.message);
			} else {
				alert(data.message);
			}
		});

		if (data.selected) {
			var i,
			    j,
			    r = [];
			for ( i = 0,
			j = data.selected.length; i < j; i++) {
				r.push(data.instance.get_node(data.selected[i]).text);
			}
			$('#application_id').html("application_id: " + data.selected).text;
			$('#name').html("name: " + r.join(', '));
		}
	});*/
});
