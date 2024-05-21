// JavaScript Document
$(document).ready(function() {

	// Reporting page custom accordion
	jQuery(".reporting-page .custom-accordion .acc-section:first-child .acc-heading").addClass('active');
	jQuery(".reporting-page .custom-accordion .acc-section:first-child .acc-content").slideDown('400');

	jQuery(".reporting-page .custom-accordion .acc-section .acc-heading").click(function() {
		jQuery("reporting-page .custom-accordion .acc-section .acc-heading").removeClass('active');
		jQuery(this).addClass('active');

		if($(this).next("div").is(":visible")){
			$(this).next("div").slideUp(400);
			$(this).removeClass('active');
		} else {
			$(".reporting-page .custom-accordion .acc-section .acc-content").slideUp(400);
			$(this).next("div").slideToggle(400);
		}
		$(".reporting-page .custom-accordion .acc-section .acc-heading").not(this).removeClass('active');
	});

	//Reporting Calendar Tab
	jQuery('.week-analysis-grid .table tfoot td:nth-child(2) .graph-trigger-btn').addClass('active');
	jQuery('.week-analysis-grid .graph-container .section:first-child').addClass('active');
	jQuery('.week-analysis-grid .table .graph-trigger-btn').click(function(e){
    	e.preventDefault();
        var tab_id = jQuery(this).attr('data-id');
        // localStorage.setItem('activeFeatureTab', jQuery(e.target).attr('class'));
        jQuery('.week-analysis-grid .table .graph-trigger-btn').removeClass('active');
        jQuery('.week-analysis-grid .graph-container .section').removeClass('active');
        jQuery(this).addClass('active');
        jQuery('#' + tab_id).addClass('active');
    });




$("#sidebar-toggle").click(function(e) {
  e.preventDefault();
  $(".wrapper").toggleClass("toggled");
});

var span = $('.icon');
$('.drop').click(function(e){
	span.toggleClass('plus minus');
});

$(".custom-control-label").click(function(){
	if($(this).hasClass("cancel-click")){
		return false;
	}
	$(this).text($(this).text() == 'Inactive' ? 'Active' : 'Inactive');
});

$(".btn.search").click(function() {
   $(".search-box").toggle();
   $("input[type='text']").focus();
 });

//$('#DataTable').DataTable( {
//	//order: [[ 0, 'desc' ], [ 0, 'asc' ]]		
//	"bFilter": false,
//	"bInfo": false,
//	"bPaginate": false,
//});

//========croper start=======//
function popupResult(result) {
	var html;
	if (result.html) {
		html = result.html;
	}
	if (result.src) {
		$('#loginscreenform-screen').val(result.src);
		$('#imgView img').attr("src", result.src);
	}
	// setTimeout(function () {
	// 	$('.sweet-alert').css('margin', function () {
	// 		var top = -1 * ($(this).height() / 2),
	// 			left = -1 * ($(this).width() / 2);

	// 		return top + 'px 0 0 ' + left + 'px';
	// 	});
	// }, 1);
}

function readFile(input) {
if (input.files && input.files[0]) {
	$('#imguploadmodal').modal('show');
	var reader = new FileReader();
	reader.onload = function (e) {
		$('.upload-img-view').addClass('ready');
		$uploadCrop.croppie('bind', {
			url: e.target.result
		}).then(function () {
			var filename = input.files[0].name;
			//console.log('jQuery bind complete');
			//console.log(e.target.result);
			//$("#profileimgup").attr("src", e.target.result);
		});
	}
	reader.readAsDataURL(input.files[0]);

} else {
	swal("Sorry - you're browser doesn't support the FileReader API");
}
}
$uploadCrop = $('#upload-img-view').croppie({
enableExif: true,
enableResize: true,
enableOrientation: true,
viewport: {
	width: 300,
	height: 300,
	type: 'square'
},
boundary: {
	width: 400,
	height: 400
}
});
$('.img-upload').on('change', function () {
readFile(this);
});

$('.upload-img-result').on('click', function (ev) {

$uploadCrop.croppie('result', {
	type: 'canvas',
	size: 'viewport'
}).then(function (resp) {
	popupResult({
		src: resp
	});
});
$("#imguploadmodal").modal('hide');
});
$('.cr-slider').attr({ 'min': 0.3297, 'max': 2.5000 });
//========croper end=======//
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 3000);


$('#frm_date,#t_date').datepicker({
    format: "dd-mm-yyyy",
    clearBtn: true,
    autoclose: true,
    endDate: '+1d',
    datesDisabled: '+1d',
});
 
});