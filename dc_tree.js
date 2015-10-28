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
 * @param {Int} nb_rows: the desired number of rows
 */
function setRows(nb_rows) {
	rows = nb_rows;
}

/**
 * set the number of columns in the grid
 * @param {Int} nb_cols: the desired number of columns
 */
function setColumns(nb_cols) {
	cols = nb_cols;
}

/**
 * set the id of the selected node in the tree
 * @param {Int} id: the node id
 */
function setNodeId(id) {
	node_id = id;
}

/**
 * set the number of the selected row in the grid
 * @param {Int} row: the row of the currently selected cell
 */
function setSelectedRow(row) {
	selected_row = row;
}

/**
 * set the number of the selected column in the grid
 * @param {Int} col: the column of the currently selected cell
 */
function setSelectedCol(col) {
	selected_col = col;
}

/**
 * set the various properties of the selected tile
 * @param {Object} prop: an object representing all the properties of the tile
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
 * @param {Int} p: the position of the server (int)
 */
function setPosition(p) {
	position = p;
}

/**
 * set the height of a cabinet
 * @param {Int} h: the height of the cabinet (int)
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
 * return the x value for the selected tile in the grid
 * @param {Int} x: the html x value of the tile
 * @param {Int} dim: the dimension of the tile
 */
function getXValue(x, dim) {
	return x * dim;
}

/**
 * return the y value for the selected tile in the grid
 * @param {Int} y: the html y value of the tile
 * @param {Int} dim: the dimension of the tile
 */
function getYValue(y, dim) {
	return y * dim;
}

/**
 * returns the label of a tile
 * @param {Int} row: the row id of the tile
 * @param {Int} col: the column id of the tile
 * @param {String} labelRows: the first id of the rows in the grid
 * @param {String} labelCols: the first column id of the rows in the grid
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
 * @param {String} s: the current letter
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
 * @param {String} s: the current letter
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
 * @param {Int} rows: the number of rows in the grid
 * @param {Int} cols: the number of columns in the grid
 * @param {String} labelRows: the label of the first row in the grid
 * @param {String} labelCols: the label of the first column in the grid
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
 * @param {Int} n: the number to convert into a letter
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
 * @param {Int} x: the cell abscissa
 * @param {Int} y: the cell ordinate
 */
function grayOutCell(x, y) {
	var table = document.getElementById("table");
	var row = table.rows[x];
	var cell = row.cells[y];
	$(cell).addClass("grayed");
}

/**
 * add graphically a cabinet on the grid
 * @param {Int} x: the tile abscissa containing the cabinet
 * @param {Int} y: the tile ordinate containing the cabinet
 * @param {String} color: the tile background color
 */
function addCabinet(x, y, color) {
	var table = document.getElementById("table");
	var row = table.rows[x];
	var cell = row.cells[y];
	$(cell).html("<img src='img/cabinet-icon.png'>");
	$(cell).css("background-color", color);
}

/**
 * load a tile on the data center grid
 * @param {Int} id: id of the data center
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
 * load the cabinet from the database on the grid
 * @param {Int} id: id of the data center including the grid
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
}

/**
 * add the name of the server in the cabinet at a specific position
 * @param {Int} position: the starting position for which the server will be added
 * @param {String} name: the server name
 * @param {Int} height: the server height
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
 * @param {Int} id: the id of the cabinet
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
 * build the grid of a data center from the database properties
 * @param {Int} id: the data center id related to the grid
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
 * @param {Int} id: the cabinet id
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
 * @param {Int} id: the id of the cabinet
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
			var h = $("#racks-container").css("height");
			$("#img-container").height(h);
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
			'show_app' : function(t) {
				setPosition(t.id);
				var ci_name = document.getElementById(getPosition()).innerHTML;
				$.ajax({
					type : "POST",
					url : "dc_db_getPopupContent.php",
					data : "name=" + ci_name,
					success : function(data) {
						var chain = "";
						for (var i = 0; i < data.length; i++) {
							for (var j = data[i].parents.length - 1; j >= 0; j--) {
								chain += '<img class="pop-img" src="img/folder-icon.png">' + data[i].parents[j].name;
							}
							chain += '<img class="pop-img" src="img/file-icon.png"><a href="app_admin.php">' + data[i].application + '</a>';
							chain += '<br>';
						}
						$("#dialog").html(chain);
						$("#dialog").dialog("open");
					}
				});
			},

			'show_ci' : function(t) {
				setPosition(t.id);
				$("#tree").jstree("deselect_all");
				$('#tree').jstree('select_node', 3);
				window.location.href = "ci_admin.php";
			},

			'help' : function(t) {
				setPosition(t.id);
				alert("To add a server, log in as an administrator.");
			},
		},

		onShowMenu : function(e, menu) {
			resetSelect();
			if ($(e.target)[0].innerText === '') {
				$('#show_app', menu).remove();
				$('#show_ci', menu).remove();
			} else {
				$('#help', menu).remove();
			}
			return menu;
		}
	});
}

$(function() {

	$("#dialog").dialog({
		autoOpen : false,
		width : 500
	});

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
			},
			"multiple" : false
		},

		"types" : {
			"file" : {
				"icon" : "img/file-icon.png",
				"valid_children" : []
			}
		},

		"ui" : {
			"select_limit" : 1,
			"selected_parent_close" : false
		},

		"plugins" : ["json_data", "massload", "search", "sort", "state", "themes", "types", "ui", "unique", "wholerow"]

	}).on('select_node.jstree', function(e, data) {
		setNodeId(data.node.id);
		$('#server-design').hide();
		resetSelect();

		if (data.node.type == "file") {
			$('#grid-controls').show();
			buildGrid(getNodeId());
		} else {
			$('#grid-controls').hide();
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

	$('#back-view').click(function(e) {
		e.preventDefault();
		$('#server-design').hide();
		$('#grid-controls').show();
		resetSelect();
	});

});
