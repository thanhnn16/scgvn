<?php

namespace App\Imports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EventsImport implements ToModel, WithHeadingRow
{
    /**
     * @throws \Exception
     */
    public function model(array $row): Event
    {
        $startDate = Date::excelToDateTimeObject($row['ngay_bat_dau']);
        $endDate = Date::excelToDateTimeObject($row['ngay_ket_thuc']);

        if ($endDate < $startDate) {
            throw new \Exception('Ngày kết thúc không nhỏ hơn ngày bắt đầu!');
        }

        return new Event([
            'id' => $row['id'],
            'title' => $row['tieu_de'],
            'content' => $row['noi_dung'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $row['trang_thai'] ?? 'draft',
        ]);
    }

//    public function bindValue(Cell $cell, $value)
//    {
//        if (is_numeric($value) && $cell->getColumn() === 'C') {
//            $value = Date::excelToDateTimeObject($value);
//        }
//
//        return parent::bindValue($cell, $value);
//    }
}