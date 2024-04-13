<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    // Метод для отображения списка отзывов
    public function index()
    {
        $reviews = Review::all();
        return view('reviews.index', compact('reviews'));
    }

    // Метод для создания нового отзыва
    public function store(Request $request)
    {
        // Валидация данных отзыва
        $request->validate([
            'content' => 'required|string',
        ]);

        // Создание нового отзыва
        $review = new Review();
        $review->user_id = auth()->id(); // ID текущего пользователя
        $review->content = $request->content;
        $review->save();

        return redirect()->route('reviews.index')->with('success', 'Отзыв успешно добавлен');
    }
}
