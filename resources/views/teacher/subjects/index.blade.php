@extends('layouts.app')
@section('title')
    Subject
@endsection

@section('activeSubject')
    active border-2 border-bottom border-primary
@endsection

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header border-0 bg-transparent mb-2 fs-2 text-primary lead">
                        <div class="d-flex justify-content-between">
                            <span>{{ __('Subjects') }}</span>

                            <div class="button-create text-end">
                                <a class="btn btn-primary rounded-1 shadow-none ms-auto" href="{{ route('subject.create') }}"
                                    role="button">
                                    <i class="bi bi-plus-lg"></i>{{ __('Add Subjects') }}
                                </a>
                            </div>

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="col-md-12 table-responsive" id="subjectsTable">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="row">#</th>
                                        <th scope="row">subject_id</th>
                                        <th scope="row">subject_name</th>
                                        <th scope="row" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subjects as $item)
                                        <tr>

                                            <td>#</td>
                                            <td>{{ $item->subject_id }}</td>
                                            <td>{{ $item->subject_name }}</td>
                                            <td class="text-center">
                                                <a href="" class="btn btn-sm btn-info"><i class="fa-regular fa-eye"></i></a>
                                                <a href="" class="btn btn-sm btn-success"><i
                                                        class="fa-regular fa-pen-to-square"></i></a>
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
    </div>
@endsection

@section('scripts')
@endsection
