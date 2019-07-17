<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Курсы валют</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    @if (count($currencies) > 0)
                        <div class="table-responsive">
                        <table class="table table-hover table-striped currency-table">
                            <thead>
                                <tr>
                                    <th colspan="2">Валюта</th>
                                    <th style="text-align: right;">Значение <small>(руб)</small></th>
                                    <th style="width: 40px">График</th>
                                </tr>
                            </thead>
                            @foreach ($currencies as $currency)
                                <tr>
                                    <td class="currency-icon currency-key">
                                        <span class="flag flag-{{ substr(strtolower($currency['CharCode']), 0, 2) }} ">&nbsp;</span>
                                        {{ $currency['CharCode'] }}
                                    </td>
                                    <td class="currency-name">
                                        <a href="{{ route('currency::detail', ['currency' => strtolower($currency['CharCode']) ]) }}">
                                            {{ $currency['Name'] }}
                                        </a>
                                        @if ($currency['Nominal'] and $currency['Nominal'] > 1)
                                        <span class="pull-right">Номинал: {{ $currency['Nominal'] }}</span>
                                        @endif
                                    </td>
                                    <td class="currency-value">
                                        <span class="pull-right" data-tooltip="tooltip" title="Toggle">
                                            {{ $currency['Value'] }}
                                        </span>
                                        <span class="pull-left label label-success" data-tooltip="tooltip" title="Toggle">
                                            <i class="fa fa-caret-down"></i>
                                        </span>
                                    </td>
                                    <td class="currency-graph">
                                        <a href="{{ route('currency::detail', ['currency' => strtolower($currency['CharCode']) ]) }}" class="btn btn-xs">
                                            <i class="fa fa-line-chart"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                     @elseif (empty($dailyCurrencies) or !isset($dailyCurrencies))
                        {{-- <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Ошибка! </h4>
                            Данные о курсах валют недоступны, попробуйте перезагрузить страницу или обратитесь позднее. Спасибо!
                        </div> --}}
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-warning"></i> Внимание! </h4>
                            Не указаны курсы валют или нет результата! Обратитесь к системному администратору! Спасибо!
                        </div>
                    @endif
                </div><!-- /.table-responsive -->
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>