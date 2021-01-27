<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;

use Illuminate\Http\Request;
use Illuminate\Support\Str;


/**
 * Class CategoryController
 * @package App\Http\Controllers\Blog\Admin
 */
class CategoryController extends BaseController
{

    /**
     * @var BlogCategoryRepository App\Repositories\BlogCategoryRepository
     */
    private $blogCategoryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$paginator = BlogCategory::paginate(5);
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(5);
        return view('blog.admin.categories.index',compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new BlogCategory();
        //$categoryList = BlogCategory::all();
        $categoryList = $this->blogCategoryRepository->getForComboBox();
        return view('blog.admin.categories.edit',compact('item','categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();
        if (empty($data['slug'])) {
            $data['slug'] = Str::of($data['title'])->slug();
        }

        $item = new BlogCategory($data);

        //dd($item);

        $item->save();

        if ($item) {
            return redirect()->route('blog.admin.categories.edit',[$item->id])->with(['success'=>'Успешно сохранено']);
        } else {
            return back()->withErrors(['msg'=>'Ошибка сохранения'])->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //получаем данные через репозитории, для вынесения бизнесс-логики из контроллера
        $item = $this->blogCategoryRepository->getEdit($id);
        if (empty($item)) abort(404);

        $categoryList = $this->blogCategoryRepository->getForComboBox();

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
        $item = $this->blogCategoryRepository->getEdit($id);
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
