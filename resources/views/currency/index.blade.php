@extends('app')

@section('title', $title)

@section('header')
    @parent
@endsection

@section('content')
    <div class="row">
        @foreach ($indexCurrencies as $currency)
            <div class="col-md-6">
                <div class="info-box currency-block-wrapper">
                    <span class="info-box-icon bg-primary">
                        <i class="fa fa-{{ substr(strtolower($currency['CharCode']), 0, 3) }}"></i>
                    </span>

                    <div class="info-box-content">
                        <div class="currency-block border-right text-center">
                            <h5 class="currency-value">{{ $currency['Value'] }}</h5>
                            <div class="currency-percentage text-red">
                                <i class="fa fa-caret-left"></i> 0%
                            </div>
                        </div>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Изменения курса $ (Доллар США)</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <div class="btn-group">
                            <button class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown"><i class="fa fa-wrench"></i></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </div>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="chart">
                                <!-- Sales Chart Canvas -->
                                <span>

                                </span>
                                <div id="chartdiv" data-end-date="{{ $chartEndDate }}" data-start-date="{{ $chartEndDate }}" data-load-url="{{ route('api::dinamic', ['date1' => $chartStartDate, 'date2' => $chartEndDate]) }}"
                                ></div>
                            </div><!-- /.chart-responsive -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="btn-group">
                                @foreach($dates as $key => $date)
                                    <button type="button" class="btn btn-default changeChartPeriod" data-chart-period="{{ $date['period']}}" data-chart-count="{{ $date['count'] }})">{{ $key }}</button>
                                @endforeach
                            </div>
                        </div>
                    </div><!-- /.row -->
                </div><!-- ./box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

    @include('currency.table', ['currencies' => $dailyCurrencies])
@endsection

@section('footer_scripts')
    @parent
    <!-- FastClick -->
    <script src="/adminlte/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- Sparkline -->
    <script src="/adminlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- ChartJS -->
    <script src="/adminlte/bower_components/chart.js/Chart.js"></script>
    <!-- AmCharts 3 -->
    <script src="/js/amcharts3.js"></script>

    <!-- daterangepicker -->
    <script src="/adminlte/bower_components/moment/min/moment.min.js"></script>
    <script src="/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/adminlte/dist/js/demo.js"></script>
    <!-- Detail js chart currency -->
    <script src="/js/detail-chart.js"></script>
@endsection
