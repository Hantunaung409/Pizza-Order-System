@extends('admin.layouts.master')

@section('title', 'Category List Page')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Category List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('category@createPage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>Add Category
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>

                    {{-- alert --}}
                    @if (session('createdSuccessfully'))
                        <div class="col-6 offset-6">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong><i class="fa-solid fa-check"></i>{{ session('createdSuccessfully') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    @if (session('deletedSuccessfully'))
                        <div class="col-6 offset-6">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong><i class="fa-solid fa-trash"></i>{{ session('deletedSuccessfully') }}</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    {{-- end alert --}}

                                       {{-- Search --}}
                                       <div class="row">
                                        <div class="col-4">
                                          <h4>Results of <span class=" text-success">{{ request('key') }}</span></h4>
                                        </div>
                                        <div class=" col-4 offset-4">
                                          <form action="{{ route('category@list') }}" method="get">
                                            @csrf
                                           <div class="d-flex">
                                           <input type="text" name="key" id="" class=" form-control" value="{{ request('key') }}">
                                           <button class=" btn btn-dark text-white"><i class="fa-solid fa-magnifying-glass"></i>
                                           </button>
                                           </div>

                                          </form>
                                        </div>
                                     </div>

                                     <div class="row">
                                        <div class="col-4">Total - ( {{ $categories->total() }} )</div>
                                     </div>
                                   {{-- end Search --}}

                    @if (count($categories) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category name</th>
                                        <th>Created at</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr class="tr-shadow my-2">
                                            <td>{{ $category->id }}</td>
                                            <td class="desc">{{ $category->name }}</td>
                                            <td>{{ $category->created_at->format('j-F-Y') }}</td>
                                            <td>
                                                <div class="table-data-feature">
                                                    {{-- <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="More">
                                                        <i class="zmdi zmdi-more"></i>
                                                    </button> --}}

                                                    <a href="{{ route('category@edit',$category->id) }}">
                                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="Edit">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    <button>                                            </a>

                                                    <a href="{{ route('category@delete', $category->id) }}">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </a>


                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="">
                                {{-- {{ $categories->links() }} --}}
                                {{ $categories->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @else
                        <h2 class=" text-center text-secondary mt-5">There is no Category here</h2>
                    @endif

                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
@endsection
