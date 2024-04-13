<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use App\Models\Requests as RequestModel;

class StatisticsController extends Controller
{
    public function index()
    {
        // Получение статистических данных
        $usersCount = User::count();
        $chatsCount = Chat::count();
        $requestsCount = RequestModel::count();

        // Получение статистики заявок по темам
        $requestsByTopic = RequestModel::selectRaw('topic_id, count(*) as count')->groupBy('topic_id')->get();

        // Получение всех возможных тем заявок
        $allTopics = \App\Models\Topic::pluck('id', 'name');

        // Форматирование данных для использования в графиках
        $topics = [];
        $counts = [];

        foreach ($allTopics as $topic => $topicId) {
            $topics[] = $topic;
            $count = $requestsByTopic->where('topic_id', $topicId)->first(); // Получаем первый элемент или null
            $counts[] = $count ? $count->count : 0; // Если $count не null, получаем значение count, иначе 0
        }
        

        return view('statistics.index', compact('usersCount', 'chatsCount', 'requestsCount', 'topics', 'counts'));
    }
}
