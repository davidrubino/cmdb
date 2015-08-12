var global_id,
    global_parent_id,
    global_grandparent_id,
    current_name;

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

function initializeTabs() {
	$('#tabs').tabs();
}

function getCurrentTab() {
	var active = $('#tabs').tabs('option', 'active');
	var tab = $("#tabs ul>li a").eq(active).attr("href");
	return tab.substring(1);
}

function getCurrentId() {
	return global_id;
}

function getFullPath(node) {
	$('.name').html($("#tree").jstree(true).get_path(node, ":"));
}

function createProperty(data, id, tab) {
	$.ajax({
		type : "POST",
		url : "db_createProperty.php",
		data : data + "&class_id=" + id + "&tab=" + tab,
		success : function() {
			location.reload();
		}
	});
}

function removeProperty(name, id) {
	if ($("tr").hasClass("highlight")) {
		if (confirm("Are you sure you want to permanently delete this property?")) {
			$.ajax({
				type : "POST",
				url : "db_removeProperty.php",
				data : "name=" + name + "&id=" + id,
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
}

function getProperties(tab, id) {
	$.ajax({
		type : "POST",
		url : "db_loadClassProperties.php",
		data : "tab=" + tab + "&class_id=" + id,
		success : function(data) {
			var htmlResult = new Array();
			for (var i = 0; i < data.length; i++) {
				htmlResult.push('<tr><td>' + data[i].name + '</td><td>' + data[i].value_type + '</td></tr>');
			}
			$(".property-table").html(htmlResult);
		}
	});
}

function editValues(data) {
	$.ajax({
		type : "POST",
		url : "db_updateValues.php",
		data : data,
		success : function() {
			alert("Update successful!");
		}
	});
}


$(document).ready(function() {
	initializeTabs();

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
		getFullPath(data.node);

		if (data.node.type == "file") {
			var grandparent_name = $("#tree").jstree(true).get_path(data.node)[1];
			var parent_name = $("#tree").jstree(true).get_path(data.node)[2];
			$('.class-title').html(grandparent_name);
			$('.subclass-title').html(grandparent_name + ':' + parent_name);

			initializeTabs();
			$("#tabs").show();

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

			initializeTabs();
			$("#tabs").show();

			$("#folderData_general").show();
			$("#folderData_financial").show();
			$("#folderData_labor").show();

			$("#fileData_general").hide();
			$("#fileData_financial").hide();
			$("#fileData_labor").hide();

			global_id = data.node.id;
			getProperties(getCurrentTab(), getCurrentId());
		}

		if (data.node.type == "default") {
			$("#tabs").hide();
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

	$('#tabs').tabs({
		activate : function(event, ui) {
			getProperties(getCurrentTab(), getCurrentId());
			$('.btn-group').hide();
		}
	});

	$(".property-form").on('submit', function(event) {
		event.preventDefault();
		var form_data = $(this).serialize();
		createProperty(form_data, global_id, getCurrentTab());
	});

	$(".value-form").on('submit', function(event) {
		event.preventDefault();
		var form_data = $(this).serialize();
		editValues(form_data);
	});

	$(".add-toggler").click(function(e) {
		e.preventDefault();
		$('.property-table').append('<tr><td><input name="property-name" value="my data"></td><td><select class="form-control" name="property-type" ><option value="string">String</option><option value="date">Date</option><option value="float">Float</option></select></td></tr>');
		$('.btn-group').slideDown(0);
	});

	$(".rm-toggler").click(function(e) {
		e.preventDefault();
		removeProperty(current_name, global_id);
	});

	$('.selectable').on('click', 'tr', function(event) {
		current_name = $(this).find("td")[0].innerHTML;
		$('tr').removeClass('highlight');
		$(this).addClass('highlight');
	});

});
