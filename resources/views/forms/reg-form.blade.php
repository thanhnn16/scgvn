<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet"/>
<meta name="viewport" content="width=device-width, initial-scale=1">

<div class="form-container md:w-full sm:w-10/12 mx-auto py-2 justify-items-center mt-6 px-4">
    <img src="{{ asset('images/logo.svg') }}" alt="SCG" class="mx-auto" style="width: 100px;"/>
    <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Đăng ký thông tin</h1>
    <form class="max-w-2xl mx-auto"
          method="post" id="reg-form"
          action="https://external-v1-stg.omicrm.com/api/campaign/webhook/65de9ab9bc80f44218300276-l5QPJQ7Tyab4cLqxu5Ml">
        <div class="relative z-0 w-full mb-5 group">
            <label for="province"
                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Chọn
                tỉnh</label>
            <select name="province" id="province"
                    class="bg-gray-50 border border-gray-300 text-gray-900  rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    required>
                <option value="0">-- Tỉnh --</option>
                @foreach($provinces as $provinces)
                    <option value="{{$provinces->id}}">{{$provinces->province}}</option>
                @endforeach
            </select>
        </div>

        <div class="relative z-0 w-full mb-5 group">
            <label for="agency_name"
                   class="block mb-2  font-medium text-gray-900 dark:text-white">Tên
                đại lý</label>
            <select name="agency_name" id="agency_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900  rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    required>
                <option value="0">-- Chọn đại lý --</option>
            </select>
        </div>


        <div class="relative z-0 w-full mb-5 group">
            <label for="agency_id"
                   class="block mb-2  font-medium text-gray-900 dark:text-white">Mã
                đại lý</label>
            <input type="text" name="agency_id" id="agency_id" disabled
                   class="bg-gray-50 border border-gray-300 text-gray-900  rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                   placeholder="Mã đại lý" required/>
        </div>

        <div class="relative z-0 w-full mb-5 group">
            <label for="distributor"
                   class="block mb-2  font-medium text-gray-900 dark:text-white">Nhà
                phân phối</label>
            <select name="distributor" id="distributor"
                    class="bg-gray-50 border border-gray-300 text-gray-900  rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    required>
                <option value="0">-- Chọn nhà phân phối --</option>
            </select>
        </div>


        <div class="relative z-0 w-full mb-5 group">
            <label for="phone_number"
                   class="block mb-2  font-medium text-gray-900 dark:text-white">Số
                điện thoại</label>
            <input type="tel" name="phone_number" id="phone_number"
                   class="bg-gray-50 border border-gray-300 text-gray-900  rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                   placeholder=" " required/>
        </div>

        <div class="relative z-0 w-full mb-5 group">
            <label for="uid"
                   class="block mb-2  font-medium text-gray-900 dark:text-white">Zalo User Id</label>
            <input type="text" disabled name="uid" id="uid"
                   class="bg-gray-50 border border-gray-300 text-gray-900  rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                   placeholder=" " required
            />
        </div>

        <button id="send-data" type="submit"
                class="mt-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg  w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Gửi thông tin
        </button>
        <button type="reset"
                class="mt-2 text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg  w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
            Reset
        </button>
    </form>
    <div class="reg-result hidden mt-4">
        <p class="text-center text-green-500 font-bold"></p>
    </div>

</div>

<footer class="">
    <div class="max-w-7xl mx-auto py-2">
        <p class="text-center text-gray-400">
            &copy; 2024 SCGVN. All rights reserved.
        </p>
    </div>
</footer>
{{--lastest jquery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{--lastest jquery --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

<script>
    var url_string = window.location.href;
    var url = new URL(url_string);
    var uid = url.searchParams.get("uid");

    $('#uid').val(uid);

    $('#province').on('change', function () {
        let provinceId = $(this).val();
        getAgencies(provinceId);
    });

    $('#agency_name').on('change', function () {
        let agencyId = $(this).val();
        $('#agency_id').val(agencyId);
    });

    $('#send-data').on('click', function (e) {
        e.preventDefault();
        var phone_number = $('#phone_number').val();
        var customer_name = $('#agency_name').val();
        var customer_code = $('#agency_id').val();
        var province = $('#province option:selected').text();
        var distributor = $('#distributor').val();
        var uid = $('#uid').val();

        $.ajax({
            url: 'https://external-v1-stg.omicrm.com/api/campaign/webhook/65de9ab9bc80f44218300276-l5QPJQ7Tyab4cLqxu5Ml',
            type: 'POST',
            data: JSON.stringify({
                phone_number: phone_number,
                customer_name: customer_name,
                customer_code: customer_code,
                province: province,
                distributor: distributor,
                uid: uid
            }),
            contentType: 'application/json',
            headers: {
                'Accept': 'application/json',
            },
            success: function (data) {
                $('#reg-form').addClass('hidden');
                $('.reg-result').removeClass('hidden').find('p').text('Đăng ký thành công, SCG xin chân thành cảm ơn!');
                },
            error: function (error) {
                console.log(error);
            }
        });
    });

    function getAgencies(province_id) {
        $.ajax({
            url: ' {{ route('get-agencies') }}',
            type: 'GET',
            data: {
                province_id: province_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                let agencies = data.agencies;
                let distributors = data.distributors;


                $('#agency_name').empty();
                $('#agency_name').append('<option value="0">-- Chọn đại lý --</option>');

                $('#distributor').empty();
                $('#distributor').append('<option value="0">-- Chọn nhà phân phối --</option>');

                if (Array.isArray(agencies)) {
                    agencies.sort(function (a, b) {
                        if (a.agency_name < b.agency_name) {
                            return -1;
                        }
                        if (a.agency_name > b.agency_name) {
                            return 1;
                        }
                        return 0;
                    });
                }

                if (Array.isArray(distributors)) {
                    distributors.sort(function (a, b) {
                        if (a.distributor < b.distributor) {
                            return -1;
                        }
                        if (a.distributor > b.distributor) {
                            return 1;
                        }
                        return 0;
                    });
                }

                agencies.forEach(function (agency) {
                    $('#agency_name').append('<option value="' + agency.agency_id + '">' + agency.agency_name + ' - ' + agency.agency_id + '</option>');
                });

                distributors.forEach(function (distributor) {
                    $('#distributor').append('<option value="' + distributor.id + '">' + distributor.distributor_name + '</option>');
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

</script>