var global_id = -1;
var global_parent_id = -1;
var global_grandparent_id = -1;

function customMenu($node) {
	var tree = $("#tree").jstree(true);
	var items = {
		"createfolder" : {
			"separator_before" : false,
			"separator_after" : false,
			"label" : "New class",
			"action" : function(obj) {
				$node = tree.create_node($node, {
					type : "folder"
				});
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
		delete items.createitem;
		delete items.remove;
		delete items.rename;
	}

	if ($node.type === 'file') {
		delete items.createfolder;
		delete items.createitem;
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
			},
			"folder" : {

			}
		},

		"contextmenu" : {
			"items" : customMenu
		},

		"plugins" : ["contextmenu", "json_data", "massload", "search", "sort", "themes", "types", "ui", "unique", "wholerow"]

	}).on('select_node.jstree', function(e, data) {
		var path = $("#tree").jstree(true).get_path(data.node, ":");
		$('.name').html(path);

		if (data.node.type == "file") {
			var grandparent_name = $("#tree").jstree(true).get_path(data.node)[1];
			var parent_name = $("#tree").jstree(true).get_path(data.node)[2];
			$('.class-title').html(grandparent_name);
			$('.subclass-title').html(grandparent_name + ':' + parent_name);

			$(".tabbable").show();

			$("#fileData_general").show();
			$("#fileData_financial").show();
			$("#fileData_labor").show();

			$("#folderData_general").hide();
			$("#folderData_financial").hide();
			$("#folderData_labor").hide();

			global_id = data.node.id;
			global_parent_id = data.node.parent;
			global_grandparent_id = data.node.parents[1];

			$.ajax({
				type : "POST",
				url : "db_loadClassValues.php",
				data : "id=" + global_id + "&grandparent_id=" + global_grandparent_id,
				success : function(data) {
					var htmlResult_general = new Array();
					var htmlResult_financial = new Array();
					var htmlResult_labor = new Array();
					for (var i = 0; i < data.length; i++) {
						if (data[i].tab == 'general') {
							htmlResult_general.push('<tr><td>' + data[i].name + '</td><td><input name="classValue[' + i + '][' + global_id + '][' + data[i].name + ']" value="' + data[i].value + '"></td></tr>');
						}
						if (data[i].tab == 'financial') {
							htmlResult_financial.push('<tr><td>' + data[i].name + '</td><td><input name="classValue[' + i + '][' + global_id + '][' + data[i].name + ']" value="' + data[i].value + '"></td></tr>');
						}
						if (data[i].tab == 'labor') {
							htmlResult_labor.push('<tr><td>' + data[i].name + '</td><td><input name="classValue[' + i + '][' + global_id + '][' + data[i].name + ']" value="' + data[i].value + '"></td></tr>');
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
				data : "id=" + global_id + "&parent_id=" + global_parent_id,
				success : function(data) {
					var htmlResult_general = new Array();
					var htmlResult_financial = new Array();
					var htmlResult_labor = new Array();
					for (var i = 0; i < data.length; i++) {
						if (data[i].tab == 'general') {
							htmlResult_general.push('<tr><td>' + data[i].name + '</td><td><input name="subclassValue[' + i + '][' + global_id + '][' + data[i].name + ']" value="' + data[i].value + '"></td></tr>');
						}
						if (data[i].tab == 'financial') {
							htmlResult_financial.push('<tr><td>' + data[i].name + '</td><td><input name="subclassValue[' + i + '][' + global_id + '][' + data[i].name + ']" value="' + data[i].value + '"></td></tr>');
						}
						if (data[i].tab == 'labor') {
							htmlResult_labor.push('<tr><td>' + data[i].name + '</td><td><input name="subclassValue[' + i + '][' + global_id + '][' + data[i].name + ']" value="' + data[i].value + '"></td></tr>');
						}
					}
					$("#subclass-panel-general").html(htmlResult_general);
					$("#subclass-panel-financial").html(htmlResult_financial);
					$("#subclass-panel-labor").html(htmlResult_labor);
				}
			});
		}

		if (data.node.type == "folder") {
			var item_path = $("#tree").jstree(true).get_path(data.node);
			item_path.shift();
			var string = "";
			for (var i = 0; i < item_path.length; i++) {
				string += item_path[i] + ":";
			}
			$('.class-title').html(string);

			$(".tabbable").show();

			$("#folderData_general").show();
			$("#folderData_financial").show();
			$("#folderData_labor").show();

			$("#fileData_general").hide();
			$("#fileData_financial").hide();
			$("#fileData_labor").hide();

			global_id = data.node.id;

			$.ajax({
				type : "POST",
				url : "db_loadClassProperties.php",
				data : "class_id=" + data.node.id,
				success : function(data) {
					var htmlResult_general = new Array();
					var htmlResult_financial = new Array();
					var htmlResult_labor = new Array();
					for (var i = 0; i < data.length; i++) {
						if (data[i].tab == 'general') {
							htmlResult_general.push('<tr><td>' + data[i].name + '</td><td>' + data[i].value_type + '</td></tr>');
						}
						if (data[i].tab == 'financial') {
							htmlResult_financial.push('<tr><td>' + data[i].name + '</td><td>' + data[i].value_type + '</td></tr>');
						}
						if (data[i].tab == 'labor') {
							htmlResult_labor.push('<tr><td>' + data[i].name + '</td><td>' + data[i].value_type + '</td></tr>');
						}
					}
					$("#class-panel-general-data").html(htmlResult_general);
					$("#class-panel-financial-data").html(htmlResult_financial);
					$("#class-panel-labor-data").html(htmlResult_labor);
				}
			});
		}

		if (data.node.type == "default") {
			$(".tabbable").hide();
		}

	}).on('rename_node.jstree', function(e, data) {
		var name = data.text;
		if (data.node.type == 'file') {
			$.ajax({
				type : "POST",
				url : "db_renameConfigItem.php",
				data : "name=" + name + "&id=" + data.node.id
			});
		} else {
			$.ajax({
				type : "POST",
				url : "db_renameClass.php",
				data : "name=" + name + "&class_id=" + data.node.id
			});
		}
		$("#tree").jstree("refresh");

	}).on('delete_node.jstree', function(e, data) {
		if (data.node.type == 'file') {
			$.ajax({
				type : "POST",
				url : "db_deleteConfigItem.php",
				data : "id=" + data.node.id,
				success : function(data) {
					$(".tabbable").hide();
				}
			});
		} else {
			$.ajax({
				type : "POST",
				url : "db_deleteClass.php",
				data : "id=" + data.node.id,
				success : function(data) {
					$(".tabbable").hide();
				}
			});
		}
		$("#tree").jstree("refresh");

	}).on('create_node.jstree', function(e, data) {
		if (data.node.type == 'file') {
			$.ajax({
				type : "POST",
				url : "db_createConfigItem.php",
				data : "class_id=" + data.node.parent + "&parent_id=" + data.node.parents[1]
			});
		} else {
			$.ajax({
				type : "POST",
				url : "db_createClass.php",
				data : "id=" + data.node.parent
			});
		}
		$("#tree").jstree("refresh");
	});
});

$(document).ready(function() {
	var current_name = "";

	$("#form-general").on('submit', function(event) {
		event.preventDefault();
		data = $(this).serialize();

		$.ajax({
			type : "POST",
			url : "db_updateValues.php",
			data : data
		}).done(function(msg) {
			alert("Update successful!");
		});
	});

	$("#form-general-class").on('submit', function(event) {
		event.preventDefault();
		var form_data = $(this).serialize();

		$.ajax({
			type : "POST",
			url : "db_createProperty.php",
			data : form_data + "&class_id=" + global_id + "&tab=general"
		}).done(function(msg) {
			alert("Update successful!");
		});
	});

	$("#form-financial").on('submit', function(event) {
		event.preventDefault();
		data = $(this).serialize();

		$.ajax({
			type : "POST",
			url : "db_updateValues.php",
			data : data
		}).done(function(msg) {
			alert("Update successful!");
		});
	});

	$("#form-financial-class").on('submit', function(event) {
		event.preventDefault();
		var form_data = $(this).serialize();

		$.ajax({
			type : "POST",
			url : "db_createProperty.php",
			data : form_data + "&class_id=" + global_id + "&tab=financial"
		}).done(function(msg) {
			alert("Update successful!");
		});
	});

	$("#form-labor").on('submit', function(event) {
		event.preventDefault();
		data = $(this).serialize();

		$.ajax({
			type : "POST",
			url : "db_updateValues.php",
			data : data
		}).done(function(msg) {
			alert("Update successful!");
		});
	});

	$("#form-labor-class").on('submit', function(event) {
		event.preventDefault();
		var form_data = $(this).serialize();

		$.ajax({
			type : "POST",
			url : "db_createProperty.php",
			data : form_data + "&class_id=" + global_id + "&tab=labor"
		}).done(function(msg) {
			alert("Update successful!");
		});
	});

	$("#add-general-class-toggler").click(function(e) {
		e.preventDefault();
		$('#class-panel-general-data').append('<tr><td><input name="property-name" value="my data"></td><td><select class="form-control" name="property-type" ><option value="string">String</option><option value="date">Date</option><option value="float">Float</option></select></td></tr>');
		$('.btn-group-folder-general').slideDown(0);
	});

	$("#add-financial-class-toggler").click(function(e) {
		e.preventDefault();
		$('#class-panel-financial-data').append('<tr><td><input name="property-name" value="my data"></td><td><select class="form-control" name="property-type"><option value="string">String</option><option value="date">Date</option><option value="float">Float</option></select></td></tr>');
		$('.btn-group-folder-financial').slideDown(0);
	});

	$("#add-labor-class-toggler").click(function(e) {
		e.preventDefault();
		$('#class-panel-labor-data').append('<tr><td><input name="property-name" value="my data"></td><td><select class="form-control" name="property-type"><option value="string">String</option><option value="date">Date</option><option value="float">Float</option></select></td></tr>');
		$('.btn-group-folder-labor').slideDown(0);
	});

	$(".rm-toggler").click(function(e) {
		e.preventDefault();
		if ($("tr").hasClass("highlight")) {
			if (confirm("Are you sure you want to permanently delete this property?")) {
				$.ajax({
					type : "POST",
					url : "db_removeProperty.php",
					data : "name=" + current_name + "&id=" + global_id,
					success : function(data) {
						$('.highlight').remove();
					}
				});
			} else {
				return;
			}
		} else {
			alert("Please select a property to remove!");
		}
	});

	$('.selectable').on('click', 'tr', function(event) {
		current_name = $(this).find("td")[0].innerHTML;
		$('tr').removeClass('highlight');
		$(this).addClass('highlight');
	});

});
