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

function getFullPath(node) {
	$('.name').html($("#tree").jstree(true).get_path(node, ":"));
}

function getCurrentId() {
	return global_id;
}

function setCurrentId(id) {
	global_id = id;
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
				url : "db_deleteProperty.php",
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

function getProperties(tab, id, table, classTitle) {
	$.ajax({
		type : "POST",
		url : "db_loadClassProperties.php",
		data : "tab=" + tab + "&class_id=" + id,
		success : function(data) {
			var htmlResult = new Array();
			var title = new Array();
			for (var i = 0; i < data.length; i++) {
				for (var j = 0; j < data[i].content.length; j++) {
					htmlResult.push('<tr><td>' + data[i].content[j].name + '</td><td>' + data[i].content[j].value_type + '</td></tr>');
				}
				for (var k = 0; k < data[i].title.length; k++) {
					title.push(data[i].title[k].name);
				}
			}
			$(table).html(htmlResult);
			$(classTitle).html(title);
		}
	});
}

function getValues(id, tab) {
	$.ajax({
		type : "POST",
		url : "db_loadClassValues.php",
		data : "id=" + id + "&tab=" + tab,
		success : function(data) {
			var htmlContainer = new Array();
			for (var i = 0; i < data.length; i++) {
				for (var k = 0; k < data[i].title.length; k++) {
					for (var j = 0; j < data[i].content.length; j++) {
						htmlContainer.push('<div class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title">' + data[i].title[k].name + '</h3></div><div class="table-responsive"><table class="table value-table"><tr><td>' + data[i].content[j].name + '</td><td><input name="' + data[i].content[j].name + '" value="' + data[i].content[j].value + '"></td></tr></table></div></div>');
					}
				}
			}
			if (htmlContainer.length != 0) {
				htmlContainer.push('<button type="submit" class="btn btn-large btn-primary">Save</button>');
				htmlContainer.push('<input type="button" onclick="document.location.href=\'ci_admin.php\';" value="Cancel" class="btn btn-large btn-default">');
			} else {
				htmlContainer.push('<div class="alert alert-info" role="alert">There are no properties for this category.</div>');
			}
			$('.value-form').html(htmlContainer);
		}
	});
}

function editValues(id, name, value) {
	$.ajax({
		type : "POST",
		url : "db_updateValues.php",
		data : "id=" + id + "&name=" + name + "&value=" + value,
		success : function(data) {
			$('.alert-success').html(data);
			$('.alert-success').show();
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

		"plugins" : ["contextmenu", "json_data", "massload", "search", "sort", "state", "themes", "types", "ui", "unique", "wholerow"]

	}).on('select_node.jstree', function(e, data) {
		getFullPath(data.node);
		$('.alert-success').hide();
		setCurrentId(data.node.id);

		if (data.node.type == "file") {
			initializeTabs();
			$("#tabs").show();

			$("#fileData_general").show();
			$("#fileData_financial").show();
			$("#fileData_labor").show();

			$("#folderData_general").hide();
			$("#folderData_financial").hide();
			$("#folderData_labor").hide();

			global_parent_id = data.node.parent;
			global_grandparent_id = data.node.parents[1];

			getValues(getCurrentId(), getCurrentTab());
		}

		if (data.node.type == "folder") {
			initializeTabs();
			$("#tabs").show();

			$("#folderData_general").show();
			$("#folderData_financial").show();
			$("#folderData_labor").show();

			$("#fileData_general").hide();
			$("#fileData_financial").hide();
			$("#fileData_labor").hide();

			getProperties(getCurrentTab(), getCurrentId(), ".property-table", ".property-class-title");
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
				data : "name=" + name + "&id=" + data.node.id,
				success : function() {
					$("#tree").jstree("refresh");
				}
			});
		} else {
			$.ajax({
				type : "POST",
				url : "db_renameClass.php",
				data : "name=" + name + "&class_id=" + data.node.id,
				success : function() {
					$("#tree").jstree("refresh");
				}
			});
		}

	}).on('delete_node.jstree', function(e, data) {
		if (data.node.type == 'file') {
			$.ajax({
				type : "POST",
				url : "db_deleteConfigItem.php",
				data : "id=" + data.node.id,
				success : function(data) {
					$("#tabs").hide();
					$("#tree").jstree("refresh");
				}
			});
		} else {
			$.ajax({
				type : "POST",
				url : "db_deleteClass.php",
				data : "id=" + data.node.id,
				success : function(data) {
					$("#tabs").hide();
					$("#tree").jstree("refresh");
				}
			});
		}

	}).on('create_node.jstree', function(e, data) {
		if (data.node.type == 'file') {
			$.ajax({
				type : "POST",
				url : "db_createConfigItem.php",
				data : "class_id=" + data.node.parent + "&parent_id=" + data.node.parents[1],
				success : function(data) {
					$("#tree").jstree("refresh");
				}
			});
		} else {
			$.ajax({
				type : "POST",
				url : "db_createClass.php",
				data : "id=" + data.node.parent,
				success : function(data) {
					$("#tree").jstree("refresh");
				}
			});
		}
	});

	$('#tabs').tabs({
		activate : function(event, ui) {
			getProperties(getCurrentTab(), getCurrentId(), ".property-table", ".property-class-title");
			getValues(getCurrentId(), getCurrentTab());
			$('.btn-group').hide();
			$('.alert-success').hide();
		}
	});

	$(".property-form").on('submit', function(event) {
		event.preventDefault();
		var form_data = $(this).serialize();
		createProperty(form_data, getCurrentId(), getCurrentTab());
	});

	$(".value-form").on('submit', function(event) {
		event.preventDefault();
		var elem = document.getElementsByClassName('value-form');
		var index = -1;

		if (getCurrentTab() == "general") {
			index = 0;
		} else {
			if (getCurrentTab() == "financial") {
				index = 1;
			} else {
				index = 2;
			}
		}

		for (var i = 0; i < elem[index].length; i++) {
			if (elem[index][i].type == "text") {
				var name = elem[index][i].name;
				var value = elem[index][i].value;
				editValues(getCurrentId(), name, value);
			}
		}
	});

	$(".add-toggler").click(function(e) {
		e.preventDefault();
		$('.property-table').append('<tr><td><input name="property-name" value="my data"></td><td><select class="form-control" name="property-type" ><option value="string">String</option><option value="date">Date</option><option value="float">Float</option></select></td></tr>');
		$('.btn-group').slideDown(0);
	});

	$(".rm-toggler").click(function(e) {
		e.preventDefault();
		removeProperty(current_name, getCurrentId());
	});

	$(".btn-cancel").click(function(e) {
		e.preventDefault();
		document.location.href = 'ci_admin.php';
	});

	$('.selectable').on('click', 'tr', function(event) {
		current_name = $(this).find("td")[0].innerHTML;
		$('tr').removeClass('highlight');
		$(this).addClass('highlight');
	});

});
