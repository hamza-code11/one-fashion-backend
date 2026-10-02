<?php
// database/seeders/FaqSeeder.php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        Faq::create([
            'eyebrow'     => 'Support',
            'heading'     => 'Frequently Asked Questions',
            'description' => 'Everything you need to know about shopping, sizing, delivery and returns.',

            'items' => [
                [
                    'question' => 'How do I find the right size for my child?',
                    'answer'   => 'Each product page lists the available sizes by age. For detailed measurements in centimetres, visit our Size Guide. If your child is between sizes, we recommend sizing up for a longer, more comfortable fit.',
                ],
                [
                    'question' => 'What is your delivery timeline?',
                    'answer'   => 'Orders are dispatched within 24–48 hours. Delivery across Pakistan usually takes 2–4 working days. Remote areas may take 1–2 additional days. You will receive tracking details once your order ships.',
                ],
                [
                    'question' => 'Do you offer Cash on Delivery?',
                    'answer'   => 'Yes. Cash on Delivery is available across Pakistan for orders up to PKR 50,000. For larger orders, please use card or bank transfer at checkout.',
                ],
                [
                    'question' => 'What is your return policy?',
                    'answer'   => 'We offer 7-day easy returns on unworn items with original tags attached. Simply start a return from your account or contact our support team — we will arrange the pickup.',
                ],
                [
                    'question' => 'How do I track my order?',
                    'answer'   => 'Once your order ships you will receive an SMS and email with a tracking link. You can also view live status anytime from the Orders section of your account.',
                ],
                [
                    'question' => 'Do you ship internationally?',
                    'answer'   => 'Currently we ship within Pakistan only. International shipping is on our roadmap — join our newsletter to be the first to know when we expand.',
                ],
                [
                    'question' => 'Are your fabrics safe for sensitive skin?',
                    'answer'   => 'Yes. We use cotton-rich, breathable fabrics with OEKO-TEX certified dyes, gentle on the most sensitive little skin. Every batch is tested for softness and safety.',
                ],
                [
                    'question' => 'How do I care for the garments?',
                    'answer'   => 'Machine wash cold with similar colours, tumble dry low or line dry in shade. Avoid bleach and harsh detergents. Full care instructions are printed on every garment label.',
                ],
            ],
        ]);
    }
}
