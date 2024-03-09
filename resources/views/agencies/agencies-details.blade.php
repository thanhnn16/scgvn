@php use Carbon\Carbon; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chi tiết đại lý') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="text-2xl">
                        Đại lý: {{ $agency->agency_name }}
                    </div>
                    <div class="mt-6">
                        <div class="flex">
                            <div class="w-1/2">
                                <div class="text-lg">
                                    <span class="font-bold">Tên đại lý:</span> {{ $agency->agency_name }}
                                </div>
                                <div class="text-lg">
                                    <span class="font-bold">Mã đại lý:</span> {{ $agency->agency_id }}
                                </div>
                                <div class="text-lg">
                                    <span class="font-bold">Mã từ khóa:</span> {{ $agency->keywords }}
                                </div>
                                <div class="text-lg">
                                    <span class="font-bold">Tỉnh:</span> {{ $agency->province->province }}
                                </div>
                            </div>
                            <div class="w-1/2">
                                <div class="text-lg">
                                    <span class="font-bold">Ngày tạo:</span> {{ $agency->created_at->format('d/m/Y') }}
                                </div>
                                <div class="text-lg">
                                    <span class="font-bold">Ngày cập nhật:</span> {{ $agency->updated_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--        các giải thưởng đã trúng--}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="text-2xl">
                            Các giải thưởng đã trúng
                        </div>
                    </div>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tên sự kiện
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ngày bắt đầu
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ngày kết thúc
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tên giải thưởng
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Mô tả
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($eventAgencies as $eventAgency)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 text-center">{{ $eventAgency->event->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 text-center">{{ Carbon::parse($eventAgency->event->start_date)->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 text-center">{{ Carbon::parse($eventAgency->event->end_date)->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 text-center">{{ $eventAgency->prize->prize_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 text-center">{{ $eventAgency->prize->prize_desc }}</div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>

            </div>
        </div>

    </div>

</x-app-layout>

<script>
    console.log('hello')
    console.log('Agency: ', @json($agency));
    console.log('Agency EV: ', @json($eventAgencies));
</script>