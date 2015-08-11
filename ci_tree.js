$(function() {
	$("#tree").jstree({

		"core" : {
			"check_callback" : true,

			"data" : {
				"type" : "POST",
				"url" : function(node) {
					return node.id === '#' ? 'db_treeLoaderRoot.php' : 'db_treeLoader.php';
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
			}
		},

		"plugins" : ["massload", "search", "sort", "state", "types", "unique", "wholerow", "themes", "json_data", "ui"]

	}).on('select_node.jstree', function(e, data) {

		var path = $("#tree").jstree(true).get_path(data.node, ":");
		var grandparent_name = $("#tree").jstree(true).get_path(data.node)[1];
		var parent_name = $("#tree").jstree(true).get_path(data.node)[2];
		$('.name').html(path);
		$('.class-title').html(grandparent_name);
		$('.subclass-title').html(grandparent_name + ':' + parent_name);

		var id = data.node.id;
		var parent_id = data.node.parent;
		var grandparent_id = data.node.parents[1];

		$.ajax({
			type : "POST",
			url : "db_loadClassValues.php",
			data : "id=" + id + "&grandparent_id=" + grandparent_id,
			success : function(data) {
				var htmlResult_general = new Array();
				var htmlResult_financial = new Array();
				var htmlResult_labor = new Array();
				for (var i = 0; i < data.length; i++) {
					if (data[i].tab == 'general') {
						htmlResult_general.push("<tr><td>" + data[i].name + "</td><td>" + data[i].value + "</td></tr>");
					}
					if (data[i].tab == 'financial') {
						htmlResult_financial.push("<tr><td>" + data[i].name + "</td><td>" + data[i].value + "</td></tr>");
					}
					if (data[i].tab == 'labor') {
						htmlResult_labor.push("<tr><td>" + data[i].name + "</td><td>" + data[i].value + "</td></tr>");
					}
				}
				$("#class-panel-general").html(htmlResult_general);
				$("#class-panel-financial").html(htmlResult_financial);
				$("#class-panel-labor").html(htmlResult_labor);
			}
		});

		$.ajax({
			type : "POST",
			url : "db_loadSubClassValues.php",
			data : "id=" + id + "&parent_id=" + parent_id,
			success : function(data) {
				var htmlResult_general = new Array();
				var htmlResult_financial = new Array();
				var htmlResult_labor = new Array();
				for (var i = 0; i < data.length; i++) {
					if (data[i].tab == 'general') {
						htmlResult_general.push("<tr><td>" + data[i].name + "</td><td>" + data[i].value + "</td></tr>");
					}
					if (data[i].tab == 'financial') {
						htmlResult_financial.push("<tr><td>" + data[i].name + "</td><td>" + data[i].value + "</td></tr>");
					}
					if (data[i].tab == 'labor') {
						htmlResult_labor.push("<tr><td>" + data[i].name + "</td><td>" + data[i].value + "</td></tr>");
					}
				}
				$("#subclass-panel-general").html(htmlResult_general);
				$("#subclass-panel-financial").html(htmlResult_financial);
				$("#subclass-panel-labor").html(htmlResult_labor);
			}
		});

	}).bind('delete_node.jstree', function(e, data) {
		// Check medatada, assuming that root's parent_id is NULL:
		if (data.node.parent == '#') {
			core.check_callback(false);
		}
	});
});
