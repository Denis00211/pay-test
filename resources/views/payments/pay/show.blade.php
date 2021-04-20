@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Оплата</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('payments.pay', ['uuid' => $payment->uuid]) }}">
                            @csrf
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Номер карты</label>

                                <div class="col-md-6">
                                    <input id="cardNumber" type="number" class="form-control @error('cardNumber') is-invalid @enderror" name="cardNumber" value="{{ old('cardNumber') }}">

                                    @error('cardNumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="cardMonth" class="col-md-4 col-form-label text-md-right">Месяц</label>
                                        <div class="col-md-6">
                                            <select style="width: 100%;height: 38px;" name="cardMonth" id="cardMonth">
                                                @foreach($months as $monthKey => $monthValue)
                                                    <option value="{{$monthKey}}" {{ old('cardMonth') ? 'checked' : '' }}>{{$monthValue}}</option>
                                                @endforeach
                                            </select>
                                            @error('cardMonth')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="cardYear" class="col-md-4 col-form-label text-md-right">Год</label>
                                        <div class="col-md-6">
                                            <input id="cardYear" placeholder="YYYY" type="number" class="form-control @error('cardYear') is-invalid @enderror" name="cardYear" value="{{ old('cardYear') }}">

                                            @error('cardYear')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <h6>Сумма: {{ $payment->amount }} {{ $payment->getCurrency() }}</h6>
                                </div>
                            </div>
                            @if($payment->email)
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <h6>Email: {{ $payment->email }}</h6>
                                    </div>
                                </div>
                            @endif
                            @if($payment->phone)
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <h6>Телефон: {{ $payment->phone }}</h6>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Оплатить
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
