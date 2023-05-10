@extends('layouts.app')

@section('content')
    
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Add Participants') }}</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('event-participants.store', ['event'=> request()->event])}}" method="post">
                                @csrf
                                <div class="my-2 d-flex justify-content-end">
                                    <button class="btn btn-success mx-1" title="Add Participant">
                                        <i class="fas fa-user-plus"></i>
                                    </button>
                                </div>

                                <table class="table table-responsive-sm table-striped-columns table-bordered table-hover" id="participants_table">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" class="selectAll" name="selectAll" value="all"></th>
                                            <th>ID Number</th>
                                            <th>Participant Name</th>
                                            <th>Participant Type</th>
                                            <th>Department</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($participants as $participant)
                                        <tr>  
                                            <td><input type="checkbox" name="participants[]" id="participants" value="{{ $participant->id }}-{{ $participant->user_type }}" class=""></td>
                                            <td>{{ $participant->id_number }}</td>
                                            <td>{{ $participant->name }}</td>
                                            <td>{{ App\Helpers\UserTypeHelper::getPrettyType($participant->user_type) }}</td>
                                            <td>{{ $participant->department }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready( function () {
        const participants = $('#participants_table').DataTable();

        $(".selectAll").on( "click", function(e) {
            if ($(this).is( ":checked" )) {
                let rows = participants.rows({ 'search': 'applied' }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            } else {
                let rows = participants.rows({ 'search': 'applied' }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', false);
            }
        });
    } );
</script>
@endsection


@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection

@section('scripts')
    @error('participants')
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script>
            toastr.options = {
                "closeButton": true,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            toastr.error('{{ $message }}')
        </script>
    @enderror
@endsection