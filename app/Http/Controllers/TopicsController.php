<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic)
	{
		$topics = Topic::withOrder($request->order)
            ->with('user','category')
            ->paginate(30);
		return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic)
    {
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
	    $categories = Category::all(); // 可有可无，在视图共享中已为所有视图共享 categories
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function store(TopicRequest $request, Topic $topic)
	{
//	      $topic->user_id = $request->user_id;
//        $topic->title = $request->title;
//        $topic->category_id = $request->category_id;
//        $topic->body = $request->body;

        $topic->fill($request->all());
        $topic->user_id = Auth::id();

		$topic->save();

//        dd($topic->excerpt);
		return redirect()->route('topics.show', $topic->id)->with('success', '发布成功！');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();  // 可有可无，在视图共享中已为所有视图共享 categories
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('success', '更新成功！');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($file, 'topics', Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }
}
