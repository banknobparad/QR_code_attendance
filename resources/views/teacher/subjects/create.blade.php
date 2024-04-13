@extends('layouts.app')
@section('title')

@section('content')
    <style>
        .image-preview {
            max-width: 100%;
            /* ทำให้รูปภาพไม่เกินความกว้างของ container */
            max-height: 200px;
            /* กำหนดความสูงสูงสุดของรูปภาพ */
            margin-top: 10px;
            /* ระยะห่างด้านบน */
            border: 1px solid #ddd;
            /* เส้นขอบ */
            border-radius: 5px;
            /* ขอบมน */
            padding: 5px;
            /* ระยะห่างขอบ */
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
            border-bottom-color: #0d6efd;
            /* สีขอบล่างเมื่อ focus */
        }

        .form-group {
            margin-bottom: 15px;
            /* ระยะห่างระหว่างกลุ่มฟอร์ม */
        }

        .image-preview {
            max-width: 100%;
            max-height: 200px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
        }
    </style>
    <div class="container d-flex flex-column">
        <div class="card shadow-sm rounded-3 my-auto col-md-12 mx-auto">
            <div class="card-header p-3 h4" style="color: #0d6efd">
                เพิ่มรายวิชา และนักเรียน
            </div>
            <div class="card-body p-4">
                <form id="myForm" action="{{ route('subject.store') }}" method="POST" class="row">

                    @csrf
                    <div class="form-group col-lg-6">
                        <label class="form-control-label" for="form-group-input">รหัสวิชา</label>
                        <input type="text" class="form-control" id="form-group-input" name="subject_id"
                            value="{{ old('subject_id') }}">
                        @error('subject_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        @error('subject_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-control-label" for="form-group-input">ชื่อวิชา</label>
                        <input type="text" class="form-control" id="form-group-input" name="subject_name"
                            value="{{ old('subject_name') }}">

                        @error('subject_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-control-label" for="form-group-input">สาขาวิชา</label>
                        <select name="branch_id"
                            class="form-select
                                    {{ $errors->has('branch_id') ? 'is-invalid' : (old('branch_id') ? 'is-valid' : '') }}">
                            <option value="" selected disabled>{{ __('เลือกสาขา') }}</option>

                            @foreach ($branch as $item)
                                <option value="{{ $item->id }}" {{ old('branch_id') == $item->id ? 'selected' : '' }}>
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


                    <div class="form-group col-lg-6">
                        <label class="form-control-label" for="form-group-input">ชั้นปี</label>
                        <select name="year_id"
                            class="form-select
                                    {{ $errors->has('year_id') ? 'is-invalid' : (old('year_id') ? 'is-valid' : '') }}">
                            <option value="" selected disabled>{{ __('เลือกชั้นปี') }}</option>
                            @foreach ($year as $item)
                                <option value="{{ $item->id }}" {{ old('year_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
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






    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- Page-header start -->
                    <div class="page-header">
                        <div class="row align-items-end">
                            <div class="col-lg-8">
                                <div class="page-header-title">
                                    <h4>อัพโหลดไฟล์</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Page-header end -->
                    <form action="" method="post" class="j-pro" id="j-pro"></form>
                    <div class="j-wrapper">
                        <form method="post" class="j-pro" id="j-pro" enctype="multipart/form-data"
                            action="{{ route('subject.students.import') }}" novalidate="">
                            {{ csrf_field() }}
                            <div class="j-content">
                                <div class="j-unit d-flex align-items-center">
                                    <div class="j-input j-append-big-btn">
                                        <label class="j-icon-left" for="file_input">
                                            <i class="icofont icofont-download"></i>
                                        </label>

                                        <input type="file" name="select_file"
                                            onchange="document.getElementById('file_input').value = this.value;">

                                    </div>
                                </div>
                                <div class="j-footer">
                                    <button type="submit" name="upload" class="btn btn-primary mt-2">Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Page-body end -->
                    @if (count($errors) > 0)
                        <div class="text-danger text-center"id="alert-error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- upload -->
                    @if ($message = Session::get('success'))
                        <div class="text-success alert-block text-center">
                            <strong>{{ $message }}</strong>

                        </div>
                    @endif

                    <!-- delete -->
                    @if ($message = Session::get('importDelete'))
                        <div class="text-success alert-block text-center">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    <!-- insert -->
                    @if ($message = Session::get('importInsert'))
                        <div class="text-success alert-block text-center">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    <!-- update -->
                    @if ($message = Session::get('importUpdate'))
                        <div class="text-success alert-block text-center">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    <!-- code exit -->
                    @if ($message = Session::get('codesExists'))
                        <div class="text-danger alert-block text-center">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    <div class="card mt-2" style="border-top: 3px solid #404E67;">
                        <div class="card-header">
                            <h5>ข้อมูลนักเรียน</h5>
                            <button type="button" class="btn btn-success float-right" data-toggle="modal"
                                data-target="#ImportAdd"><i class="icofont icofont-check-circled"></i>Add</button>
                        </div>
                        <div class="card-block">
                            <div class="table-responsive dt-responsive">
                                <table id="dom-jqry" class="table table-sm table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th style="display:none;"></th>
                                            <th>รหัสนักศึกษา</th>
                                            <th>ชื่อ นามสกุล</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $row)
                                            <tr role="row" class="odd">
                                                <td style="display:none;" class="idUpdate">
                                                    {{ $row->id }}</td>
                                                <td class="Student_id">{{ $row->student_id }}</td>
                                                <td class="Name">{{ $row->name }}</td>
                                                <td class="text-center">
                                                    <a class="m-r-15 text-muted importEdit" data-toggle="modal"
                                                        data-idUpdate="'.$row->id.'" data-target="#ImportUpdate">Edit</a>
                                                    <a href="javascript:void(0)" class="delete-item"
                                                        data-id="{{ $row->id }}">Delete</a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    <!-- Modal Add New-->
                    <div class="modal fade" id="ImportAdd" tabindex="-1" role="dialog"
                        style="z-index: 1050; display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add New</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true"><i class="ti-close"></i></span>
                                    </button>
                                </div>
                                <form action="{{ route('subject.students.insert') }}" method = "post">
                                    <!-- form add -->
                                    @csrf
                                    <div class="modal-body">

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">ชื่อ-นามสกุล</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="Name"name="Name" class="form-control"
                                                    placeholder="กรอกชื่อ-นามสกุล">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">รหัสนักศึกษา</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="Student_id"name="Student_id"
                                                    class="form-control" placeholder="กรอกรหัสนักศึกษา">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                                class="icofont icofont-eye-alt"></i>Close</button>
                                        <button type="submit" id=""name=""
                                            class="btn btn-success  waves-light"><i
                                                class="icofont icofont-check-circled"></i>Save</button>
                                    </div>
                                </form><!-- form add end -->
                            </div>
                        </div>
                    </div> <!-- End Modal Add New-->





                    <!-- Modal Update-->
                    <div class="modal fade" id="ImportUpdate" tabindex="-1" role="dialog"
                        style="z-index: 1050; display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header text-write">
                                    <h4 class="modal-title">Update</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true"><i class="ti-close"></i></span>
                                    </button>
                                </div>
                                <form action="{{ route('subject.students.update') }}" method = "post">
                                    <!-- form delete -->
                                    @csrf
                                    <input type = "text"hidden class="col-sm-9 form-control"id="idUpdate"
                                        name ="idUpdate" value="" />
                                    <div class="modal-body">

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="e_Name"name="Name" class="form-control"
                                                    value="" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">รหัสนักศึกษา</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="e_Student_id"name="Student_id"
                                                    class="form-control" value="" />
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                                class="icofont icofont-eye-alt"></i>Close</button>
                                        <button type="submit" id=""name=""
                                            class="btn btn-success  waves-light"><i
                                                class="icofont icofont-check-circled"></i>Update</button>
                                    </div>
                                </form><!-- form delete end -->
                            </div>
                        </div>
                    </div> <!-- End Modal Delete-->
                </div><!-- Main-body end -->
            </div>
        </div>
    </div>

    <div class="form-group col-lg-12 py-2">
        <button type="submit" class="btn btn-dark float-end" for="form-group-input" id="sendButton">Send</button>
    </div>
    </form>
    </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.delete-item').click(function(e) {
                e.preventDefault();

                var id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `import_excel/${id}`;
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#sendButton").click(function() {
                $("#myForm").submit();
            });
        });

        // select import
        $(document).on('click', '.importEdit', function() {
            var _this = $(this).parents('tr');
            $('#idUpdate').val(_this.find('.idUpdate').text());
            $('#e_Name').val(_this.find('.Name').text());
            $('#e_Student_id').val(_this.find('.Student_id').text());
        });
    </script>

@endsection
