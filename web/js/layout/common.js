$(document).ready(function() {
	$('#DataTable').DataTable( {	
		"bFilter": false,
		"bInfo": false,
		"bPaginate": false,
	});	

	$(function() {
        $("#dvloader").show();
        //$(".contents").load("data.php", function(){ $("#dvloader").hide(); });
        return false;
	});		 
 });