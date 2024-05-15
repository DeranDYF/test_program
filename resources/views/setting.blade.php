@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-xl-12">
            <div class="card text-center mb-4">
                <div class="card-header p-0">
                    <div class="nav-align-top">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link d-flex flex-column gap-1 active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-profile-card" aria-controls="navs-profile-card" aria-selected="true">
                                    <i class="tf-icons tf-icons ri-user-3-line"></i> Profil
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link d-flex flex-column gap-1" role="tab" data-bs-toggle="tab" data-bs-target="#navs-password-card" aria-controls="navs-password-card" aria-selected="false">
                                    <i class="tf-icons ri-git-repository-private-line"></i> Password
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content pb-0">
                        <div class="tab-pane fade show active" id="navs-profile-card" role="tabpanel">
                            <div class="d-flex align-items-start gap-6">
                                <img src="/assets/img/avatars/1.png" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded-4" id="setting-avatar" />
                                <div class="text-start">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-setting-avatar">
                                        Ubah Profil
                                    </button>
                                    <p class="mt-2 text-muted">Gambar harus berformat JPG, GIF atau PNG. Maks Ukuran 800
                                        KB</p>
                                </div>
                            </div>
                            <form action="post" class="space-y-4" id="form-setting-user" entype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row mt-1 g-5">
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input class="form-control" type="email" id="setting-user-nama" name="setting-user-nama" value="" placeholder="" required />
                                            <label for="nama-lengkap">Nama Lengkap</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input class="form-control" type="text" id="setting-user-email" name="setting-user-email" value="" placeholder="" readonly required />
                                            <label for="email">E-mail</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-merge">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="setting-user-telepon" name="setting-user-telepon" class="form-control" value="" placeholder="" />
                                                <label for="telepon">Nomor Telepon</label>
                                            </div>
                                            <span class="input-group-text">ID (+62)</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input class="form-control" type="text" id="setting-user-alamat" name="setting-user-alamat" value="" placeholder="" />
                                            <label for="alamat">Alamat</label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="mt-6">
                                <button type="submit" id="btn-setting-user" class="btn btn-primary me-3">Simpan</button>
                                <button type="reset" id="btnr-setting-user" class="btn btn-outline-secondary">Reset</button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-password-card" role="tabpanel">
                            <form action="post" class="space-y-4" id="form-setting-password" entype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="mb-5 col-md-6 form-password-toggle">
                                        <div class="input-group input-group-merge">
                                            <div class="form-floating form-floating-outline">
                                                <input class="form-control" type="password" name="setting-user-password" id="setting-user-password" placeholder="" required />
                                                <label for="PasswordBaru">Password Baru</label>
                                            </div>
                                            <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-password-toggle">
                                        <div class="input-group input-group-merge">
                                            <div class="form-floating form-floating-outline">
                                                <input class="form-control" type="password" id="setting-user-confirm-password" name="setting-user-confirm-password" placeholder="" required />
                                                <label for="ConfirmPasswordBaru">Confirm Password Baru</label>
                                            </div>
                                            <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="mt-6">
                                <button type="submit" id="btn-setting-password" class="btn btn-primary me-3 align-item-start">Ubah Password</button>
                                <button type="reset" id="btnr-setting-password" class="btn btn-outline-secondary">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Avatar -->
<div class="modal fade" id="modal-setting-avatar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Modal Gambar Profil</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="post" class="space-y-4" id="form-setting-avatar" entype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-floating form-floating-outline mb-6">
                        <input type="file" class="form-control" id="setting-user-avatar" name="setting-user-avatar" required />
                        <label for="setting-user-avatar">Gambar</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" id="btn-setting-avatar" class="btn btn-primary">Ubah</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Avatar -->

<script>
    $(document).ready(function() {
        function loadData() {
            $.ajax({
                type: "GET",
                url: "{{ route('get_setting_user') }}",
                dataType: "JSON",
                success: function(response) {
                    (response.avatar == null ? $('#setting-avatar').attr('src',
                        '/assets/img/avatars/1.png') : $('#setting-avatar').attr('src',
                        response.avatar));
                    $('#setting-user-nama').val(response.name);
                    $('#setting-user-email').val(response.email);
                    $('#setting-user-alamat').val(response.alamat);
                    $('#setting-user-telepon').val(response.telepon);
                }
            });
        }

        loadData();

        $('#btnr-setting-user').click(function() {
            loadData();
        });

        $('#modal-setting-avatar').on('hide.bs.modal', function(e) {
            $('#form-setting-avatar')[0].reset();
        });

        $('#btn-setting-avatar').click(function() {
            let button = $(this);
            button.prop('disabled', true);
            button.html(
                "<span class='spinner-border spinner-border-sm me-1' user='status' aria-hidden='true'></span> Please wait..."
            );
            let valid = true;
            let msg = '';

            var fileInput = $('#setting-user-avatar')[0];

            if (fileInput.files.length === 0) {
                fileInput.classList.add('is-invalid');
                msg = 'mohon untuk tidak mengkosongkan input!';
                valid = false;
            }

            if (valid) {
                let form_data = new FormData($('#form-setting-avatar')[0]);
                $.ajax({
                    type: "POST",
                    url: "{{ route('update_setting_avatar')}}",
                    data: form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.success) {
                            $('#form-setting-avatar')[0].reset();
                            $('#modal-setting-avatar').modal(
                                'hide');
                            toastr.success(response.msg, "Berhasil!", {
                                progressBar: true
                            });
                            location.reload();
                        } else {
                            toastr.error(response.msg, "Kesalahan!", {
                                progressBar: true
                            });
                            button.prop('disabled', false);
                            button.text('Ubah');
                        }
                    }
                });
            } else {
                toastr.error(msg, "Kesalahan!", {
                    progressBar: true
                });
                button.prop('disabled', false);
                button.text('Ubah');

            }
        });

        $('#btn-setting-user').click(function() {
            let button = $(this);
            button.prop('disabled', true);
            button.html(
                "<span class='spinner-border spinner-border-sm me-1' user='status' aria-hidden='true'></span> Please wait..."
            );
            let valid = true;
            let msg = '';
            $('#form-setting-user :input[required]').each(function(index, element) {
                $(this).removeClass('is-invalid');
                $(this).next('span').removeClass('is-invalid');
                if ($(this).val() == '') {
                    $(this).addClass('is-invalid');
                    $(this).next('span').addClass('is-invalid');
                    msg = 'mohon untuk tidak mengkosongkan input!';
                    valid = false;
                }
            });

            if (valid) {
                let form_data = new FormData($('#form-setting-user')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ route('update_setting_user')}}",
                    data: form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.msg, "Berhasil!", {
                                progressBar: true
                            });
                            location.reload();
                        } else {
                            toastr.error(response.msg, "Kesalahan!", {
                                progressBar: true
                            });
                            button.prop('disabled', false);
                            button.text('Simpan');
                        }
                    }
                });
            } else {
                button.prop('disabled', false);
                button.text('Simpan');
                toastr.error(msg, "Kesalahan!", {
                    progressBar: true
                });
            }
        });


        $('#btn-setting-password').click(function() {
            let button = $(this);
            button.prop('disabled', true);
            button.html(
                "<span class='spinner-border spinner-border-sm me-1' user='status' aria-hidden='true'></span> Please wait..."
            );
            let valid = true;
            let msg = '';
            $('#form-setting-password :input[required]').each(function(index, element) {
                $(this).removeClass('is-invalid');
                $(this).next('span').removeClass('is-invalid');
                if ($(this).val() == '') {
                    $(this).addClass('is-invalid');
                    $(this).next('span').addClass('is-invalid');
                    msg = 'mohon untuk tidak mengkosongkan input!';
                    valid = false;
                }
            });

            if (valid) {
                let form_data = new FormData($('#form-setting-password')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ route('update_setting_password')}}",
                    data: form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(response) {
                        if (response.success) {
                            $('#form-setting-password')[0].reset();
                            toastr.success(response.msg, "Berhasil!", {
                                progressBar: true
                            });
                            location.reload();
                        } else {
                            toastr.error(response.msg, "Kesalahan!", {
                                progressBar: true
                            });
                            button.prop('disabled', false);
                            button.text('Ubah Password');
                        }
                    }
                });
            } else {
                toastr.error(msg, "Kesalahan!", {
                    progressBar: true
                });
                button.prop('disabled', false);
                button.text('Ubah Password');
            }
        });

        $('#btnr-setting-password').click(function() {
            $('#form-setting-password')[0].reset();
        });

    });
</script>
@endsection