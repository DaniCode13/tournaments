<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ImageInter;

class ImageController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $images =auth()->user()->images()->get();

        return response()->json($images, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data = $request->validate([
        //     'image' => 'required'
        // ]);
        $this->user = auth()->user()->id;
        $image = $request->image;
        $this->check_directory_exists();
        $path = $this->save_formats_images($image);
        $image= auth()->user()->images()->create(['image_url' => $path]);
        return response()->json($image, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }

    private function save_formats_images($image)
    {
        $name_image = uniqid() . "." . $image->getClientOriginalExtension();
        $path = $image->storeAs("/users/{$this->user}/images/original", $name_image, "public");
        $original = ImageInter::make(storage_path("app/public/{$path}"));
        $original->backup();

        $original->fit(600,600, function ($constraint) {
            $constraint->upsize();
        })->save(storage_path("app/public/users/{$this->user}/images/medium/{$name_image}"));

        $original->fit(250,250, function ($constraint) {
            $constraint->upsize();
        })->save(storage_path("app/public/users/{$this->user}/images/small/{$name_image}"));
        // $original->resize(400, 400, function ($constraint) {
        //     $constraint->aspectRatio();
        // })->save(storage_path("app/public/users/{$this->user}/images/medium/{$name_image}"));
        $original->reset();
        // $original->resize(100, 100)->save(storage_path("app/public/users/{$this->user}/images/thumbnail/{$name_image}"));
        $original->fit(100, 100,function($constraint){
            $constraint->upsize();
        })->save(storage_path("app/public/users/{$this->user}/images/thumbnail/{$name_image}"));
        return $path;
    }

    private function check_directory_exists()
    {
        $medium = "public/users/{$this->user}/images/medium";
        $small = "public/users/{$this->user}/images/small";
        $thumbnail = "public/users/{$this->user}/images/thumbnail";
        $directories = [$medium, $small, $thumbnail];
        foreach ($directories as $key => $directory) {
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory, 0775, true);
            }
        }
    }
}
