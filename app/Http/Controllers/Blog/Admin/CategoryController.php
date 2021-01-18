<?php

namespace App\Http\Controllers\Blog\Admin;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Requests\BlogCategoryUpdateRequest;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = BlogCategory::paginate(5);

        return view('blog.admin.categories.index',compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd(__METHOD__);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd(__METHOD__);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = BlogCategory::findOrFail($id);
        $categoryList = BlogCategory::all();
        return view('blog.admin.categories.edit',compact('item','categoryList'));
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        /*
            $rules = [
                'title' => 'required|min:5|max:200',
                'slug'  =>  'max:200',
                'description' => 'string|min:3|max:500',
                'parent_id' => 'required|integer|exists:blog_categories,id',
            ];

            //$validateData = $this->validate($request,$rules);

            //$validateData = $request->validate($rules);   //редирект в случае ошибки


            $validator = \Validator::make($request->all(),$rules);
            $validateData[] = $validator->passes();     //и выполнит проверку, заполняет даные ошибок, вернет TRUE если ОК, и FALSE если НЕ ОК и есть ошибки
            $validateData[] = $validator->validate(); //редиректит если данные не валидны
            $validateData[] = $validator->valid();      // те поля которые валидны
            $validateData[] = $validator->failed();     // те поля которые не валидны
            $validateData[] = $validator->errors();     // сообщения о ошибках
            $validateData[] = $validator->fails();      // TRUE = если ошибки, FALSE = нет ошибок

            dd($validateData);
        */

        $item = BlogCategory::find($id);
        if (empty($item)) {
            return back()->withErrors(['msg'=>"Запись ID-[{$id}] не найдена"])->withInput();
        }

        $data = $request->all();
        $result = $item->fill($data)->save();
        if ($result) {
            return redirect()->route('blog.admin.categories.edit',$item->id)->with(['success'=> 'Успешно сохранено']);
        } else {
            return back()->withErrors(['msg'=>'Ошибка сохранения'])->withInput();
        }

    }

}
