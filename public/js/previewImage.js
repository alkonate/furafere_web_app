       $(document).ready(function(){

            $(document).on("click", "#upload", function() {

                $("#imgInp").trigger("click");

                $('#imgInp').change(function(e) {

                var reader = new FileReader();
                reader.onload = function(e) {
                    // get loaded data and render thumbnail.
                    document.getElementById("imagePreview").src = e.target.result;
                };
                // read the image file as a data URL.
                reader.readAsDataURL(this.files[0]);

                });

            });

            $(document).on("click", "#updateupload", function() {

                $("#updateimgInp").trigger("click");

                $('#updateimgInp').change(function(e) {

                var reader = new FileReader();
                reader.onload = function(e) {
                    // get loaded data and render thumbnail.
                    document.getElementById("updateimagePreview").src = e.target.result;
                };
                // read the image file as a data URL.
                reader.readAsDataURL(this.files[0]);

                });

            });
       });

