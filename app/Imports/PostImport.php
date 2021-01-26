<?php

namespace App\Imports;

use App\Post;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;

class PostImport implements ToCollection, ToModel
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $dateTime = now();

        $request['your_datetime_field'] = $dateTime->format('Y-m-d H:i:s');
        return new Post([
            'title' => $row[1],
            'description'=> $row[2],
            'status'=> $row[3],
            'create_user_id'=> $row[4],
            'updated_user_id'=> $row[5],
            'deleted_user_id'=> $row[6],
            'created_at'=> $row[7] = $dateTime->format('Y-m-d H:i:s'),
            'updated_at'=> $row[8] = $dateTime->format('Y-m-d H:i:s')
        ]);
    }
}
