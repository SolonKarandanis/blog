<footer class="text-sm space-x-4 flex items-center border-t border-gray-900 dark:border-gray-100 flex-wrap justify-center py-4 ">
    <div class="flex space-x-4">
        @foreach (config('app.supported_locales') as $locale => $data)
            <x-nav-link href="{{ route('locale', $locale) }}" :active="app()->getLocale()=== $locale">
                <x-dynamic-component :component="'flag-country-' . $data['icon']" class="w-6 h-6" />
            </x-nav-link>
        @endforeach
    </div>
    <div class="flex space-x-4">
        <a class="text-gray-500 hover:text-red-500" href="">{{ __('menu.login') }}</a>
        <a class="text-gray-500 hover:text-red-500" href="">{{ __('menu.profile') }}</a>
        <a class="text-gray-500 hover:text-red-500" href="">{{ __('menu.blog') }}</a>
    </div>
</footer>
