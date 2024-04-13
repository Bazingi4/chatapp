<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogController extends Controller
{
    public function index()
    {
        // Получаем все записи логов
        $allLogs = file(storage_path('logs/laravel.log'));

        // Фильтруем логи, оставляя только те, которые относятся к действиям пользователей
        $userLogs = [];
        foreach ($allLogs as $log) {
            if (strpos($log, 'Пользователь') !== false) {
                $userLogs[] = $log;
            }
        }

        return view('logs', compact('userLogs'));
    }
}
