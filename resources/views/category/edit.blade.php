<base href="/public"/>
<x-layout>
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin.sidebar')


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
              @include('admin.topbar')


              <div class="container-fluid">
                <div class="">
                    <h1 class="h3 ms-6 text-black text-bold">Property Categories</h1>
                </div>
            </div>
            <div class="py-3">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        {{-- <x-welcome /> --}}
                        <div class="create_category m-2">
                            <h1></h1>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{route('category.update', $category->id)}}" method="POST" enctype="multipart/form-data" style="width: 50%;margin-left:20px;">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ $category->name }}" class="form-control" id="name" required>
                                </div>


                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" name="image_url" accept="image/*" class="form-control" id="image_url"></input>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
           @include('admin.footer')


        </div>


    </div>

</x-layout>
