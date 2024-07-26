<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PropertyApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $property_applicant = Role::create(['name' => 'property_applicant']);

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
            $property_applicant->givePermissionTo($permission);
        }
    }
}
