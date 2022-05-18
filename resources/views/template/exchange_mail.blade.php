<!DOCTYPE html>
<html>
    <head>
    <title>Exchange Email</title>
    </head>
    <body>
        <h2>Currency Exchange</h2>
        <ul>
            <li><b>Origin currency:</b> {{ $mail_data->origin_currency }}</li>
            <li><b>Income currency:</b> {{ $mail_data->income_currency }}</li>
            <li><b>Amount to exchange:</b> {{ Helper::currencyFormat($mail_data->amount_exchange, $mail_data->origin_currency) }}</li>
            <li><b>Payment method:</b> {{ Helper::capitalize($mail_data->payment_method) }}</li>
            <li><b>Current currency:</b> {{ Helper::currencyFormat($mail_data->current_currency, $mail_data->income_currency) }}</li>
            <li><b>Exchange total:</b> {{ Helper::currencyFormat($mail_data->exchange_total, $mail_data->income_currency) }}</li>
            <li><b>Payment fee:</b> {{ Helper::currencyFormat($mail_data->payment_fee, $mail_data->origin_currency) }}</li>
            <li><b>Exchange fee:</b> {{ Helper::currencyFormat($mail_data->exchange_fee, $mail_data->origin_currency) }}</li>
            <li><b>Exchange without fees:</b> {{ Helper::currencyFormat($mail_data->exchange_without_fees, $mail_data->origin_currency) }}</li>
        </ul>
    </body>
</html>
