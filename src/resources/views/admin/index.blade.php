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

<div class="admin__content">
    <div class="admin__title">
        <h2>Admin</h2>
    </div>

    <form class="search-form" action="/admin" method="get" enctype="multipart/form-data">
        <div class="search-form__group">

            <div class="search-form__item">
                <input
                    type="text"
                    name="keyword" p
                    laceholder="名前やメールアドレスを入力してください"
                    value="{{ request('keyword') }}">
            </div>

            <div class="search-form__item">
                <select name="gender">
                    <option value="">性別</option>
                    <option value="1">男性</option>
                    <option value="2">女性</option>
                    <option value="3">その他</option>
                </select>
            </div>

            <div class="search-form__item">
                <select name="category_id">
                    <option value="">お問い合わせの種類</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->content }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="search-form__item">
                <input type="date" name="date">
            </div>

            <div class="search-form__button">
                <button type="submit" class="search-form__button-submit">
                    検索
                </button>

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
                <th>お名前</th>
                <th>性別</th>
                <th>メールアドレス</th>
                <th>お問い合わせの種類</th>
                <th></th>
            </tr>

            @foreach($contacts as $contact)
            <tr class="admin-table__row">

                <td>
                    {{ $contact->last_name }} {{ $contact->first_name }}
                </td>

                <td>
                    @if($contact->gender == 1)
                    男性
                    @elseif($contact->gender == 2)
                    女性
                    @else
                    その他
                    @endif
                </td>

                <td>
                    {{ $contact->email }}
                </td>

                <td>
                    {{ $contact->category->content }}
                </td>

                <td>
                    <a href="/admin?keyword={{ request('keyword') }}&modal={{ $contact->id }}" class="admin-table__detail">
                        詳細
                    </a>
                </td>
            </tr>
            @endforeach

            @foreach ($contacts as $contact)
            @if(request('modal') == $contact->id)
            <div class="modal">
                <div class="modal-content">

                    <p>名前</p>
                    <p>{{ $contact->last_name }} {{ $contact->first_name }}</p>

                    <p>メール</p>
                    <p>{{ $contact->email }}</p>

                    <p>お問い合わせ内容</p>
                    <p>{{ $contact->detail }}</p>

                    <form action="/delete/{{ $contact->id }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                        <button>削除</button>
                    </form>

                    <a href="/admin">閉じる</a>

                </div>
            </div>
            @endif
            @endforeach
        </table>
    </div>
</div>

@endsection