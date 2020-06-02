@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header text-primary">
                </div>
                <div class="card-body">

                    <div class="alert" role="alert" id="notice" hidden></div>

                    <form action=" {{ route('upload.store') }} " method="post"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="file" id="file" onchange="check(this)" required>
                            </div>

                            <div class="input-group">
                                <button id="upload-button" disabled type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </div>

                    </form>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên</th>
                                <th scope="col">Kích thước</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $file)
                                <tr>
                                    <th scope="row"> {{ $loop->iteration }} </th>
                                    <td> {{ $file['name'] }} </td>
                                    <td> {{ number_format($file['size'], 2) }} MB</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('download') }}?path={{ urlencode($file['path']) }}"
                                                class="btn btn-success mr-2">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <form
                                                action="{{ route('upload.destroy', $file['name']) }}"
                                                method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <button class="btn btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
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
<script>

    function showNotice(message, type) {
        $('#notice').text(message).attr('class', 'alert alert-' + type).prop('hidden', false);
    }

    function hideNotice() {
        $('#notice').prop('hidden', true);
    }


    var CheckFileExists = "{{ route('CheckFileExists') }}";
    // Lấy tên File
    function check(fileInput) {
        var files = fileInput.files;
        if (files.length == 0) return;

        var fileName = files[0].name;

        console.log(fileName);

        $.ajax({
            type: 'GET',
            url: CheckFileExists,
            data: {
                fileName: fileName,
            },

            success: function (data) {

                if (data['success'] == true) {
                    showNotice('File đã tồn tại không thể upload.', 'danger');
                    $('#upload-button').prop('disabled', true);

                } else {
                    hideNotice();
                    $('#upload-button').prop('disabled', false);
                }
            }
        });
    }

</script>

@if(session('status'))
<script>
    showNotice('{{ session('status') }}', 'success');
</script>
@endif

@endsection
