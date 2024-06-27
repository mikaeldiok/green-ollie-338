@extends('backend.layouts.app')

@section('title') @lang("Dashboard") @endsection

@section('breadcrumbs')
<x-backend.breadcrumbs />
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-body">

        <x-backend.section-header>
            @lang("Admin Dashboard")

            <x-slot name="toolbar">
                <button class="btn btn-outline-primary mb-1" type="button" data-toggle="tooltip" data-coreui-placement="top" title="Tooltip">
                    <i class="fa-solid fa-bullhorn"></i>
                </button>
            </x-slot>
        </x-backend.section-header>

        <!-- Dashboard Content Area -->
        <div class="container mt-4">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white" style="background-color: #FD9B63; border-color: #FD9B63;">
                        <div class="card-body">
                            <div class="h2 font-weight-bold">{{ $foodCount }}</div>
                            <div>Jumlah Makanan</div>
                            <a href="/admin/foods" class="btn btn-link text-white p-0 mt-2">Lihat Detail Produk</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3" >
                    <div class="card text-white mb-3" style="background-color: #E7D37F; border-color: #E7D37F;">
                        <div class="card-body">
                            <div class="h2 font-weight-bold">{{ $transactionCount }}</div>
                            <div>PO (Purchase Order)</div>
                            <a href="/admin/transactions" class="btn btn-link text-white p-0 mt-2">Lihat Detail PO</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white" style="background-color: #81A263; border-color: #81A263;">
                        <div class="card-body">
                            <div class="h2 font-weight-bold">{{ $CustomerCount }}</div>
                            <div>Customer</div>
                            <a href="/admin/transactions" class="btn btn-link text-white p-0 mt-2">Lihat Detail Customer</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white mb-3" style="background-color: #365E32; border-color: #365E32;">
                        <div class="card-body">
                            <div class="h2 font-weight-bold">{{ $userCount }}</div>
                            <div>Admin</div>
                            <a href="#" class="btn btn-link text-white p-0 mt-2">Lihat Detail Admin</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Data Produk Table -->
                <div class="col-lg-8 mb-4">
                    <div class="card">
                        <div class="card-header font-weight-bold">Data Produk</div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($menu as $index => $food)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $food->id }}</td>
                                        <td>{{ $food->name }}</td>
                                        <td>Rp. {{ number_format($food->price, 2, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-2">
                                <a href="/admin/foods" class="btn btn-primary">Menu Makanan</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Admin Table -->
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-header font-weight-bold">Data Admin</div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Fullname</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user as $index => $admin)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->first_name }} {{ $admin->last_name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-2">
                                <a href="#" class="btn btn-primary">Menu Admin</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Dashboard Content Area -->

    </div>
</div>

{{-- Demo content --}}
<!-- @include("backend.includes.dashboard_demo_data") -->

@endsection
