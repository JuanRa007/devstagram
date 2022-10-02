@extends('layouts.app')

@section('titulo')
Página principal
@endsection

@section('contenido')
{{-- 
  <x-listar-post>
    <x-slot:titulo>
      <header>Esto es una cabecera</header>
    </x-slot:titulo>
    <h1>Mostrando post desde slot</h1>
  </x-listar-post>
--}}
  <x-listar-post :posts="$posts" />
@endsection