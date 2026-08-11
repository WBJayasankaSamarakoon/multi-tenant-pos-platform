<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (! Schema::hasTable('users')) {
            Artisan::call('migrate', [
                '--force' => true,
            ]);
        }

        $users = [
            ['name' => 'Owner Demo', 'email' => 'owner@demo.lk', 'role' => 'owner'],
            ['name' => 'Cashier Demo', 'email' => 'cashier@demo.lk', 'role' => 'cashier'],
            ['name' => 'Manager Demo', 'email' => 'manager@demo.lk', 'role' => 'manager'],
            ['name' => 'Platform Admin Demo', 'email' => 'admin@demo.lk', 'role' => 'admin'],
            ['name' => 'Northwind Owner', 'email' => 'owner2@demo.lk', 'role' => 'owner'],
            ['name' => 'Northwind Cashier', 'email' => 'cashier2@demo.lk', 'role' => 'cashier'],
            ['name' => 'Northwind Manager', 'email' => 'manager2@demo.lk', 'role' => 'manager'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'password' => 'demo1234',
                ]
            );
        }

        $ownerId = User::where('email', 'owner@demo.lk')->value('id');
        if (! $ownerId) {
            return;
        }

        DB::table('owner_companies')->updateOrInsert(
            ['owner_user_id' => $ownerId],
            [
                'name' => 'Perera Grocery',
                'email' => 'info@pereragrocery.lk',
                'phone' => '+94 77 123 4567',
                'address' => 'No. 42, Galle Road, Colombo 03',
                'currency' => 'LKR',
                'tax_rate' => 15,
                'invoice_template' => 'standard',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('owner_subscriptions')->updateOrInsert(
            ['owner_user_id' => $ownerId],
            [
                'plan' => 'Pro',
                'status' => 'Active',
                'price' => 5000,
                'renews_at' => now()->addMonth()->toDateString(),
                'user_limit' => 5,
                'product_limit' => 1000,
                'transaction_limit' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        foreach ([
            ['sku' => 'P001', 'name' => 'Basmati Rice 5kg', 'category' => 'Groceries', 'price' => 1850, 'stock' => 3, 'low_stock_threshold' => 10, 'supplier' => 'Lanka Rice Mills'],
            ['sku' => 'P002', 'name' => 'Coconut Oil 750ml', 'category' => 'Cooking', 'price' => 890, 'stock' => 5, 'low_stock_threshold' => 15, 'supplier' => 'Ceylon Oils Ltd'],
            ['sku' => 'P003', 'name' => 'Sugar 1kg', 'category' => 'Groceries', 'price' => 320, 'stock' => 8, 'low_stock_threshold' => 20, 'supplier' => 'Lanka Sugar Co'],
            ['sku' => 'P004', 'name' => 'Dhal 500g', 'category' => 'Groceries', 'price' => 480, 'stock' => 2, 'low_stock_threshold' => 10, 'supplier' => 'Import Foods Ltd'],
        ] as $product) {
            DB::table('owner_products')->updateOrInsert(
                ['owner_user_id' => $ownerId, 'sku' => $product['sku']],
                $product + ['owner_user_id' => $ownerId, 'created_at' => now(), 'updated_at' => now()]
            );
        }

        foreach ([
            ['name' => 'Saman Kumara', 'role' => 'Manager', 'email' => 'saman@pereragrocery.lk', 'phone' => '+94 77 234 5678', 'status' => 'Active', 'joined_at' => '2025-02-01'],
            ['name' => 'Kamala Dissanayake', 'role' => 'Cashier', 'email' => 'kamala@pereragrocery.lk', 'phone' => '+94 77 345 6789', 'status' => 'Active', 'joined_at' => '2025-02-15'],
            ['name' => 'Ruwan Jayawardena', 'role' => 'Cashier', 'email' => 'ruwan@pereragrocery.lk', 'phone' => '+94 77 456 7890', 'status' => 'Active', 'joined_at' => '2025-03-01'],
        ] as $employee) {
            DB::table('owner_employees')->updateOrInsert(
                ['owner_user_id' => $ownerId, 'email' => $employee['email']],
                $employee + ['owner_user_id' => $ownerId, 'created_at' => now(), 'updated_at' => now()]
            );
        }

        foreach ([
            ['customer_code' => 'C001', 'name' => 'Kamal Jayasinghe', 'email' => 'kamal@gmail.com', 'phone' => '+94 77 111 2233', 'total_purchases' => 45200, 'visits' => 28],
            ['customer_code' => 'C002', 'name' => 'Dilani Wickrama', 'email' => 'dilani@yahoo.com', 'phone' => '+94 77 222 3344', 'total_purchases' => 128500, 'visits' => 52],
            ['customer_code' => 'C003', 'name' => 'Sunil Bandara', 'email' => 'sunil@gmail.com', 'phone' => '+94 77 333 4455', 'total_purchases' => 18900, 'visits' => 12],
        ] as $customer) {
            DB::table('owner_customers')->updateOrInsert(
                ['owner_user_id' => $ownerId, 'customer_code' => $customer['customer_code']],
                $customer + ['owner_user_id' => $ownerId, 'created_at' => now(), 'updated_at' => now()]
            );
        }

        foreach ([
            ['invoice_number' => 'INV-1024', 'customer_name' => 'Kamal Jayasinghe', 'items_count' => 5, 'total' => 3450, 'payment_method' => 'Cash', 'status' => 'Completed', 'sold_at' => now()->subMinutes(12)],
            ['invoice_number' => 'INV-1023', 'customer_name' => 'Dilani Wickrama', 'items_count' => 12, 'total' => 12800, 'payment_method' => 'Card', 'status' => 'Completed', 'sold_at' => now()->subMinutes(35)],
            ['invoice_number' => 'INV-1022', 'customer_name' => 'Sunil Bandara', 'items_count' => 2, 'total' => 890, 'payment_method' => 'Cash', 'status' => 'Completed', 'sold_at' => now()->subHours(1)],
        ] as $sale) {
            DB::table('owner_sales')->updateOrInsert(
                ['owner_user_id' => $ownerId, 'invoice_number' => $sale['invoice_number']],
                $sale + ['owner_user_id' => $ownerId, 'created_at' => now(), 'updated_at' => now()]
            );
        }

        foreach ([
            ['period' => now()->subMonthsNoOverflow(2)->toDateString(), 'amount' => 5000, 'status' => 'Paid', 'paid_at' => now()->subMonthsNoOverflow(2)],
            ['period' => now()->subMonthNoOverflow()->toDateString(), 'amount' => 5000, 'status' => 'Paid', 'paid_at' => now()->subMonthNoOverflow()],
            ['period' => now()->toDateString(), 'amount' => 5000, 'status' => 'Paid', 'paid_at' => now()],
        ] as $payment) {
            DB::table('owner_subscription_payments')->updateOrInsert(
                ['owner_user_id' => $ownerId, 'period' => $payment['period']],
                $payment + ['owner_user_id' => $ownerId, 'created_at' => now(), 'updated_at' => now()]
            );
        }

        $secondaryOwnerId = User::where('email', 'owner2@demo.lk')->value('id');
        if ($secondaryOwnerId) {
            DB::table('owner_companies')->updateOrInsert(
                ['owner_user_id' => $secondaryOwnerId],
                [
                    'name' => 'Northwind Traders',
                    'email' => 'hello@northwind.lk',
                    'phone' => '+94 77 987 6543',
                    'address' => 'No. 8, Kandy Road, Kurunegala',
                    'currency' => 'LKR',
                    'tax_rate' => 15,
                    'invoice_template' => 'compact',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            DB::table('owner_subscriptions')->updateOrInsert(
                ['owner_user_id' => $secondaryOwnerId],
                [
                    'plan' => 'Basic',
                    'status' => 'Active',
                    'price' => 2500,
                    'renews_at' => now()->addMonth()->toDateString(),
                    'user_limit' => 2,
                    'product_limit' => 200,
                    'transaction_limit' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            foreach ([
                ['sku' => 'N001', 'name' => 'Tea Pack 250g', 'category' => 'Groceries', 'price' => 650, 'stock' => 18, 'low_stock_threshold' => 10, 'supplier' => 'North Tea Co'],
                ['sku' => 'N002', 'name' => 'Biscuits 400g', 'category' => 'Snacks', 'price' => 420, 'stock' => 22, 'low_stock_threshold' => 12, 'supplier' => 'North Snacks Ltd'],
            ] as $product) {
                DB::table('owner_products')->updateOrInsert(
                    ['owner_user_id' => $secondaryOwnerId, 'sku' => $product['sku']],
                    $product + ['owner_user_id' => $secondaryOwnerId, 'created_at' => now(), 'updated_at' => now()]
                );
            }

            foreach ([
                ['name' => 'Suren Perera', 'role' => 'Manager', 'email' => 'suren@northwind.lk', 'phone' => '+94 77 654 3210', 'status' => 'Active', 'joined_at' => '2025-04-01'],
                ['name' => 'Tharushi Silva', 'role' => 'Cashier', 'email' => 'tharushi@northwind.lk', 'phone' => '+94 77 654 3211', 'status' => 'Active', 'joined_at' => '2025-04-10'],
            ] as $employee) {
                DB::table('owner_employees')->updateOrInsert(
                    ['owner_user_id' => $secondaryOwnerId, 'email' => $employee['email']],
                    $employee + ['owner_user_id' => $secondaryOwnerId, 'created_at' => now(), 'updated_at' => now()]
                );
            }

            foreach ([
                ['customer_code' => 'N001', 'name' => 'Asanka Jayasuriya', 'email' => 'asanka@gmail.com', 'phone' => '+94 77 555 1212', 'total_purchases' => 16500, 'visits' => 9],
                ['customer_code' => 'N002', 'name' => 'Nimali Fernando', 'email' => 'nimali@gmail.com', 'phone' => '+94 77 555 3434', 'total_purchases' => 22100, 'visits' => 14],
            ] as $customer) {
                DB::table('owner_customers')->updateOrInsert(
                    ['owner_user_id' => $secondaryOwnerId, 'customer_code' => $customer['customer_code']],
                    $customer + ['owner_user_id' => $secondaryOwnerId, 'created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }
}
