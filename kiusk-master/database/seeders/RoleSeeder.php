<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'user_management_access',
            'permission_access',
            'permission_create',
            'permission_edit',
            'permission_delete',
            'permission_show',
            'role_access',
            'role_create',
            'role_edit',
            'role_delete',
            'role_show',
            'user_access',
            'user_create',
            'user_edit',
            'user_delete',
            'user_show',
            'ad_access',
            'ad_create',
            'ad_edit',
            'ad_delete',
            'ad_show',
            'real_estate_access',
            'real_estate_create',
            'real_estate_edit',
            'real_estate_delete',
            'real_estate_show',
            'seller_access',
            'seller_create',
            'seller_edit',
            'seller_delete',
            'seller_show',
            'business_owner_access',
            'business_owner_create',
            'business_owner_edit',
            'business_owner_delete',
            'business_owner_show',
            'category_access',
            'category_create',
            'category_edit',
            'category_delete',
            'category_show',
            'comment_access',
            'comment_create',
            'comment_edit',
            'comment_delete',
            'comment_show',
            'review_access',
            'review_create',
            'review_edit',
            'review_delete',
            'review_show',
            'post_access',
            'post_create',
            'post_edit',
            'post_delete',
            'post_show',
            'post_category_access',
            'post_category_create',
            'post_category_edit',
            'post_category_delete',
            'post_category_show',
            'advertisement_access',
            'advertisement_create',
            'advertisement_edit',
            'advertisement_delete',
            'advertisement_show',
            'chat_access',
            'chat_create',
            'chat_edit',
            'chat_delete',
            'chat_show',
            'plan_access',
            'plan_create',
            'plan_edit',
            'plan_delete',
            'plan_show',
            'rating_access',
            'rating_create',
            'rating_edit',
            'rating_delete',
            'rating_show',
            'ticket_access',
            'ticket_create',
            'ticket_edit',
            'ticket_delete',
            'ticket_show',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $superAdmin = Role::create(['name' => 'super_admin']);
        $admin = Role::create(['name' => 'admin']);
        $seo = Role::create(['name' => 'seo']);
        $author = Role::create(['name' => 'author']);


        $customer = Role::create(['name' => 'customer']);
        $business_owner = Role::create(['name' => 'business_owner']);
        $seller = Role::create(['name' => 'seller']);
        $real_estate = Role::create(['name' => 'real_estate']);
        $vip = Role::create(['name' => 'vip']);

        $customerPermissions = [
            'post_category_access',
            'post_category_show',
            'post_access',
            'post_show',
            'ad_access',
            'ad_show',
            'real_estate_access',
            'real_estate_show',
            'seller_access',
            'seller_show',
            'business_owner_access',
            'business_owner_show',
            'category_access',
            'category_show',
            'advertisement_access',
            'advertisement_create',
            'advertisement_edit',
            'advertisement_delete',
            'advertisement_show',
            'chat_access',
            'chat_create',
            'chat_edit',
            'chat_delete',
            'chat_show',
            'comment_access',
            'comment_create',
            'comment_edit',
            'comment_delete',
            'comment_show',
            'review_access',
            'review_create',
            'review_edit',
            'review_delete',
            'review_show',
            'rating_access',
            'rating_create',
            'rating_edit',
            'rating_delete',
            'rating_show',
            'ticket_access',
            'ticket_create',
            'ticket_edit',
            'ticket_delete',
            'ticket_show',
        ];

        foreach ($customerPermissions as $permission) {
            $customer->givePermissionTo($permission);
        }

        $businessOwnerPermissions = [
            'post_category_access',
            'post_category_show',
            'post_access',
            'post_show',
            'ad_access',
            'ad_show',
            'real_estate_access',
            'real_estate_show',
            'seller_access',
            'seller_show',
            'business_owner_access',
            'business_owner_create',
            'business_owner_edit',
            'business_owner_delete',
            'business_owner_show',
            'category_access',
            'category_show',
            'advertisement_access',
            'advertisement_create',
            'advertisement_edit',
            'advertisement_delete',
            'advertisement_show',
            'chat_access',
            'chat_create',
            'chat_edit',
            'chat_delete',
            'chat_show',
            'comment_access',
            'comment_create',
            'comment_edit',
            'comment_delete',
            'comment_show',
            'review_access',
            'review_create',
            'review_edit',
            'review_delete',
            'review_show',
            'rating_access',
            'rating_create',
            'rating_edit',
            'rating_delete',
            'rating_show',
            'ticket_access',
            'ticket_create',
            'ticket_edit',
            'ticket_delete',
            'ticket_show',
        ];

        foreach ($businessOwnerPermissions as $permission) {
            $business_owner->givePermissionTo($permission);
        }

        $sellerPermissions = [
            'post_category_access',
            'post_category_show',
            'post_access',
            'post_show',
            'ad_access',
            'ad_show',
            'real_estate_access',
            'real_estate_show',
            'seller_access',
            'seller_create',
            'seller_edit',
            'seller_delete',
            'seller_show',
            'business_owner_access',
            'business_owner_show',
            'category_access',
            'category_show',
            'advertisement_access',
            'advertisement_create',
            'advertisement_edit',
            'advertisement_delete',
            'advertisement_show',
            'chat_access',
            'chat_create',
            'chat_edit',
            'chat_delete',
            'chat_show',
            'comment_access',
            'comment_create',
            'comment_edit',
            'comment_delete',
            'comment_show',
            'review_access',
            'review_create',
            'review_edit',
            'review_delete',
            'review_show',
            'rating_access',
            'rating_create',
            'rating_edit',
            'rating_delete',
            'rating_show',
            'ticket_access',
            'ticket_create',
            'ticket_edit',
            'ticket_delete',
            'ticket_show',
        ];

        foreach ($sellerPermissions as $permission) {
            $seller->givePermissionTo($permission);
        }

        $realEstatePermissions = [
            'post_category_access',
            'post_category_show',
            'post_access',
            'post_show',
            'ad_access',
            'ad_show',
            'real_estate_access',
            'real_estate_create',
            'real_estate_edit',
            'real_estate_delete',
            'real_estate_show',
            'seller_access',
            'seller_show',
            'business_owner_access',
            'business_owner_show',
            'category_access',
            'category_show',
            'advertisement_access',
            'advertisement_create',
            'advertisement_edit',
            'advertisement_delete',
            'advertisement_show',
            'chat_access',
            'chat_create',
            'chat_edit',
            'chat_delete',
            'chat_show',
            'comment_access',
            'comment_create',
            'comment_edit',
            'comment_delete',
            'comment_show',
            'review_access',
            'review_create',
            'review_edit',
            'review_delete',
            'review_show',
            'rating_access',
            'rating_create',
            'rating_edit',
            'rating_delete',
            'rating_show',
            'ticket_access',
            'ticket_create',
            'ticket_edit',
            'ticket_delete',
            'ticket_show',
        ];

        foreach ($realEstatePermissions as $permission) {
            $real_estate->givePermissionTo($permission);
        }

        $vipPermissions = [
            'post_category_access',
            'post_category_show',
            'post_access',
            'post_show',
            'ad_access',
            'ad_show',
            'real_estate_access',
            'real_estate_create',
            'real_estate_edit',
            'real_estate_delete',
            'real_estate_show',
            'seller_access',
            'seller_create',
            'seller_edit',
            'seller_delete',
            'seller_show',
            'business_owner_access',
            'business_owner_create',
            'business_owner_edit',
            'business_owner_delete',
            'business_owner_show',
            'category_access',
            'category_show',
            'advertisement_access',
            'advertisement_create',
            'advertisement_edit',
            'advertisement_delete',
            'advertisement_show',
            'chat_access',
            'chat_create',
            'chat_edit',
            'chat_delete',
            'chat_show',
            'comment_access',
            'comment_create',
            'comment_edit',
            'comment_delete',
            'comment_show',
            'review_access',
            'review_create',
            'review_edit',
            'review_delete',
            'review_show',
            'rating_access',
            'rating_create',
            'rating_edit',
            'rating_delete',
            'rating_show',
            'ticket_access',
            'ticket_create',
            'ticket_edit',
            'ticket_delete',
            'ticket_show',
        ];

        foreach ($vipPermissions as $permission) {
            $vip->givePermissionTo($permission);
        }
    }
}