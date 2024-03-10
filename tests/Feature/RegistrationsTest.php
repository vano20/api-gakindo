<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationsTest extends TestCase
{
   public function testCreateSuccess()
   {
        $this->post('/api/registrations', [
            'company_name' => 'PT. Foo bar',
            'contact_person' => 'John Doe',
            'email' => 'foo@bar.com',
            'phone_number' => '081234567890',
            'company_address' => 'Ir. Soekarno-Hatta No. 4',
            'npwp' => '1234567890123456',
            'qualification' => 'Konstruksi',
            'province_id' => 1,
            'position' => 'Koordinator'
        ])->assertStatus(201)->assertJson([
            'data' => [
                'company_name' => 'PT. Foo bar',
                'contact_person' => 'John Doe',
                'email' => 'foo@bar.com',
                'phone_number' => '081234567890',
                'company_address' => 'Ir. Soekarno-Hatta No. 4',
                'npwp' => '1234567890123456',
                'qualification' => 'Konstruksi',
                'province_id' => 1,
                'status' => 0,
                'period' => date('Y'),
                'position' => 'Koordinator'
            ]
        ]);
   }
}
