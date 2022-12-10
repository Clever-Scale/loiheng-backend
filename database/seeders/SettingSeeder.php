<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting1 = Setting::create([
            'key'          =>  'general_site_name',
            'value'         =>  'LOI HENG',
            'created_by'      =>  1,
        ]);
        $setting2 = Setting::create([
            'key'          =>  'regis_enable_registration',
            'value'         =>  1,
            'created_by'      =>  1,
        ]);
        $setting3 = Setting::create([
            'key'          =>  'general_homepage_title',
            'value'         =>  'Loi Heng',
            'created_by'      =>  1,
        ]);
        $setting4 = Setting::create([
            'key'          =>  'exchange_rate',
            'value'         =>  2950,
            'created_by'      =>  1,
        ]);
        $setting5 = Setting::create([
            'key'          =>  'general_admin_email',
            'value'         =>  'admin@gmail.com',
            'created_by'      =>  1,
        ]);
        $setting6 = Setting::create([
            'key'          =>  'footer_address',
            'value'         =>  'No.10, Nant Thar Street, Ahlone Township, Yangon , Myanmar (Burma).',
            'created_by'      =>  1,
        ]);
        $setting7 = Setting::create([
            'key'          =>  'footer_mail',
            'value'         =>  'sales@loiheng.com',
            'created_by'      =>  1,
        ]);
        $setting8 = Setting::create([
            'key'          =>  'footer_phone',
            'value'         =>  '(09) 96 444 0531, 96 444 0532, 96 444 0535, 964 440 536.',
            'created_by'      =>  1,
        ]);
        $setting9 = Setting::create([
            'key'          =>  'yangon_address',
            'value'         =>  'No.10, Nanthar Street, Ahlone Township, Yangon , Myanmar (Burma).',
            'created_by'      =>  1,
        ]);
        $setting10 = Setting::create([
            'key'          =>  'yangon_phone',
            'value'         =>  '(09) 96 444 0531, 96 444 0532, 96 444 0535, 964 440 536.',
            'created_by'      =>  1,
        ]);
        $setting11 = Setting::create([
            'key'          =>  'mandalay_address',
            'value'         =>  '18, 34 Street, Between 78×79 Street, Chanayetharzan Township',
            'created_by'      =>  1,
        ]);
        $setting12 = Setting::create([
            'key'          =>  'mandalay_phone',
            'value'         =>  '(09) 79 136 6614, 73 098 730, 96 444 0540',
            'created_by'      =>  1,
        ]);
        $setting13 = Setting::create([
            'key'          =>  'singapore_address',
            'value'         =>  '21, Bukit Batok Crescent, #22-78, WCEGA Tower, S 658 065',
            'created_by'      =>  1,
        ]);
        $setting14 = Setting::create([
            'key'          =>  'singapore_phone',
            'value'         =>  '(65) 6336 4548',
            'created_by'      =>  1,
        ]);
        $setting15 = Setting::create([
            'key'          =>  'opening_hour',
            'value'         =>  'Monday ~ Saturday: 9:00 AM - 4:00 PM',
            'created_by'      =>  1,
        ]);
        $setting16 = Setting::create([
            'key'          =>  'facebook_url',
            'value'         =>  'https://www.facebook.com/loihengmm/',
            'created_by'      =>  1,
        ]);
        $setting17 = Setting::create([
            'key'          =>  'twitter_url',
            'value'         =>  'https://www.twitter.com/loihengmm',
            'created_by'      =>  1,
        ]);
        $setting18 = Setting::create([
            'key'          =>  'about',
            'value'         =>  '<p>Loi Heng International Pte Ltd is one of the leading IT Company provides products and networking solutions through channel dealers and direct sales, serving both the local and international organizations. Our official name in Myanmar is known as <font color="#0000ff"><b>THEIN HAN &amp; KHINE MYAE CO., LTD.</b></font> (aka LOI HENG INTERNATIONAL). In order to meet the needs of clients, we distribute a wide range of IT products that are well known globally and synonymous with ease of technology leadership. </p><ul><li><font color="#0000ff"><b> SMC Networks</b></font> – Full Range of Networking Products (Authorized Distributor for Singapore &amp; Myanmar) </li><li><font color="#0000ff"><b>EdgeCore</b></font> – Full Range of Networking Products (Authorized Distributor for Singapore &amp; Myanmar) </li><li><font color="#0000ff"><b>LevelOne</b></font> – Full Range of Networking Products (Authorized Distributor for Myanmar) </li><li><font color="#0000ff"><b>UBiQUiTi</b></font> – Full Range of Networking Products (Authorized Distributor for Myanmar) </li><li><font color="#0000ff"><b>SEPOMs</b></font> – Ink &amp; Paper (Photo Paper, Inkjet Paper… etc). (Authorized Distributor for Myanmar)</li><li><font color="#0000ff"><b> Darlink</b></font> – In-House Brand, Ink &amp; Paper (Photo Paper, Inkjet Paper… etc). </li><li><font color="#0000ff"><b>Super</b></font> – In-House Brand, Ink &amp; Paper (Photo Paper, Inkjet Paper… etc). </li><li><b><font color="#0000ff">Dell</font> </b>– Dell™ Business Partner. </li><li><b><font color="#0000ff">Corsair</font> </b>– PC &amp; Notebook RAM, Power Supply, Memory Stick (Business Partner for Myanmar)</li><li><b><font color="#0000ff"> Apple</font> </b>– Full range of Apple Products and related accessories. </li></ul><p>The above mentioned brands are some of the products that we are proudly carrying and supplying to our valued dealers. Basically most of the IT products, consumer and hi-end products you can relate to us as we are trying to act as One-Stop Distribution Centre. We are Platinum Member for most of our sources and we are importing from all over the world to compete, to supply the best for our customer/dealer.</p>',
            'created_by'      =>  1,
        ]);
        $setting19 = Setting::create([
            'key'          =>  'top_bar',
            'value'         =>  'ငွေစျေးအပြောင်းအလဲကြောင့် စျေးနှုန်းအနည်းငယ်ပြောင်းလဲနိုင်ပါသည်။',
            'created_by'      =>  1,
        ]);
        $setting20 = Setting::create([
            'key'          =>  'delivery_fee',
            'value'         =>  0,
            'created_by'      =>  1,
        ]);
        $setting21 = Setting::create([
            'key'          =>  'delivery_description',
            'value'         =>  'Delivery Charges',
            'created_by'      =>  1,
        ]);
    }
}
