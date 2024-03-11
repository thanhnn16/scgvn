<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dữ liệu đại lý') }}
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
        <button data-modal-show="addAgencyModal" data-modal-target="addAgencyModal"
                class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded mt-2">
            Thêm đại lý</button>
        <button class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded mt-2"
                data-modal-show="uploadModal" data-modal-target="uploadModal">
            <a>Nhập từ Excel</a>
        </button>
        <button class="bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded mt-2">
            <a href="{{ route('agencies.export') }}">Xuất file Excel</a></button>

    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white min-h-96 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900" id="selectList">
                    <h3 class="text-xl font-bold">Chọn tỉnh</h3>
                    <div class="flex items-center mt-3 justify-between">
                        <div class="w-7/12">
                            <select name="provinces_list" id="provinces_list"
                                    class="form-select rounded-md mt-1 w-full shadow-sm">
                                <option value="0">-- Tỉnh --</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->province }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div id="emptyResult" class="p-6 text-emerald-950 font-bold hidden">
                    {{ __("Không có đại lý nào thuộc tỉnh này. Bạn có thể") }}
                    <a data-modal-show="addAgencyModal" data-modal-target="addAgencyModal"
                            href="#" class="text-emerald-500 hover:text-emerald-700">
                        {{ __("thêm đại lý") }} </a>
                </div>

                <div id="agencyListText" class="p-6 text-emerald-950 font-bold hidden">
                    {{ __("Danh sách đại lý") }}
                    <div class="search">
                        <input type="text" class="form-input rounded-md mt-1 w-full shadow-sm" id="search"
                               placeholder="Tìm kiếm">
                    </div>
                </div>
                <div class="px-6 mt-2 pb-6 text-gray-900">
                    <table class="min-w-full divide-y text-center divide-gray-200 hidden" id="agencyTable">
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

    {{--    modal--}}
    {{--upload from excel--}}
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
                            <a href="{{ route('agencies.download-template') }}" class="text-emerald-500">
                                đây
                            </a>
                            để tải file excel mẫu cho tỉnh và đại lý
                        </p>
                        <form class="space-y-4" method="POST" action="{{ route('provinces.import') }}"
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
    {{--add agency modal--}}
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
                            <label for="keywords"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mã từ
                                khóa</label>
                            <input type="text" name="keywords" id="keywords"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   placeholder="Mã từ khóa" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="agency_id"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mã đại
                                lý</label>
                            <input type="text" name="agency_id" id="agency_id"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   placeholder="Mã đại lý" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="agency_name"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên đại
                                lý</label>
                            <input type="text" name="agency_name" id="agency_name"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   placeholder="Tên đại lý" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="province_id"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tỉnh</label>
                            <select name="province_id" id="province_id"
                                    class="form-select rounded-md mt-1 w-full shadow-sm">
                                <option value="0">-- Tỉnh --</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->province }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" data-modal-hide="addAgencyModal" id="addAgencyBtn"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Thêm đại lý
                    </button>
                </form>
            </div>
        </div>
    </div>

{{--edit agency modal--}}
    <div id="edtAgencyModal" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Sửa đại lý
                    </h3>
                    <button type="button" onclick="document.getElementById('edtAgencyModal').style.display = 'none'"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            >
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" id="edtAgencyForm">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="keywords-edt"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mã từ
                                khóa</label>
                            <input type="text" name="keywords-edt" id="keywords-edt"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   placeholder="Mã từ khóa" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="agency_id-edt"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mã đại
                                lý</label>
                            <input type="text" name="agency_id-edt" id="agency_id-edt" disabled
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   placeholder="Mã đại lý" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="agency_name-edt"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên đại
                                lý</label>
                            <input type="text" name="agency_name-edt" id="agency_name-edt"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   placeholder="Tên đại lý" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="province_id"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tỉnh</label>
                            <select name="province_id-edt" id="province_id-edt"
                                    class="form-select rounded-md mt-1 w-full shadow-sm">
                                <option value="0">-- Tỉnh --</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->province }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" id="edtAgencyBtn"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Sửa đại lý
                    </button>
                </form>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            const provinces = @json($provinces);

            $('#provinces_list').change(function () {
                resetList();
                let provinceId = $(this).val().toString();
                if (provinceId !== '0') {
                    let thisProvince = provinces.find(province => province.id == provinceId);

                    if (thisProvince.agencies.length === 0) {
                        $('#emptyResult').removeClass('hidden');
                        $('#agencyListText').addClass('hidden');
                        $('#agencyTable').addClass('hidden');
                        return;
                    }

                    let agenciesList = thisProvince.agencies;

                    $('#agencyListText').removeClass('hidden');
                    $('#agencyTable').removeClass('hidden');
                    $('#tbody').empty();
                    agenciesList.forEach(agency => {
                        $('#tbody').append(`
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">${agency.keywords}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">${agency.agency_id}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">${agency.agency_name}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="#" data-agency-keywords="${agency.keywords}" data-agency-agency-id="${agency.agency_id}" data-agency-agency-name="${agency.agency_name}" data-agency-province-id="${agency.province_id}"
class="text-black-500 hover:text-black-700 editAgency">Sửa</a>
                                    -
                                    <a href="#" data-agency-agency-id="${agency.agency_id}" data-agency-agency-name="${agency.agency_name}"
class="text-red-500 hover:text-red-700 delAgency">Xóa</a>
                                </td>
                            </tr>
                        `);
                    });
                    $('#search').on('keyup', function () {
                        let value = $(this).val().toLowerCase();
                        $('#tbody tr').filter(function () {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                        });
                    });

                } else {
                    $('#agencyListText').addClass('hidden');
                    $('#agencyTable').addClass('hidden');
                }

            });

            function resetList() {
                $('#emptyResult').addClass('hidden');
                $('#agencyListText').addClass('hidden');
                $('#agencyTable').addClass('hidden');
            }

            $('#addAgencyBtn').click(function (e) {
                e.preventDefault();
                let keywords = $('#keywords').val();
                let agency_id = $('#agency_id').val();
                let agency_name = $('#agency_name').val();
                let province_id = $('#province_id').val();
                $.ajax({
                    url: '{{ route('agencies.store') }}',
                    type: 'POST',
                    data: {
                        keywords: keywords,
                        agency_id: agency_id,
                        agency_name: agency_name,
                        province_id: province_id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        console.log('response: ', response);
                        if (response.status === 'success') {
                            alert('Thêm đại lý thành công');
                            window.location.reload();
                        } else {
                            alert('Thêm đại lý thất bại');
                        }
                    },
                    error: function (error) {
                        console.log('error: ', error);
                    }
                });
            });


            $(document).on('click', '.editAgency', function (e) {
                e.preventDefault();

                let keywords = $(this).data('agency-keywords');
                let agency_id = $(this).data('agency-agency-id');
                let agency_name = $(this).data('agency-agency-name');
                let province_id = $(this).data('agency-province-id');
                $('#keywords-edt').val(keywords);
                $('#agency_id-edt').val(agency_id);
                $('#agency_name-edt').val(agency_name);
                $('#province_id-edt').val(province_id);

                $('#edtAgencyModal').show();

                $('#edtAgencyBtn').click(function (e) {
                    e.preventDefault();
                    let keywords = $('#keywords-edt').val();
                    let agency_id = $('#agency_id-edt').val();
                    let agency_name = $('#agency_name-edt').val();
                    let province_id = $('#province_id-edt').val();

                    console.log('keywords: ', keywords);
                    console.log('agency_id: ', agency_id);
                    console.log('agency_name: ', agency_name);
                    console.log('province_id: ', province_id);

                    $.ajax({
                        url: '{{ route('agencies.update') }}',
                        type: 'POST',
                        data: {
                            keywords: keywords,
                            agency_id: agency_id,
                            agency_name: agency_name,
                            province_id: province_id
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                alert('Sửa đại lý thành công');
                                window.location.reload();
                            } else {
                                console.log('response: ', response);
                                alert('Sửa đại lý thất bại');
                            }
                        },
                        error: function (error) {
                            console.log('error: ', error);
                        }
                    });
                });
            });

            $(document).on('click', '.delAgency', function (e) {
                let agency_id = $(this).data('agency-agency-id');
                let agency_name = $(this).data('agency-agency-name');
                console.log('agency_id: ', agency_id);
                if (confirm(`Bạn có chắc chắn muốn xóa đại lý ${agency_name} không?`)) {
                    $.ajax({
                        url: '{{ route('agencies.destroy') }}',
                        type: 'DELETE',
                        data: {
                            agency_id: agency_id,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                alert('Xóa đại lý thành công');
                                window.location.reload();
                            } else {
                                console.log('response: ', response);
                                alert('Xóa đại lý thất bại');
                            }
                        },
                        error: function (error) {
                            console.log('error: ', error);
                        }
                    });
                }
            });
        });

    </script>
</x-app-layout>
