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
            <th>User</th>
            <th>Email</th>
            <th>Ruolo</th>
            <th>Sito</th>
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
            <h5 class="modal-title" id="exampleModalLabel">Nuovo Utente</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div class="form-group">
              <label class="form-label" for="username">Nome e Cognome</label>
              <input
                type="text"
                class="form-control dt-full-name"
                id="username"
                placeholder="Nome Cognome"
                name="username"
                aria-label="Nome e Cognome"
                aria-describedby="basic-icon-default-fullname2"
              />
              <label class="form-label" id="error_username" for="username" style="display: none; color: red;">Inserire Nome e Cognome</label>
            </div>
            <div class="form-group">
              <label class="form-label" for="cf">Codice Fiscale</label>
              <input
                type="text"
                id="cf"
                class="form-control dt-uname"
                placeholder="DOEJHN99P16F704T"
                aria-label="Codice fiscale"
                aria-describedby="basic-icon-default-uname2"
                name="user-name"
              />
              <label class="form-label" for="cf" id="error_cf" style="display: none; color: red;">Inserire il Codice fiscale 16 caratteri</label>
            </div>
            <div class="form-group">
              <label class="form-label" for="email">Email</label>
              <input
                type="email"
                id="email"
                class="form-control dt-email"
                placeholder="nome.cognome@example.com"
                aria-label="nome.cognome@example.com"
                aria-describedby="basic-icon-default-email2"
                name="user-email"
              />
              <label class="form-label" id="error_email" for="email" style="display: none; color: red;">Inserire una mail valida</label>
            </div>
            <div class="form-group">
              <label class="form-label" for="user-role">Ruolo Utente</label>
              <select id="role" class="form-control">
                <option value="user">User</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div class="form-group mb-2">
              <label class="form-label" for="user-plan">Seleziona Sito</label>
              <select id="sito" class="form-control">
                @foreach($siti as $sito)
                  <option value="{{$sito->Nome_sito}}">{{$sito->Nome_sito}}</option>
                @endforeach
              </select>
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
  <script src="{{ asset(mix('js/scripts/pages/app-user-list.js')) }}"></script>
@endsection
