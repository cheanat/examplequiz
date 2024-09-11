<base href="/public"/>
<x-layout>
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin.sidebar');


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
              @include('admin.topbar')


              <div class="container-fluid">
                <div class="">
                    <h1 class="h3 ms-6 text-black text-bold">Property Room</h1>
                </div>
            </div>
            <div class="py-3">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        {{-- <x-welcome /> --}}
                        <div class="create m-2">
                            <h1></h1>
                            <a href="{{ route('quiz.create') }}" class="btn btn-primary">Add New Quiz</a>
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success mt-2">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                            <table class="table table-bordered mt-3">
                                <tr>
                                    <th>ID</th>
                                    <th>question</th>
                                    <th>correct_answer</th>
                                    <th>incorrect_answer</th>
                                    <th>category</th>
                                    <th>difficulty</th>
                                    <th>type</th>

                                    <th>category_id</th>
                                    <th>Actions</th>
                                </tr>
                                @foreach ($quizzes as $quiz)
                                <tr>
                                    <td>{{ $quiz->id }}</td>
                                    <td>{{  $quiz->question }}</td>
                                    <td>{{ $quiz->correct_answer }}</td>
                                    <td>{{ implode(', ', $quiz->incorrect_answers) }}</td>
                                    <td>{{ $quiz->category }}</td>
                                    <td>{{  $quiz->difficulty }}</td>
                                    <td>{{  $quiz->type }}</td>
                                    <td>{{ $quiz->category_id }}</td>




                                    <td class="d-flex">

                                        <a href="{{route('quiz.edit',$quiz->id)}}" class="btn btn-primary me-2" style="max-width: 50px;height:40px;margin-right:20px">Edit</a>
                                        <form action="{{ route('quiz.destroy', $quiz->id) }}"  method="POST" >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
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
