<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function news()
    {
        $news = News::all();
        return view('news.news', [
            'news' => $news
        ]);
    }

    public function newsDetails($id)
    {
        $news = News::findOrFail($id);
        return view('news.news_details', [
            'news' => $news
        ]);
    }

    public function newsManagement()
    {
        $news = News::all();
        return view('news.news_management', [
            'news' => $news
        ]);
    }

    public function create()
    {
        return view('news.news_create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|min:2',
                'description' => 'required',
                'img' => 'nullable',
            ],
            [
                'title.required' => 'The title cannot be empty.',
                'title.min' => 'The title must be at least 2 characters.',
                'description.required' => 'The description cannot be empty.',
                // 'img.required' => 'You have to add an image.',
            ]
        );
        
        $input = $request->all();

        // so we can store images
        if($request->hasFile('img')) {
            $input['img'] = $request->file('img')->store('imgs', 'public');
        }

        News::create($input);
        
        return redirect()
            ->route('news.management')
            ->with('feedback.message', 'The news <b>"' . e($input['title']) . '"</b> was uploaded successfully');
    }

    public function destroy(int $id) 
    {
        $news = News::findOrFail($id);
        $news->delete($id);

        if(
            $news->img &&
            Storage::has($news->img)
        ) {
            Storage::delete($news->img);
        }

        return redirect()
        ->route('news.management')
        ->with('feedback.message', 'The news <b>"' . e($news['title']) . '"</b> was deleted successfully');
    }

    public function delete(int $id)
    {
        return view('news.news_delete', [
            'news' => News::findOrFail($id),
        ]);
    }

    public function edit(int $id)
    {
        return view('news.news_edit', [
            'news' => News::findOrFail($id),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $request->validate(
            [
                'title' => 'required|min:2',
                'description' => 'required',
                'img' => 'required',
            ],
            [
                'title.required' => 'The title cannot be empty.',
                'title.min' => 'The title must be at least 2 characters.',
                'description.required' => 'The description cannot be empty.',
                'img.required' => 'You have to add an image.',
            ]
        );

        $news = News::findOrFail($id);

        $input = $request->except(['_token', '_method']);
        $oldImg = $news->img;

        if($request->hasFile('img')) {
            $input['img'] = $request->file('img')->store('imgs', 'public');
        }

        $news->update($input);
        
        if(
            $request->hasFile('img') &&
            $oldImg &&
            Storage::has($oldImg)
        ) {
            Storage::delete($oldImg);
        }


        return redirect()
            ->route('news.management')
            ->with('feedback.message', 'The news <b>"' . e($news->title) . '"</b> was updated successfully');
    }
}

