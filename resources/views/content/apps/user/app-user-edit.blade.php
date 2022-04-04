@extends('layouts/contentLayoutMaster')

@section('title', 'User Edit')

@section('vendor-style')
  {{-- Vendor Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
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
          <div class="media mb-2">
            <img
              src="{{asset('/images/avatars/7.png')}}"
              alt="users avatar"
              class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer"
              height="90"
              width="90"
            />
            <div class="media-body mt-50">
              <h4>{{$user->name}}</h4>
              <div class="col-12 d-flex mt-1 px-0">
                <label class="btn btn-primary mr-75 mb-0" for="change-picture">
                  <span class="d-none d-sm-block">Change</span>
                  <input
                    class="form-control"
                    type="file"
                    id="change-picture"
                    hidden
                    accept="image/png, image/jpeg, image/jpg"
                  />
                  <span class="d-block d-sm-none">
                    <i class="mr-0" data-feather="edit"></i>
                  </span>
                </label>
                <button class="btn btn-outline-secondary d-none d-sm-block">Remove</button>
                <button class="btn btn-outline-secondary d-block d-sm-none">
                  <i class="mr-0" data-feather="trash-2"></i>
                </button>
              </div>
            </div>
          </div>
          <!-- users edit media object ends -->
          <!-- users edit account form start -->
          <form class="form-validate">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="username">Username</label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Username"
                    value="eleanor.aguilar"
                    name="username"
                    id="username"
                  />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Name"
                    value="Eleanor Aguilar"
                    name="name"
                    id="name"
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
                    value="eleanor.aguilar@gmail.com"
                    name="email"
                    id="email"
                  />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="status">Status</label>
                  <select class="form-control" id="status">
                    <option>Active</option>
                    <option>Blocked</option>
                    <option>Deactivated</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="role">Role</label>
                  <select class="form-control" id="role">
                    <option>Admin</option>
                    <option>User</option>
                    <option>Staff</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="company">Company</label>
                  <input
                    type="text"
                    class="form-control"
                    value="WinDon Technologies Pvt Ltd"
                    placeholder="Company name"
                    id="company"
                  />
                </div>
              </div>
              <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Save Changes</button>
                <button type="reset" class="btn btn-outline-secondary">Reset</button>
              </div>
            </div>
          </form>
          <!-- users edit account form ends -->
        </div>
        <!-- Account Tab ends -->

        <!-- Information Tab starts -->
        <div class="tab-pane" id="information" aria-labelledby="information-tab" role="tabpanel">
          <!-- users edit Info form start -->
          <form class="form-validate">
            <div class="row mt-1">
              <div class="col-12">
                <h4 class="mb-1">
                  <i data-feather="user" class="font-medium-4 mr-25"></i>
                  <span class="align-middle">Personal Information</span>
                </h4>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="form-group">
                  <label for="birth">Birth date</label>
                  <input
                    id="birth"
                    type="text"
                    class="form-control birthdate-picker"
                    name="dob"
                    placeholder="YYYY-MM-DD"
                  />
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="form-group">
                  <label for="mobile">Mobile</label>
                  <input id="mobile" type="text" class="form-control" value="&#43;6595895857" name="phone" />
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="form-group">
                  <label for="website">Website</label>
                  <input
                    id="website"
                    type="text"
                    class="form-control"
                    placeholder="Website here..."
                    value="https://rowboat.com/insititious/Angelo"
                    name="website"
                  />
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="form-group">
                  <label for="languages">Languages</label>
                  <select id="languages" class="form-control">
                    <option value="English">English</option>
                    <option value="Spanish">Spanish</option>
                    <option value="French" selected>French</option>
                    <option value="Russian">Russian</option>
                    <option value="German">German</option>
                    <option value="Arabic">Arabic</option>
                    <option value="Sanskrit">Sanskrit</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="form-group">
                  <label class="d-block mb-1">Gender</label>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="male" name="gender" class="custom-control-input" />
                    <label class="custom-control-label" for="male">Male</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="female" name="gender" class="custom-control-input" checked />
                    <label class="custom-control-label" for="female">Female</label>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="form-group">
                  <label class="d-block mb-1">Contact Options</label>
                  <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="email-cb" checked />
                    <label class="custom-control-label" for="email-cb">Email</label>
                  </div>
                  <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="message" checked />
                    <label class="custom-control-label" for="message">Message</label>
                  </div>
                  <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="phone" />
                    <label class="custom-control-label" for="phone">Phone</label>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <h4 class="mb-1 mt-2">
                  <i data-feather="map-pin" class="font-medium-4 mr-25"></i>
                  <span class="align-middle">Address</span>
                </h4>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="form-group">
                  <label for="address-1">Address Line 1</label>
                  <input
                    id="address-1"
                    type="text"
                    class="form-control"
                    value="A-65, Belvedere Streets"
                    name="address"
                  />
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="form-group">
                  <label for="address-2">Address Line 2</label>
                  <input id="address-2" type="text" class="form-control" placeholder="T-78, Groove Street" />
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="form-group">
                  <label for="postcode">Postcode</label>
                  <input id="postcode" type="text" class="form-control" placeholder="597626" name="zip" />
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="form-group">
                  <label for="city">City</label>
                  <input id="city" type="text" class="form-control" value="New York" name="city" />
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="form-group">
                  <label for="state">State</label>
                  <input id="state" type="text" class="form-control" name="state" placeholder="Manhattan" />
                </div>
              </div>
              <div class="col-lg-4 col-md-6">
                <div class="form-group">
                  <label for="country">Country</label>
                  <input id="country" type="text" class="form-control" name="country" placeholder="United States" />
                </div>
              </div>
              <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">Save Changes</button>
                <button type="reset" class="btn btn-outline-secondary">Reset</button>
              </div>
            </div>
          </form>
          <!-- users edit Info form ends -->
        </div>
        <!-- Information Tab ends -->

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
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/app-user-edit.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/components/components-navs.js')) }}"></script>
@endsection
