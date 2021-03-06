@extends("elements.home")
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <section class="content">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading" style="margin-bottom: 50px;">
                                <h4>Team - Create</h4></div>
                            <div class="panel-body">
                                <form action="{{route('team.create_confirm')}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-horizontal" style="border: 1px solid black; padding:50px 100px 100px;">
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-2">Name *</div>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control email" name="name"
                                                       value="{{getDataCreateForm('team_createConfirm', 'name')}}">
                                                @include('elements.message_error', ['value' => 'name'])
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <a href="{{route('team.create')}}"><input style="float: left;" type="button" value="Reset" class="btn btn-danger"></a>
                                            <input style="float: right;" type="submit" value="Confirm" class="btn btn-primary">
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
