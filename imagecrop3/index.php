<html>  
    <head>  
        <title>Image Crop & Upload using JQuery with PHP Ajax</title>  

        <script src="jquery.min.js"></script>  
        <script src="bootstrap.min.js"></script>
        <script src="croppie.js"></script>
        <link rel="stylesheet" href="bootstrap.min.css" />
        <link rel="stylesheet" href="croppie.css" />
    </head>  
    <body>  
        <div class="container">
            <div class="panel panel-default">
                
                <div class="panel-heading"> Select Profile Image</div>
                <div class="panel-body" align="center">
                    <input type="file" name="upload_image" id="upload_image" />                  
                    <div id="uploaded_image"></div>
                </div>

            </div>
        </div>
        <div id="uploadimageModal" class="modal modal-dialog modal-lg" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Upload & Crop Image</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-9 text-center">
                                <div id="image_demo" style="width:650px; height: 450px; margin-top:0px"></div>
                            </div>
                            <div class="col-md-3" style="padding-top:0px;"> 
                                <p>Preview</p>
                                <img class="img-responsive" id="prev-img" src="" alt="Preview" />                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ">
                                <button class="btn btn-success crop_image">Crop & Upload Image</button>
                                <!-- <button class="js-main-image" >result</button>-->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </body>  
</html>
<script>
    $(document).ready(function () {

        $image_crop = $('#image_demo').croppie({
            enableExif: false,
            viewport: {
                width: 200,
                height: 200,
                type: 'square' 
            },
            boundary: {
                width: 400,
                height: 400
            }
        });

        $('#upload_image').on('change', function () {
            var reader = new FileReader();
            reader.onload = function (event) {
                result = event.target.result;
                arrTarget = result.split(';');
                tipo = arrTarget[0];
                if (tipo == 'data:image/jpeg' || tipo == 'data:image/png') {
                    //alert('valid image');
                    $('#uploadimageModal').modal('show');
                } else {
                    // Setup the clear functionality
                    var control = $("#upload_image");
                    control.replaceWith(control.val('').clone(true));
                    alert('Accept only .jpg or .png image types');
                }
                $image_crop.croppie('bind', {
                    url: event.target.result
                }).then(function () {
                    console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('.crop_image').click(function (event) {
            $image_crop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (response) {
                $.ajax({
                    url: "upload.php",
                    type: "POST",
                    data: {"image": response},
                    success: function (data)
                    {
                        $('#uploadimageModal').modal('hide');
                        $('#uploaded_image').html(data);
                    }
                });
            })
        });

        $image_crop.on('update.croppie', function (ev, data) {
            //console.log('jquery update', ev, data);
            $image_crop.croppie('result', {
                type: 'rawcanvas',
                circle: false,
                // size: { width: 300, height: 300 },
                format: 'jpg'
            }).then(function (canvas) {
                $('#prev-img').attr('src', canvas.toDataURL());
                //console.log(canvas.toDataURL());
            });
        });

        $('.js-main-image').on('click', function (ev) {
            $image_crop.croppie('result', {
                type: 'rawcanvas',
                circle: false,
                format: 'jpg'
            }).then(function (canvas) {
                $('#prev-img').attr('src', canvas.toDataURL());
                //console.log(canvas.toDataURL());
            });
        });

    });
</script>
