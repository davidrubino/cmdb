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

		//http://stackoverflow.com/questions/8120617/jstree-load-and-click
		var parents = $("#tree").jstree("get_path", data.node, true);
		$.each(parents, function(k, v) {
			// Log down the ID's
			$('#parent_id').html(v);
		});
		//var ids = data.get_path(data.node, '/');
		//var names = data.inst.get_path(data.rslt.obj.attr('id'),'#',false);
		//$('#parent_id').html("Path [ID or Name] from root node to selected node = ID's = "+ids ); //+" :: Name's = "+names);

		//$('#parent_id').html(data.node.parents);
		/*node = data.node;
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
		});*/

		//var loMainSelected = data;
		//alert(loMainSelected.node.parents);

		/*var i,
		 j,
		 r = [];
		 for ( i = 0,
		 j = data.selected.length; i < j; i++) {
		 r.push(data.instance.get_node(data.selected[i]).text);
		 }
		 $('#id').html("id: " + data.selected).text;
		 $('#name').html("name: " + r.join(', '));*/
	});

});
