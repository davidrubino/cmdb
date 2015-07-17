var global_id = -1;
var global_parent_id = -1;
var global_grandparent_id = -1;

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
				"url" : "db_loadValue.php"
			}
		},

		"types" : {
			"file" : {
				"icon" : "img/file-icon.png",
				"valid_children" : []
			},
			"folder" : {

			},
			"subfolder" : {

			}
		},

		"contextmenu" : {
			"items" : customMenu
		},

		"plugins" : ["contextmenu", "massload", "search", "sort", "state", "types", "unique", "wholerow", "themes", "json_data", "ui"]

	}).on('select_node.jstree', function(e, data) {

		var path = $("#tree").jstree(true).get_path(data.node, ":");
		var grandparent_name = $("#tree").jstree(true).get_path(data.node)[1];
		var parent_name = $("#tree").jstree(true).get_path(data.node)[2];
		$('.name').html(path);
		$('.class-title').html(grandparent_name);
		$('.subclass-title').html(grandparent_name + ':' + parent_name);

		if (data.node.type == "file") {
			$(".tabbable").show();
			$("#fileData_general").show();
			$("#fileData_financial").show();
			$("#fileData_labor").show();

			$("#subfolderData_general").hide();
			$("#subfolderData_financial").hide();
			$("#subfolderData_labor").hide();

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
							htmlResult_general.push('<tr><td>' + data[i].name + '</td><td><input name="generalA[' + i + '][' + global_id + '][' + data[i].name + ']" value="' + data[i].value + '"></td></tr>');
						}
						if (data[i].tab == 'financial') {
							htmlResult_financial.push('<tr><td>' + data[i].name + '</td><td><input name="financialA[' + i + '][' + global_id + '][' + data[i].name + ']" value="' + data[i].value + '"></td></tr>');
						}
						if (data[i].tab == 'labor') {
							htmlResult_labor.push('<tr><td>' + data[i].name + '</td><td><input name="laborA[' + i + '][' + global_id + '][' + data[i].name + ']" value="' + data[i].value + '"></td></tr>');
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
							htmlResult_general.push('<tr><td>' + data[i].name + '</td><td><input name="generalB[' + i + '][' + global_id + '][' + data[i].name + ']" value="' + data[i].value + '"></td></tr>');
						}
						if (data[i].tab == 'financial') {
							htmlResult_financial.push('<tr><td>' + data[i].name + '</td><td><input name="financialB[' + i + '][' + global_id + '][' + data[i].name + ']" value="' + data[i].value + '"></td></tr>');
						}
						if (data[i].tab == 'labor') {
							htmlResult_labor.push('<tr><td>' + data[i].name + '</td><td><input name="laborB[' + i + '][' + global_id + '][' + data[i].name + ']" value="' + data[i].value + '"></td></tr>');
						}
					}
					$("#subclass-panel-general").html(htmlResult_general);
					$("#subclass-panel-financial").html(htmlResult_financial);
					$("#subclass-panel-labor").html(htmlResult_labor);
				}
			});
		}

		if (data.node.type == "subfolder") {
			$(".tabbable").show();
			$("#subfolderData_general").show();
			$("#subfolderData_financial").show();
			$("#subfolderData_labor").show();

			$("#fileData_general").hide();
			$("#fileData_financial").hide();
			$("#fileData_labor").hide();

			$("#folderData_general").hide();
			$("#folderData_financial").hide();
			$("#folderData_labor").hide();

			global_id = data.node.id;

			$.ajax({
				type : "POST",
				url : "db_loadSubClassProperties.php",
				data : "class_id=" + global_id,
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
					$("#subclass-panel-general-data").html(htmlResult_general);
					$("#subclass-panel-financial-data").html(htmlResult_financial);
					$("#subclass-panel-labor-data").html(htmlResult_labor);
				}
			});
		}

		if (data.node.type == "folder") {
			$(".tabbable").show();
			$("#folderData_general").show();
			$("#folderData_financial").show();
			$("#folderData_labor").show();

			$("#fileData_general").hide();
			$("#fileData_financial").hide();
			$("#fileData_labor").hide();

			$("#subfolderData_general").hide();
			$("#subfolderData_financial").hide();
			$("#subfolderData_labor").hide();

			global_id = data.node.id;

			$.ajax({
				type : "POST",
				url : "db_loadClassProperties.php",
				data : "class_id=" + global_id,
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

	}).bind('delete_node.jstree', function(e, data) {
		if (data.node.parent == '#') {
			core.check_callback(false);
		}
	});
});

$(document).ready(function() {
	$("#form-general").on('submit', function(event) {
		event.preventDefault();
		data = $(this).serialize();

		$.ajax({
			type : "POST",
			url : "db_uploadGeneral.php",
			data : data
		}).done(function(msg) {
			alert("Update successful!");
		});
	});

	$("#form-general-subclass").on('submit', function(event) {
		event.preventDefault();
		var form_data = $(this).serialize();

		$.ajax({
			type : "POST",
			url : "db_uploadGeneralSubclass.php",
			data : form_data + "&class_id=" + global_id
		}).done(function(msg) {
			alert("Update successful!");
		});
	});

	$("#form-general-class").on('submit', function(event) {
		event.preventDefault();
		var form_data = $(this).serialize();

		$.ajax({
			type : "POST",
			url : "db_uploadGeneralClass.php",
			data : form_data + "&class_id=" + global_id
		}).done(function(msg) {
			alert("Update successful!");
		});
	});

	$("#form-financial").on('submit', function(event) {
		event.preventDefault();
		data = $(this).serialize();

		$.ajax({
			type : "POST",
			url : "db_uploadFinancial.php",
			data : data
		}).done(function(msg) {
			alert("Update successful!");
		});
	});

	$("#form-financial-subclass").on('submit', function(event) {
		event.preventDefault();
		var form_data = $(this).serialize();

		$.ajax({
			type : "POST",
			url : "db_uploadFinancialSubclass.php",
			data : form_data + "&class_id=" + global_id
		}).done(function(msg) {
			alert("Update successful!");
		});
	});

	$("#form-financial-class").on('submit', function(event) {
		event.preventDefault();
		var form_data = $(this).serialize();

		$.ajax({
			type : "POST",
			url : "db_uploadFinancialClass.php",
			data : form_data + "&class_id=" + global_id
		}).done(function(msg) {
			alert("Update successful!");
		});
	});

	$("#form-labor").on('submit', function(event) {
		event.preventDefault();
		data = $(this).serialize();

		$.ajax({
			type : "POST",
			url : "db_uploadLabor.php",
			data : data
		}).done(function(msg) {
			alert("Update successful!");
		});
	});

	$("#form-labor-subclass").on('submit', function(event) {
		event.preventDefault();
		var form_data = $(this).serialize();

		$.ajax({
			type : "POST",
			url : "db_uploadLaborSubclass.php",
			data : form_data + "&class_id=" + global_id
		}).done(function(msg) {
			alert("Update successful!");
		});
	});

	$("#form-labor-class").on('submit', function(event) {
		event.preventDefault();
		var form_data = $(this).serialize();

		$.ajax({
			type : "POST",
			url : "db_uploadLaborClass.php",
			data : form_data + "&class_id=" + global_id
		}).done(function(msg) {
			alert("Update successful!");
		});
	});

	$("#add-general-class-file-toggler").click(function(e) {
		var tab = "general";
		e.preventDefault();
		$('#class-panel-general').append('<tr><td><select class="form-control" id="select-class-general-file" name="select-class-general-file"></select></td><td><input name="class-general-file" value="my data"></td></tr>');
		$.ajax({
			type : "POST",
			url : "db_loadUnusedClassProperties.php",
			data : "tab=" + tab + "&class_id=" + global_grandparent_id + "&config_item_id=" + global_id,
			success : function(data) {
				$('#select-class-general-file').find('option').remove();
				for (var i = 0; i < data.length; i++) {
					$('#select-class-general-file').append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
				}
			}
		});
	});

	$("#add-general-class-toggler").click(function(e) {
		e.preventDefault();
		$('#class-panel-general-data').append('<tr><td><input name="general-class" value="my data"></td><td><select class="form-control" name="select-general-class" ><option value="string">String</option><option value="date">Date</option><option value="float">Float</option></select></td></tr>');
		$('.btn-group-folder-general').slideDown(0);
	});

	$("#add-general-subclass-file-toggler").click(function(e) {
		var tab = "general";
		e.preventDefault();
		$('#subclass-panel-general').append('<tr><td><select class="form-control" id="select-subclass-general-file" name="select-class-general-file"></select></td><td><input name="subclass-general-file" value="my data"></td></tr>');
		$.ajax({
			type : "POST",
			url : "db_loadUnusedSubclassProperties.php",
			data : "tab=" + tab + "&class_id=" + global_parent_id + "&config_item_id=" + global_id,
			success : function(data) {
				$('#select-subclass-general-file').find('option').remove();
				for (var i = 0; i < data.length; i++) {
					$('#select-subclass-general-file').append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
				}
			}
		});
	});

	$("#add-general-subclass-toggler").click(function(e) {
		e.preventDefault();
		$('#subclass-panel-general-data').append('<tr><td><input name="general-subclass" value="my data"></td><td><select class="form-control" name="select-general-subclass"><option value="string">String</option><option value="date">Date</option><option value="float">Float</option></select></td></tr>');
		$('.btn-group-subfolder-general').slideDown(0);
	});

	$("#add-financial-class-file-toggler").click(function(e) {
		var tab = "financial";
		e.preventDefault();
		$('#class-panel-financial').append('<tr><td><select class="form-control" id="select-class-financial-file" name="select-class-financial-file"></select></td><td><input name="class-financial-file" value="my data"></td></tr>');
		$.ajax({
			type : "POST",
			url : "db_loadUnusedClassProperties.php",
			data : "tab=" + tab + "&class_id=" + global_grandparent_id + "&config_item_id=" + global_id,
			success : function(data) {
				$('#select-class-financial-file').find('option').remove();
				for (var i = 0; i < data.length; i++) {
					$('#select-class-financial-file').append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
				}
			}
		});
	});
	
	$("#add-financial-class-toggler").click(function(e) {
		e.preventDefault();
		$('#class-panel-financial-data').append('<tr><td><input name="financial-class" value="my data"></td><td><select class="form-control" name="select-financial-class"><option value="string">String</option><option value="date">Date</option><option value="float">Float</option></select></td></tr>');
		$('.btn-group-folder-financial').slideDown(0);
	});
	
	$("#add-financial-subclass-file-toggler").click(function(e) {
		var tab = "financial";
		e.preventDefault();
		$('#subclass-panel-financial').append('<tr><td><select class="form-control" id="select-subclass-financial-file" name="select-subclass-financial-file"></select></td><td><input name="subclass-financial-file" value="my data"></td></tr>');
		$.ajax({
			type : "POST",
			url : "db_loadUnusedSubclassProperties.php",
			data : "tab=" + tab + "&class_id=" + global_parent_id + "&config_item_id=" + global_id,
			success : function(data) {
				$('#select-subclass-financial-file').find('option').remove();
				for (var i = 0; i < data.length; i++) {
					$('#select-subclass-financial-file').append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
				}
			}
		});
	});

	$("#add-financial-subclass-toggler").click(function(e) {
		e.preventDefault();
		$('#subclass-panel-financial-data').append('<tr><td><input name="financial-subclass" value="my data"></td><td><select class="form-control" name="select-financial-subclass"><option value="string">String</option><option value="date">Date</option><option value="float">Float</option></select></td></tr>');
		$('.btn-group-subfolder-financial').slideDown(0);
	});
	
	$("#add-labor-class-file-toggler").click(function(e) {
		var tab = "labor";
		e.preventDefault();
		$('#class-panel-labor').append('<tr><td><select class="form-control" id="select-class-labor-file" name="select-class-labor-file"></select></td><td><input name="class-labor-file" value="my data"></td></tr>');
		$.ajax({
			type : "POST",
			url : "db_loadUnusedClassProperties.php",
			data : "tab=" + tab + "&class_id=" + global_grandparent_id + "&config_item_id=" + global_id,
			success : function(data) {
				console.log(global_grandparent_id);
				console.log(global_id);
				console.log(data.length);
				console.log(data);
				$('#select-class-labor-file').find('option').remove();
				for (var i = 0; i < data.length; i++) {
					console.log("in it");
					
					console.log(data[i].name);
					$('#select-class-labor-file').append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
				}
			}
		});
	});

	$("#add-labor-class-toggler").click(function(e) {
		e.preventDefault();
		$('#class-panel-labor-data').append('<tr><td><input name="labor-class" value="my data"></td><td><select class="form-control" name="select-labor-class"><option value="string">String</option><option value="date">Date</option><option value="float">Float</option></select></td></tr>');
		$('.btn-group-folder-labor').slideDown(0);
	});
	
	$("#add-labor-subclass-file-toggler").click(function(e) {
		var tab = "labor";
		e.preventDefault();
		$('#subclass-panel-labor').append('<tr><td><select class="form-control" id="select-subclass-labor-file" name="select-subclass-labor-file"></select></td><td><input name="subclass-labor-file" value="my data"></td></tr>');
		$.ajax({
			type : "POST",
			url : "db_loadUnusedSubclassProperties.php",
			data : "tab=" + tab + "&class_id=" + global_parent_id + "&config_item_id=" + global_id,
			success : function(data) {
				$('#select-subclass-labor-file').find('option').remove();
				for (var i = 0; i < data.length; i++) {
					$('#select-subclass-labor-file').append('<option value=' + data[i].id + '>' + data[i].name + '</option>');
				}
			}
		});
	});

	$("#add-labor-subclass-toggler").click(function(e) {
		e.preventDefault();
		$('#subclass-panel-labor-data').append('<tr><td><input name="labor-subclass" value="my data"></td><td><select class="form-control" name="select-labor-subclass"><option value="string">String</option><option value="date">Date</option><option value="float">Float</option></select></td></tr>');
		$('.btn-group-subfolder-labor').slideDown(0);
	});

	$("#rm-general-class-toggler").click(function(e) {
		$('.highlight-general').remove();
		$('.btn-group-folder-general').slideDown(0);
	});

	$("#rm-general-subclass-toggler").click(function(e) {
		$('.highlight-general').remove();
		$('.btn-group-subfolder-general').slideDown(0);
	});

	$("#rm-financial-class-toggler").click(function(e) {
		$('.highlight-financial').remove();
		$('.btn-group-folder-financial').slideDown(0);
	});

	$("#rm-financial-subclass-toggler").click(function(e) {
		$('.highlight-financial').remove();
		$('.btn-group-subfolder-financial').slideDown(0);
	});

	$("#rm-labor-class-toggler").click(function(e) {
		$('.highlight-labor').remove();
		$('.btn-group-folder-labor').slideDown(0);
	});

	$("#rm-labor-subclass-toggler").click(function(e) {
		$('.highlight-labor').remove();
		$('.btn-group-subfolder-labor').slideDown(0);
	});

	$('#class-panel-general-data').on('click', 'tr', function(event) {
		$(this).addClass('highlight-general').siblings().removeClass('highlight-general');
	});

	$('#subclass-panel-general-data').on('click', 'tr', function(event) {
		$(this).addClass('highlight-general').siblings().removeClass('highlight-general');
	});

	$('#class-panel-financial-data').on('click', 'tr', function(event) {
		$(this).addClass('highlight-financial').siblings().removeClass('highlight-financial');
	});

	$('#subclass-panel-financial-data').on('click', 'tr', function(event) {
		$(this).addClass('highlight-financial').siblings().removeClass('highlight-financial');
	});

	$('#class-panel-labor-data').on('click', 'tr', function(event) {
		$(this).addClass('highlight-labor').siblings().removeClass('highlight-labor');
	});

	$('#subclass-panel-labor-data').on('click', 'tr', function(event) {
		$(this).addClass('highlight-labor').siblings().removeClass('highlight-labor');
	});
});
