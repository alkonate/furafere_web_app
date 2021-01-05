<!-- Modal -->
<div class="modal fade" id="modalBarecodeReader" tabindex="-1" role="dialog" aria-labelledby="barecodeReaderModalTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title">{{__('Barcode reader')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body" style="position: static">
                {{-- ZxingJS --}}
                <div id="interactive" class="viewport">
                    <video id="videoViewport"></video>
                </div>

                {{-- QuaggaJS --}}
				{{-- <div id="interactive" class="viewport"></div>
				<div class="error"></div> --}}
			</div>
            <div class="modal-footer">
                <label class="btn btn-default pull-left">
					<i class="fa fa-camera"></i> {{__('Use camera app')}}
					<input type="file" accept="image/*;capture=camera" capture="camera" class="hidden" />
				</label>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
			</div>
            </div>
        </div>
    </div>
</div>
