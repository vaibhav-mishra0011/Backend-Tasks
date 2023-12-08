<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class TaskListExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Task::all();
    }

    public function headings(): array
    {
        return [
            "id",
            "User_id",
            'Name',
            'Description',
            'created_at',
            'updated_at',
            'completed',

        ];
    }
}
