@php use Carbon\Carbon; @endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chi tiết sự kiện') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white min-h-40 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold">Thông tin sự kiện</h3>
                </div>
                <div class="event-detail">
                    <div class="px-6 mb-6 text-gray-900">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="eventName" class="block text-sm font-bold text-gray-700">Tên sự kiện</label>
                                <p class="text-gray-900" id="eventName">{{ $event->title }}</p>
                            </div>
                            <div>
                                <label for="eventDate" class="block text-sm font-bold text-gray-700">Ngày diễn
                                    ra</label>
                                <p class="text-gray-900" id="eventDate">
                                    Từ {{ Carbon::parse($event->start_date)->format('d/m/Y') }}
                                    đến {{ Carbon::parse($event->end_date)->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <label for="eventDescription" class="block text-sm font-bold text-gray-700">Nội
                                    dung</label>
                                <p class="text-gray-900" id="eventDescription">{{ $event->content }}</p>
                            </div>
                            <div>
                                <label for="eventStatus" class="block text-sm font-bold text-gray-700">Trạng
                                    thái</label>
                                @php
                                    $status = '';
                                    if ($event->status === 'draft') {
                                        $status = 'Bản nháp';
                                    } elseif ($event->status === 'published') {
                                        $status = 'Đã xuất bản';
                                    } else {
                                        $status = 'Đã lưu trữ';
                                    }
                                @endphp
                                <p class="text-gray-900" id="eventStatus">{{ $status }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white min-h-40 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900" id="selectEvents">
                    <h3 class="text-xl font-bold">Đại lý tham gia</h3>
                </div>

                <div id="agencyListText" class="p-6 text-emerald-950 font-bold hidden">
                    {{ __("Danh sách đại lý") }}
                </div>

                <div id="emptyList" class="p-6 text-emerald-950 font-bold hidden">
                    <div class="text-emerald-950 font-bold">
                        {{ __("Hiện không có đại lý nào trong sự kiện này, bạn có thể:") }}
                    </div>
                    <div class="flex items-center justify-start mt-3">
                        <button
                                class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 mx-2 px-4 rounded mt-2">
                            <a href="{{ route('events.create') }}">Thêm đại lý</a></button>

                        <button class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 mx-2 px-4 rounded mt-2">
                            <a>Nhập từ Excel (khuyến khích)</a>
                        </button>
                    </div>
                </div>

                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200" id="agencyTable">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Nhóm từ khóa') }}
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Mã đại lý') }}
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Tên đại lý') }}
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Địa chỉ') }}
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Giải thưởng') }}
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Hành động') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="tbody">
                        @foreach($agencies as $agency)
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap text-center">
                                    <div class="text-sm leading-5 text-gray-900">{{ $agency->keywords }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-center">
                                    <div class="text-sm leading-5 text-gray-900">{{ $agency->agency_id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-center">
                                    <div class="text-sm leading-5 text-gray-900">{{ $agency->agency_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-center">
                                    <div class="text-sm leading-5 text-gray-900">{{ $agency->district }}
                                        - {{ $agency->province }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-center">
                                    <div class="text-sm leading-5 text-gray-900">{{ $agency->prize ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-center text-sm leading-5 font-medium">
                                    <a href="#" id="editAgency"
                                       class="text-slate-600 hover:text-blue-600">Sửa</a> -
                                    <a href="#" id="{{ $agency->id }}"
                                       class="text-slate-600 hover:text-red-900 deleteAgency">Xóa</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white min-h-40 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900" id="selectEvents">
                    <h3 class="text-xl font-bold">Danh sách phần thưởng</h3>
                </div>

                <div id="agencyListText" class="p-6 text-emerald-950 font-bold hidden">
                    {{ __("Danh sách giải thưởng") }}
                </div>

                @if ($prizes->count() === 0)
                    <div id="emptyList" class="p-6 text-emerald-950 font-bold">
                        <div class="text-emerald-950 font-bold">
                            {{ __("Hiện không có danh sách phần thưởng trong sự kiện này, bạn có thể:") }}
                        </div>
                        <div class="flex items-center justify-start mt-3">
                            <button
                                    class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 mx-2 px-4 rounded mt-2">
                                <a href="{{ route('events.create') }}">Thêm phần thưởng</a></button>

                            <button class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 mx-2 px-4 rounded mt-2">
                                <a>Nhập từ Excel (khuyến khích)</a>
                            </button>
                        </div>
                    </div>
                @else
                    <div class="p-6 text-gray-900">
                        <table class="min-w-full divide-y divide-gray-200" id="agencyTable">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Tên giải thưởng') }}
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Số lượng') }}
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Mô tả') }}
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Đại lý trúng giải') }}
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Hành động') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="tbody">
                            @foreach($event->prizes as $prize)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap text-center">
                                        <div class="text-sm leading-5 text-gray-900">{{ $prize->prize_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-center">
                                        <div class="text-sm leading-5 text-gray-900">{{ $prize->prize_qty }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-center">
                                        <div class="text-sm leading-5 text-gray-900">{{ $prize->prize_desc }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-center">
                                        <div class="text-sm leading-5 text-gray-900">
                                            {{ $prize->agency_id ? $prize->agency->agency_name : '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-center text-sm leading-5 font-medium">
                                        <a href="#" id="editPrize"
                                           class="text-slate-600 hover:text-blue-600">Sửa</a> -
                                        <a href="#" id="{{ $prize->id }}"
                                           class="text-slate-600 hover:text-red-900 deletePrize">Xóa</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
            </div>
        </div>
    </div>

    <script>
        console.log('Hello from event-detail.blade.php')
        console.log('Event: ', @json($event))
        console.log('Agencies: ', @json($event->agencies))
        console.log('Prizes: ', @json($prizes))
        console.log('Prize agencies: ', @json($event->agencies->pluck('prize')))
    </script>

</x-app-layout>