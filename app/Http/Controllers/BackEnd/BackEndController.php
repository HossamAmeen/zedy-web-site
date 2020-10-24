<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Image , Auth;

class BackEndController extends Controller
{

    protected $model;
    protected $routeNameEdit;
    protected $orderBy;
    public function __construct(Model $model , $orderBy = "id")
    {
        $this->model = $model;
        $this->orderBy = $orderBy ; 
    }

    public function getRouteName()
    {
        return   isset($this->routeNameEdit) ? $this->routeNameEdit :  $this->getClassNameFromModel();
    }

    public function index()
    {
        $rows = $this->model;
        $rows = $this->filter($rows);
        $with = $this->with();
        if (!empty($with)) {
            $rows = $rows->with($with);
        }
        $rows = $rows->orderBy('id', 'DESC')->get();
        $moduleName = $this->pluralModelName();
        $sModuleName = $this->getModelName();
        $routeName = $this->getClassNameFromModel();
        $pageTitle = "Control " . $moduleName;
        $pageDes = "Here you can add / edit / delete " . $moduleName;
        // return $rows;
        // return Auth::user()->role;
        return view('back-end.' . $routeName . '.index', compact(
            'rows',
            'pageTitle',
            'moduleName',
            'pageDes',
            'sModuleName',
            'routeName'
        ));
    }

    public function create()
    {
        $moduleName = $this->getModelName();
        $pageTitle = "Create " . $moduleName;
        $pageDes = "Here you can create " . $moduleName;
        $folderName = $this->getClassNameFromModel();
        $routeName = $folderName;
        $append = $this->append(null);

        // return  request()->segment(3);
        return view('back-end.' . $folderName . '.create', compact(
            'pageTitle',
            'moduleName',
            'pageDes',
            'folderName',
            'routeName'
        ))->with($append);
    }

    // public function store(Request $request){
    //     $requestArray = $request->all();
    //     $requestArray['user_id'] = Auth::user()->id;
    //     $item=  $this->model->create($requestArray );
    //     $routeName = $this->getRouteName();
    //     return view('back-end.'.$routeName .'.row' , compact('item' , 'routeName'));
    // }

    // public function update($id , Request $request){
    //     $row = $this->model->FindOrFail($id);
    //     $requestArray = $request->all();
    //     $requestArray['user_id'] = Auth::user()->id;
    //     $row->update($requestArray);
    //     session()->flash('action', 'تمت التحديث بنجاح');
    //     return redirect()->route($this->getClassNameFromModel().'.index');
    // }
    
    public function destroy($id)
    {
        $this->model->FindOrFail($id)->delete();

        return redirect()->route($this->getClassNameFromModel() . '.index');
    }

    public function edit($id)
    {
        // return Auth::user()->role;
        $row = $this->model->FindOrFail($id);
        $moduleName = $this->getModelName();
        $pageTitle = "Edit " . $moduleName;
        $pageDes = "Here you can edit " . $moduleName;
        $folderName = $this->getClassNameFromModel();
        $routeName = $folderName;
        $append = $this->append($row);
        // return $this->model;
        // return $append;
        return view('back-end.' . $folderName . '.edit', compact(
            'row',
            'pageTitle',
            'moduleName',
            'pageDes',
            'folderName',
            'routeName'
        ))->with($append);
    }
    public function getDownload($path)
    {
        //PDF file is stored under project/public/download/info.pdf
        $file = public_path() . "/download/info.pdf";

        $headers = array(
            'Content-Type: application/pdf',
        );

        return Response::download($file, 'filename.pdf', $headers);
    }
    protected function uploadImage($request, $height = 400, $width = 400)
    {

        $photo = $request->file('image');
        $fileName = time() . str_random('10') . '.' . $photo->getClientOriginalExtension();
        $destinationPath = 'uploads/' . $this->getClassNameFromModel() . '/';
        $image = Image::make($photo->getRealPath())->resize($height, $width);

        // return $destinationPath;

        if (!is_dir($destinationPath)) {
            mkdir($destinationPath);
        }
        $image->save($destinationPath . $fileName);
        return 'uploads/' . $this->getClassNameFromModel() . '/' . $fileName;
    }
    protected function storeFile($file)
    {
        $mytime = Carbon\Carbon::now();
        $file = Input::file('file');
        $path = '/' . $this->pluralModelName();
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $name = $this->pluralModelName() . ' ' . $mytime->toDateTimeString() . '.' . $file->getClientOriginalExtension();

        $name = str_replace(' ', '_', $name);
        $name = str_replace(':', '_', $name);
        // $destinationPath = public_path('/' . $this->pluralModelName().'/');
        $destinationPath = public_path();
      
        $file->move($destinationPath, $name);
        return $this->pluralModelName() . '/' . $name;
    }

    protected function filter($rows)
    {
        return $rows;
    }

    protected function with()
    {
        return [];
    }

    protected function getClassNameFromModel()
    {
        return strtolower($this->pluralModelName());
    }

    protected function pluralModelName()
    {
        return str_plural($this->getModelName());
    }

    protected function getModelName()
    {
        return class_basename($this->model);
    }

    protected function append($row)
    {
        return [];
    }

}
