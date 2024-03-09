<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hồ sơ') }}
        </h2>
        @if(session('status') === 'password-updated')
            <div class="text-sm mt-5 text-green-600">
                {{ __('Mật khẩu đã được cập nhật.') }}
            </div>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Sao lưu Database') }}
                    </h2>
                    {{--                    export current db to sql file--}}
                    <form method="post" action="{{ route('backup') }}" class="mt-6 space-y-6">
                        @csrf
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Sao lưu') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
