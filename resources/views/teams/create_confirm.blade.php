@extends("elements.home")
@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <section class="content">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading" style="margin-bottom: 50px;">
                                <h4>Team - Create Confirm</h4></div>
                            <div class="panel-body">
                                <form action="{{route('team.store')}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-horizontal" style="border: 1px solid black; padding:50px 100px 100px;">
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-2">Name</div>
                                            <div class="col-md-5">
                                                <span>{{$data['name']}}</span>
                                                <input type="hidden" value="{{$data['name']}}" name="name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top:15px;">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <a href="{{route('team.create')}}"><input style="float: left;" type="button" value="Back" class="btn btn-danger"></a>
                                            <input type="button" value="Save" style="float:right;"
                                                   class="btn btn-primary" data-toggle="modal"
                                                   data-target="#confirm-delete">

                                            <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog"
                                                 aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel">Confirm Create</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Do you want to create employee?</p>
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
