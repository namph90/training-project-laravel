@extends("elements.home")
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success" style="text-align: center;">
            <strong>{{ session()->get('success') }}</strong>
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger" style="text-align: center;">
            <strong>{{ session()->get('error') }}</strong>
        </div>
    @endif
    <div class="panel panel-primary">
        <div class="panel-body">
            <form style="border: 1px solid black; padding: 20px;" method="get" action="">
                <div class="form-horizontal">
                    <div class="row" style="margin-top:15px;">
                        <div class="col-md-2">Name</div>
                        <div class="col-md-10">
                            <input style="width: 50%" type="text" class="form-control searchName" name="searchName"
                                   value="{{request()->has('searchName') ? request('searchName') : ""}}">
                        </div>
                    </div>
                    <div class="row" style="margin-top:15px;">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            </br></br>
                            <a href=""><input style="float: left;" type="button" value="Reset"
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
                        <th style="width: 50px;">
                                @sortablelink('id')</th>
                        <th style="width:300px;">@sortablelink('name')
                               </th>
                        <th style="width:100px;">Action</th>
                    </tr>
                    @foreach($data as $item)
                        <tr>
                            <td style="vertical-align: middle;">{{$item->id}}</td>
                            <td style="text-align: left; vertical-align: middle;">{{$item->name}}</td>
                            <td style="text-align:center; vertical-align: middle;">
                                <a href="{{route('team.edit', ['id'=>$item->id])}}" class="btn btn-outline-info">
                                    Edit
                                </a>&nbsp;&nbsp;&nbsp;
                                <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Do you want to delete?</p>
                                                <p class="debug-url"></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    Cancel
                                                </button>
                                                <a class="btn btn-danger btn-ok">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-outline-danger"
                                        data-href="{{route('team.destroy', ['id'=>$item->id])}}" data-toggle="modal"
                                        data-target="#confirm-delete">
                                    Delete
                                </button>
                                <script>
                                    $('#confirm-delete').on('show.bs.modal', function (e) {
                                        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
                                    });
                                </script>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <table class="table table-bordered table-hover thead-light" style="text-align: center;">
                    <tr>
                        <th style="width: 50px;">
                            <a style="text-decoration: none; color:#34373a ;"
                               href="">
                                ID</th>
                        <th style="width:300px;"><a style="text-decoration: none; color:#34373a ;"
                                                    href="#">Name</a></th>
                        <th style="width:170px;">Action</th>
                    </tr>
                    <tr>
                        <td colspan="3">No results found!</td>
                    </tr>
                </table>
            @endif
        </div>
    </div>
@endsection
