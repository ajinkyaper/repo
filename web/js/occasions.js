(function(){

	$(document).on('click', '#submit-btn', function(e) {
        e.preventDefault();

        let formValid = false;
        let descriptionValid = false;
        let occasionValid = false;
        let moodValid = false;
        let drinkValid = false;
        let whoValid = false;
        let imageValid = true;

        $('#occasion-form').yiiActiveForm('validateAttribute', 'occasionv3-name');
        // $('#occasion-form').yiiActiveForm('validateAttribute', 'occasionv3-description');
        // $('#occasion-form').yiiActiveForm('validateAttribute', 'occasionv3-the_occasion');
        // $('#occasion-form').yiiActiveForm('validateAttribute', 'occasionv3-the_mood');
        // $('#occasion-form').yiiActiveForm('validateAttribute', 'occasionv3-the_drink');
        // $('#occasion-form').yiiActiveForm('validateAttribute', 'occasionv3-who');

        // let imageInput = $('#imgValidationInput');

        // if (imageInput.val() !== '') {
        // 	imageValid = true;
        // } else {
        // 	$('.imgReqMsg').css('display', 'block');
        // }


        var dummy = "<p><br data-cke-filler=\"true\"></p>";

		var descriptionVal = $("#desc-editor").html()== dummy ? "" : $("#desc-editor").html();
		if(descriptionVal==""){
			$("#descriptionError").css('display', 'block');
		} else {
			descriptionValid = true;
		}
		$("#description").val(descriptionVal);

		var occasionVal = $("#occasion-editor").html()== dummy ? "" : $("#occasion-editor").html();
		if(occasionVal==""){
			$("#occasionError").css('display', 'block');
		} else {
			occasionValid = true;
		}
		$("#occasion").val(occasionVal);

		var moodVal = $("#mood-editor").html()== dummy ? "" : $("#mood-editor").html();
		if(moodVal==""){
			$("#moodError").css('display', 'block');
		} else {
			moodValid = true;
		}
		$("#mood").val(moodVal);

		var drinkVal = $("#drink-editor").html()== dummy ? "" : $("#drink-editor").html();
		if(drinkVal==""){
			$("#drinkError").css('display', 'block');
		} else {
			drinkValid = true;
		}
		$("#drink").val(drinkVal);

		var whoVal = $("#who-editor").html()== dummy ? "" : $("#who-editor").html();
		if(whoVal==""){
			$("#whoError").css('display', 'block');
		} else {
			whoValid = true;
		}
		$("#who").val(whoVal);

        setTimeout(function(){

          console.log($('#occasion-form').find('.has-error').length);

          if ($('#occasion-form').find('.has-error').length < 1) {
            formValid = true;
            submitForm(formValid, descriptionValid, occasionValid, moodValid, drinkValid, whoValid, imageValid);
          }

        }, 1000);
        
    });

    function submitForm(formValid, descriptionValid, occasionValid, moodValid, drinkValid, whoValid, imageValid) {
    	if (formValid && descriptionValid && occasionValid && moodValid && drinkValid && whoValid && imageValid) {
    		$('#occasion-form').submit();
    	}
    }

    function initializeEditor(editor) {
    	window.editor = editor;
        editor.model.document.on( "change:data", ( evt, data ) => {
            var emptyVal = "<p></p>";
            var isEmpty = editor.getData() == "" || editor.getData() == "<p><br data-cke-filler=\"true\"></p>" ? 1 : 0;
            console.log("description empty", isEmpty);
            if(isEmpty){
            	$('#' + editor.sourceElement.id).closest('.editor-wrapper').find('.editor-error').css('display', 'block');
            }else{
            	$('#' + editor.sourceElement.id).closest('.editor-wrapper').find('.editor-error').css('display', 'none');
            }
        });
    }


	$(document).ready(function(){
		// $( 'textbox.editor').each( function() {
		//    CKEDITOR.replace( $(this).attr('id') );
		// });
		// BalloonEditor.create( document.querySelector( "#occ-editor" ), {} );

		BalloonEditor
		    .create( document.querySelector( "#desc-editor" ), {toolbar: [ "bold", "italic", "bulletedList" ]} )
		    .then( editor => {
		      	initializeEditor(editor);
		      } )    
		    .catch( err => {console.error( err.stack ); } );

		BalloonEditor
		    .create( document.querySelector( "#occasion-editor" ), {toolbar: [ "bold", "italic", "bulletedList" ]} )
		    .then( editor => {
		      	initializeEditor(editor);
		      } )    
		    .catch( err => {console.error( err.stack ); } );

		BalloonEditor
		    .create( document.querySelector( "#mood-editor" ), {toolbar: [ "bold", "italic", "bulletedList" ]} )
		    .then( editor => {
		      	initializeEditor(editor);
		      } )    
		    .catch( err => {console.error( err.stack ); } );

		BalloonEditor
		    .create( document.querySelector( "#drink-editor" ), {toolbar: [ "bold", "italic", "bulletedList" ]} )
		    .then( editor => {
		      	initializeEditor(editor);
		      } )    
		    .catch( err => {console.error( err.stack ); } );

		BalloonEditor
		    .create( document.querySelector( "#who-editor" ), {toolbar: [ "bold", "italic", "bulletedList" ]} )
		    .then( editor => {
		      	initializeEditor(editor);
		      } )    
		    .catch( err => {console.error( err.stack ); } );




		$occUploadCrop = $('#occ-upload-img-view').croppie({
			enableExif: true,
			enableResize: false,
			enableOrientation: true,
			viewport: {
				width: 500,
				height: 618,
				type: 'square'
			},
			boundary: {
				width: 600,
				height: 650
			}
		});

		function popupResult(result) {
			var html;
			if (result.html) {
				html = result.html;
			}
			if (result.src) {
				$('#occasionv3-uploaded_image').val(result.src);
				$('#imgValidationInput').val('present');
				$('.imgReqMsg').css('display', 'none');
				$('#occ-imgView img').attr("src", result.src);
			}
		}

		function readFile(input) {
			if (input.files && input.files[0]) {
				$('#occimguploadmodal').modal('show');
				var reader = new FileReader();
				reader.onload = function (e) {
					$('.occ-upload-img-view').addClass('ready');
					$occUploadCrop.croppie('bind', {
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

		$('.occ-img-upload').on('click', function () {
			this.value = null;
		});

		$('.occ-img-upload').on('change', function () {
			readFile(this);
		});

		$('.occ-upload-img-result').on('click', function (ev) {

			$occUploadCrop.croppie('result', {
				type: 'canvas',
				size: {
					width:1000,
					height:1237
				},
				quality:1
			}).then(function (resp) {
				popupResult({
					src: resp
				});
			});
			$("#occimguploadmodal").modal('hide');
		});
	});

})();