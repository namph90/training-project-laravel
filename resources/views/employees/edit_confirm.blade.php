@extends("elements.home")
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <section class="content">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading" style="margin-bottom: 50px;">
                                <h4><a href="{{route('employee.search')}}">Search</a> > Employee - Edit Confirm</h4>
                            </div>
                            <div class="panel-body">
                                <form action="{{route('employee.update', ['employee' => $id])}}" method="post"
                                      enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="form-horizontal"
                                         style="border: 1px solid black; padding:50px 100px 100px;">
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Avatar</div>
                                            <div class="col-md-9">
                                                <img id="output" class="img-rounded image" alt="Ảnh" width="100"
                                                     src="{{asset($data['src_img'])}}"/>
                                            </div>

                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Team</div>
                                            <div class="col-md-9">
                                                @foreach($teams as $item)
                                                    @if($data['team_id'] == $item->id)
                                                        <span>{{$item->name}}</span>
                                                    @endif
                                                @endforeach
                                            </div>
                                            @error('team')
                                            <code> {{ $message }} </code>
                                            @enderror
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">First name</div>
                                            <div class="col-md-9">
                                                <span>{{$data['first_name']}}</span>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Last name</div>
                                            <div class="col-md-9">
                                                <span>{{$data['last_name']}}</span>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Gerder</div>
                                            <div class="col-md-9">
                                                @foreach(config('const.gerder') as $key => $val)
                                                    <span>{{$data['gerder'] == $key ? $val : ""}}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Email</div>
                                            <div class="col-md-9">
                                                <span>{{$data['email']}}</span>
                                            </div>
                                        </div>
                                        @if(!empty($data['password_confirm']))
                                            <div class="row" style="margin-top:15px;">
                                                <div class="col-md-3">Password</div>
                                                <div class="col-md-9">
                                                    <span>{{$data['password']}}</span>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Birthday</div>
                                            <div class="col-md-9">
                                                <span>{{$data['birthday']}}</span>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Address</div>
                                            <div class="col-md-9">
                                                <span>{{$data['address']}}</span>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Salary</div>
                                            <div class="col-md-9" style="display: flex;">
                                                <span>{{number_format($data['salary'])}} (VND)</span>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Position</div>
                                            <div class="col-md-9">
                                                @foreach(config('const.position') as $key => $val)
                                                    <span>{{$data['position'] == $key ? $val : ""}}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Type of work</div>
                                            <div class="col-md-9">
                                                @foreach(config('const.type_of_work') as $key => $val)
                                                    <span>{{$data['type_of_work'] == $key ? $val : ""}}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Status</div>
                                            <div class="col-md-9">
                                                @foreach(config('const.status') as $key => $val)
                                                    <span>{{$data['status'] == $key ? $val : ""}}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <a href="{{route('employee.edit', ['employee' =>$id])}}">
                                                <input
                                                    style="float: left;"
                                                    type="button" value="Back"
                                                    class="btn btn-danger"></a>
                                            <input type="button" value="Save" style="float:right;"
                                                   class="btn btn-primary" data-toggle="modal"
                                                   data-target="#confirm-delete">

                                            <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog"
                                                 aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel">Confirm Edit</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Do you want to edit employee?</p>
                                                            <p class="debug-url"></p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">
                                                                Cancel
                                                            </button>
                                                            <input style="float: right;" value="Save"
                                                                   class="btn btn-primary btn-ok">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                $('#confirm-delete').on('show.bs.modal', function (e) {
                                                    $(this).find('.btn-ok').attr('type', 'submit');
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
@endsection
