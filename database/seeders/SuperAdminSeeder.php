<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Define all permissions found in the system
        $permissions = [
            'Sales',
            'Products',
            'Category',
            'Sub Category',
            'Brands',
            'Purchase',
            'Purchase Return',
            'Vendor',
            'List Warehouse',
            'Warehouse Stock',
            'Stock Transfer',
            'Sale Return',
            'Bookings',
            'Customer',
            'Char Of Accounts',
            'Expense Voucher',
            'Receipts Voucher',
            'Payment Voucher',
            'Narrations',
            'Item Stock Report',
            'Purchase Report',
            'Sale Report',
            'Customer Ledger',
            'Vendor Ledger',
            'System Reports',
            // CRUD specific if needed
            'Create Product',
            'Edit Product',
            'Delete Product',
            'View Product',
        ];

        // 2. Create permissions if they don't exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 3. Create or find the Admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // 4. Sync all permissions to the admin role
        $adminRole->syncPermissions(Permission::all());

        // 5. Create the Super Admin user
        $user = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('808080'),
            ]
        );

        // 6. Assign role to user
        $user->assignRole($adminRole);

        $this->command->info('Super Admin created successfully with email: admin@admin.com and password: 808080');
    }
}
