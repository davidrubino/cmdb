var countRows,
    countCols;

function clickableGrid(rows, cols, callback) {
	var i = "";
	countRows = rows;
	countCols = cols;
	var grid = document.createElement('table');
	grid.className = 'grid';

	for (var r = 0; r < rows + 1; ++r) {
		var tr = grid.appendChild(document.createElement('tr'));

		for (var c = 0; c < 1; ++c) {
			var numberCell = tr.appendChild(document.createElement('td'));
			if (r != 0) {
				numberCell.innerHTML = r;
			}
		}

		for (var c = 1; c < cols + 1; ++c) {
			if (r == 0) {
				var letterCell = tr.appendChild(document.createElement('td'));
				letterCell.innerHTML = colName(c - 1);
			} else {
				var cell = tr.appendChild(document.createElement('td'));
				cell.innerHTML = i;
				cell.addEventListener('click', (function(el, r, c, i) {
					return function() {
						callback(el, r, c, i);
					};
				})(cell, r, c, i), false);
			}
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

function addDataCenter(cell) {
	if (cell.className.indexOf("grayed") == -1) {
		$(cell).html("DC");
	}
}

function removeDataCenter(cell) {
	$(cell).html("");
}

function addRow(grid, rows, cols) {
	var i = "";
	countRows++;
	var tr = grid.appendChild(document.createElement('tr'));
	for (var c = 0; c < 1; ++c) {
		var numberCell = tr.appendChild(document.createElement('td'));
		numberCell.innerHTML = countRows;
	}
	for (var c = 1; c < cols + 1; ++c) {
		var cell = tr.appendChild(document.createElement('td'));
	}
}

function addColumn() {
	countCols++;
	$("tr").append(document.createElement('td'));
	$("tr:first>td:last").html(colName(countCols - 1));
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

		"plugins" : ["json_data", "massload", "sort", "themes", "types", "ui", "unique", "wholerow"]
	});

	var lastClicked;
	var rows = 10;
	var cols = 10;
	var grid = clickableGrid(rows, cols, function(el, row, col, i) {
		i = el.innerHTML;
		console.log("You clicked on element:", el);
		console.log("You clicked on row:", row);
		console.log("You clicked on col:", col);
		console.log("You clicked on item #:", i);
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
	});

	$('#mygraph').append(grid);

	$("#gray-out").click(function(e) {
		e.preventDefault();
		grayOutCell(lastClicked);
	});

	$('#activate').click(function(e) {
		e.preventDefault();
		activateCell(lastClicked);
	});

	$('#addDC').click(function(e) {
		e.preventDefault();
		addDataCenter(lastClicked);
	});

	$('#rmDC').click(function(e) {
		e.preventDefault();
		removeDataCenter(lastClicked);
	});

	$('#addRow').click(function(e) {
		e.preventDefault();
		addRow(grid, rows, cols);
	});

	$('#addCol').click(function(e) {
		e.preventDefault();
		addColumn();
	});
});
