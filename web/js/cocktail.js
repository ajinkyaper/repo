$(document).ready(function(){
   		
    	var old_img = '';
		$occUploadCrop = $('#occ-upload-img-view').croppie({
			enableExif: true,
			enableResize: false,
			enableOrientation: true,
			enableZoomboolean: false,
			
			viewport: {
				width: 260,
				height: 600,
				type: 'square'
			},
			boundary: {
				width: 263,
				height: 604
			},
		});

		function popupResult(result) {
			var html;
			if (result.html) {
				html = result.html;
			}
			if (result.src) {
				$('#product_uploaded_image').val(result.src);
				$('#imgValidationInput').val('present');
				$('.imgReqMsg').css('display', 'none');
				$('#occ-imgView img').attr("src", result.src);
			}
		}

		function readFile(input) {
			var isdimension = true;

			if (input.files && input.files[0]) {

				var reader = new FileReader();
				isValidFile(input.files[0], function(result){
					if(result){
						$('#occimguploadmodal').modal('show');
						   // $('.cr-boundary').attr('aria-dropeffect',"none");
				    	//    $('.cr-image').attr('aria-grabbed',"none");

						reader.onload = function (e) {
						    console.log("inside image ionmanipulat");
							$('.occ-upload-img-view').addClass('ready');
							$occUploadCrop.croppie('bind', {
								url: e.target.result,
								orientation: "unchanged"
							}).then(function () {
								$occUploadCrop.croppie('setZoom', 1);
								var filename = input.files[0].name;
							});
						}
						$("#cocktailImgError").html("");
						reader.readAsDataURL(input.files[0]);
					}else{
						$('#uploaded_img').attr('src', old_img);
						$("#cocktailImgError").html("Height and Width must be within 500px * 1000px");
					}

     			});
				
			} else {
				swal("Sorry - you're browser doesn't support the FileReader API");
			}
		}

		function isValidFile(input, callBack){

			var reader = new FileReader();
			var flag = true;
			//Read the contents of Image File.
			reader.readAsDataURL(input);
			reader.onload = function (e) {

			//Initiate the JavaScript Image object.
			var image = new Image();

			//Set the Base64 string return from FileReader as source.
			image.src = e.target.result;

			//Validate the File Height and Width.
			 image.onload = function () {
			  var height = this.height;
			  var width = this.width;
			  if (height > 1000 || width > 500) {
			    
			    flag = false;
			    console.log("flag inside",flag);
			    callBack(true);
			    return false;
			  }

			  //alert("Uploaded image has valid Height and Width.");
			  callBack(true);
			};

		  }
		  console.log("flag", flag);
		  return flag;
	    }
	    $('.occ-img-upload').on('click', function () {
	    	this.value = null;
	    });

		$('.occ-img-upload').on('change', function () {
			old_img = $("#uploaded_img").attr("src");
			readFile(this);
		});

		$('.occ-upload-img-result').on('click', function (ev) {

			$occUploadCrop.croppie('result', {
				type: 'canvas',
				size: {width:650,height:1500},
				//size: {width:220,height:500},
				quality: 1
			}).then(function (resp) {
				popupResult({
					src: resp
				});
			});

			$("#occimguploadmodal").modal('hide');
		});
});
