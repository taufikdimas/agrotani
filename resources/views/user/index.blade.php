@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

 <div class="card mt-4">
        <div class="card-header border-bottom">
            <div class="row align-items-center g-3 mt-3">
                <div class="col-md-7">
                    <input type="text" id="search_user" class="form-control" placeholder="Cari Nama/Username/Role" aria-label="Search User">
                </div>
                <div class="col-md-2">
                    <select id="select_per_page" class="form-select w-100" aria-label="Select number of items">
                        <option selected value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="col-md-3 text-end">
                    <button type="button" class="btn btn-primary w-100" id="createUserBtn" onclick="modalAction('{{ url('user/create') }}')">
                        <i class="bx bx-plus me-1"></i> Tambah User
                    </button>
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="list_user" class="table-border-bottom-0">
                    <!-- Data akan diisi oleh AJAX -->
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div id="paginationContainer">
                <!-- Pagination akan diisi oleh AJAX -->
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true">
    </div>
@endsection

@push('scripts')
<script>
    // Base URL untuk memudahkan
    const baseUrl = "{{ url('/') }}";

    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    $(document).ready(function() {
        function loadUsers(page = 1) {
            $.ajax({
                url: baseUrl + "/user",
                method: "GET",
                data: {
                    search: $('#search_user').val(),
                    per_page: $('#select_per_page').val(),
                    page: page,
                    ajax: true
                },
                success: function(res) {
                    let html = '';
                    if (res.users && res.users.length > 0) {
                        $.each(res.users, function(index, user) {
                            html += `
                                <tr>
                                    <td>${user.nama}</td>
                                    <td>${user.username}</td>
                                    <td>••••••••</td>
                                    <td>${user.role}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="icon-base bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="modalAction('${baseUrl}/user/${user.id}/edit')">
                                                    <i class="icon-base bx bx-edit-alt me-1"></i> Edit
                                                </a>
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="modalAction('${baseUrl}/user/${user.id}/delete')">
                                                    <i class="icon-base bx bx-trash me-1"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        html = '<tr><td colspan="5" class="text-center">Tidak ada data ditemukan</td></tr>';
                    }

                    $('#list_user').html(html);
                    
                    // Update pagination jika ada
                    if (res.pagination) {
                        $('#paginationContainer').html(res.pagination);
                    }
                },
                error: function(err) {
                    console.log(err);
                    alert('Terjadi kesalahan saat memuat data');
                }
            });
        }

        // Panggil pertama kali
        loadUsers();

        // Event change filter dan search
        $('#select_per_page').on('change', function() {
            loadUsers();
        });

        $('#search_user').on('keyup', function() {
            loadUsers();
        });

        // Handle klik pagination
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            loadUsers(page);
        });
    });

        $(document).on('submit', 'form', function(e) {
            $('#myModal').modal('hide');
            e.preventDefault();
            let form = $(this);
            let url = form.attr('action');
            let method = form.attr('method');
            let data = new FormData(this);

            $.ajax({
                url: url,
                type: method,
                data: data,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.status) {
                        $('#myModal').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });

                        setTimeout(function() {
                            loadUsers();
                        }, 2100);

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: res.message
                        });

                        if (res.msgField) {
                            $('.error-text').text('');
                            $.each(res.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                        }
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat mengirim data.'
                    });
                }
            });
        });
    </script>
@endpush