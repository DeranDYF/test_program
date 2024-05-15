@extends('layouts.app')
@section('content')

<div class="modal fade" id="modal-filter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Modal Filter</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="post" class="space-y-4" id="form-filter">
                    {{ csrf_field() }}
                    <div class="row g-6 mb-6">
                        <div class="col-md-6 col-xl-6">
                            <div class="form-floating form-floating-outline mb-2">
                                <input class="form-control dob-picker" type="date" id="tanggal-awal" />
                                <label for="tanggal-awal">Tanggal Awal</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-6">
                            <div class="form-floating form-floating-outline mb-2">
                                <input class="form-control dob-picker" type="date" id="tanggal-akhir" />
                                <label for="tanggal-akhir">Tanggal Akhir</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating form-floating-outline">
                        <select id="filter-customer" class="select2 form-select form-select-lg" data-allow-clear="true">
                            <option value="" selected>Pilih Customer</option>
                            @foreach ($customer as $cr)
                            <option value="{{ $cr->nama }}">{{ $cr->nama }}</option>
                            @endforeach
                        </select>

                        <label for="Customer">Customer</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="reset" class="btn btn-outline-secondary">
                    Reset
                </button>
                <button type="button" data-bs-dismiss="modal" class="btn btn-primary">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-6 mb-6">
        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="me-1">
                            <p class="text-heading mb-1">Total Customer</p>
                            <div class="d-flex align-items-center">
                                <h4 class="mb-1 me-2">{{ $customer_count }}</h4>
                            </div>
                        </div>
                        <div class="avatar">
                            <div class="avatar-initial bg-label-primary rounded-3">
                                <div class="ri-group-line ri-26px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="me-1">
                            <p class="text-heading mb-1">Total Barang</p>
                            <div class="d-flex align-items-center">
                                <h4 class="mb-1 me-1">{{ $barang_count }}</h4>
                            </div>
                        </div>
                        <div class="avatar">
                            <div class="avatar-initial bg-label-danger rounded-3">
                                <div class="ri-shopping-bag-3-line ri-26px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="me-1">
                            <p class="text-heading mb-1">Total Transaksi</p>
                            <div class="d-flex align-items-center">
                                <h4 class="mb-1 me-1">{{ $transaksi_count }}</h4>
                            </div>
                        </div>
                        <div class="avatar">
                            <div class="avatar-initial bg-label-success rounded-3">
                                <div class="ri-bill-line ri-26px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar Transaksi</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-filter">
                    Filter
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
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>



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
            ],

        });

        $('#filter-customer').on('change', function(e) {
            var selectedValue = $(this).val();
            transaksi.column(3).search(selectedValue).draw();
        });

        $('#reset').on('click', function(e) {
            $('#tanggal-awal').val('');
            $('#tanggal-akhir').val('');
            $('#filter-customer').val('').trigger('change');
            transaksi.ajax.reload();
        });

        $('#tanggal-awal, #tanggal-akhir').on('change', function() {
            var minDateStr = $('#tanggal-awal').val();
            var maxDateStr = $('#tanggal-akhir').val();

            // Konversi format tanggal dari 'YYYY-MM-DD' ke 'DD MMMM YYYY'
            var min = moment(minDateStr, 'YYYY-MM-DD').format('DD MMMM YYYY');
            var max = moment(maxDateStr, 'YYYY-MM-DD').format('DD MMMM YYYY');

            // Pastikan tanggal yang diubah benar-benar valid
            if (!moment(minDateStr, 'YYYY-MM-DD', true).isValid() || !moment(maxDateStr, 'YYYY-MM-DD', true).isValid()) {
                // Tangani kasus tanggal tidak valid
                return;
            }

            // Lakukan filter pada kolom tanggal di sini
            transaksi.column(2).search(min + ' | ' + max).draw();
        });







    });
</script>
@endsection