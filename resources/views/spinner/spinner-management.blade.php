<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('SCG VN PRIZE SPINNER') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white min-h-96 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900" id="selectEvents">
                    <h3 class="text-xl font-bold">Chọn sự kiện</h3>
                    <div class="flex items-center mt-3 justify-between">
                        <div class="w-2/12">
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Từ ngày</label>
                            <input type="date" name="start_date" id="start_date"
                                   class="form-input rounded-md shadow-sm mt-1 block">
                        </div>
                        <div class="w-2/12">
                            <label for="end_date" class="block text-sm font-medium text-gray-700 ml-4">Đến
                                ngày</label>
                            <input type="date" name="end_date" id="end_date"
                                   class="form-input rounded-md shadow-sm mt-1 block">
                        </div>
                        <div class="w-7/12">
                            <label for="end_date" class="block text-sm font-medium text-gray-700 ml-4">Sự kiện</label>
                            <select name="event" id="event" class="form-select rounded-md mt-1 w-full shadow-sm">
                                <option value="0">Chọn sự kiện</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}">{{ $event->title }}
                                        - {{ $event->content }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-1/12 items-center justify-self-center">
                            <button type="reset" id="reset"
                                    class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 mx-2 rounded mt-6">
                                Reset
                            </button>
                        </div>
                    </div>

                    <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="mt-3 block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        Bắt đầu quay thưởng
                    </button>

                    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Đóng</span>
                                </button>
                                <div class="p-4 md:p-5 text-center">
                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <h3 class="mb-1 text-lg font-normal text-gray-500 dark:text-gray-400">Bắt đầu quay số?</h3>
                                    <h3 class="mb-1 text-sm font-normal text-gray-500 dark:text-gray-400">Tên sự kiện: <span id="event-name"></span></h3>
                                    <h3 class="mb-5 text-sm font-normal text-gray-500 dark:text-gray-400">Mã sự kiện: <span id="event-id"></span>   </h3>
                                    <button id="start-spinner" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                        Đúng, bắt đầu quay
                                    </button>
                                    <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Chọn lại</button>
                                </div>
                            </div>
                        </div>
                    </div>

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
                    <table class="min-w-full divide-y divide-gray-200 hidden" id="agencyTable">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Nhóm từ khóa') }}
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Mã đại lý') }}
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Tên đại lý') }}
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Địa chỉ') }}
                            </th>
                            <th class="px-6 py-3 bg-gray-50"></th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="tbody">
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <div class="text-sm leading-5 text-gray-900">1</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <div class="text-sm leading-5 text-gray-900">1</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <div class="text-sm leading-5 text-gray-900">1</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <div class="text-sm leading-5 text-gray-900">1</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                <a href="#"
                                   class="text-indigo-600 hover:text-indigo-900">Xem chi tiết</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#end_date').change(function () {
                let start_date = $('#start_date').val();
                let end_date = $('#end_date').val();
                if (start_date === '' || end_date === '') {
                    alert('Vui lòng chọn ngày bắt đầu và ngày kết thúc');
                } else if (start_date > end_date) {
                    alert('Ngày bắt đầu không thể lớn hơn ngày kết thúc');
                    $('#end_date').val('');
                } else {
                    getEvents(start_date, end_date);
                }
            });

            $('#start_date').change(function () {
                let start_date = $('#start_date').val();
                let end_date = $('#end_date').val();
                if (start_date === '' || end_date === '') {
                    let today = new Date();
                    end_date = today.toISOString().slice(0, 10);
                } else if (start_date > end_date) {
                    alert('Ngày bắt đầu không thể lớn hơn ngày kết thúc');
                    $('#start_date').val('');
                } else {
                    getEvents(start_date, end_date);
                }
            });

            $('#event').change(function () {
                let event_id = $('#event').val();
                if ($('#event').val() === '0') {
                    $('#agencyListText').addClass('hidden');
                    $('#agencyTable').addClass('hidden');
                } else {
                    getAgencies(event_id);
                    $('#event-name').text($('#event option:selected').text());
                    $('#event-id').text(event_id);
                }
            });

            $('#reset').click(function () {
                $('#start_date').val('');
                $('#end_date').val('');
                $('#event').val(0);
                $('#agencyListText').addClass('hidden');
                $('#agencyTable').addClass('hidden');
                $('#emptyList').addClass('hidden');
            });

            $('#start-spinner').click(function (e) {
                e.preventDefault();
                let event_id = $('#event').val();
                if ($('#event').val() === '0') {
                    alert('Vui lòng chọn sự kiện');
                    return;
                } else {
                    window.location.href = '/spinner/' + event_id;
                }
            });


            function getEvents(start_date, end_date) {
                $.ajax({
                    url: '{{ route('events.filter') }}',
                    type: 'GET',
                    data: {
                        start_date: start_date,
                        end_date: end_date,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    success: function (data) {
                        console.log(data)
                        if (data.length === 0) {
                            alert('Không có sự kiện nào trong khoảng thời gian này');
                        }

                        $('#event').empty();
                        $('#event').append('<option value="0">Chọn sự kiện</option>');
                        $.each(data, function (index, value) {
                            $('#event').append('<option value="' + value.id + '">' + value.title + ' - ' + value.content + '</option>');
                        });

                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }

            function getAgencies(event_id) {
                $.ajax({
                    url: '{{ route('events.show-agencies') }}',
                    type: 'GET',
                    data: {
                        event_id: event_id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    success: function (data) {
                        console.log(data)
                        if (data.length === 0) {
                            console.log('Không có đại lý nào trong sự kiện này');
                            $('#agencyListText').addClass('hidden');
                            $('#agencyTable').addClass('hidden');
                            $('#emptyList').removeClass('hidden');
                            return;
                        }

                        $('#emptyList').addClass('hidden');
                        $('#agencyListText').removeClass('hidden');
                        $('#agencyTable').removeClass('hidden');
                        $('#tbody').empty();
                        $.each(data, function (index, value) {
                            $('#tbody').append('<tr>' +
                                '<td class="px-6 py-4 whitespace-no-wrap">' +
                                '<div class="text-sm leading-5 text-gray-900">' + value.keywords + '</div>' +
                                '</td>' +
                                '<td class="px-6 py-4 whitespace-no-wrap">' +
                                '<div class="text-sm leading-5 text-gray-900">' + value.agency_id + '</div>' +
                                '</td>' +
                                '<td class="px-6 py-4 whitespace-no-wrap">' +
                                '<div class="text-sm leading-5 text-gray-900">' + value.agency_name + '</div>' +
                                '</td>' +
                                '<td class="px-6 py-4 whitespace-no-wrap">' +
                                '<div class="text-sm leading-5 text-gray-900">' + value.district + ' - ' + value.province + '</div>' +
                                '</td>' +
                                '<td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">' +
                                '<a href="#" class="text-indigo-600 hover:text-indigo-900">Xem chi tiết</a>' +
                                '</td>' +
                                '</tr>');
                        });

                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }


        });
    </script>
</x-app-layout>
