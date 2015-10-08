var lastClicked,
    grid,
    rows,
    cols,
    node_id,
    selected_row = -1,
    select_col = -1,
    tile_prop,
    position,
    height;

/**
 * set the number of rows in the grid
 * @param {Object} nb_rows: the desired number of rows
 */
function setRows(nb_rows) {
	rows = nb_rows;
}

/**
 * set the number of columns in the grid
 * @param {Object} nb_cols: the desired number of columns
 */
function setColumns(nb_cols) {
	cols = nb_cols;
}

/**
 * set the id of the selected node in the tree
 * @param {Object} id: the node id
 */
function setNodeId(id) {
	node_id = id;
}

/**
 * set the number of the selected row in the grid
 * @param {Object} row: the row of the currently selected cell
 */
function setSelectedRow(row) {
	selected_row = row;
}

/**
 * set the number of the selected column in the grid
 * @param {Object} col: the column of the currently selected cell
 */
function setSelectedCol(col) {
	selected_col = col;
}

/**
 * set the various properties of the selected tile
 * @param {Object} prop: an object including all the properties
 * 	id: the tile id
 * 	x: the x coordinate of the tile
 * 	y: the y coordinate of the tile
 * 	label: the tile label according to its position in the grid
 * 	grayed_out: 1 if grayed-out, 0 otherwise
 * 	html_row: the row number accoridng to the html grid
 * 	html_col: the column number according to the html grid
 * 	data_center_id: the id referencing the tile to its data center
 */
function setTileProperties(prop) {
	tile_prop = prop;
}

/**
 * set the position of a server in the cabinet view
 * @param {Object} p: the position of the server (int)
 */
function setPosition(p) {
	position = p;
}

/**
 * set the height of a cabinet
 * @param {Object} h: the height of the cabinet (int)
 */
function setHeight(h) {
	height = h;
}

/**
 * return the height of the cabinet
 */
function getHeight() {
	return height;
}

/**
 * return the position of the server in the cabinet
 */
function getPosition() {
	return position;
}

/**
 * return all the properties of the selected tile
 */
function getTileProperties() {
	return tile_prop;
}

/**
 * return the number of rows in the grid
 */
function getRows() {
	return rows;
}

/**
 * return the number of columns in the grid
 */
function getColumns() {
	return cols;
}

/**
 * return the id of the selected node in the tree
 */
function getNodeId() {
	return node_id;
}

/**
 * return the row of the selected cell in the grid
 */
function getSelectedRow() {
	return selected_row;
}

/**
 * return the column of the selected cell in the grid
 */
function getSelectedCol() {
	return selected_col;
}

/**
 * return the x value of the selected tile in the grid
 * @param {Object} x: the html x value of the tile
 * @param {Object} dim: the dimension of the tile
 */
function getXValue(x, dim) {
	return x * dim;
}

/**
 * return the y value f the selected tile in the grid
 * @param {Object} y: the html y value of the tile
 * @param {Object} dim: the dimension of the tile
 */
function getYValue(y, dim) {
	return y * dim;
}

/**
 * returns the label of a tile
 * @param {Object} row: the row id of the tile
 * @param {Object} col: the column id of the tile
 * @param {Object} labelRows: the first id of the rows in the grid
 * @param {Object} labelCols: the first column id of the rows in the grid
 */
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

/**
 * return true if the cell is grayed out
 * @param {Object} el: the cell
 */
function isGrayedOut(el) {
	return el.className == 'grayed';
}

/**
 * return the previous char of the current letter
 * @param {Object} s: the current letter
 */
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

/**
 * return the next char of the current letter
 * @param {Object} s: the current letter
 */
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

/**
 * creates the clickable grid for a data center
 * @param {Object} rows: the number of rows in the grid
 * @param {Object} cols: the number of columns in the grid
 * @param {Object} labelRows: the label of the first row in the grid
 * @param {Object} labelCols: the label of the first column in the grid
 * @param {Object} callback: the callback function
 */
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

/**
 * return the equivalent letter for a specified number.
 * This function is used to create the column names with letters
 * @param {Object} n: the number to convert into a letter
 */
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

/**
 * change the background color of a defined cell to gray
 * @param {Object} x: the cell abscissa
 * @param {Object} y: the cell ordinate
 */
function grayOutCell(x, y) {
	var table = document.getElementById("table");
	var row = table.rows[x];
	var cell = row.cells[y];
	$(cell).addClass("grayed");
}

/**
 * delete a tile
 * @param {Object} id: id of the tile to delete
 */
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

/**
 * add graphically a cabinet on the grid
 * @param {Object} x: the tile abscissa containing the cabinet
 * @param {Object} y: the tile ordinate containing the cabinet
 * @param {Object} color: the tile background color
 */
function addCabinet(x, y, color) {
	var table = document.getElementById("table");
	var row = table.rows[x];
	var cell = row.cells[y];
	$(cell).html("<img src='img/cabinet-icon.png'>");
	$(cell).css("background-color", color);
}

/**
 * add another row to the grid of a data center
 * @param {Object} id: id of the data center in which the row will be added
 */
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

/**
 * add another column to the grid of  data center
 * @param {Object} id: id of the data center in which the column will be added
 */
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

/**
 * remove the last row from the grid of a data center
 * @param {Object} id: id of the data center
 */
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

/**
 * remove the last column from the grid of a data center
 * @param {Object} id: id of the data center
 */
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

/**
 * creates the data center in the database
 * @param {Object} data: the form data sent by the user
 */
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

/**
 * creates a tile for a data center
 * The function is called only when another item (grayed cell, cabinet) is added on the tile
 * @param {Object} id: tile id
 * @param {Object} x: tile abscissa
 * @param {Object} y: tile ordinate
 * @param {Object} label: tile label using the row and column labels
 * @param {Object} grayed_out: 1 is the cell is grayed out, 0 otherwise
 * @param {Object} html_row: row on the html grid
 * @param {Object} html_col: column on the html grid
 * @param {Object} data_center_id: references the data center corresponding to the grid
 */
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

/**
 * load a tile on the data center grid
 * @param {Object} id: id of the data center
 */
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

/**
 * create the cabinet in the database
 * @param {Object} data: data from the form sent by the user
 * @param {Object} tile_id: id of the tile including the cabinet
 */
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

/**
 * load the cabinet from the database on the grid
 * @param {Object} id: id of the data center including the grid
 */
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

/**
 * reset the different selections when the tile is no longer on focus
 * It hides the menu allowing the user to choose a server to add in a cabinet.
 * It resets the html of the menu field where the configuration item are displayed.
 */
function resetSelect() {
	$("#select-ci").html("");
	$(".form-group").hide();
}

/**
 * add the name of the server in the cabinet at a specific position
 * @param {Object} position: the reference of the cell in which the name will be added
 * @param {Object} name: the name of the server to be added
 */
function addServer(position, name, height) {
	var limit = position + height;
	var pxHeight = height * 25;
	$("#rack" + position).html(name);
	for (var i = 1; i < height; i++) {
		$("#rack" + position).next('.second-row').remove();
		$("#rack" + position).css("height", pxHeight + "px");
	}
}

/**
 * reset the racks fields for a cabinet
 */
function resetFields() {
	$(".clickable-div").html("");
}

/**
 * retrieve the color for a cabinet, and then change its background color
 * @param {Object} id: the id of the cabinet
 */
function getCabinetColor(id) {
	$.ajax({
		type : "POST",
		url : "dc_db_getCabinetColor.php",
		data : "id=" + id,
		success : function(data) {
			for (var i = 0; i < data.length; i++) {
				$("#racks").css("background-color", data[i].color);
			}
		}
	});
}

/**
 * create a custom menu for the tree
 * @param {Object} $node: callback parameter representing a node on the tree
 */
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

/**
 * build the grid of a data center from the database properties
 * @param {Object} id: the data center id related to the grid
 */
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

/**
 * return the list of servers for a specified cabinet
 * @param {Object} id: the cabinet id
 */
function getServers(id) {
	$.ajax({
		type : "POST",
		url : "dc_db_getServers.php",
		data : "id=" + id,
		success : function(data) {
			for (var i = 0; i < data.length; i++) {
				addServer(data[i].starting_position, data[i].name, data[i].height);
			}
		}
	});
}

/**
 * retrieve the height of the current cabinet, and then
 * insert the correct amount of racks into the cabinet
 * @param {Object} id: the id of the cabinet
 */
function buildRacks(id) {
	$.ajax({
		type : "POST",
		url : "dc_db_getHeight.php",
		data : "id=" + id,
		success : function(data) {
			var htmlResult = new Array();
			for (var j = 0; j < data.length; j++) {
				setHeight(data[j].height);
				for (var i = 0; i < data[j].height; i++) {
					var el = $('<div class="clickable-div second-row" id="rack' + i + '"></div>');
					htmlResult.push(el);
					addContextMenu(el);
				}
				getServers(data[j].id);
				$("#racks").html(htmlResult);
			}
		}
	});
}

/**
 * create the context menu for the racks and bind them with to a function
 * @param {Object} el: the element on which the context menu will be bound
 */
function addContextMenu(el) {
	$(el).contextMenu('myMenu1', {
		bindings : {
			'add_ci' : function(t) {
				setPosition(t.id);
				$.ajax({
					type : "POST",
					url : "dc_db_loadConfigItems.php",
					success : function(data) {
						if (data.length != 0) {
							for (var i = 0; i < data.length; i++) {
								$("#select-ci").append($('<option>', {
									value : data[i].id,
									text : data[i].name
								}));
							}
							$(".form-group").show();
						} else {
							alert("All configuration items are already assigned to a cabinet.");
						}
					}
				});
			},

			'show_ci' : function(t) {
				setPosition(t.id);
				console.log(t.id);
				$("#tree").jstree("deselect_all");
				$('#tree').jstree('select_node', 2);
				window.location.href = "ci_admin.php?id=1000";
			},

			'rm_ci' : function(t) {
				setPosition(t.id);
				if (confirm("Are you sure you want to remove this server from the cabinet?")) {
					var pos = parseInt(getPosition().substring(4));
					var incr = pos + 1;
					$.ajax({
						type : "POST",
						url : "dc_db_deleteServer.php",
						data : "position=" + pos + "&id=" + getTileProperties().id,
						success : function(data) {
							$("#" + getPosition()).html("");
							$("#" + getPosition()).css("height", "25px");
							for (var i = 0; i < data.length; i++) {
								for (var j = 0; j < data[i].height - 1; j++) {
									$("#rack" + pos).after('<div class="clickable-div second-row" id="rack' + incr + '"></div>');
									pos++;
									incr++;
								}
							}
						}
					});
				}
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
}

$(function() {

	$("#tree").jstree({

		"contextmenu" : {
			"items" : customMenu
		},

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
			},
			"multiple" : false
		},

		"types" : {
			"file" : {
				"icon" : "img/file-icon.png",
				"valid_children" : []
			}
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
		$('#cabinet-form').hide();
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

		if ($(".error").is(":visible")) {
			alert("There are errors on this page!");
		} else {

			if (form_data.indexOf("selectionField") != -1) {

				var pos = parseInt(getPosition().substring(4));
				var height = parseInt($("#item-height").val()); //height of the server
				var bool = true;
				var cabinet_height = getHeight(); // height of the cabinet
				var adjusted_pos = pos + height;

				if (adjusted_pos <= cabinet_height) {
					for (var i = pos; i < adjusted_pos; i++) {
						if ($("#rack" + i).html() != "") {
							bool = false;
						}
					}

					if (bool) {
						$.ajax({
							type : "POST",
							url : "dc_db_map2Cabinet.php",
							data : form_data + "&position=" + pos + "&cabinet_id=" + tile_prop.id,
							success : function(data) {
								$(".form-group").hide();
								for (var i = 0; i < data.length; i++) {
									addServer(pos, data[i].name, height);
								}
							}
						});

					} else {
						alert("Adjacent element! Please reduce the height.");
					}

				} else {
					alert("The server does not fit! Please reduce the height.");
				}

			} else {
				alert("Please select a server!");
			}
		}
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

	$('#item-height').on('input', function() {
		var input = $(this);
		var is_valid = input.val();
		if (is_valid > 0) {
			$("#error-item-height").hide();
		} else {
			$("#error-item-height").show();
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

	$('#view_cabinet').click(function(e) {
		e.preventDefault();
		if (lastClicked) {
			if (lastClicked.innerHTML != "") {
				$("#grid-controls").hide();
				$("#server-design").show();
				getCabinetColor(getTileProperties().id);
				resetFields();
				buildRacks(getTileProperties().id);
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

});
