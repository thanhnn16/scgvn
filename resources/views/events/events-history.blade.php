<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lịch sử quay thưởng') }}
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
                </div>

                <div id="agencyListText" class="p-6 text-emerald-950 font-bold hidden">
                    {{ __("Danh sách đại lý") }}
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
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Giải thưởng') }}
                            </th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ __(' ') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="tbody">
                        </tbody>
                    </table>
                </div>

                <div id="prizeList" class="p-6 text-emerald-950 font-bold hidden">
                    {{ __("Danh sách giải thưởng") }}
                </div>

                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200 hidden" id="prizeTable">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

        let agencies = [];
        let prizes = [];

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
                    $('#pprizeList').addClass('hidden');
                    $('#prizeTable').addClass('hidden');
                } else {
                    getData(event_id);
                }
            });


            $('#reset').click(function () {
                $('#start_date').val('');
                $('#end_date').val('');
                $('#event').val(0);
                $('#agencyListText').addClass('hidden');
                $('#agencyTable').addClass('hidden');
                $('#emptyList').addClass('hidden');
                $('#prizeList').addClass('hidden');
                $('#prizeTable').addClass('hidden');
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

            function getData(event_id) {
                $.ajax({
                    url: '{{ route('events.get-data') }}',
                    type: 'GET',
                    data: {
                        event_id: event_id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    success: function (data) {
                        console.log(data);
                        $('#agencyListText').removeClass('hidden');
                        $('#agencyTable').removeClass('hidden');
                        $('#prizeList').removeClass('hidden');
                        $('#prizeTable').removeClass('hidden');
                        $('#agencyTable tbody').empty();
                        $('#prizeTable tbody').empty();
                        agencies = data.agencies;
                        prizes = data.prizes;

                        $.each(agencies, function (index, value) {
                            $('#agencyTable tbody').append('<tr>' +
                                '<td class="px-6 py-4 whitespace-no-wrap">' +
                                '<div class="text-sm leading-5 text-gray-900">' + value.agency.keywords + '</div>' +
                                '</td>' +
                                '<td class="px-6 py-4 whitespace-no-wrap">' +
                                '<div class="text-sm leading-5 text-gray-900">' + value.agency_id + '</div>' +
                                '</td>' +
                                '<td class="px-6 py-4 whitespace-no-wrap">' +
                                '<div class="text-sm leading-5 text-gray-900">' + value.agency.agency_name + '</div>' +
                                '</td>' +
                                '<td class="px-6 py-4 whitespace-no-wrap">' +
                                '<div class="text-sm leading-5 text-gray-900">' + value.agency.province.province + '</div>' +
                                '</td>' +
                                '<td class="px-6 py-4 whitespace-no-wrap">' +
                                '<div class="text-sm leading-5 text-gray-900">' + (value.prize ? value.prize.prize_name : '-') + '</div>' +
                                '</td>' + '</td>' +
                                '<td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">' +
                                `<a href="events/${event_id}" class="text-indigo-600 hover:text-indigo-900">Xem chi tiết</a>` +
                                '</td>' +
                                '</tr>');
                        });

                        if (prizes.length > 0) {
                            $.each(prizes, function (index, value) {
                                let agencies = value.agencies;
                                console.log(agencies)
                                let agencyNames = [];
                                $.each(agencies, function (index, value) {
                                    if (value.agency_name) {
                                        agencyNames.push(value.agency_name);
                                    }
                                });
                                let winnerString = agencyNames.length > 0 ? agencyNames.join(', ') : '-';
                                let prizeDes = value.prize_des ? value.prize_des : 'Không có mô tả';

                                $('#prizeTable tbody').append('<tr>' +
                                    '<td class="px-6 py-4 whitespace-no-wrap text-center">' +
                                    '<div class="text-sm leading-5 text-gray-900">' + value.prize_name + '</div>' +
                                    '</td>' +
                                    '<td class="px-6 py-4 whitespace-no-wrap text-center">' +
                                    '<div class="text-sm leading-5 text-gray-900">' + value.prize_qty + '</div>' +
                                    '</td>' +
                                    '<td class="px-6 py-4 whitespace-no-wrap text-center">' +
                                    '<div class="text-sm leading-5 text-gray-900">' + prizeDes + '</div>' +
                                    '</td>' +
                                    '<td class="px-6 py-4 whitespace-no-wrap text-center">' +
                                    '<div class="text-sm leading-5 text-gray-900">' + winnerString + '</div>' +
                                    '</td>' +
                                    '<td class="px-6 py-4 whitespace-no-wrap text-center text-sm leading-5 font-medium">' +
                                    '<a href="#" id="editPrize" class="text-slate-600 hover:text-blue-600">Sửa</a> - ' +
                                    '<a href="#" id="' + value.id + '" class="text-slate-600 hover:text-red-900 deletePrize">Xóa</a>' +
                                    '</td>' +
                                    '</tr>');
                            });
                        } else {
                            $('#prizeTable tbody').append('<tr>' +
                                '<td class="px-6 py-4 whitespace-no-wrap text-center" colspan="5">' +
                                '<div class="text-lg mt-3 leading-5 text-gray-900">Không có giải thưởng nào</div>' +
                                '</td>' +
                                '</tr>');
                        }


                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
        });

    </script>
</x-app-layout>
