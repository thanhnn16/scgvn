<?php

namespace App\Imports;

use App\Models\Event;
use Exception;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EventsImport implements ToModel, WithHeadingRow
{
    /**
     * @throws Exception
     */
    public function model(array $row): ?Event
    {

        if ($row['id'] === null && $row['tieu_de'] === null && $row['noi_dung'] === null && $row['ngay_bat_dau'] === null && $row['ngay_ket_thuc'] === null && $row['trang_thai'] === null) {
            return null;
        }

        $startDate = Date::excelToDateTimeObject($row['ngay_bat_dau']);
        $endDate = Date::excelToDateTimeObject($row['ngay_ket_thuc']);

        if ($endDate < $startDate) {
            throw new Exception('Ngày kết thúc không nhỏ hơn ngày bắt đầu!');
        }

        $event = Event::updateOrCreate(
            ['id' => $row['id']],
            [
                'title' => $row['tieu_de'],
                'content' => $row['noi_dung'],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => $row['trang_thai'] ?? 'draft',
            ]
        );

        return $event;

    }
}