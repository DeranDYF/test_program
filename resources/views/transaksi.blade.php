@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Transaksi</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah-transaksi">
                    Tambah
                </button>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="table" id="transaksi">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No transaksi</th>
                        <th>Tanggal</th>
                        <th>Nama Customer</th>
                        <th>Jumlah Barang</th>
                        <th>Sub Total</th>
                        <th>Diskon</th>
                        <th>Ongkos Kirim</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- Modal Tambah transaksi -->
<div class="modal fade" id="modal-tambah-transaksi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalFullTitle">Tambah Transaksi</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="post" class="space-y-4" id="form-tambah-transaksi" entype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row g-6 mb-6">
                        <div class="col-md-6 col-xl-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input class="form-control" type="date" id="html5-date-input" name="tambah-tanggal-transaksi" required />

                                <label for="html5-date-input">Tanggal</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <select class="form-select" id="tambah-daftar-customer-transaksi" name="tambah-daftar-customer-transaksi" aria-label="Default select example" required>
                                    <option value="" selected>Pilih Customer</option>
                                </select>
                                <label for="exampleFormControlSelect1">Customer</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <select class="form-select" id="tambah-daftar-barang-transaksi" aria-label="Default select example">
                                    <option value="" selected>Pilih Barang</option>
                                </select>
                                <label for="exampleFormControlSelect1">Barang</label>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive text-nowrap mb-2">
                        <table class="table table-bordered" id="tabel-tambah-transaksi">
                            <thead>
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Kode Barang</th>
                                    <th rowspan="2">Nama Barang</th>
                                    <th rowspan="2">Qty</th>
                                    <th rowspan="2">Harga Bandrol</th>
                                    <th colspan="2">Diskon</th>
                                    <th rowspan="2">Harga Diskon</th>
                                    <th rowspan="2">Total</th>
                                    <th rowspan="2"></th>
                                </tr>
                                <tr>
                                    <th>%</th>
                                    <th>(Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="row g-6 mb-6">
                        <div class="col-md-6 col-xl-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input class="form-control" type="text" id="tambah-subtotal-transaksi" name="tambah-subtotal-transaksi" readonly />
                                <label for="tambah-subtotal-transaksi">Subtotal</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input class="form-control" type="text" id="tambah-diskon-transaksi" value="0" name="tambah-diskon-transaksi" />
                                <label for="diskon-transaksi">Diskon</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-6 mb-6">
                        <div class="col-md-6 col-xl-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input class="form-control" type="text" id="tambah-ongkir-transaksi" value="0" name="tambah-ongkir-transaksi" />
                                <label for="ongkir-transaksi">Ongkir</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input class="form-control" type="text" id="tambah-total-bayar-transaksi" value="" name="tambah-total-bayar-transaksi" readonly />
                                <label for="total-bayar-transaksi">Total Bayar</label>
                            </div>
                        </div>
                        <input class="form-control" type="hidden" id="tambah-jumlah-barang" value="" name="tambah-jumlah-barang" readonly />
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary" id="btn-tambah-transaksi">Tambah</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Tambah transaksi -->

<!-- Modal edit transaksi -->
<div class="modal fade" id="modal-edit-transaksi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalFullTitle">Edit Transaksi</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="post" class="space-y-4" id="form-edit-transaksi" entype="multipart/form-data">
                    {{ csrf_field() }}
                    <input class="form-control" type="hidden" id="edit-id-transaksi" name="edit-id-transaksi" required readonly />
                    <div class="row g-6 mb-6">
                        <div class="col-md-6 col-xl-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input class="form-control dob-picker" type="date" id="edit-tanggal-transaksi" name="edit-tanggal-transaksi" required />
                                <label for="edit-tanggal-transaksi">Tanggal</label>
                            </div>

                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input class="form-control" type="text" id="edit-daftar-customer-transaksi" name="edit-daftar-customer-transaksi" required readonly />
                                <label for="edit-daftar-customer-transaksi">Customer</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <select class="form-select" id="edit-daftar-barang-transaksi" aria-label="Default select example">
                                    <option value="" selected>Pilih Barang</option>
                                </select>
                                <label for="edit-daftar-barang-transaksi">Barang</label>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive text-nowrap mb-2">
                        <table class="table table-bordered" id="tabel-edit-transaksi">
                            <thead>
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Kode Barang</th>
                                    <th rowspan="2">Nama Barang</th>
                                    <th rowspan="2">Qty</th>
                                    <th rowspan="2">Harga Bandrol</th>
                                    <th colspan="2">Diskon</th>
                                    <th rowspan="2">Harga Diskon</th>
                                    <th rowspan="2">Total</th>
                                    <th rowspan="2"></th>
                                </tr>
                                <tr>
                                    <th>%</th>
                                    <th>(Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="row g-6 mb-6">
                        <div class="col-md-6 col-xl-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input class="form-control" type="text" id="edit-subtotal-transaksi" name="edit-subtotal-transaksi" readonly />
                                <label for="edit-subtotal-transaksi">Subtotal</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input class="form-control" type="text" id="edit-diskon-transaksi" value="0" name="edit-diskon-transaksi" />
                                <label for="edit-diskon-transaksi">Diskon</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-6 mb-6">
                        <div class="col-md-6 col-xl-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input class="form-control" type="text" id="edit-ongkir-transaksi" value="0" name="edit-ongkir-transaksi" />
                                <label for="edit-ongkir-transaksi">Ongkir</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="form-floating form-floating-outline mb-3">
                                <input class="form-control" type="text" id="edit-total-bayar-transaksi" value="" name="edit-total-bayar-transaksi" readonly />
                                <label for="edit-total-bayar-transaksi">Total Bayar</label>
                            </div>
                        </div>
                        <input class="form-control" type="hidden" id="edit-jumlah-barang" value="" name="edit-jumlah-barang" readonly />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary" id="btn-edit-transaksi">edit</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal edit transaksi -->

<script>
    $(document).ready(function() {
        moment.locale('id')
        var transaksi = $("#transaksi").DataTable({
            "language": {
                "lengthMenu": "Show _MENU_"
            },
            ajax: {
                url: "{{ route('get_transaksi')}}",
                type: "GET",
                dataSrc: "",
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return '<p class="table-td">' + (meta.row + 1) + '</p>';
                    }
                },
                {
                    data: "kode",
                    render: function(data, type, row) {
                        return '<p class="table-td">' + moment(row.tgl).format('YYYYMMDD') + '-' + data + '</p>';
                    }
                },
                {
                    data: "tgl",
                    render: function(data, type, row) {
                        return '<p>' + moment(data).format('DD MMMM YYYY') +
                            '</p>';
                    },
                },
                {
                    data: "nama_customer",
                    render: function(data, type, row) {
                        return '<p class="fw-bold">' + data + '</p>';
                    }
                },
                {
                    data: "jumlah_barang",
                    render: function(data, type, row) {
                        return '<p class="table-td">' + data + '</p>';
                    }
                },
                {
                    data: "subtotal",
                    render: function(data, type, row) {
                        let formattedNumber = data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        return '<p class="table-td">Rp. ' + formattedNumber + '</p>';
                    }
                },
                {
                    data: "diskon",
                    render: function(data, type, row) {
                        let formattedNumber = data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        return '<p class="table-td">Rp. ' + formattedNumber + '</p>';
                    }
                },
                {
                    data: "ongkir",
                    render: function(data, type, row) {
                        let formattedNumber = data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        return '<p class="table-td">Rp. ' + formattedNumber + '</p>';
                    }
                },
                {
                    data: "total_bayar",
                    render: function(data, type, row) {
                        let formattedNumber = data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        return '<p class="table-td">Rp. ' + formattedNumber + '</p>';
                    }
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
                            '" class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#modal-edit-transaksi">' +
                            '<i class="ri-pencil-line me-1"></i> Edit</button>' +
                            '<button data-id="' + row.id +
                            '" class="dropdown-item" id="btn-delete-transaksi">' +
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

        $.ajax({
            type: "GET",
            url: "{{ url('get_customer') }}",
            dataType: 'json',
            success: function(data) {
                $.each(data, function(key, value) {
                    var option = $("<option></option>")
                        .attr("value", value.id)
                        .text(value.nama);
                    $('#tambah-daftar-customer-transaksi').append(option);
                });
            }
        });

        $.ajax({
            type: "GET",
            url: "{{ url('get_barang') }}",
            dataType: 'json',
            success: function(data) {
                $.each(data, function(key, value) {
                    var option = $("<option></option>")
                        .attr("value", value.id)
                        .text(value.nama)
                        .data("id", value.id)
                        .data("kode", value.kode)
                        .data("harga", value.harga);
                    $('#tambah-daftar-barang-transaksi').append(option);
                });
            }
        });

        $('#tambah-daftar-barang-transaksi').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var id = selectedOption.data('id');
            var kode = selectedOption.data('kode');
            var nama = selectedOption.text();
            var hargaBandrol = selectedOption.data('harga');
            var formattedHargaBandrol = formatRupiah(hargaBandrol);

            var newRow = `
            <tr>
                <td>${$('#tabel-tambah-transaksi tbody tr').length + 1}</td>
                <td><input class="form-control" type="hidden" id="kode-barang" value="${id}" name="tambah-kode-barang[]" readonly />${kode}</td>
                <td>${nama}</td>
                <td><input type="number" class="form-control qty" min="1" name="tambah-qty[]" value="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required></td>
                <td>${formatRupiah(hargaBandrol)}</td>
                <td><input type="number" class="form-control diskon-persen" min="0" name="tambah-diskon[]" onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="0"></td>
                <td class="diskon-rp" data-value="0">0</td>
                <td class="harga-diskon" name="tambah-harga-diskon[]" data-value="${hargaBandrol}">${formattedHargaBandrol}</td>
                <td class="total" name="tambah-total[]" data-value="${hargaBandrol}">${formattedHargaBandrol}</td>
                <td><button type="button" class="btn btn-icon btn-danger delete-row"><i class="ri-close-line"></i></button></td>
            </tr>
        `;

            $('#tabel-tambah-transaksi tbody').append(newRow);
            tambahUpdateCalculations();
            tambahUpdateTotalBayar();
            tambahUpdateJumlahBarang();
        });

        $('#tabel-tambah-transaksi').on('input', '.qty, .diskon-persen', function() {
            tambahUpdateCalculations();

        });

        $('#tabel-tambah-transaksi').on('click', '.delete-row', function() {
            $(this).closest('tr').remove();
            tambahUpdateRowNumbers();
            tambahUpdateCalculations();
            tambahUpdateTotalBayar();
        });

        function tambahUpdateCalculations() {
            $('#tabel-tambah-transaksi tbody tr').each(function() {
                var $row = $(this);
                var hargaBandrol = parseFloat($row.find('td:eq(4)').text().replace(/\./g, ''));
                var qty = parseFloat($row.find('.qty').val());
                var diskonPersen = parseFloat($row.find('.diskon-persen').val());

                var diskonRp = hargaBandrol * diskonPersen / 100;
                var hargaDiskon = hargaBandrol - diskonRp;
                var total = hargaDiskon * qty;

                $row.find('.diskon-rp').data('value', diskonRp).text(formatRupiah(diskonRp));
                $row.find('.harga-diskon').data('value', hargaDiskon).text(formatRupiah(hargaDiskon));
                $row.find('.total').data('value', total).text(formatRupiah(total));
            });
            tambahUpdateSubtotal();
        }

        function tambahUpdateRowNumbers() {
            $('#tabel-tambah-transaksi tbody tr').each(function(index) {
                $(this).find('td:eq(0)').text(index + 1);
            });
        }

        $('#tambah-diskon-transaksi, #tambah-ongkir-transaksi').on('input', function() {
            var input = $(this);
            var value = input.val();
            value = value.replace(/\D/g, '');
            if (value) {
                value = parseInt(value, 10).toLocaleString('id-ID');
            }
            input.val(value);
        });

        $('#tabel-tambah-transaksi, #tambah-diskon-transaksi, #tambah-ongkir-transaksi').on('input', function() {
            tambahUpdateSubtotal();
            tambahUpdateTotalBayar();
        });

        function tambahUpdateJumlahBarang() {
            var jumlahBarang = $('#tabel-tambah-transaksi tbody tr').length;
            $('#tambah-jumlah-barang').val(jumlahBarang);
        }

        function tambahUpdateSubtotal() {
            var subtotal = 0;
            $('#tabel-tambah-transaksi tbody tr').each(function() {
                var total = parseFloat($(this).find('.total').data('value'));
                subtotal += total;
            });
            $('#tambah-subtotal-transaksi').val(formatRupiah(subtotal));
        }

        function tambahUpdateTotalBayar() {
            var subtotal = parseFloat($('#tambah-subtotal-transaksi').val().replace(/\./g, ''));
            var ongkir = parseFloat($('#tambah-ongkir-transaksi').val().replace(/\./g, '')) || 0;
            var diskon = parseFloat($('#tambah-diskon-transaksi').val().replace(/\./g, '')) || 0;

            var totalBayar = subtotal - diskon + ongkir;
            $('#tambah-total-bayar-transaksi').val(formatRupiah(totalBayar));
        }

        function formatRupiah(angka) {
            return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        $('#modal-tambah-transaksi').on('hide.bs.modal', function(e) {
            $('#form-tambah-transaksi')[0].reset();
            $('#tabel-tambah-transaksi tbody').empty();
            tambahUpdateSubtotal();
            tambahUpdateJumlahBarang();
        });

        $('#btn-tambah-transaksi').click(function() {
            let button = $(this);
            button.prop('disabled', true);
            button.html(
                "<span class='spinner-border spinner-border-sm me-1' user='status' aria-hidden='true'></span> Please wait..."
            );
            let valid = true;
            let msg = '';
            $('#form-tambah-transaksi :input[required]').each(function(index, element) {
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
                let form_data = new FormData($('#form-tambah-transaksi')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ route('tambah_transaksi')}}",
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
                            transaksi.ajax.reload();
                            $('#modal-tambah-transaksi').modal('hide');
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

        $.ajax({
            type: "GET",
            url: "{{ url('get_barang') }}",
            dataType: 'json',
            success: function(data) {
                $.each(data, function(key, value) {
                    var option = $("<option></option>")
                        .attr("value", value.id)
                        .text(value.nama)
                        .data("id", value.id)
                        .data("kode", value.kode)
                        .data("harga", value.harga);
                    $('#edit-daftar-barang-transaksi').append(option);
                });
            }
        });

        $('#modal-edit-transaksi').on('shown.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');
            $.ajax({
                type: "GET",
                url: "{{ url('get_transaksi_by') }}" + '/' + id,
                dataType: "json",
                success: function(response) {
                    $('#edit-id-transaksi').val(response.id);
                    $('#edit-tanggal-transaksi').val(moment(response.tgl).format('YYYY-MM-DD'));
                    $('#edit-daftar-customer-transaksi').val(response.nama_customer);
                    $('#edit-diskon-transaksi').val(formatRupiah(response.diskon));
                    $('#edit-ongkir-transaksi').val(formatRupiah(response.ongkir));
                    var saledets = response.saledets;
                    $('#tabel-edit-transaksi tbody').empty();

                    $.each(saledets, function(index, saledet) {
                        var kode = saledet.barang.kode;
                        var hargaBandrol = saledet.barang.harga;
                        var qty = saledet.qty;
                        var diskon = saledet.diskon_pct;
                        var newRow = `
        <tr>
            <td>${index + 1}</td>
            <td><input class="form-control" type="hidden" value="${saledet.barang_id}" name="edit-kode-barang[]" readonly />${kode}</td>
            <td>${saledet.barang.nama}</td>
            <td><input type="number" class="form-control qty" min="1" name="edit-qty[]" value="${qty}" required></td>
            <td>${formatRupiah(hargaBandrol)}</td>
            <td><input type="number" class="form-control diskon-persen" min="0" value="${diskon}" name="edit-diskon[]"></td>
            <td class="diskon-rp" data-value="0">0</td>
            <td class="harga-diskon" data-value="${hargaBandrol}">${hargaBandrol}</td>
            <td class="total" data-value="${hargaBandrol * qty}">${hargaBandrol * qty}</td>
            <td><button type="button" class="btn btn-icon btn-danger delete-row"><i class="ri-close-line"></i></button></td>
        </tr>
    `;

                        $('#tabel-edit-transaksi tbody').append(newRow);
                        editUpdateCalculations();
                        editUpdateTotalBayar(response);
                        editUpdateJumlahBarang();
                    });
                }
            });

        });

        $('#edit-daftar-barang-transaksi').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var id = selectedOption.data('id');
            var kode = selectedOption.data('kode');
            var nama = selectedOption.text();
            var hargaBandrol = selectedOption.data('harga');
            var formattedHargaBandrol = formatRupiah(hargaBandrol);

            var isNameExists = false;
            $('#tabel-edit-transaksi tbody tr').each(function() {
                var existingNama = $(this).find('td:eq(2)').text();
                if (existingNama === nama) {
                    isNameExists = true;
                    return false;
                }
            });

            if (!isNameExists) {
                var newRow = `
            <tr>
                <td>${$('#tabel-edit-transaksi tbody tr').length + 1}</td>
                <td><input class="form-control" type="hidden" id="edit-kode-barang" value="${id}" name="edit-kode-barang[]" readonly />${kode}</td>
                <td>${nama}</td>
                <td><input type="number" class="form-control qty" min="1" name="edit-qty[]" value="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required></td>
                <td>${formatRupiah(hargaBandrol)}</td>
                <td><input type="number" class="form-control diskon-persen" min="0" name="edit-diskon[]" onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninput="this.value = this.value.replace(/[^0-9]/g, '');" value="0"></td>
                <td class="diskon-rp" data-value="0">0</td>
                <td class="harga-diskon" name="edit-harga-diskon[]" data-value="${hargaBandrol}">${formattedHargaBandrol}</td>
                <td class="total" name="edit-total[]" data-value="${hargaBandrol}">${formattedHargaBandrol}</td>
                <td><button type="button" class="btn btn-icon btn-danger delete-row"><i class="ri-close-line"></i></button></td>
            </tr>
        `;

                $('#tabel-edit-transaksi tbody').append(newRow);
                editUpdateCalculations();
                editUpdateTotalBayar();
                editUpdateJumlahBarang();
            }
        });


        $('#tabel-edit-transaksi').on('input', '.qty, .diskon-persen', function() {
            editUpdateCalculations();
        });

        $('#tabel-edit-transaksi').on('click', '.delete-row', function() {
            $(this).closest('tr').remove();
            editUpdateRowNumbers();
            editUpdateCalculations();
            editUpdateTotalBayar();
            editUpdateJumlahBarang();
        });

        function editUpdateCalculations() {
            $('#tabel-edit-transaksi tbody tr').each(function() {
                var $row = $(this);
                var hargaBandrol = parseFloat($row.find('td:eq(4)').text().replace(/\./g, ''));
                var qty = parseFloat($row.find('.qty').val());
                var diskonPersen = parseFloat($row.find('.diskon-persen').val());

                var diskonRp = hargaBandrol * diskonPersen / 100;
                var hargaDiskon = hargaBandrol - diskonRp;
                var total = hargaDiskon * qty;

                $row.find('.diskon-rp').data('value', diskonRp).text(formatRupiah(diskonRp));
                $row.find('.harga-diskon').data('value', hargaDiskon).text(formatRupiah(hargaDiskon));
                $row.find('.total').data('value', total).text(formatRupiah(total));
            });
            editUpdateSubtotal();
        }

        function editUpdateRowNumbers() {
            $('#tabel-edit-transaksi tbody tr').each(function(index) {
                $(this).find('td:eq(0)').text(index + 1);
            });
        }

        $('#edit-diskon-transaksi, #edit-ongkir-transaksi').on('input', function() {
            var input = $(this);
            var value = input.val();
            value = value.replace(/\D/g, '');
            if (value) {
                value = parseInt(value, 10).toLocaleString('id-ID');
            }
            input.val(value);
        });

        $('#tabel-edit-transaksi, #edit-diskon-transaksi, #edit-ongkir-transaksi').on('input', function() {
            editUpdateSubtotal();
            editUpdateTotalBayar();
        });

        function editUpdateJumlahBarang() {
            var jumlahBarang = $('#tabel-edit-transaksi tbody tr').length;
            $('#edit-jumlah-barang').val(jumlahBarang);
        }

        function editUpdateSubtotal() {
            var subtotal = 0;
            $('#tabel-edit-transaksi tbody tr').each(function() {
                var total = parseFloat($(this).find('.total').data('value'));
                subtotal += total;
            });
            $('#edit-subtotal-transaksi').val(formatRupiah(subtotal));
        }

        function editUpdateTotalBayar() {
            var subtotal = parseFloat($('#edit-subtotal-transaksi').val().replace(/\./g, ''));
            var ongkir = parseFloat($('#edit-ongkir-transaksi').val().replace(/\./g, '')) || 0;
            var diskon = parseFloat($('#edit-diskon-transaksi').val().replace(/\./g, '')) || 0;

            var totalBayar = subtotal - diskon + ongkir;
            $('#edit-total-bayar-transaksi').val(formatRupiah(totalBayar));
        }

        $('#modal-edit-transaksi').on('hide.bs.modal', function(e) {
            $('#form-edit-transaksi')[0].reset();
            $('#tabel-edit-transaksi tbody').empty();
            editUpdateSubtotal();
            editUpdateJumlahBarang();
        });

        $('#btn-edit-transaksi').click(function() {
            let button = $(this);
            button.prop('disabled', true);
            button.html(
                "<span class='spinner-border spinner-border-sm me-1' user='status' aria-hidden='true'></span> Please wait..."
            );
            let valid = true;
            let msg = '';
            $('#form-edit-transaksi :input[required]').each(function(index, element) {
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
                let form_data = new FormData($('#form-edit-transaksi')[0]);

                $.ajax({
                    type: "POST",
                    url: "{{ route('edit_transaksi')}}",
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
                            transaksi.ajax.reload();
                            $('#modal-edit-transaksi').modal('hide');
                            button.prop('disabled', false);
                            button.text('Edit');
                        } else {
                            toastr.error(response.msg, "Kesalahan!", {
                                progressBar: true
                            });
                            console.log(response.msg);
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

        $('body').on('click', '#btn-delete-transaksi', function() {
            let button = $(this);
            button.prop('disabled', true);
            let id = $(this).data('id');

            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Data Transaksi yang dihapus tidak dapat kembali!",
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
                        url: "{{ url('delete_transaksi') }}" + '/' + id,
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
                            transaksi.ajax.reload();
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