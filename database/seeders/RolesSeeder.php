<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Administrador']);
        $role2 = Role::create(['name' => 'Jefe de Departamento Catastro']);
        $role3 = Role::create(['name' => 'Jefe de Departamento RPP']);
        $role4 = Role::create(['name' => 'Distribuidor Catastro']);
        $role5 = Role::create(['name' => 'Distribuidor Rpp']);
        $role6 = Role::create(['name' => 'Despachador RPP']);
        $role7 = Role::create(['name' => 'Despachador Catastro']);
        $role8 = Role::create(['name' => 'Surtidor RPP']);
        $role9 = Role::create(['name' => 'Solicitante RPP']);
        $role10 = Role::create(['name' => 'Solicitante Catastro']);
        $role11 = Role::create(['name' => 'Digitalizador RPP']);
        $role12 = Role::create(['name' => 'Digitalizador Catastro']);

        Permission::create(['name' => 'Lista de roles', 'area' => 'Roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'Crear rol', 'area' => 'Roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar rol', 'area' => 'Roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar rol', 'area' => 'Roles'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de permisos', 'area' => 'Permisos'])->syncRoles([$role1]);
        Permission::create(['name' => 'Crear permiso', 'area' => 'Permisos'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar permiso', 'area' => 'Permisos'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar permiso', 'area' => 'Permisos'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de usuarios', 'area' => 'Usuarios'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'Crear usuario', 'area' => 'Usuarios'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'Editar usuario', 'area' => 'Usuarios'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'Borrar usuario', 'area' => 'Usuarios'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de archivos catastro', 'area' => 'Archivos Catastro'])->syncRoles([$role1, $role2, $role4, $role7, $role10]);
        Permission::create(['name' => 'Crear archivo catastro', 'area' => 'Archivos Catastro'])->syncRoles([$role1, $role2, $role4, $role7]);
        Permission::create(['name' => 'Editar archivo catastro', 'area' => 'Archivos Catastro'])->syncRoles([$role1, $role2, $role4, $role7]);
        Permission::create(['name' => 'Incidencias archivo catastro', 'area' => 'Archivos Catastro'])->syncRoles([$role1, $role2, $role4, $role7]);
        Permission::create(['name' => 'Borrar archivo catastro', 'area' => 'Archivos Catastro'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de archivos rpp', 'area' => 'Archivos Rpp'])->syncRoles([$role1, $role3, $role5, $role6, $role8, $role9]);
        Permission::create(['name' => 'Crear archivo rpp', 'area' => 'Archivos Rpp'])->syncRoles([$role1, $role3, $role5, $role6]);
        Permission::create(['name' => 'Editar archivo rpp', 'area' => 'Archivos Rpp'])->syncRoles([$role1, $role3, $role5, $role6]);
        Permission::create(['name' => 'Incidencias archivo rpp', 'area' => 'Archivos Rpp'])->syncRoles([$role1, $role3, $role5, $role6]);
        Permission::create(['name' => 'Borrar archivo rpp', 'area' => 'Archivos Rpp'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de solicitudes rpp', 'area' => 'Solicitudes RPP'])->syncRoles([$role1, $role3, $role5, $role6, $role8, $role9]);
        Permission::create(['name' => 'Crear solicitud rpp', 'area' => 'Solicitudes RPP'])->syncRoles([$role1, $role9]);
        Permission::create(['name' => 'Editar solicitud rpp', 'area' => 'Solicitudes RPP'])->syncRoles([$role1, $role3, $role5, $role6, $role9]);
        Permission::create(['name' => 'Borrar solicitud rpp', 'area' => 'Solicitudes RPP'])->syncRoles([$role1, $role3, $role5, $role6, $role9]);
        Permission::create(['name' => 'Aceptar solicitud rpp', 'area' => 'Solicitudes RPP'])->syncRoles([$role1, $role3, $role5, $role6]);
        Permission::create(['name' => 'Rechazar solicitud rpp', 'area' => 'Solicitudes RPP'])->syncRoles([$role1, $role3, $role5, $role6]);
        Permission::create(['name' => 'Entregar solicitud rpp', 'area' => 'Solicitudes RPP'])->syncRoles([$role1, $role3, $role5, $role6, ]);
        Permission::create(['name' => 'Ver solicitud rpp', 'area' => 'Solicitudes RPP'])->syncRoles([$role1, $role3, $role5, $role6, $role9]);

        Permission::create(['name' => 'Lista de solicitudes catastro', 'area' => 'Solicitudes Catastro'])->syncRoles([$role1, $role2, $role4, $role7, $role10]);
        Permission::create(['name' => 'Crear solicitud catastro', 'area' => 'Solicitudes Catastro'])->syncRoles([$role1, $role10]);
        Permission::create(['name' => 'Editar solicitud catastro', 'area' => 'Solicitudes Catastro'])->syncRoles([$role1, $role2, $role4, $role7, $role10]);
        Permission::create(['name' => 'Borrar solicitud catastro', 'area' => 'Solicitudes Catastro'])->syncRoles([$role1, $role2, $role4, $role7, $role10]);
        Permission::create(['name' => 'Aceptar solicitud catastro', 'area' => 'Solicitudes Catastro'])->syncRoles([$role1, $role2, $role4, $role7]);
        Permission::create(['name' => 'Rechazar solicitud catastro', 'area' => 'Solicitudes Catastro'])->syncRoles([$role1, $role2, $role4, $role7]);
        Permission::create(['name' => 'Ver solicitud catastro', 'area' => 'Solicitudes Catastro'])->syncRoles([$role1, $role2, $role4, $role7, $role10]);
        Permission::create(['name' => 'Entregar solicitud catastro', 'area' => 'Solicitudes Catastro'])->syncRoles([$role1, $role2, $role4, $role7]);

        Permission::create(['name' => 'Distribución RPP', 'area' => 'Distribución RPP'])->syncRoles([$role1, $role3, $role5, $role6, $role8]);
        Permission::create(['name' => 'Distribución Catastro', 'area' => 'Distribución Catastro'])->syncRoles([$role1, $role2, $role4, $role7]);

        Permission::create(['name' => 'Digitalización RPP', 'area' => 'Digitalización RPP'])->syncRoles([$role1, $role3, $role11]);
        Permission::create(['name' => 'Digitalización Catastro', 'area' => 'Digitalización Catastro'])->syncRoles([$role1, $role2, $role12]);

        Permission::create(['name' => 'Reportes Catastro', 'area' => 'Reportes'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'Reportes Rpp', 'area' => 'Reportes'])->syncRoles([$role1, $role3]);

        Permission::create(['name' => 'Auditoria', 'area' => 'Auditoria'])->syncRoles([$role1]);
    }
}
