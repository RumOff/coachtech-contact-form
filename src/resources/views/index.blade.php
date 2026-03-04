@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

@if(session('message'))
<div class="contact__alert">
    <div class="contact__alert--success">
        {{ session('message')}}
    </div>
</div>
@endif

@if($errors->any())
<div class="contact__alert--danger">
    <ul>
        @foreach($errors->all() as $error )
        <li> {{ $error }} </li>
        @endforeach
    </ul>
</div>
@endif

<div class="contact__content">
    <div class="section__title">
        <h2>新規作成</h2>
    </div>
    <form class="create-form" action="/contacts" method="post" enctype="multipart/form-data">
        @csrf
        <div class="create-form__item">
            <input
                class="create-form__item-input"
                type="text"
                name="content"
                value="{{ old('content') }}" />
            <select class="create-form__item-select" name="category_id">
                <option value="">カテゴリ</option>
                @foreach($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>

        </div>
        <div class="create-form__button">
            <button class="create-form__button-submit" type="submit">作成</button>
        </div>
    </form>
    <div class="section__title">
        <h2>contact検索</h2>
    </div>
    <form class="search-form" action="/contacts/search" method="get">
        @csrf
        <div class="search-form__item">
            <input class="search-form__item-input" type="text" name="keyword" value="{{ old('keyword') }}">
            <select class="search-form__item-select" name="category_id">
                <option value="">カテゴリ</option>
                @foreach($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="search-form__button">
            <button class="search-form__button-submit" type="submit">検索</button>
        </div>
    </form>
    <div class="contact-table">
        <table class="contact-table__inner">
            <tr class="contact-table__row">
                <th class="contact-table__header">
                    <span class="contact-table__header-span">contact</span>
                    <span class="contact-table__header-span">カテゴリ</span>
                </th>
            </tr>
            @foreach($contacts as $contact)
            <tr class="contact-table__row">
                <td class="contact-table__item">
                    <form class="update-form" action="/contacts/update" method="post">
                        @method('PATCH')
                        @csrf
                        <div class="update-form__item">
                            <input class="update-form__item-input" typy="text" name="content" value="{{ $contact['content'] }}">
                            <input type="hidden" name="id" value="{{ $contact['id'] }}">
                        </div>
                        <div class="update-form__item">
                            <p class="update-form__item-p">{{ $contact['category']['name'] }}</p>
                        </div>
                        <div class="update-form__button">
                            @if($user_id === $contact['user_id'])
                            <button class="update-form__button-submit" type="submit">更新</button>
                            @endif
                        </div>
                    </form>
                </td>
                <td class="contact-table__item">
                    <form class="delete-form" action="/contacts/delete" method="post">
                        @method('DELETE')
                        @csrf
                        <div class="delete-form__button">
                            @if($user_id === $contact['user_id'])
                            <input type="hidden" name="id" value="{{ $contact['id'] }}">
                            <button class="delete-form__button-submit" type="submit">削除</button>
                            @endif
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
<div class="pagination">
    {{ $contacts->withQueryString()->links() }}
</div>
@endsection