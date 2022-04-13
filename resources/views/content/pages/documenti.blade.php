@extends('layouts/contentLayoutMaster')

@section('title', 'Lista Utenti')

@section('vendor-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">
@endsection

@section('page-style')
    <style>
        .errore_validazione {
            outline: #ff0e0e outset 1px;
            border-color: #f10000;
            box-shadow: 0 0 2pt 2pt #963232;
        }
    </style>
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
@endsection

@section('content')
    <!-- users list start -->
    <section class="app-user-list">
        <!-- list section start -->
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="user-list-table table">
                    <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th>Nome Documento</th>
                        <th>Data inserimento</th>
                        <th>Azioni</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <!-- Modal to add new user starts-->
            <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
                <div class="modal-dialog">
                    <div class="add-new-user modal-content pt-0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                        <div class="modal-header mb-1">
                            <h5 class="modal-title" id="exampleModalLabel">Nuovo Sito</h5>
                        </div>

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                        data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                        aria-selected="true">Nuovo Documento
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="modal-body flex-grow-1">

                                    <div class="modal-body flex-grow-1">
                                        <form action="{{url('documenti/aggiungiNuovoDocumento')}}" method="POST"
                                              enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="form-group mb-2">
                                                <label class="form-label" for="user-plan">Seleziona Documento</label>
                                                <input type="file" name="Contenuto" id="fileNew" class="form-control">
                                            </div>

                                            <button type="submit"
                                                    class="btn btn-primary mr-1 data-submit">Aggiungi
                                            </button>
                                            <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">
                                                Cancel
                                            </button>
                                        </form>

                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!-- Modal to add new user Ends-->
        </div>
        <!-- list section end -->
    </section>
    <!-- users list ends -->
@endsection

@section('vendor-script')
    {{-- Vendor js files --}}
    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap4.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
@endsection

@section('page-script')
    {{-- Page js files --}}
    <script src="{{ asset(mix('js/scripts/pages/app-documenti-list.js')) }}"></script>
@endsection
