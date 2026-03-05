@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/comfirm.css') }}">
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

<div class="confirm__content">
    <div class="confirm__heading">
        <h2>お問い合わせ内容確認</h2>
    </div>
    <form class="form" action="/confirm/store" method="post">
        @csrf
        <div class="confirm-table">
            <table class="confirm-table__inner">
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お名前</th>
                    <td class="confirm-table__text">
                        {{ $contact['last_name']}} {{ $contact['first_name'] }}
                        <input type="hidden" name="last_name" value="{{ $contact['last_name']}}" />
                        <input type="hidden" name="first_name" value="{{ $contact['first_name']}}" />
                    </td>
                </tr>

                <tr class="confirm-table__row">
                    <th class="confirm-table__header">性別</th>
                    <td class="confirm-table__text">
                        @if($contact['gender'] == 1)
                        男性
                        @elseif($contact['gender'] == 2)
                        女性
                        @else
                        その他
                        @endif

                        <input type="hidden" name="gender" value="{{ $contact['gender'] }}">
                    </td>
                </tr>

                <tr class="confirm-table__row">
                    <th class="confirm-table__header">メールアドレス</th>
                    <td class="confirm-table__text">
                        {{ $contact['email'] }}
                        <input type="hidden" name="email" value="{{ $contact['email'] }}" />
                    </td>
                </tr>

                <tr class="confirm-table__row">
                    <th class="confirm-table__header">電話番号</th>
                    <td class="confirm-table__text">
                        {{ $contact['tel1'] }}{{ $contact['tel2'] }}{{ $contact['tel3'] }}
                        <input type="hidden" name="tel1" value="{{ $contact['tel1'] }}" />
                        <input type="hidden" name="tel2" value="{{ $contact['tel2'] }}" />
                        <input type="hidden" name="tel3" value="{{ $contact['tel3'] }}" />
                    </td>
                </tr>

                <tr class="confirm-table__row">
                    <th class="confirm-table__header">住所</th>
                    <td class="confirm-table__text">
                        {{ $contact['address'] }}
                        <input type="hidden" name="address" value="{{ $contact['address'] }}" />
                    </td>
                </tr>

                <tr class="confirm-table__row">
                    <th class="confirm-table__header">建物名</th>
                    <td class="confirm-table__text">
                        {{ $contact['building'] }}
                        <input type="hidden" name="building" value="{{ $contact['building'] }}" />
                    </td>
                </tr>

                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お問い合わせの種類</th>
                    <td class="confirm-table__text">

                        {{ $category->content }}

                        <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}">
                    </td>
                </tr>

                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お問い合わせ内容</th>
                    <td class="confirm-table__text">
                        {{ $contact['detail'] }}
                        <input type="hidden" name="detail" value="{{ $contact['detail'] }}" />
                    </td>
                </tr>
            </table>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit" name="action" value="submit">送信</button>
        </div>
        <div class="form__button">
            <button class="form__button-fix" type="submit" name="action" value="back">修正</button>
        </div>
    </form>
</div>

@endsection