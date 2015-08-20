$(function() {
	$("#tree").jstree({

		"core" : {
			"data" : {
				"type" : "POST",
				"url" : function(node) {
					return 'dc_db_treeLoader.php';
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

		"plugins" : ["json_data", "massload", "sort", "themes", "types", "ui", "unique", "wholerow"]

	}).on('select_node.jstree', function(e, data) {
		$('.col-md-8').html("selected");
	});
});
