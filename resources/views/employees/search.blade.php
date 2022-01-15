@extends("elements.home")
@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success" style="text-align: center;">
            <strong>{{ session()->get('success') }}</strong>
        </div>
    @endif
    <div class="panel panel-primary">
        <div class="panel-body">
            <form style="border: 1px solid black; padding: 20px;" method="get" action="">
                <div class="form-horizontal">
                    <div class="row" style="margin-top:15px;">
                        <div class="col-md-2">Team</div>
                        <div class="col-md-10">
                            <select class="form-control col-md-2" id="sel1" name="team">
                                @foreach($teams as $item)
                                    <option value="{{$item->id}}" {{request()->has('team')&& request('team')==$item->id ? "selected" : ""}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <br><br>
                        <div class="col-md-2">Name</div>
                        <div class="col-md-10">
                            <input style="width: 50%" type="text" class="form-control" name="name"
                                   value="{{request()->has('name') ? request('name') : ""}}">
                        </div>
                        <br><br><br>
                        <div class="col-md-2">Email</div>
                        <div class="col-md-10">
                            <input style="width: 50%" type="text" class="form-control" name="email"
                                   value="{{request()->has('email') ? request('email') : ""}}">
                        </div>
                    </div>
                    <div class="row" style="margin-top:15px;">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            </br></br>
                            <a href="{{route('employee.search')}}"><input style="float: left;" type="button" value="Reset"
                                              class="btn btn-danger"></a>
                            <input style="float: right;" type="submit" value="Search" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <br><br>
        <div class="panel-body">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    {{$data->appends(request()->all())->links()}}
                </ul>
            </nav>
            @if($data->count() != 0)
                <table class="table table-bordered table-hover thead-light" style="text-align: center;">
                    <tr>
                        <th style="width: 50px;">@sortablelink('id')
                        </th>
                        <th style="width: 50px;">Avatar
                        </th>
                        <th style="width:100px;">@sortablelink('team_id', 'Team')
                        </th>
                        <th style="width:150px;">@sortablelink('last_name', 'Name')
                        </th>
                        <th style="width:150px;">@sortablelink('email')
                        </th>
                        <th style="width:150px;">Action</th>
                    </tr>
                    @foreach($data as $item)
                        <tr>
                            <td style="vertical-align: middle;">{{$item->id}}</td>
                            <td style="vertical-align: middle;">
                                <img style="width: 80px; height: 80px;"
                                     src="{{asset('storage/uploads/'.$item->id.'/'.$item->avatar)}}" alt="">
                            </td>
                            <td style="text-align: center; vertical-align: middle;">{{$item->team->name}}</td>
                            <td style="text-align: center; vertical-align: middle;">{{$item->name}}</td>
                            <td style="text-align: left; vertical-align: middle;">{{$item->email}}</td>
                            <td style="text-align:center; vertical-align: middle;">
                                <a href="{{route('employee.edit', ['id'=>$item->id])}}">
                                    <button type="button" class="btn btn-outline-info">Edit</button>
                                </a>&nbsp;&nbsp;&nbsp;
                                <a href="{{route('employee.destroy', ['id'=>$item->id])}}"
                                   onclick="return window.confirm('Are you sure?');">
                                    <button type="button" class="btn btn-outline-danger">Delete</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <table class="table table-bordered table-hover thead-light" style="text-align: center;">
                    <tr>
                        <th style="width: 50px;">Id
                        </th>
                        <th style="width:100px;">Team
                        </th>
                        <th style="width:150px;">Name
                        </th>
                        <th style="width:150px;">Email
                        </th>
                        <th style="width:100px;">Action</th>
                    </tr>
                    <tr>
                        <td colspan="5">No results found!</td>
                    </tr>
                </table>
            @endif
        </div>
    </div>
@endsection
