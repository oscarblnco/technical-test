<?php

namespace App\Livewire;

use Livewire\Attributes\Validate; 
use App\Models\BookCategory;
use App\Models\Book as BookModel;
use App\Models\Category as CategoryModel;
use Livewire\Component;
use Livewire\WithPagination;

class Book extends Component
{
    use WithPagination;

    public $id = null;
    public $perPage = 3;
    public $search = "";
    public $recordId = null;
    public $sortDirection = "DESC";
    public $sortColumn ="id";
    public $dataCategories = [];

    #[Validate('required',message:"Introduzca el titulo del libro.")] 
    public $title = "";

    #[Validate('required',message:"Introduzca el autor del libro.")] 
    public $author;

    #[Validate('required',message:"Introduzca la editorial del libro.")] 
    public $editorial;

    #[Validate('required',message:"Introduzca el año de publicación del libro.")] 
    public $yearPublication;

    public $categories =[];

    public function changeStatus($recordId)
    {
        $findBook = BookModel::find($recordId);
        $status = ($findBook->read == 1)? '0':'1';
        $findBook->fill(['read' => $status ])->save();
    }

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

    public function getData()
    {
        return BookModel::search($this->search)
        ->orderBy($this->sortColumn, $this->sortDirection)
        ->paginate($this->perPage);
    }

    public function selectId($id)
    {
        $this->recordId = $id;
        $this->modal('form-r')->show();
    }

    public function deleteRecord()
    {
        if ($this->recordId) {
            $book = BookModel::find($this->recordId);
            if ($book) {
                BookCategory::where('book_id',$book->id)->delete();
                $book->delete();
                $this->reset('recordId');
                $this->modal('form-r')->close();
                session()->flash('msg', __('Record deleted successfully.'));
            }
        }

    }

    public function formOpen($id = null)
    {
        $this->dataCategories = CategoryModel::all();

        if (!is_null($id)) {
            $book = BookModel::find($id);
            $this->id = $book->id;
            $this->title = $book->title;
            $this->author = $book->author;
            $this->editorial = $book->editorial;
            $this->yearPublication = $book->year_publication;
            $this->categories = $book->categories->pluck('id')->toArray();
        } else {
            $this->id = null;
            $this->title = "";
            $this->author = "";
            $this->editorial = "";
            $this->yearPublication = "";
            $this->categories = [];
        }
        $this->modal('form')->show();
    }

    public function save()
    {
        $this->validate();

        if (!is_null($this->id)) {
            $book = BookModel::find($this->id);
            $book->fill([
                'title' => $this->title,
                'author' => $this->author,
                'editorial' => $this->editorial,
                'year_publication' => $this->yearPublication
            ])->save();
            BookCategory::where('book_id',$book->id)->delete();
        } else {
            $book = BookModel::create([
                'title' => $this->title,
                'author' => $this->author,
                'editorial' => $this->editorial,
                'year_publication' => $this->yearPublication
            ]);
        }

        foreach($this->categories as $category)
        {
            BookCategory::create([
                'book_id' => $book->id,
                'category_id' => $category
            ]);
        }

        $this->modal('form')->close();
    }

    public function render()
    {
        $books = $this->getData();
        return view('livewire.books.index',['books'=>$books]);
    }
}
