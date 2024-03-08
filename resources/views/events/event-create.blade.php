@php use Carbon\Carbon; @endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('events-management') }}"
               class=" text-emerald-500 text-sm hover:text-emerald-700">Quản lý sự kiện</a>
            / {{ __('Thêm sự kiện') }}
        </h2>

    </x-slot>
    <div class="py-3">
        <form id="createEventForm" class="p-4 md:p-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white min-h-40 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-xl font-bold">Thông tin sự kiện</h3>
                    </div>
                    <div class="event-create">
                        <div class="px-6 mb-6 text-gray-900">
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2">
                                    <label for="name" class="block mb-2  font-medium text-gray-900 dark:text-white">Tên
                                        sự kiện</label>
                                    <input type="text" name="event_title" id="event_title"
                                           class="bg-gray-50 border border-gray-300 text-gray-900  rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                           placeholder="Tên sự kiện" required="">
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="price" class="block mb-2  font-medium text-gray-900 dark:text-white">Ngày
                                        bắt đầu</label>
                                    <input type="date" name="start_date" id="start_date"
                                           class="bg-gray-50 border border-gray-300 text-gray-900  rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                           required="">
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="category" class="block mb-2  font-medium text-gray-900 dark:text-white">Ngày
                                        kết thúc</label>
                                    <input type="date" name="end_date" id="end_date"
                                           class="bg-gray-50 border border-gray-300 text-gray-900  rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                           required="">
                                </div>
                                <div class="col-span-2">
                                    <label for="description"
                                           class="block mb-2  font-medium text-gray-900 dark:text-white">Mô tả</label>
                                    <textarea id="description" rows="4"
                                              class="block p-2.5 w-full  text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                              placeholder="Thông tin chi tiết sự kiện"></textarea>
                                </div>
                                <div class="col-span-2 ">
                                    <label for="category" class="block mb-2  font-medium text-gray-900 dark:text-white">Trạng
                                        thái</label>
                                    <select id="status"
                                            class="bg-gray-50 border border-gray-300 text-gray-900  rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        <option value="draft">Bản nháp
                                        </option>
                                        <option value="published">Xuất
                                            bản
                                        </option>
                                        <option value="archived">Lưu
                                            trữ
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <h3 class="text-xl mt-4 font-bold">Đại lý tham gia</h3>

                            <div class="col-span-2 my-2">
                                <label for="agencies-list"
                                       class="block mb-2 text-sm text-red-300-900">** Chỉ nhập mã đại lý, mỗi mã đại lý
                                    là 1 dòng (Vui lòng thêm Đại lý mới vào Dữ liệu đại lý trước nếu chưa có trong danh
                                    sách)</label>
                                <textarea id="agencies-list" rows="4"
                                          class="block p-2.5 w-full  text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                          placeholder="Chỉ nhập mã đại lý, mỗi mã đại lý là 1 dòng (Vui lòng thêm Đại lý mới vào Dữ liệu đại lý trước nếu chưa có trong danh sách)"></textarea>
                            </div>

                            <h3 class="text-xl mt-4 font-bold">Giải thưởng cho Event</h3>
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

                            <div class="mt-3">
                                <button type="submit"
                                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg  px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Lưu
                                </button>
                                <button type="reset"
                                        class="py-2.5 px-5 ms-3  font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

        $(document).ready(function () {
            $('#add-prize').on('click', function () {
                let prize_name = $('#prize_name').val();
                let prize_quantity = $('#prize_quantity').val();
                let prize_description = $('#prize_description').val();
                let prize_list = $('#prize-list');
                let table = $('#table');
                let prize = `
                    <tr>
                        <td>${prize_name}</td>
                        <td>${prize_quantity}</td>
                        <td>${prize_description}</td>
                        <td>
                            <button type="button" class="remove-prize text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg  px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                Xóa
                            </button>
                        </td>
                    </tr>
                `;
                prize_list.append(prize);
                $('#prize_name').val('');
                $('#prize_quantity').val('');
                $('#prize_description').val('');
                table.removeClass('hidden');
            });

            $('#prize-list').on('click', '.remove-prize', function () {
                $(this).closest('tr').remove();
                if ($('#prize-list tr').length === 0) {
                    $('#table').addClass('hidden');
                }
            });

            $('#createEventForm').submit(function (e) {
                e.preventDefault();
                let event_title = $('#event_title').val();
                let start_date = $('#start_date').val();
                let end_date = $('#end_date').val();
                let description = $('#description').val();
                let status = $('#status').val();
                let agencies_list = $('#agencies-list').val();
                let prize_name = $('#prize_name').val();
                let prize_quantity = $('#prize_quantity').val();
                let prize_description = $('#prize_description').val();
                let prize_list = $('#prize-list').html();

                if (start_date > end_date) {
                    alert('Ngày kết thúc không thể nhỏ hơn ngày bắt đầu');
                    return;
                }

                let data = {
                    title: event_title,
                    start_date: start_date,
                    end_date: end_date,
                    content: description,
                    status: status,
                };

                let prizes = [];
                $('#prize-list tr').each(function () {
                    let prize = {
                        prize_name: $(this).find('td').eq(0).text().trim(),
                        prize_qty: parseInt($(this).find('td').eq(1).text().trim()),
                        prize_desc: $(this).find('td').eq(2).text().trim()

                    };
                    prizes.push(prize);
                });
                let agencies = agencies_list.split('\n');

                console.log('Agencies list: ' + agencies);

                console.log('Price list: ' + prizes);

                prizes.forEach(function (prize) {
                    console.log(prize);
                });

                let isErr = false;

                $.ajax({
                    url: "{{ route('events.store') }}",
                    type: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        let event_id = response.event_id;

                        $.ajax({
                            url: "{{ route('prizes.store') }}",
                            type: 'POST',
                            data: {
                                event_id: event_id,
                                prizes: prizes
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                console.log('Prize res: ' + response.status);
                            },
                            error: function (response) {
                                console.log(response);
                                isErr = true;
                            }
                        });

                        agencies.forEach(function (agencyCode) {
                            $.ajax({
                                url: "{{ route('event-agencies.store') }}",
                                type: 'POST',
                                data: {
                                    event_id: event_id,
                                    agency_id: agencyCode
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (response) {
                                    console.log('Agency res: ' + response.status)
                                },
                                error: function (response) {
                                    console.log(response);
                                    isErr = true;
                                }
                            });
                        });
                    },
                    error: function (response) {
                        console.log(response);
                        isErr = true;
                    }
                });

                if (!isErr) {
                    alert('Thêm sự kiện thành công');
                    window.location.href = "{{ route('events-management') }}";
                } else {
                    alert('Có lỗi xảy ra, vui lòng thử lại');
                }
            });
        });

    </script>

</x-app-layout>