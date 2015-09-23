$(document).ready(function() {
	$(".toggler").click(function(e) {
		e.preventDefault();
		$('.cat1').toggle();
		$('.btn-group').toggle();
	});
});