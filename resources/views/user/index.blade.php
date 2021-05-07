@extends('layouts.app')

@section('content')
  <user></user>
@endsection

@section('additional_js')
    <script src="{{ mix('js/user.js') }}"></script>
@endsection