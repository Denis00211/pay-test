@extends('layouts.app')

@section('content')
    <div class="container">
        <h2> {{$isPaid === true ? 'Платеж успешно оплачен' : 'Неверно введена карта или срок действия карты истек. '}}</h2>
        <h2>{{$isPaid === true ? $payment->payment_date->format('d-m-Y H:i:s') : '' }}</h2>
        <h2>{{$payment->amount }} {{$payment->getCurrency()}}</h2>
    </div>
@endsection
