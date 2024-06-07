@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route("admin.dashboard") }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route("admin.categories") }}">Jobs</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('admin.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.message')

                <form action="" method="post" id="editJobForm" name="editJobForm">
                    <div class="card border-0 shadow mb-4 ">
                        <div class="card-body card-form p-4">
                            <h3 class="fs-4 mb-1">Edit Category</h3>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Category<span class="req">*</span></label>
                                    <input value="{{ $category->name }}" type="text" placeholder="Category Title" id="category" name="category" class="form-control">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer  p-4">
                            <button type="submit" class="btn btn-primary">Update Job</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script type="text/javascript">
    $("#editJobForm").submit(function(e) {
        e.preventDefault();
        $("button[type='submit']").prop('disabled', true);
        $.ajax({
            url: '{{ route("admin.categories.update",$category->id) }}',
            type: 'PUT',
            dataType: 'json',
            data: $("#editJobForm").serializeArray(),
            success: function(response) {
                $("button[type='submit']").prop('disabled', false);
                if (response.status == true) {


                    $("#category").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('')

                    window.location.href = "{{ route('admin.categories') }}";

                } else {
                    var errors = response.errors;

                    if (errors.category) {
                        $("#category").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(errors.category)
                    } else {
                        $("#category").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('')
                    }
                }

            }
        });
    });

    function deleteUser(id) {
        if (confirm("Are you sure you want to delete?")) {
            $.ajax({
                url: '{{ route("admin.users.destroy") }}',
                type: 'delete',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    window.location.href = "{{ route('admin.categories') }}";
                }
            });
        }
    }
</script>
@endsection