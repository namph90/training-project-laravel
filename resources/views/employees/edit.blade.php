@extends("elements.home")
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <section class="content">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading" style="margin-bottom: 50px;">
                                <h4><a href="{{route('employee.search')}}">Search</a> > Employee - Edit</h4></div>
                            <div class="panel-body">
                                <form action="{{route('employee.edit_confirm', ['id' => $employee->id])}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-horizontal"
                                         style="border: 1px solid black; padding:50px 100px 100px;">
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Id</div>
                                            <div class="col-md-9">
                                                <span>{{$employee->id}}</span>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Avatar *</div>
                                            <div class="col-md-9">
                                            <span><input name="avatar" type="file"
                                                         onchange="loadFile(event)"/></span></br></br>
                                                <img id="output" class="img-rounded image" alt="Ảnh" width="100"
                                                     src="{{asset(session()->has('img_avatar') ? session('img_avatar')['src_img'] : ('storage/uploads/'.$employee->id.'/'.$employee->avatar))}}"/>
                                                <input type="hidden" name="tmp_url"
                                                       value="{{session()->has('tmp_url')?session('tmp_url'):""}}">
                                                @error('avatar')
                                                <code> {{ $message }} </code>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Team *</div>
                                            <div class="col-md-9">
                                                <select class="form-control col-md-3" id="sel1" name="team_id">
                                                    @foreach($teams as $item)
                                                        <option
                                                            value="{{$item->id}}" {{session()->has('data_confirm_edit')&&session('data_confirm_edit')['team_id'] == $item->id ? "selected": ($employee->team_id==$item->id ? "selected" : "")}}>{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('team')
                                            <code> {{ $message }} </code>
                                            @enderror
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">First name *</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="first_name"
                                                       value="{{session()->has('data_confirm_edit') ? session('data_confirm_edit')['first_name'] : $employee->first_name}}">
                                                @error('first_name')
                                                <code> {{ $message }} </code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Last name *</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="last_name"
                                                       value="{{session()->has('data_confirm_edit') ? session('data_confirm_edit')['last_name'] : $employee->last_name}}">
                                                @error('last_name')
                                                <code> {{ $message }} </code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Gerder *</div>
                                            <div class="col-md-9">
                                                @foreach(config('const.gerder') as $key => $val)
                                                    <input type="radio" name="gerder"
                                                           value="{{$key}}" {{session()->has('data_confirm_edit')&&session('data_confirm_edit')['gerder']== $key ? "checked" : ($employee->gerder == $key ? "checked" : "")}}>
                                                    {{$val}}&emsp;&emsp;&emsp;&emsp;
                                                @endforeach
                                                @error('gerder')
                                                <code> {{ $message }} </code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Email *</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="email"
                                                       value="{{session()->has('data_confirm_edit') ? session('data_confirm_edit')['email'] : $employee->email}}">
                                                @error('email')
                                                <code> {{ $message }} </code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Password *</div>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control" name="password"
                                                       placeholder='Enter this field if you change your password' value="{{session()->has('data_confirm_edit')&&session('data_confirm_edit')['password_confirm'] != "" ? session('data_confirm_edit')['password'] : ""}}">
                                                @error('password')
                                                <code> {{ $message }} </code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Password confirm *</div>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control" name="password_confirm" value="{{session()->has('data_confirm_edit')&&session('data_confirm_edit')['password_confirm'] != "" ? session('data_confirm_edit')['password'] : ""}}">
                                                @error('password_confirm')
                                                <code> {{ $message }} </code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Birthday *</div>
                                            <div class="col-md-9">
                                                <input type="date" class="form-control" name="birthday"
                                                       value="{{session()->has('data_confirm_edit') ? session('data_confirm_edit')['birthday'] : $employee->birthday}}">
                                                @error('birthday')
                                                <code> {{ $message }} </code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Address *</div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="address"
                                                       value="{{session()->has('data_confirm_edit') ? session('data_confirm_edit')['address'] : $employee->address}}">
                                                @error('address')
                                                <code> {{ $message }} </code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Salary *</div>
                                            <div class="col-md-9">
                                                <div style="display: flex;">
                                                    <input type="text" class="form-control" name="salary"
                                                           value="{{session()->has('data_confirm_edit') ? session('data_confirm_edit')['salary'] : $employee->salary}}">&nbsp;
                                                    &nbsp; <span>VND</span>
                                                </div>
                                                @error('salary')
                                                <code> {{ $message }} </code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Position *</div>
                                            <div class="col-md-9">
                                                <select class="form-control col-md-3" id="sel1" name="position">
                                                    @foreach(config('const.position') as $key => $val)
                                                        <option
                                                            value="{{$key}}" {{session()->has('data_confirm_edit')&&session('data_confirm_edit')['position'] == $key ? "selected": ($employee->position == $key ? "selected" : "")}}>{{$val}}</option>
                                                    @endforeach
                                                </select>
                                                @error('position')
                                                <code> {{ $message }} </code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Type of work *</div>
                                            <div class="col-md-9">
                                                <select class="form-control col-md-3" name="type_of_work">
                                                    @foreach(config('const.type_of_work') as $key => $val)
                                                        <option value="{{$key}}" {{session()->has('data_confirm_edit')&&session('data_confirm_edit')['type_of_work'] == $key ? "selected": ($employee->type_of_work == $key ? "selected" : "")}}>{{$val}}</option>
                                                    @endforeach
                                                </select>
                                                @error('type_of_work')
                                                <code> {{ $message }} </code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">Status *</div>
                                            <div class="col-md-9">
                                                @foreach(config('const.status') as $key => $val)
                                                    <input type="radio" name="status"
                                                           value="{{$key}}" {{session()->has('data_confirm_edit')&&session('data_confirm_edit')['status']== $key ? "checked" : ($employee->status == $key ? "checked" : "")}}>
                                                    {{$val}}&emsp;&emsp;&emsp;&emsp;
                                                @endforeach
                                                @error('status')
                                                <code> {{ $message }} </code>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <a href="{{route('employee.edit', ['id'=> $employee->id])}}">
                                                <input style="float: left;" type="button" value="Reset"
                                                       class="btn btn-danger">
                                            </a>
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
    <script>
        var loadFile = function (event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
@endsection
