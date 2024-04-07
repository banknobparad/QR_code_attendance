@extends('layouts.app')

@section('title')
    หน้าหลัก
@endsection

@section('content')
    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-weight: bold;
        }

        .card-text {
            color: #777;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 5px;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0069d9;
        }

        .btn-primary:active {
            transform: scale(1.1);
        }

        /* ตัวอย่าง animation เพิ่มเติม */

        .btn-primary:hover {
            transform: translateY(5px);
        }

        .btn-primary:active {
            transform: scale(0.8);
        }


        .btn-primary:hover {
            animation: pulse 0.5s ease-in-out;
        }

        .qr-code {
            width: 100px;
            height: 100px;
            margin: 10px;
        }

        .image-hover:hover .qr-code {
            transform: scale(0.9);
            opacity: 0.8;
            transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
        }

        .image-hover .qr-code:hover {
            transform: scale(0.9);
            opacity: 0.8;
        }

        .image-hover .qr-code {
            transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
        }
    </style>
    <div class="container d-flex flex-column">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4 mb-4">
                <a href="{{ route('attendance.index') }}">
                    <div class="card h-100 card-hover">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title">หน้าสร้าง QR code</h5>
                            <div class="image-hover text-center">
                                <img src="/images/qr-code.svg" alt="QR Code" class="qr-code">
                            </div>
                            <button class="btn btn-primary">ไปหน้าสร้าง QR code</button>

                        </div>
                    </div>
                </a>
            </div>


            <div class="col-md-6 col-lg-4 mb-4">
                <a href="{{ route('attendance.showQRcode') }}">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title">หน้าแสดง QR code</h5>
                            <div class="image-hover text-center">
                                <img src="/images/scan.svg" alt="QR Code" class="qr-code">
                            </div> <button class="btn btn-primary">ไปหน้าแสดง QR code</button>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
