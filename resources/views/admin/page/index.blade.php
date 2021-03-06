@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            @if (Session::has('message'))
                <div class="alert alert-success alert-dismissible">
                    <button type='button' class="close" data-dismiss='alert' area-hidden='true'>x</button>
                    {{Session('message')}}
                </div>
            @endif
            @if (Session::has('delete-message'))
                <div class="alert alert-danger alert-dismissible">
                    <button type='button' class="close" data-dismiss='alert' area-hidden='true'>x</button>
                    {{Session('delete-message')}}
                </div>
            @endif
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Pages - List') }}
                    <a href="{{route('pages.create')}}" class="btn btn-sm btn-primary float-right">Add New</a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col" width="60">#</th>
                                <th scope="col" width="60">Title</th>
                                <th scope="col" width="200">Create By</th>
                                <th scope="col" width="129">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pages as $page)
                               <tr>
                                   <td>{{$page->id}}</td>
                                   <td>{{$page->title}}</td>
                                   <td>{{$page->user->name}}</td>
                                   <td>
                                       <a href="{{route('pages.edit', $page->id)}}" class="btn btn-sm btn-primary">Edit</a>
                                       {!! Form::open(['route' => ['pages.destroy', $page->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                       {!! Form::submit('delete', ['class' => 'btn btn-sm btn-danger']) !!}
                                       {!! Form::close() !!}
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
@endsection
