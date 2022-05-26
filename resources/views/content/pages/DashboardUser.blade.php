@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard')

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
@endsection

@section('content')
    <!-- Dashboard Ecommerce Starts -->
    <section id="dashboard-ecommerce">
        <div class="row match-height">
            <!-- Company Table Card -->
            <div class="col-lg-8 col-12">
                <div class="card card-company-table">
                    <div class="card-header">
                        <h4 class="card-title">Compilazioni fatte fare</h4>
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
            <!--/ Company Table Card -->

            <!-- Developer Meetup Card -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card card-developer-meetup">
                    <div class="meetup-img-wrapper rounded-top text-center">
                        <img src="{{asset('images/illustration/email.svg')}}" alt="Meeting Pic" height="170"/>
                    </div>
                    <div class="card-body">
                        <div class="meetup-header d-flex align-items-center">
                            <div class="meetup-day">
                                <h6 class="mb-0">{{__("locale.".date('l'))}}</h6>
                                <h3 class="mb-0">{{date("d")}}</h3>
                            </div>
                            <div class="my-auto">
                                <h4 class="card-title mb-25">Compilazione Documento</h4>
                                {{--                                <p class="card-text mb-0">Meet world popular developers</p>--}}
                            </div>
                        </div>

                        <div>
                            <div class="form-group mb-2">
                                <label class="form-label" for="user-plan" style="font-size: 15px">Seleziona Documento da
                                    compilare</label>
                                <select id="sito" class="form-control">
                                    @foreach($documenti as $documento)
                                        <option value="{{$documento->ID_documento}}">{{$documento->Nome_documento}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" style="font-size: 15px">Qual è il livello di Istruzione di chi
                                    legge e compila il Consenso Informato? <span style="color: red;">*</span></label>
                                <div style="">
                                    <div class="form-group form-control"
                                         style="display: table-cell!important;width:auto;margin-bottom:0;border:0px;height:50%;padding-top:0;padding-bottom:0">
                                        <input class="form-check-input form-controls" type="radio" id="scuola"
                                               name="education" value="1" data-enpassusermodified="yes" checked>
                                        <label class="form-label" for="scuola" style="font-size: 0.947rem"> Scuola
                                            dell'obbligo</label>
                                    </div>
                                    <div class="form-group form-control"
                                         style="display: table-cell!important;width:auto;margin-bottom:0;border:0;height:50%;padding-top:0;padding-bottom:0">
                                        <input class="form-check-input" type="radio" id="diploma" name="education"
                                               value="2" data-enpassusermodified="yes">
                                        <label class="form-label" for="diploma" style="font-size: 0.947rem">
                                            Diploma</label>
                                    </div>
                                    <div class="form-group form-control"
                                         style="display: table-cell!important;width:auto;margin-bottom:0;border:0;height:50%;padding-top:0;padding-bottom:0">
                                        <input class="form-check-input" type="radio" id="laurea" name="education"
                                               value="3" data-enpassusermodified="yes">
                                        <label class="form-label" for="laurea" style="font-size: 0.947rem">
                                            Laurea</label>
                                    </div>
                                    <label class="form-label" for="cf" id="error_nome"
                                           style="display: none; color: red;">Inserire il Nome del Sito</label>
                                </div>

                                <button type="submit" class="btn btn-primary mr-1 aggiungi-compilazioni">Aggiungi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Developer Meetup Card -->


        </div>
    </section>
    <!-- Dashboard Ecommerce ends -->
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
    <script src="{{ asset(mix('js/scripts/pages/dashboard-utente.js')) }}"></script>
@endsection
