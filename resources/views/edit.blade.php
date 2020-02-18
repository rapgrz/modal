@extends('layout')
@section('title','Redagavimas')
@section('content')
    <div class="container">
        <a href="{{route('home')}}" class="btn btn-primary mb-2">Atgal</a>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Redaguoti {{$company->name}}</div>
                    <div class="card-body">
                        <form action="{{route('modify-company', $company->id)}}" method="POST">
                            <div class="form-group">
                                <label for="title" class="col-form-label">Pavadinimas:</label>
                                <input type="text" name="title" class="form-control" id="title" value="{{$company->name}}" required>
                            </div>
                            <div class="form-group">
                                <label for="company-code" class="col-form-label">Įmonės kodas:</label>
                                <input type="number" name="code" class="form-control" id="company-code" value="{{$company->code}}" required>
                            </div>
                            <div class="form-group">
                                <label for="city" class="col-form-label">Miestas:</label>
                                <select class="form-control" name="city" id="city" required>
                                    @foreach($cities as $city)
                                        <option value="{{$city->id}}" @if($city->id === $company->city->id) selected @endif>{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="sum" class="col-form-label">Suma (EUR):</label>
                                <input type="number" name="sum" min="0" class="form-control" id="sum" value="{{$company->dates->sum('sum')}}" readonly>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Mėnuo</th>
                                    <th scope="col">Suma</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($company->dates as $key => $data)
                                    <tr>
                                        <th scope="row">{{$key + 1}}</th>
                                        <td>{{$data->date}}</td>
                                        <td><input type="number" id="{{$data->id}}" name="dates[]" class="form-control date" value="{{$data->sum}}" required></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @csrf
                            <button type="submit" class="btn btn-primary">Atnaujinti</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
