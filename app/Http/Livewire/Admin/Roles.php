<?php

namespace App\Http\Livewire\Admin;

use App\Http\Traits\ComponentesTrait;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Roles extends Component
{
    use WithPagination;
    use ComponentesTrait;

    public $nombre;
    public $listaDePermisos = [];

    protected function rules(){
        return [
            'nombre' => 'required'
         ];
    }

    public function resetearTodo(){

        $this->reset(['modalBorrar', 'crear', 'editar', 'modal', 'nombre', 'listaDePermisos']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function abrirModalEditar($modelo){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        $this->selected_id = $modelo['id'];
        $this->nombre = $modelo['name'];

        foreach($modelo['permissions'] as $permission){
            array_push($this->listaDePermisos, (string)$permission['id']);
        }

    }

    public function crear(){

        $this->validate();

        try {

            $role = Role::create([
                'name' => $this->nombre,
                'creado_por' => auth()->user()->id
            ]);

            $role->permissions()->sync($this->listaDePermisos);

            $this->resetearTodo();

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El role se creó con éxito."]);

        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
            $this->resetearTodo();
        }

    }

    public function actualizar(){

        try{

            $rol = Role::find($this->selected_id);

            $rol->update([
                'name' => $this->nombre,
                'actualizado_por' => auth()->user()->id
            ]);

            $rol->permissions()->sync($this->listaDePermisos);

            $this->resetearTodo();

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El rol se actualizó con éxito."]);

        } catch (\Throwable $th) {

            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function borrar(){

        try{

            $role = Role::find($this->selected_id);

            $role->delete();

            $this->resetearTodo();

            $this->dispatchBrowserEvent('mostrarMensaje', ['success', "El role se elimino con exito."]);

        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
            $this->resetearTodo();
        }

    }

    public function render()
    {

        $roles = Role::with('permissions')->where('name', 'LIKE', '%' . $this->search . '%')
                            ->paginate($this->pagination);

        $permisos = Permission::all();

        $permisos = $permisos->groupBy(function($permiso) {
            return $permiso->area;
        })->all();

        return view('livewire.admin.roles', compact('roles', 'permisos'))->extends('layouts.admin');
    }
}
