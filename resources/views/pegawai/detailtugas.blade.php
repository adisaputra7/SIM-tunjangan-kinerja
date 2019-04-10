@extends('layouts.home')
@section('core')
    <script>
        $(document).ready( function() {
            $(document).on('change', '.btn-file :file', function() {
            var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
            });

            $('.btn-file :file').on('fileselect', function(event, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = label;

                if( input.length ) {
                    input.val(log);
                } else {
                    if( log ) alert(log);
                }

            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#img-upload').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#filekumpul").change(function(){
                readURL(this);
            });
        });
    </script>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada masalah ketika mengunggah foto.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    {{ $details->judul }}
                </div>
                <div class="card-body">
                    <div class="from-group">
                        <label>Penjelasan Tugas</label>
                        <input type="text" value="{{$details->penjelasan_tugas}}" 
                        class="form-control"
                        disabled> 
                    </div>    
                    <br>
                    <form role="form" method="POST" action="{{ route('kumpulkan', ['id_tugas'=>$details->idTugas]) }}" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Pesan</label>
                            <textarea name="pesan" value="" class = "form-control" rows="8"autofocus></textarea>
                        </div>
                        <div class="form-group">
                            <label for="fileKumpul">File Pengumpulan</label>
                            <input name="filekumpul" id="filekumpul" type="file" class="form-control">
                        </div>
                        <input name="id_tugas" type="hidden" class="col-sm-3" value="{{ $details->idTugas }}" >
                        <br>
                      
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                        <button type="reset" class="btn btn-danger pull-right" style="margin-right:10px;">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection