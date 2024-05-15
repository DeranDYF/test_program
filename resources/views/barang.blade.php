@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Barang</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal-tambah-barang">
                    Tambah
                </button>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="table" id="barang">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama barang</th>
                        <th>Harga Barang</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Modal Tambah barang -->
<div class="modal fade" id="modal-tambah-barang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Modal Tambah barang</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="post" class="space-y-4" id="form-tambah-barang" entype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-floating form-floating-outline mb-5">
                        <input class="form-control" type="text" id="tambah-nama-barang" name="tambah-nama-barang"
                            value="" placeholder="" required />
                        <label for="tambah-nama-barang">Nama Barang</label>
                    </div>
                    <div class="input-group input-group-merge mb-5">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="tambah-harga-barang" name="tambah-harga-barang" class="form-control"
                                value="" placeholder="" required />
                            <label for="tambah-harga-barang">Harga Barang</label>
                        </div>
                        <span class="input-group-text">IDR</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" id="btn-tambah-barang" class="btn btn-primary">Tambah</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Tambah barang -->

<!-- Modal Edit barang -->
<div class="modal fade" id="modal-edit-barang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Modal Edit barang</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="post" class="space-y-4" id="form-edit-barang" entype="multipart/form-data">
                    {{ csrf_field() }}
                    <input class="form-control" type="hidden" id="edit-id-barang" name="edit-id-barang" value=""
                        placeholder="" required />
                    <div class="form-floating form-floating-outline mb-5">
                        <input class="form-control" type="text" id="edit-nama-barang" name="edit-nama-barang" value=""
                            placeholder="" required />
                        <label for="edit-nama-barang">Nama Barang</label>
                    </div>
                    <div class="input-group input-group-merge mb-5">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="edit-harga-barang" name="edit-harga-barang" class="form-control"
                                value="" placeholder="" required />
                            <label for="edit-harga-barang">Harga Barang</label>
                        </div>
                        <span class="input-group-text">IDR</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" id="btn-edit-barang" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Edit barang -->
<script>
$(document).ready(function() {
    moment.locale('id')
    var barang = $("#barang").DataTable({
        "language": {
            "lengthMenu": "Show _MENU_"
        },
        ajax: {
            url: "{{ route('get_barang')}}",
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
                data: "harga",
                render: function(data, type, row) {
                    let formattedNumber = data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    return '<p class="table-td">Rp. ' + formattedNumber + '</p>';
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
                        '" class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#modal-edit-barang">' +
                        '<i class="ri-pencil-line me-1"></i> Edit</button>' +
                        '<button data-id="' + row.id +
                        '" class="dropdown-item" id="btn-delete-barang">' +
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

    $('#modal-tambah-barang').on('hide.bs.modal', function(e) {
        $('#form-tambah-barang')[0].reset();
    });

    $('#tambah-harga-barang').on('input', function() {
        var input = $(this);
        var value = input.val();
        value = value.replace(/\D/g, '');
        if (value) {
            value = parseInt(value, 10).toLocaleString('id-ID');
        }
        input.val(value);
    });

    $('#btn-tambah-barang').click(function() {
        let button = $(this);
        button.prop('disabled', true);
        button.html(
            "<span class='spinner-border spinner-border-sm me-1' user='status' aria-hidden='true'></span> Please wait..."
        );
        let valid = true;
        let msg = '';
        $('#form-tambah-barang :input[required]').each(function(index, element) {
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
            let form_data = new FormData($('#form-tambah-barang')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('tambah_barang')}}",
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
                        barang.ajax.reload();
                        $('#modal-tambah-barang').modal('hide');
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

    $('#modal-edit-barang').on('shown.bs.modal', function(e) {
        let id = $(e.relatedTarget).data('id');
        $.ajax({
            type: "GET",
            url: "{{ url('get_barang_by') }}" + '/' + id,
            dataType: "json",
            success: function(response) {
                $('#edit-id-barang').val(response.id);
                $('#edit-nama-barang').val(response.nama);
                $('#edit-harga-barang').val(response.harga);
            }
        });
        $('#edit-harga-barang').on('input', function() {
            var input = $(this);
            var value = input.val();
            value = value.replace(/\D/g, '');
            if (value) {
                value = parseInt(value, 10).toLocaleString('id-ID');
            }
            input.val(value);
        });
    });

    $('#modal-edit-barang').on('hide.bs.modal', function(e) {
        $('#form-edit-barang')[0].reset();
    });

    $('#btn-edit-barang').click(function() {
        let button = $(this);
        button.prop('disabled', true);
        button.html(
            "<span class='spinner-border spinner-border-sm me-1' user='status' aria-hidden='true'></span> Please wait..."
        );
        let valid = true;
        let msg = '';
        $('#form-edit-barang :input[required]').each(function(index, element) {
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
            let form_data = new FormData($('#form-edit-barang')[0]);

            $.ajax({
                type: "POST",
                url: "{{ route('edit_barang')}}",
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
                        barang.ajax.reload();
                        $('#modal-edit-barang').modal('hide');
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

    $('body').on('click', '#btn-delete-barang', function() {
        let button = $(this);
        button.prop('disabled', true);
        let id = $(this).data('id');

        Swal.fire({
            title: "Apakah Anda Yakin?",
            text: "Data barang yang dihapus tidak dapat kembali!",
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
                    url: "{{ url('delete_barang') }}" + '/' + id,
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
                        barang.ajax.reload();
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