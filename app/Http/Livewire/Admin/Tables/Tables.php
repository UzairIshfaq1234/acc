<?php

namespace App\Http\Livewire\Admin\Tables;

use App\Models\Table;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Tables extends Component
{
    public $tables,$name,$capacity,$layout,$table,$is_active = true,$lang;
    /* render the page */
    public function render()
    {
        $this->tables = Table::latest()->get();
        return view('livewire.admin.tables.tables');
    }
    /* store staff data*/
    public function create()
    {
        $this->validate([
            'name'  => 'required',
            'capacity'  => 'required',
            'layout'  => 'required',
        ]);
        $table = new Table();
        $table->name = $this->name;
        $table->capacity = $this->capacity;
        $table->layout = $this->layout;
        $table->is_active = $this->is_active;
        $table->save();
        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Table has been created!']);
    }
    /* process before render */
    public function mount()
    {
        $this->lang = getTranslation();
        if(!Auth::user()->can('tables_list'))
        {
            abort(404);
        }
    }


    public function edit(Table $table)
    {
        $this->resetFields();
        $this->table = $table;
        $this->name = $table->name;
        $this->capacity = $table->capacity;
        $this->layout = $table->layout;
        $this->is_active = $table->is_active;
    }

    public function update()
    {
        $this->validate([
            'name'  => 'required',
            'capacity'  => 'required',
            'layout'  => 'required',
        ]);
        $table = $this->table;
        $table->name = $this->name;
        $table->capacity = $this->capacity;
        $table->layout = $this->layout;
        $table->is_active = $this->is_active;
        $table->save();
        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Table has been updated!']);
    }

    public function delete(Table $table)
    {
        $table->delete();
        $this->table = null;
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Table has been deleted!']);
    }

    public function resetFields()
    {
        $this->resetErrorBag();
        $this->name = '';
        $this->capacity='';
        $this->layout='';
        $this->is_active = 1;
    }
}
