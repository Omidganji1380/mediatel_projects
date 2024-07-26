<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class UsersExport implements FromQuery, WithMapping, WithHeadings, WithCustomValueBinder
{
    use Exportable;

    protected $startOfMonth;
    protected $endOfMonth;
    public const ROLES = [
        'admin' => 'Admin',
        'super_admin' => 'Super Admin',
        'customer' => 'Customer',
        'subscriber' => 'Subscriber',
        'seo' => 'seo',
        'author' => 'author',
        'business_owner' => 'Business Owner',
        'seller' => 'Seller',
        'real_estate' => 'Real Estate',
        'property_applicant' => 'Property Applicant',
        'vip' => 'VIP'
    ];

    public function __construct($startOfMonth, $endOfMonth)
    {
        $this->startOfMonth = $startOfMonth;
        $this->endOfMonth = $endOfMonth;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return User::query()->whereBetween('created_at', [
            $this->startOfMonth,
            $this->endOfMonth,
        ])->where('email', 'not like', '%@telegram.telegram');
    }

    public function map($user): array
    {
        // Customize the fields you want to export
        return [
            $user->id,
            $user->full_name,
            self::ROLES[$user->getRoleNames()?->first()] ?? 'no-role',
            $user->email,
            $user->full_phone,
            $user->created_at,
        ];
    }

    public function headings(): array
    {
        // Set the column headers
        return [
            'ID',
            'Name',
            'Role',
            'Email',
            'Phone',
            'Register Date',
        ];
    }

    public function bindValue(Cell $cell, $value)
    {
        // Format the phone number as a string
        $stringValue = (string) $value;
        $cell->setValueExplicit($stringValue, DataType::TYPE_STRING);
        return true;
    }
}
