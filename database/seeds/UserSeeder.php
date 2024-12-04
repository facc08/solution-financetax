<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

          //resetea el cache de roles y permisos antes de exportar
          app()[PermissionRegistrar::class]->forgetCachedPermissions();
          $role1 = Role::create(['name'  => 'super-admin']);
          $role2 = Role::create(['name'  => 'admin']);
          $role3 = Role::create(['name'  => 'contador' ]);
          $role4 = Role::create(['name'  => 'financiero' ]);
          $role5 = Role::create(['name'  => 'marketing' ]);
          $role6 = Role::create(['name'  => 'abogado' ]);
          $role7 = Role::create(['name'  => 'invitado' ]);
          $role8 = Role::create(['name'  => 'cliente' ]);
  
          Permission::create(['name' => 'administracion']); //menu administracion
          Permission::create(['name' => 'mantenimientos']); //menu mantenimientos
          Permission::create(['name' => 'compra']); //menu lista compra
          //de administracion
          Permission::create(['name' => 'roles']);
          Permission::create(['name' => 'usuarios']);

          //de mantenimientos
          Permission::create(['name' => 'm-tipoplan']);
          Permission::create(['name' => 'm-plan']);
          Permission::create(['name' => 'm-tiposervicio']);
          Permission::create(['name' => 'm-servicio']);
          Permission::create(['name' => 'm-subservicio']);
          Permission::create(['name' => 'm-tipocuenta']);
          Permission::create(['name' => 'm-plancontable']);
          Permission::create(['name' => 'm-impuesto']);
          Permission::create(['name' => 'm-proyecciones']);
           // del menu de compra compra
          Permission::create(['name' => 'c-servicios']);
          Permission::create(['name' => 'c-misservicios']);
          Permission::create(['name' => 'c-admtienda']);
          Permission::create(['name' => 'c-miadmtienda']);
         
         
         
      
      
      
          DB::table('users')->insert([

           
            'name'         => 'Administrador',
            'email'           => 'admin@admin.com',
            'password'        => Hash::make('12345678'),
            'estado'          => 'activo',
            'created_at'      => now(),
            'updated_at'      => now()
        ]);
        $user = User::find(1);
        $user->assignRole($role1);

        // $user = User::create([
        //     'name'      =>  'Luis López',
        //     'email'     =>  'luisefrain1985@gmail.com',
        //     'password'  =>  bcrypt('123456'),
        //     'estado'    =>  'activo',
        // ]);
        // $user->assignRole($role1);
    }
}
