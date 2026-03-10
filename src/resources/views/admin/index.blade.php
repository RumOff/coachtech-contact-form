@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
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

<div class="admin__content">
    <div class="admin__title">
        <h2>Admin</h2>
    </div>

    <form class="search-form" action="/admin" method="get" enctype="multipart/form-data">
        <div class="search-form__group">

            <div class="search-form__item">
                <input
                    type="text"
                    name="keyword"
                    placeholder="名前やメールアドレスを入力してください"
                    value="{{ request('keyword') }}">
            </div>

            <div class="search-form__item">
                <select name="gender">
                    <option value="">性別</option>
                    <option value="">全て</option>
                    <option value="1">男性</option>
                    <option value="2">女性</option>
                    <option value="3">その他</option>
                </select>
            </div>

            <div class="search-form__item">
                <select name="category_id">
                    <option value="">お問い合わせの種類</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}{{ request('category_id') == $category->id ? 'selected' : '' }}">
                        {{ $category->content }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="search-form__item">
                <input type="date" name="date">
            </div>

            <div class="search-form__item">
                <input type="hidden" name="page" value="{{ request('page') }}">
                <button type="submit" class="search-form__button-submit form__button__content">
                    検索
                </button>
            </div>
            <div class="search-form__item">
                <a href="/admin" class="search-form__button-reset">
                    リセット
                </a>
            </div>
        </div>
    </form>

    <div class="admin__utility">

        <form class="admin__export" action="/export" method="get">
            <div class="admin__export">

                <input type="hidden" name="name" value="{{ request('last_name') }} . {{ 'first_name' }}">
                <input type="hidden" name="gender" value="{{ request('gender') }}">
                <input type="hidden" name="mail" value="{{ request('mail') }}">
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                <input type="hidden" name="date" value="{{ request('date') }}">

                <button type="submit" class="admin__button-export">エクスポート</button>
            </div>

        </form>

        <div class="admin__pagination">
            {{ $contacts->appends(request()->query())->links() }}
        </div>

    </div>

    <div class="admin-table">

        <table class="admin-table__inner">

            <tr class="admin-table__row">
                <th class="admin-table__header">お名前</th>
                <th class="admin-table__header">性別</th>
                <th class=" admin-table__header">メールアドレス</th>
                <th class="admin-table__header">お問い合わせの種類</th>
                <th class="admin-table__header"></th>
            </tr>

            @foreach($contacts as $contact)
            <tr class=" admin-table__row">

                <td class="admin-table__text">
                    {{ $contact->last_name }} {{ $contact->first_name }}
                </td>

                <td class="admin-table__text">
                    @if($contact->gender == 1)
                    男性
                    @elseif($contact->gender == 2)
                    女性
                    @else
                    その他
                    @endif
                </td>

                <td class="admin-table__text">
                    {{ $contact->email }}
                </td>

                <td class="admin-table__text">
                    {{ $contact->category->content }}
                </td>

                <td class="admin-table__text">
                    <a href="{{ request()->fullUrlWithQuery(['modal' => $contact->id, 'page' => request('page', 1)]) }}" class="admin-table__detail">
                        詳細
                    </a>
                </td>
            </tr>
            @endforeach

            @foreach ($contacts as $contact)
            @if(request('modal') == $contact->id)
            <div class="modal">
                <div class="modal__inner">

                    <a class="modal__close-button" href="{{ request()->fullUrlWithQuery(['modal' => null]) }}">&times;</a>

                    <div class="modal__content">
                        <p class="modal__content--title">名前</p>
                        <p class="modal__content--data">{{ $contact->last_name }} {{ $contact->first_name }}</p>
                    </div>

                    <div class="modal__content">
                        <p class="modal__content--title">性別</p>
                        <p class="modal__content--data">
                            @if($contact->gender == 1)
                            男性
                            @elseif($contact->gender == 2)
                            女性
                            @else
                            その他
                            @endif
                        </p>
                    </div>

                    <div class=" modal__content">
                        <p class="modal__content--title">メール</p>
                        <p class=" modal__content--data">{{ $contact->email }}</p>
                    </div>

                    <div class=" modal__content">
                        <p class="modal__content--title">電話番号</p>
                        <p class=" modal__content--data">{{ $contact->tel }}</p>
                    </div>

                    <div class=" modal__content">
                        <p class="modal__content--title">住所</p>
                        <p class=" modal__content--data">{{ $contact->address }}</p>
                    </div>

                    <div class=" modal__content">
                        <p class="modal__content--title">建物名</p>
                        <p class=" modal__content--data">{{ $contact->building }}</p>
                    </div>

                    <div class=" modal__content">
                        <p class="modal__content--title">お問い合わせの種類</p>
                        <p class=" modal__content--data">{{ $contact->category->content }}</p>
                    </div>

                    <div class=" modal__content">
                        <p class="modal__content--title">お問い合わせ内容</p>
                        <p class=" modal__content--data">{{ $contact->detail }}</p>
                    </div>

                    <div class="modal__button-container">
                        <form action="/delete/{{ $contact->id }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="page" value="{{ request('page') }}">
                            <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                            <button class="modal__content--button">削除</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </table>
    </div>
</div>

@endsection