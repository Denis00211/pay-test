<?php
use App\Helpers\CardHelper;
?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <a  class="btn btn-primary" href="{{ route('payments.index') }}"><i class="bi bi-arrow-left"></i> </a>
        </div>
        <br>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>#</td>
                    <td>{{ $payment->id }}</td>
                </tr>
                <tr>
                    <td>UUID</td>
                    <td>{{ $payment->uuid }}</td>
                </tr>
                <tr>
                    <td>Сумма</td>
                    <td>{{ $payment->amount }} {{$payment->getCurrency()}}</td>
                </tr>
                <tr>
                    <td>Статус</td>
                    <td>{{ $payment->getStatusText() }}</td>
                </tr>
                <tr>
                    <td>Дата создания</td>
                    <td>{{ $payment->payment_date ? $payment->created_date->format('d-m-Y H:i:s') : '' }}</td>
                </tr>
                <tr>
                    <td>Дата оплаты</td>
                    <td>{{ $payment->payment_date ? $payment->payment_date->format('d-m-Y H:i:s') : '' }}</td>
                </tr>
                <tr>
                    <td>Телефон</td>
                    <td>{{ $payment->phone }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $payment->email }}</td>
                </tr>
                <tr>
                    <td>Карта</td>
                    <td>{{ $payment->card_first_six && $payment->card_last_four ? $payment->card_first_six .'XXXXXX'.$payment->card_last_four : '' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
