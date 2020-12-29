<?php

namespace App\Exports;

use App\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PostExport implements FromCollection, WithHeadings, WithColumnFormatting, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Post::all();
    }
    public function headings(): array
    {
        return [
            'id',
            'title', 
            'description',
            'status',
            'create_user_id',
            'updated_user_id',
            'deleted_user_id',
            'created_at',
            'updated_at',
            'deleted_at'
        ];
    }

    public function map($post): array
    {
        return [
            $post->id,
            $post->title, 
            $post->description,
            $post->status,
            $post->create_user_id,
            $post->updated_user_id,
            $post->deleted_user_id,
            Date::dateTimeToExcel($post->created_at),
            Date::dateTimeToExcel($post->updated_at),
            $post->deleted_at == null ? "" : date('d/m/Y', strtotime($post->deleted_at)),
        ];
    }

    // Set Date Format
    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'I' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
