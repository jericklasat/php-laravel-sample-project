@extends('layouts.app')

@section('content')
  <user-profile></user-profile>
@endsection

@section('additional_js')
    <script src="{{ mix('js/user_profile.js') }}"></script>
@endsection