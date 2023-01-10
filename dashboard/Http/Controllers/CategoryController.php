<?php

namespace Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Coderello\SharedData\Facades\SharedData;
use Dashboard\Rules\Slug;
use App\Http\Controllers\HelperTrait;
use App\Models\AddCategory;
use App\Models\Category;
use File;

class CategoryController extends Controller
{
    use HelperTrait;

    /**
     * Страница со списком категорий
     *
     * @return Illuminate\Support\Facades\View
     */
    public function categories()
    {
        $categories = Category::all();
        SharedData::put([
            'categories' => $categories,
        ]);

        return view('dashboard::pages.category.list', [
            'categories' => $categories,
        ]);
    }

    /**
     * Страница редактирования категории
     *
     * @param int $id
     * @return [type] [description]
     */
    public function category($id)
    {
        $this->breadcrumbs['category'] = 'Категории';
        $category = Category::query()->findOrNew($id);
        $this->data['category'] = $category;

        return view('dashboard::pages.category.item', [
            'category' => $category,
        ]);
    }

    /**
     * Создание/редактирование категории
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function postCategory(Request $request)
    {
        $data = $this->validate($request, [
            'name' => ['required'],
            'slug' => ['required', new Slug, Rule::unique('categories')->ignore($request->get('id'))],
            'image' => ['image', 'max:5000'],
        ], [
            'slug.slug' => 'Некорректное имя ссылки. Разрешенные символы латинские буквы, цифры и тире'
        ]);
        $category = Category::updateOrCreate(['id' => $request->get('id')], $request->only(['name', 'slug', 'image']));
        if ($request->hasFile('image')) {
            $fileName = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
            $fields = $this->processingImage($request, $category, 'image', $fileName, 'images/categories');
            $category->update(['image' => $fields['image']]);
        }
        return redirect()->route('dashboard.categoryList');
    }

    /**
     * Удаление категории
     *
     * @return [type] [description]
     */
    public function deleteCategory(Request $request)
    {
        $this->validate($request, [
            'id' => ['required', 'integer', 'exists:categories,id'],
        ]);
        $category = Category::findOrFail($request->get('id'));
        if ($category->image && file_exists($category->image)) {
            File::delete($category->image);
        }
        $category->delete();
        return response()->json(['success' => true]);
    }
}
