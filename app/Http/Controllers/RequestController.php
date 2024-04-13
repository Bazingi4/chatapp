<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requests as RequestModel;
use App\Models\Topic;
use Illuminate\Support\Facades\Log; // Добавлен импорт класса Log

class RequestController extends Controller
{
    public function index()
    {
        $requests = RequestModel::all(); // Получить все заявки
        return view('requests.index', compact('requests'));
    }

    public function create()
    {
        $topics = Topic::all(); // Получить все темы заявок
        return view('requests.create', compact('topics'));
    }
    
    public function store(Request $request)
    {
        // Валидация данных
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'text' => 'required|string',
            'file' => 'nullable|file', // Теперь файл не обязателен
        ]);
    
        // Получаем идентификатор текущего пользователя
        $userId = auth()->id();
    
        // Сохранение новой заявки
        $newRequest = new RequestModel();
        $newRequest->user_id = $userId;
        $newRequest->topic_id = $request->topic_id;
        $newRequest->text = $request->text;
    
        // Обработка прикрепленного файла, если он был загружен
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads');
            $newRequest->file_path = $path;
        }
    
        $newRequest->save();

        // Логируем действие пользователя
        Log::info('Пользователь создал новую заявку', ['user_id' => $userId, 'request_id' => $newRequest->id]);
    
        return back()->with('success', 'Заявка успешно отправлена');
    }
    
    public function show(Request $request, $id)
    {
        $request = RequestModel::findOrFail($id);
        return view('requests.show', compact('request'));
    }

    public function edit(Request $request, $id)
    {
        $request = RequestModel::findOrFail($id);
        $topics = Topic::all(); // Получить все темы заявок
        return view('requests.edit', compact('request', 'topics'));
    }

    public function update(Request $request, $id)
    {
        // Валидация данных
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'topic_id' => 'required|exists:topics,id',
            'text' => 'required|string',
            'file' => 'nullable|file',
        ]);

        // Обновление информации о заявке
        $requestModel = RequestModel::findOrFail($id);
        $requestModel->name = $request->name;
        $requestModel->email = $request->email;
        $requestModel->topic_id = $request->topic_id;
        $requestModel->text = $request->text;

        // Обработка прикрепленного файла
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads');
            $requestModel->file_path = $path;
        }

        $requestModel->save();

        return redirect()->route('requests.index')->with('success', 'Заявка успешно обновлена');
    }

    public function destroy(Request $request, $id)
    {
        // Удаление заявки
        $requestModel = RequestModel::findOrFail($id);
        $requestModel->delete();

        return redirect()->route('requests.index')->with('success', 'Заявка успешно удалена');
    }

    public function sendRequestForm()
    {
        $topics = Topic::all(); // Получить все темы заявок
        return view('requests.create', compact('topics'));
    }

    public function userRequests()
{
    $userId = auth()->id();
    $userRequests = RequestModel::where('user_id', $userId)->get();
    return view('requests.user_index', compact('userRequests'));
}

public function managerRequests()
{
    $requests = RequestModel::all();
    return view('requests.manager_index', compact('requests'));
}

}
