@extends('template')  
  
@section('content_header')  
    Edit WA Admin  
@endsection  
  
@section('main_content')  
<form action="{{ route('wa_admin.update', $waAdmin->id) }}" method="POST">  
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
    <button type="submit" class="btn btn-primary">Update</button>  
</form>  
@endsection  
