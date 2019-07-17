@extends('app')

@section('title', $title)

@section('metaDescription', $metaDescription)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="info-box bg-aqua">
                <span class="info-box-icon">
                    <i class="fa fa-{{ substr(strtolower($currency['CharCode']), 0, 3) }}"></i>
                </span>

                <div class="info-box-content">
                  <span class="info-box-text">{{ $currency['Name'] }}</span>
                  <span class="info-box-number">{{ $currency['Value'] }}</span>

                  <div class="progress">
                        <hr class="progress-bar">
                  </div>
                      <span class="">
                          Номинал: &nbsp; <b style="font-size: 14px;">{{ $currency['Nominal'] }}</b>
                      </span>
                      &nbsp;&nbsp;
                      <span class="">
                          Код валюты: &nbsp; <b style="font-size: 14px;">{{ $currency['NumCode'] }}</b>
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Изменения курса {{ $currency['Name']}}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="chart">
                                <!-- Sales Chart Canvas -->
                                <div id="chartdiv" data-end-date="{{ $chartEndDate }}" data-start-date="{{ $chartEndDate }}" data-load-url="{{ route('api::dinamic', ['date1' => $chartStartDate, 'date2' => $chartEndDate, 'currencyCode' => $currencyCode]) }}" data-currency-code="{{ $currencyCode }}"
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
    <div class="row">
        @if (count($detailCurrency) > 0)
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Изменения за неделю</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    @include('currency.detailTable', ['detailCurrency' => $detailCurrency])
                                </div>
                            </div>
                        </div>
                      <!-- /.row -->
                    </div>
                <!-- ./box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        @endif
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border clearfix">
                    <h3 class="box-title">Выберите дату</h3>
                    <button class="btn btn-sm btn-info btn-flat pull-right chooseDate">Выбрать дату</button>
                </div>
                <div class="box-body">
                     <div class="table-responsive" id="chooseDate">
                        <table class="table table-hover table-striped no-margin">
                            <tbody></tbody>
                        </table>
                     </div>
                </div>
            </div>
        </div>
    </div>
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

    <script type="text/javascript">
        $(function() {
            $('.chooseDate').daterangepicker({
                locale: 'ru',
                singleDatePicker: true,
                showDropdowns: true,
                drops: "down"
            },
            function(start, end, label) {
                var table = $('#chooseDate').find('table tbody');

                $.get('/api/currency/daily/' + moment(start).format('DD-MM-YYYY') + "/{{$currency['CharCode']}}")
                .done(function(data) {
                    var content = "";

                    if (!$.isEmptyObject(data)) {
                        $.each(data, function(i, val) {
                            console.log(val.Value);
                            var value = (val.Value == null) ? "Нет данных" : val.Value;
                            content += "<tr><td>" + moment(start).format('DD.MM.YYYY') + "</td><td><span class='pull-right'>" + value + "</span></td></tr>";
                        });

                    }

                    table.append(content);
                })
                .fail(function(error) {
                    console.error(error);
                });
            });
        });
    </script>
@endsection
