var global_id,
    global_parent_id,
    global_grandparent_id,
    current_name;

/**
 * reurns the id of the selected node in the tree
 */
function getCurrentId() {
	return global_id;
}

/**
 * returns the current selected tab
 */
function getCurrentTab() {
	var active = $('#tabs').tabs('option', 'active');
	var tab = $("#tabs ul>li a").eq(active).attr("href");
	return tab.substring(1);
}

/**
 * prints the path of the selected node from the root node
 * @param {Int} id: the id of the selected node
 */
function getFullPath(node) {
	$('.name').html($("#tree").jstree(true).get_path(node, ":"));
}

/**
 * loads the properties of the selected class for the selected tab
 * @param {String} tab: the tab name
 * @param {Int} id: the id of the selected node in the tree
 * @param {String} table: the class name of the HTML table in which the results will be displayed
 * @param {String} classTitle: the class name of the HTML field reserved for the title of the table
 */
function getProperties(tab, id, table, classTitle) {
	$.ajax({
		type : "POST",
		url : "ci_db_loadClassProperties.php",
		data : "tab=" + tab + "&class_id=" + id,
		success : function(data) {
			var htmlResult = new Array();
			var title = new Array();
			for (var i = 0; i < data.length; i++) {
				for (var j = 0; j < data[i].content.length; j++) {
					htmlResult.push('<tr><td>' + data[i].content[j].name + '</td><td>' + data[i].content[j].value_type + '</td></tr>');
				}
				for (var j = 0; j < data[i].title.length; j++) {
					title.push(data[i].title[j].name);
				}
			}
			if (htmlResult.length == 0) {
				htmlResult.push('<div class="alert alert-info" role="alert">There are no properties for this category.</div>');
			}
			$(table).html(htmlResult);
			$(classTitle).html(title);
		}
	});
}

/**
 * get the property values for the selected configuration item in the selected tab
 * @param {Int} id: the node id
 * @param {String} tab: the tab name
 */
function getValues(id, tab) {
	$.ajax({
		type : "POST",
		url : "ci_db_loadClassValues.php",
		data : "id=" + id + "&tab=" + tab,
		success : function(data) {
			var htmlContainer = new Array();
			for (var i = 0; i < data.length; i++) {
				for (var k = 0; k < data[i].title.length; k++) {
					for (var j = 0; j < data[i].content.length; j++) {
						htmlContainer.push('<div class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title">' + data[i].title[k].name + '</h3></div><div class="table-responsive"><table class="table value-table"><tr><td>' + data[i].content[j].name + '</td><td>' + data[i].content[j].value + '</td></tr></table></div></div>');
					}
				}
			}
			if (htmlContainer.length == 0) {
				htmlContainer.push('<div class="alert alert-info" role="alert">There are no properties for this category.</div>');
			}
			$('.values').html(htmlContainer);
		}
	});
}

/**
 * sets the different category tabs: general, financial, labor
 */
function initializeTabs() {
	$('#tabs').tabs();
}


$(document).ready(function() {
	initializeTabs();

	$("#tree").jstree({
		"core" : {
			"check_callback" : true,
			"data" : {
				"type" : "POST",
				"url" : function(node) {
					return node.id === '#' ? 'ci_db_treeLoaderRoot.php' : 'ci_db_treeLoader.php';
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

		"plugins" : ["json_data", "massload", "search", "sort", "state", "themes", "types", "ui", "unique", "wholerow"]

	}).on('select_node.jstree', function(e, data) {
		getFullPath(data.node);

		if (data.node.type == "file") {
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

			global_id = data.node.id;
			getProperties(getCurrentTab(), getCurrentId(), ".property-table", ".property-class-title");
		}

		if (data.node.type == "default") {
			$("#tabs").hide();
		}
	});

	$('#tabs').tabs({
		activate : function(event, ui) {
			getProperties(getCurrentTab(), getCurrentId(), ".property-table", ".property-class-title");
			getValues(getCurrentId(), getCurrentTab());
			$('.btn-group').hide();
		}
	});
});
