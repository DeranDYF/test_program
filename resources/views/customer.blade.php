@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Customer</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah-customer">
                    Tambah
                </button>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="table" id="customer">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Customer</th>
                        <th>Telepon</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Modal Tambah Customer -->
<div class="modal fade" id="modal-tambah-customer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Modal Tambah Customer</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="post" class="space-y-4" id="form-tambah-customer" entype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-floating form-floating-outline mb-5">
                        <input class="form-control" type="text" id="tambah-nama-customer" name="tambah-nama-customer" value="" placeholder="" required />
                        <label for="tambah-nama-customer">Nama Customer</label>
                    </div>
                    <div class="input-group input-group-merge mb-5">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="tambah-telepon-customer" name="tambah-telepon-customer" class="form-control" value="" placeholder="" required />
                            <label for="tambah-telepon-customer"> Telepon</label>
                        </div>
                        <span class="input-group-text">ID (+62)</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" id="btn-tambah-customer" class="btn btn-primary">Tambah</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Tambah Customer -->

<!-- Modal Edit Customer -->
<div class="modal fade" id="modal-edit-customer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Modal Edit Customer</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="post" class="space-y-4" id="form-edit-customer" entype="multipart/form-data">
                    {{ csrf_field() }}
                    <input class="form-control" type="hidden" id="edit-id-customer" name="edit-id-customer" value="" placeholder="" required />
                    <div class="form-floating form-floating-outline mb-5">
                        <input class="form-control" type="text" id="edit-nama-customer" name="edit-nama-customer" value="" placeholder="" required />
                        <label for="edit-nama-customer">Nama Customer</label>
                    </div>
                    <div class="input-group input-group-merge mb-5">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="edit-telepon-customer" name="edit-telepon-customer" class="form-control" value="" placeholder="" />
                            <label for="edit-telepon-customer"> Telepon</label>
                        </div>
                        <span class="input-group-text">ID (+62)</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" id="btn-edit-customer" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Edit Customer -->
<script>
    $(document).ready(function() {
        moment.locale('id')
        var customer = $("#customer").DataTable({
            "language": {
                "lengthMenu": "Show _MENU_"
            },
            ajax: {
                url: "{{ route('get_customer')}}",
                type: "GET",
                dataSrc: "",
            },
            columns: [{
                    data: "kode",
                    render: function(data, type, row) {
                        return '<p class="table-td">' + data + '</p>';
                    }
                },
                {
                    data: "nama",
                    render: function(data, type, row) {
                        return '<p class="table-td">' + data + '</p>';
                    }
                },
                {
                    data: "telp",
                    render: function(data, type, row) {
                        if (data) {
                            return '<p class="table-td">' + data + '</p>';
                        } else {
                            return '<p class="table-td"></p>';
                        }
                    }
                },
                {
                    data: 'created_at',
                    render: function(data, type, row) {
                        return '<div>' + moment(data).format('DD MMMM YYYY') +
                            '</div><div class="text-muted fs-6">' + moment(data)
                            .format(
                                'H:m:s')
                        '</div>';
                    },
                },
                {
                    render: function(data, type, row) {
                        var btn =
                            '<div class="dropdown">' +
                            '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                            '<i class="ri-more-2-line"></i>' +
                            '</button>' +
                            '<div class="dropdown-menu">' +
                            '<button data-id="' + row.id +
                            '" class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#modal-edit-customer">' +
                            '<i class="ri-pencil-line me-1"></i> Edit</button>' +
                            '<button data-id="' + row.id +
                            '" class="dropdown-item" id="btn-delete-customer">' +
                            '<i class="ri-delete-bin-7-line me-1"></i> Delete</button>' +
                            '</div>' +
                            '</div>';
                        return btn;
                    },
                    className: 'text-center',
                    sortable: false
                }
            ],

        });

        $('#modal-tambah-customer').on('hide.bs.modal', function(e) {
            $('#form-tambah-customer')[0].reset();
        });


        $('#btn-tambah-customer').click(function() {
            let button = $(this);
            button.prop('disabled', true);
            button.html(
                "<span class='spinner-border spinner-border-sm me-1' user='status' aria-hidden='true'></span> Please wait..."
            );
            let valid = true;
            let msg = '';
            $('#form-tambah-customer :input[required]').each(function(index, element) {
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
                let form_data = new FormData($('#form-tambah-customer')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ route('tambah_customer')}}",
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
                            customer.ajax.reload();
                            $('#modal-tambah-customer').modal('hide');
                            button.prop('disabled', false);
                            button.text('Tambah');
                        } else {
                            toastr.error(response.msg, "Kesalahan!", {
                                progressBar: true
                            });
                            button.prop('disabled', false);
                            button.text('Tambah');
                        }
                    }
                });
            } else {
                button.prop('disabled', false);
                button.text('Tambah');
                toastr.error(msg, "Kesalahan!", {
                    progressBar: true
                });
            }
        });

        $('#modal-edit-customer').on('shown.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');
            $.ajax({
                type: "GET",
                url: "{{ url('get_customer_by') }}" + '/' + id,
                dataType: "json",
                success: function(response) {
                    $('#edit-id-customer').val(response.id);
                    $('#edit-nama-customer').val(response.nama);
                    $('#edit-telepon-customer').val(response.telp);
                }
            });
        });

        $('#modal-edit-customer').on('hide.bs.modal', function(e) {
            $('#form-edit-customer')[0].reset();
        });

        $('#btn-edit-customer').click(function() {
            let button = $(this);
            button.prop('disabled', true);
            button.html(
                "<span class='spinner-border spinner-border-sm me-1' user='status' aria-hidden='true'></span> Please wait..."
            );
            let valid = true;
            let msg = '';
            $('#form-edit-customer :input[required]').each(function(index, element) {
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
                let form_data = new FormData($('#form-edit-customer')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ route('edit_customer')}}",
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
                            customer.ajax.reload();
                            $('#modal-edit-customer').modal('hide');
                            button.prop('disabled', false);
                            button.text('Edit');
                        } else {
                            toastr.error(response.msg, "Kesalahan!", {
                                progressBar: true
                            });
                            button.prop('disabled', false);
                            button.text('Edit');
                        }
                    }
                });
            } else {
                button.prop('disabled', false);
                button.text('Edit');
                toastr.error(msg, "Kesalahan!", {
                    progressBar: true
                });
            }
        });

        $('body').on('click', '#btn-delete-customer', function() {
            let button = $(this);
            button.prop('disabled', true);
            let id = $(this).data('id');

            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Data customer yang dihapus tidak dapat kembali!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus!",
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('delete_customer') }}" + '/' + id,
                        dataType: "JSON",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.msg, "Success", {
                                    progressBar: true
                                });
                            } else {
                                toastr.error(response.msg, "Failed", {
                                    progressBar: true
                                });
                            }
                            button.prop('disabled', false);
                            customer.ajax.reload();
                        },
                        error: function() {
                            toastr.error("Terjadi kesalahan pada server.", "Error", {
                                progressBar: true
                            });
                            button.prop('disabled', false);
                        }
                    });
                } else {
                    button.prop('disabled', false);
                }
            });
        });

    });
</script>
@endsection