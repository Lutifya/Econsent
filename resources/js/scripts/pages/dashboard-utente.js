$(function () {
    'use strict';

    var dtUserTable = $('.compilazioni-table'),
        newUserSidebar = $('.new-user-modal'),
        newUserForm = $('.add-new-user'),
        statusObj = {
            1: {title: 'In sospeso', class: 'badge-light-warning'},
            2: {title: 'Attivo', class: 'badge-light-success'},
            3: {title: 'Inattivo', class: 'badge-light-secondary'}
        };
    var assetPath = $('body').attr('data-asset-path'),
        userView = assetPath + 'siti/info',
        userEdit = assetPath + 'user/edit';
    if (dtUserTable.length) {
        dtUserTable.DataTable({
            ajax: assetPath + 'compilazioni/getAllCompilazioni',
            serverSide: true,
            // ajax: assetPath + 'data/user-list.json', // JSON file to add data
            columns: [
                // columns according to JSON
                {data: 'responsive_id'},
                {data: 'full_name'},
                {data: 'username'},
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
                // {
                //     // User Role
                //     targets: 3,
                //     render: function (data, type, full, meta) {
                //         var $role = full['role'];
                //         var roleBadgeObj = {
                //             Subscriber: feather.icons['user'].toSvg({class: 'font-medium-3 text-primary mr-50'}),
                //             Author: feather.icons['settings'].toSvg({class: 'font-medium-3 text-warning mr-50'}),
                //             Maintainer: feather.icons['database'].toSvg({class: 'font-medium-3 text-success mr-50'}),
                //             Editor: feather.icons['edit-2'].toSvg({class: 'font-medium-3 text-info mr-50'}),
                //             Admin: feather.icons['slack'].toSvg({class: 'font-medium-3 text-danger mr-50'}),
                //             admin: feather.icons['slack'].toSvg({class: 'font-medium-3 text-danger mr-50'}),
                //             user: feather.icons['user'].toSvg({class: 'font-medium-3 text-primary mr-50'}),
                //         };
                //         return "<span class='text-truncate align-middle'>" + roleBadgeObj[$role] + $role + '</span>';
                //     }
                // },
                // {
                //     // User Status
                //     targets: 3,
                //     render: function (data, type, full, meta) {
                //         var $status = full['status'];
                //
                //         return (
                //             '<span class="badge badge-pill ' +
                //             statusObj[$status].class +
                //             '" text-capitalized>' +
                //             statusObj[$status].title +
                //             '</span>'
                //         );
                //     }
                // },
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
                            // '<a href="' +
                            // userView +
                            // '/' + full.id + '" class="dropdown-item">' +
                            // feather.icons['file-text'].toSvg({class: 'font-small-4 mr-50'}) +
                            // 'Informazioni</a>' +
                            '<a href="' +
                            userEdit +
                            '/' + full.id + '" class="dropdown-item">' +
                            feather.icons['download'].toSvg({class: 'font-small-4 mr-50'}) +
                            'Scarica</a>' +
                            // '<a href="javascript:;" data-id="' + full.id + '" class="dropdown-item delete-record">' +
                            // feather.icons['trash-2'].toSvg({class: 'font-small-4 mr-50'}) +
                            // 'Disattiva/Riattiva </a></div>' +
                            '</div>' +
                            '</div>'
                        );
                    }
                }
            ],
            order: [[1, 'desc']],
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
                    text: 'Compila un documento',
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

            }
        });
    }

    $('.aggiungi-compilazioni').click(function(e){
        e.preventDefault();
        alert("prova");
    })
});