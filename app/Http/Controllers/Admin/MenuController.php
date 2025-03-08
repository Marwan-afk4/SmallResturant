<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Resturant;
use App\trait\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    use Image;

    protected $updateProduct =['resturant_id','category_id','name','price','description','image','status'];


    public function GetMenu($Resturantid){
        $menu = Menu::where('resturant_id','=',$Resturantid)->get();
        foreach($menu as $item){
            $item->image = asset('storage/'.$item->image);
        }
        $data =[
            'menu' => $menu
        ];
        return response()->json($data);
    }

    public function getResturantsandCategories(){
        $resturants = Resturant::all();
        $categories = Category::all();
        $data =[
            'resturants' => $resturants,
            'categories' => $categories
        ];
        return response()->json($data);
    }

    public function addproduct(Request $request){
        $validation = Validator::make($request->all(), [
            'resturant_id' => 'required|exists:resturants,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'image' => 'required',
            'status' => 'required|in:active,inactive',
        ]);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $menu = Menu::create([
            'resturant_id' => $request->resturant_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $this->storeBase64Image($request->image, 'admin/menu/producImage'),
            'status' => $request->status,
        ]);
        $data =[
            'message' => 'Product added successfully',
        ];
        return response()->json($data);
    }

    public function deleteProduct($id){
        $menu = Menu::find($id);
        $menu->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }

    public function updateProduct(Request $request, $id)
{
    $menu = Menu::find($id);

    if (!$menu) {
        return response()->json(['error' => 'Product not found'], 404);
    }

    $validation = Validator::make($request->all(), [
        'resturant_id' => 'required|exists:resturants,id',
        'category_id' => 'required|exists:categories,id',
        'name' => 'required',
        'price' => 'required',
        'description' => 'required',
        'image' => 'nullable',
        'status' => 'required|in:active,inactive',
    ]);

    if ($validation->fails()) {
        return response()->json(['errors' => $validation->errors()], 422);
    }


    if ($request->image) {
        $imagePath = $this->storeBase64Image($request->image, 'admin/menu/productImage');
        $menu->image = $imagePath;
    }

    $menu->update($request->except('image'));

    return response()->json(['menu' => $menu]);
}

}
