<table class="table table-hover table-striped no-margin">
    <thead>
        <tr>
            <th>Дата</th>
            <th style="text-align: right;">Значение</th>
        </tr>
    </thead>
    <tbody>
        @foreach($detailCurrency as $currency)
            <tr>
                <td>{{ $currency['date'] }}</td>
                <td>
                    <span class="pull-right" data-tooltip="tooltip" title="Toggle">
                        {{ $currency['value'] }}
                    </span>
                    <span class="pull-left label label-success" data-tooltip="tooltip" title="Toggle">
                        <i class="fa fa-caret-down"></i>
                    </span>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>