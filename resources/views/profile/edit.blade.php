@extends('layouts.app')

@section('title', '編輯個人資料')

@section('content')
   <a href="{{ url()->previous() }}" class="text-green-600 hover:underline">← 返回上一頁</a>
    <h2 class="font-semibold text-xl text-green-800 mb-6">個人資料</h2>

    <div class="space-y-6">
        <div class="p-6 bg-white rounded shadow">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="p-6 bg-white rounded shadow">
            @include('profile.partials.update-password-form')
        </div>

        <div class="p-6 bg-white rounded shadow">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection
