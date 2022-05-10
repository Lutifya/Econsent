$(function () {
    'use strict';

    var dtUserTable = $('.user-list-table'),
        newUserSidebar = $('.new-user-modal'),
        newUserForm = $('.add-new-user'),
        statusObj = {
            1: {title: 'In sospeso', class: 'badge-light-warning'},
            2: {title: 'Attivo', class: 'badge-light-success'},
            3: {title: 'Inattivo', class: 'badge-light-secondary'}
        };
    var assetPath = $('body').attr('data-asset-path'),
        userView = assetPath + 'user/info',
        userEdit = assetPath + 'user/edit';

    // Users List datatable
    if (dtUserTable.length) {
        dtUserTable.DataTable({
            ajax: assetPath + 'user/getAllUsers',
            serverSide: true,
            // ajax: assetPath + 'data/user-list.json', // JSON file to add data
            columns: [
                // columns according to JSON
                {data: 'responsive_id'},
                {data: 'full_name'},
                {data: 'email'},
                {data: 'role'},
                {data: 'current_plan'},
                {data: 'status'},
                {data: ''}
            ],
            columnDefs: [
                {
                    // For Responsive
                    className: 'control',
                    orderable: false,
                    responsivePriority: 2,
                    targets: 0
                },
                {
                    // User full name and username
                    targets: 1,
                    responsivePriority: 4,
                    render: function (data, type, full, meta) {
                        var $name = full['full_name'],
                            $uname = full['username'],
                            $image = full['avatar'];
                        if ($image) {
                            // For Avatar image
                            var $output =
                                '<img src="' + assetPath + 'images/avatars/' + $image + '" alt="Avatar" height="32" width="32">';
                        } else {
                            // For Avatar badge
                            var stateNum = Math.floor(Math.random() * 6) + 1;
                            var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                            var $state = states[stateNum],
                                $name = full['full_name'],
                                $initials = $name.match(/\b\w/g) || [];
                            $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
                            $output = '<span class="avatar-content">' + $initials + '</span>';
                        }
                        var colorClass = $image === '' ? ' bg-light-' + $state + ' ' : '';
                        // Creates full output for row
                        var $row_output =
                            '<div class="d-flex justify-content-left align-items-center">' +
                            '<div class="avatar-wrapper">' +
                            '<div class="avatar ' +
                            colorClass +
                            ' mr-1">' +
                            $output +
                            '</div>' +
                            '</div>' +
                            '<div class="d-flex flex-column">' +
                            '<a href="' +
                            userView +
                            '/'+ full.id + '" class="user_name text-truncate"><span class="font-weight-bold">' +
                            $name +
                            '</span></a>' +
                            '<small class="emp_post text-muted">@' +
                            $uname +
                            '</small>' +
                            '</div>' +
                            '</div>';
                        return $row_output;
                    }
                },
                {
                    // User Role
                    targets: 3,
                    render: function (data, type, full, meta) {
                        var $role = full['role'];
                        var roleBadgeObj = {
                            Subscriber: feather.icons['user'].toSvg({class: 'font-medium-3 text-primary mr-50'}),
                            Author: feather.icons['settings'].toSvg({class: 'font-medium-3 text-warning mr-50'}),
                            Maintainer: feather.icons['database'].toSvg({class: 'font-medium-3 text-success mr-50'}),
                            Editor: feather.icons['edit-2'].toSvg({class: 'font-medium-3 text-info mr-50'}),
                            Admin: feather.icons['slack'].toSvg({class: 'font-medium-3 text-danger mr-50'}),
                            admin: feather.icons['slack'].toSvg({class: 'font-medium-3 text-danger mr-50'}),
                            user: feather.icons['user'].toSvg({class: 'font-medium-3 text-primary mr-50'}),
                        };
                        return "<span class='text-truncate align-middle'>" + roleBadgeObj[$role] + $role + '</span>';
                    }
                },
                {
                    // User Status
                    targets: 5,
                    render: function (data, type, full, meta) {
                        var $status = full['status'];

                        return (
                            '<span class="badge badge-pill ' +
                            statusObj[$status].class +
                            '" text-capitalized>' +
                            statusObj[$status].title +
                            '</span>'
                        );
                    }
                },
                {
                    // Actions
                    targets: -1,
                    title: 'Azioni',
                    orderable: false,
                    render: function (data, type, full, meta) {
                        return (
                            '<div class="btn-group">' +
                            '<a class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">' +
                            feather.icons['more-vertical'].toSvg({class: 'font-small-4'}) +
                            '</a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a href="' +
                            userView +
                            '/' + full.id + '" class="dropdown-item">' +
                            feather.icons['file-text'].toSvg({class: 'font-small-4 mr-50'}) +
                            'Informazioni</a>' +
                            // '<a href="' +
                            // userEdit +
                            // '/' + full.id + '" class="dropdown-item">' +
                            // feather.icons['archive'].toSvg({class: 'font-small-4 mr-50'}) +
                            // 'Modifica</a>' +
                            '<a href="javascript:;" data-id="' + full.id + '" class="dropdown-item delete-record">' +
                            feather.icons['trash-2'].toSvg({class: 'font-small-4 mr-50'}) +
                            'Disattiva/Riattiva </a></div>' +
                            '</div>' +
                            '</div>'
                        );
                    }
                }
            ],
            order: [[2, 'desc']],
            dom:
                '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
                '<"col-lg-12 col-xl-6" l>' +
                '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>B>>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row mb-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            language: {
                sLengthMenu: 'Mostra _MENU_',
                search: 'Search',
                searchPlaceholder: 'Search..'
            },
            // Buttons with Dropdown
            buttons: [
                {
                    text: 'Aggiungi nuovo utente',
                    className: 'add-new btn btn-primary mt-50',
                    attr: {
                        'data-toggle': 'modal',
                        'data-target': '#modals-slide-in'
                    },
                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                }
            ],
            // For responsive popup
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Details of ' + data['full_name'];
                        }
                    }),
                    type: 'column',
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                        tableClass: 'table',
                        columnDefs: [
                            {
                                targets: 2,
                                visible: false
                            },
                            {
                                targets: 3,
                                visible: false
                            }
                        ]
                    })
                }
            },
            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },
            initComplete: function () {
                // Adding role filter once table initialized
                this.api()
                    .columns(3)
                    .every(function () {
                        var column = this;
                        var select = $(
                            '<select id="UserRole" class="form-control text-capitalize mb-md-0 mb-2"><option value=""> Seleziona Ruolo </option></select>'
                        )
                            .appendTo('.user_role')
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
                            });
                    });
                // Adding plan filter once table initialized
                this.api()
                    .columns(4)
                    .every(function () {
                        var column = this;
                        var select = $(
                            '<select id="UserPlan" class="form-control text-capitalize mb-md-0 mb-2"><option value=""> Seleziona Sito </option></select>'
                        )
                            .appendTo('.user_plan')
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
                            });
                    });
                // Adding status filter once table initialized
                this.api()
                    .columns(5)
                    .every(function () {
                        var column = this;
                        var select = $(
                            '<select id="FilterTransaction" class="form-control text-capitalize mb-md-0 mb-2xx"><option value=""> Seleziona Stato </option></select>'
                        )
                            .appendTo('.user_status')
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append(
                                    '<option value="' +
                                    statusObj[d].title +
                                    '" class="text-capitalize">' +
                                    statusObj[d].title +
                                    '</option>'
                                );
                            });
                    });
            }
        });
    }

    // Check Validity
    function checkValidity(el) {
        if (el.validate().checkForm()) {
            submitBtn.attr('disabled', false);
        } else {
            submitBtn.attr('disabled', true);
        }
    }

    // Form Validation
    if (newUserForm.length) {
        newUserForm.validate({
            errorClass: 'error',
            rules: {
                'user-fullname': {
                    required: true
                },
                'user-name': {
                    required: true
                },
                'user-email': {
                    required: true
                }
            }
        });

        newUserForm.on('submit', function (e) {
            var isValid = newUserForm.valid();
            e.preventDefault();
            if (isValid) {
                newUserSidebar.modal('hide');
            }
        });
    }

    var duplicate = false;
    // To initialize tooltip with body container
    $('body').tooltip({
        selector: '[data-toggle="tooltip"]',
        container: 'body'
    });

    $('.data-submit').on('click', function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let cf = $('#cf');
        let email = $('#email');
        let username = $('#username');
        let error_username = $('#error_username');
        let error_cf = $('#error_cf');
        let error_email = $('#error_email');


        let variabili = {
            username : username.val(),
            email : email.val(),
            role : $('#role').val(),
            Sito_appartenenza : $('#sito').val(),
            CF : cf.val(),
        };

        let isValid = true;
        if(!validateEmail(variabili.email)){
            isValid = false;
            email.addClass('errore_validazione');
            error_email.css('display', 'block');
        } else{
            email.removeClass('errore_validazione');
            error_email.css('display', 'none');
        }

        if(!variabili.username.length > 0){
            isValid = false;
            username.addClass('errore_validazione');
            error_username.css('display', 'block');
        } else{
            username.removeClass('errore_validazione');
            error_username.css('display', 'none');
        }

        if(variabili.CF.length !== 16){
            isValid = false;
            cf.addClass('errore_validazione');
            error_cf.css('display', 'block');
        } else{
            cf.removeClass('errore_validazione');
            error_cf.css('display', 'none');
        }


        if(isValid && !duplicate){
            jQuery.ajax({
                url: assetPath + 'user/addUser',
                method: 'POST',
                data: variabili,
                success: function (result) {
                    if(result === "okay"){
                        location.reload();
                    }
                }
            });
        }

    });

    $( "#email" ).keyup(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: assetPath + 'user/existEmail',
            method: 'POST',
            data: {
                email: $('#email').val(),
                // type: jQuery('#type').val(),
                // price: jQuery('#price').val()
            },
            success: function (result) {
                let error_duplicate = $('#error_duplicate');
                if(result==="true"){
                    duplicate = true;
                    error_duplicate.css('display', 'block');
                }
                else{
                    duplicate = false;
                    error_duplicate.css('display', 'none');
                }
            }
        });
    });

    $(document).on("click", '.delete-record', function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery.ajax({
            url: assetPath + 'user/changeState/'+ $(this).attr('data-id'),
            method: 'GET',
            data: {
                // name: jQuery('#name').val(),
                // type: jQuery('#type').val(),
                // price: jQuery('#price').val()
            },
            success: function (result) {
                if(result === "okay"){
                    location.reload();
                }
            }
        });

    });


});

const validateEmail = (email) => {
    return String(email)
        .toLowerCase()
        .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
};

