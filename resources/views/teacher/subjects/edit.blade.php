@extends('layouts.app')
@section('title', 'Edit Subject')

@section('activeSubject')
    active border-2 border-bottom border-primary
@endsection

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
                <form id="myForm" action="{{ route('subject.edit', $edit_subject->subject_id) }}" method="POST"
                    class="row">

                    @csrf
                    <div class="form-group col-lg-6">
                        <label class="form-control-label" for="form-group-input">รหัสวิชา</label>
                        <input type="text" class="form-control" id="form-group-input" name="subject_id"
                            value="{{ $edit_subject['subject_id'] }}">

                        @error('subject_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-control-label" for="form-group-input">ชื่อวิชา</label>
                        <input type="text" class="form-control" id="form-group-input" name="subject_name"
                            value="{{ $edit_subject['subject_name'] }}">

                        @error('subject_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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
                                                data-target="#ImportAdd"><i
                                                    class="icofont icofont-check-circled"></i>Add</button>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive dt-responsive">
                                                <table id="dom-jqry"
                                                    class="table table-sm table-striped table-bordered nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th style="display:none;"></th>
                                                            <th>รหัสนักศึกษา</th>
                                                            <th>ชื่อ นามสกุล</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($edit_subject['subject_stu'] as $index => $row)
                                                            <tr role="row" class="odd">
                                                                <td style="display:none;" class="idUpdate">
                                                                    {{ $row->id }}</td>
                                                                <td class="Student_id">{{ $row->student_id }}</td>
                                                                <td class="Name">{{ $row->name }}</td>
                                                                <td class="text-center">
                                                                    <a class="m-r-15 text-muted importEdit"
                                                                        data-toggle="modal" data-idUpdate="'.$row->id.'"
                                                                        data-target="#ImportUpdate">Edit</a>

                                                                    <a href="{{ route('subject.students.editdelete', ['id' => $row->id]) }}"
                                                                        class="delete-item" data-id="{{ $row->id }}"
                                                                        onclick="confirmDelete(event)">Delete</a>


                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 py-2">
                                        <button type="submit" class="btn btn-dark float-end" for="form-group-input"
                                            id="sendButton">Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>


            <!-- Modal Add New-->
            <div class="modal fade" id="ImportAdd" tabindex="-1" role="dialog" style="z-index: 1050; display: none;"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add New</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="ti-close"></i></span>
                            </button>
                        </div>
                        <form action="{{ route('subject.students.updateadd') }}" method = "post">
                            <!-- form add -->
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="subject_id" value="{{ $edit_subject['subject_id'] }}">

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="Name"name="Name" class="form-control"
                                            placeholder="Enter Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Student_id</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="Student_id"name="Student_id" class="form-control"
                                            placeholder="Enter Student_id">
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                        class="icofont icofont-eye-alt"></i>Close</button>
                                <button type="submit" id=""name="" class="btn btn-success  waves-light"><i
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
                        <form action="{{ route('subject.students.updateinedit') }}" method = "post">
                            <!-- form delete -->
                            @csrf
                            <input type = "text" hidden class="col-sm-9 form-control"id="idUpdate" name ="idUpdate"
                                value="" />
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
                                        <input type="text" id="e_Student_id"name="Student_id" class="form-control"
                                            value="" />
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                        class="icofont icofont-eye-alt"></i>Close</button>
                                <button type="submit" id=""name="" class="btn btn-success  waves-light"><i
                                        class="icofont icofont-check-circled"></i>Update</button>
                            </div>
                        </form><!-- form delete end -->
                    </div>
                </div>
            </div> <!-- End Modal Delete-->
        </div><!-- Main-body end -->

        <script>
            function confirmDelete(event) {
                event.preventDefault(); // ยกเลิกการทำงานของลิงก์เดิม
                var deleteUrl = event.target.href; // รับ URL ที่ต้องการลบ

                // เรียกใช้ SweetAlert2 สำหรับการยืนยันการลบ
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // ถ้าผู้ใช้กดปุ่มยืนยัน
                        window.location.href = deleteUrl; // ลิงก์ไปยัง URL สำหรับการลบ
                    }
                });
            }
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
