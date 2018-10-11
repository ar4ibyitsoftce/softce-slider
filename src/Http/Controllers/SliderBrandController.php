<?php

namespace Ar4ibyitsoftce\Brandslider\Http\Controllers;

use Mage2\Ecommerce\Http\Controllers\Admin\AdminController;
use Ar4ibyitsoftce\Brandslider\Http\Requests\SlideRequest;
use Ar4ibyitsoftce\Brandslider\Http\Requests\TypeRequest;
use Ar4ibyitsoftce\Brandslider\Module\Sliders_brand;
use File;
use DB;

class SliderBrandController extends AdminController
{

    private $path_slide = '';

    public function __construct()
    {
        $this->middleware(['admin.auth']);
        $this->path_slide = 'uploads/slider_brand';
    }

    /**
     * Show list slide
     */
    public function index()
    {
        return view('admin-slide::admin-slide')
            ->with('slides', Sliders_brand::all())
            ->with('path_slide', $this->path_slide);
    }

    /**
     * Create new slide
     * @param SlideRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SlideRequest $request)
    {
        $new_slide = $request->file('new_slide');

        if($new_slide) {
            foreach($new_slide as $slide) {
                $name_file = $slide->getClientOriginalName();
                $slide->move(public_path($this->path_slide), $name_file);
                Sliders_brand::create([
                    'path' => $name_file
                ]);
            }

            return redirect()->route('admin.slider-brand.index')->with('notificationText', 'Слайд(и) успешно добавлен(и)');
        }

        return redirect()->route('admin.slider-brand.index')->with('errorText', 'Для создания слайд(а/ов) нужно изображение');
    }

    /**
     * Update slide
     * @param SlideRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SlideRequest $request, $id)
    {
        $slide = Sliders_brand::find($id);
        if($slide){
            $new_slide = $request->file('slide');
            $data = $request->except(['_token', 'slide']);


            if($new_slide){
                File::delete(public_path($this->path_slide.'/'.$slide->path));

                $name_file = $new_slide->getClientOriginalName();
                $new_slide->move(public_path($this->path_slide), $name_file);
                $data['path'] = $name_file;
            }
            $slide->update($data);

            return redirect()->route('admin.slider-brand.index')->with('notificationText', 'Слайд успешно обновлен');
        }
        return redirect()->route('admin.slider-brand.index')->with('errorText', 'Ошибка обновления слайда. Повторите запрос позже!!!');
    }

    /**
     * Delete slide
     * @param $id_slide
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id_slide)
    {
        $slide = Sliders_brand::find($id_slide);
        if($slide){
            File::delete(public_path($this->path_slide.'/'.$slide->path));
            $slide->delete();
            return redirect()->route('admin.slider-brand.index')->with('notificationText', 'Слайд успешно удален');
        }
        return redirect()->route('admin.slider-brand.index')->with('errorText', 'Ошибка удаления слайда. Повторите запрос позже!!!');
    }

}