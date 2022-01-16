<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait MainTrait {

    /**
     * Get all model columns for list.
     *
     */
    function get_all_columns($model)
    {
        $all_columns = [];
        foreach ($model->attributes() as $attribute) {
            $all_columns[] = (object)["label" => $attribute['label'], "field" => $attribute['field'], "type" => "string", "filterOptions" => $attribute['filterOptions'] ?? ''];
        }
//        $all_columns[] = (object)["label" => 'Дата создания', "field" => 'created_at', 'type' => 'date', 'dateInputFormat' => "yyyy-MM-dd'T'HH:mm:ss.SSSSSS'Z'", 'dateOutputFormat' => 'dd-MM-yyyy HH:mm'];
        $all_columns[] = (object)["label" => 'Действия', "field" => 'actions', "sortable" => false];

        return $all_columns;
    }

    /**
     * Save files from array to storage and return array of files data.
     *
     */
    public function saveFiles($documents)
    {
        $files = [];
        foreach ($documents as $item) {
            if (isset($item['data'])) {
                $itemName = date('Y-m-d_H-i-s') . '_' . Str::random(3) . '_' . $item['file_name'];
                $data = substr($item['data'], strpos($item['data'], 'base64,') + 7);
                Storage::disk('local')->put($itemName, base64_decode($data));

                $files[] = [
                    'path' => '/files/' . $itemName,
                    'file_name' => $item['file_name']
                ];
            } else {
                $files[] = $item;
            }
        }
        return $files;
    }

}
