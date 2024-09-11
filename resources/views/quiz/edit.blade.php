
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
                        <div class="create m-2">
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
                            <form action="{{ route('quiz.update', $quiz->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <input type="text" class="form-control" id="type" name="type" value="{{ old('type', $quiz->type) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="difficulty">Difficulty</label>
                                    <input type="text" class="form-control" id="difficulty" name="difficulty" value="{{ old('difficulty', $quiz->difficulty) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <input type="text" class="form-control" id="category" name="category" value="{{ old('category', $quiz->category) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="question">Question</label>
                                    <textarea class="form-control" id="question" name="question" rows="3" required>{{ old('question', $quiz->question) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="correct_answer">Correct Answer</label>
                                    <input type="text" class="form-control" id="correct_answer" name="correct_answer" value="{{ old('correct_answer', $quiz->correct_answer) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="incorrect_answers">Incorrect Answers (comma separated)</label>
                                    <input type="text" class="form-control" id="incorrect_answers" name="incorrect_answers" value="{{ old('incorrect_answers', implode(', ', $quiz->incorrect_answers)) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="category_id">Category ID</label>
                                    <input type="number" class="form-control" id="category_id" name="category_id" value="{{ old('category_id', $quiz->category_id) }}" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Update Quiz</button>
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
