@extends('admin.layouts.master')
@section('title', 'Message List Page')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">

                    {{-- alert --}}
                    @if (count($newMessage) != 0)
                    <div class="col-6 offset-6">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>You Have {{ count($newMessage) }}&nbsp;new message</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                    @if (session('deleted'))
                        <div class="col-6 offset-6">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong><i class="fa-solid fa-check"></i>{{ session('deleted') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    {{-- end of alert --}}

                    @if (count($messages) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($messages as $m)
                                        <tr class="tr-shadow my-2">
                                              <td>
                                                <input type="hidden" name="" class="messageCode" value="{{ $m->code }}">
                                                @if ($m->message_code == $m->code)
                                                    <span class="badge bg-danger">New</span>
                                                @endif

                                              </td>
                                              <td>{{ $m->name }}</td>
                                              <td>{{ $m->email }}</td>

                                              <td class="col-2">
                                                <a href="{{ route('admin@messageDetail',$m->message_code) }}">
                                                    <button class="btn btn-outline-secondary viewBtn">View Message</button>
                                                </a>
                                              </td>
                                              <td class=" col-1">
                                                <div class="table-data-feature">
                                                    <a href="{{ route('admin@messageDelete',$m->id) }}" class=" me-1">
                                                        <button class="item" data-toggle="tooltip"
                                                            data-placement="top" title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </a>
                                                </div></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="">
                                {{-- {{ $categories->links() }} --}}
                                {{ $messages->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @else
                        <h2 class=" text-center text-secondary mt-5">There is no Messages here</h2>
                    @endif

                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptSource')
    <script>
        $(document).ready(function (){
         $('.viewBtn').click(function (){
           $messageCode = $('.messageCode').val();
            $.ajax({
                type : 'get',
                url : '/admin/ajax/message',
                data : { 'messageCode' : $messageCode },
                dataType : 'json',
            })
         })
        })
    </script>
@endsection
