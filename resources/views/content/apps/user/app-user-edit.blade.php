@extends('layouts/contentLayoutMaster')

@section('title', 'Modifica Utente')

@section('vendor-style')
    {{-- Vendor Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">
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
                                id="account-tab"
                                data-toggle="tab"
                                href="#account"
                                aria-controls="account"
                                role="tab"
                                aria-selected="true"
                        >
                            <i data-feather="user"></i><span class="d-none d-sm-block">Account</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                                class="nav-link d-flex align-items-center"
                                id="information-tab"
                                data-toggle="tab"
                                href="#information"
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
                                        <label for="username">Nome e Cognome</label>
                                        <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Username"
                                                value="{{$user->name}}"
                                                name="username"
                                                id="username"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input
                                                type="email"
                                                class="form-control"
                                                placeholder="Email"
                                                value="{{$user->email}}"
                                                name="email"
                                                id="email"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Stato</label>
                                        <select class="form-control" id="status">
                                            <option value="2" {{$user->Attivo === 2 ? 'selected' : ''}}>Attivo</option>
                                            {{--                    <option>Blocked</option>--}}
                                            <option value="3" {{$user->Attivo === 3 ? 'selected' : ''}}>Disattivato
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select class="form-control" id="role">
                                            <option value="admin" {{$user->role === 'admin' ? 'selected' : ''}}>Admin
                                            </option>
                                            <option value="utente" {{$user->role === 'utente' ? 'selected' : ''}}>User
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="role">Sito</label>
                                        <select class="form-control" id="site">
                                            @foreach($siti as $sito)
                                                <option value="{{$sito->Nome_sito}}" {{$user->Sito_appartenenza === $sito->Nome_sito ? 'selected' : ''}}>{{$sito->Nome_sito}}</option>
                                            @endforeach
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
                    <input type="hidden" id="id" name="id" value="{{$user->id}}">
                    <!-- Information Tab starts -->
                    <div class="tab-pane" id="information" aria-labelledby="information-tab" role="tabpanel">
                        <!-- users edit Info form start -->
                        <form class="form-validate">
                            <div class="row mt-1">
                                <div class="col-12">
                                    <h4 class="mb-1">
                                        <i data-feather="user" class="font-medium-4 mr-25"></i>
                                        <span class="align-middle">Informazioni Personali</span>
                                    </h4>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label for="birth">Data di nascita</label>
                                        <input
                                                id="birth"
                                                type="text"
                                                class="form-control birthdate-picker"
                                                name="dob"
                                                value="{{$user->data_nascita}}"
                                                placeholder="YYYY-MM-DD"
                                        />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label for="cf">Codice Fiscale</label>
                                        <input id="cf" type="text" class="form-control" value="{{$user->CF}}"
                                               name="cf"/>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label class="d-block mb-1">Genere</label>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="male" name="gender" class="custom-control-input"
                                                    {{($user->genere == 1 || $user->genere === null) ? 'checked' : ''}}/>
                                            <label class="custom-control-label" for="male">Maschio</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="female" name="gender" class="custom-control-input"
                                                    {{$user->genere == 2 ? 'checked' : ''}} />
                                            <label class="custom-control-label" for="female">Femmina</label>
                                        </div>
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
                        <!-- users edit Info form ends -->
                    </div>
                    <!-- Information Tab ends -->

                    <div class="">
                        <div class="card card-company-table">
                            <div class="card-header">
                                <h4 class="card-title">Compilazioni fatte fare da {{$user->name}}</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="card-datatable table-responsive pt-0">
                                    <table class="compilazioni-table table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th></th>
                                            <th>Nome Documento</th>
                                            <th>Data Compilazione</th>
                                            <th>Azioni</th>
                                        </tr>
                                        </thead>
                                    </table>
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
    <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
@endsection

@section('page-script')
    {{-- Page js files --}}
    <script>
        var idUtente = {{$user->id}};
    </script>
    <script src="{{ asset(mix('js/scripts/pages/app-user-edit.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/components/components-navs.js')) }}"></script>
@endsection
