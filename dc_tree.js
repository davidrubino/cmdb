var lastClicked,
    grid,
    rows,
    cols,
    node_id,
    selected_row = -1,
    select_col = -1;

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

function previousChar(c) {
	return String.fromCharCode(c.charCodeAt(0) - 1);
}

function nextChar(c) {
	return String.fromCharCode(c.charCodeAt(0) + 1);
}

function clickableGrid(rows, cols, labelRows, labelCols, callback) {
	var i = "";
	var grid = document.createElement('table');
	grid.className = 'grid';

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
				if ($.isNumeric(labelCols)) {
					yCell.innerHTML = labelCols;
				} else {
					yCell.innerHTML = labelCols;
				}
			} else {
				var cell = tr.appendChild(document.createElement('td'));
				cell.innerHTML = i;
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

function grayOutCell(el) {
	if (el.innerHTML == "") {
		$(el).addClass("grayed");
	}
}

function activateCell(el) {
	$(el).removeClass("grayed");
}

function addCabinet(cell) {
	if (cell.className.indexOf("grayed") == -1) {
		$(cell).html("C");
	}
}

function removeCabinet(cell) {
	$(cell).html("");
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
		success : function() {
			location.reload();
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
	$.ajax({
		type : "POST",
		url : "dc_db_getDataCenterProperties.php",
		data : "id=" + id,
		success : function(data) {
			for (var i = 0; i < data.length; i++) {
				setRows(data[i].count_rows);
				setColumns(data[i].count_columns);
				grid = clickableGrid(getRows(), getColumns(), data[i].label_rows, data[i].label_columns, function(el, row, col, i) {
					i = el.innerHTML;
					setSelectedRow(row);
					setSelectedCol(col);
					$(el).addClass("clicked");

					if (el.className != 'grayed') {
						currentCell = el;
						if (lastClicked) {
							if (lastClicked.className != 'grayed') {
								$(lastClicked).removeClass("clicked");
							}
						}
						lastClicked = el;
					}

					console.log("You clicked on element:", el);
					console.log("You clicked on row:", getSelectedRow());
					console.log("You clicked on col:", getSelectedCol());
					console.log("You clicked on item #:", i);
				});
				$('#mygraph').html(grid);
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
		});
		$("#tree").jstree("refresh");

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
		if (data.node.type == "file") {
			$('#grid-controls').show();
			buildGrid(getNodeId());
		} else {
			$('#grid-controls').hide();
		}
	});

	$(".property-form").on('submit', function(event) {
		event.preventDefault();
		var form_data = $(this).serialize();
		if ($(".error").is(":visible")) {
			alert("There are errors on this page!");
		} else {
			createDataCenter(form_data);
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

	$(".btn-default").click(function(e) {
		e.preventDefault();
		document.location.href = 'dc.php';
	});

	$("#gray-out").click(function(e) {
		e.preventDefault();
		grayOutCell(lastClicked);
	});

	$('#activate').click(function(e) {
		e.preventDefault();
		activateCell(lastClicked);
	});

	$('#addCabinet').click(function(e) {
		e.preventDefault();
		addCabinet(lastClicked);
	});

	$('#rmCabinet').click(function(e) {
		e.preventDefault();
		removeCabinet(lastClicked);
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
});
