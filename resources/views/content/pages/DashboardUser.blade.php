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
    <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
        <div class="modal-dialog">
            <form class="add-new-user modal-content pt-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">Compilazione Documento</h5>
                </div>
                <div class="modal-body flex-grow-1">
                    <div class="form-group mb-2">
                        <label class="form-label" for="user-plan" style="font-size: 15px">Seleziona Documento da compilare</label>
                        <select id="sito" class="form-control">
                            @foreach($documenti as $documento)
                                <option value="{{$documento->ID_documento}}">{{$documento->Nome_documento}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-size: 15px">Qual è il livello di Istruzione di chi legge e compila il Consenso Informato? <span style="color: red;">*</span></label>

                        <div class="form-group form-control" style="margin-bottom:0;border:0px;height:50%;padding-top:0;padding-bottom:0">
                            <input class="form-check-input form-controls" type="radio" id="scuola" name="education" value="0" data-enpassusermodified="yes" checked>
                            <label class="form-label" for="scuola"> Scuola dell'obbligo</label>
                        </div>
                        <div class="form-group form-control" style="margin-bottom:0;border:0;height:50%;padding-top:0;padding-bottom:0">
                            <input class="form-check-input" type="radio" id="diploma" name="education" value="1" data-enpassusermodified="yes">
                            <label class="form-label" for="diploma"> Diploma</label>
                        </div>
                        <div class="form-group form-control" style="margin-bottom:0;border:0;height:50%;padding-top:0;padding-bottom:0">
                            <input class="form-check-input" type="radio" id="laurea" name="education" value="2" data-enpassusermodified="yes">
                            <label class="form-label" for="laurea"> Laurea</label>
                        </div>
                        <label class="form-label" for="cf" id="error_nome" style="display: none; color: red;">Inserire il Nome del Sito</label>
                    </div>

                    <button type="submit" class="btn btn-primary mr-1 aggiungi-compilazioni">Aggiungi</button>
                    <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <section id="dashboard-ecommerce">
        <div class="row match-height">
            <!-- Company Table Card -->
            <div class="col-lg-8 col-12">
                <div class="card card-company-table">
                    <div class="card-header">
                        <h4 class="card-title">Compilazioni effettuate</h4>
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
                        <img src="{{asset('images/illustration/email.svg')}}" alt="Meeting Pic" height="170" />
                    </div>
                    <div class="card-body">
                        <div class="meetup-header d-flex align-items-center">
                            <div class="meetup-day">
                                <h6 class="mb-0">THU</h6>
                                <h3 class="mb-0">24</h3>
                            </div>
                            <div class="my-auto">
                                <h4 class="card-title mb-25">Developer Meetup</h4>
                                <p class="card-text mb-0">Meet world popular developers</p>
                            </div>
                        </div>
                        <div class="media">
                            <div class="avatar bg-light-primary rounded mr-1">
                                <div class="avatar-content">
                                    <i data-feather="calendar" class="avatar-icon font-medium-3"></i>
                                </div>
                            </div>
                            <div class="media-body">
                                <h6 class="mb-0">Sat, May 25, 2020</h6>
                                <small>10:AM to 6:PM</small>
                            </div>
                        </div>
                        <div class="media mt-2">
                            <div class="avatar bg-light-primary rounded mr-1">
                                <div class="avatar-content">
                                    <i data-feather="map-pin" class="avatar-icon font-medium-3"></i>
                                </div>
                            </div>
                            <div class="media-body">
                                <h6 class="mb-0">Central Park</h6>
                                <small>Manhattan, New york City</small>
                            </div>
                        </div>
                        <div class="avatar-group">
                            <div
                                    data-toggle="tooltip"
                                    data-popup="tooltip-custom"
                                    data-placement="bottom"
                                    data-original-title="Billy Hopkins"
                                    class="avatar pull-up"
                            >
                                <img src="{{asset('images/portrait/small/avatar-s-9.jpg')}}" alt="Avatar" width="33" height="33" />
                            </div>
                            <div
                                    data-toggle="tooltip"
                                    data-popup="tooltip-custom"
                                    data-placement="bottom"
                                    data-original-title="Amy Carson"
                                    class="avatar pull-up"
                            >
                                <img src="{{asset('images/portrait/small/avatar-s-6.jpg')}}" alt="Avatar" width="33" height="33" />
                            </div>
                            <div
                                    data-toggle="tooltip"
                                    data-popup="tooltip-custom"
                                    data-placement="bottom"
                                    data-original-title="Brandon Miles"
                                    class="avatar pull-up"
                            >
                                <img src="{{asset('images/portrait/small/avatar-s-8.jpg')}}" alt="Avatar" width="33" height="33" />
                            </div>
                            <div
                                    data-toggle="tooltip"
                                    data-popup="tooltip-custom"
                                    data-placement="bottom"
                                    data-original-title="Daisy Weber"
                                    class="avatar pull-up"
                            >
                                <img
                                        src="{{asset('images/portrait/small/avatar-s-20.jpg')}}"
                                        alt="Avatar"
                                        width="33"
                                        height="33"
                                />
                            </div>
                            <div
                                    data-toggle="tooltip"
                                    data-popup="tooltip-custom"
                                    data-placement="bottom"
                                    data-original-title="Jenny Looper"
                                    class="avatar pull-up"
                            >
                                <img
                                        src="{{asset('images/portrait/small/avatar-s-20.jpg')}}"
                                        alt="Avatar"
                                        width="33"
                                        height="33"
                                />
                            </div>
                            <h6 class="align-self-center cursor-pointer ml-50 mb-0">+42</h6>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Developer Meetup Card -->

            <!-- Browser States Card -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card card-browser-states">
                    <div class="card-header">
                        <div>
                            <h4 class="card-title">Browser States</h4>
                            <p class="card-text font-small-2">Counter August 2020</p>
                        </div>
                        <div class="dropdown chart-dropdown">
                            <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-toggle="dropdown"></i>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="browser-states">
                            <div class="media">
                                <img
                                        src="{{asset('images/icons/google-chrome.png')}}"
                                        class="rounded mr-1"
                                        height="30"
                                        alt="Google Chrome"
                                />
                                <h6 class="align-self-center mb-0">Google Chrome</h6>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="font-weight-bold text-body-heading mr-1">54.4%</div>
                                <div id="browser-state-chart-primary"></div>
                            </div>
                        </div>
                        <div class="browser-states">
                            <div class="media">
                                <img
                                        src="{{asset('images/icons/mozila-firefox.png')}}"
                                        class="rounded mr-1"
                                        height="30"
                                        alt="Mozila Firefox"
                                />
                                <h6 class="align-self-center mb-0">Mozila Firefox</h6>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="font-weight-bold text-body-heading mr-1">6.1%</div>
                                <div id="browser-state-chart-warning"></div>
                            </div>
                        </div>
                        <div class="browser-states">
                            <div class="media">
                                <img
                                        src="{{asset('images/icons/apple-safari.png')}}"
                                        class="rounded mr-1"
                                        height="30"
                                        alt="Apple Safari"
                                />
                                <h6 class="align-self-center mb-0">Apple Safari</h6>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="font-weight-bold text-body-heading mr-1">14.6%</div>
                                <div id="browser-state-chart-secondary"></div>
                            </div>
                        </div>
                        <div class="browser-states">
                            <div class="media">
                                <img
                                        src="{{asset('images/icons/internet-explorer.png')}}"
                                        class="rounded mr-1"
                                        height="30"
                                        alt="Internet Explorer"
                                />
                                <h6 class="align-self-center mb-0">Internet Explorer</h6>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="font-weight-bold text-body-heading mr-1">4.2%</div>
                                <div id="browser-state-chart-info"></div>
                            </div>
                        </div>
                        <div class="browser-states">
                            <div class="media">
                                <img src="{{asset('images/icons/opera.png')}}" class="rounded mr-1" height="30" alt="Opera Mini" />
                                <h6 class="align-self-center mb-0">Opera Mini</h6>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="font-weight-bold text-body-heading mr-1">8.4%</div>
                                <div id="browser-state-chart-danger"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Browser States Card -->

            <!-- Goal Overview Card -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Goal Overview</h4>
                        <i data-feather="help-circle" class="font-medium-3 text-muted cursor-pointer"></i>
                    </div>
                    <div class="card-body p-0">
                        <div id="goal-overview-radial-bar-chart" class="my-2"></div>
                        <div class="row border-top text-center mx-0">
                            <div class="col-6 border-right py-1">
                                <p class="card-text text-muted mb-0">Completed</p>
                                <h3 class="font-weight-bolder mb-0">786,617</h3>
                            </div>
                            <div class="col-6 py-1">
                                <p class="card-text text-muted mb-0">In Progress</p>
                                <h3 class="font-weight-bolder mb-0">13,561</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Goal Overview Card -->

            <!-- Transaction Card -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card card-transaction">
                    <div class="card-header">
                        <h4 class="card-title">Transactions</h4>
                        <div class="dropdown chart-dropdown">
                            <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-toggle="dropdown"></i>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="transaction-item">
                            <div class="media">
                                <div class="avatar bg-light-primary rounded">
                                    <div class="avatar-content">
                                        <i data-feather="pocket" class="avatar-icon font-medium-3"></i>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h6 class="transaction-title">Wallet</h6>
                                    <small>Starbucks</small>
                                </div>
                            </div>
                            <div class="font-weight-bolder text-danger">- $74</div>
                        </div>
                        <div class="transaction-item">
                            <div class="media">
                                <div class="avatar bg-light-success rounded">
                                    <div class="avatar-content">
                                        <i data-feather="check" class="avatar-icon font-medium-3"></i>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h6 class="transaction-title">Bank Transfer</h6>
                                    <small>Add Money</small>
                                </div>
                            </div>
                            <div class="font-weight-bolder text-success">+ $480</div>
                        </div>
                        <div class="transaction-item">
                            <div class="media">
                                <div class="avatar bg-light-danger rounded">
                                    <div class="avatar-content">
                                        <i data-feather="dollar-sign" class="avatar-icon font-medium-3"></i>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h6 class="transaction-title">Paypal</h6>
                                    <small>Add Money</small>
                                </div>
                            </div>
                            <div class="font-weight-bolder text-success">+ $590</div>
                        </div>
                        <div class="transaction-item">
                            <div class="media">
                                <div class="avatar bg-light-warning rounded">
                                    <div class="avatar-content">
                                        <i data-feather="credit-card" class="avatar-icon font-medium-3"></i>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h6 class="transaction-title">Mastercard</h6>
                                    <small>Ordered Food</small>
                                </div>
                            </div>
                            <div class="font-weight-bolder text-danger">- $23</div>
                        </div>
                        <div class="transaction-item">
                            <div class="media">
                                <div class="avatar bg-light-info rounded">
                                    <div class="avatar-content">
                                        <i data-feather="trending-up" class="avatar-icon font-medium-3"></i>
                                    </div>
                                </div>
                                <div class="media-body">
                                    <h6 class="transaction-title">Transfer</h6>
                                    <small>Refund</small>
                                </div>
                            </div>
                            <div class="font-weight-bolder text-success">+ $98</div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Transaction Card -->
        </div>
        <div class="row match-height">
            <!-- Medal Card -->
            <div class="col-xl-4 col-md-6 col-12">
                <div class="card card-congratulation-medal">
                    <div class="card-body">
                        <h5>Congratulations 🎉 John!</h5>
                        <p class="card-text font-small-3">You have won gold medal</p>
                        <h3 class="mb-75 mt-2 pt-50">
                            <a href="javascript:void(0);">$48.9k</a>
                        </h3>
                        <button type="button" class="btn btn-primary">View Sales</button>
                        <img src="{{asset('images/illustration/badge.svg')}}" class="congratulation-medal" alt="Medal Pic" />
                    </div>
                </div>
            </div>
            <!--/ Medal Card -->

            <!-- Statistics Card -->
            <div class="col-xl-8 col-md-6 col-12">
                <div class="card card-statistics">
                    <div class="card-header">
                        <h4 class="card-title">Statistics</h4>
                        <div class="d-flex align-items-center">
                            <p class="card-text font-small-2 mr-25 mb-0">Updated 1 month ago</p>
                        </div>
                    </div>
                    <div class="card-body statistics-body">
                        <div class="row">
                            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                <div class="media">
                                    <div class="avatar bg-light-primary mr-2">
                                        <div class="avatar-content">
                                            <i data-feather="trending-up" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto">
                                        <h4 class="font-weight-bolder mb-0">230k</h4>
                                        <p class="card-text font-small-3 mb-0">Sales</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                <div class="media">
                                    <div class="avatar bg-light-info mr-2">
                                        <div class="avatar-content">
                                            <i data-feather="user" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto">
                                        <h4 class="font-weight-bolder mb-0">8.549k</h4>
                                        <p class="card-text font-small-3 mb-0">Customers</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                                <div class="media">
                                    <div class="avatar bg-light-danger mr-2">
                                        <div class="avatar-content">
                                            <i data-feather="box" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto">
                                        <h4 class="font-weight-bolder mb-0">1.423k</h4>
                                        <p class="card-text font-small-3 mb-0">Products</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 col-12">
                                <div class="media">
                                    <div class="avatar bg-light-success mr-2">
                                        <div class="avatar-content">
                                            <i data-feather="dollar-sign" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="media-body my-auto">
                                        <h4 class="font-weight-bolder mb-0">$9745</h4>
                                        <p class="card-text font-small-3 mb-0">Revenue</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Statistics Card -->
        </div>

        <div class="row match-height">
            <div class="col-lg-4 col-12">
                <div class="row match-height">
                    <!-- Bar Chart - Orders -->
                    <div class="col-lg-6 col-md-3 col-6">
                        <div class="card">
                            <div class="card-body pb-50">
                                <h6>Orders</h6>
                                <h2 class="font-weight-bolder mb-1">2,76k</h2>
                                <div id="statistics-order-chart"></div>
                            </div>
                        </div>
                    </div>
                    <!--/ Bar Chart - Orders -->

                    <!-- Line Chart - Profit -->
                    <div class="col-lg-6 col-md-3 col-6">
                        <div class="card card-tiny-line-stats">
                            <div class="card-body pb-50">
                                <h6>Profit</h6>
                                <h2 class="font-weight-bolder mb-1">6,24k</h2>
                                <div id="statistics-profit-chart"></div>
                            </div>
                        </div>
                    </div>
                    <!--/ Line Chart - Profit -->

                    <!-- Earnings Card -->
                    <div class="col-lg-12 col-md-6 col-12">
                        <div class="card earnings-card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="card-title mb-1">Earnings</h4>
                                        <div class="font-small-2">This Month</div>
                                        <h5 class="mb-1">$4055.56</h5>
                                        <p class="card-text text-muted font-small-2">
                                            <span class="font-weight-bolder">68.2%</span><span> more earnings than last month.</span>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <div id="earnings-chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Earnings Card -->
                </div>
            </div>

            <!-- Revenue Report Card -->
            <div class="col-lg-8 col-12">
                <div class="card card-revenue-budget">
                    <div class="row mx-0">
                        <div class="col-md-8 col-12 revenue-report-wrapper">
                            <div class="d-sm-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-title mb-50 mb-sm-0">Revenue Report</h4>
                                <div class="d-flex align-items-center">
                                    <div class="d-flex align-items-center mr-2">
                                        <span class="bullet bullet-primary font-small-3 mr-50 cursor-pointer"></span>
                                        <span>Earning</span>
                                    </div>
                                    <div class="d-flex align-items-center ml-75">
                                        <span class="bullet bullet-warning font-small-3 mr-50 cursor-pointer"></span>
                                        <span>Expense</span>
                                    </div>
                                </div>
                            </div>
                            <div id="revenue-report-chart"></div>
                        </div>
                        <div class="col-md-4 col-12 budget-wrapper">
                            <div class="btn-group">
                                <button
                                        type="button"
                                        class="btn btn-outline-primary btn-sm dropdown-toggle budget-dropdown"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                >
                                    2020
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);">2020</a>
                                    <a class="dropdown-item" href="javascript:void(0);">2019</a>
                                    <a class="dropdown-item" href="javascript:void(0);">2018</a>
                                </div>
                            </div>
                            <h2 class="mb-25">$25,852</h2>
                            <div class="d-flex justify-content-center">
                                <span class="font-weight-bolder mr-25">Budget:</span>
                                <span>56,800</span>
                            </div>
                            <div id="budget-chart"></div>
                            <button type="button" class="btn btn-primary">Increase Budget</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Revenue Report Card -->
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
