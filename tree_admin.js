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
			$(".class-panel").show();
			$(".subclass-panel").show();
			$(".tabbable").show();
			$(".btn-group-file").show();
			$(".controls").hide();

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
							htmlResult_general.push('<tr><td>' + data[i].name + '</td><td><input name="generalA[' + i + '][' + id + '][' + data[i].name + ']" value="' + data[i].value + '"></td></tr>');
						}
						if (data[i].tab == 'financial') {
							htmlResult_financial.push('<tr><td>' + data[i].name + '</td><td><input name="financialA[' + i + '][' + id + '][' + data[i].name + ']" value="' + data[i].value + '"></td></tr>');
						}
						if (data[i].tab == 'labor') {
							htmlResult_labor.push('<tr><td>' + data[i].name + '</td><td><input name="laborA[' + i + '][' + id + '][' + data[i].name + ']" value="' + data[i].value + '"></td></tr>');
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
							htmlResult_general.push('<tr><td>' + data[i].name + '</td><td><input name="generalB[' + i + '][' + id + '][' + data[i].name + ']" value="' + data[i].value + '"></td></tr>');
						}
						if (data[i].tab == 'financial') {
							htmlResult_financial.push('<tr><td>' + data[i].name + '</td><td><input name="financialB[' + i + '][' + id + '][' + data[i].name + ']" value="' + data[i].value + '"></td></tr>');
						}
						if (data[i].tab == 'labor') {
							htmlResult_labor.push('<tr><td>' + data[i].name + '</td><td><input name="laborB[' + i + '][' + id + '][' + data[i].name + ']" value="' + data[i].value + '"></td></tr>');
						}
					}
					$("#subclass-panel-general").html(htmlResult_general);
					$("#subclass-panel-financial").html(htmlResult_financial);
					$("#subclass-panel-labor").html(htmlResult_labor);
				}
			});
		}

		if (data.node.type == "subfolder") {
			$(".class-panel").hide();
			$(".btn-group-file").hide();
			$(".controls").show();
			$(".subclass-panel").show();
			$(".tabbable").show();

			var class_id = data.node.id;

			$.ajax({
				type : "POST",
				url : "db_loadSubClassProperties.php",
				data : "class_id=" + class_id,
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
					$("#subclass-panel-general").html(htmlResult_general);
					$("#subclass-panel-financial").html(htmlResult_financial);
					$("#subclass-panel-labor").html(htmlResult_labor);
				}
			});
		}

		if (data.node.type == "folder") {
			$(".subclass-panel").hide();
			$(".btn-group-file").hide();
			$(".controls").show();
			$(".class-panel").show();
			$(".tabbable").show();

			var class_id = data.node.id;

			$.ajax({
				type : "POST",
				url : "db_loadClassProperties.php",
				data : "class_id=" + class_id,
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
					$("#class-panel-general").html(htmlResult_general);
					$("#class-panel-financial").html(htmlResult_financial);
					$("#class-panel-labor").html(htmlResult_labor);
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
			type : "GET",
			url : "db_uploadGeneral.php",
			data : data
		}).done(function(msg) {
			alert("Update successful!");
		});
	});

	$("#form-financial").on('submit', function(event) {
		event.preventDefault();
		data = $(this).serialize();

		$.ajax({
			type : "GET",
			url : "db_uploadFinancial.php",
			data : data
		}).done(function(msg) {
			alert("Update successful!");
		});
	});

	$("#form-labor").on('submit', function(event) {
		event.preventDefault();
		data = $(this).serialize();

		$.ajax({
			type : "GET",
			url : "db_uploadLabor.php",
			data : data
		}).done(function(msg) {
			alert("Update successful!");
		});
	});

	$("#add-general-class-toggler").click(function(e) {
		e.preventDefault();
		$('#class-panel-general').append('<tr><td><input value="my data"></td><td><select class="form-control" name="select-value"><option value="string">String</option><option value="date">Date</option><option value="float">Float</option></select></td></tr>');
		$('.btn-group').slideDown(0);
	});

	$("#add-general-subclass-toggler").click(function(e) {
		e.preventDefault();
		$('#subclass-panel-general').append('<tr><td><input value="my data"></td><td><select class="form-control" name="select-value"><option value="string">String</option><option value="date">Date</option><option value="float">Float</option></select></td></tr>');
		$('.btn-group').slideDown(0);
	});

	$("#add-financial-class-toggler").click(function(e) {
		e.preventDefault();
		$('#class-panel-financial').append('<tr><td><input value="my data"></td><td><select class="form-control" name="select-value"><option value="string">String</option><option value="date">Date</option><option value="float">Float</option></select></td></tr>');
		$('.btn-group').slideDown(0);
	});

	$("#add-financial-subclass-toggler").click(function(e) {
		e.preventDefault();
		$('#subclass-panel-financial').append('<tr><td><input value="my data"></td><td><select class="form-control" name="select-value"><option value="string">String</option><option value="date">Date</option><option value="float">Float</option></select></td></tr>');
		$('.btn-group').slideDown(0);
	});

	$("#add-labor-class-toggler").click(function(e) {
		e.preventDefault();
		$('#class-panel-labor').append('<tr><td><input value="my data"></td><td><select class="form-control" name="select-value"><option value="string">String</option><option value="date">Date</option><option value="float">Float</option></select></td></tr>');
		$('.btn-group').slideDown(0);
	});

	$("#add-labor-subclass-toggler").click(function(e) {
		e.preventDefault();
		$('#subclass-panel-labor').append('<tr><td><input value="my data"></td><td><select class="form-control" name="select-value"><option value="string">String</option><option value="date">Date</option><option value="float">Float</option></select></td></tr>');
		$('.btn-group').slideDown(0);
	});

	$("#rm-general-class-toggler").click(function(e) {
		$('.highlight-general').remove();
		$('.btn-group').slideDown(0);
	});

	$("#rm-general-subclass-toggler").click(function(e) {
		$('.highlight-general').remove();
		$('.btn-group').slideDown(0);
	});

	$("#rm-financial-class-toggler").click(function(e) {
		$('.highlight-financial').remove();
		$('.btn-group').slideDown(0);
	});

	$("#rm-financial-subclass-toggler").click(function(e) {
		$('.highlight-financial').remove();
		$('.btn-group').slideDown(0);
	});

	$("#rm-labor-class-toggler").click(function(e) {
		$('.highlight-labor').remove();
		$('.btn-group').slideDown(0);
	});

	$("#rm-labor-subclass-toggler").click(function(e) {
		$('.highlight-labor').remove();
		$('.btn-group').slideDown(0);
	});

	$('#class-panel-general').on('click', 'tr', function(event) {
		$(this).addClass('highlight-general').siblings().removeClass('highlight-general');
	});

	$('#subclass-panel-general').on('click', 'tr', function(event) {
		$(this).addClass('highlight-general').siblings().removeClass('highlight-general');
	});

	$('#class-panel-financial').on('click', 'tr', function(event) {
		$(this).addClass('highlight-financial').siblings().removeClass('highlight-financial');
	});

	$('#subclass-panel-financial').on('click', 'tr', function(event) {
		$(this).addClass('highlight-financial').siblings().removeClass('highlight-financial');
	});

	$('#class-panel-labor').on('click', 'tr', function(event) {
		$(this).addClass('highlight-labor').siblings().removeClass('highlight-labor');
	});

	$('#subclass-panel-labor').on('click', 'tr', function(event) {
		$(this).addClass('highlight-labor').siblings().removeClass('highlight-labor');
	});
});
