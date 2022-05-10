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
        <!-- users filter start -->
        <div class="card">
            <h5 class="card-header">Ricerca per Filtri</h5>
            <div class="d-flex justify-content-between align-items-center mx-50 row pt-0 pb-2">
                <div class="col-md-4 user_role"></div>
                <div class="col-md-4 user_plan"></div>
                <div class="col-md-4 user_status"></div>
            </div>
        </div>
        <!-- users filter end -->
        <!-- list section start -->
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="user-list-table table">
                    <thead class="thead-light">
                    <tr>
                        <th></th>
                        <th>Nome Sito</th>
                        <th>Indirizzo_sito</th>
                        <th>Stato</th>
                        <th>Azioni</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <!-- Modal to add new user starts-->
            <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
                <div class="modal-dialog">
                    <form class="add-new-user modal-content pt-0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                        <div class="modal-header mb-1">
                            <h5 class="modal-title" id="exampleModalLabel">Nuovo Sito</h5>
                        </div>
                        <div class="modal-body flex-grow-1">
                            <label class="form-label" id="error_duplicate" for="email"
                                   style="display:none; color: red;">Nome sito già esistente!</label>
                            <div class="form-group">
                                <label class="form-label" for="username">Indirizzo Sito</label>
                                <input
                                        type="text"
                                        class="form-control dt-full-name"
                                        id="indirizzo_sito"
                                        placeholder="Indirizzo Sito"
                                        name="indirizzo_sito"
                                        aria-label="Indirizzo Sito"
                                        aria-describedby="basic-icon-default-fullname2"
                                />
                                <label class="form-label" id="err_indirizzo" for="username"
                                       style="display: none; color: red;">Inserire Indirizzo sito</label>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="cf">Nome Sito</label>
                                <input
                                        type="text"
                                        id="nome_sito"
                                        class="form-control dt-uname"
                                        placeholder="Nome sito"
                                        aria-label="Nome Sito"
                                        aria-describedby="basic-icon-default-uname2"
                                        name="sito-name"
                                />
                                <label class="form-label" for="cf" id="error_nome" style="display: none; color: red;">Inserire il Nome del Sito</label>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email">Reazione1 Sito</label>
                                <input
                                        type="text"
                                        id="reazione1"
                                        class="form-control"
                                        placeholder="Reazione1"
                                        aria-label="Reazione1"
                                        aria-describedby="basic-icon-default-email2"
                                        name="sito-reazione1"
                                />
                                <label class="form-label" id="error_reazione1" for="email"
                                       style="display: none; color: red;">Inserire correttamente la Reazione1</label>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email">Reazione2 Sito</label>
                                <input
                                        type="text"
                                        id="reazione2"
                                        class="form-control dt-email"
                                        placeholder="Reazione2"
                                        aria-label="Reazione2"
                                        aria-describedby="basic-icon-default-email2"
                                        name="sito-reazione2"
                                />
                                <label class="form-label" id="error_reazione2" for="email"
                                       style="display: none; color: red;">Inserire correttamente la Reazione</label>
                            </div>
                            <button type="submit" class="btn btn-primary mr-1 data-submit">Aggiungi</button>
                            <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
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
    <script src="{{ asset(mix('js/scripts/pages/app-siti-list.js')) }}"></script>
@endsection
