$(function() {
    const codeReader = new ZXing.BrowserMultiFormatReader();
    console.log('Zxing initialized.');
    var barcodeImgURI;

    // start the video live scanning
    $("#modalBarecodeReader").on('shown.bs.modal',function(){
        codeReader.getVideoInputDevices().then(function (videoInputDevices) {
            selectedDeviceId = videoInputDevices[0].deviceId;

            codeReader.decodeOnceFromVideoDevice(selectedDeviceId,'videoViewport').then(function (result) {
                console.log(result);
            }).catch(function (err) {
                // console.log(err);
            });
        }).catch(function (err) {
            // console.log(err);
        });

    });

    // on modal hide reset codereader
    // Stop quagga in any case, when the modal is closed
$('#modalBarecodeReader').on('hide.bs.modal', function(){
    if (ZXing){
        codeReader.reset();
        console.log('Zxing Reset');
    }exit
        codeReader.decodeFromImage(undefined,barcodeImgURI).then(function (result) {
            console.log(result.text);
        }).catch(function (err) {
            console.error(err);
        });
    });

});
