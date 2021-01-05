@extends('layouts.app1')
@section('header')
<meta name="csrf-token" content="{{csrf_token()}}">
@endsection
@section('content')

<div class="container">

    <nav class="row">
        <div class="col-12 nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">{{__('Admins')}}</a>
          <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">{{__('Sellers')}}</a>
          <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">{{__('Cashiers')}}</a>
        </div>
    </nav>
      <div class="row tab-content" id="nav-tabContent">
        <div class="col-12 tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <table class="show_users_font_size table text-center mt-2">
                <thead>
                    <tr class="bg-dark text-white">
                        <th>{{__('Username')}}</th>
                        <th>{{__('Firstname')}}</th>
                        <th>{{__('Lastname')}}</th>
                        <th>{{__('Lock')}}</th>
                        <th>{{__('Update')}}</th>
                        <th>{{__('Delete')}}</th>
                    </tr>
                </thead>
                <tbody>

                   @forelse ($adminInfos as $adminInfo)
                       <tr id="{{'record_'.$adminInfo->id}}">
                        <td><a href="{{route('user.SuperAdmin.account',['user'=>$adminInfo->id])}}">{{$adminInfo->username}}</a></td>
                           <td>{{$adminInfo->firstname}}</td>
                           <td>{{$adminInfo->lastname}}</td>

                                @if ($adminInfo->locked)
                                    <td ><button type="button" class="btn" onclick="toggleVault({{$adminInfo->id}});">
                                        <i id="{{'vault_'.$adminInfo->id}}" class="fas fa-lock fa-lg fa-fw text-danger" ></i>
                                    </button></td>
                                @else
                                    <td ><button type="button" class="btn" onclick="toggleVault({{$adminInfo->id}});">
                                        <i id="{{'vault_'.$adminInfo->id}}"  class="fas fa-unlock fa-lg fa-fw text-success" ></i>

                                    </button></td>
                                @endif



                           <td><form action="{{route('user.SuperAdmin.updateForm',['user'=>$adminInfo->id])}}" method="GET"><button type="submit"  class="btn btn-primary">{{__('UPDATE')}}</button></form></td>
                           <td><button type="button" class="btn btn-danger" onclick="deleteUserAccount({{$adminInfo->id}});">{{__('DELETE')}}</button></td>
                       </tr>
                   @empty
                       <tr>
                           <td colspan="5">{{__('There is no admin account')}}</td>
                       </tr>
                   @endforelse
                </tbody>
            </table>



            <nav aria-label="...">
                <ul class="pagination pagination-lg">
                    {{ $adminInfos->links() }}
                </ul>
            </nav>
        </div>


        <div class="col-12 tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <table class="show_users_font_size table text-center mt-2">
                <thead>
                    <tr class="bg-dark text-white">
                        <th>{{__('Username')}}</th>
                        <th>{{__('Firstname')}}</th>
                        <th>{{__('Lastname')}}</th>
                        <th>{{__('Lock')}}</th>
                        <th>{{__('Update')}}</th>
                        <th>{{__('Delete')}}</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($sellerInfos as $sellerInfo)
                    <tr id="{{'record_'.$sellerInfo->id}}">
                     <td><a href="{{route('user.SuperAdmin.account',['user'=>$sellerInfo->id])}}">{{$sellerInfo->username}}</a></td>
                        <td>{{$sellerInfo->firstname}}</td>
                        <td>{{$sellerInfo->lastname}}</td>

                             @if ($sellerInfo->locked)
                                 <td ><button type="button" class="btn" onclick="toggleVault({{$sellerInfo->id}});">
                                     <i id="{{'vault_'.$sellerInfo->id}}" class="fas fa-lock fa-lg fa-fw text-danger" ></i>
                                 </button></td>
                             @else
                                 <td ><button type="button" class="btn" onclick="toggleVault({{$sellerInfo->id}});">
                                     <i id="{{'vault_'.$sellerInfo->id}}"  class="fas fa-unlock fa-lg fa-fw text-success" ></i>

                                 </button></td>
                             @endif



                             <td><form action="{{route('user.SuperAdmin.updateForm',['user'=>$sellerInfo->id])}}" method="GET"><button type="submit"  class="btn btn-primary">{{__('UPDATE')}}</button></form></td>
                             <td><button type="button" class="btn btn-danger" onclick="deleteUserAccount({{$sellerInfo->id}});">{{__('DELETE')}}</button></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">{{__('There is no seller account')}}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <nav aria-label="...">
                <ul class="pagination pagination-lg">
                    {{ $sellerInfos->links() }}
                </ul>
              </nav>
        </div>
        <div class="col-12 tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
            <table class="show_users_font_size table text-center mt-2">
                <thead>
                    <tr class="bg-dark text-white">
                        <th>{{__('Username')}}</th>
                        <th>{{__('Firstname')}}</th>
                        <th>{{__('Lastname')}}</th>
                        <th>{{__('Lock')}}</th>
                        <th>{{__('Update')}}</th>
                        <th>{{__('Delete')}}</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($cashierInfos as $cashierInfo)
                       <tr id="{{'record_'.$cashierInfo->id}}">
                        <td><a href="{{route('user.SuperAdmin.account',['user'=>$cashierInfo->id])}}">{{$cashierInfo->username}}</a></td>
                           <td>{{$cashierInfo->firstname}}</td>
                           <td>{{$cashierInfo->lastname}}</td>

                                @if ($cashierInfo->locked)
                                    <td ><button type="button" class="btn" onclick="toggleVault({{$cashierInfo->id}});">
                                        <i id="{{'vault_'.$cashierInfo->id}}" class="fas fa-lock fa-lg fa-fw text-danger" ></i>
                                    </button></td>
                                @else
                                    <td ><button type="button" class="btn" onclick="toggleVault({{$cashierInfo->id}});">
                                        <i id="{{'vault_'.$cashierInfo->id}}"  class="fas fa-unlock fa-lg fa-fw text-success" ></i>
                                    </button></td>
                                @endif

                                <td><form action="{{route('user.SuperAdmin.updateForm',['user'=>$cashierInfo->id])}}" method="GET"><button type="submit"  class="btn btn-primary">{{__('UPDATE')}}</button></form></td>
                                <td><button type="button" class="btn btn-danger" onclick="deleteUserAccount({{$cashierInfo->id}});">{{__('DELETE')}}</button></td>
                       </tr>
                   @empty
                       <tr>
                           <td colspan="5">{{__('There is no cashier account')}}</td>
                       </tr>
                   @endforelse
                </tbody>
            </table>

            <nav aria-label="...">
                <ul class="pagination pagination-lg">
                    {{ $cashierInfos->links() }}
                </ul>
              </nav>
        </div>
      </div>
</div>
@endsection

@section('script')

    <script>

            function toggleVaultIcon(vault){

                vault.toggleClass("fa-unlock");
                vault.toggleClass("fa-lock");
                vault.toggleClass("text-success");
                vault.toggleClass("text-danger");
                vault.next().remove();
                vault.toggle();
            }


            function toggleVault(user){
                vault = $('#vault_'+user);

                vault.toggle();

                vault.after("<i class=\"fas fa-spinner fa-lg fa-fw\"></i>");

                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                        },
                    url: "{{route('user.SuperAdmin.toggleVault')}}",
                    method:"POST",
                    contentType:"application/json",
                    data : JSON.stringify({id:user}),

                }).done(function(isToggle){
                        isToggle = JSON.parse(isToggle)['toggle'];
                        if(isToggle){
                            toggleVaultIcon(vault);
                        }
                    }).fail(function(xhr,status,error){
                            var errorMessage = '{{__("Error Enable to lock/unlock the user account : ")}}' + xhr.statusText;
                            alert(errorMessage);
                        });

            }


            //delete function
            function deleteUserAccount(user){
                if(confirm('{{__("Do you really want to delete this user account ?")}}')){

                    $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                        },
                    url: "{{route('user.SuperAdmin.delete')}}",
                    method:"POST",
                    contentType:"application/json",
                    data : JSON.stringify({id:user}),

                }).done(function(isDelete){
                        isDelete = JSON.parse(isDelete)['delete'];
                        if(isDelete){
                            $('#record_' + user).remove();
                            alert('{{__("Done")}}');
                        }else{
                            alert('{{__("Error Enable to delete the user account.")}}');
                        }
                    }).fail(function(xhr,status,error){
                            var errorMessage = '{{__("Error Enable to delete the user account : ")}}' + xhr.statusText;
                            alert(errorMessage);
                        });

                }
            }

    </script>
@endsection
