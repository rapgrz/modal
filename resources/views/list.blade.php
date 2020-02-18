@extends('layout')
@section('title','Sąrašas')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="msg"></div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Sąrašas</div>
                    <div class="card-body">
                       <button class="btn btn-success float-right" data-toggle="modal" data-target="#modalas">Pridėti</button>
                        <table id="list" class="table table-striped mt-5">
                            <thead>
                            <tr>
                                <th scope="col">Pavadinimas</th>
                                <th scope="col">Įmonės kodas</th>
                                <th scope="col">Adresas</th>
                                <th scope="col">Miestas</th>
                                <th scope="col">Suma</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($companies->sortByDesc('id') as $company)
                                <tr id="{{$company->id}}">
                                    <td>{{$company->name}}</td>
                                    <td>{{$company->code}}</td>
                                    <td>{{$company->address}}</td>
                                    <td>{{$company->city->name}}</td>
                                    <td>{{$company->dates->sum('sum')}}</td>
                                    <td class="float-right">
                                        <a href="{{route('edit-company', $company->id)}}"><i class="fa fa-edit text-primary mr-3"></i></a>
                                        <a href="#" class="manage-delete" data-toggle="modal" data-target="#deleteConfirm" target="{{$company->id}}"
                                           action="{{route('delete-company', $company->id)}}">
                                            <i class="fa fa-trash text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalas" tabindex="-1" role="dialog" aria-labelledby="modalasTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalasTitle">Įmonė</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('store-company')}}" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title" class="col-form-label">Pavadinimas:</label>
                            <input type="text" class="form-control" id="title" required>
                        </div>
                        <div class="form-group">
                            <label for="company-code" class="col-form-label">Įmonės kodas:</label>
                            <input type="number" class="form-control" id="company-code" required>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-form-label">Adresas:</label>
                            <input type="text" class="form-control" id="address" required>
                        </div>
                        <div class="form-group">
                            <label for="city" class="col-form-label">Miestas:</label>
                            <select class="form-control" id="city" required>
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="date-from" class="col-form-label">Data nuo:</label>
                                <input type="date" class="form-control" id="date-from" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="date-to" class="col-form-label">Data iki:</label>
                                <input type="date" class="form-control" id="date-to" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sum" class="col-form-label">Suma (EUR):</label>
                            <input type="number" min="0" class="form-control" id="sum" value="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary mr-auto">Išsaugoti</button>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmLabel">{{ 'Ar jūs tikri?' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ "Jūs ketinate ištrinti įmonę. Šis veiksmas negrąžinamas." }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ "Atšaukti" }}</button>
                    <button type="button" class="btn btn-success delete-sure" data-backdrop="false">{{ "Ištrinti" }}</button>
                </div>
            </div>
        </div>
    </div>
    @csrf
@endsection