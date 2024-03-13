@php use Carbon\Carbon; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý sự kiện') }}
        </h2>
        @if (session('success'))
            <div class="py-5 text-2xl text-green-500">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="py-5 text-2xl text-red-500">
                Lỗi khi nhập file: {{ session('error') }}
            </div>
        @endif
    </x-slot>

    <div class="add-event mx-auto mt-4 max-w-7xl sm:px-6 lg:px-8">
        <button
                class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded mt-2">
            <a href="{{ route('events.create') }}">Thêm sự kiện</a></button>

        <button class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded mt-2"
                data-modal-show="uploadModal" data-modal-target="uploadModal">
            <a>Nhập từ Excel</a>
        </button>
    </div>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 pt-6 text-gray-900">
                    <a href="#" class="event-link mx-2 px-1 text-green-500 font-bold"
                       data-url="{{ route('events.all') }}">{{ __("Tất cả") }}</a>
                    <a href="#" class="event-link mx-2 px-1"
                       data-url="{{ route('events.ongoing') }}">{{ __("10 ngày tới") }}</a>
                    <a href="#" class="event-link mx-2 px-1"
                       data-url="{{ route('events.upcoming') }}">{{ __("Sắp diễn ra") }}</a>
                    <a href="#" class="event-link mx-2 px-1"
                       data-url="{{ route('events.past') }}">{{ __("Đã diễn ra") }}</a>
                </div>

                <div class="search my-2 mx-6">
                    <input type="text" class="form-input rounded-md w-full shadow-sm" id="search"
                           placeholder="Tìm kiếm">
                </div>
                <div class="mt-2 px-2 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tên sự kiện
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nội dung
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Thời gian
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Trạng thái
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Hành động
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($events as $event)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900">{{ $event->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap overflow-hidden overflow-ellipsis">
                                    <div class="text-sm max-w-md overflow-ellipsis overflow-clip text-gray-900">{{ $event->content }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900">{{ Carbon::parse($event->start_date)->format('d/m/Y') }}
                                        - {{ Carbon::parse($event->end_date)->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-center text-gray-900">
                                        @if($event->status !== null)
                                            @switch($event->status)
                                                @case('draft')
                                                    Nháp
                                                    @break
                                                @case('published')
                                                    Xuất bản
                                                    @break
                                                @default
                                                    Lưu trữ
                                            @endswitch
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <a href="{{ route('events.show', $event->id) }}"
                                       class="text-itext-slate-600 hover:text-red-700">Xem chi tiết</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        {{--  Upload excel Modal --}}
        <div id="uploadModal" tabindex="-1" aria-hidden="true"
             class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Chọn tập tin
                        </h3>
                        <button type="button"
                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="uploadModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Đóng</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="px-4 md:px-5">
                        <div class="py-4">
                            <p class="text-sm text-gray-800 dark:text-gray-300">
                                Nhấn vào
                                <a href="{{ route('events.download-template') }}" class="text-emerald-500">
                                    đây
                                </a>
                                để tải file excel mẫu cho sự kiện, đại lý tham gia, phần thưởng
                            </p>
                            <form class="space-y-4" method="POST" action="{{ route('events.import-with-data') }}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="flex flex-col">
                                    <input type="file" required name="file" id="file" accept=".xlsx, .xls"
                                           class="form-input px-2">
                                </div>

                                <div class="flex items
                                -center justify-end space-x-2">
                                    <button type="submit"
                                            class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded">
                                        Tải lên
                                    </button>
                                    <button type="button"
                                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded"
                                            data-modal-hide="uploadModal">
                                        Hủy
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.event-link').click(function (e) {
                e.preventDefault();
                $('.event-link').removeClass('text-green-500 font-bold');
                $(this).addClass('text-green-500 font-bold');
                let url = $(this).data('url');
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (data) {
                        console.log(data);
                        if (data.length === 0) {
                            $('tbody').html('<tr><td colspan="6" class="text-center mt-4 py-3 font-bold text-xl text-gray-900">Không có sự kiện nào</td></tr>');
                            return;
                        }

                        let eventList = data.map(createEventHTML);
                        $('tbody').html(eventList.join(''));

                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });

            $('#search').on('keyup', function () {
                let value = $(this).val().toLowerCase();
                $('tbody tr').filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });


        function createEventHTML(event) {
            let agenciesLength = event.event_agencies.length;
            let eventId = event.id;

            return `
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-center text-gray-900">${event.title}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap overflow-hidden overflow-ellipsis">
                <div class="text-sm max-w-md overflow-ellipsis overflow-clip text-gray-900">${event.content}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
    <div class="text-sm text-center text-gray-900">
        ${new Date(event.start_date).toLocaleDateString('vi-VN', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            })} - ${new Date(event.end_date).toLocaleDateString('vi-VN', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            })}
    </div>
</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-center text-gray-900">
${event.status === 'draft' ? 'Nháp' : event.status === 'published' ? 'Xuất bản' : 'Lưu trữ'}
</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                <a href="events/${eventId}"
                                       class="text-itext-slate-600 hover:text-red-700">Xem chi tiết</a>
            </td>

        </tr>
    `;
        }

    </script>

</x-app-layout>
