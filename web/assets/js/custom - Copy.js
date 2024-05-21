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

$('#DataTable').DataTable( {
	//order: [[ 0, 'desc' ], [ 0, 'asc' ]]		
	"bFilter": false,
	"bInfo": false,
	"bPaginate": false,
});

$(".custom-control-label").click(function(){
	$(this).text($(this).text() == 'Inactive' ? 'Active' : 'Inactive');
});
	
//========croper start=======//
function popupResult(result) {
	var html;

	if (result.html) {
		html = result.html;
	}
	if (result.src) {
		$('#signupform-avatar').val(result.src);
		$('#profileform-avatar').val(result.src);
		$('#profileimgResult img').attr("src", result.src);
	}

	let avatarInput = $('#avatar-input');
	let fileName = avatarInput.val().split( '\\' ).pop();
	avatarInput.next().find('span').text(fileName);
}

function readFile(input) {
	if (input.files && input.files[0]) {
		$('#profileuploadmodal').modal('show');
		var reader = new FileReader();

		reader.onload = function (e) {
			$('.upload-profile').addClass('ready');
			$uploadCrop.croppie('bind', {
				url: e.target.result
			}).then(function () {
				var filename = input.files[0].name;
			});
		}

		reader.readAsDataURL(input.files[0]);

	} else {
		swal("Sorry - you're browser doesn't support the FileReader API");
	}
}
$uploadCrop = $('#upload-profile').croppie({
	enableExif: true,
	enableResize: true,
	enforceBoundary: false,
	viewport: {
		width: 300,
		height: 300,
		type: 'square'
	},
	boundary: {
		width: 350,
		height: 350
	}
});
$('.profile-upload').on('change', function () {
	readFile(this);
});
$('.upload-profile-result').on('click', function (ev) {

	$uploadCrop.croppie('result', {
		type: 'canvas',
		size: 'viewport'
	}).then(function (resp) {
		popupResult({
			src: resp
		});
	}).catch(function(err) {
		debugger;
	});

	$("#profileuploadmodal").modal('hide');

});

$('.cr-slider').attr({ 'min': 0.3297, 'max': 2.5000 });
//========croper end=======//

});
