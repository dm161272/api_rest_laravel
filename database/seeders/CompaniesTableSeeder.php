<?php

namespace Database\Seeders;


use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents("https://challenges-asset-files.s3.us-east-2.amazonaws.com/jobMadrid/companies.json");
        $json = json_decode($json, true);
        foreach ($json as $company) {
            Company::create($company);
        }  
    }
}