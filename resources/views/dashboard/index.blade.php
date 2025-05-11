@extends('layouts.app')

@section('content-app')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-1">
                    <div class="card-body">
                        <h3 class="card-title text-white">Total Pasien</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $total_pasien ?? 0 }}</h2>
                            {{-- <p class="text-white mb-0">Jan - March 2019</p> --}}
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-user"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-2">
                    <div class="card-body">
                        <h3 class="card-title text-white">Total Hasil Lab</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">{{ $total_hasil_lab ?? 0 }}</h2>
                            {{-- <p class="text-white mb-0">Jan - March 2019</p> --}}
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-medkit"></i></span>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-3 col-sm-6">
                <div class="card gradient-3">
                    <div class="card-body">
                        <h3 class="card-title text-white"></h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">4565</h2>
                            <p class="text-white mb-0">Jan - March 2019</p>
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card gradient-4">
                    <div class="card-body">
                        <h3 class="card-title text-white">Customer Satisfaction</h3>
                        <div class="d-inline-block">
                            <h2 class="text-white">99%</h2>
                            <p class="text-white mb-0">Jan - March 2019</p>
                        </div>
                        <span class="float-right display-5 opacity-5"><i class="fa fa-heart"></i></span>
                    </div>
                </div>
            </div> --}}
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Transaksi Berdasarkan Jenis Kelamin</h4>
                        <div id="morris-bar-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Grafik Berdasarkan Usia</h4>
                        <div id="flotPie1" class="flot-chart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="active-member">
                            <div class="table-responsive">
                                <table class="table table-xs mb-0">
                                    <thead>
                                        <tr>
                                            <th>Customers</th>
                                            <th>Product</th>
                                            <th>Country</th>
                                            <th>Status</th>
                                            <th>Payment Method</th>
                                            <th>Activity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><img src="{{ asset('theme') }}/images/avatar/1.jpg"
                                                    class=" rounded-circle mr-3" alt="">Sarah Smith</td>
                                            <td>iPhone X</td>
                                            <td>
                                                <span>United States</span>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="progress" style="height: 6px">
                                                        <div class="progress-bar bg-success" style="width: 50%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><i class="fa fa-circle-o text-success  mr-2"></i> Paid</td>
                                            <td>
                                                <span>Last Login</span>
                                                <span class="m-0 pl-3">10 sec ago</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img src="{{ asset('theme') }}/images/avatar/2.jpg"
                                                    class=" rounded-circle mr-3" alt="">Walter R.</td>
                                            <td>Pixel 2</td>
                                            <td><span>Canada</span></td>
                                            <td>
                                                <div>
                                                    <div class="progress" style="height: 6px">
                                                        <div class="progress-bar bg-success" style="width: 50%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><i class="fa fa-circle-o text-success  mr-2"></i> Paid</td>
                                            <td>
                                                <span>Last Login</span>
                                                <span class="m-0 pl-3">50 sec ago</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img src="{{ asset('theme') }}/images/avatar/3.jpg"
                                                    class=" rounded-circle mr-3" alt="">Andrew D.</td>
                                            <td>OnePlus</td>
                                            <td><span>Germany</span></td>
                                            <td>
                                                <div>
                                                    <div class="progress" style="height: 6px">
                                                        <div class="progress-bar bg-warning" style="width: 50%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><i class="fa fa-circle-o text-warning  mr-2"></i> Pending</td>
                                            <td>
                                                <span>Last Login</span>
                                                <span class="m-0 pl-3">10 sec ago</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img src="{{ asset('theme') }}/images/avatar/6.jpg"
                                                    class=" rounded-circle mr-3" alt=""> Megan S.</td>
                                            <td>Galaxy</td>
                                            <td><span>Japan</span></td>
                                            <td>
                                                <div>
                                                    <div class="progress" style="height: 6px">
                                                        <div class="progress-bar bg-success" style="width: 50%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><i class="fa fa-circle-o text-success  mr-2"></i> Paid</td>
                                            <td>
                                                <span>Last Login</span>
                                                <span class="m-0 pl-3">10 sec ago</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img src="{{ asset('theme') }}/images/avatar/4.jpg"
                                                    class=" rounded-circle mr-3" alt=""> Doris R.</td>
                                            <td>Moto Z2</td>
                                            <td><span>England</span></td>
                                            <td>
                                                <div>
                                                    <div class="progress" style="height: 6px">
                                                        <div class="progress-bar bg-success" style="width: 50%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><i class="fa fa-circle-o text-success  mr-2"></i> Paid</td>
                                            <td>
                                                <span>Last Login</span>
                                                <span class="m-0 pl-3">10 sec ago</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img src="{{ asset('theme') }}/images/avatar/5.jpg"
                                                    class=" rounded-circle mr-3" alt="">Elizabeth W.</td>
                                            <td>Notebook Asus</td>
                                            <td><span>China</span></td>
                                            <td>
                                                <div>
                                                    <div class="progress" style="height: 6px">
                                                        <div class="progress-bar bg-warning" style="width: 50%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><i class="fa fa-circle-o text-warning  mr-2"></i> Pending</td>
                                            <td>
                                                <span>Last Login</span>
                                                <span class="m-0 pl-3">10 sec ago</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('theme') }}/plugins/datamaps/datamaps.world.min.js"></script>

    <script src="{{ asset('theme') }}/plugins/chart.js/Chart.bundle.min.js"></script>
    <script src="{{ asset('theme') }}/plugins/flot/js/jquery.flot.min.js"></script>
    <script src="{{ asset('theme') }}/plugins/flot/js/jquery.flot.pie.js"></script>
    <script src="{{ asset('theme') }}/plugins/flot/js/jquery.flot.resize.js"></script>
    <script src="{{ asset('theme') }}/plugins/flot/js/jquery.flot.spline.js"></script>
    <script src="{{ asset('theme') }}/plugins/flot/js/jquery.flot.init.js"></script>
@endsection
