    @if(!Auth::user()->password_updated)
      <div class="container">
          <div class="row justify-content">
              <div class="col-md-12">
                  <div class="card text-white">
                      <div class="card-header bg-danger"><i class="fas fa-exclamation-triangle fa-lg fa-fw"></i> {{__('Warning')}}</div>
                      <div class="card-body bg-success">
                          {{__('After creating a new account you must update your default password.')}}
                      </div>
                  </div>
              </div>
          </div>
      </div>
  @endif


    @if(session()->has('right'))
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissible bg-danger text-white fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('right')}}</strong>
                </div>
            </div>
        </div>
    </div>
    @endif
