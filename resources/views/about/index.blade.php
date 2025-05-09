@extends('layouts.app')

@section('content-app')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h5 class="card-title mb-1">Informasi Sistem</h5>
                    <p class="text-muted mb-3">Detail tentang software Sky LIS</p>

                    <table class="table table-borderless">
                        <tbody>
                            <tr class="border-bottom">
                                <th scope="row" style="width: 40%" class="px-0">Versi Perangkat Lunak</th>
                                <td class="px-0">Versi 1.0</td>
                            </tr>
                            <tr class="border-bottom">
                                <th scope="row" class="px-0">Tipe Lisensi</th>
                                <td  class="px-0">Lisensi Standar</td>
                            </tr>
                            <tr class="border-bottom">
                                <th scope="row" class="px-0">Terakhir Diperbarui</th>
                                <td class="px-0">15 Mei 2023</td>
                            </tr>
                            <tr class="border-bottom">
                                <th scope="row" class="px-0">Protokol yang Didukung</th>
                                <td class="px-0">HL7</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
