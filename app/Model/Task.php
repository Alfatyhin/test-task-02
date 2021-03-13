<?php

namespace App\Model;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasklist';
    private static $tbname = 'tasklist';

    protected $fillable = [
        'user_name',
        'email',
        'description',
        'status',
        'redact'
    ];


    // получаем сообщения из базы
    public static function getTasks($skip, $count, $sort_name, $sort_by)
    {

        return self::orderBy($sort_name, $sort_by)
            ->skip($skip)
            ->take($count)
            ->get()
            ->toArray();

    }
    public static function getById(int $id): ? self
    {
        return self::query()->find($id);
    }

    public static function paginate($count)
    {
        $tbname = self::$tbname;
        $totalCount = Manager::select('SELECT COUNT(*) FROM ' . $tbname);
        $totalCount = json_encode($totalCount);
        $totalCount = json_decode($totalCount, true);
        $totalCount = $totalCount[0]['COUNT(*)'];

        $data['totalCount'] = $totalCount;
        $data['pages'] = ceil($totalCount / $count);

        return $data;
    }


}