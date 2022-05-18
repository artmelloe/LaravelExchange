@extends('template.default')
@section('content')
    @include('template.head', ['title' => 'Index'])
    <body class="bg-light">
        <div class="container">
            <div class="py-5 text-center">
                <div>
                    <img class="d-block mx-auto mb-4" src="{{ asset('images/bootstrap-solid.svg') }}" alt="" width="72" height="72">
                    <h2>Currency Exchange</h2>
                    <p class="lead">Every exchange is done using Brazilian currency (BRL) as default.</p>
                </div>
                @if(Session::get('submit_email_success'))
                    <div class="alert alert-success mt-5" role="alert">
                        {{ Session::get('submit_email_success') }}
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-md-12 order-md-1">
                    <form class="needs-validation" method="post" action="{{ route('store') }}" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-6">
                                <label for="income_currency">Income currency</label>
                                <select class="form-select d-block w-100" id="income_currency" name="income_currency" required>
                                    <option value="">- Select -</option>
                                    @foreach ($exchange_available as $k => $v)
                                        <option value="{{ $k }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid income currency.
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="amount_exchange">Amount to exchange</label>
                                <input type="number" class="form-control" id="amount_exchange" name="amount_exchange" min="1000" max="100000" placeholder="Ex: 5000" required>
                                <div class="invalid-feedback">
                                    A valid amount exchange is required.
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="payment_method">Payment method</label>
                                <select class="form-select d-block w-100" id="payment_method" name="payment_method" required>
                                    <option value="">- Select -</option>
                                    <option value="boleto">Boleto</option>
                                    <option value="credit_card">Credit card</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid payment method.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="accordion" id="accordionExchangeConfiguration">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingExchangeConfiguration">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExchangeConfiguration" aria-expanded="false" aria-controls="collapseExchangeConfiguration">
                                            Exchange Configuration
                                        </button>
                                    </h2>
                                    <div id="collapseExchangeConfiguration" class="accordion-collapse collapse" aria-labelledby="headingExchangeConfiguration" data-bs-parent="#accordionExchangeConfiguration">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="boleto_fee">Boleto fee (%)</label>
                                                    <input type="number" class="form-control" id="boleto_fee" name="boleto_fee" value="{{ Helper::floatToPercentage($configuration->boleto_fee) }}" step=".01" placeholder="Ex: 1.45" required>
                                                    <div class="invalid-feedback">
                                                        A valid boleto fee is required.
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="credit_card_fee">Credit card fee (%)</label>
                                                    <input type="number" class="form-control" id="credit_card_fee" name="credit_card_fee" value="{{ Helper::floatToPercentage($configuration->credit_card_fee) }}" step=".01" placeholder="Ex: 7.63" required>
                                                    <div class="invalid-feedback">
                                                        A valid credit card fee is required.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label for="fee_amount_less">Fee amount (%)</label>
                                                    <input type="number" class="form-control" id="fee_amount_less" name="fee_amount_less" value="{{ Helper::floatToPercentage($configuration->fee_amount_less) }}" step=".01" placeholder="Ex: 2" required>
                                                    <div class="invalid-feedback">
                                                        A fee amount less is required.
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="fee_amount_less_value">To less than</label>
                                                    <input type="number" class="form-control" id="fee_amount_less_value" name="fee_amount_less_value" value="{{ $configuration->fee_amount_less_value }}" min="0" max="{{ $configuration->fee_amount_greater_value }}" placeholder="Ex: 3000" required>
                                                    <div class="invalid-feedback">
                                                        A valid amount exchange is required.
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="fee_amount_greater">Fee amount (%)</label>
                                                    <input type="number" class="form-control" id="fee_amount_greater" name="fee_amount_greater" value="{{ Helper::floatToPercentage($configuration->fee_amount_greater) }}" step=".01" placeholder="Ex: 1" required>
                                                    <div class="invalid-feedback">
                                                        A fee amount greater is required.
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="fee_amount_greater_value">To greater than</label>
                                                    <input type="number" class="form-control" id="fee_amount_greater_value" name="fee_amount_greater_value" value="{{ $configuration->fee_amount_greater_value }}" min="0" placeholder="Ex: 3000" onkeyup="equalValues()" required>
                                                    <div class="invalid-feedback">
                                                        A valid amount exchange is required.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="mb-3">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Exchange</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if(Session::get('result'))
                <hr class="mb-4">
                <div class="row">
                    <div class="col-md-4 mb-6">
                        <h2 class="mb-3">Exchange result</h2>
                        <ul>
                            <li><b>Origin currency:</b> {{ session('result')['originCurrency'] }}</li>
                            <li><b>Income currency:</b> {{ session('result')['incomeCurrency'] }}</li>
                            <li><b>Amount to exchange:</b> {{ Helper::currencyFormat(session('result')['amountExchange'], session('result')['originCurrency']) }}</li>
                            <li><b>Payment method:</b> {{ Helper::capitalize(session('result')['paymentMethod'], session('result')['originCurrency']) }}</li>
                            <li><b>Current currency:</b> {{ Helper::currencyFormat(session('result')['currentCurrency'], session('result')['incomeCurrency']) }}</li>
                            <li><b>Exchange total:</b> {{ Helper::currencyFormat(session('result')['exchangeTotal'], session('result')['incomeCurrency']) }}</li>
                            <li><b>Payment fee:</b> {{ Helper::currencyFormat(session('result')['paymentFee'], session('result')['originCurrency']) }}</li>
                            <li><b>Exchange fee:</b> {{ Helper::currencyFormat(session('result')['exchangeFee'], session('result')['originCurrency']) }}</li>
                            <li><b>Exchange without fees:</b> {{ Helper::currencyFormat(session('result')['exchangeWithoutFees'], session('result')['originCurrency']) }}</li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-6">
                        <h2 class="mb-3">JSON return</h2>
                        <code>
                            {{ json_encode(session('result')) }}
                        </code>
                    </div>
                    <div class="col-md-4 mb-6">
                        <h2 class="mb-3">Send to email</h2>
                        <form class="needs-validation" method="post" action="{{ route('submit_mail') }}" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" min="1000" max="100000" placeholder="Your email here" required>
                                    <div class="invalid-feedback">
                                        A valid email is required.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Sent</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            @if($exchange_total->isNotEmpty())
                <hr class="mb-4">
                <div class="row">
                    <div class="col-md-12 mb-6 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Origin currency</th>
                                    <th scope="col">Income currency</th>
                                    <th scope="col">Amount to exchange</th>
                                    <th scope="col">Payment method</th>
                                    <th scope="col">Current currency</th>
                                    <th scope="col">Exchange total</th>
                                    <th scope="col">Payment fee</th>
                                    <th scope="col">Exchange fee</th>
                                    <th scope="col">Exchange without fees</th>
                                    <th scope="col">Exchanged in</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($exchange_total as $exchange)
                                    <tr>
                                        <td>{{ $exchange->origin_currency }}</td>
                                        <td>{{ $exchange->income_currency }}</td>
                                        <td>{{ Helper::currencyFormat($exchange->amount_exchange, $exchange->origin_currency) }}</td>
                                        <td>{{ Helper::capitalize($exchange->payment_method) }}</td>
                                        <td>{{ Helper::currencyFormat($exchange->current_currency, $exchange->income_currency) }}</td>
                                        <td>{{ Helper::currencyFormat($exchange->exchange_total, $exchange->income_currency) }}</td>
                                        <td>{{ Helper::currencyFormat($exchange->payment_fee, $exchange->origin_currency) }}</td>
                                        <td>{{ Helper::currencyFormat($exchange->exchange_fee, $exchange->origin_currency) }}</td>
                                        <td>{{ Helper::currencyFormat($exchange->exchange_without_fees, $exchange->origin_currency) }}</td>
                                        <td>{{ Helper::dateFormat($exchange->created_at) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            <hr class="mb-3">
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="{{ route('logout') }}">
                        <button class="btn btn-primary btn-lg btn-block">Logout</button>
                    </a>
                </div>
            </div>
            @include('template.footer')
        </div>
        @include('template.scripts')
    </body>
@stop
