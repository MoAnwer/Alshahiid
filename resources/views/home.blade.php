@include('components.header', ['page_title' => __('messages.login_form')])



<h1>{{ __('messages.home_page') }}</h1>
<h4> {{ __('messages.welcome', ['name' => auth()->user()->username]) }} 🤗👋🏼</h4>

<a href="{{ route('martyrs.index') }}">قائمة الشهداء</a>