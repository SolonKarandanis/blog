<nav class="flex items-center justify-between py-3 px-6 border-b border-gray-900 dark:border-gray-100">
    <div id="nav-left" class="flex items-center">
        <a href="{{route('home')}}">
            <x-application-mark class="block h-9 w-auto" />
        </a>
        <div class="top-menu ml-10">
            <div class="flex space-x-4">
                <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                    {{ __('menu.home') }}
                </x-nav-link>
                <x-nav-link href="{{ route('posts.index') }}" :active="request()->routeIs('posts.index')">
                    {{ __('menu.blog') }}
                </x-nav-link>
            </div>
        </div>
    </div>
    <div id="nav-right" class="flex items-center md:space-x-6">
        <div class="flex space-x-4">
            @foreach (config('app.supported_locales') as $locale => $data)
                <x-nav-link href="{{ route('locale', $locale) }}" :active="app()->getLocale()=== $locale">
                    <x-dynamic-component :component="'flag-country-' . $data['icon']" class="w-6 h-6" />
                </x-nav-link>
            @endforeach
        </div>
        @auth
            @include('layouts.partials.header-right-auth')
        @else
            @include('layouts.partials.header-right-guest')
        @endauth
    </div>
</nav>
