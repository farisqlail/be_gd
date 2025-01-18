@extends('template')

@section('content_header')
Add WA Admin
@endsection

@section('main_content')
<form action="{{ route('wa_admin.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="wa">WhatsApp</label>
        <input type="text" name="wa" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="image" class="form-label">Logo Admin</label>
        <input type="file" name="logo" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection