<?php

namespace App\Imports;

use App\Models\Task;
use Log;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TaskListImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        Log::debug("Import tasks in database");
        $rowcount = count($rows);
        $row = $rows->toArray();
        for ($i = 1; $i < $rowcount; $i++) {
            $task = new Task([
                "id" => $row[$i][0],
                "user_id" => $row[$i][1],
                "name" => $row[$i][2],
                "description" => $row[$i][3],
                "completed" => !$row[$i][6] ? false : true,
            ]);
            $task->save();
        }
    }
}


