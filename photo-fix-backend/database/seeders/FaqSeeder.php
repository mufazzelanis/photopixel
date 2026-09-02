<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'How Should I Send My Images Or Videos That I Want To Edit?',
                'answer' => 'You can share your files through a direct download link — Google Drive, Dropbox, WeTransfer, or our upload servers. Just paste the link in the quote form and add any instructions.',
            ],
            [
                'question' => 'How Long Does It Take To Deliver The Edited Photos Or Videos?',
                'answer' => 'Standard turnaround is 12–24 hours for most image orders. Bulk projects and complex video edits are scheduled with an agreed deadline before we start.',
            ],
            [
                'question' => 'Is There Any Limit On The File Size Of Uploaded Images?',
                'answer' => 'No practical limit. For large batches we recommend a WeTransfer or Dropbox link so nothing is compressed and quality stays intact.',
            ],
            [
                'question' => 'Do You Offer Free Photo Or Video Editing Trials?',
                'answer' => 'Yes. You get up to 5 free trial images so you can review our quality before placing a paid order.',
            ],
            [
                'question' => 'Which Kind Of Customers Do You Serve?',
                'answer' => 'Photographers, photo studios & agencies, e-commerce businesses, marketing and digital agencies, and individual sellers worldwide.',
            ],
            [
                'question' => 'What Kind Of File Types Do You Accept?',
                'answer' => 'JPG, PNG, TIFF, PSD, RAW/CR2/NEF for images and MP4, MOV, AVI for video. Let us know if you need a specific output format.',
            ],
            [
                'question' => "What If I'm Not Satisfied With The Final Edit?",
                'answer' => 'We offer unlimited revisions until it matches your brief. If it still is not right, you are covered by our satisfaction guarantee.',
            ],
        ];

        foreach ($faqs as $i => $f) {
            Faq::updateOrCreate(
                ['group' => 'home', 'question' => $f['question']],
                ['answer' => $f['answer'], 'sort_order' => $i + 1, 'is_active' => true],
            );
        }
    }
}
