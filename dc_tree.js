var lastClicked,
    grid,
    rows,
    cols,
    node_id,
    selected_row = -1,
    select_col = -1,
    tile_prop,
    position;

function setRows(nb_rows) {
	rows = nb_rows;
}

function setColumns(nb_cols) {
	cols = nb_cols;
}

function setNodeId(id) {
	node_id = id;
}

function setSelectedRow(row) {
	selected_row = row;
}

function setSelectedCol(col) {
	selected_col = col;
}

function setTileProperties(prop) {
	tile_prop = prop;
}

function setPosition(p) {
	position = p;
}

function getPosition() {
	return position;
}

function getTileProperties() {
	return tile_prop;
}

function getRows() {
	return rows;
}

function getColumns() {
	return cols;
}

function getNodeId() {
	return node_id;
}

function getSelectedRow() {
	return selected_row;
}

function getSelectedCol() {
	return selected_col;
}

function getXValue(x, dim) {
	return x * dim;
}

function getYValue(y, dim) {
	return y * dim;
}

function getLabel(row, col, labelRows, labelCols) {
	if ($.isNumeric(labelRows)) {
		for (var i = 1; i < row; i++) {
			labelRows++;
		}
	} else {
		for (var i = 1; i < row; i++) {
			labelRows = nextChar(labelRows);
		}

	}

	if ($.isNumeric(labelCols)) {
		for (var i = 0; i < col - 1; i++) {
			labelCols++;
		}
	} else {
		for (var i = 0; i < col - 1; i++) {
			labelCols = nextChar(labelCols);
		}
	}

	return labelRows + '-' + labelCols;
}

function isGrayedOut(el) {
	return el.className == 'grayed';
}

function previousChar(s) {
	return s.replace(/([a-zA-Z])[^a-zA-Z]*$/, function(a) {
		var c = a.charCodeAt(0);
		switch(c) {
		case 65:
			return 'Z';
		case 97:
			return 'z';
		default:
			return String.fromCharCode(--c);
		}
	});
}

function nextChar(s) {
	return s.replace(/([a-zA-Z])[^a-zA-Z]*$/, function(a) {
		var c = a.charCodeAt(0);
		switch(c) {
		case 90:
			return 'AA';
		case 122:
			return 'aa';
		default:
			return String.fromCharCode(++c);
		}
	});
}

function clickableGrid(rows, cols, labelRows, labelCols, callback) {
	var i = "";
	var grid = document.createElement('table');
	grid.className = 'grid';
	grid.id = 'table';

	for (var r = 0; r < rows + 1; ++r) {
		var tr = grid.appendChild(document.createElement('tr'));

		for (var c = 0; c < 1; ++c) {
			var xCell = tr.appendChild(document.createElement('td'));
			if (r != 0) {
				if ($.isNumeric(labelRows)) {
					xCell.innerHTML = labelRows - 1;
				} else {
					xCell.innerHTML = previousChar(labelRows);
				}
			}
		}

		for (var c = 1; c < cols + 1; ++c) {
			if (r == 0) {
				var yCell = tr.appendChild(document.createElement('td'));
				yCell.innerHTML = labelCols;
			} else {
				var cell = tr.appendChild(document.createElement('td'));
				cell.addEventListener('click', (function(el, r, c, i) {
					return function() {
						callback(el, r, c, i);
					};
				})(cell, r, c, i), false);
			}

			if ($.isNumeric(labelCols)) {
				labelCols++;
			} else {
				labelCols = nextChar(labelCols);
			}
		}

		if ($.isNumeric(labelRows)) {
			labelRows++;
		} else {
			labelRows = nextChar(labelRows);
		}
	}
	return grid;
}

function colName(n) {
	var ordA = 'a'.charCodeAt(0);
	var ordZ = 'z'.charCodeAt(0);
	var len = ordZ - ordA + 1;

	var s = "";
	while (n >= 0) {
		s = String.fromCharCode(n % len + ordA) + s;
		n = Math.floor(n / len) - 1;
	}
	return s;
}

function grayOutCell(x, y) {
	var table = document.getElementById("table");
	var row = table.rows[x];
	var cell = row.cells[y];
	$(cell).addClass("grayed");
}

function deleteTile(id) {
	$.ajax({
		type : "POST",
		url : "dc_db_deleteTile.php",
		data : "id=" + id,
		success : function(data) {
			var table = document.getElementById("table");
			var row,
			    cell;
			for (var i = 0; i < data.length; i++) {
				row = table.rows[data[i].html_row];
				cell = row.cells[data[i].html_col];
				$(cell).html("");
				$(cell).css("background-color", "#FFFFFF");
			}
		}
	});
}

function addCabinet(x, y, color) {
	var table = document.getElementById("table");
	var row = table.rows[x];
	var cell = row.cells[y];
	$(cell).html("<img src='img/cabinet-icon.png'>");
	$(cell).css("background-color", color);
}

function addRow(id) {
	$.ajax({
		type : "POST",
		url : "dc_db_addRow.php",
		data : "id=" + id,
		success : function() {
			location.reload();
		}
	});
}

function addColumn(id) {
	$.ajax({
		type : "POST",
		url : "dc_db_addColumn.php",
		data : "id=" + id,
		success : function() {
			location.reload();
		}
	});
}

function removeRow(id) {
	$.ajax({
		type : "POST",
		url : "dc_db_rmRow.php",
		data : "id=" + id,
		success : function() {
			location.reload();
		}
	});
}

function removeColumn(id) {
	$.ajax({
		type : "POST",
		url : "dc_db_rmColumn.php",
		data : "id=" + id,
		success : function() {
			location.reload();
		}
	});
}

function createDataCenter(data) {
	$.ajax({
		type : "POST",
		url : "dc_db_createDataCenter.php",
		data : data,
		success : function(data) {
			console.log(data);
			$("#tree").jstree("refresh");
		}
	});
}

function createTile(id, x, y, label, grayed_out, html_row, html_col, data_center_id) {
	$.ajax({
		type : "POST",
		url : "dc_db_createTile.php",
		data : "id=" + id + "&x=" + x + "&y=" + y + "&label=" + label + "&grayed_out=" + grayed_out + "&html_row=" + html_row + "&html_col=" + html_col + "&data_center_id=" + data_center_id,
		success : function() {
			console.log("tile created: " + x + " " + y);
		}
	});
}

function loadTiles(id) {
	$.ajax({
		type : "POST",
		url : "dc_db_getTiles.php",
		data : "id=" + id,
		success : function(data) {
			for (var i = 0; i < data.length; i++) {
				grayOutCell(data[i].html_row, data[i].html_col);
			}
		}
	});
}

function createCabinet(data, tile_id) {
	$.ajax({
		type : "POST",
		url : "dc_db_createCabinet.php",
		data : data + "&tile_id=" + tile_id,
		success : function(data) {
			for (var i = 0; i < data.length; i++) {
				addCabinet(getSelectedRow(), getSelectedCol(), data[i].color);
			}
			$("#tree").jstree("refresh");
			$("#cabinet-form").hide();
		}
	});
}

function loadCabinets(id) {
	$.ajax({
		type : "POST",
		url : "dc_db_getCabinets.php",
		data : "id=" + id,
		success : function(data) {
			for (var i = 0; i < data.length; i++) {
				addCabinet(data[i].html_row, data[i].html_col, data[i].color);
			}
		}
	});
}

function resetSelect() {
	$("#select-ci").html("");
	$(".form-group").hide();
}

function loadConfigItems() {
	$.ajax({
		type : "POST",
		url : "db_loadConfigItems.php",
		success : function(data) {
			for (var i = 0; i < data.length; i++) {
				$("#select-ci").append($('<option>', {
					value : data[i].id,
					text : data[i].name
				}));
			}
		}
	});
}

function map2Cabinet(data, position, cabinet_id) {
	$.ajax({
		type : "POST",
		url : "dc_db_map2Cabinet.php",
		data : data + "&position=" + position + "&cabinet_id=" + cabinet_id,
		success : function() {
			$("#"+position).html("success");
		}
	});
}

function customMenu($node) {
	var tree = $("#tree").jstree(true);
	var items = {
		"createfile" : {
			"separator_before" : false,
			"separator_after" : false,
			"label" : "New data center",
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
		delete items.remove;
		delete items.rename;
	}

	if ($node.type === 'file') {
		delete items.createfile;
	}

	return items;
}

function buildGrid(id) {
	var label_rows;
	var label_cols;
	var tile_dim;
	var grayed_out;

	$.ajax({
		type : "POST",
		url : "dc_db_getDataCenterProperties.php",
		data : "id=" + id,
		success : function(data) {
			for (var i = 0; i < data.length; i++) {
				setRows(data[i].count_rows);
				setColumns(data[i].count_columns);
				label_rows = data[i].label_rows;
				label_cols = data[i].label_columns;
				tile_dim = data[i].tile_dim;

				grid = clickableGrid(getRows(), getColumns(), data[i].label_rows, data[i].label_columns, function(el, row, col) {
					setSelectedRow(row);
					setSelectedCol(col);
					$(el).addClass("clicked");
					if (lastClicked) {
						$(lastClicked).removeClass("clicked");
					}
					lastClicked = el;

					console.log("id: ", getNodeId() + getSelectedRow() + getSelectedCol());
					console.log("x: ", getXValue(getSelectedCol(), tile_dim));
					console.log("y: ", getYValue(getSelectedRow(), tile_dim));
					console.log("html_row: ", getSelectedRow());
					console.log("html_col: ", getSelectedCol());
					console.log("label_rows: ", label_rows);
					console.log("label_cols: ", label_cols);
					console.log("label: ", getLabel(getSelectedRow(), getSelectedCol(), label_rows, label_cols));
					console.log("grayed_out: ", isGrayedOut(el));
					console.log("data_center_id: ", getNodeId());

					var tileProp = {
						id : getNodeId() + getSelectedRow() + getSelectedCol(),
						x : getXValue(getSelectedCol(), tile_dim),
						y : getYValue(getSelectedRow(), tile_dim),
						label : getLabel(getSelectedRow(), getSelectedCol(), label_rows, label_cols),
						grayed_out : isGrayedOut(el),
						html_row : getSelectedRow(),
						html_col : getSelectedCol(),
						data_center_id : getNodeId()
					};
					setTileProperties(tileProp);
				});
				$('#mygraph').html(grid);
				loadTiles(getNodeId());
				loadCabinets(getNodeId());
			}
		}
	});
}

$(function() {
	$("#tree").jstree({

		"core" : {
			"check_callback" : function(operation, node) {
				if (operation === 'delete_node') {
					return confirm("Are you sure you want to delete this node?");
				}
			},
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
			}
		},

		"contextmenu" : {
			"items" : customMenu
		},

		"plugins" : ["contextmenu", "json_data", "massload", "search", "sort", "state", "themes", "types", "ui", "unique", "wholerow"]

	}).on('rename_node.jstree', function(e, data) {
		$.ajax({
			type : "POST",
			url : "dc_db_renameDataCenter.php",
			data : "name=" + data.text + "&id=" + data.node.id,
			success : function() {
				$("#tree").jstree("refresh");
			}
		});

	}).on('delete_node.jstree', function(e, data) {
		$.ajax({
			type : "POST",
			url : "dc_db_deleteDataCenter.php",
			data : "id=" + data.node.id,
			success : function(data) {
				location.reload();
			}
		});

	}).on('create_node.jstree', function(e, data) {
		$("#grid-form").show();

	}).on('select_node.jstree', function(e, data) {
		setNodeId(data.node.id);
		$("#grid-form").hide();
		$('#server-design').hide();
		resetSelect();

		if (data.node.type == "file") {
			$('#grid-controls').show();
			buildGrid(getNodeId());
		} else {
			$('#grid-controls').hide();
		}
	});

	$("#form1").on('submit', function(event) {
		event.preventDefault();
		var form_data = $(this).serialize();
		if ($(".error").is(":visible")) {
			$("#alert1").show();
		} else {
			$("#alert1").hide();
			createDataCenter(form_data);
		}
	});

	$("#form2").on('submit', function(event) {
		event.preventDefault();
		var form_data = $(this).serialize();
		if ($(".error").is(":visible")) {
			alert("There are errors on this page!");
		} else {
			createTile(tile_prop.id, tile_prop.x, tile_prop.y, tile_prop.label, tile_prop.grayed_out, tile_prop.html_row, tile_prop.html_col, tile_prop.data_center_id);
			createCabinet(form_data, tile_prop.id);
		}
	});

	$("#form3").on('submit', function(event) {
		event.preventDefault();
		var form_data = $(this).serialize();
		map2Cabinet(form_data, getPosition(), tile_prop.id);
	});

	$('#name').on('input', function() {
		var input = $(this);
		var is_valid = input.val();
		if (is_valid) {
			$("#error-name").hide();
		} else {
			$("#error-name").show();
		}
	});

	$('#count_rows').on('input', function() {
		var input = $(this);
		var is_valid = input.val();
		if (is_valid) {
			$("#error-count_rows").hide();
		} else {
			$("#error-count_rows").show();
		}
	});

	$('#count_columns').on('input', function() {
		var input = $(this);
		var is_valid = input.val();
		if (is_valid) {
			$("#error-count_columns").hide();
		} else {
			$("#error-count_columns").show();
		}
	});

	$('#label_rows').on('input', function() {
		var input = $(this);
		var is_valid = input.val();
		if (is_valid) {
			$("#error-label_rows").hide();
		} else {
			$("#error-label_rows").show();
		}
	});

	$('#label_columns').on('input', function() {
		var input = $(this);
		var is_valid = input.val();
		if (is_valid) {
			$("#error-label_columns").hide();
		} else {
			$("#error-label_columns").show();
		}
	});

	$('#tile_dim').on('input', function() {
		var input = $(this);
		var is_valid = input.val();
		if (is_valid) {
			$("#error-tile_dim").hide();
		} else {
			$("#error-tile_dim").show();
		}
	});

	$('#height').on('input', function() {
		var input = $(this);
		var is_valid = input.val();
		if (is_valid > 0) {
			$("#error-height").hide();
		} else {
			$("#error-height").show();
		}
	});

	$('#width').on('input', function() {
		var input = $(this);
		var is_valid = input.val();
		if (is_valid > 0) {
			$("#error-width").hide();
		} else {
			$("#error-width").show();
		}
	});

	$("#create-dc-cancel").click(function(e) {
		e.preventDefault();
		$("#grid-form").hide();
		$("#tree").jstree("refresh");
	});

	$("#create-cabinet-cancel").click(function(e) {
		e.preventDefault();
		$("#cabinet-form").hide();
	});

	$("#cancel-select-ci").click(function(e) {
		e.preventDefault();
		resetSelect();
	});

	$("#gray-out").click(function(e) {
		e.preventDefault();
		if (lastClicked) {
			if (lastClicked.innerHTML == "") {
				if (!isGrayedOut(lastClicked)) {
					grayOutCell(tile_prop.html_row, tile_prop.html_col);
					createTile(tile_prop.id, tile_prop.x, tile_prop.y, tile_prop.label, 1, tile_prop.html_row, tile_prop.html_col, tile_prop.data_center_id);
				} else {
					alert("The cell is already grayed out!");
				}
			} else {
				alert("There is a cabinet in this cell!");
			}
		} else {
			alert("Please select a cell!");
		}
	});

	$('#activate').click(function(e) {
		e.preventDefault();
		if (lastClicked) {
			if (isGrayedOut(lastClicked)) {
				deleteTile(tile_prop.id);
			} else {
				alert("The cell is already activated!");
			}
		} else {
			alert("Please select a cell!");
		}
	});

	$('#addCabinet').click(function(e) {
		e.preventDefault();
		if (lastClicked) {
			if (lastClicked.innerHTML == "") {
				if (lastClicked.className.indexOf("grayed") == -1) {
					$("#cabinet-form").show();
				} else {
					alert("You cannot add a cabinet to this cell!");
				}
			} else {
				alert("There is already a cabinet in this cell!");
			}
		} else {
			alert("Please select a cell!");
		}
	});

	$('#rmCabinet').click(function(e) {
		e.preventDefault();
		if (lastClicked) {
			if (lastClicked.innerHTML != "") {
				if (confirm("Are you sure you want to delete this cabinet?")) {
					deleteTile(tile_prop.id);
				}
			} else {
				alert("There is no cabinet on this cell!");
			}
		} else {
			alert("Please select a cabinet to remove!");
		}
	});

	$('#3d').click(function(e) {
		e.preventDefault();
		if (lastClicked) {
			if (lastClicked.innerHTML != "") {
				$("#grid-controls").hide();
				$("#server-design").show();
			} else {
				alert("There is no cabinet on this cell!");
			}
		} else {
			alert("Please select a cabinet!");
		}
	});

	$('#addRow').click(function(e) {
		e.preventDefault();
		addRow(getNodeId());
	});

	$('#addCol').click(function(e) {
		e.preventDefault();
		addColumn(getNodeId());
	});

	$('#rmRow').click(function(e) {
		e.preventDefault();
		if (getRows() > 1) {
			if (confirm("The last row will be deleted. Continue?")) {
				removeRow(getNodeId());
			}
		} else {
			alert("You cannot remove the last row!");
		}
	});

	$('#rmCol').click(function(e) {
		e.preventDefault();
		if (getColumns() > 1) {
			if (confirm("The last column will be deleted. Continue?")) {
				removeColumn(getNodeId());
			}
		} else {
			alert("You cannot remove the last column!");
		}
	});

	$('#back-view').click(function(e) {
		e.preventDefault();
		$('#server-design').hide();
		$('#grid-controls').show();
		resetSelect();
	});

	$('.clickable-div').contextMenu('myMenu1', {
		bindings : {
			'add_ci' : function(t) {
				loadConfigItems();
				$(".form-group").show();
				setPosition(t.id);
			},
			'show_ci' : function(t) {
				alert('Trigger was ' + t.id + '\nAction was show_ci');
				setPosition(t.id);
			},
			'rm_ci' : function(t) {
				alert('Trigger was ' + t.id + '\nAction was rm_ci');
				setPosition(t.id);
			},
		},

		onShowMenu : function(e, menu) {
			resetSelect();
			if ($(e.target)[0].innerText === '') {
				$('#show_ci', menu).remove();
				$('#rm_ci', menu).remove();
			} else {
				$('#add_ci', menu).remove();
			}
			return menu;
		}
	});
});
