/*=========================================================================================
    File Name: app-user-edit.js
    Description: User Edit page
    --------------------------------------------------------------------------------------
    Item Name: Econsent  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
$(function () {
    'use strict';
    var dtInvoiceTable = $('.invoice-list-table');
    var changePicture = $('#change-picture'),
        userAvatar = $('.user-avatar'),
        languageSelect = $('#users-language-select2'),
        form = $('.form-validate'),
        birthdayPickr = $('.birthdate-picker');

    var assetPath = $('body').attr('data-asset-path'),
        userView = assetPath + 'user/info',
        userEdit = assetPath + 'user/edit';

    // Change user profile picture
    if (changePicture.length) {
        $(changePicture).on('change', function (e) {
            var reader = new FileReader(),
                files = e.target.files;
            reader.onload = function () {
                if (userAvatar.length) {
                    userAvatar.attr('src', reader.result);
                }
            };
            reader.readAsDataURL(files[0]);
        });
    }

    // users language select
    if (languageSelect.length) {
        languageSelect.wrap('<div class="position-relative"></div>').select2({
            dropdownParent: languageSelect.parent(),
            dropdownAutoWidth: true,
            width: '100%'
        });
    }

    // Users birthdate picker
    if (birthdayPickr.length) {
        birthdayPickr.flatpickr();
    }

    // Validation
    if (form.length) {
        $(form).each(function () {
            var $this = $(this);
            $this.validate({
                submitHandler: function (form, event) {
                    event.preventDefault();

                    let variabili = {
                        username : $('#username').val(),
                        email : $('#email').val(),
                        role : $('#role').val(),
                        genere : $('input[name=gender]:checked')[0].id,
                        data_nascita : $('#birth').val(),
                        Attivo : $('#status').val(),
                        Sito_appartenenza : $('#site').val(),
                        CF : $('#cf').val(),
                    };

                    if( variabili.username.length > 0 &&
                        variabili.email.length > 0 &&
                        (variabili.CF.length === 16 || variabili.CF.length === 0)
                    ){
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        jQuery.ajax({
                            url: assetPath + 'user/saveProfile/',
                            method: 'POST',
                            data: variabili,
                            success: function (result) {
                                if(result === "okay"){
                                    location.reload();
                                }
                            }
                        });
                    }
                },
                rules: {
                    username: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    // dob: {
                    //     required: true,
                    //     step: false
                    // },
                    cf: {
                        required: true
                    }
                }
            });

        });



    }
});
