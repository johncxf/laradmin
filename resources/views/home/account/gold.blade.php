@extends('home.layouts.master')
@section('title', '金币明细')
@section('content')
    @include('errors.validate')
    @include('errors.message')
    <h5>金币明细</h5>
    <hr>
    <div class="card">
        <div class="card-body">
            <span class="card-title">共计收入：
                <span class="text-success">{{$gold_info['get_gold']}}</span>
            </span>
            <span class="text-muted ml-2">|</span>
            <span class="card-title ml-2">总支出：
                <span class="text-danger">{{$gold_info['used_gold']}}</span>
            </span>
        </div>
        <ul class="list-group list-group-flush">
            @foreach($gold_logs as $gold_log)
                <li class="list-group-item">
                    <span>{{$gold_log->remark}}</span>
                    @if($gold_log->type == 1)
                        <span class="ml-2 badge badge-success">+{{$gold_log->gold}}</span>
                    @else
                        <span class="ml-2 badge badge-danger">- {{$gold_log->gold}}</span>
                    @endif
                    <span class="text-muted float-right">{{$gold_log->create_at}}</span>

                </li>
            @endforeach
        </ul>
        <div class="card-body">
            {{$gold_logs->links()}}
        </div>
    </div>
@endsection