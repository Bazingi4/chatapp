<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Добавлен импорт класса Log
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Broadcast;
use App\Models\Requests as RequestModel;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function myChats()
    {
        $userId = auth()->id();

        // Получаем все чаты, где пользователь является участником (отправитель или получатель)
        $chats = Chat::where('user_id', $userId)
                    ->orWhere('receiver_id', $userId)
                    ->with('messages')
                    ->get();

        // Логируем действие пользователя
        Log::info('Пользователь просмотрел свои чаты', ['user_id' => $userId]);

        return view('users.my_chats', compact('chats'));
    }
    
    public function show($receiverId)
    {
        $receiver = User::findOrFail($receiverId);
        $senderId = auth()->id();
    
        // Получение чата между отправителем и получателем
        $chat = $this->getOrCreateChat($senderId, $receiverId);
        $chats = $chat->messages;
    
        return view('users.show', compact('receiver', 'chats', 'chat'));
    }
    

    public function store(Request $request, $receiverId)
    {
        $request->validate([
            'message' => 'required_without_all:file|string',
            'file' => 'file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,zip,rar',
        ]);

        $senderId = auth()->id();
        $chat = $this->getOrCreateChat($senderId, $receiverId);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            if ($file->isValid()) {
                try {
                    $filePath = $this->storeFile($file);

                    $message = Message::create([
                        'user_id' => $senderId,
                        'receiver_id' => $receiverId,
                        'chat_id' => $chat->id,
                        'content' => $request->input('message'),
                        'file_path' => $filePath,
                    ]);

                    // Отправка сообщения через вещание
                    broadcast(new \App\Events\MessageSent($message))->toOthers();

                    return redirect()->route('users.show', $receiverId);
                } catch (\Exception $e) {
                    \Log::error('Ошибка при загрузке файла', [
                        'exception' => $e,
                        'file' => $file,
                        'request' => $request->all(),
                    ]);

                    return redirect()->route('users.show', $receiverId)->withErrors([
                        'file' => 'Ошибка при загрузке файла: ' . $e->getMessage(),
                    ]);
                }
            } else {
                return redirect()->route('users.show', $receiverId)->withErrors([
                    'file' => 'Ошибка при загрузке файла: ' . $file->getErrorMessage(),
                ]);
            }
        }

        Message::create([
            'user_id' => $senderId,
            'receiver_id' => $receiverId,
            'chat_id' => $chat->id,
            'content' => $request->input('message'),
        ]);

        return redirect()->route('users.show', $receiverId);
    }

    private function storeFile($file)
    {
        if (!$file || !$file->isValid()) {
            \Log::error('Файл не прошел валидацию', ['file' => $file]);
            return null;
        }

        $extension = $file->getClientOriginalExtension();
        $filename = uniqid() . '.' . $extension;

        $path = $file->storeAs('public/uploads', $filename);

        \Log::info('Успешная загрузка файла', ['file_path' => $path]);

        return 'uploads/' . $filename;
    }

    private function getOrCreateChat($senderId, $receiverId)
    {
        $chat = Chat::where(function ($query) use ($senderId, $receiverId) {
            $query->where('user_id', $senderId)->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('user_id', $receiverId)->where('receiver_id', $senderId);
        })->first();

        if (!$chat) {
            $receiver = User::findOrFail($receiverId);

            $chat = Chat::create([
                'user_id' => $senderId,
                'receiver_id' => $receiverId,
                'name' => $receiver->name,
            ]);
        }

        return $chat;
    }

    public function account()
    {
        // Получаем текущего авторизованного пользователя
        $user = auth()->user();

        // Получаем заявки текущего пользователя
        $requests = RequestModel::where('user_id', $user->id)->get();

        return view('users.account', compact('user', 'requests'));
    }

}
