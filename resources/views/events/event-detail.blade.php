@php use Carbon\Carbon; @endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('events-management') }}"
               class="text-sm text-emerald-500 hover:text-emerald-700">Quản lý sự kiện</a>
            / {{ __('Chi tiết sự kiện') }}
        </h2>

        @if (session('success'))
            <div class="py-5 text-2xl text-green-500">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="py-5 text-2xl text-red-500">
                {{ session('error') }}
            </div>
        @endif

    </x-slot>
    <div class="mt-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-start">
                <button data-modal-target="editModal" data-modal-toggle="editModal"
                        class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 me-2 px-4 rounded mt-2">
                    Chỉnh sửa
                </button>

                <button data-modal-target="addAgencyModal" data-modal-toggle="addAgencyModal"
                        class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 mx-2 px-4 rounded mt-2">
                    <a href="#">Thêm đại lý</a></button>

                <button data-modal-target="addPrizeModal" data-modal-toggle="addPrizeModal"
                        class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 mx-2 px-4 rounded mt-2">
                    <a href="#">Thêm phần thưởng</a></button>

                <button class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 mx-2 px-4 rounded mt-2">
                    <a href="#">Xuất file Excel</a></button>

                <button class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 mx-2 px-4 rounded mt-2">
                    Nhân đôi sự kiện
                </button>

                <button data-modal-target="confirmDelModal" data-modal-toggle="confirmDelModal"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 mx-2 px-4 rounded mt-2">
                    Xóa sự kiện
                </button>
            </div>
        </div>
    </div>

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
                <div class="px-4 text-gray-900">
                    <div class="search mb-4">
                        <input type="text" class="form-input rounded-md w-full shadow-sm" id="search"
                               placeholder="Tìm kiếm">
                    </div>

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
                        @foreach($event_agencies as $agency)
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap text-center">
                                    <div class="text-sm leading-5 text-gray-900">{{ $agency->agency->keywords }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-center">
                                    <div class="text-sm leading-5 text-gray-900">{{ $agency->agency->agency_id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-center">
                                    <div class="text-sm leading-5 text-gray-900">{{ $agency->agency->agency_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-center">
                                    <div class="text-sm leading-5 text-gray-900">{{ $agency->agency->province->province }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-center">
                                    <div class="text-sm leading-5 text-gray-900">{{ $agency->prize->prize_name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-center text-sm leading-5 font-medium">
                                    <a href="#" data-modal-target="eADelModal" data-modal-toggle="eADelModal" data-agency-name="{{ $agency->agency->agency_name }}" data-agency-id="{{ $agency->agency->agency_id }}"
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

                @if ($event->prizes->count() === 0)
                    <div id="emptyList" class="p-6 text-emerald-950 font-bold">
                        <div class="text-emerald-950 font-bold">
                            {{ __("Hiện không có danh sách phần thưởng trong sự kiện này, bạn có thể:") }}
                        </div>
                        <div class="flex items-center justify-start mt-3">
                            <button data-modal-target="addPrizeModal" data-modal-toggle="addPrizeModal"
                                    class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 mx-2 px-4 rounded mt-2">Thêm phần thưởng</button>
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
                            @foreach($prizes as $prize)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap text-center">
                                        <div class="text-sm leading-5 text-gray-900">{{ $prize->prize_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-center">
                                        <div class="text-sm leading-5 text-gray-900">{{ $prize->prize_qty }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-center">
                                        <div class="text-sm leading-5 text-gray-900">{{ $prize->prize_desc ?? ' - ' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-center">
                                        <div class="text-sm leading-5 text-gray-900">
                                            @if ($prize->event_agencies->isNotEmpty())
                                                @foreach($prize->event_agencies as $agency)
                                                    {{ $agency->agency->agency_name }}
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            @else
                                                {{ '-' }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-center text-sm leading-5 font-medium">
                                        <a href="#" id="editPrize" data-modal-target="edtPrizeModal" data-modal-toggle="edtPrizeModal" data-prize-id="{{ $prize->id }}" data-prize-name="{{ $prize->prize_name }}" data-prize-qty="{{ $prize->prize_qty }}" data-prize-desc="{{ $prize->prize_desc }}"
                                           class="text-slate-600 hover:text-blue-600 editPrize">Sửa</a> -
                                        <a href="#" id="{{ $prize->id }}" data-modal-target="prizeDelModal" data-modal-toggle="prizeDelModal" data-prize-name="{{ $prize->prize_name }}"
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
    {{--    POPUP MODAL--}}
    {{--    DELETE MODAL--}}
    <div id="confirmDelModal" tabindex="-1"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Bạn có chắc muốn xóa sự
                        kiện?</h3>
                    <button data-modal-hide="confirmDelModal" type="button" id="deleteEvent"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Chắc chắn
                    </button>
                    <button data-modal-hide="confirmDelModal" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Hủy
                    </button>
                </div>
            </div>
        </div>
    </div>
{{--    delete event_agency --}}
    <div id="eADelModal" tabindex="-1"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Bạn có chắc muốn xóa đại lý: <span></span> khỏi sự kiện? </h3>
                    <button type="button" data-modal-hide="eADelModal" id="btn-del-ea"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Chắc chắn
                    </button>
                    <button data-modal-hide="confirmDelModal" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Hủy
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{--    delete prize --}}
    <div id="prizeDelModal" tabindex="-1"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Bạn có chắc muốn xóa phần thưởng: <span></span> khỏi sự kiện? </h3>
                    <button type="button" data-modal-hide="prizeDelModal" id="btn-del-prize"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Chắc chắn
                    </button>
                    <button data-modal-hide="prizeDelModal" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Hủy
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{--    edit event modal--}}
    <div id="editModal" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-2 w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-3 md:p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Chỉnh sửa sự kiện
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="editModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Đóng</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên
                                sự kiện</label>
                            <input type="text" name="event_title" id="event_title"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   placeholder="Tên sự kiện" required="" value="{{ $event->title }}">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ngày
                                bắt đầu</label>
                            <input type="date" name="start_date" id="start_date"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   value="{{ $event->start_date }}" required="">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ngày
                                kết thúc</label>
                            <input type="date" name="end_date" id="end_date"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   value="{{ $event->end_date }}" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="description"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mô tả</label>
                            <textarea id="description" rows="4"
                                      class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                      placeholder="Thông tin chi tiết sự kiện">{{ $event->content }}</textarea>
                        </div>
                        <div class="col-span-2 ">
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Trạng
                                thái</label>
                            <select id="status"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option value="draft" {{ $event->status === 'draft' ? 'selected' : '' }}>Bản nháp
                                </option>
                                <option value="published" {{ $event->status === 'published' ? 'selected' : '' }}>Đã xuất
                                    bản
                                </option>
                                <option value="archived" {{ $event->status === 'archived' ? 'selected' : '' }}>Đã lưu
                                    trữ
                                </option>
                            </select>
                        </div>
                    </div>
                    <button id="saveUpdateEvent"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Lưu
                    </button>
                    <button data-modal-hide="editModal" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Hủy
                    </button>
                </form>
            </div>
        </div>
    </div>
    {{--    add agency modal--}}
    <div id="addAgencyModal" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Thêm đại lý
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="addAgencyModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" id="addAgencyForm">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="agency_id_input"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nhập mã đại
                                lý</label>
                            {{--                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" required="">--}}
                            <textarea name="agency_id_input" id="agency_id_input" rows="4"
                                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                      placeholder="Nhập mã đại lý, mỗi đại lý là 1 dòng. Nếu trùng sẽ tự động thay thế đại lý trùng mã. Vui lòng thêm Dữ liệu đại lý trước khi thêm đại lý vào sự kiện!"
                                      required=""></textarea>
                        </div>
                    </div>
                    <button type="submit" data-modal-hide="addAgencyModal"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Thêm đại lý
                    </button>
                </form>
            </div>
        </div>
    </div>
{{--    add prize modal--}}
    <div id="addPrizeModal" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Thêm phần thưởng
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="addPrizeModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" id="addPrizeForm">
                    <table id="table" class="min-w-full divide-y divide-gray-200 hidden">
                        <thead>
                        <tr>
                            <th class="text-left dark:text-white">Tên giải thưởng</th>
                            <th class="text-left dark:text-white">Số lượng</th>
                            <th class="text-left dark:text-white">Mô tả</th>
                            <th class="text-left dark:text-white">Hành động</th>
                        </tr>
                        </thead>
                        <tbody id="prize-list">
                        </tbody>
                    </table>
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2 sm:col-span-1">
                            <label for="prize_name"
                                   class="block mt-2 font-medium text-gray-900 dark:text-white">Phần
                                thưởng</label>
                            <input type="text" name="prize_name" id="prize_name"
                                   class="bg-gray-50 border border-gray-300 text-gray-900  rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   placeholder="Tên giải thưởng">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="prize_quantity"
                                   class="block mt-2  font-medium text-gray-900 dark:text-white">Số
                                lượng</label>
                            <input type="number" name="prize_quantity" id="prize_quantity" maxlength="3"
                                   class="bg-gray-50 border border-gray-300 text-gray-900  rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   max="50" placeholder="Số lượng">
                        </div>
                        <div class="col-span-2">
                            <label for="prize_description"
                                   class="block mt-2  font-medium text-gray-900 dark:text-white">Mô tả</label>
                            <textarea id="prize_description" rows="4"
                                      class="block p-2.5 w-full  text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                      placeholder="Thông tin chi tiết giải thưởng"></textarea>
                        </div>
                        <div class="col-span-2">
                            <button type="button" id="add-prize"
                                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg  px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Thêm giải thưởng
                            </button>
                        </div>
                    </div>
                    <button type="submit" disabled data-modal-hide="addPrizeModal"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Lưu
                    </button>
                </form>
            </div>
        </div>
    </div>
    {{--    edit prize modal--}}
    <div id="edtPrizeModal" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Sửa phần thưởng
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="edtPrizeModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" id="edtPrizeForm">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2 sm:col-span-1">
                            <label for="prize_name-edt"
                                   class="block mt-2 font-medium text-gray-900 dark:text-white">Phần
                                thưởng</label>
                            <input type="text" name="prize_name-edt" id="prize_name-edt"
                                   class="bg-gray-50 border border-gray-300 text-gray-900  rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   placeholder="Tên giải thưởng">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="prize_quantity-edt"
                                   class="block mt-2  font-medium text-gray-900 dark:text-white">Số
                                lượng</label>
                            <input type="number" name="prize_quantity-edt" id="prize_quantity-edt" maxlength="3"
                                   class="bg-gray-50 border border-gray-300 text-gray-900  rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   max="50" placeholder="Số lượng">
                        </div>
                        <div class="col-span-2">
                            <label for="prize_description-edt"
                                   class="block mt-2  font-medium text-gray-900 dark:text-white">Mô tả</label>
                            <textarea id="prize_description-edt" rows="4"
                                      class="block p-2.5 w-full  text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                      placeholder="Thông tin chi tiết giải thưởng"></textarea>
                        </div>
                    </div>
                    <button type="button" data-modal-hide="edtPrizeModal" id="edt-prize"
                            class="cursor-pointer text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Lưu
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#saveUpdateEvent').on('click', function (e) {
                e.preventDefault();
                if ($('#start_date').val() > $('#end_date').val()) {
                    alert('Ngày bắt đầu không thể lớn hơn ngày kết thúc');
                    return;
                }
                saveUpdateEvent();
            });

            $('#search').on('keyup', function () {
                let value = $(this).val().toLowerCase();
                $('#agencyTable tr').filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('#addAgencyForm').on('submit', function (e) {
                e.preventDefault();
                let agencyIdList = [];
                let agencyId = $('#agency_id_input').val().split('\n');
                agencyId.forEach(function (item) {
                    if (item.trim() !== '') {
                        agencyIdList.push(item.trim());
                    }
                });
                agencyIdList.forEach(function (item) {
                    addAgency(item);
                });
            });

            $('.deleteAgency').on('click', function (e) {
                e.preventDefault();
                let agency_id = $(this).data('agency-id');
                let agency_name = $(this).data('agency-name');
                $('#eADelModal span').text(agency_name);
                $('#btn-del-ea').on('click', function () {
                    deleteAgency(agency_id);
                });
            });

            $('#add-prize').on('click', function (e) {
                e.preventDefault();
                let prize_name = $('#prize_name').val();
                let prize_quantity = $('#prize_quantity').val();
                let prize_description = $('#prize_description').val();
                if (prize_name === '' || prize_quantity === '') {
                    alert('Vui lòng nhập đầy đủ thông tin');
                    return;
                }
                let prizeList = $('#prize-list');
                let prize = '<tr>' +
                    '<td>' + prize_name + '</td>' +
                    '<td>' + prize_quantity + '</td>' +
                    '<td>' + prize_description + '</td>' +
                    '<td><a class="text-slate-600 hover:text-red-900 cursor-pointer deletePrize">Xóa</a></td>' +
                    '</tr>';
                prizeList.append(prize);
                $('#prize_name').val('');
                $('#prize_quantity').val('');
                $('#prize_description').val('');
                $('.deletePrize').on('click', function (e) {
                    e.preventDefault();
                    $(this).closest('tr').remove();
                    if ($('#prize-list tr').length === 0) {
                        $('#table').addClass('hidden');
                    }
                });
                $('#table').removeClass('hidden');
                $('#addPrizeForm button').prop('disabled', false);
            });

            $('#addPrizeForm').on('submit', function (e) {
                e.preventDefault();
                let prizeList = [];
                $('#prize-list tr').each(function () {
                    let prize = {
                        prize_name: $(this).find('td').eq(0).text().trim(),
                        prize_qty: parseInt($(this).find('td').eq(1).text().trim()),
                        prize_desc: $(this).find('td').eq(2).text().trim(),
                        event_id: '{{ $event->id }}'
                    };
                    prizeList.push(prize);
                });
                addPrize(prizeList);
            });

            $('.deletePrize').on('click', function (e) {
                e.preventDefault();
                let prize_id = $(this).attr('id');
                let prize_name = $(this).data('prize-name');
                $('#prizeDelModal span').text(prize_name);
                $('#btn-del-prize').on('click', function () {
                    deletePrize(prize_id);
                });
            });

            $('.editPrize').on('click', function (e) {

                let prize_id = $(this).data('prize-id');

                $('#prize_name-edt').val($(this).data('prize-name'));
                $('#prize_quantity-edt').val($(this).data('prize-qty'));
                $('#prize_description-edt').val($(this).data('prize-desc'));

                $('#edt-prize').on('click', function (e) {
                    e.preventDefault();
                    let prize_name = $('#prize_name-edt').val();
                    let prize_quantity = $('#prize_quantity-edt').val();
                    let prize_desc = $('#prize_description-edt').val();
                    if (prize_name === '' || prize_quantity === '') {
                        alert('Vui lòng nhập đầy đủ thông tin');
                        return;
                    }
                    let data = {
                        prize_name: prize_name,
                        prize_qty: prize_quantity,
                        prize_desc: prize_desc,
                    };
                    editPrize(prize_id, data);
                });
            });

            $('#deleteEvent').on('click', function (e) {
                e.preventDefault();
                let event_id = {{ $event->id }};
                deleteEvent(event_id);
            });
        });

        function deleteAgency(agency_id) {
            console.log(agency_id);
            console.log('{{ $event->id }}')
            $.ajax({
                url: "/event-agencies/" + agency_id,
                type: 'POST',
                data: {
                    event_id: '{{ $event->id }}',
                    agency_id: agency_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status === 'success') {
                        console.log(response);
                        window.location.reload();
                    } else {
                        console.log(response);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        function deletePrize(id) {
            $.ajax({
                url: '/prizes/' + id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status === 'success') {
                        console.log(response);
                        window.location.reload();
                    } else {
                        console.log(response);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        function editPrize(id, data) {
            $.ajax({
                url: '/prizes/' + id,
                type: 'PUT',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status === 'success') {
                        console.log(response);
                        window.location.reload();
                    } else {
                        console.log(response);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        function deleteEvent(id) {
            $.ajax({
                url: '/events/' + id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status === 'success') {
                        console.log(response);
                        window.location.href = '{{ route('events-management') }}';
                    } else {
                        console.log(response);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        function addAgency(agency_id) {
            $.ajax({
                url: '{{ route('event-agencies.store_update') }}',
                type: 'POST',
                data: {
                    event_id: '{{ $event->id }}',
                    agency_id: agency_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status === 'success') {
                        console.log(response);
                        window.location.reload();
                    } else {
                        console.log(response);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        function addPrize(data) {
            $.ajax({
                url: '{{ route('prizes.store') }}',
                type: 'POST',
                data: {
                    prizes: data,
                    event_id: '{{ $event->id }}'
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status === 'success') {
                        console.log(response);
                        window.location.reload();
                    } else {
                        console.log(response);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

        function exportExcel() {
            console.log('export excel');
        }

        function duplicateEvent() {
            console.log('duplicate event');
        }

        function saveUpdateEvent() {
            $.ajax({
                url: '{{ route('events.update', $event->id) }}',
                type: 'PUT',
                data: {
                    event_title: $('#event_title').val(),
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
                    content: $('#description').val(),
                    status: $('#status').val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status === 'success') {
                        console.log(response);
                        window.location.reload();

                    } else {
                        console.log(response);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }

    </script>

</x-app-layout>