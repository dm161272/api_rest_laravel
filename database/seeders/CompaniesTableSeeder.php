<?php

namespace Database\Seeders;


use App\Models\Company;
use Illuminate\Database\Seeder;

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
        foreach ($json as $index => $company) {

              $s = explode("-", $json[$index]['size']);
              unset($company['size']);
              $min = (int)$s[0];
              if (count($s) == 1) 
              {  
                $max = "+";
              }
              else 
              {
                $max = (int)$s[1];
              }
                $company['size_min'] = $min;
                $company['size_max'] = $max;
              
                Company::create($company);
            }
        }  
    }
