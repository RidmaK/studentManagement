@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Student') }}</div>

                    <div class="card-body">
                        <div class="container mt-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2>Students</h2>
                                    <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                        data-bs-target="#addStudentModal">Add Student</a>
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Guardian</th>
                                                <th>Courses</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($students as $student)
                                                <tr>
                                                    <td>{{ $student->name }}</td>
                                                    <td>{{ $student->email }}</td>
                                                    <td>{{ $student->guardian->name }}</td>
                                                    <td>
                                                        @foreach ($student->courses as $course)
                                                            {{ $course->name }}<br>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-info"
                                                            onclick="showStudent({{ $student->id }})">Show</button>
                                                        <button class="btn btn-warning"
                                                            onclick="editStudent({{ $student->id }})">Edit</button>
                                                        <form action="{{ route('student.destroy', $student->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Add Student Modal -->
                        <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('student.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="guardian_id">Guardian</label>
                                                <select class="form-control" id="guardian_id" name="guardian_id" required>
                                                    @foreach ($guardians as $guardian)
                                                        <option value="{{ $guardian->id }}">{{ $guardian->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="courses">Courses</label>
                                                <select class="form-control" id="courses" name="courses[]" multiple
                                                    required>
                                                    @foreach ($courses as $course)
                                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Student Modal -->
                        <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form id="editStudentForm" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="edit_name">Name</label>
                                                <input type="text" class="form-control" id="edit_name" name="name"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_email">Email</label>
                                                <input type="email" class="form-control" id="edit_email" name="email"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_guardian_id">Guardian</label>
                                                <select class="form-control" id="edit_guardian_id" name="guardian_id"
                                                    required>
                                                    @foreach ($guardians as $guardian)
                                                        <option value="{{ $guardian->id }}">{{ $guardian->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="edit_courses">Courses</label>
                                                <select class="form-control" id="edit_courses" name="courses[]" multiple
                                                    required>
                                                    @foreach ($courses as $course)
                                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Show Student Modal -->
                        <div class="modal fade" id="showStudentModal" tabindex="-1"
                            aria-labelledby="showStudentModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="showStudentModalLabel">Student Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Name:</strong> <span id="show_name"></span></p>
                                        <p><strong>Email:</strong> <span id="show_email"></span></p>
                                        <p><strong>Guardian:</strong> <span id="show_guardian"></span></p>
                                        <p><strong>Courses:</strong> <span id="show_courses"></span></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function showStudent(id) {
            fetch(`/student/${id}`)
                .then(response => response.json()) // Ensure to parse the JSON response
                .then(data => {
                    document.getElementById('show_name').innerText = data.name;
                    document.getElementById('show_email').innerText = data.email;
                    document.getElementById('show_guardian').innerText = data.guardian.name;
                    document.getElementById('show_courses').innerHTML = data.courses.map(course => course.name).join(
                        '<br>');
                    new bootstrap.Modal(document.getElementById('showStudentModal')).show();
                });
        }

        function editStudent(id) {
            console.log(id)
            fetch(`/student/${id}/edit`)
                .then(response => response.json()) // Ensure to parse the JSON response
                .then(data => {
                    console.log(data);
                    document.getElementById('editStudentForm').action = `/student/${id}`;
                    document.getElementById('edit_name').value = data.student.name;
                    document.getElementById('edit_email').value = data.student.email;
                    document.getElementById('edit_guardian_id').value = data.student.guardian_id;
                    let courseOptions = Array.from(document.getElementById('edit_courses').options);
                    courseOptions.forEach(option => {
                        option.selected = data.student.courses.some(course => course.id == option.value);
                    });
                    // Show the modal
                    const editStudentModal = new bootstrap.Modal(document.getElementById('editStudentModal'));
                    editStudentModal.show();
                });
        }
    </script>
@endsection
