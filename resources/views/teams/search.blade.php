@extends("elements.home")
@section('content')
    @if (Session::has('create_success'))
        <div class="alert alert-success" style="text-align: center;">
            <strong>{{ trans('messages.create_success') }}</strong>
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
                                   value="">
                        </div>
                    </div>
                    <div class="row" style="margin-top:15px;">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            </br></br>
                            <a href=""><input style="float: left;" type="button" value="Reset" class="btn btn-danger"></a>
                            <input style="float: right;" type="submit" value="Search" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <br><br>
        <div class="panel-body">
            <table class="table table-bordered table-hover thead-light" style="text-align: center;">
                <tr>
                    <th style="width: 50px;">
                        <a style="text-decoration: none; color:#34373a ;"
                           href="">
                            ID <i
                                class="fa fa-sort"
                                aria-hidden="true"></i></a></th>
                    <th style="width:300px;"><a style="text-decoration: none; color:#34373a ;"
                                                href="#">Name
                            <i
                                class="fa fa-sort"
                                aria-hidden="true"></i></a></th>
                    <th style="width:170px;">Action</th>
                </tr>
                <tr>
                    <td style="vertical-align: middle;">1</td>
                    <td style="text-align: left; vertical-align: middle;">dsf</td>
                    <td style="text-align:center; vertical-align: middle;">
                        <a href="#">
                            <button type="button" class="btn btn-outline-info">Edit</button>
                        </a>&nbsp;&nbsp;&nbsp;
                        <a href="#"
                           onclick="return window.confirm('Are you sure?');">
                            <button type="button" class="btn btn-outline-danger">Danger</button>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">No results found!</td>
                </tr>
            </table>
            <table class="table table-bordered table-hover thead-light" style="text-align: center;">
                <tr>
                    <th style="width: 50px;">
                        <a style="text-decoration: none; color:#34373a ;"
                           href="">
                            ID <i
                                class="fa fa-sort"
                                aria-hidden="true"></i></a></th>
                    <th style="width:300px;"><a style="text-decoration: none; color:#34373a ;"
                                                href="#">Name</a></th>
                    <th style="width:170px;">Action</th>
                </tr>
                <tr>
                    <td colspan="3">No results found!</td>
                </tr>
            </table>
            <style type="text/css">
                .pagination {
                    padding: 0px;
                    margin: 0px;
                }
            </style>
        </div>
    </div>
@endsection
