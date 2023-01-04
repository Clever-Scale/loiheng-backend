<?php

namespace Database\Seeders;

use App\Models\CompanyProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company_profile = CompanyProfile::create([
            'image'          =>  '',
            'title'         =>  'About Us',
            'content'      =>  "Loi Heng International Pte Ltd is one of the leading IT
            Company provides products and networking solutions through
            channel dealers and direct sales, serving both the local
            and international organizations. Our official name in
            Myanmar is known as THEIN HAN & KHINE MYAE CO., LTD. (aka
            LOI HENG INTERNATIONAL). In order to meet the needs of
            clients, we distribute a wide range of IT products that
            are well known globally and synonymous with ease of
            technology leadership. SMC Networks – Full Range of
            Networking Products (Authorized Distributor for Singapore
            & Myanmar) EdgeCore – Full Range of Networking Products
            (Authorized Distributor for Singapore & Myanmar) LevelOne
            – Full Range of Networking Products (Authorized
            Distributor for Myanmar) UBiQUiTi – Full Range of
            Networking Products (Authorized Distributor for Myanmar)
            SEPOMs – Ink & Paper (Photo Paper, Inkjet Paper… etc).",
        ]);
    }
}
