@extends('layouts/contentLayoutMaster')

@section('title', 'Modifica Utente')

@section('vendor-style')
    {{-- Vendor Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">

@endsection

@section('content')
    <!-- users edit start -->
    <section class="app-user-edit">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item">
                        <a
                                class="nav-link d-flex align-items-center active"
                                id="information-tab"
                                data-toggle="tab"
                                href=""
                                aria-controls="information"
                                role="tab"
                                aria-selected="false"
                        >
                            <i data-feather="info"></i><span class="d-none d-sm-block">Information</span>
                        </a>
                    </li>

                </ul>
                <div class="tab-content">
                    <!-- Account Tab starts -->
                    <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                        <!-- users edit media object start -->
                    {{--          <div class="media mb-2">--}}
                    {{--            <img--}}
                    {{--              src="{{asset('/images/avatars/7.png')}}"--}}
                    {{--              alt="users avatar"--}}
                    {{--              class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer"--}}
                    {{--              height="90"--}}
                    {{--              width="90"--}}
                    {{--            />--}}
                    {{--            <div class="media-body mt-50">--}}
                    {{--              <h4>{{$user->name}}</h4>--}}
                    {{--              <div class="col-12 d-flex mt-1 px-0">--}}
                    {{--                <label class="btn btn-primary mr-75 mb-0" for="change-picture">--}}
                    {{--                  <span class="d-none d-sm-block">Change</span>--}}
                    {{--                  <input--}}
                    {{--                    class="form-control"--}}
                    {{--                    type="file"--}}
                    {{--                    id="change-picture"--}}
                    {{--                    hidden--}}
                    {{--                    accept="image/png, image/jpeg, image/jpg"--}}
                    {{--                  />--}}
                    {{--                  <span class="d-block d-sm-none">--}}
                    {{--                    <i class="mr-0" data-feather="edit"></i>--}}
                    {{--                  </span>--}}
                    {{--                </label>--}}
                    {{--                <button class="btn btn-outline-secondary d-none d-sm-block">Remove</button>--}}
                    {{--                <button class="btn btn-outline-secondary d-block d-sm-none">--}}
                    {{--                  <i class="mr-0" data-feather="trash-2"></i>--}}
                    {{--                </button>--}}
                    {{--              </div>--}}
                    {{--            </div>--}}
                    {{--          </div>--}}
                    <!-- users edit media object ends -->
                        <!-- users edit account form start -->
                        <form class="form-validate">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="username">Indirizzo Sito</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Indirizzo Sito"
                                                value="{{$sito->indirizzo_sito}}"
                                                name="indirizzo_sito"
                                                id="indirizzo_sito"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Nome Sito</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Nome sito"
                                                value="{{$sito->Nome_sito}}"
                                                name="nome_sito"
                                                id="nome_sito"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Stato</label>
                                        <select class="form-control" id="status">
                                            <option value="2" {{$sito->Attivo === 2 ? 'selected' : ''}}>Attivo</option>
                                            {{--                    <option>Blocked</option>--}}
                                            <option value="3" {{$sito->Attivo === 3 ? 'selected' : ''}}>Disattivato
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                                    <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Salva
                                        cambiamenti
                                    </button>
                                    <button type="reset" onclick="location.reload();" class="btn btn-outline-secondary">
                                        Resetta
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- users edit account form ends -->
                    </div>
                    <!-- Account Tab ends -->
                    <input type="hidden" id="id" name="id" value="{{$sito->id}}">

                    <div class="card mt-2">
                        <div class="card-datatable table-responsive pt-0">
                            <table class="user-list-table table">
                                <thead class="thead-light">
                                <tr>
                                    <th></th>
                                    <th>Nome_documento</th>
                                    <th>Data_inserimento</th>
                                    <th>Stato</th>
                                    <th>Azioni</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
                <div class="modal-dialog">
                    <div class="add-new-user modal-content pt-0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                        <div class="modal-header mb-1">
                            <h5 class="modal-title" id="exampleModalLabel">Aggiungi Documento</h5>
                        </div>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                        data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                        aria-selected="true">Nuovo Documento
                                </button>
                            </li>
                            @if(count($documenti) > 0)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                            data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                                            aria-selected="false">Seleziona Documento
                                    </button>
                                </li>
                            @endif
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="modal-body flex-grow-1">

                                    <div class="modal-body flex-grow-1">
                                        <div class="form-group mb-2">
                                            @if(count($documenti) <= 0)
                                                <label class="form-label" id="error_duplicate" for="email"
                                                       style="color: red;">Nessun nuovo documenti disponibile, crealo
                                                    ora!</label>
                                            @endif
                                        </div>
                                        <form action="{{url('siti/aggiungiNuovoDocumento')}}/{{$sito->id}}" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="form-group mb-2">
                                                <label class="form-label" for="user-plan">Seleziona Documento</label>
                                                <input type="file" name="Contenuto" id="fileNew" class="form-control">
                                            </div>

                                            <button type="submit" id="documentNewSubmit"
                                                    class="btn btn-primary mr-1 data-submit">Aggiungi
                                            </button>
                                            <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">
                                                Cancel
                                            </button>
                                            <input type="hidden" id="SitoID" name="sitoid" value="{{$sito->id}}">
                                        </form>

                                    </div>

                                </div>
                            </div>


                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <label class="form-label" id="error_duplicate" for="email"
                                       style="display:none; color: red;">Email già esistente!</label>

                                <div class="modal-body flex-grow-1">
                                    <div class="form-group mb-2">
                                        <label class="form-label" for="user-plan">Seleziona Documento</label>
                                        <select id="sito" class="form-control">
                                            @foreach($documenti as $documento)
                                                <option value="{{$documento->ID_documento}}">{{$documento->Nome_documento}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-1 data-submit">Aggiungi</button>
                                    <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Cancel
                                    </button>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- users edit ends -->
@endsection

@section('vendor-script')
    {{-- Vendor js files --}}
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>

    <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap4.min.js')) }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
@endsection

@section('page-script')
    {{-- Page js files --}}
    <script src="{{ asset(mix('js/scripts/pages/app-siti-edit.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/components/components-navs.js')) }}"></script>
@endsection
