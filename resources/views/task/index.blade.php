@extends('layout')

@section('content')
<div class="row">

    <div class="col-3">
        <div class="card text-center">
            <div class="card-header bg-dark text-white">
                Latest Tasks
            </div>
            <div class="card-body">
                @foreach($latest as $key => $value)
                <div class="card">
                    <div class="card-body">
                        {{ $value->title }}
                        @if($value->completed)
                        <span class="badge bg-success">Completed</span>
                        @else
                        <span class="badge bg-warning text-dark">Incomplete</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="card text-center">
            <div class="card-header bg-dark text-white">
                Tasks List
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tasks</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $key => $value)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>
                                {{ $value->title }}
                                @if($value->completed)
                                <span class="badge bg-success">Completed</span>
                                @else
                                <span class="badge bg-warning text-dark">Incomplete</span>
                                @endif
                            </td>

                            <td>
                                <span class="text-danger">
                                    <i title="Delete" style="cursor:pointer" class="fas fa-trash" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $value->id }}"></i>
                                </span>

                                <!-- Modal -->
                                <div class="modal fade" id="deleteModal{{ $value->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete Task</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete a task '{{ $value->title }}' ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">No</button>
                                                <form action="{{ url('tasks/'.$value->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-trash"></i> Yes, Delete it
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <span class="text-warning">
                                    <i title="Edit" style="cursor:pointer" class="fas fa-edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $value->id }}"></i>
                                </span>
                                <!-- Modal -->
                                <div class="modal fade" id="editModal{{ $value->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Change the value and click Edit Task
                                                <form action="{{ url('tasks/'.$value->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                      <input 
                                                        type="text" class="form-control" 
                                                        placeholder="Edit Task ..."
                                                        value="{{ $value->title }}"
                                                        name="title"
                                                        >
                                                    </div>
                                                    <div class="mb-3">
                                                      <input 
                                                        type="checkbox" 
                                                        name="completed"
                                                        class="form-check-input"
                                                        @if($value->completed)
                                                            checked
                                                        @endif                                                       
                                                        >
                                                      <label class="form-check-label">Mark as Complete</label>
                                                    </div>
                                                    <button type="submit" class="btn btn-warning">
                                                        <i class="fas fa-edit"></i> Edit Task
                                                    </button>
                                                  </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $tasks->links("pagination::bootstrap-4") !!}
            </div>
        </div>
    </div>

    <div class="col-3">
        <div class="card text-center mb-3">
            <div class="card-header bg-dark text-white">
                Add Task
            </div>
            <div class="card-body">
                <form action="{{ url('tasks') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="title" class="form-control" placeholder="Enter Task ..."
                            autocomplete="off">
                    </div>
                    @if(session('create'))
                    <div class="alert alert-success">
                        {{ session('create') }}
                    </div>
                    @endif
                    @error('title')
                    <p class="text-danger">
                        <strong>{{ $message }}</strong>
                    </p>
                    @enderror
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-sm">Add Task</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card text-center">
            <div class="card-header bg-dark text-white">
                Tasks Stats
            </div>
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        Total Task: {{ $total }}
                    </div>
                    <div class="card-body">
                        Completed Task: {{ $complete }}
                    </div>
                    <div class="card-body">
                        Incomplete Task: {{ $incomplete }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection