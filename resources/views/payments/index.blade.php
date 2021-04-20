@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($errors)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="p-0 m-0" style="list-style: none;">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('payments.index') }}" method="GET">
            <table class="table table-bordered">
                <thead>
                <tr class="table-primary">
                    <th scope="col">UUID  <input type="text" name="uuid" value="{{$filters['uuid']}}" /> </th>
                    <th scope="col">Сумма  <input type="text" name="amount" value="{{$filters['amount']}}" /></th>
                    <th scope="col">Статус
                        <select name="status" id="">
                            <option value=""></option>
                            @foreach($statuses as $key => $status)
                                <option value="{{$key}}" {{$filters['status'] == $key ? 'selected' : ''}}>{{$status}}</option>
                            @endforeach
                        </select>
                    </th>
                    <th scope="col">Создано  </th>
                    <th scope="col">Оплачено </th>
                    <th scope="col"><button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button></th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $item)
                    <tr>
                        <td>{{ $item->uuid }}</td>
                        <td>{{ $item->cutAmount($item->amount, 2) }} {{$item->getCurrency()}}</td>
                        <td>{{ $item->getStatusText() }}</td>
                        <td>{{ $item->created_date ? $item->created_date->format('d-m-Y H:i:s') : '' }}</td>
                        <td>{{ $item->payment_date ? $item->payment_date->format('d-m-Y H:i:s') : 'Не оплачено'}}</td>
                        <td>
                            <div>
                                <a  class="btn btn-primary" href="{{ route('payments.show', ['id' => $item->id]) }}"><i class="bi bi-eye"></i> </a>
                            </div>
                            @if($item->status === \App\Models\Payment::STATUS_CREATED)
                                <div style="margin-top: 10px"><a  class="btn btn-success" href="{{ route('payments.pay.show', ['uuid' => $item->uuid]) }}"><i class="bi bi-bucket"></i> </a></div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {!! $payments->withQueryString()->links() !!}
            </div>

        </form>
        <div>
            <a  class="btn btn-primary" href="{{ route('payments.create') }}">Создать счет на оплату</a>
        </div>

    </div>
@endsection
