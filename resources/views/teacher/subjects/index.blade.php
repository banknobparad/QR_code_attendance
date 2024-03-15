@extends('layouts.app')
@section('title')


@section('content')
    <style>
        .subject_id_error {
            font-size: 18px;
            box-sizing: border-box;
        }

        .subject_name_error {
            font-size: 18px;
            box-sizing: border-box;
        }
    </style>
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
                                <tbody></tbody>
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
