<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = [
            [
                'name'    => 'Ayesha Khan',
                'email'   => 'ayesha.khan@example.com',
                'phone'   => '+92 300 1234567',
                'message' => 'Hi, I wanted to ask about the sizing for the Floral Cotton Frock — my daughter is 4 years old. Would the 4-5Y fit her well?',
            ],
            [
                'name'    => 'Zain Ali',
                'email'   => 'zain.ali@example.com',
                'phone'   => '+92 321 9876543',
                'message' => 'Do you ship to Karachi? I placed an order yesterday but haven’t received confirmation yet.',
            ],
            [
                'name'    => 'Hira M.',
                'email'   => 'hira.m@example.com',
                'phone'   => '+92 333 4455667',
                'message' => 'Loved the packaging on my last order! Just wanted to say thank you and ask if you have gift wrapping available.',
            ],
            [
                'name'    => 'Ali Raza',
                'email'   => 'ali.raza@example.com',
                'phone'   => '+92 345 1122334',
                'message' => 'Please let me know the return policy for sale items. I bought the Printed Co-ord Set last week.',
            ],
            [
                'name'    => 'Sara N.',
                'email'   => 'sara.n@example.com',
                'phone'   => '+92 311 7788990',
                'message' => 'Can I change the delivery address on my order? It hasn’t shipped yet.',
            ],
            [
                'name'    => 'Hamza Ahmed',
                'email'   => 'hamza98.dev@gmail.com',
                'phone'   => '+92 300 5556677',
                'message' => 'Hey team, I’d love to know if you plan to launch a newborn collection soon.',
            ],
            [
                'name'    => 'Maryam T.',
                'email'   => 'maryam.t@example.com',
                'phone'   => '+92 322 9988776',
                'message' => 'Could you send me the fabric composition for the Knitted Cardigan?',
            ],
            [
                'name'    => 'Bilal Ahmed',
                'email'   => 'bilal.ahmed@example.com',
                'phone'   => '+92 336 2233445',
                'message' => 'Placing a bulk order for a school event — 15 pieces. Can you share wholesale pricing?',
            ],
            [
                'name'    => 'Noor Fatima',
                'email'   => 'noor.f@example.com',
                'phone'   => '+92 315 6677889',
                'message' => 'The zipper on my Corduroy Pants got stuck after the first wash. Can you help?',
            ],
            [
                'name'    => 'Hassan Khan',
                'email'   => 'hassan.k@example.com',
                'phone'   => '+92 302 4455661',
                'message' => 'I need to update my phone number on file. Please guide me.',
            ],
            [
                'name'    => 'Fatima Sheikh',
                'email'   => 'fatima.s@example.com',
                'phone'   => '+92 300 7778899',
                'message' => 'Just discovered your brand through Instagram — the designs are lovely! Do you have a physical store in Lahore?',
            ],
            [
                'name'    => 'Usman Javed',
                'email'   => 'usman.j@example.com',
                'phone'   => null,
                'message' => 'My order #12345 shows delivered but I haven’t received it. Can you please look into this?',
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}
