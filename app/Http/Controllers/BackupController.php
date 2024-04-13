<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    public function backup()
    {
        // Определите имя файла бэкапа с уникальным временным штампом
        $backupFileName = 'backup_' . now()->format('Y-m-d_H-i-s') . '.sql';

        // Определите путь, где будет сохранен файл бэкапа
        $backupFilePath = storage_path('app/backups/' . $backupFileName);

        // Выполните команду pg_dump для создания резервной копии базы данных PostgreSQL
        $pgDumpCommand = sprintf(
            'pg_dump -U %s -h %s -p %d %s > %s',
            config('database.connections.pgsql.username'),
            config('database.connections.pgsql.host'),
            config('database.connections.pgsql.port'),
            config('database.connections.pgsql.database'),
            $backupFilePath
        );

        // Выполните команду с помощью функции exec
        exec($pgDumpCommand);

        // Возврат результата пользователю (например, вывод ссылки на скачивание)
        return response()->download($backupFilePath);
    }
}
