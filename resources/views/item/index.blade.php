@extends('layouts.app')

@section('title', 'Daftar Barang')
@section('pageHeading', 'Daftar Barang')

@section('content')
    <div class="page-content">
        <section class="section">
            <div class="row" id="table-hover-row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>CODE</th>
                                                <th>NAMA BARANG</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            ?>
                                            @foreach ($items as $item)
                                                <tr>
                                                    <td class="text-bold-500">{{ $no++ }}</td>
                                                    <td>{{ $item->code }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>
                                                        <a href="#">
                                                            <i class="badge-circle badge-circle-light-secondary font-medium-1"
                                                                data-feather="mail"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
