// JavaScript Document
$(document).ready(function() {

$("#sidebar-toggle").click(function(e) {
  e.preventDefault();
  $(".wrapper").toggleClass("toggled");
});

var span = $('.icon');
$('.drop').click(function(e){
	span.toggleClass('plus minus');
});

$(".custom-control-label").click(function(){
	//$(this).text($(this).text() == 'Inactive' ? 'Active' : 'Inactive');
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
	enforceBoundary: false,
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
 
});