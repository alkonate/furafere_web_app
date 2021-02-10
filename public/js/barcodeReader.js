$(function(){
    // on click on barcode reader button open the barcodereader modal
// done via bootstrap

// Create the Quagga config objects
// create the Quagga liveStream config object
var liveStreamConfig = {
    inputStream: {
        type : "LiveStream",
        constraints: {
            width: {min: 640},
            height: {min: 480},
            aspectRatio: {min: 1, max: 100},
            facingMode: "environment" // or "user" for the front camera
        }
    },
    locator: {
        patchSize: "medium",
        halfSample: true
    },
    numOfWorkers: (navigator.hardwareConcurrency ? navigator.hardwareConcurrency : 4),
    decoder: {
        "readers":[
            "code_128_reader",
            "code_39_reader",
            "code_39_vin_reader",
            "ean_reader",
            "ean_8_reader",
            "codabar_reader",
        ],
        multiple : false,
    },
    locate: true
};

// custom error message to display when something bad happen !
var errorMessage = '<div class="alert alert-danger">'+
                        '<strong>'+
                            '<i class="fa fa-exclamation-triangle"></i>'+
                            ':errName' +
                        '</strong>: '+
                        ':errMessage' +
                    '</div>';


// start the live stream scanner when the modal show up
$("#modalBarecodeReader").on('show.bs.modal',function(){
// initialize the barcode reader
Quagga.init(
    liveStreamConfig,
        function(err) {
            if (err) {
                $("#modalBarecodeReader .modal-body .error").html(errorMessage.format({
                                        errName : err.name,
                                        errMessage : err.message
                                    }));
            console.log(err);
            Quagga.stop();
                return;
            }
            Quagga.start();
            console.log(lang.barcodeReader["Initialization finished. Ready to start"]);
        }
        );

});


Quagga.onProcessed(function(result) {
var drawingCtx = Quagga.canvas.ctx.overlay,
    drawingCanvas = Quagga.canvas.dom.overlay;

if (result) {
    if (result.boxes) {
        drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
        result.boxes.filter(function (box) {
            return box !== result.box;
        }).forEach(function (box) {
            Quagga.ImageDebug.drawPath(box, {x: 0, y: 1}, drawingCtx, {color: "green", lineWidth: 2});
        });
    }

    if (result.box) {
        Quagga.ImageDebug.drawPath(result.box, {x: 0, y: 1}, drawingCtx, {color: "#00F", lineWidth: 2});
    }

    if (result.codeResult && result.codeResult.code) {
        Quagga.ImageDebug.drawPath(result.line, {x: 'x', y: 'y'}, drawingCtx, {color: 'red', lineWidth: 3});
    }
}
});

// Once a barcode had been read successfully, stop quagga and
// close the modal after a second to let the user notice where
// the barcode had actually been found.
Quagga.onDetected(function(result) {
if (result.codeResult.code){
    $('#barcode').val(result.codeResult.code);
    Quagga.stop();
    setTimeout(function(){ $('#modalBarecodeReader').modal('hide'); }, 1000);
}
});

// Stop quagga in any case, when the modal is closed
$('#modalBarecodeReader').on('hide.bs.modal', function(){
if (Quagga){
    Quagga.stop();
}
});

});
