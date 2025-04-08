<?php

namespace App\Livewire;

use Livewire\Attributes\Validate; 
use App\Models\Category as CategoryModel;
use Livewire\Component;
use Livewire\WithPagination;

class Category extends Component
{
    use WithPagination;

    public $id = null;
    public $perPage = 3;
    public $search = "";
    public $recordId = null;
    public $sortDirection = "ASC";
    public $sortColumn ="name";
    
    #[Validate('required',message:"Introduzca un nombre para la categoria del libro.")] 
    public $name = "";

    public $description = "";

    public function doSort($column)
    {
        if($this->sortColumn===$column)
        {
            $this->sortDirection = ($this->sortDirection=='ASC')? 'DESC':'ASC';
            return;
        }

        $this->sortColumn = $column;
        $this->sortDirection = "ASC";
    }

    public function selectId($id)
    {
        $this->recordId = $id;
        $this->modal('form-r')->show();
    }

    public function deleteRecord()
        {
            if ($this->recordId) {
                $registro = CategoryModel::find($this->recordId);
                if ($registro) {
                    $registro->delete();
                    $this->reset('recordId');
                    $this->modal('form-r')->close();
                    session()->flash('msg', __('Record deleted successfully.'));
                }
            }

        }

    public function getData()
    {
        return CategoryModel::search($this->search)
        ->orderBy($this->sortColumn, $this->sortDirection)
        ->paginate($this->perPage);
    }

    public function formOpen($id = null)
    {
        if (!is_null($id)) {
            $category = CategoryModel::find($id);
            $this->id = $category->id;
            $this->name = $category->name;
            $this->description = $category->description;


        } else {
            $this->id = null;
            $this->name = "";
            $this->description = "";
        }
        $this->modal('form')->show();
    }

    public function save()
    {
        $this->validate(); 

        if (!is_null($this->id)) {
            $category = CategoryModel::find($this->id);
            $category->fill([
                'name' => $this->name,
                'description' => $this->description,
            ])->save();
        } else {
            CategoryModel::create([
                'name' => $this->name,
                'description' => $this->description,
            ]);
        }
        $this->modal('form')->close();
    }
    
    public function render()
    {
        $categories = $this->getData();
        return view('livewire.categories.index',['categories'=>$categories]);
    }

}
