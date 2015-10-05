var lastClicked,
    grid,
    rows,
    cols,
    node_id,
    selected_row = -1,
    select_col = -1,
    tile_prop,
    height;

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

function setHeight(h) {
	height = h;
}

function getHeight() {
	return height;
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

function loadTiles(id) {
	$.ajax({
		type : "POST",
		url : "dc_db_getTiles.php",
		data : "id=" + id,
		success : function(data) {
			for (var i = 0; i < data.length; i++) {
				var table = document.getElementById("table");
				var row = table.rows[data[i].html_row];
				var cell = row.cells[data[i].html_col];
				$(cell).addClass("grayed");
			}
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
				var table = document.getElementById("table");
				var row = table.rows[data[i].html_row];
				var cell = row.cells[data[i].html_col];
				$(cell).html("<img src='img/cabinet-icon.png'>");
				$(cell).css("background-color", data[i].color);
			}
		}
	});
}

function resetSelect() {
	$("#select-ci").html("");
	$(".form-group").hide();
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

					var tileProp = {
						id : getNodeId() + getSelectedRow() + getSelectedCol(),
						x : getXValue(getSelectedCol(), tile_dim),
						y : getYValue(getSelectedRow(), tile_dim),
						label : getLabel(getSelectedRow(), getSelectedCol(), label_rows, label_cols),
						grayed_out : el.className == 'grayed',
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

function getServers(id) {
	$.ajax({
		type : "POST",
		url : "dc_db_getServers.php",
		data : "id=" + id,
		success : function(data) {
			for (var i = 0; i < data.length; i++) {
				var limit = data[i].starting_position + data[i].height;
				var pxHeight = data[i].height * 25;
				$("#rack" + data[i].starting_position).html(data[i].name);
				for (var i = 1; i < data[i].height; i++) {
					$("#rack" + data[i].starting_position).next('.second-row').remove();
					$("#rack" + data[i].starting_position).css("height", pxHeight + "px");
				}
			}
		}
	});
}

function addContextMenu(el) {
	$(el).contextMenu('myMenu1', {
		bindings : {
			'show_ci' : function(t) {
				window.location.href = "ci.php";
			},
			'help' : function(t) {
				alert("To add a server, log in as an administrator.");
			},
		},

		onShowMenu : function(e, menu) {
			resetSelect();
			if ($(e.target)[0].innerText === '') {
				$('#show_ci', menu).remove();
			} else {
				$('#help', menu).remove();
			}
			return menu;
		}
	});
}

$(function() {

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

		"plugins" : ["json_data", "massload", "search", "sort", "state", "themes", "types", "ui", "unique", "wholerow"]

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

	$('#view_cabinet').click(function(e) {
		e.preventDefault();
		if (lastClicked) {
			if (lastClicked.innerHTML != "") {
				$("#grid-controls").hide();
				$("#server-design").show();

				$.ajax({
					type : "POST",
					url : "dc_db_getCabinetColor.php",
					data : "id=" + getTileProperties().id,
					success : function(data) {
						for (var i = 0; i < data.length; i++) {
							$("#racks").css("background-color", data[i].color);
						}
					}
				});

				$(".clickable-div").html("");

				$.ajax({
					type : "POST",
					url : "dc_db_getHeight.php",
					data : "id=" + getTileProperties().id,
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
