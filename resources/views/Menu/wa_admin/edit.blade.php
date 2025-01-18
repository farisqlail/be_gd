@extends('template')

@section('content_header')
Edit WA Admin
@endsection

@section('main_content')
<form action="{{ route('wa_admin.update', $waAdmin->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" value="{{ $waAdmin->name }}" required>
    </div>
    <div class="form-group">
        <label for="wa">WhatsApp</label>
        <input type="text" name="wa" class="form-control" value="{{ $waAdmin->wa }}" required>
    </div>
    <div class="form-group">
        <label for="image" class="form-label">Logo Admin</label>
        <input type="file" name="logo" class="form-control">
        @if ($waAdmin->logo)
        <p class="mt-2">Logo saat ini:</p>
        <img src="{{ asset('storage/' . $waAdmin->logo) }}" alt="{{ $waAdmin->name }}" style="max-width: 150px;">
        @endif
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection