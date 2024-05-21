(function () {

    $(document).ready(function () {
        // $( 'textbox.editor').each( function() {
        //    CKEDITOR.replace( $(this).attr('id') );
        // });
        // BalloonEditor.create( document.querySelector( "#mom-editor" ), {} );


        $(document).on('click', '#submit-btn', function (e) {
            e.preventDefault();

            let formValid = false;
            let descValid = false;
            // let imageValid = false;

            $('#moment-form').yiiActiveForm('validateAttribute', 'momentv3-name');

            // let imageInput = $('#imgValidationInput');

            // if (imageInput.val() !== '') {
            // 	imageValid = true;
            // } else {
            // 	$('.imgReqMsg').css('display', 'block');
            // }

            var dummy = "<p><br data-cke-filler=\"true\"></p>";
            var descVal = $("#mom-editor").html() == dummy ? "" : $("#mom-editor").html();
            var flag = true;
            if (descVal == "") {
                $("#descriptionError").css('display', 'block');
            } else {
                descValid = true;
            }

            $("#description").val(descVal);

            setTimeout(function () {

                console.log($('#moment-form').find('.has-error').length);

                if ($('#moment-form').find('.has-error').length < 1) {
                    formValid = true;
                    submitForm(formValid, descValid);
                }

            }, 1000);

        });

        function submitForm(formValid, descValid) {
            if (formValid && descValid) {
                $('#moment-form').submit();
            }
        }


        BalloonEditor
            .create(document.querySelector(".editor"), { toolbar: ["bold", "italic", "bulletedList"] })
            .then(editor => {
                window.editor = editor;
                editor.model.document.on("change:data", (evt, data) => {
                    var emptyVal = "<p></p>";
                    var isEmpty = editor.getData() == "" || editor.getData() == "<p><br data-cke-filler=\"true\"></p>" ? 1 : 0;
                    console.log("description empty", isEmpty);
                    if (isEmpty) {
                        $('#' + editor.sourceElement.id).closest('.editor-wrapper').find('.editor-error').css('display', 'block');
                    } else {
                        $('#' + editor.sourceElement.id).closest('.editor-wrapper').find('.editor-error').css('display', 'none');
                    }
                });
            })
            .catch(err => { console.error(err.stack); });


        $momUploadCrop = $('#mom-upload-img-view').croppie({
            enableExif: true,
            enableResize: false,
            enableOrientation: true,
            viewport: {
                width: 500,
                height: 316,
                type: 'square'
            },
            boundary: {
                width: 600,
                height: 400
            }
        });

        function popupResult(result) {
            var html;
            if (result.html) {
                html = result.html;
            }
            if (result.src) {
                $('#momentv3-uploaded_image').val(result.src);
                $('#mom-imgView img').attr("src", result.src);
            }
        }

        function readFile(input) {
            if (input.files && input.files[0]) {
                $('#momimguploadmodal').modal('show');
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.mom-upload-img-view').addClass('ready');
                    $momUploadCrop.croppie('bind', {
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

        $('.mom-img-upload').on('click', function () {
            this.value = null;
        });
        $('.mom-img-upload').on('change', function () {
            readFile(this);
        });


        $('.mom-upload-img-result').on('click', function (ev) {

            $momUploadCrop.croppie('result', {
                type: 'canvas',
                size: {
                    width: 1000,
                    height: 633
                },
                quality: 1

            }).then(function (resp) {
                popupResult({
                    src: resp
                });
            });
            $("#momimguploadmodal").modal('hide');
        });
    });

})();