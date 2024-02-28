<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dữ liệu đại lý') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-emerald-950 font-bold">
                    {{ __("Chọn sự kiện") }}
                </div>

                <div class="p-6 text-gray-900" id="selectEvents">
                    <form action="{{ route('agencies-management') }}" method="get">
                        <select name="event" id="event" class="form-select rounded-md shadow-sm mt-1 block w-1/4">
                            <option value="0">Chọn sự kiện</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}">{{ $event->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded mt-2">Chọn</button>
                    </form>
                </div>

                <div class="p-6 text-emerald-950 font-bold">
                    {{ __("Danh sách đại lý") }}
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
