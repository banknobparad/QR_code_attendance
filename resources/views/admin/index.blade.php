@extends('layouts.app')

@section('title')
    My Profile
@endsection


@section('activeUsers')
    active border-2 border-bottom border-primary
@endsection



@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-primary">
                    <div class="card-header bg-transparent border-0 fs-2 text-primary lead">{{ __('My Profile') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.store') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('ชื่อ-นามสกุล') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror @if (old('name')) is-valid @endif"
                                        name="name" value="{{ old('name') }}" autocomplete="name" autofocus
                                        placeholder="ชื่อ นามสกุล">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="student_id"
                                    class="col-md-4 col-form-label text-md-end">{{ __('รหัสนักศึกษา') }}</label>

                                <div class="col-md-6">
                                    <input id="student_id" type="text"
                                        class="form-control @error('student_id') is-invalid @enderror @if (old('student_id')) is-valid @endif"
                                        name="student_id" value="{{ old('student_id') }}" autocomplete="student_id"
                                        autofocus placeholder="รหัสนักศึกษา">

                                    @error('student_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="branch_id"
                                    class="col-md-4 col-form-label text-md-end">{{ __('สาขา') }}</label>

                                <div class="col-md-6">
                                    <select name="branch_id"
                                        class="form-select
                                            {{ $errors->has('branch_id') ? 'is-invalid' : (old('branch_id') ? 'is-valid' : '') }}">
                                        <option value="" selected disabled>{{ __('เลือกสาขา') }}</option>

                                        @foreach ($branch as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('branch_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('branch_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="year_id"
                                    class="col-md-4 col-form-label text-md-end">{{ __('ชั้นปี') }}</label>

                                <div class="col-md-6">
                                    <select name="year_id"
                                        class="form-select
                                            {{ $errors->has('year_id') ? 'is-invalid' : (old('year_id') ? 'is-valid' : '') }}">
                                        <option value="" selected disabled>{{ __('เลือกชั้นปี') }}</option>
                                        @foreach ($year as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('year_id') == $item->id ? 'selected' : '' }}> {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('year_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone_number"
                                    class="col-md-4 col-form-label text-md-end">{{ __('เบอร์โทร') }}</label>

                                <div class="col-md-6">
                                    <input id="phone_number" type="text"
                                        class="form-control @error('phone_number') is-invalid @enderror @if (old('phone_number')) is-valid @endif"
                                        name="phone_number" value="{{ old('phone_number') }}" autocomplete="phone_number"
                                        autofocus placeholder="เบอร์โทร">

                                    @error('phone_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('อีเมล') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror @if (old('email')) is-valid @endif"
                                        name="email" value="{{ old('email') }}" autocomplete="email"
                                        placeholder="อีเมล">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('รหัสผ่าน') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        autocomplete="new-password" placeholder="รหัสผ่าน">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('ยืนยันรหัสผ่าน') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" autocomplete="new-password"
                                        placeholder="ยืนยันรหัสผ่าน">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('เลือกบทบาท') }}</label>
                                <div class="col-md-6">

                                    <select name="role" id="role"
                                        class="form-control shadow-none rounded-0 @error('role') is-invalid @enderror">
                                        <option value="Administrator">Administrator</option>
                                        <option value="Teacher">Teacher</option>
                                        <option value="Student">Student</option>
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary rounded-0 shadow-none">
                                        <span class="me-2"><i class="fa-solid fa-square-plus"></i></span>
                                        {{ __('Add New User') }}
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

@section('scripts')
    @if (Session::has('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ Session::get('success') }}',
            });
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ Session::get('error') }}',
            });
        </script>
    @endif

    @if (Session::has('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: '{{ Session::get('warning') }}',
            });
        </script>
    @endif


    @if (Session::has('question'))
        <script>
            Swal.fire({
                icon: 'question',
                title: 'Question',
                text: '{{ Session::get('question') }}',
            });
        </script>
    @endif
@endsection
