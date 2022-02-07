@extends("elements.home")
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <section class="content">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading" style="margin-bottom: 50px;">
                                <h4>Employee - Create</h4></div>
                            <div class="panel-body">
                                <form action="{{route('employee.create_confirm')}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-horizontal"
                                         style="border: 1px solid black; padding:50px 100px 100px;">
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Avatar *</div>
                                            <div class="col-md-9">
                                            <span><input name="avatar" type="file"
                                                         onchange="loadFile(event)"/></span></br></br>

                                                <img id="output" class="img-rounded image" alt="Ảnh" width="100"
                                                     src="{{asset(session()->has('url_img')?session('url_img'):(session()->has('employee') ? session('employee')['src_img'] : "")) }}"/>
                                                <input type="hidden" name="tmp_url"
                                                       value="{{session()->has('tmp_url')?session('tmp_url'):""}}">
                                                @include('elements.message_error', ['value' => 'avatar'])
                                            </div>

                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Team *</div>
                                            <div class="col-md-9">
                                                <select class="form-control col-md-3" id="sel1" name="team_id">
                                                    @foreach($teams as $item)
                                                        <option
                                                            value="{{$item->id}}" {{getDataCreateForm('employee_createConfirm', 'team_id') == $item->id ? "selected" : ""}}>{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @include('elements.message_error', ['value' => 'team'])
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">First name *</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="first_name"
                                                       value="{{getDataCreateForm('employee_createConfirm', 'first_name')}}">
                                                @include('elements.message_error', ['value' => 'first_name'])
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Last name *</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="last_name"
                                                       value="{{getDataCreateForm('employee_createConfirm', 'last_name')}}">
                                                @include('elements.message_error', ['value' => 'last_name'])
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Gerder *</div>
                                            <div class="col-md-9">
                                                @foreach(config('const.gerder') as $key => $val)
                                                    <input type="radio" name="gerder"
                                                           value="{{$key}}" {{getDataCreateForm('employee_createConfirm', 'gerder')==$key ? "checked" : ""}}>
                                                    {{$val}}&emsp;&emsp;&emsp;&emsp;
                                                @endforeach
                                                @include('elements.message_error', ['value' => 'gerder'])
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Email *</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="email"
                                                       value="{{getDataCreateForm('employee_createConfirm', 'email')}}">
                                                @include('elements.message_error', ['value' => 'email'])
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Password *</div>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control" name="password"
                                                       value="{{getDataCreateForm('employee_createConfirm', 'password')}}">
                                                @include('elements.message_error', ['value' => 'password'])
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Password confirm *</div>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control" name="password_confirm"
                                                       value="{{getDataCreateForm('employee_createConfirm', 'password_confirm')}}">
                                                @include('elements.message_error', ['value' => 'password_confirm'])
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Birthday *</div>
                                            <div class="col-md-9">
                                                <input type="date" class="form-control" name="birthday"
                                                       value="{{getDataCreateForm('employee_createConfirm', 'birthday')}}">
                                                @include('elements.message_error', ['value' => 'birthday'])
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Address *</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="address"
                                                       value="{{getDataCreateForm('employee_createConfirm', 'address')}}">
                                                @include('elements.message_error', ['value' => 'address'])
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Salary *</div>
                                            <div class="col-md-9">
                                                <div style="display: flex;">
                                                    <input type="text" class="form-control" name="salary"
                                                           value="{{getDataCreateForm('employee_createConfirm', 'salary')}}">&nbsp;
                                                    &nbsp; <span>VND</span>
                                                </div>
                                                @include('elements.message_error', ['value' => 'salary'])
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Position *</div>
                                            <div class="col-md-9">
                                                <select class="form-control col-md-3" id="sel1" name="position">
                                                    @foreach(config('const.position') as $key => $val)
                                                        <option
                                                            value="{{$key}}" {{getDataCreateForm('employee_createConfirm', 'position')==$key ? "selected" : ""}}>{{$val}}</option>
                                                    @endforeach
                                                </select>
                                                @include('elements.message_error', ['value' => 'position'])
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Type of work *</div>
                                            <div class="col-md-9">
                                                <select class="form-control col-md-4" id="sel1" name="type_of_work">
                                                    @foreach(config('const.type_of_work') as $key => $val)
                                                        <option
                                                            value="{{$key}}" {{getDataCreateForm('employee_createConfirm', 'type_of_work')==$key ? "selected" : ""}}>{{$val}}</option>
                                                    @endforeach
                                                </select>
                                                @include('elements.message_error', ['value' => 'type_of_work'])
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Status *</div>
                                            <div class="col-md-9">
                                                @foreach(config('const.status') as $key => $val)
                                                    <input type="radio" name="status"
                                                           value="{{$key}}" {{getDataCreateForm('employee_createConfirm', 'status')==$key ? "checked" : ""}}>
                                                    {{$val}}&emsp;&emsp;&emsp;&emsp;
                                                @endforeach
                                                @include('elements.message_error', ['value' => 'status'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <a href="{{route('employee.create')}}"><input style="float: left;"
                                                                                          type="button"
                                                                                          value="Reset"
                                                                                          class="btn btn-danger"></a>
                                            <input style="float: right;" type="submit" value="Confirm"
                                                   class="btn btn-primary">
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
    @push('scripts')
        <script>
            var loadFile = function (event) {
                var image = document.getElementById('output');
                image.src = URL.createObjectURL(event.target.files[0]);
            };
        </script>
    @endpush
@endsection
